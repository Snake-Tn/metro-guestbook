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
            self::$connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }
        return self::$connection;
    }
}