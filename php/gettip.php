<?php
require("database.php");
$open_id = $_POST['open_id'];
$result = sql_str("select * from tip where `user_id` = '$open_id'");
echo json_encode(['status'=>1,'data'=>$result]);