<?php
include "wxtools/wxBizDataCrypt.php";

$data = '';

define("APPID","wx4f3980f10121e716");
define("APPSECRET","9b33d0349712ce205dcd5348f274a2f9");

if(empty($_POST['code']) || empty($_POST['signature']) || empty($_POST['rawData']) || empty($_POST['encryptedData'])){
    die("参数错误");
}

$code = $_POST['code'];

$url = "https://api.weixin.qq.com/sns/jscode2session?appid=" . APPID . "&secret=" . APPSECRET . "&js_code=" . $code . "&grant_type=authorization_code";

$responses_arr = vget($url);

$responses_arr = json_decode($responses_arr,true);

if(empty($responses_arr)||empty($responses_arr['openid'])||empty($responses_arr['session_key'])){
    $this->render(0,'请求微信接口失败,appid或私钥不匹配！');
}

$openid = $responses_arr['openid'];
$session_key = $responses_arr['session_key'];

$signature2 = sha1($_POST['rawData'] . $session_key);

if($_POST['signature'] !== $signature2){
    die("数据签名校验失败");
}

$encryptedData = $_POST['encryptedData'];
$iv = $_POST['iv'];
$pc = new wxBizDataCrypt(APPID,$session_key);
$errCode = $pc->decryptData($encryptedData, $iv, $data);

$data = json_decode($data,true);

print_r($data);

function vget($url){
    $info=curl_init();
    curl_setopt($info,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($info,CURLOPT_HEADER,0);
    curl_setopt($info,CURLOPT_NOBODY,0);
    curl_setopt($info,CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($info,CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($info,CURLOPT_URL,$url);
    $output= curl_exec($info);
    curl_close($info);
    return $output;
}