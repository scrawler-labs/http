<?php
/*
 * This file is part of the Scrawler package.
 *
 * (c) Pranjal Pandey <its.pranjalpandey@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

 if (!function_exists('response')) {
    /**
     * Get the response object.
     */
    function response(): Scrawler\Http\Response
    {
        
        return new Scrawler\Http\Response();
    }
}

if (!function_exists('request')) {
    /**
     * Get the response object.
     */
    function request(): Scrawler\Http\Request
    {
        if (class_exists('\Scrawler\App')) {
            return Scrawler\App::engine()->request();
        }    
        return  Scrawler\Http\Request::createFromGlobals();
    }
}


if (!function_exists('response')) {
    /**
     * Get the response object.
     */
    function response(): Scrawler\Http\Response
    {
        if (class_exists('\Scrawler\App')) {
            return Scrawler\App::engine()->response();
        }    
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
