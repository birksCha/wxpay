<?php
//以下为日志

require_once __DIR__ . '/../../autoload.php';

use birksCha\WxPay\WxPayConfig;
use birksCha\WxPay\QRcode;
use birksCha\Lib\WxPayUnifiedOrder;
use birksCha\Lib\WxPayApi;


class Native
{
    private $configObj;

    public function setConfigObj($values){
        $this->configObj = $values;
    }
    public function getConfigObj(){
        return $this->configObj;
    }

    public function __construct($values)
    {
        $tempObj = new WxPayConfig($values);
        $this->setConfigObj($tempObj);
    }

    public function preOrder($procuct_id,$trade_type="NATIVE"){
        $this->native();
    }

    public function native() {
        $config = $this->configObj;
        $out_trade_no = md5("ZZRW".$config->GetMerchantId().date("YmdHis"));
        $product_id = "123456789";
        $Notify_url = "https://bns.ymify.com/test/laravel/notify.php";
        $Time_start = date("YmdHis");
        $Time_expire = date("YmdHis", time() + 600);
        $Goods_tag = "test";
        $Trade_type = "NATIVE";
        $Total_fee = "1";
        $Attach = "test";
        $Body = "test";

        
        $input = new WxPayUnifiedOrder();
        $input->SetBody($Body);
        $input->SetAttach($Attach);
        $input->SetOut_trade_no($out_trade_no);
        $input->SetTotal_fee($Total_fee);
        $input->SetTime_start($Time_start);
        $input->SetTime_expire($Time_expire);
        $input->SetGoods_tag($Goods_tag);
        $input->SetNotify_url($Notify_url);
        $input->SetTrade_type($Trade_type);
        $input->SetProduct_id($product_id);

        if($input->GetTrade_type() == "NATIVE")
        {
            try{
                $result = WxPayApi::unifiedOrder($config, $input);
            } catch(Exception $e) {
                Log::ERROR(json_encode($e));
            }
        }
        $result['out_trade_no'] = $out_trade_no;
        return $result;
    }
}




