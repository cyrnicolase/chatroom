<?php namespace Chat\Model;
/**
 * 会话
 */
class Session {

    const SWOOLE_TABLE_SIZE = 1048576;
    protected $swoole_table;

    public function __construct() {
        $this->swoole_table = $this->initSwooleTable();
    }

    /**
     * 映射用户id和fd
     * @param  int $user_id 用户id
     * @param  int $fd      客户端
     * @return void          
     */
    public function mapUserAndFd($user_id, $fd) {
        $swoole_table = $this->swoole_table;
        $usr_to_fd = ['value' => $fd];
        $fd_to_usr = ['value' => $user_id];

        $swoole_table->set($this->getUserToFdKey($user_id), $usr_to_fd);
        $swoole_table->set($this->getFdToUserKey($fd), $fd_to_usr);
    }

    public function getFdByUserId($user_id) {
        $swoole_table = $this->swoole_table;
        return $swoole_table->get($this->getUserToFdKey($user_id))['value'];
    }

    public function getUserByFd($fd) {
        $swoole_table = $this->swoole_table;
        return $swoole_table->get($this->getFdToUserKey($fd))['value'];
    }


    /**
     * 通过user_id 判断给定fd 是否真正存在
     * @param  [type]  $user_id [description]
     * @param  [type]  $fd      [description]
     * @return boolean          [description]
     */
    public function isExistsUserFd($user_id, $fd) {
        $user_fd = $this->getFdByUserId($user_id);
        if ($user_fd && $user_fd == $fd) {
            return true;
        }
        return false;
    }


    public function deleteUser($user_id) {
        $swoole_table = $this->swoole_table;
        $swoole_table->del($this->getUserToFdKey($user_id));
    }


    public function deleteFd($fd) {
        $swoole_table = $this->swoole_table;
        $swoole_table->del($this->getFdToUserKey($fd));
    }

    private function getUserToFdKey($user_id) {
        return "usr_to_fd" . $user_id;
    }

    private function getFdToUserKey($fd) {
        return "fd_to_usr" . $fd;
    }

    private function initSwooleTable() {
        $swoole_table = new \swoole_table(static::SWOOLE_TABLE_SIZE);
        $swoole_table->column("value", \swoole_table::TYPE_INT, 4);
        $swoole_table->create();
        return $swoole_table;
    }

}
