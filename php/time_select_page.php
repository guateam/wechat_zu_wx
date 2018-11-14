<?php
require('database.php');
date_default_timezone_set('PRC');
//获取店铺信息
$shop="御足堂影院式足道";
if(isset( $_COOKIE['zys'])){
    $shop_name = $_COOKIE['zys'];
}
$shop = get("shop","name",$shop);
if($shop){
    $result = [];

    $open = strtotime(date("Y-m-d ",time()).$shop[0]['open_time']);//开业时间戳
    $close = strtotime(date("Y-m-d ",time()).$shop[0]['close_time']);;//结业时间戳
    $today = strtotime(date("Y-m-d",time()));//当天0点时间戳
    $leap = 1800;//时间块间隔多少秒
    $row = [];//一行时间块
    $time_block = []; //营业时间块

    //填充时间块变量
    for($i=$open,$j=0;$i<=$close;$i+=$leap,$j++){
        if (($j + 1) % 4 == 0) {

            array_push($row,['time'=>$i,'choosen'=>0,'allow'=>(time()>$i+(60*25)?0:1)]);//目前时间比时间块时间大25分钟，则时间块无法选择(时间块里面最多细分到超前25分钟)
            array_push($time_block,$row);
            $row = [];
        } else {
            array_push($row,['time'=>$i,'choosen'=>0,'allow'=>(time()>$i+(60*25)?0:1)]);
        }
    }
    //将多余的最后一行push进去
    array_push($time_block,$row);


    //获取开业时间，结业时间，当前时间, 是否允许预约
    array_push($result,
    ['open'=>$shop[0]['open_time'],
    'close'=>$shop[0]['close_time'],
    'today'=>strtotime(date("Y-m-d",time())),
    'time_block'=>$time_block,
    'pre'=>$shop[0]['appoint_allow']
    ]);
    echo json_encode(['status'=>1,"data"=>$result]);
}else{
    echo json_encode(['status'=>0]);
}