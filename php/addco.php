<?php
date_default_timezone_set('PRC');
require("database.php");
$id = $_POST['id'];
$phone = $_POST['phone'];
$people_num  = $_POST['people_num'];
$pay =  $_POST['pay'];
$obj = $_POST['obj'];
$appoint_time = $_POST['select_time'];

//是否有完成支付
$cant_pay = false;
if(isset($_POST['cant_pay']))$cant_pay = $_POST['cant_pay'];

//支付方式，0--未支付，1--微信支付，3--会员卡支付
$pay_way = 0;
if(isset($_POST['pay_way']))$pay_way = $_POST['pay_way'];

//外部传入的订单状态，1--预约待支付  4--完成支付
$state=$_POST['state'];

//根据openid获取用户的信息
$user = get("customer","openid",$id);

//创建订单号
$dict=['1','2','3','4','5','6','7','8','9','0'];
$rnd = "";
for($i=0;$i<3;$i++)
{
    for($j=0;$j<4;$j++)
        $rnd.=$dict[rand(0,count($dict)-1)];
}
$time = date("Ymd").$rnd;

//若能查找到用户，则继续处理
if($user)
{
    //无法支付的情况: 余额不足或微信支付失败
    if($cant_pay)
    {
        //添加未支付订单
        add("consumed_order",[
            ['appoint_time',$appoint_time],
            ['user_num',$people_num],
            ['generated_time',time()],
            ["order_id",$time],
            ["pay_amount",$pay],
            ['user_id',$user[0]['openid']],
            ['state',1],//状态为1，表示待支付
            ['contact_phone',$phone],
            ['payment_method',0] //未支付的时候，支付方式为0，表示未支付
        ]);
        //添加服务
        foreach($obj as $tech_service)
        {
            $jbnb = $tech_service['tech']['job_number'];
            $service_id = $tech_service['service']['ID'];
            add("service_order",[['appoint_time',$appoint_time],['order_id',$time],['service_type',1],["item_id",$service_id],["job_number",$jbnb]]);
        }
        echo json_encode(['state'=>1,'order_id'=>$time]);
        die();
    }

    //可以支付，则添加订单
    add("consumed_order",[
        ['appoint_time',$appoint_time],
        ['user_num',$people_num],
        ['generated_time',time()],
        ["order_id",$time],
        ["pay_amount",$pay],
        ['user_id',$user[0]['openid']],
        ['state',4],
        ['contact_phone',$phone],
        ['payment_method',$pay_way] 
    ]);
    //添加服务
    foreach($obj as $tech_service)
    {
        $jbnb = $tech_service['tech']['job_number'];
        $service_id = $tech_service['service']['ID'];
        add("service_order",[['appoint_time',$appoint_time],['order_id',$time],['service_type',1],["item_id",$service_id],["job_number",$jbnb]]);
    }
    echo json_encode(['state'=>1,'order_id'=>$time]);
    die();

}
//用户不存在的情况
echo json_encode(['state'=>0]);