	<?php
include("../config.php");

if($_GET['service']){
	switch ($_GET['service']) {
		case 'register':
				Register($db);
			break;
		case 'login':
				Login($db);
			break;
		case 'forgetPassword':
				forgetPassword($db);
			break;
		default:
			// code...
			break;
	}
}else{
	echo json_encode(array(), true);
}

// function Register($db)
// {
// 	  //print_r($_FILES)
// 	if(isset($_FILES["file"]["type"]) || $_FILES["file"]["type"]==""){
		
// 		$validextensions = array(
// 			"jpeg",
// 			"jpg",
// 			"png",
// 			"JPG",
// 			"PNG"
// 		);
// 		$temporary = explode(".", $_FILES["file"]["name"]);

// 		$file_extension = end($temporary);
// 		if (($_FILES["file"]["size"] < 8000000) || $_FILES["file"]["size"]==0){
// 			$fileName = 'profile_'.time().'.'.$file_extension;
// 					$sourcePath = $_FILES['file']['tmp_name']; // Storing source path of the file in a variable
// 					$targetPath = "../images/upload/".$fileName; // Target path where file is to be stored
// 					move_uploaded_file($sourcePath, $targetPath); // Moving Uploaded file
					
// 						  /*if($_POST['firebaseid'] == ''){
// 						  	echo json_encode(array('error' => 'Y', 'msg' => 'firebaseid not found on requested data'), true);
// 						  	return true;
// 						  }*/

// 						  if($_POST['username'] == ''){
// 						  	echo json_encode(array('error' => 'Y', 'msg' => 'user not found on requested data', 'data' => $_POST), true);
// 						  	return true;
// 						  }

// 						  if($_POST["email"] == ''){
// 						  	echo json_encode(array('error' => 'Y', 'msg' => 'email address not valid on requested data', 'data' => $_POST), true);
// 						  	return true;
// 						  }

// 						  if($_POST['password'] == ''){
// 						  	echo json_encode(array('error' => 'Y', 'msg' => 'password not found on requested data', 'data' => $_POST), true);
// 						  	return true;
// 						  }

// 						  if($_POST['mobile'] == ''){
// 						  	echo json_encode(array('error' => 'Y', 'msg' => 'mobile not found on requested data', 'data' => $_POST), true);
// 						  	return true;
// 						  }

// 						  if($_POST['city'] == ''){
// 						  	echo json_encode(array('error' => 'Y', 'msg' => 'city not found on requested data', 'data' => $_POST), true);
// 						  	return true;
// 						  }						  

// 						  $email = mysqli_real_escape_string($db, $_POST['email']);
// 						  $mobile = mysqli_real_escape_string($db, $_POST['mobile']); 

// 						  $sql = "SELECT id FROM register WHERE email = '$email'";
// 						  $result = mysqli_query($db, $sql);
// 						  $row = mysqli_fetch_array($result,MYSQLI_ASSOC);

// 						  $count = mysqli_num_rows($result);

// 						  $sql1 = "SELECT id FROM register WHERE mobile='$mobile'";
// 						  $result1 = mysqli_query($db, $sql1);
// 						  $row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC);

// 						  $count1 = mysqli_num_rows($result1);

// 						  if($count){
// 						  	echo json_encode(array('error' => 'Y', 'msg' => 'Email ID already present into system', 'data' => $_POST), true);
// 						  }else if($count1){
// 						  	echo json_encode(array('error' => 'Y', 'msg' => 'Mobile Number already present into system', 'data' => $_POST['mobile']), true);
// 						  }else {			
// 						  	$firebaseid = (isset($_POST['firebaseid'])) ? $_POST['firebaseid'] : '';
// 						  	$firebaseid = mysqli_real_escape_string($db, $firebaseid);
// 						  	$username = mysqli_real_escape_string($db, $_POST['username']);
// 						  	$email = mysqli_real_escape_string($db, $_POST['email']);
// 						  	$mobile = mysqli_real_escape_string($db, $_POST['mobile']); 
// 						  	$city = mysqli_real_escape_string($db, $_POST['city']); 
// 						  	$password = mysqli_real_escape_string($db, $_POST['password']);

// 						  	$sql = "INSERT INTO register (firebaseid, username, email, mobile, city, password, profile) VALUES ('$firebaseid','$username','$email','$mobile','$city','$password', '$fileName')";
// 						  	mysqli_query($db, $sql);

// 						  	if(mysqli_affected_rows($db)) {

// 						  		$sql = "SELECT * FROM register WHERE email = '$email'";
// 						  		$result = mysqli_query($db, $sql);
// 						  		$row = mysqli_fetch_array($result,MYSQLI_ASSOC);

