<?php
declare(strict_types=1);

/**
 * Scrawler Request Object
 *
 * @package: Scrawler
 * @author: Pranjal Pandey
 */

namespace Scrawler\Http;



class Response extends \Symfony\Component\HttpFoundation\Response
{

    /**
     * Redirect to url 
     * @param string $url
     * @return RedirectResponse
     */
    public function redirect(string $url): RedirectResponse
    {
        return new RedirectResponse($url);
    }

    /**
     * Return json response
     * @param string|array<mixed> $data
     * @param array<mixed> $headers
     * @return Response
     */
    public function json(string|array $data,array $headers=[]): Response
    {
        if(is_array($data)){
            $data = \Safe\json_encode($data);
        }
        $this->setContent($data);
        $this->headers->set('Content-Type', 'application/json');
        foreach ($headers as $key => $value) {
            $this->headers->set($key, $value);
        }
        return $this;
    }

}