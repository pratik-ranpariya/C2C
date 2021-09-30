<?php
	include("v1/config.php");
	if(!isset($_SESSION)) 
	{ 
	    session_start(); 
	} 
	
	$userid = mysqli_real_escape_string($db, $_SESSION['id']);
	$query=mysqli_query($db,"select count(id) from `orders` where buyerid='$userid' and payment='cleared'");
	$row = mysqli_fetch_row($query);
 
	$rows = $row[0];
 	$requestscount = $rows;
	$page_rows = 10;
 
	$last = ceil($rows/$page_rows);
 
	if($last < 1){
		$last = 1;
	}
 
	$pagenum = 1;
 
	if(isset($_GET['pn'])){
		$pagenum = preg_replace('#[^0-9]#', '', $_GET['pn']);
	}
 
	if ($pagenum < 1) { 
		$pagenum = 1; 
	} 
	else if ($pagenum > $last) { 
		$pagenum = $last; 
	}
 
	$limit = 'LIMIT ' .($pagenum - 1) * $page_rows .',' .$page_rows;
 	
 	$sql = "SELECT offerid,serviceid,`date`,id FROM orders WHERE orders.buyerid='$userid' and orders.payment='cleared'";
	$result = mysqli_query($db, $sql);
	$confirmOrder = mysqli_fetch_all($result,MYSQLI_ASSOC);
	$temp = array();
	foreach ($confirmOrder as $value) {
		$date = $value['date'];
		if($value['offerid']){
			$id = mysqli_real_escape_string($db, $value['id']);
			$sql = "SELECT orders.id,sendoffer.comments as description,sendoffer.time,sendoffer.type,sendoffer.budget,categories.name as category,subcategories.name as scategory,user_services.image as profile,user_services.title as title,user_services.id as serviceid FROM sendoffer, orders, categories, subcategories, user_services WHERE orders.buyerid='$userid' and sendoffer.id=orders.offerid and user_services.id=sendoffer.serviceid and categories.id=user_services.category and subcategories.id=user_services.scategory and orders.id='$id' and orders.payment='cleared' $limit";

		 	$requests=mysqli_query($db,$sql);
		 	$requests = mysqli_fetch_array($requests,MYSQLI_ASSOC);

		}else{
			$serviceid = mysqli_real_escape_string($db, $value['serviceid']);
			$id = mysqli_real_escape_string($db, $value['id']);
			$sql = "SELECT orders.id,user_services.description,user_services.price as budget,user_services.time,user_services.type,categories.name as category,subcategories.name as scategory,user_services.image as profile,user_services.title as title,user_services.id as serviceid FROM orders,user_services,categories,subcategories WHERE orders.buyerid='$userid' and user_services.id='$serviceid' and categories.id=user_services.category and subcategories.id=user_services.scategory and orders.id='$id' and orders.payment='cleared' $limit";
			
			
			$requests=mysqli_query($db,$sql);
			$requests = mysqli_fetch_array($requests,MYSQLI_ASSOC);
		}
		array_push($temp, $requests);
	}
 	
 	$count = count($temp);
 	$requests = $temp;
 	$paginationCtrls = '<ul>';
 	if($last != 1){
 
	if ($pagenum > 1) {
        $previous = $pagenum - 1;
		$paginationCtrls .= '<li class="pagination-arrow"><a href="'.$_SERVER['PHP_SELF'].'?pn='.$previous.'" class="btn btn-default"><i class="icon-material-outline-keyboard-arrow-left"></i></a></li>';
 
		for($i = $pagenum-4; $i < $pagenum; $i++){
			if($i > 0){
		        $paginationCtrls .= '<li><a href="'.$_SERVER['PHP_SELF'].'?pn='.$i.'">'.$i.'</a></li>';
			}
	    }
    }
 	
 	$paginationCtrls .= '<li><a href="javascript:;">'.$pagenum.'</a></li>';
 
	for($i = $pagenum+1; $i <= $last; $i++){
		$paginationCtrls .= '<li><a href="'.$_SERVER['PHP_SELF'].'?pn='.$i.'">'.$i.'</a></li>';
		if($i >= $pagenum+4){
			break;
		}
	}
 
    if ($pagenum != $last) {
        $next = $pagenum + 1;
        $paginationCtrls .= ' <li class="pagination-arrow"><a href="'.$_SERVER['PHP_SELF'].'?pn='.$next.'"><i class="icon-material-outline-keyboard-arrow-right"></i></a></li>';
    }
	}