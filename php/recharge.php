<?php
require("database.php");
require("getpromotion.php");
$user = $_POST['user_id'];
$us = get("customer","openid",$user);

if($us)
{
    $val = $_POST['charge']*100;
    $job_number = null;
    if(isset($_POST['job_number']))$job_number = $_POST['job_number'];
    //支付方式
    $pay = $_POST['pay'];

    $dict=['1','2','3','4','5','6','7','8','9','0'];
    $rnd = "";
    $rnd.=date("YmdHis");
    
	for($i=0;$i<2;$i++)
	{
        $rnd.=$dict[rand(0,count($dict)-1)];
    }
    for($i=0;$i<4;$i++)
	{
        $rnd.=$dict[rand(0,count($dict)-1)];
    }

    $promotion = get_promotion();
    //活动返的钱
    $bonus = 0;
    foreach($promotion as $pro){
        if($val >= $pro['need']*100){
            $val+=$pro['back']*100;
        }
    }
    add("recharge_record",[
        ["record_id",$rnd],
        ["user_id",$us[0]['openid']],
        ['charge',$val],
        ['payment_method',$pay],
        ['job_number',$job_number],
        ['generated_time',time()]
        ]);
		
    $all_recharge = get('recharge_record','user_id',$user);
    $all_level = get('vip_information');
    $total_recharge = 0;
    $new_level = 0;
    
	foreach($all_recharge as $re)
	{
        $total_recharge+=$re['charge'];
    }
    foreach($all_level as $lv)
	{
        if($lv['necessary_charge_to_level_up']>$total_recharge)
		{
            $new_level = $lv['level'];
            break;
        }
    }
    set("customer","ID",$user,[['cash',$us[0]['cash']+$val],['level',$new_level]]);

    echo json_encode(['status'=>1]);
}
else
{
    echo json_encode(['status'=>0]);
}