// 						  	session_start();
// 						  	$_SESSION['username'] = $username;
// 						  	$_SESSION['id'] = $row['id'];
// 						  	$_SESSION['profile'] = ($fileName != '') ? URL.'../images/upload/'.$fileName  : URL.'/images/user-avatar-placeholder.png';
// 						  	$_SESSION['logged_in'] = 'Y';
// 						  	$_SESSION['email'] = $_POST['email'];
// 						  	$_SESSION['status'] = 'user-online';

// 						  		$userid = mysqli_real_escape_string($db, $row['id']);
// 						  		$sql = "INSERT INTO balance (userid) VALUES ('$userid')";
// 						  		mysqli_query($db, $sql);

// 						  		$profile = ($fileName != '') ? URL.'../images/upload/'.$fileName  : URL.'/images/user-avatar-placeholder.png';
// 						  		echo json_encode(array('error' => 'N', 'msg' => 'Sucessfull Register of User', 'data' => array('id' => $row['id'], 'username' => $row['username'], 'email' => $row['email'], 'profile' => $profile, 'balance' => 0)), true);

// 									$to = $_POST['email'];
// 									$subject = "thanks for register";
// 									$txt = "Hello world!";
// 									$headers = "From: pratikranpariya123@gmail.com" . "\r\n" .
// 									"CC: somebodyelse@example.com";

// 									mail($to,$subject,$txt,$headers);


// 						  	}else{
// 						  		echo json_encode(array('error' => 'Y', 'msg' => 'unSucessfull Register of User', 'data' => $_POST), true);
// 						  	}
// 						  }


// 						}else{
// 							echo json_encode(array('error' => 'Y', 'msg' => 'Enable to Upload File Size Exceed', 'data' => $_POST), true);
// 						}
// 					}
// 				}
function Register($db){
	  //print_r($_FILES)
	if(isset($_FILES["file"]["type"]) || $_FILES["file"]["type"]==""){
		
		$validextensions = array(
			"jpeg",
			"jpg",
			"png",
			"JPG",
			"PNG"
		);
		$temporary = explode(".", $_FILES["file"]["name"]);

		$file_extension = end($temporary);
		
        
		if (($_FILES["file"]["size"] < 8000000) || $_FILES["file"]["size"]==0){
		 	 		$fileName = 'profile_'.time().'.'.$file_extension;
					$sourcePath = $_FILES['file']['tmp_name']; // Storing source path of the file in a variable
					$targetPath = "../../images/upload/".$fileName; // Target path where file is to be stored
					move_uploaded_file($sourcePath, $targetPath); // Moving Uploaded file
					
					
						
						  /*if($_POST['firebaseid'] == ''){
						  	echo json_encode(array('error' => 'Y', 'msg' => 'firebaseid not found on requested data'), true);
						  	return true;
						  }*/

						  if($_POST['username'] == ''){
						  	echo json_encode(array('error' => 'Y', 'msg' => 'user not found on requested data', 'data' => $_POST), true);
						  	return true;
						  }

						  if($_POST["email"] == ''){
						  	echo json_encode(array('error' => 'Y', 'msg' => 'email address not valid on requested data', 'data' => $_POST), true);
						  	return true;
						  }

						  if($_POST['password'] == ''){
						  	echo json_encode(array('error' => 'Y', 'msg' => 'password not found on requested data', 'data' => $_POST), true);
						  	return true;
						  }

							if($_POST['mobile'] == ''){
						  	echo json_encode(array('error' => 'Y', 'msg' => 'mobile not found on requested data', 'data' => $_POST), true);
						  	return true;
						  }

						  if($_POST['city'] == ''){
						  	echo json_encode(array('error' => 'Y', 'msg' => 'city not found on requested data', 'data' => $_POST), true);
						  	return true;
						  }						  

							$email = mysqli_real_escape_string($db, $_POST['email']);
							$mobile = mysqli_real_escape_string($db, $_POST['mobile']); 

							$sql = "SELECT id FROM register WHERE email = '$email'";
							$result = mysqli_query($db, $sql);
							$row = mysqli_fetch_array($result,MYSQLI_ASSOC);

							$count = mysqli_num_rows($result);

							$sql1 = "SELECT id FROM register WHERE mobile='$mobile'";
							$result1 = mysqli_query($db, $sql1);
							$row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC);

							$count1 = mysqli_num_rows($result1);

							if($count){
							      echo json_encode(array('error' => 'Y', 'msg' => 'Email ID already present into system', 'data' => $_POST), true);
							}else if($count1){
							      echo json_encode(array('error' => 'Y', 'msg' => 'Mobile Number already present into system', 'data' => $_POST['mobile']), true);
							}else {			
									$firebaseid = (isset($_POST['firebaseid'])) ? $_POST['firebaseid'] : '';
							    $firebaseid = mysqli_real_escape_string($db, $firebaseid);
							    $username = mysqli_real_escape_string($db, $_POST['username']);
							    $email = mysqli_real_escape_string($db, $_POST['email']);
							    $mobile = mysqli_real_escape_string($db, $_POST['mobile']); 
							    $city = mysqli_real_escape_string($db, $_POST['city']); 
							    $password = mysqli_real_escape_string($db, $_POST['password']);

							    $sql = "INSERT INTO register (firebaseid, username, email, mobile, city, password, profile) VALUES ('$firebaseid','$username','$email','$mobile','$city','$password', '$fileName')";
						     	mysqli_query($db, $sql);

						     	if(mysqli_affected_rows($db)) {
						     		
						     		$sql = "SELECT * FROM register WHERE email = '$email'";
										$result = mysqli_query($db, $sql);
										$row = mysqli_fetch_array($result,MYSQLI_ASSOC);

										session_start();
				    				$_SESSION['username'] = $username;
									$_SESSION['id'] = $row['id'];
									// $_SESSION['profile'] == '' ? $_SESSION['profile'] : 'images/user-avatar-placeholder.png';
									$_SESSION['profile'] = ($fileName != '') ? URL.'/images/upload/'.$fileName  : URL.'/images/user-avatar-placeholder.png';
									$_SESSION['logged_in'] = 'Y';
									$_SESSION['email'] = $_POST['email'];
									$_SESSION['status'] = 'user-online';
										
										$userid = mysqli_real_escape_string($db, $row['id']);
										$sql = "INSERT INTO balance (userid) VALUES ('$userid')";
						     		mysqli_query($db, $sql);

										$profile = ($fileName != '') ? URL.'/images/upload/'.$fileName.$file_extension  : URL.'/images/user-avatar-placeholder.png';
						     		//$profile = ($_SESSION['profile'] == '') ? $_SESSION['profile'] : 'images/user-avatar-placeholder.png';
											echo json_encode(array('error' => 'N', 'msg' => 'Sucessfull Register of User', 'data' => array('id' => $row['id'], 'username' => $row['username'], 'email' => $row['email'], 'profile' => $profile, 'balance' => 0)), true);
								
					        }else{
					          echo json_encode(array('error' => 'Y', 'msg' => 'unSucessfull Register of User', 'data' => $_POST), true);
					        }
							}

		
		}else{
			echo json_encode(array('error' => 'Y', 'msg' => 'Enable to Upload File Size Exceed', 'data' => $_POST), true);
		}
	}
}


