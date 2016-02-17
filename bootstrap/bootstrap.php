<?php

error_reporting(E_ALL | E_STRICT);

defined('APP_PATH') ? null : define('APP_PATH', dirname(dirname(__FILE__)));
defined('APP_ROOT') ? null : define('APP_ROOT', dirname(dirname(__FILE__)));


require_once APP_PATH.'/vendor/autoload.php';
require_once APP_PATH.'/bootstrap/define.php';

use App\Session;
use App\File;
use App\Sqlite;

$s = new Session;

$db = Sqlite::getConnection();

$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

