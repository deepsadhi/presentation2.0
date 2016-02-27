<?php

error_reporting(E_ALL | E_STRICT);

require __DIR__ . '/../vendor/autoload.php';

use Slim\App;

session_cache_limiter(false);
session_start();

// Instantiate the app
$settings = require __DIR__ . '/../config/app.php';
$app = new App($settings);

// Set up dependencies
require __DIR__ . '/../app/dependencies.php';

// Register middleware
require __DIR__ . '/../app/middleware.php';

// Register routes
require __DIR__ . '/../app/routes.php';


return $app;
