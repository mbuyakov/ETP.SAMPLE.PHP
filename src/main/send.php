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

// отправка сообщения
for($i=0;$i<10000;$i++) {
$result = $con->send("/queue/TEST_STOMP", "<?xml ... тело сообщения".rand(1,1000)." ...?>", array(), true);
echo ("send result: $result\n" );
}
// Последний параметр всегда true иначе невозможно понять дошло ли сообщение до очереди
// При неудачной попытке отправки возникает исключительная ситуация или возвращается 0,
// При успешной отправке $result==1 (если $result==1, можно помечать сообщение как "доставленное")

//Закрытие соедниения с транспортным модулем ЕТП
$con->disconnect();
echo ("disconnected\n" );
// При неудачной попытке отключения возникает исключительная ситуация возвращаемого значения не предусмотрено