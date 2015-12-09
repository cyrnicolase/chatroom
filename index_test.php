<?php
const WORK_NUM = 250;

for ($i = 0; $i < WORK_NUM; $i++) {
    $process = new swoole_process(function($worker) {
         $worker->exec("/usr/bin/php", array("/mnt/hgfs/work/swoole/swoole_task/chat_room/client.php"));
    });

    $process->start();
}


for ($i = 0; $i < WORK_NUM; $i++) {
    swoole_process::wait(); // 回收结束运行的子进程
}