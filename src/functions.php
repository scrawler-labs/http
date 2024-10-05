<?php

if (!function_exists('request')) {
    /**
     * Get the request object
     *
     * @return \Scrawler\Http\Request
     */
    function request(): \Scrawler\Http\Request
    {
        // @codeCoverageIgnoreStart
        if (class_exists('\Scrawler\App')) {
            if (!\Scrawler\App::engine()->has('request')) {
                $request = \Scrawler\Http\Request::createFromGlobals();
                \Scrawler\App::engine()->register('request', $request);
            }
            return \Scrawler\App::engine()->request();
        }
        // @codeCoverageIgnoreEnd

        return \Scrawler\Http\Request::createFromGlobals();
    }
}

if (!function_exists('response')) {
    /**
     * Get the response object
     *
     * @return \Scrawler\Http\Response
     */
    function response(): \Scrawler\Http\Response
    {
        // @codeCoverageIgnoreStart
        if (class_exists('\Scrawler\App')) {
            if (!\Scrawler\App::engine()->has('response')) {
                $response = new \Scrawler\Http\Response();
                \Scrawler\App::engine()->register('response', $response);
            }
            return \Scrawler\App::engine()->response();
        }
        // @codeCoverageIgnoreEnd

        return new \Scrawler\Http\Response();
    }
}

if (!function_exists('session')) {
    /**
     * Get the session object
     *
     * @param Symfony\Component\HttpFoundation\Session\Storage\SessionStorageInterface|null $storage
     * @return \Scrawler\Http\Session
     */
    function session(Symfony\Component\HttpFoundation\Session\Storage\SessionStorageInterface|null $storage = null): \Scrawler\Http\Session
    {
        // @codeCoverageIgnoreStart
        if (class_exists('\Scrawler\App')) {
            if (!\Scrawler\App::engine()->has('session')) {
                $response = new \Scrawler\Http\Session($storage);
                \Scrawler\App::engine()->register('session', $response);
            }
            return \Scrawler\App::engine()->session();
        }
        // @codeCoverageIgnoreEnd

        return new \Scrawler\Http\Session();
    }

}

if (! function_exists('redirect')) {
    /**
     * Redirect to a new url
     * Optionally send data to add to flashbag
     *
     * @param string $url
     * @param array<mixed> $data
     * @return Symfony\Component\HttpFoundation\RedirectResponse
     */
    function redirect(string $url, array $data=[])
    {
        if (!empty($data)) {
            foreach ($data as $key=>$value) {
                session()->flash($key, $value);
            }
        }
        return response()->redirect($url);

    }
}
