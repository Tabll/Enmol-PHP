<?php
require dirname(__FILE__).'/../../ENMOL/tools/GetHeaders.php';
$headers = GetTheHeaders();
if(empty($headers['key']) || $headers['key'] != "QFE1WEG3ER448984WEF7W4849WEF") {
    exit();
}

$State = isset($_POST['sign-in-state']) ? $_POST['sign-in-state'] : "";
$PhoneNumber = isset($_POST['user-phone-number']) ? $_POST['user-phone-number'] : "";
$Token = isset($_POST['token']) ? $_POST['token'] : "";
$Password = isset($_POST['user-password']) ? $_POST['user-password'] : "";

$ANSWER = array();
$ANSWER['NeedUpdate'] = "FALSE";
$ANSWER['State'] = "FAILED";
$ANSWER['Token'] = "";
$ANSWER['WARNING'] = "";

require_once dirname(__FILE__).'/../../ENMOL/identity-verification/session-new.php';
require_once dirname(__FILE__).'/../../ENMOL/identity-verification/sessions-get.php';
require_once dirname(__FILE__).'/../../ENMOL/identity-verification/password-verification.php';

switch ($State){
    case "1"://客户端没有Token
        if(isPasswordTrue($PhoneNumber,$Password)){
            newSession($PhoneNumber);
            $ANSWER['State'] = "SUCCESS";
            $ANSWER['NeedUpdate'] = "TRUE";
            $ANSWER['Token'] = getToken($PhoneNumber);
        }else{
            $ANSWER['WARNING'] = "用户名或密码错误";
        }
        break;
    case "2"://客户端存储有Token
        if($Token == getToken($PhoneNumber)){
            $ANSWER['State'] = "SUCCESS";
        }elseif(isPasswordTrue($PhoneNumber,$Password)){
            newSession($PhoneNumber);
            $ANSWER['State'] = "SUCCESS";
            $ANSWER['NeedUpdate'] = "TRUE";
            $ANSWER['Token'] = getToken($PhoneNumber);
        }else{
            $ANSWER['WARNING'] = "用户名或密码错误";
        }
        break;
    default:
        break;
}
echo json_encode($ANSWER);