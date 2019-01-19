<?php

namespace Database;

class MariadbConnector
{
    /**
     * @var \PDO
     */
    static private $connection;

    public function getConnection()
    {
        if (!isset(self::$connection)) {
            self::$connection = new \PDO('mysql:host=mariadb;dbname=guestbook', 'root', 'root');
        }
        return self::$connection;
    }
}