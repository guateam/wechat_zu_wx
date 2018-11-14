<?php
require("database.php");
$id = $_POST['id'];
$svod = set("consumed_order","order_id",$id,[['show',0]]);
echo json_encode(['status'=>1]);

