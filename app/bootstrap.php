<?php

error_reporting(E_ALL | E_STRICT);

require __DIR__ . '/../vendor/autoload.php';

use Slim\App;

// Start session
session_cache_limiter(false);
session_start();

// Initialize the app
$settings = require __DIR__ . '/../config/app.php';
$app = new App($settings);

// Set up dependencies
require __DIR__ . '/../app/dependencies.php';

// Register routes
require __DIR__ . '/../app/routes.php';

// Return app
return $app;
