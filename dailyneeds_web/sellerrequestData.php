<?php
	include("v1/config.php");
	if(!isset($_SESSION)) 
	{ 
	    session_start(); 
	} 
	if(isset($_GET['sid'])){

		$cid = mysqli_real_escape_string($db, $_GET['sid']);
		$sql = "SELECT * FROM user_services WHERE id = '$cid'";
		$result = mysqli_query($db, $sql);
		$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
	}

	$sql = "SELECT * FROM city";
	$result = mysqli_query($db, $sql);
	$citydata = mysqli_fetch_all($result, MYSQLI_ASSOC);

	$userid = mysqli_real_escape_string($db, $_SESSION['id']);
	
	$postrequestid = mysqli_real_escape_string($db, $_GET['postrequest']);
	
	/*$sql = "SELECT count(postrequest.id) FROM postrequest,sendoffer,categories,subcategories,register WHERE sendoffer.revoke='N' and postrequest.id='$postrequestid' and postrequest.category=categories.id and postrequest.scategory=subcategories.id and register.id=sendoffer.userid";*/

	$sql = "SELECT sendoffer.* FROM sendoffer,orders WHERE sendoffer.revoke='N' and sendoffer.postrequestid='$postrequestid' and orders.offerid<>sendoffer.id GROUP BY sendoffer.id;";

	$query=mysqli_query($db,$sql);
	$row = mysqli_fetch_all($query, MYSQLI_ASSOC);
	$rows = $requestscount = count($row);
 
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
 	
 	// $nquery=mysqli_query($db,"select * from `user_services` where email='$email' $limit");
 	
 	/*$sql = "SELECT postrequest.id,postrequest.posterid,sendoffer.userid,sendoffer.id as offerid,sendoffer.comments as description,sendoffer.serviceid,sendoffer.budget,sendoffer.time,sendoffer.type,sendoffer.date,categories.name as category,subcategories.name as scategory, register.username,register.profile as sellerProfile, register.id as sellerid FROM postrequest,sendoffer,categories,subcategories,register WHERE sendoffer.revoke='N' and postrequest.id='$postrequestid' and postrequest.category=categories.id and postrequest.scategory=subcategories.id and register.id=sendoffer.userid $limit";*/

 	$sql = "SELECT postrequest.id,postrequest.posterid,sendoffer.userid,sendoffer.id as offerid,sendoffer.comments as description,sendoffer.serviceid,sendoffer.budget,sendoffer.time,sendoffer.type,sendoffer.date,categories.name as category,subcategories.name as scategory, register.username,register.profile as sellerProfile, register.id as sellerid FROM postrequest,sendoffer,categories,subcategories,register,orders WHERE sendoffer.revoke='N' and sendoffer.postrequestid='$postrequestid' and postrequest.id='$postrequestid' and postrequest.category=categories.id and postrequest.scategory=subcategories.id and orders.offerid<>sendoffer.id and register.id=sendoffer.userid GROUP BY sendoffer.id $limit";

	$result = mysqli_query($db, $sql);
	$requests = mysqli_fetch_all($result,MYSQLI_ASSOC);
	$count = mysqli_num_rows($result);
 	
 	$paginationCtrls = '<ul>';
 	if($last != 1){
 
	if ($pagenum > 1) {
        $previous = $pagenum - 1;
		$paginationCtrls .= '<li class="pagination-arrow"><a href="'.$_SERVER['PHP_SELF'].'?postrequest='.$postrequestid.'&pn='.$previous.'" class="btn btn-default"><i class="icon-material-outline-keyboard-arrow-left"></i></a></li>';
 
		for($i = $pagenum-4; $i < $pagenum; $i++){
			if($i > 0){
		        $paginationCtrls .= '<li><a href="'.$_SERVER['PHP_SELF'].'?postrequest='.$postrequestid.'&pn='.$i.'">'.$i.'</a></li>';
			}
	    }
    }
 	
 	$paginationCtrls .= '<li><a href="javascript:;">'.$pagenum.'</a></li>';
 
	for($i = $pagenum+1; $i <= $last; $i++){
		$paginationCtrls .= '<li><a href="'.$_SERVER['PHP_SELF'].'?postrequest='.$postrequestid.'&pn='.$i.'">'.$i.'</a></li>';
		if($i >= $pagenum+4){
			break;
		}
	}
 
    if ($pagenum != $last) {
        $next = $pagenum + 1;
        $paginationCtrls .= ' <li class="pagination-arrow"><a href="'.$_SERVER['PHP_SELF'].'?postrequest='.$postrequestid.'&pn='.$next.'"><i class="icon-material-outline-keyboard-arrow-right"></i></a></li>';
    }
	}