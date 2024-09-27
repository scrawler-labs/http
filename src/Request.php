<?php
declare(strict_types=1);

/**
 * Scrawler Request Object
 *
 * @package: Scrawler
 * @author: Pranjal Pandey
 */

namespace Scrawler\Http;


class Request extends \Symfony\Component\HttpFoundation\Request
{

    /**
     * Method to directly get request variable
     */
    public function get(string $key,mixed $default = null): string
    {
        $value = $this->request->get($key,);
        if (is_null($value)) {
            $value = $this->query->get($key);
        }
        if (is_null($value) && json_decode($this->getContent())) {
            $value = json_decode($this->getContent())->$key;
        }
        if($value == ''){
            return $default;
        }
        return $value;
    }


    public function __get($key)
    {
        return $this->get($key);
    }

    /**
     * Get all property of request
     *
     */
    public function all() : array
    {
        if ($this->getContent() && json_decode($this->getContent()))
            return array_merge($this->request->all(), $this->query->all(), json_decode($this->getContent(), true));

        return array_merge($this->request->all(), $this->query->all());

    }

    /**
     * Check id requst has key 
     *
     * @return boolean
     */
    public function has(string $key) : bool
    {
        if ($this->getContent() && json_decode($this->getContent())) {
            if (isset(json_decode($this->getContent())->$key))
                return true;
        }
        if ($this->request->has($key) || $this->query->has($key)) {
            return true;
        }
        return false;
    }

    /**
     * Get request url or generate url from path
     */
    public function url(string $path) : string
    {
        if (isset($path)) {
            return $this->getSchemeAndHttpHost() . $this->getBasePath() . $path;
        } else {
            return $this->getSchemeAndHttpHost() . $this->getBasePath();
        }
    }
}
