<?php
/**
 * Scrawler Database Handlerfor symfony NativeSessionStorage
 *
 * @package: Scrawler
 * @author: Pranjal Pandey
 */
namespace Scrawler\Http\Adapters\Session;

use Symfony\Component\HttpFoundation\Session\Storage\Handler\AbstractSessionHandler;


class DatabaseHandler extends AbstractSessionHandler implements \SessionHandlerInterface
{
    /**
     * Store Database instance
     *
     * @var \Scrawler\Arca\Database
     */
    private $db;

    /**
     * Check if gc is called
     *
     * @var boolean
     */
    private $gcCalled = false;


    public function __construct()
    {
        //@codeCoverageIgnoreStart
        if(function_exists('db')){
            $this->db = db();
        }else{
            throw new \Exception("This adapter requires scrawler\database");
        }
        //@codeCoverageIgnoreEnd
    }

    protected function doWrite(string $sessionId, string $data): bool
    {
        $maxlifetime = (int) \Safe\ini_get('session.gc_maxlifetime');
        if ($this->db->tableExists('session') == false) {
            $session = $this->db->create('session');
        } else {
            $session = $this->db->find('session')->where('sessionid  LIKE ?')->setParameter(0, $sessionId)->first();
            if (is_null($session)) {
                $session = $this->db->create('session');
            }
        }

        $session->set('sessionid', $sessionId);
        $session->set('session_data', $data);
        $session->set('session_expire', time() + $maxlifetime);
        $this->db->save($session);
        return true;
    }

    protected function doRead(string $sessionId): string
    {
        $session = $this->db->find('session')->where('sessionid = ? AND session_expire > ?')->setParameters([$sessionId, time()])->first();
        if (is_null($session)) {
            return '';
        }
        return $session->get('session_data');
    }

    protected function doDestroy(string $sessionId): bool
    {
        $session = $this->db->find('session')
            ->where('sessionid  LIKE ?')
            ->setParameter(0, $sessionId)
            ->first();
        if (!is_null($session))
            $this->db->delete($session);
        return true;
    }

    public function updateTimestamp(string $sessionId, string $data): bool
    {
        $expiry =  (int) \Safe\ini_get('session.gc_maxlifetime');
        $session = $this->db->find('session')
        ->where('sessionid  LIKE ?')
        ->setParameter(0, $sessionId)
        ->first();

        if (!is_null($session)){
            $session->set('session_expire', time() + $expiry);
            $this->db->save($session);
        }
          
        return true;
    }

    public function gc(int $maxlifetime): int|false
    {
        $this->gcCalled = true;
        return 0;
    }

    // @codeCoverageIgnoreStart
    public function close(): bool
    {
        if ($this->gcCalled) {
            $this->gcCalled = false;

            $sessions = $this->db->find('session')
                ->where('session_expire < ?')
                ->setParameter(0, time())
                ->get();
                
                foreach ($sessions as $session) {
                    $session->delete();
                }
        }
        return true;
    }
    // @codeCoverageIgnoreEnd
}