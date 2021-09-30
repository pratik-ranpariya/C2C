<?php
session_start();
include("../v1/config.php");

if($_GET['service']){
	switch ($_GET['service']) {
		case 'unblockuser':
				unblockuser($db);
			break;
		default:
			// code...
			break;
	}
}else{
	echo json_encode(array(), true);
}


function unblockuser($db){
	if($_GET){

		$id = $_GET['id'];
		mysqli_query($db,"UPDATE users SET is_active = '1' WHERE id = '$id' ");
		
	}
}
