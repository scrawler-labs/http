<?php
declare(strict_types=1);

/**
 * Scrawler Request
 *
 * @package: Scrawler
 * @author: Pranjal Pandey
 */

namespace Scrawler\Http;

class Request extends \Symfony\Component\HttpFoundation\Request
{

    /**
     * Method to get varaiable sent with request
     * First checks in $request->request then in $request->query and then in $request->getContent()
     * @param string $key
     * @param mixed $default
     * @return string|null
     */
    public function get(string $key,mixed $default = null): string|null
    {
        $value = $this->request->get($key);
        if (is_null($value)) {
            $value = $this->query->get($key);
        }
        if (is_null($value)) {
            $value = $this->getContentValue($key);
        }
        if(is_null($value) || $value == ''){
            return $default;
        }
        return $value;
    }

    /**
     * Get value from $request->getContent()
     * @param string $key
     * @return mixed|null
     */
    private function getContentValue($key): mixed{
        if ($this->getContent() && \Safe\json_decode($this->getContent())) {
            if (isset(\Safe\json_decode($this->getContent())->$key))
                return \Safe\json_decode($this->getContent())->$key;
        }
        return null;
    }


    /**
     * Magic method to get property of request
     * @param string $key
     */
    public function __get(string $key): string|null
    {
        return $this->get($key);
    }

    /**
     * Get all property of request
     * returns array of all from $request->request, $request->query and $request->getContent()
     * @return array<string,mixed>
     */
    public function all() : array
    {
        if ($this->getContent() && \Safe\json_decode($this->getContent()))
            return array_merge($this->request->all(), $this->query->all(), \Safe\json_decode($this->getContent(), true));

        return array_merge($this->request->all(), $this->query->all());

    }

    /**
     * Check id request has key in $request->request, $request->query and $request->getContent()
     *
     * @return boolean
     */
    public function has(string $key) : bool
    {
        if ($this->getContent() && \Safe\json_decode($this->getContent())) {
            if (isset(\Safe\json_decode($this->getContent())->$key))
                return true;
        }
        if ($this->request->has($key) || $this->query->has($key)) {
            return true;
        }
        return false;
    }

    /**
     * Get request url or generate url from path
     * @param string $path
     * @return string
     */
    public function url(string $path = null) : string
    {
        if (is_null($path)) {
            return $this->getSchemeAndHttpHost().$this->getBaseUrl().$this->getPathInfo();
        }
        return $this->getSchemeAndHttpHost().$this->getBasePath().$path;
    }

    /**
     * Check if current path is same as given path
     * @param string $path
     * @return bool
     */
    public function is(string $path):bool{
        return $this->getPathInfo() == $path;
    }
}
