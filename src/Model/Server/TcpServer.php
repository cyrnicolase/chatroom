<?php namespace Chat\Model\Server;
/**
 * tcp 方式的聊天server 
 */
class TcpServer extends \Chat\Model\Server {

    protected $serv;

    public function __construct() {
        parent::__construct();
        $this->serv = new \swoole_server(static::SERVER_HOST, static::SERVER_PORT);
    }

    public function initServer() {
        $this->serv->set([
            'task_worker_num' => 4,
        ]);
        $this->serv->on("connect", array($this, "connect"));
        $this->serv->on("receive", array($this, "receive"));
        $this->serv->on("task",    array($this, "task"));
        $this->serv->on("finish",  array($this, "finish"));
        $this->serv->on("close",   array($this, "close"));
    }


    public function connect($serv, $fd, $from_id) {
        echo "Connect {$fd} OK!\n";
        $this->login($fd);
    }

    public function receive($serv, $fd, $from_id, $input) {
        /**
         * 解析收取到的数据可以使用单独对象来完成 new Message()->getParser()->parse();
         * 这里就创建一个局部的对象，针对每次请求结束后自动回收对象空间
         */
        // $data = (array)json_decode($input);
        // $cmd = $data['cmd'];
        $input = "{$fd} says: " . $input;
        $cmd = 'xxx';
        switch($cmd) {
            case "login":
                // user_id = $data['user_id']; 测试时，fd == user_id
                $this->login($fd);
                break;
            case "chat":
                $message = $data['message'];
                $serv->task($message);
                break;
            default:
                $serv->task($input);
                break;
        }
    }
}
