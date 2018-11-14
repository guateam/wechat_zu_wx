<?php
function getdiscount($id)
{
    $servicetype=get('service_type');
    $data=[];
    foreach($servicetype as $value)
	{
        if($value['discount']<100)
		{
            $item=[
                'name'=>$value['name'],
                'price'=>$value['price']/100.0,
                'discount'=>$value['price']*$value['discount']/10000.0
            ];
            array_push($data,$item);
        }
    }
    return ['status'=>1,'data'=>$data];
}