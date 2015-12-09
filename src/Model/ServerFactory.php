<?php namespace Chat\Model;

use \Chat\Model\Server\WebSocketServer;
use \Chat\Model\Server\TcpServer;

class ServerFactory {

    static public function factory($app_type) {
        $app_type = strtolower($app_type);
        if ($app_type == "websocket") {
            return new WebSocketServer();
        } elseif ($app_type == "tcp") {
            return new TcpServer();
        } else {
            throw new Exception("协议不正确");
        }
    }
}
