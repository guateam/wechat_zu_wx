<?php
function getfeedback($id)
{
    $rate=sql_str("select A.score,A.comment,A.time,B.head,B.name from rate A,customer B where A.`job_number`='$id' and A.bad=1 and A.customer_id=B.openid");
    // $serivce = sql_str("select * from service_order WHERE (`job_number` = '$id') ORDER BY `ID` DESC");//get('service_order', 'job_number', $id);
    // $data = [];
    // foreach ($serivce as $value) 
	// {    
    //     $odid = $value['order_id'];
    //     $svid = $value['item_id'];
    //     $rates = sql_str("select * from rate where `order_id` = '$odid' and `job_number` = '$id' and `bad` = 1 and `service_id` = '$svid' ");
    //     // get('rate', 'order_id', $value['order_id']);
    //     foreach($rates as $rate) 
	// 	{
    //         $odid = $value['order_id'];
    //         $user = sql_str("select A.name, A.head from customer A,consumed_order B where A.ID = B.user_id and B.order_id ='$odid' limit 1");
    //         // $order = get('consumed_order', 'order_id', $value['order_id']);
    //         // if ($order) 
	// 		// {
    //         //     $order = $order[0];
    //         if ($user) 
	// 	    {
    //                 $user = $user[0];
    //                 $head = '../photo/defult.jpg';
    //                 if ($user['head'] != '') 
	// 	    		{
    //                     $head = $user['head'];
    //                 }
    //                 $price = 0;
    //                 if ($value['service_type'] == 1) 
	// 	    		{
    //                     $serivcetype = get('service_type', 'ID', $rate['service_id']);
    //                     if ($serivcetype) 
	// 	    			{
    //                         $price = $serivcetype[0]['price'];
    //                     }
    //                 } 
	// 	    		else if ($value['servicetype'] == 2) 
	// 	    		{
    //                     $serivcetype = get('item_type', 'ID', $rate['service_id']);
    //                     if ($serivcetype) 
	// 	    			{
    //                         $price = $serivcetype[0]['price'];
    //                     }
    //                 } 
	// 	    		else 
	// 	    		{
    //                     $price = $value['price'];
    //                 }

    //                 $item = [
    //                     'name' => $user['name'],
    //                     'head' => $head,
    //                     'rate' => $rate['score'],
    //                     'time' => date("Y-m-d",$rate['time']),
    //                     'text' => $rate['comment'],
    //                     'serviceid' => $value['order_id'],
    //                     'price' => $price,
    //                 ];
    //                 array_push($data, $item);
    //         }
    //         //}
    //     }
    // }
    return $rate;
}
