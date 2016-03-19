<?php
if (PHP_SAPI == 'cli-server') {
    // To help the built-in PHP dev server, check if the request was actually for
    // something which should probably be served as a static file
    $file = __DIR__ . $_SERVER['REQUEST_URI'];
    if (is_file($file))
    {
    	if (file_exists($file))
    	{
            die($file);
        	return false;
        }
    }
}


// Store public path
define('PUBLIC_PATH', getcwd());

// Initialize app
$app = require __DIR__ . '/../app/bootstrap.php';

// Run app
$app->run();
