<?php
header('Access-Control-Allow-Origin: *');
include("v1/config.php");

if($_GET['service']){
	switch ($_GET['service']) {
		
		case 'updatemydata':
				UpdateMyData($db);
			break;
		
		default:
			// code...
			break;
	}
}else{
	echo json_encode(array(), true);
}




function UpdateMyData($db){

	if(!isset($_SESSION)) 
	{
		session_start();
	}
	if(isset($_SESSION['id'])){

		$id = mysqli_real_escape_string($db, $_SESSION['id']);
	}
	else{
		$id= mysqli_real_escape_string($db,$_POST['userid']);
	}


	if(isset($_SESSION['email'])){
		$email = mysqli_real_escape_string($db, $_SESSION['email']);
	}else{
		$email = mysqli_real_escape_string($db, $_POST['email']);
	}

	$sql = "SELECT id FROM register WHERE id = '".$id."'";
	$result = mysqli_query($db, $sql);
	$row = mysqli_fetch_array($result,MYSQLI_ASSOC);

	$sql = "SELECT id FROM register WHERE email = '".$email."'";
	$result1 = mysqli_query($db, $sql);
	$row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC);

    $count1 = mysqli_num_rows($result1);


	if($count1){
		echo json_encode(array('error' => 'Y', 'msg' => 'Email ID already present into system', 'data' => $_POST), true);
	}else {
		$update = "";
       
		if($_POST['email'] != ''){
			$email = mysqli_real_escape_string($db, $_POST['email']);
			if(strlen($update) > 2){
				$update .= ", email = '$email', emailverified= 'YES'";
				// $update .= ", emailverified= 'YES'";
			}else{
				$update .= "email='$email', emailverified= 'YES'";
			}
		}
	} 

	$sql = "UPDATE register SET ".$update." WHERE id='".$id."'";
	mysqli_query($db, $sql);
	if(mysqli_affected_rows($db)) {
		echo json_encode(array('error' => 'N', 'msg' => 'Profile Update Sucessfully'), true);
	}else{
		echo json_encode(array('error' => 'N', 'msg' => 'Profile Update Failed'), true);
	}
}

?>