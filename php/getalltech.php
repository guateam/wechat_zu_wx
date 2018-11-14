<?php
require("database.php");
date_default_timezone_set('PRC'); 
$numbers = [];


//计算目前的时间距离下一个5分钟还有多少秒
$to_5min = 300-time()%300;
////获取选择的时间，若未选择时间，则默认为当前时间的下一个5分钟整
$select_time = time()+$to_5min;
if(isset($_POST['select_time'])){
    $select_time = intval($_POST['select_time']);
}


$tech_info = sql_str("select A.job_number,A.photo from technician A");
foreach($tech_info as $idx => $tc){
    $job_number = $tc['job_number'];
    //获取刷钟情况
    $clock = sql_str("select state from clock where job_number = '$job_number' order by `time` limit 1");
    //获取预约情况
    $appoint_tech = sql_str("select * from service_order where job_number = '$job_number' and appoint_time > ($select_time - (select Sum(duration)*60 from service_order A,service_type B where A.item_id = B.ID and A.order_id =(select order_id from service_order where job_number = '$job_number' and appoint_time < $select_time order by appoint_time desc limit 1)  ))");
    //是否在上钟
    $up_clock = false;
    //是否被预约
    $already_appoint = false;
    //若有刷钟记录
    if($clock){
        //若最近的刷钟记录为上钟，则上钟情况为true
        if($clock[0]['state'] == 1)
            $up_clock = true;
    }
    //若有预约
    if($appoint_tech){
        //预约情况为true
        $already_appoint = true;
    }

    //获取图片
    $friend_circle = sql_str("select A.img from technician_photo A where A.job_number = '$job_number' order by A.ID desc limit 3");
    //获取评分
    $rate = sql_str("select Avg(score) as score from rate where job_number = '$job_number' and `bad` = 1");
    //保留一位小数
    $rate = round($rate[0]['score'],1);
    $tech_info[$idx] = array_merge($tech_info[$idx],['img_list'=>$friend_circle,'rate'=>$rate,'level'=>"",'busy'=>$up_clock,'appoint'=>$already_appoint]);
}
echo json_encode(['status'=>1,'data'=>$tech_info]);




// $all_tech = get("technician");

// $result = [];
// foreach($all_tech as $tech)
// {
//     $jbnb = $tech['job_number'];
//     $photos = get("technician_photo","job_number",$jbnb);
//     $skills = get("skill","job_number",$jbnb);
//     $order = get("service_order","job_number",$jbnb);
//     //表示是否繁忙，1为繁忙，2为不繁忙
//     $busy = 2;
//     $save_order=[];
//     $clock = sql_str("select * from clock WHERE (`job_number` = '$jbnb') ORDER BY `time` DESC");
//     if($clock){
//         if($clock[0]['state'] == 1)$busy = 1;
//         else $busy = 2;
//     }
//     $photo_list = [];
//     // foreach($photos as $photo)
// 	// {
//     //     array_push($photo_list,str_replace('..','/wechat_zu_technician/',$photo['img']));
//     // }
//     array_push($result,[
//         "avatar_url"=>$tech['photo'],
//         "job_number"=>$tech['job_number'],
//         "description"=>$tech['description'],
//         "photo_list"=>$photos,
//         "rate"=>$tech['rate'],
//         "skill"=>$skills,
//         'busy'=>$busy,
//         "level"=>$tech['level'],
//         "hot"=>count($order),
//     ]);
// }
// echo json_encode(["data"=>$result]);