<?php
require("database.php");
date_default_timezone_set('PRC'); 
$all_tech = getSearch("technician","job_number",$_POST['jobNumber']);
$job_number_like = $_POST['jobNumber'];


$numbers = [];
$tech_info = sql_str("select A.job_number,A.photo from technician A where `job_number` like '%$job_number_like%'");
foreach($tech_info as $idx => $tc){
    $job_number = $tc['job_number'];
    //获取图片
    $friend_circle = sql_str("select A.img from technician_photo A where A.job_number = '$job_number' order by A.ID desc limit 3");
    //获取评分
    $rate = sql_str("select Avg(score) as score from rate where job_number = '$job_number' and `bad` = 1");
    //保留一位小数
    $rate = round($rate[0]['score'],1);
    $tech_info[$idx] = array_merge($tech_info[$idx],['img_list'=>$friend_circle,'rate'=>$rate,'level'=>""]);
}
echo json_encode(['status'=>1,'data'=>$tech_info]);


// $now = "";
// if(!isset($_POST['time']))$now = date('Y-m-d H:i:s',time());
// else $now = date('Y-m-d ').$_POST['time'].":00";

// $result = [];
// foreach($all_tech as $tech)
// {
//     $photos = getSearch("technician_photo","job_number",$tech['job_number']);
//     $skills = getSearch("skill","job_number",$tech['job_number']);
//     $order = getSearch("service_order","job_number",$tech['job_number']);
//     $busy = 2;
//     $save_order=[];
//     foreach($order as $so){
//         $consumed_order = getSearch('consumed_order','order_id',$so['order_id']);
//         $latest_time = "0";
//         foreach($consumed_order as $co){
//             //如果有订单时间距离现在的时间差小于1小时，则认为该订单还未完成，繁忙
//             $leap = abs(   strtotime($co['generated_time'])-strtotime($now)   );
//             if($leap<3600){
//                 $busy = 1;
//                 break;
//             }
//         }
//     }
//     $photo_list = [];
//     foreach($photos as $photo){
//         array_push($photo_list,str_replace('..','/wechat_zu_technician/',$photo['img']));
//     }
//     array_push($result,[
//         "avatar_url"=>$tech['photo'],
//         "job_number"=>$tech['job_number'],
//         "description"=>$tech['description'],
//         "photo_list"=>$photo_list,
//         "rate"=>$tech['rate'],
//         "skill"=>$skills,
//         'busy'=>$busy,
//         "level"=>$tech['level'],
//         "hot"=>count($order),
//     ]);
// }

// echo json_encode(["data"=>$result]);