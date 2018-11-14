<?php
require("database.php");
$tcs = '';
if(isset($_POST['tc']))$tcs = $_POST['tc'];
//选择了技师的情况
if($tcs != '' && $tcs[0] != ''){
    $skills = sql_str("SELECT
    `skill`.`level` AS `level`,
    `skill`.`job_number` AS `job_number`,
    `service_type`.`name` AS `name`,
    `service_type`.`image` AS `image`,
    `service_type`.`duration` AS `duration`,
    `service_type`.`price` AS `price`,
    `service_type`.`ID` AS `id`
    FROM
    ( `skill` JOIN `service_type` ) 
    WHERE
    ( `service_type`.`ID` = `skill`.`service_id` )
    ORDER BY
    `skill`.`job_number`");
    $list = [];//输出的技师-服务列表
    for($i=0;$i<count($tcs);$i++){
        //默认选择第一个技师
        $list = array_merge($list,[$tcs[$i]=>['skill'=>[],'choosen'=>$i==0?true:false,'job_number'=>$tcs[$i]]]);
    }
    foreach($skills as $skill){
        //单位换算  分->元
        $skill['price']/=100;
        //添加服务的选择状态
        $skill = array_merge($skill,['choosen'=>false]);
        //若该技师在传入的技师列表中
        if(in_array($skill['job_number'],$tcs)){
            //在输出的技师-服务列表中添加该技师的服务信息
            $list[$skill['job_number']]['skill'] = array_merge($list[$skill['job_number']]['skill'],[$skill]);
        }
    }
    echo json_encode(['status'=>1,'data'=>$list]);
}
//未选择技师的情况
else
{
    $skills = sql_str("SELECT
    `service_type`.`name` AS `name`,
    `service_type`.`image` AS `image`,
    `service_type`.`duration` AS `duration`,
    `service_type`.`price` AS `price` ,
    `service_type`.`ID` AS `id`
    FROM
    (`service_type` )");
     $list = [];//输出的技师-服务列表
     $list = array_merge($list,['all'=>['skill'=>[],'choosen'=>true,'job_number'=>"所有"]]);
     foreach($skills as $skill){
        //单位换算  分->元
        $skill['price']/=100;
        //添加服务的选择状态
        $skill = array_merge($skill,['choosen'=>false]);
        //在输出的技师-服务列表中添加该技师的服务信息
        $list['all']['skill'] = array_merge($list['all']['skill'],[$skill]);
    }
    echo json_encode(['status'=>1,'data'=>$list]);
}
