<?php

/**
 * Copyright © 2019 Ahmed Kooli. metro-guestbook challenge.
 */

declare(strict_types=1);

namespace Database;

class MariadbConnector
{
    /**
     * @var \PDO
     */
    static private $connection;

    public function getConnection(): \PDO
    {
        if (!isset(self::$connection)) {
            self::$connection = new \PDO('mysql:host=mariadb;dbname=guestbook', 'root', 'root');
            self::$connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }
        return self::$connection;
    }
}