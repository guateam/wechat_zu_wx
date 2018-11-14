<?php
if(isset($_POST['ajax_get']))
    require("database.php");
function get_promotion()
{
    $time = time();
   
    $dates =  sql_str("select * from promotion ORDER BY `need` ASC");
    $result = [];
    foreach($dates as $date)
	{
        if($date['start'] <= $time && $time <= $date['end'])
		{
            $date['need']/=100;
            $date['back']/=100;
            array_push($result,$date);
        }
    }
    return $result;
}
//若不是ajax请求，不执行语句，用于给其他php文件require的时候不额外执行内容
if(isset($_POST['ajax_get']))
{
    echo json_encode(['status'=>1,'data'=>get_promotion()]);
}