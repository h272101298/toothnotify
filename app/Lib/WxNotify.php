<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/4/15
 * Time: 15:49
 */

namespace App\Lib;


class WxNotify
{
    private $appId;
    private $appSecret;
    private $accessToken;
    private $getAccessUrl = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=%s&secret=%s';
    private $sendUrl = 'https://api.weixin.qq.com/cgi-bin/message/subscribe/send?access_token=%s';
    public function __construct()
    {
        $this->appId = "wxa68706fc4cad18a5";
        $this->appSecret = "70afb2c709af2ea53dd72c31c365850e";
    }
    public function getAccessToken()
    {
        $url = sprintf($this->getAccessUrl,$this->appId,$this->appSecret);
        $data = $this->httpRequest($url);
        if (!empty($data['access_token'])){
            return $data['access_token'];
        }else{
            throw new \Exception(json_encode($data));
        }
    }
    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;
    }
    public function send($data)
    {
        $url = sprintf($this->sendUrl,$this->accessToken);
        $data = $this->httpRequest($url,$data);
        return $data;
    }
    public function httpRequest($url,$data=null)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        if (!empty($data)){
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        if($output === FALSE ){
            return false;
        }
        curl_close($curl);
        return json_decode($output,JSON_UNESCAPED_UNICODE);
    }

}