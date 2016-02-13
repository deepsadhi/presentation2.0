<?php

namespace App;

use \PDO;
use \RuntimeException;
use \PDOException;

class Sqllite
{
    /**
     * Store POD object
     *
     * @var object
     */
    private static $_db;

    /**
     * Protect from cloning
     */
    private function __clone() {}

    /**
     * Protect from wakeup
     */
    private function __wakeup() {}

    /**
     * Create Sqlite connection
     */
    private function __construct(){
        try
        {
            self::$_db = new PDO('sqlite:'.SQLITE_FILE);
        }

        catch(PDOException $e)
        {
            throw new RuntimeException($e->getMessage(), 100);
        }
    }


    /**
     * Checks for a DB object and creates one if it's not created
     *
     * @return object PDO object
     */
     public static function getConnection(){
        if (!self::$_db)
        {
            new self();
        }

        return self::$_db;
    }
}
