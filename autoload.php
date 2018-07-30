<?php
define("SDK_PATH",__DIR__);

spl_autoload_register(function ($class) {
//    if (false !== stripos($class, '\\\\WxPay\\\\')||false !== stripos($class, '\\\\Lib\\\\')) {
    //echo DIRECTORY_SEPARATOR;
    preg_match("/\\\WxPay\\\/",$class,$wxpay);
    preg_match("/\\\Lib\\\/",$class,$lib);
    if (!empty($wxpay)||!empty($lib)) {
        if(!empty($wxpay)){
            $path = SDK_PATH.DIRECTORY_SEPARATOR."src".DIRECTORY_SEPARATOR."WxPay".DIRECTORY_SEPARATOR."Native";
        }else{
            $path = SDK_PATH.DIRECTORY_SEPARATOR."src".DIRECTORY_SEPARATOR."WxPay".DIRECTORY_SEPARATOR."Lib";
        }
        //$path = SDK_PATH."/src/WxPay/Native";
        $files = scandir($path);
        //var_dump(scandir($path));
        foreach($files as $k => $v){
            if($v != "." && $v != ".."){
                $class_path = $path.DIRECTORY_SEPARATOR.$v;
                if(!is_file($class_path)){
                    continue;
                }
                require_once $class_path;
            }
        }
    }
});