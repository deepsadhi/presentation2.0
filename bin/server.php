<?php

require __DIR__ . '/../vendor/autoload.php';

defined('APP_PATH') ? null : define('APP_PATH', dirname(dirname(__FILE__)));

use App\Websocket;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;


// Initialize Web Socket server
$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new Websocket()
        )
    ),
    8080
);

// Run Web Socket server
$server->run();
