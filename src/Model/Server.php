<?php namespace Chat\Model;

use \Chat\Model\Room;
use \Chat\Model\Session;

/**
 * 服务端抽象类
 * 用来支持多个服务方式
 */
abstract class Server {

    const SERVER_HOST = "0.0.0.0";
    const SERVER_PORT = 9501;

    protected $serv;
    protected $room;
    protected $session;

    abstract public function initServer();

    public function __construct() {
        $this->room = new Room(ROOM_ID);
        $this->session = new Session();
    }

    public function start() {
        $this->serv->start();
    }

    /**
     * Map userid and fd once user login
     */
    public function login($fd) {
        $user_id = $fd;
        $this->room->addUser($user_id);
        $this->session->mapUserAndFd($user_id, $fd);
    }

    public function logout($fd) {
        $user_id = $this->session->getUserByFd($fd);
        if ($this->session->isExistsUserFd($user_id, $fd)) {
            $this->session->deleteUser($user_id);
            $this->room->deleteUser($user_id);
        }
        $this->session->deleteFd($fd);
    }

    public function task($serv, $task_id, $from_id, $data) {
        $target_user_ids = $this->room->getAllusers();
        foreach ($target_user_ids as $user_id) {
            $fd = $this->session->getFdByUserId($user_id);
            $serv->send($fd, $data);
        }
        $serv->finish("message has sended done!\n");
    }

    public function finish($serv, $task_id, $data) {
        // echo trim($data) . "\n";
    }

    public function close($serv, $fd, $from_id) {
        $this->logout($fd);
        echo "Close {$fd} Done!\n";
    }

}
