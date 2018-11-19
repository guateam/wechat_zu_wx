<?php
function getnotice($id)
{
    $notice=get('notice');
    $data=[];
    foreach($notice as $value)
	{
        $item=[
            'text'=>$value['text'],
            'title'=>$value['title']
        ];
        array_push($data,$item);
    }
    return ['status'=>1,'data'=>$data];
}