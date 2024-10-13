<?php
/*
 * This file is part of the Scrawler package.
 *
 * (c) Pranjal Pandey <its.pranjalpandey@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

if (!function_exists('request')) {
    /**
     * Get the request object.
     */
    function request(): Scrawler\Http\Request
    {
        // @codeCoverageIgnoreStart
        if (class_exists('\Scrawler\App')) {
            if (!Scrawler\App::engine()->has('request')) {
                $request = Scrawler\Http\Request::createFromGlobals();
                Scrawler\App::engine()->register('request', $request);
            }

            return Scrawler\App::engine()->request();
        }
        // @codeCoverageIgnoreEnd

        return Scrawler\Http\Request::createFromGlobals();
    }
}

if (!function_exists('response')) {
    /**
     * Get the response object.
     */
    function response(): Scrawler\Http\Response
    {
        // @codeCoverageIgnoreStart
        if (class_exists('\Scrawler\App')) {
            if (!Scrawler\App::engine()->has('response')) {
                $response = new Scrawler\Http\Response();
                Scrawler\App::engine()->register('response', $response);
            }

            return Scrawler\App::engine()->response();
        }
        // @codeCoverageIgnoreEnd

        return new Scrawler\Http\Response();
    }
}

if (!function_exists('session')) {
    /**
     * Get the session object.
     */
    function session(?Symfony\Component\HttpFoundation\Session\Storage\SessionStorageInterface $storage = null): Scrawler\Http\Session
    {
        // @codeCoverageIgnoreStart
        if (class_exists('\Scrawler\App')) {
            if (!Scrawler\App::engine()->has('session')) {
                $response = new Scrawler\Http\Session($storage);
                Scrawler\App::engine()->register('session', $response);
            }

            return Scrawler\App::engine()->session();
        }
        // @codeCoverageIgnoreEnd

        return new Scrawler\Http\Session();
    }
}

if (!function_exists('redirect')) {
    /**
     * Redirect to a new url
     * Optionally send data to add to flashbag.
     *
     * @param array<mixed> $data
     *
     */
    function redirect(string $url, array $data = []): Scrawler\Http\RedirectResponse
    {
        foreach ($data as $key => $value) {
            session()->flash($key, $value);
        }

        return response()->redirect($url);
    }
}
