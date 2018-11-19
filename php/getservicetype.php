<?php
function getservicetype($id)
{
    $servicetype=get('service_type');
    $data=[];
    foreach($servicetype as $value)
	{
        $item=[
            'id'=>$value['ID'],
            'procedure'=>$value['procedure'],
            'attention'=>$value['attention'],
            'benefit'=>$value['benefit'],
            'name'=>$value['name'],
            'time'=>$value['duration'],
            'price'=>$value['price']/100.0,
            'img'=>$value['image']
        ];
        array_push($data,$item);
    }
    return ['status'=>1,'data'=>$data];
}