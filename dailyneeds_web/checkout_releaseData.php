<?php

include("v1/config.php");
if(!isset($_SESSION)) 
{ 
    session_start(); 
} 
$orderid = base64_decode($_GET['cc']);
$orderid = mysqli_real_escape_string($db, $orderid);
$sql = "SELECT orders.id,orders.offerid, orders.userid FROM orders,sendoffer WHERE orders.id='$orderid' and sendoffer.id=orders.offerid";
$result = mysqli_query($db, $sql);
$orderData = mysqli_fetch_array($result, MYSQLI_ASSOC);

$orderid = mysqli_real_escape_string($db, $orderData['id']);
$userid = mysqli_real_escape_string($db, $orderData['userid']);

$sql = "UPDATE orders SET payment='cleared' WHERE id='$orderid'";
mysqli_query($db, $sql);

if(mysqli_affected_rows($db)) {
	
	$sql = "INSERT INTO payment (payment_type,userid,orderid) VALUES ('paypal','$userid', '$orderid')";
	mysqli_query($db, $sql);
	if(mysqli_affected_rows($db)) {

		$sql = "INSERT INTO orders_track (orderid,userid,active, new) VALUES ('$orderid','$userid', '1', '1')";
		mysqli_query($db, $sql);
		if(mysqli_affected_rows($db)) {
		}else{
			// echo json_encode(array('error' => 'Y', 'msg' => 'Service Failed'), true);		
		}

	}else{
		// echo json_encode(array('error' => 'Y', 'msg' => 'Service Failed'), true);		
	}

}else{
  // echo json_encode(array('error' => 'Y', 'msg' => 'Service Failed'), true);
}
