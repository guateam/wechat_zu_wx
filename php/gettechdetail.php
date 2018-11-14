<?php
require("database.php");
$job_number = $_POST['job_number'];
$tech = get("technician","job_number",$job_number);

if($tech)
{
    $tech[0]['entry_date'] = substr($tech[0]['entry_date'],0,10);
    $tech[0]['birthday'] = substr($tech[0]['birthday'],0,10);
    echo json_encode([
        'status'=>1,
        'data'=>$tech
    ]);
}
else
{
    echo json_encode([
        'status'=>0,
        'data'=>[]
    ]);
}
?>