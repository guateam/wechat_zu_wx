<?php
require("database.php");
//获取预约信息: 工号和对应的服务
$sv = $_POST['fn'];
$phone = (get("shop"))[0]['phone'];
$sv = explode('-',$sv);
$info = [];
$total_time = 0;
$total_price = 0;
$id=$_POST['id'];//用户的openid

//获取充值总额
//这里的查询语句，recharge_record的user_id应该为openid,测试期间都是id,应该改掉。具体代码在充值的相关代码中更改
$str = "select sum(`recharge_record`.`charge`) AS `charge` from  `recharge_record` where ( '$id' = `recharge_record`.`user_id`)";
$charge = sql_str($str);
//获取消费总额,仅计算用会员卡支付并且支付完成或评价完成的订单
$str = "select sum(`pay_amount`) AS `use` from `consumed_order` where ('$id' = `user_id`) AND (`payment_method` = 3) AND (`state` >= 4)";
$use = sql_str($str);
//计算目前账户内余额
$charge=$charge[0]['charge']-$use[0]['use'];


for($i=0;$i<count($sv)/2;$i++){
    $j = $i*2;
    $job_number = $sv[$j];
    $id = $sv[$j+1];
    $service = sql_str("select * from service_type where `ID`='$id'");
    $total_time+=intval($service[0]['duration'])*60;
    $total_price+=intval($service[0]['price']);
    $tech = sql_str("select job_number,photo from technician where `job_number`='$job_number'");
    array_push($info,['tech'=>$tech[0],'service'=>$service[0]]);
}
echo json_encode(['status'=>1,'data'=>$info,'phone'=>$phone,'exist'=>$total_time,'total_price'=>$total_price,'charge'=>$charge]);