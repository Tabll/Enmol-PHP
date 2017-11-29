<?php
function SendMessage(string $phoneNumber, string $message){
    $ch = curl_init();
    $data = array('text'=>$message,'apikey'=>'63c1048235cbd2307c5c7f332aa4046e','mobile'=>$phoneNumber);
    curl_setopt ($ch, CURLOPT_URL, 'https://sms.yunpian.com/v2/sms/single_send.json');
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
    $resultJson = curl_exec($ch);//如果curl发生错误，打印出错误
    if(curl_error($ch) != ""){
        $messageSendState = false;
    }
    $result = json_decode($resultJson,true);
    $messageSendState = ($result['msg']=="发送成功") ? true : false;
    return $messageSendState;
}
