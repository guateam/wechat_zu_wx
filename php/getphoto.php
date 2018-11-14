<?php
    require("database.php");
    $job_number=$_POST['job_number'];
    $photo = get("technician_photo","job_number",$job_number);
    if($photo)
	{
        echo json_encode(['status'=>1,'data'=>$photo]);
    }
	else
	{
        echo json_encode(['status'=>0,'data'=>[]]);
    }
