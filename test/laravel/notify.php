<?php

require_once __DIR__ . '/../../autoload.php';

use birksCha\Lib\WxPayApi;
use birksCha\Lib\WxPayNotify;
use birksCha\Lib\WxPayOrderQuery;
use birksCha\WxPay\WxPayConfig;
use birksCha\WxPay\Log;
use birksCha\WxPay\CLogFileHandler;

//初始化日志
$logHandler= new CLogFileHandler(__DIR__."/logs/".date('Y-m-d').'.log');
$log = Log::Init($logHandler, 15);



require_once __DIR__ ."/notify.class.php";
require_once __DIR__ ."/../config.php";

$config = new WxPayConfig($configs);
Log::DEBUG("begin notify online test!");
$notify = new PayNotifyCallBack($configs);
$notify->Handle($config,true);
