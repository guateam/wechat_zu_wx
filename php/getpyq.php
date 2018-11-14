<?php
require("database.php");
$job_number = $_POST['job_number'];
$datas = sql_str("select * from friend_circle where `job_number`='$job_number' order by date desc");
//$datas = get("friend_circle",'job_number',$job_number);
$i = 0;
foreach($datas as $data)
{


    if($data['img'] != ""){
        $datas[$i]['img'] = explode(",", $data['img']);
        $j = 0;
        foreach($datas[$i]['img'] as $imgid)
        {
            $result = get("technician_photo",'ID',$imgid);
            if($result)
            {
                $datas[$i]['img'][$j] = $result[0]['img'];
            }
            $j++;
        }
    }else{
        $datas[$i]['img'] =[];
    }
    
    if($data['video'] != ""){
        $datas[$i]['video'] = explode(",", $data['video']);
        array_pop( $datas[$i]['video']);
        $j = 0;
        foreach($datas[$i]['video'] as $videoid)
        {
            $result = get("technician_video",'ID',$videoid);
            if($result)
            {
                $datas[$i]['video'][$j] = ['src'=>$result[0]['dir'],'play'=>false,'poster'=>$result[0]['poster']];
            }
            $j++;
        }
    }else{
        $datas[$i]['video'] =[];
    }


    // $datas[$i]['img'] = explode(",", $data['img']);
    // //array_pop($datas[$i]['img']);  
    // $j = 0;
    // foreach($datas[$i]['img'] as $imgid)
	// {
    //     $result = get("technician_photo",'ID',$imgid);
    //     if($result)
	// 	{
    //         $datas[$i]['img'][$j] = $result[0]['img'];
    //     }
    //     $j++;
    // }
    $tm1 = $datas[$i]['date'];
    $tm2 = time();
    $gap = $tm2-$tm1;
    //转换成文字表示
    if ($gap < 60) $gap = $gap."秒前";
    else {
        $gap /= 60;
        if ($gap < 60) $gap = floor($gap)."分钟前";
        else {
            $gap /= 60;
            if ($gap < 24) $gap = floor($gap)."小时前";
            else {
                $gap /= 24;
                if ($gap <= 30) $gap = floor($gap)."天前";
                else {
                    $gap /= 30;
                    if ($gap <= 12) $gap = floor($gap)."月前";
                    else {
                        $gap /= 12;
                        if ($gap >= 1) $gap =floor($gap)."年前";
                    }
                }
            }
        }
    }
    $datas[$i]['date']=$gap;
    $i++;
}
$jb = get("technician",'job_number',$job_number);
$head = "";
$background = "";
if(!$jb)
{
    $jb = "";
}
else
{
    $jb = $jb[0];
    if(!is_null($jb['friend_circle_background']))
	{
		$background = $jb['friend_circle_background'];
	}
    if(!is_null($jb['photo']))
	{
		$head = $jb['photo'];
	}
}
echo json_encode(['status'=>1,'data'=>$datas,'head'=>$head,'background'=>$background]);