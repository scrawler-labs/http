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
 * Session class adds magic to the Symfony session.
 */
class Session extends \Symfony\Component\HttpFoundation\Session\Session
{
    /**
     * Magic method to directly set session variable.
     */
    public function __set(string $key, string $value): void
    {
        $this->set($key, $value);
    }

    /**
     * Magic method to directly get session data.
     */
    public function __get(string $key): mixed
    {
        return $this->get($key);
    }

    /**
     * check if session or flashbag has key.
     */
    #[\Override]
    public function has(string $key): bool
    {
        return parent::has($key) || parent::getFlashBag()->has($key);
    }

    /**
     * Invalidates the current session.
     *
     * Clears all session attributes and flashes and regenerates the
     * session and deletes the old session from persistence.
     */
    public function stop(): void
    {
        $this->invalidate(0);
    }

    /**
     * Get/Set flash message
     * If message and type is provided then set the flash message
     * If only type is provided then return all messages of that type.
     *
     * @return array<mixed>|null
     */
    public function flash(?string $type = null, ?string $message = null): ?array
    {
        if (!is_null($message) && !is_null($type)) {
            $this->getFlashBag()->add($type, $message);

            return null;
        } else {
            if (!is_null($type)) {
                return $this->getFlashBag()->get($type);
            }

            return $this->getFlashBag()->all();
        }
    }
}
