<?php
function newSession($phone){
    require_once dirname(__FILE__).'/../../ENMOL/config/enmol-redis-config.php';
    ini_set("session.save_handler","redis");
    ini_set("session.save_path","tcp://".REDIS_HOST.":".REDIS_PORT);
    ini_set('session.gc_maxlifetime', 2592000); //设置时间
    session_id($phone);
    session_start();
    $newToken = md5($phone.time());
    $_SESSION['Token'] = $newToken;
}