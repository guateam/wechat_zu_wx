<?php
require("database.php");
$phone = $_POST['phone'];
$user_id = get("customer","phone_number",$phone);
if($user_id)
{
    $user_id = $user_id[0]['ID'];
    $order = get("recharge_record","user_id",$user_id);
    if($order)
	{
        for($i=0;$i<count($order);$i++)
		{
            $order[$i]['generated_time']=substr($order[$i]['generated_time'],0,10);
        }
        echo json_encode(['status'=>1,'data'=>$order]);
    }
    else
	{
		echo json_encode(['status'=>-1]);
	}
}
else
{
    echo json_encode(['status'=>0]);
}
?>