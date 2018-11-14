<?php
require("database.php");
$user_id = $_POST['user_id'];
$is_vip = get("customer",'ID',$user_id);
$head = $is_vip[0]['head'];
$is_vip = $is_vip[0]['level']==0?false:true;
//获取该用户的充值总额
$str = "select sum(`recharge_record`.`charge`) AS `charge` from  `recharge_record` where ( '$user_id' = `recharge_record`.`user_id`)";
$result = sql_str($str);

$data=[];
$result = $result[0];

//获取升级所需的总充值额和目前等级
$str = "SELECT group_concat(`necessary_charge_to_level_up` SEPARATOR ',')  AS str, group_concat(`name` SEPARATOR ',') AS nm FROM vip_information WHERE necessary_charge_to_level_up > ".$result['charge']." LIMIT 1 ;";
$exp = (int)(explode(',',(sql_str($str))[0]['str']))[0];
$lv_list = (explode(',',(sql_str($str))[0]['nm']));
//计算还需要多少充值才能升级
if($exp)$exp = $exp -  $result['charge'];
else $exp = 0;
//获取目前等级和下一级
$nowlv = $lv_list[0];
$nxlv = "无";
if(count($lv_list)>1) $nxlv = $lv_list[1];

//数据整合到一个数组钟去
$result = array_merge($result,["exp"=>$exp,'nowlv'=>$nowlv,'nxlv'=>$nxlv]);

   
if($result && $is_vip)
{ 
    $result['exp']/=100;
    $result['charge']/=100;
    echo json_encode(['status'=>1,'data'=>$result,'head'=>$head]);
}
else
{
    $first_lv = get("vip_information",'level',1);
    echo json_encode(['status'=>0,'head'=>$head,'data'=>[
        'next_lv'=>$first_lv[0]['name'],
    ]]);
}