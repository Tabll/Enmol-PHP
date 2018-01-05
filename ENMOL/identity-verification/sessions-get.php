<?php
function getToken($phone){
    if(!isset($_SESSION)){
        require_once dirname(__FILE__).'/../../ENMOL/config/enmol-redis-config.php';
        ini_set("session.save_handler","redis");
        ini_set("session.save_path","tcp://".REDIS_HOST.":".REDIS_PORT);
        ini_set('session.gc_maxlifetime', 2592000); //设置时间
        session_id($phone);
        session_start();
    }
    if(isset($_SESSION['Token'])){
        return $_SESSION['Token'];
    }else{
        return "";
    }
}