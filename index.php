<?php
// require_once "./src/Model/Room.php";
// require_once "./src/Model/Server.php";
// require_once "./src/Model/ServerFactory.php";
// require_once "./src/Model/Session.php";
// require_once "./src/Model/Server/TcpServer.php";

const ROOT_DIR = __DIR__;
require_once ROOT_DIR . "/vendor/autoload.php";

const ROOM_ID = 'room_id';
$app_type = "tcp";
$serv = \Chat\Model\ServerFactory::factory($app_type);
$serv->initServer();
$serv->start();

