<?php namespace Chat\Model;
/**
 * 聊天房间,用户管理
 */
class Room {

    protected $room_id;
    protected $redis;

    public function __construct($room_id) {
        $this->room_id = $room_id;
        $this->_initCache();
    }

    /**
     * 使用redis 的集合来存储用户
     * @return void
     */
    private function _initCache() {
        $this->redis = new \Redis();
        $this->redis->connect("127.0.0.1", 6379);
    }

    public function addUser($user_id) {
        $this->redis->sadd($this->room_id, $user_id);
    }

    public function deleteUser($user_id) {
        $this->redis->srem($this->room_id, $user_id);
    }

    public function getAllUsers() {
        return $this->redis->smembers($this->room_id) ?: [];
    }

}
