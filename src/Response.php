<?php
declare(strict_types=1);

/**
 * Scrawler Request Object
 *
 * @package: Scrawler
 * @author: Pranjal Pandey
 */

namespace Scrawler\Http;

use Symfony\Component\HttpFoundation\RedirectResponse;


class Response extends \Symfony\Component\HttpFoundation\Response
{

    /**
     *  Redirect to url 
     */
    public function redirect($url): RedirectResponse
    {
        return new RedirectResponse($url);
    }

    /**
     *  Return json response
     */
    public function json($data,$headers=[]): Response
    {
        $this->setContent($data);
        $this->headers->set('Content-Type', 'application/json');
        foreach ($headers as $key => $value) {
            $this->headers->set($key, $value);
        }
        return $this;
    }

}