<?php
if(isset($_POST['ajax_call'])){
    require('database.php');
    $id = $_POST['id'];
    $data = gettechnician($id);
    echo json_encode(['status'=>1,'data'=>$data]);
}

function gettechnician($id,$tm="")
{
    $technician=get('technician','job_number',$id);

    if($technician)
	{
        $rate = sql_str("select Avg(score) as score from rate where job_number = '$id'");
       
        $technician=$technician[0];

        $skill='';
        $skilllist=[];
        $skills=get('skill','job_number',$id);
		
        foreach($skills as $value)
		{
            $service=get('service_type','ID',$value['service_id']);
            if($service)
			{
                $skill.=$service[0]['name'].' ';
                array_push($skilllist,['name'=>$service[0]['name'],'id'=>$service[0]['ID']]);
            }
        }
        $service=get('service_order','job_number',$id);
        $photo=sql_str("select A.img from technician_photo A where A.job_number = '$id' order by A.ID desc limit 4");
        // $photodata=[];
        // if(count($photo)>=4)
		// {
        //     for($i=0;$i<4;$i++)
		// 	{
        //         array_push($photodata,$photo[$i]['img']);
        //     }
        // }
		// else
		// {
        //     foreach($photo as $value)
		// 	{
        //         array_push($photodata,$value['img']);
        //     }
        // }
        
        $entrytime='';
        $date=(time()-$technician['entry_date']);
        if($date>365*24*60*60)
		{
            $entrytime=round($date/(365*24*60*60),1).'年';
        }
		else if($date>(30*24*60*60))
		{
            $entrytime=round($date/(30*24*60*60),1).'月';
        }
		else if($date>24*60*60)
		{
            $entrytime=round($date/(24*60*60)).'天';
        }
		else
		{
            $entrytime='新人';
        }
        $gender='';
        if($technician['gender']==1)
		{
            $gender='他';
        }
		else if($technician['gender']==2)
		{
            $gender='她';
        }
        $data=[
            'name'=>$technician['name'],
            'description'=>$technician['description'],
            'jobnumber'=>$id,
            'head'=>$technician['photo'],
            'rate'=>$rate[0],
            'skill'=>$skill,
            'service'=>count($service),
            'photo'=>$photo,
            'favoate'=>0,
            'entrytime'=>$entrytime,
            'entrydate'=>date("Y-m-d",$technician['entry_date']),
            'in_job'=>$technician['in_job'],
            'skills'=>$skilllist,
            'gender'=>$gender,
            'vcr'=>$technician['vcr'],
            'level'=>$technician['level'],
//            'busy'=>$busy
        ];
        return $data;
    }
}