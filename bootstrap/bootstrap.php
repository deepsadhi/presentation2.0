<?php

defined('APP_PATH') ? null : define('APP_PATH', dirname(dirname(__FILE__)));

require_once APP_PATH.'/vendor/autoload.php';

use App\Session;
use App\File;

$s = new Session;