function Login($db){

	if($_POST['email'] == '' && !filter_var(test_input($_POST["email"]), FILTER_VALIDATE_EMAIL)){
    	echo json_encode(array('error' => 'Y', 'msg' => 'email not found on requested data', 'data' => $_POST));
    }

    if($_POST['password'] == ''){
    	echo json_encode(array('error' => 'Y', 'msg' => 'password not found on requested data', 'data' => $_POST));
    }
    /*if($_POST['firebaseid'] == ''){
    	echo json_encode(array('error' => 'Y', 'msg' => 'firebaseid not found on requested data'));
    }*/

    $myusername = mysqli_real_escape_string($db, $_POST['email']);
    $mypassword = mysqli_real_escape_string($db, $_POST['password']);

    $firebaseid = (isset($_POST['firebaseid'])) ? $_POST['firebaseid'] : '';
    $firebaseid = mysqli_real_escape_string($db, $firebaseid);
    
    $sql = "SELECT * FROM register WHERE email = '$myusername' and password = '$mypassword' and block='0'";
    $result = mysqli_query($db, $sql);
    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
    
    $count = mysqli_num_rows($result);
    if($count) {
    		
    		$id = mysqli_real_escape_string($db, $row['id']);		
    		$sql = "UPDATE register SET firebaseid='$firebaseid' WHERE id='$id'";
				mysqli_query($db, $sql);

    		session_start();
				$_SESSION['username'] = $row['username'];
				$_SESSION['id'] = $row['id'];
				$_SESSION['profile'] = ($row['profile']) ? 'images/upload/'.$row['profile']  : 'images/user-avatar-placeholder.png';
				$_SESSION['logged_in'] = 'Y';
				$_SESSION['email'] = $_POST['email'];
				$_SESSION['status'] = ($row['status'] == '0' || $row['status'] == 0) ? 'user-invisible' : 'user-online';

				$userid = mysqli_real_escape_string($db, $row['id']);


				$sql = "SELECT balance FROM balance WHERE userid = '$userid'";
		    $result = mysqli_query($db, $sql);
		    $balanceData = mysqli_fetch_array($result,MYSQLI_ASSOC);

		    $balance = isset($balanceData['balance']) ? $balanceData['balance'] : 0;

        echo json_encode(array('error' => 'N', 'msg' => 'Sucessfull Log in', 'data' => array('id' => $row['id'], 'username' => $row['username'], 'email' => $row['email'], 'profile' => URL.'/images/upload/'.$row['profile'], 'balance' => $balance)), true);
    }else {
    	echo json_encode(array('error' => 'Y', 'msg' => 'Your Login Name or Password is invalid', 'data' => $_POST));
    }
}
/*function forgetPassword($db){
	if($_POST['mobile_no'] == ''){
  	echo json_encode(array('error' => 'Y', 'msg' => 'mobile_no not found on requested data'));
  }

  if($_POST['password'] == ''){
  	echo json_encode(array('error' => 'Y', 'msg' => 'password not found on requested data'));
  }

  $mobile_no = mysqli_real_escape_string($db, $_POST['mobile_no']);
  $mypassword = mysqli_real_escape_string($db, $_POST['password']);
  
  $sql = "SELECT * FROM register WHERE mobile = '$mobile_no'";
  $result = mysqli_query($db, $sql);
  $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
  
  $count = mysqli_num_rows($result);
  if($count) {
  		$sql = "UPDATE register SET password='$mypassword' WHERE mobile='$mobile_no'";
	    mysqli_query($db, $sql);
     	if(mysqli_affected_rows($db)) {

     		session_start();
				$_SESSION['username'] = $row[0]['username'];
				$_SESSION['id'] =$row[0]['id'];
				$_SESSION['profile'] = $row[0]['profile'] != '' ? URL.'/images/upload/'.$row[0]['profile']  : URL.'/images/user-avatar-placeholder.png';
				$_SESSION['logged_in'] = 'Y';
				$_SESSION['email'] = $row[0]['email'];
				$_SESSION['status'] = 'user-online';

     		echo json_encode(array('error' => 'N', 'msg' => 'Password Updated Sucessfully'), true);
      }else{
        echo json_encode(array('error' => 'Y', 'msg' => 'Password Update Failed'), true);
      }
  }else {
  	echo json_encode(array('error' => 'Y', 'msg' => 'Wrong Mobile Number!'));
  }
}*/

