<?php
 
	include("v1/config.php");
 	$scode = (isset($_GET['scode'])) ? $_GET['scode'] : 0;
 	$cid = (isset($_GET['cid'])) ? $_GET['cid'] : 0;
 	$code = (isset($_GET['code'])) ? $_GET['code'] : 0;
 	if(!isset($_SESSION)) 
	{ 
	    session_start(); 
	}
	if(isset($_SESSION['id'])){

		$userid = mysqli_real_escape_string($db, $_SESSION['id']);
	 	if($code > 0){
	 		$query=mysqli_query($db,"select count(email) from `user_services` where category='$code' and userid<>'$userid'");
	 		if($cid > 0){
				$query=mysqli_query($db,"select count(email) from `user_services` where category='$code' and city='$cid' and userid<>'$userid'");
			}
	 		if($scode > 0){
	 			$query=mysqli_query($db,"select count(email) from `user_services` where category='$code' and scategory='$scode' and userid<>'$userid'");
	 			if($cid > 0){
	 				$query=mysqli_query($db,"select count(email) from `user_services` where category='$code' and scategory='$scode' and city='$cid' and userid<>'$userid'");
	 			}
	 		}

	 	}else{
	 		$query=mysqli_query($db,"select count(email) from `user_services` WHERE userid<>'$userid'");
	 	}
	}else{
		if($code > 0){
	 		$query=mysqli_query($db,"select count(email) from `user_services` where category='$code'");
	 		if($cid > 0){
				$query=mysqli_query($db,"select count(email) from `user_services` where category='$code' and city='$cid'");
			}
	 		if($scode > 0){
	 			$query=mysqli_query($db,"select count(email) from `user_services` where category='$code' and scategory='$scode'");
	 			if($cid > 0){
	 				$query=mysqli_query($db,"select count(email) from `user_services` where category='$code' and scategory='$scode' and city='$cid'");
	 			}
	 		}

	 	}else{
	 		$query=mysqli_query($db,"select count(email) from `user_services`");
	 	}
	}
	$row = mysqli_fetch_row($query);
 
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
 	
 	if(isset($_SESSION['id'])){
 		$userid = mysqli_real_escape_string($db, $_SESSION['id']);
	 	if($code > 0){
			$nquery=mysqli_query($db,"select * from `user_services` where category='$code' and userid<>'$userid' $limit");
			if($cid > 0){
				$nquery=mysqli_query($db,"select * from `user_services` where category='$code' and city='$cid' and userid<>'$userid' $limit");
			}
			if($scode > 0){
				$nquery=mysqli_query($db,"select * from `user_services` where category='$code' and scategory='$scode' and userid<>'$userid' $limit");
				if($cid > 0){
					$nquery=mysqli_query($db,"select * from `user_services` where category='$code' and scategory='$scode' and city='$cid' and userid<>'$userid' $limit");
				}
			}
	 	}else{
	 		$nquery=mysqli_query($db,"select * from `user_services` WHERE userid<>'$userid' $limit");
	 	}

	 }else{
	 	if($code > 0){
			$nquery=mysqli_query($db,"select * from `user_services` where category='$code'  $limit");
			if($cid > 0){
				$nquery=mysqli_query($db,"select * from `user_services` where category='$code' and city='$cid' $limit");
			}
			if($scode > 0){
				$nquery=mysqli_query($db,"select * from `user_services` where category='$code' and scategory='$scode' $limit");
				if($cid > 0){
					$nquery=mysqli_query($db,"select * from `user_services` where category='$code' and scategory='$scode' and city='$cid' $limit");
				}
			}
	 	}else{
	 		$nquery=mysqli_query($db,"select * from `user_services` $limit");
	 	}
	 	
	 }

 	$count = mysqli_num_rows($nquery);
 	$paginationCtrls = '<ul>';
 	if($last != 1){
 
	if ($pagenum > 1) {
        $previous = $pagenum - 1;
		$paginationCtrls .= '<li class="pagination-arrow"><a href="'.$_SERVER['PHP_SELF'].'?code='.$_GET["code"].'&scode='.$scode.'&pn='.$previous.'" class="btn btn-default"><i class="icon-material-outline-keyboard-arrow-left"></i></a></li>';
 
		for($i = $pagenum-4; $i < $pagenum; $i++){
			if($i > 0){
		        $paginationCtrls .= '<li><a href="'.$_SERVER['PHP_SELF'].'?code='.$_GET["code"].'&scode='.$scode.'&pn='.$i.'">'.$i.'</a></li>';
			}
	    }
    }
 	
 	$paginationCtrls .= '<li><a href="javascript:;">'.$pagenum.'</a></li>';
 
	for($i = $pagenum+1; $i <= $last; $i++){
		$paginationCtrls .= '<li><a href="'.$_SERVER['PHP_SELF'].'?code='.$_GET["code"].'&scode='.$scode.'&pn='.$i.'">'.$i.'</a></li>';
		if($i >= $pagenum+4){
			break;
		}
	}
 
    if ($pagenum != $last) {
        $next = $pagenum + 1;
        $paginationCtrls .= ' <li class="pagination-arrow"><a href="'.$_SERVER['PHP_SELF'].'?code='.$_GET["code"].'&scode='.$scode.'&pn='.$next.'"><i class="icon-material-outline-keyboard-arrow-right"></i></a></li>';
    }
	}

	$sql = "SELECT name FROM categories WHERE id='$code'";
	$result = mysqli_query($db, $sql);
	$categoriesData = mysqli_fetch_all($result, MYSQLI_ASSOC)[0];

	$sql = "SELECT * FROM subcategories WHERE category='$code'";
 $result = mysqli_query($db, $sql);
 $categoryData = mysqli_fetch_all($result, MYSQLI_ASSOC);
 	
 	if($scode){
  $sql = "SELECT name FROM subcategories WHERE id='$scode'";
 $result = mysqli_query($db, $sql);
 $subcategoriesData = mysqli_fetch_all($result, MYSQLI_ASSOC)[0];
 // print_r($subcategoriesData);die;
 }
?>