<?php
require("database.php");
require("getservicetype.php");
$id = $_POST['id'];
$result = getservicetype($id);
$res = [];
if($result)
{
    foreach($result['data'] as $rs)
	{
        if($rs['id'] == $id)
		{
            $res = $rs;
            break;
        }
    }
    if(count($res)>0)
	{
        echo json_encode(['status'=>1,'data'=>$res]);
	}
    else
	{
		echo json_encode(['status'=>0]);
	}
}
else
{
    echo json_encode(['status'=>0]);
}
