<?php
function getdiscount($id)
{
    $servicetype=get('service_type');
    $data=[];
    foreach($servicetype as $value)
	{
            $item=[
                'name'=>$value['name'],
                'price'=>$value['price']/100.0,
            ];
            array_push($data,$item);
    }
    return ['status'=>1,'data'=>$data];
}