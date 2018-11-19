<?php
require "database.php";
require "getdiscount.php";
require "getservicetype.php";
require "getnotice.php";
require "getshop.php";
$id = $_POST['id'];
$pic = sql_str("select A.dir AS url,B.dir AS dir from shop_photo A, service_type B where A.shop_id = 1 and (B.ID = A.theme)");
$npic = sql_str("select A.dir AS url from shop_photo A where A.shop_id = 1 and 0= A.theme");
for($i=0;$i<count($npic);$i++){
    $npic[$i] = array_merge($npic[$i],['dir'=>'qiyewenhua.html']);
}
$pic = array_merge($pic,$npic);
echo (json_encode(['status' => 1,'top_pic'=>$pic,'data'=>['app1' => getdiscount($id), 'app2' => getservicetype($id), 'shop' => getshop($id), 'notice' => getnotice($id)]]));
