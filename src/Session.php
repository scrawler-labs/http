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
     * @param string $key
     * @param string $value
     */
    public function __set(string $key,string $value) : void
    {
        $this->set($key, $value);
    }
    
    /**
     * Magic method to directly get session data
     * @param string $key
     * @return mixed
     */
    public function __get(string $key) : mixed
    {
        return $this->get($key);
    }
    
   
    /**
     * check if session or flashbag has key
     * @param string $key
     * @return bool
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
     * If message and type is provided then set the flash message
     * If only type is provided then return all messages of that type
     * @param string|null $type
     * @param string|null $message
     * @return array<mixed>|null
     */
    public function flash(?string $type = null,string|null $message = null): ?array
    {
        if (!is_null($message) && !is_null($type)) {
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