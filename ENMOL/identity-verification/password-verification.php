<?php
function isPasswordTrue($phone,$password){
    require_once dirname(__FILE__) . '/../config/enmol-read-config.php';
    require_once dirname(__FILE__) . '/../config/enmol-config.php';
    $SQLReadConnection = new mysqli(DB_HOST,DB_USER,DB_READ_PASSWORD,DB_READ_NAME,DB_PORT);
    $do = $SQLReadConnection->prepare("SELECT `Password` FROM `Users` WHERE Phone = ? LIMIT 1");
    $do -> bind_param(1, $phone);
    $do -> execute();
    $result = $do -> get_result();
    $row = $result -> fetch_array();
    mysqli_close($SQLReadConnection);
    if($row[0] == NULL){
        return false;
    }else{
        return password_verify($password, $row[0]);
    }
}