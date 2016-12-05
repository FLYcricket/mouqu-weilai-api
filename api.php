<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/10/19
 * Time: 9:39
 */
$ch = curl_init();
$code = rand(1000, 9999);
$url = 'http://apis.baidu.com/kingtto_media/106sms/106sms?mobile=18656475604&content=%E3%80%90%E5%87%AF%E4%BF%A1%E9%80%9A%E3%80%91%E6%82%A8%E7%9A%84%E9%AA%8C%E8%AF%81%E7%A0%81%EF%BC%9A123';
$header = array(
    'apikey: 1a32cdc7686fe73a8cacf207bfe07faf',
);
// 添加apikey到header
curl_setopt($ch, CURLOPT_HTTPHEADER  , $header);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
// 执行HTTP请求
curl_setopt($ch , CURLOPT_URL , $url);
$res = curl_exec($ch);

var_dump($res);
?>