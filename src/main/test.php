<?php

define("ABS_PATH", dirname(__FILE__));
include(ABS_PATH . '/FuseSource/Stomp/Stomp.php');
include(ABS_PATH . '/FuseSource/Stomp/Frame.php');
include(ABS_PATH . '/FuseSource/Stomp/ExceptionInterface.php');
include(ABS_PATH . '/FuseSource/Stomp/Exception/StompException.php');

use FuseSource\Stomp\Stomp;

function check_etp_amq($ip, $port, $queue_name) {
    try {
        $con = new Stomp("tcp://$ip:$port");
        $result = $con->connect();
        // При неудачной попытке соединения возникает исключительная ситуация или возвращается 0,
        // При успешном соединении $result==1
        if ($result != 1) return 0;
        $result = $con->send("/queue/$queue_name", "<?xml ... тело сообщения" . rand(1, 1000) . " ...?>", array(), true);
        // Последний параметр всегда true иначе невозможно понять дошло ли сообщение до очереди
        // При неудачной попытке отправки возникает исключительная ситуация или возвращается 0,
        //Закрытие соедниения с транспортным модулем ЕТП
        $con->disconnect();
        // При неудачной попытке отключения возникает исключительная ситуация возвращаемого значения не предусмотрено
        if ($result != 1) return 0;
        return 1;
    } catch (Exception $e) {
        echo("Exception: " . $e->getMessage());
        return 0;
    }
}

$res = check_etp_amq("46.36.216.166", 61613, "MONITORING");

if ($res == 1) echo "Working";
else echo "Not Working";




