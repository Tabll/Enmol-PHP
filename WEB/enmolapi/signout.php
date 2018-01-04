<?php
require dirname(__FILE__).'/../../ENMOL/tools/GetHeaders.php';
$headers = GetTheHeaders();
if(empty($headers['key']) || $headers['key'] != "QFE1WEG3ER448984WEF7W4849WEF") {
    exit();
}

$State = isset($_POST['sign-out-state']) ? $_POST['sign-out-state'] : "";
$PhoneNumber = isset($_POST['user-phone-number']) ? $_POST['user-phone-number'] : "";
//$VerifyCode = isset($_POST['user-verify-code']) ? $_POST['user-verify-code'] : "";
$Token = isset($_POST['token']) ? $_POST['token'] : "";
$Password = isset($_POST['user-password']) ? $_POST['user-password'] : "";

ini_set("session.save_handler","redis");
ini_set("session.save_path","tcp://".REDIS_HOST.":".REDIS_PORT);
session_id($PhoneNumber);
session_start();

$WARNING = "";
$ANSWER = array();

if(isset($_SESSION['Token'])){
    if($_SESSION['Token'] == $Token && $_SESSION['Time'] > time()){
        session_destroy();
        session_unset();
        require dirname(__FILE__).'/../../ENMOL/config/enmol-write-config.php';
        $Result = $SQLWriteConnection->query("UPDATE `Users` SET `RememberToken` = NULL WHERE `Phone` = $PhoneNumber LIMIT 1");//写入数据
        mysqli_close($SQLWriteConnection);
        $WARNING = "SESSION-DESTROY-SUCCESS";
    }else{
        $WARNING = "SESSION-DESTROY-FAILED";
    }
}else{
    $WARNING = "NO-SESSION";
}

$ANSWER['状态'] = "SUCCESS";
$ANSWER['警告'] = $WARNING;

echo json_encode($ANSWER);
