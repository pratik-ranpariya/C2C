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
	$sql = "SELECT count(postrequest.id) FROM postrequest, categories, subcategories WHERE postrequest.posterid='$userid' and postrequest.revoke='N' and categories.id=postrequest.category and subcategories.id=postrequest.scategory and postrequest.status<>'complete'";

	$query=mysqli_query($db,$sql);
	$row = mysqli_fetch_row($query);
 	$requestscount = $row[0];

	$rows = $row[0];
 
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
 	
 	$sql = "SELECT postrequest.id,postrequest.time,postrequest.type,postrequest.date,postrequest.budget,postrequest.posterid,postrequest.description, categories.name as category, subcategories.name as scategory FROM postrequest, categories, subcategories WHERE postrequest.posterid='$userid' and postrequest.revoke='N' and categories.id=postrequest.category and subcategories.id=postrequest.scategory and postrequest.status<>'complete' $limit";

	$result = mysqli_query($db, $sql);
	$requests = mysqli_fetch_all($result,MYSQLI_ASSOC);
	
 	$count = mysqli_num_rows($result);
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


?>