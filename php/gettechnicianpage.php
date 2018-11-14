<?php
require 'database.php';
require 'gettechnician.php';
require 'getfeedback.php';

$id=$_POST['id'];
$tm = $_POST['time'];
$count = count(get("service_order","job_number",$id));
$tag = sql_str("select A.ID,A.tag_name,count(B.tag_id) as count from rate_tag A,tech_tag B where B.tag_id = A.ID and B.job_number = '$id' group by A.ID");

echo(json_encode(['status'=>1,'tag'=>$tag,'data'=>['order_num'=>$count,'technician'=>gettechnician($id,$tm),'feedback'=>getfeedback($id)]]));