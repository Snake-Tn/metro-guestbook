<?php

/**
 * Copyright © 2019 Ahmed Kooli. metro-guestbook challenge.
 */

declare(strict_types=1);

namespace Database;

class RedisConnector
{
    /**
     * @var \Redis
     */
    static private $connection;

    public function getConnection(): \Redis
    {
        if (!isset(self::$connection)) {
            $redis = new \Redis();
            $redis->connect('redis');
            self::$connection = $redis;
        }
        return self::$connection;
    }
}