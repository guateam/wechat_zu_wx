<?php
require("database.php");
$order_id = null;
if(isset($_POST['id']))$order_id = $_POST['id'];
//查询店铺信息，目前只查找ID为1的店铺
$shop_info = sql_str("select name,position,phone from shop where ID = 1");
if(!is_null($order_id)){
    //查找该订单号的订单
    $orders = sql_str("select A.appoint_time,B.job_number,C.ID,C.name,C.duration,C.price from consumed_order A,service_order B,service_type C where A.order_id = '$order_id' and B.order_id = A.order_id and C.ID = B.item_id");
    if($orders){
        //计算总共需要消费多少钱
        $total = 0;
        foreach($orders as $order){
            $total+=$order['price'];
        }
        echo json_encode(['status'=>1,'data'=>$orders,'shop'=>$shop_info[0],'total'=>$total]);
        exit();
    }
    else{
        echo json_encode(['status'=>0]);
        exit();
    }
}else{
    $orders = sql_str("select * from consumed_order where `state` = 1");
    foreach($orders as $idx => $order){
        $odid = $order['order_id'];
        $total = sql_str("select Sum(B.price) as total from service_order A,service_type B where A.order_id = '$odid' and B.ID = A.item_id ");
        $orders[$idx] = array_merge($order,$total[0]);
    }
    echo json_encode(['status'=>1,'data'=>$orders,'shop'=>$shop_info[0]]);
    exit();
}

