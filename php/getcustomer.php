<?php
require("database.php");
$phone = $_POST['phone'];
$cus = get("customer","phone_number",$phone);
$id = $cus[0]['openid'];
//获取充值总额
$str = "select sum(`recharge_record`.`charge`) AS `charge` from  `recharge_record` where ( '$id' = `recharge_record`.`user_id`)";
$charge = sql_str($str);
//获取消费总额,仅计算用会员卡支付并且支付完成或评价完成的订单
$str = "select sum(`pay_amount`) AS `use` from `consumed_order` where ('$id' = `user_id`) AND (`payment_method` = 3) AND (`state` >= 4)";
$use = sql_str($str);
//计算目前账户内余额
$charge=$charge[0]['charge']-$use[0]['use'];

if($cus)
{
    $lv = get("vip_information","level",$cus[0]['level']);
    if($lv)
	{
        $lv = $lv[0]['name'];
    }
	else
	{
        $lv="非会员";
    }
	
    echo json_encode([
        'status'=>1,
        'name'=>$cus[0]['name'],
        'head'=>$cus[0]['head'],
        'phone_number'=>$cus[0]['phone_number'],
        'id_number'=>$cus[0]['id_number'],
        'level'=>$lv,
        'gender'=>$cus[0]['gender']==1?"男":"女",
        'cash'=>$charge/100  //分转换为元表示
        
    ]);
}
else
{
    echo json_encode(['status'=>0]);
}
?>