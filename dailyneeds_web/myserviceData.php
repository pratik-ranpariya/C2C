<?php
 
	include("v1/config.php");
	if(!isset($_SESSION)) 
	{ 
	    session_start(); 
	} 
	$email = mysqli_real_escape_string($db, $_SESSION['email']);
	$query=mysqli_query($db,"select count(email) from `user_services` where email='$email'");
	$row = mysqli_fetch_row($query);
 
	$rows = $row[0];
 
	$page_rows = 4;
 
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
 	
 	$nquery=mysqli_query($db,"select * from `user_services` where email='$email' $limit");

 	$count = mysqli_num_rows($nquery);
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