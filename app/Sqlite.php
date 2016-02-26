<?php

namespace App;

use \PDO;
use \RuntimeException;
use \PDOException;

class Sqlite
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
            $settings = require __DIR__ . '/../config/app.php';
            $file     = __DIR__ . '/../config/' .
                        $settings['settings']['sqlite']['filename'];

            self::$_db = new PDO('sqlite:' . $file);
            self::$_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        catch(\PDOException $e)
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
