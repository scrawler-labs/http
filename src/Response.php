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
 * Response class adds magic to the Symfony response.
 */
class Response extends \Symfony\Component\HttpFoundation\Response
{
    /**
     * Redirect to url.
     */
    public function redirect(string $url): RedirectResponse
    {
        return new RedirectResponse($url);
    }

    /**
     * Return json response.
     *
     * @param string|array<mixed> $data
     * @param array<mixed>        $headers
     */
    public function json(string|array $data, array $headers = []): Response
    {
        if (is_array($data)) {
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