function forgetPassword($db){
	if($_POST['mobile_no'] == ''){
  	echo json_encode(array('error' => 'Y', 'msg' => 'mobile_no not found on requested data'));
  }

  if($_POST['password'] == ''){
  	echo json_encode(array('error' => 'Y', 'msg' => 'password not found on requested data'));
  }

  $mobile_no = mysqli_real_escape_string($db, $_POST['mobile_no']);
  $mypassword = mysqli_real_escape_string($db, $_POST['password']);
  
  $sql = "SELECT * FROM register WHERE mobile = '$mobile_no'";
  $result = mysqli_query($db, $sql);
  $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
  
  $count = mysqli_num_rows($result);
  if($count) {
  		$sql = "UPDATE register SET password='$mypassword' WHERE mobile='$mobile_no'";
	    mysqli_query($db, $sql);
   		
   		session_start();
			$_SESSION['username'] = $row['username'];
			$_SESSION['id'] =$row['id'];
			$_SESSION['profile'] = $row['profile'] != '' ? URL.'/images/upload/'.$row['profile']  : URL.'/images/user-avatar-placeholder.png';
			$_SESSION['logged_in'] = 'Y';
			$_SESSION['email'] = $row['email'];
			$_SESSION['status'] = 'user-online';
     	
     	if(mysqli_affected_rows($db)) {


     		echo json_encode(array('error' => 'N', 'msg' => 'Password Updated Sucessfully'), true);
      }else{
        echo json_encode(array('error' => 'Y', 'msg' => 'Password Already Updated'), true);
      }
  }else {
  	echo json_encode(array('error' => 'Y', 'msg' => 'Wrong Mobile Number!'));
  }
}


function getCities($db){
	$sql = "SELECT * FROM city";
	$result = mysqli_query($db, $sql);
	$row = mysqli_fetch_all($result, MYSQLI_ASSOC);
	echo json_encode($row, true);
}