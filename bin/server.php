<?php
require '../vendor/autoload.php';
defined('APP_PATH') ? null : define('APP_PATH', dirname(dirname(__FILE__)));


use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use App\Websocket;

$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new Websocket()
        )
    ),
    8080
);

$server->run();