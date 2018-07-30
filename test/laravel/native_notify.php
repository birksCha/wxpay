<?php
require_once __DIR__ . '/../../autoload.php';
//date_default_timezone_set('PRC');
require_once __DIR__ ."/native.class.php";
require_once __DIR__ ."/../config.php";

$native = new Native($configs);
$result = $native->native();
$out_trade_no = $result["out_trade_no"];

?>



<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>微信支付样例</title>
</head>
<body>
<div style="margin-left: 10px;color:#556B2F;font-size:30px;font-weight: bolder;">扫描支付模式二</div><br/>
<img id = "myImg" src ="http://test.wxpaycha.dev/test/laravel/qrCode.php?data=<?php echo $result["code_url"]; ?>" style="width:150px;height:150px;">
<div id="myDiv"></div><div id="timer"></div>
<script>
    //设置每隔1000毫秒执行一次load() 方法
    var maxTime = 60;
    var myIntval=setInterval(function(){load()},1000);
    function load(){
        //document.getElementById("timer").innerHTML=parseInt(document.getElementById("timer").innerHTML)+1;
        document.getElementById("timer").innerHTML=maxTime-1;

        var xmlhttp;
        if (window.XMLHttpRequest){
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp=new XMLHttpRequest();
        }else{
            // code for IE6, IE5
            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange=function(){
            if (xmlhttp.readyState==4 && xmlhttp.status==200){
                trade_state=xmlhttp.responseText;
                if(trade_state=='SUCCESS'){
                    document.getElementById("myDiv").innerHTML='支付成功';
                    //alert(transaction_id);
                    //延迟3000毫秒执行tz() 方法
                    clearInterval(myIntval);
                    setTimeout("location.href='success.php'",3000);

                }else if(trade_state=='REFUND'){
                    document.getElementById("myDiv").innerHTML='转入退款';
                    clearInterval(myIntval);
                }else if(trade_state=='NOTPAY'){
                    document.getElementById("myDiv").innerHTML='请扫码支付';

                }else if(trade_state=='CLOSED'){
                    document.getElementById("myDiv").innerHTML='已关闭';
                    clearInterval(myIntval);
                }else if(trade_state=='REVOKED'){
                    document.getElementById("myDiv").innerHTML='已撤销';
                    clearInterval(myIntval);
                }else if(trade_state=='USERPAYING'){
                    document.getElementById("myDiv").innerHTML='用户支付中';
                }else if(trade_state=='PAYERROR'){
                    document.getElementById("myDiv").innerHTML='支付失败';
                    clearInterval(myIntval);
                }

            }
        }
        //orderquery.php 文件返回订单状态，通过订单状态确定支付状态
        xmlhttp.open("POST","http://test.wxpaycha.dev/test/orderquery.php",false);
        //下面这句话必须有
        //把标签/值对添加到要发送的头文件。
        xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
        xmlhttp.send("out_trade_no=<?php echo $out_trade_no;?>");
        maxTime--;
        if(maxTime==0){
            clearInterval(myIntval);
            document.getElementById("myImg").src="./images/test.png";
            document.getElementById("timer").innerHTML="二维码已过期";
        }
    }
</script>

</body>
</html>






