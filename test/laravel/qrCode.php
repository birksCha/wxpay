<?php
//以下为日志

require_once __DIR__ . '/../../autoload.php';

use birksCha\WxPay\WxPayConfig;
use birksCha\WxPay\QRcode;
use birksCha\Lib\WxPayUnifiedOrder;
use birksCha\Lib\WxPayApi;


require_once __DIR__ ."/../config.php";
require_once __DIR__ ."/native.class.php";


//var_dump($_GET);

if(isset($_GET['data'])&&!empty($_GET['data'])){
    //var_dump(444444);
    if(substr($_GET['data'], 0, 6) == "weixin"){
        QRcode::png($_GET['data']);
        //var_dump($result);
        exit;
    }else{
        header('HTTP/1.1 404 Not Found');
    }
}else{
    $Native = new Native($configs);
    $result = $Native->native();
    $url2 = $result["code_url"];
    if(substr($url2, 0, 6) == "weixin"){
        //QRcode::png($url2);
        QRcode::png("二维码已过期");
        exit;
    }else{
        header('HTTP/1.1 404 Not Found');
    }
}





