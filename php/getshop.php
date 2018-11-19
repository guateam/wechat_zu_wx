<?php
function getshop($id){
    $shop=get('shop');
    $id = 1;
    $photos = get("shop_photo","shop_id",$id);


    return [
        'status'=>1,
        'data'=>[
            'name'=>$shop[0]['name'],
            'position'=>$shop[0]['position'],
            'location'=>'../html/map.html?location='.$shop[0]['position'],
            'open_time'=>$shop[0]['open_time'],
            'close_time'=>$shop[0]['close_time'],
            'phone'=>$shop[0]['phone'],
            'ip_adress'=>$shop[0]['ip_address'],
            'photo'=>$photos
            ]
        ];
}