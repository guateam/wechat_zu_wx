<?php
require('database.php');
$id =$_POST['service_id'];
$numbers = [];

//获取选择的时间，若未选择时间，则默认为当前时间
$select_time = time();
if(isset($_POST['select_time'])){
    $select_time = $_POST['select_time'];
}
//获取服务
$service_name = sql_str("select name,have_level from service_type where `ID` = '$id'");
$tech_info = sql_str("select A.job_number,A.photo,B.level,C.name from technician A,skill B,skill_level C where A.job_number = B.job_number and B.service_id = '$id' and C.ID = B.level");
$no_level = sql_str("select A.job_number,A.photo,B.level from technician A,skill B where A.job_number = B.job_number and B.service_id = '$id' and B.level = 0");
for($i=0;$i<count($no_level);$i++){
    $no_level[$i] =  array_merge($no_level[$i],['name'=>""]);
}
$tech_info = array_merge($tech_info,$no_level);
// $friend_circle = sql_str("select ")
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

    $friend_circle = sql_str("select A.img from technician_photo A where A.job_number = '$job_number' order by A.ID desc limit 3");
    $rate = sql_str("select Avg(score) as score from rate where job_number = '$job_number' and `bad` = 1");
    //保留一位小数
    $rate = round($rate[0]['score'],1);
    $tech_info[$idx] = array_merge($tech_info[$idx],['img_list'=>$friend_circle,'rate'=>$rate,'busy'=>$up_clock,'appoint'=>$already_appoint]);
    if($service_name[0]['have_level'] == 0)
        $tech_info[$idx]['level'] = "";
}
$svnm = $service_name[0]['name'];
echo json_encode(['status'=>1,'data'=>$tech_info,'service_name'=>$svnm,'have_level'=>$service_name[0]['have_level'] ]);