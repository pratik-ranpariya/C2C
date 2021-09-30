<?php

include("v1/config.php");
if(!isset($_SESSION)) 
{ 
    session_start(); 
} 

$orderid = base64_decode($_GET['cc']);

$orderid = mysqli_real_escape_string($db, $orderid);
// $sql = "SELECT sendoffer.budget FROM orders,sendoffer WHERE orders.id='$orderid' and sendoffer.id=orders.offerid";

$sql = "SELECT offerid,serviceid FROM orders WHERE orders.id='$orderid'";
$result = mysqli_query($db, $sql);
$data = mysqli_fetch_array($result, MYSQLI_ASSOC);

if($data['offerid']){
	$offerid = mysqli_real_escape_string($db, $data['offerid']);
	$sql = "SELECT budget, userid FROM sendoffer WHERE id='$offerid'";
	$result = mysqli_query($db, $sql);
	$data = mysqli_fetch_array($result, MYSQLI_ASSOC);	
}else{
	$serviceid = mysqli_real_escape_string($db, $data['serviceid']);
	$sql = "SELECT price as budget, userid FROM user_services WHERE id='$serviceid'";
	$result = mysqli_query($db, $sql);
	$data = mysqli_fetch_array($result, MYSQLI_ASSOC);	
}

