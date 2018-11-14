<?php
require("database.php");
$order_id = $_POST['id'];
$str = "SELECT
rate.order_id,
rate.score,
rate.`comment`,
service_order.job_number,
consumed_order.generated_time,
service_type.`name`
FROM
rate
INNER JOIN consumed_order ON rate.order_id = consumed_order.order_id
INNER JOIN service_order ON rate.service_id = service_order.item_id AND rate.order_id = service_order.order_id
INNER JOIN service_type ON service_order.item_id = service_type.ID
WHERE rate.`order_id` = '$order_id'
";

$rates = sql_str($str);
$this_rate = [];

if($rates)
{
    echo json_encode(['status'=>1,'data'=>$rates]);
}
else
{
    echo json_encode(['status'=>0]);
}
