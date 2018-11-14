<?php
require "database.php";
$openid=$_POST['openid'];
$user=get('customer','openid',$openid);

if($user)
{
    $user=$user[0];
    $data=[
        'phone'=>$user['phone_number'],
        'head'=>$user['head']
    ];
    echo(json_encode(['status'=>1,'data'=>$data]));
}
else
{
    echo(json_encode(['status'=>0]));
}