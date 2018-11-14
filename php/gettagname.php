<?php
require('database.php');
$tags = sql_str("select * from rate_tag");
if($tags){
    for($i=0;$i<count($tags);$i++){
        $tags[$i] = array_merge($tags[$i],['check'=>false]);
    }
    echo json_encode(['status'=>1,'data'=>$tags]);
    exit();
}
echo json_encode(['status'=>0]);