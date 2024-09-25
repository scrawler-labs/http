<?php

if (!function_exists('request')) {
    function request(): \Scrawler\Http\Request
    {
        if (class_exists('\Scrawler\App')) {
            if (!\Scrawler\App::engine()->has('request')) {
                $request = \Scrawler\Http\Request::createFromGlobals();
                \Scrawler\App::engine()->set('request', $request);
            }
            return \Scrawler\App::engine()->request();
        }

        return \Scrawler\Http\Request::createFromGlobals();
    }
}

if (!function_exists('response')) {
    function response(): \Scrawler\Http\Response
    {
        if (class_exists('\Scrawler\App')) {
            if (!\Scrawler\App::engine()->has('response')) {
                $response = new \Scrawler\Http\Response();
                \Scrawler\App::engine()->set('response', $response);
            }
            return \Scrawler\App::engine()->response();
        }

        return new \Scrawler\Http\Response();
    }
}

if (!function_exists('session')) {
    function session($handler = null): \Scrawler\Http\Session
    {
        if (class_exists('\Scrawler\App')) {
            if (!\Scrawler\App::engine()->has('session')) {
                $response = new \Scrawler\Http\Session($handler);
                \Scrawler\App::engine()->set('session', $response);
            }
            return \Scrawler\App::engine()->session();
        }

        return new \Scrawler\Http\Session();
    }

}