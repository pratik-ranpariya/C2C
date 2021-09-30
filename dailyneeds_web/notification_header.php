<?php
 	
 	if(!isset($db)){
		include("v1/config.php");
 	}
	if(!isset($_SESSION)) 
	{ 
	    session_start(); 
	}
	if(isset($_SESSION['id'])){

		$userid = mysqli_real_escape_string($db, $_SESSION['id']);
		$sql = "SELECT * FROM notification WHERE userid = '$userid'";
		$result = mysqli_query($db, $sql);
		$notification = mysqli_fetch_all($result,MYSQLI_ASSOC);
	}