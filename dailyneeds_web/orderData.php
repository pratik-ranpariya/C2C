<?php
 
	include("v1/config.php");
	if(!isset($_SESSION)) 
	{ 
	    session_start(); 
	}
	$orderInfo = array('active' => array(), 'completed' => array(), 'cancelled' => array(), 'new' => array(), 'delivered' => array(), 'late' => array());

	$userid = mysqli_real_escape_string($db, $_SESSION['id']);
	$sql = "SELECT orders_track.active, orders_track.late, orders_track.completed, orders_track.cancelled, orders_track.new, orders_track.delivered, orders.serviceid, orders.date, orders.offerid, orders.id FROM orders_track,orders WHERE orders.id=orders_track.orderid and orders_track.userid='$userid' GROUP BY orderid";
	$result = mysqli_query($db, $sql);
	$orders_tracks = mysqli_fetch_all($result, MYSQLI_ASSOC);
	
	if($orders_tracks != null && count($orders_tracks)){
		foreach ($orders_tracks as $value) {
			if((int)$value['offerid']){
				$offerid = mysqli_real_escape_string($db, $value['offerid']);
				$sql = "SELECT sendoffer.serviceid,user_services.title, sendoffer.time as deliverytime,sendoffer.type as timetype FROM sendoffer, user_services WHERE sendoffer.id='$offerid' and user_services.id=sendoffer.serviceid";
				$result = mysqli_query($db, $sql);
				$temp = mysqli_fetch_array($result, MYSQLI_ASSOC);

			}else if((int)$value['serviceid']){
				$serviceid = mysqli_real_escape_string($db, $value['serviceid']);
				$sql = "SELECT user_services.id as serviceid,user_services.title, user_services.time as deliverytime,user_services.type as timetype FROM user_services WHERE user_services.id='$serviceid'";
				$result = mysqli_query($db, $sql);
				$temp = mysqli_fetch_array($result, MYSQLI_ASSOC);
			}

			if($temp != null){

				
				if($temp['timetype'] == 'd'){
					$orderTime = "+".$temp['deliverytime']." days";
				}else if($temp['timetype'] == 'h'){
					$orderTime = "+".$temp['deliverytime']." hours";
				}else if($temp['timetype'] == 'm'){
					$orderTime = "+".$temp['deliverytime']." months";
				}
				if(strlen($orderTime)){

					$temp['delivery_date'] = date("d M Y H:i:s", strtotime($orderTime, strtotime(date($value['date']))));
					$temp['date'] = date_format(date_create($value['date']),"d M Y H:i:s");
					$temp['id'] = $value['id'];
					if((int)$value['active']){
						array_push($orderInfo['active'], $temp);
					}
					if((int)$value['completed']){
						array_push($orderInfo['completed'], $temp);
					}
					if((int)$value['cancelled']){
						array_push($orderInfo['cancelled'], $temp);
					}
					if((int)$value['new']){
						array_push($orderInfo['new'], $temp);
					}
					if((int)$value['delivered']){
						array_push($orderInfo['delivered'], $temp);
					}
					if((int)$value['delivered']){
						array_push($orderInfo['delivered'], $temp);
					}
				}
			}
		}
	}

	

