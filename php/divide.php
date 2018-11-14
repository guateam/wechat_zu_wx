<?php
date_default_timezone_set('PRC');
$block = $_POST['block'];
$idx = $_POST['idx'];
$idx2 = $_POST['idx2'];
$time_block_length = $_POST['length'];
$day = intval($_POST['day']);

$leap=1800;
$start = intval($block['time'])+$day-strtotime(date('Y-m-d',time()));
//新的divide_line
$tp = [];
$divide_block = [];
//第一个允许的时间块下标
$first_allow = 1000000;

for ($i = $start,$j=0; $i < $start + $leap; $i += 300,$j++) {
    $si = date("Y-m-d H:i:s",$i);

    $p = $i+$day-(3600*24);
    $allow = time()>$i?0:1;
    if($allow && $j < $first_allow )$first_allow = $j;

    array_push($divide_block,['time'=>$i,'choosen'=>0,'allow'=>$allow]);
}
for ($i = 0; $i < $time_block_length; $i++) {
    array_push($tp,$idx == $i ? 1 : 0);
}
echo json_encode(['block'=>$divide_block,'tp'=>$tp,'first'=>$first_allow]);