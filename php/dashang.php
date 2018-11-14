<?php
require("database.php");

$val = $_POST['pay'];
$user = $_POST['user_id'];

$job_number = null;
if(isset($_POST['job_number']))
{
	$job_number = $_POST['job_number'];
}

add("tip",[
        ["salary",$val],
        ["technician_id",$job_number],
        ['user_id',$user],
        ['date',time()]
        ]);
		
echo json_encode(['status'=>1]);
