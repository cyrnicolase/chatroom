<?php namespace Chat\Model\Server;
/**
 * websocket 方式的聊天服务
 */
class WebSocketServer extends \Chat\Model\Server {

    protected $serv;

    public function __construct() {
        parent::__construct();
        $this->serv = new swoole_websocket_server(static::SERVER_HOST, static::SERVER_PORT);
    }

    public function initServer() {
        $this->serv->set([
            'task_worker_num' => 4,
        ]);
        $this->serv->on("open", array($this, "open"));
        $this->serv->on("message", array($this, "message"));
        $this->serv->on("task",    array($this, "task"));
        $this->serv->on("finish",  array($this, "finish"));
        $this->serv->on("close", array($this, "close"));
    }

    public function open() {
        echo "Connect {$fd} OK\n";
    }

    public function message($serv, $frame) {

    }

}
