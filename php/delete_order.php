<?php
require("database.php");
$order_id = $_POST['order_id'];
sql_str("delete from service_order where order_id='$order_id'");
sql_str("delete from consumed_order where order_id='$order_id'");
echo json_encode(['status'=>1]);