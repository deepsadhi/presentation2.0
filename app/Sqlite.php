<?php

namespace App;

use \PDO;


class Sqlite
{
    /**
     * Store POD object
     *
     * @var object
     */
    protected static $db;

    /**
     * Protect from cloning
     */
    protected function __clone() {}

    /**
     * Protect from wakeup
     */
    protected function __wakeup() {}

    /**
     * Create Sqlite connection
     */
    protected function __construct(){
        try
        {
            $settings = require __DIR__ . '/../config/app.php';
            $file     = __DIR__ . '/../config/' .
                        $settings['settings']['sqlite']['filename'];

            self::$db = new PDO('sqlite:' . $file);
            self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch(PDOException $e)
        {
        }
    }

    /**
     * Checks for a DB object and creates one if it's not created
     *
     * @return object PDO object
     */
     public static function getConnection(){
        if (!self::$db)
        {
            new self();
        }

        return self::$db;
    }
}
