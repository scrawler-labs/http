<?php
/*
 * This file is part of the Scrawler package.
 *
 * (c) Pranjal Pandey <its.pranjalpandey@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Scrawler\Http\Adapters\Session;

use Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;

/**
 * DatabaseAdapter class to store session using Arca Orm.
 */
class DatabaseAdapter extends NativeSessionStorage
{
    public function __construct()
    {
        parent::__construct([], new DatabaseHandler());
    }
}
