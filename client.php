<?php
$cli = new swoole_client(SWOOLE_SOCK_TCP, SWOOLE_SOCK_ASYNC);


$cli->on("connect", function($cli) {
    $cli->send("hello world\r\n");
});

$cli->on("receive", function($cli, $data) {
    echo "Received: " . $data . "\n";
});

$cli->on("error", function($cli) {
    echo "Connect Failed!\n";
});

$cli->on("close", function($cli) {
    echo "Connect Close\n";
});

$cli->connect("127.0.0.1", 9501);