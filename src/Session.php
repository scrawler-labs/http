<?php
declare(strict_types=1);

/**
 * Scrawler Session Service
 *
 * @package: Scrawler
 * @author: Pranjal Pandey
 */

namespace Scrawler\Http;


class Session extends \Symfony\Component\HttpFoundation\Session\Session
{
    /**
     * Magic method to directly set session variable
     *
     */
    public function __set(string $key,string $value) : void
    {
        $this->set($key, $value);
    }
    
    /**
     * Magic method to directly get session data
     *
     */
    public function __get(string $key) : mixed
    {
        return $this->get($key);
    }
    
   
    /**
     * check if session has key
     *
     */
    public function has(string $key): bool
    {
        if (parent::has($key) || parent::getFlashBag()->has($key)) {
            return true;
        }
        return false;
    }
    

    /**
     * Invalidates the current session.
     *
     * Clears all session attributes and flashes and regenerates the
     * session and deletes the old session from persistence.
     *
     */
    public function stop() : void
    {
        $this->invalidate(0);
    }

    /**
     * Get/Set flash message
     *
     */
    public function flash(?string $type = null,?string $message = null): ?array
    {
        if (!is_null($message)) {
            $this->getFlashBag()->add($type, $message);
            return null;
        } else {
            if (!is_null($type)) {
                return $this->getFlashBag()->get($type);
            }
            return $this->getFlashBag()->all();
        }
    }
}