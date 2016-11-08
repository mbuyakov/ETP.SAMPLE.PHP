<?php

define("ABS_PATH", dirname(__FILE__));
include(ABS_PATH . '/FuseSource/Stomp/Stomp.php');
include(ABS_PATH . '/FuseSource/Stomp/Frame.php');
include(ABS_PATH . '/FuseSource/Stomp/ExceptionInterface.php');
include(ABS_PATH . '/FuseSource/Stomp/Exception/StompException.php');

use FuseSource\Stomp\Stomp;

// соединение
$con = new Stomp("tcp://etp.sm-soft.ru:61613");
$result = $con->connect();
echo("connect result: $result\n");
// При неудачной попытке соединения возникает исключительная ситуация или возвращается 0,
// При успешном соединении $result==1

$con->subscribe("/queue/TEST_STOMP", array('ack' => 'client'), true);
echo "subscribed";
// receive a message from the queue
// try to send some messages

for ($i = 0; $i < 10; $i++) {
    echo ($i);
    $msg = $con->readFrame();
// do what you want with the message
    if ($msg != null) {
        echo "Received message with body '$msg->body'\n";
        // mark the message as received in the queue
        $con->ack($msg);
    } else {
        echo "Failed to receive a message\n";
    }
    echo('finish');
}

$con->unsubscribe("/queue/TEST_STOMP", array(), true);

//Закрытие соедниения с транспортным модулем ЕТП
//$con->disconnect();
//echo ("disconnected\n" );
// При неудачной попытке отключения возникает исключительная ситуация возвращаемого значения не предусмотрено