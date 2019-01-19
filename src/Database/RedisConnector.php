<?php
/**
 * Created by PhpStorm.
 * User: a.kooli
 * Date: 19.01.19
 * Time: 17:48
 */

namespace Database;


class RedisConnector
{
    /**
     * @var \Redis
     */
    static private $connection;

    public function getConnection()
    {
        if (!isset(self::$connection)) {
            $redis = new \Redis();
            $redis->connect('redis');
            self::$connection = $redis;
        }
        return self::$connection;
    }
}