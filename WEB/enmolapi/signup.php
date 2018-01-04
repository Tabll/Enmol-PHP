<?php
require dirname(__FILE__).'/../../ENMOL/tools/GetHeaders.php';
$headers = GetTheHeaders();
if(empty($headers['key']) || $headers['key'] != "QFE1WEG3ER448984WEF7W4849WEF") {
    exit();
}
    $State = isset($_POST['sign-up-state']) ? $_POST['sign-up-state'] : "";
    $PhoneNumber = isset($_POST['user-phone-number']) ? $_POST['user-phone-number'] : "";
    $VerifyCode = isset($_POST['user-verify-code']) ? $_POST['user-verify-code'] : "";
    $Password = isset($_POST['user-password']) ? $_POST['user-password'] : "";

    switch ($State) {
        case "1":
            $token = mt_rand(10000, 99999);
            $message = "【Enmol以沫】感谢您注册以沫，您的验证码是".$token;
            require dirname(__FILE__).'/../../ENMOL/connector/write-connector.php';
            require dirname(__FILE__).'/../../ENMOL/tools/ShortMessageSender.php';
            $result = $SQLWriteConnection->query("SELECT UpdateTime FROM `Verify_Telephone` WHERE TelephoneNumber = $PhoneNumber LIMIT 1");
            $row=$result->fetch_array(MYSQLI_NUM);//将得到的结果转为数组
            $updateTime=$row[0];//取第0个值
            if($updateTime == NULL){
                $result = $SQLWriteConnection->query("INSERT INTO `Verify_Telephone` (`TelephoneNumber`,`Token`) VALUES (`$PhoneNumber`,`$token`)");
                if(SendMessage($PhoneNumber, $message)){
                    echo "success";
                }else{
                    echo "短信发送失败";
                }
            } else {
                date_default_timezone_set("Asia/Shanghai");
                $second=strtotime(date('Y-m-d H:i:s',time()))-strtotime($updateTime);
                if($second >= 60){
                    $result = $SQLWriteConnection->query("UPDATE `Verify_Telephone` SET Token = $token WHERE TelephoneNumber = $PhoneNumber LIMIT 1");
                    if(SendMessage($PhoneNumber, $message)){
                        echo "success";
                    }else{
                        echo "短信发送失败";
                    }
                }else{
                    echo $updateTime.date('Y-m-d H:i:s',time()).$second."短信发送失败";
                    exit();
                }
            }
            break;
        case "2":
            require dirname(__FILE__).'/../../ENMOL/connector/read-connector.php';
            $result = $SQLReadConnection->query("SELECT Token,UpdateTime  FROM `Verify_Telephone` WHERE TelephoneNumber = $PhoneNumber LIMIT 1");
            $row=$result->fetch_array(MYSQLI_NUM);
            if($row[0]==NULL){
                exit();
            }else{
                date_default_timezone_set("Asia/Shanghai");
                if(strtotime(date('Y-m-d H:i:s',time()))-strtotime($row[1]) < 300){
                    if($VerifyCode == $row[0]){
                        echo "success";
                    }else{
                        exit();
                    }
                }else{
                    exit();
                }
            }
            break;
        case "3":
            require dirname(__FILE__).'/../../ENMOL/connector/read-connector.php';
            $result = $SQLReadConnection->query("SELECT Token,UpdateTime  FROM `Verify_Telephone` WHERE TelephoneNumber = $PhoneNumber LIMIT 1");
            $row=$result->fetch_array(MYSQLI_NUM);
            if($row[0]==NULL){
                exit();
            }else{
                date_default_timezone_set("Asia/Shanghai");
                if(strtotime(date('Y-m-d H:i:s',time()))-strtotime($row[1]) < 300){
                    if($VerifyCode == $row[0]){
                        if(preg_match("#(?=^.*?[a-z])(?=^.*?[A-Z])(?=^.*?\d)^(.{8,})$#",$Password) != 0){
                            $vPassword = password_hash($Password, PASSWORD_DEFAULT);
                            $result = $SQLReadConnection->query("SELECT UserID  FROM `Users` WHERE Phone = $PhoneNumber LIMIT 1");
                            $row=$result->fetch_array(MYSQLI_NUM);
                            require dirname(__FILE__).'/../../ENMOL/connector/write-connector.php';
                            if($row[0]==NULL){
                                $addUser1 = $SQLWriteConnection->query("INSERT INTO `Users` (`Phone`,`Password`) VALUES ($PhoneNumber,'$vPassword')");

                                $userIDN = $SQLWriteConnection->query("SELECT UserID FROM `Users` WHERE Phone = $PhoneNumber LIMIT 1");
                                $row=$userIDN->fetch_array(MYSQLI_NUM);

                                $addUser2 = $SQLWriteConnection->query("INSERT INTO `User_Info` (`UserID`,`UserName`,`AddTime`) VALUES ($row[0],$PhoneNumber,NOW())");
                                echo "success";
                            }else{
                                $changePassword = $SQLWriteConnection->query("UPDATE `Users` SET Password = $vPassword WHERE Phone = $PhoneNumber LIMIT 1");
                                echo "success";
                            }
                        }else{
                            echo "密码长度至少八位，且必须由数字、字符、特殊字符三种中的两种组成";
                        }
                    }else{
                        exit();
                    }
                }else{
                    exit();
                }
            }
            break;
    }