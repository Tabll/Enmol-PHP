<?php

namespace ShortMessageSender;

class ShortMessageSender
{
    protected $messageSendState = false;

    public function __construct(string $phoneNumber, string $messageTest) {
        $ch = curl_init();
        $data = array('text'=>$messageTest,'apikey'=>'63c1048235cbd2307c5c7f332aa4046e','mobile'=>$phoneNumber);
        curl_setopt ($ch, CURLOPT_URL, 'https://sms.yunpian.com/v2/sms/single_send.json');
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
        $resultJson = curl_exec($ch);//如果curl发生错误，打印出错误
        if(curl_error($ch) != ""){
            $this -> $messageSendState = false;
            return;
        }
        $result = json_decode($resultJson,true);
        if($result['msg']=="发送成功"){
            $this -> $messageSendState = true;
            return;
        }else{
            $this -> $messageSendState = false;
        }
    }

    public function isMessageSendSuccess(){
        return $this -> $messageSendState;
    }
}
