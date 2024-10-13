<?php
/*
 * This file is part of the Scrawler package.
 *
 * (c) Pranjal Pandey <its.pranjalpandey@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Scrawler\Http;

/**
 * Request class adds magic to the Symfony request.
 */
class Request extends \Symfony\Component\HttpFoundation\Request
{
    /**
     * Method to get varaiable sent with request
     * First checks in $request->request then in $request->query and then in $request->getContent().
     */
    #[\Override]
    public function get(string $key, mixed $default = null): ?string
    {
        $value = $this->request->get($key);
        if (is_null($value)) {
            $value = $this->query->get($key);
        }
        if (is_null($value)) {
            $value = $this->getContentValue($key);
        }
        if (is_null($value) || '' == $value) {
            return $default;
        }

        return $value;
    }

    /**
     * Get value from $request->getContent().
     *
     * @return mixed|null
     */
    private function getContentValue(string $key): mixed
    {
        if ($this->getContent() && \Safe\json_decode($this->getContent()) && isset(\Safe\json_decode($this->getContent())->$key)) {
            return \Safe\json_decode($this->getContent())->$key;
        }

        return null;
    }

    /**
     * Magic method to get property of request.
     */
    public function __get(string $key): ?string
    {
        return $this->get($key);
    }

    /**
     * Get all property of request
     * returns array of all from $request->request, $request->query and $request->getContent().
     *
     * @return array<string,mixed>
     */
    public function all(): array
    {
        if ($this->getContent() && \Safe\json_decode($this->getContent())) {
            return array_merge($this->request->all(), $this->query->all(), \Safe\json_decode($this->getContent(), true));
        }

        return array_merge($this->request->all(), $this->query->all());
    }

    /**
     * Check id request has key in $request->request, $request->query and $request->getContent().
     */
    public function has(string $key): bool
    {
        if ($this->getContent() && \Safe\json_decode($this->getContent()) && isset(\Safe\json_decode($this->getContent())->$key)) {
            return true;
        }

        return $this->request->has($key) || $this->query->has($key);
    }

    /**
     * Get request url or generate url from path.
     */
    public function url(?string $path = null): string
    {
        if (is_null($path)) {
            return $this->getSchemeAndHttpHost().$this->getBaseUrl().$this->getPathInfo();
        }

        return $this->getSchemeAndHttpHost().$this->getBasePath().$path;
    }

    /**
     * Check if current path is same as given path.
     */
    public function is(string $path): bool
    {
        return $this->getPathInfo() === $path;
    }
}
