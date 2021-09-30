<?php
header('Access-Control-Allow-Origin: *');
include("../config.php");

if($_GET['service']){
	switch ($_GET['service']) {
		case 'online':
				getOnlineStatus($db);
			break;
		case 'city':
				getCities($db);
			break;
		case 'productCategory':
				getProductCategory($db);
			break;
		case 'states':
				getStates($db);
			break;
		case 'country':
				getCountries($db);
			break;
		case 'categories':
				getCategories($db);
			break;
		case 'scategories':
				getSubCategories($db);
			break;
		case 'getProfile':
				getProfile($db);
			break;
		case 'getMyProfile':
				getMyProfile($db);
			break;
		case 'getMyDashboard':
				getMyDashboard($db);
			break;
		case 'search':
				getSearchResult($db);
			break;
		case 'HomeSearch':
				getHomeSearchResults($db);
			break;
		case 'updatemydata':
				UpdateMyData($db);
			break;
		case 'userServices':
				GetUserServices($db);
			break;
		case 'topservices':
				GetTopServices($db);
			break;
		
		default:
			// code...
			break;
	}
}else{
	echo json_encode(array(), true);
}

function GetTopServices(){

}

function GetUserServices($db){

	if($_POST['email'] == '' && !filter_var(test_input($_POST["email"]), FILTER_VALIDATE_EMAIL)){
  	echo json_encode(array('error' => 'Y', 'msg' => 'email not found on requested data'));
  }

	$email = mysqli_real_escape_string($db, $_POST['email']);
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
 	
 	$nquery=mysqli_query($db,"select title,description,category,scategory,image from `user_services` where email='$email' $limit");
 	$data['services'] = mysqli_fetch_all($nquery, MYSQLI_ASSOC);

 	foreach ($data['services'] as $key => $value) {
 		$cid = mysqli_real_escape_string($db, $value['category']);
 		$scid = mysqli_real_escape_string($db, $value['scategory']);
 		
 		$nquery=mysqli_query($db,"select name from categories where id='$cid'");
 		$nquery1=mysqli_query($db,"select name from subcategories where id='$scid'");
 		
 		$data['services'][$key]['category'] = mysqli_fetch_array($nquery, MYSQLI_ASSOC)['name'];
 		$data['services'][$key]['scategory'] = mysqli_fetch_array($nquery1, MYSQLI_ASSOC)['name'];
 		$data['services'][$key]['image'] = URL.'/images/services/'.$value['image'];
 	}
 	$data['count'] = count($data['services']);
 	
 	echo json_encode(array('error' => 'N', 'data' => $data), true);
 	
}
/*
function UpdateMyData($db){
	
	if(!isset($_SESSION)) 
	{ 
		session_start(); 
	} 
	if(isset($_SESSION['userid'])){
		//$email = mysqli_real_escape_string($db, $_SESSION['email']);
		$userid= mysqli_real_escape_string($db, $_SESSION['userid']);
	}else{
		//$email = mysqli_real_escape_string($db, $_POST['email']);
		$userid = mysqli_real_escape_string($db, $_POST['userid']);
	}
	
    // echo print_r($userid);
	$sql = "SELECT id FROM register WHERE id = '$userid'";
	$result = mysqli_query($db, $sql);
	$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
	
	$count = mysqli_num_rows($result);

	if($count == 0){
		echo json_encode(array('error' => 'Y', 'msg' => 'Email ID not exists into system'), true);
	}else
	{
		$update = "";	

		if($_POST['fname'] != ''){
			$fname = mysqli_real_escape_string($db, $_POST['fname']);
			$update .= " fname='$fname'";
		}
		if($_POST['lname'] != ''){
			$lname = mysqli_real_escape_string($db, $_POST['lname']);
			if(strlen($update) > 2){
				$update .= ", lname='$lname'";
			}else{
				$update .= " lname='$lname'";
			}
		}
		if($_POST['tagline'] != ''){
			$tagline = mysqli_real_escape_string($db, $_POST['tagline']);
			if(strlen($update) > 2){
				$update .= ", tagline='$tagline'";
			}else{
				$update .= " tagline='$tagline'";
			}
		}
		if($_POST['city'] != ''){
			$city = mysqli_real_escape_string($db, $_POST['city']);
			if(strlen($update) > 2){
				$update .= ", city='$city'";
			}else{
				$update .= " city='$city'";
			}
		}
		if($_POST['description'] != ''){
			$description = mysqli_real_escape_string($db, $_POST['description']);
			if(strlen($update) > 2){
				$update .= ", description='$description'";
			}else{
				$update .= " description='$description'";
			}
		}
		if($_POST['email'] != ''){
			$email = mysqli_real_escape_string($db, $_POST['email']);
			if(strlen($update) > 2){
				$update .= ", email='$email'";
			}else{
				$update .= "email='$email'";
			}
		}
		if($_POST['username'] != ''){
			$username = mysqli_real_escape_string($db, $_POST['username']);
			if(strlen($update) > 2){
				$update .= ", username='$username'";
			}else{
				$update .= "username='$username'";
			}
		}

		if(@$_POST['cpassword'] != '' && @$_POST['npassword'] != '' && @$_POST['rnpassword'] != '' && @$_POST['npassword'] == @$_POST['npassword'])
		{
			$npassword = mysqli_real_escape_string($db, $_POST['npassword']);
			$cpassword = mysqli_real_escape_string($db, $_POST['cpassword']);
			$sql = "SELECT * FROM register WHERE email = '$email' and password='$cpassword'";
			$result = mysqli_query($db, $sql);
			$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
			if(count($row)){
				if(strlen($update) > 2){
					$update .= ", password='$npassword'";
				}else{
					$update .= " password='$npassword'";
				}	
			}else{
				echo json_encode(array('error' => 'N', 'msg' => 'The password does not match!'), true);
			}
		}

		if(isset($_FILES) & !empty($_FILES)){

			$validextensions = array(
				"jpeg",
				"jpg",
				"png",
				"JPG",
				"PNG"
			);
			$temporary = explode(".", $_FILES["image"]["name"]);

			$file_extension = end($temporary);
			if ($_FILES["image"]["size"] && ($_FILES["image"]["size"] < 8000000)) 
			{  
				
				$fileName = 'profile_'.time().'.'.$file_extension;
						$sourcePath = $_FILES['image']['tmp_name']; // Storing source path of the file in a variable
						$targetPath = "C:/wamp64/www/mytest/dailyneeds/html/dailyneeds_web/images/upload/".$fileName; // Target path where file is to be stored
						move_uploaded_file($sourcePath, $targetPath); // Moving Uploaded file

						$fileName = mysqli_real_escape_string($db, $fileName);
						if(strlen($update) > 2){
							$update .= ", profile='$fileName'";	
						}else{
							$update .= " profile='$fileName'";
						}
						$_SESSION['profile'] = ($fileName) ? '/images/upload/'.$fileName  : '/images/user-avatar-placeholder.png';
					}
				}
			}

			$sql = "UPDATE register SET ".$update." WHERE id='$userid'";
			mysqli_query($db, $sql);
			if(mysqli_affected_rows($db)>0) {
				echo json_encode(array('error' => 'N', 'msg' => 'Profile Update Sucessfully'), true);
			}else{
				echo json_encode(array('error' => 'N', 'msg' => 'Profile Update Failed'), true);
			}
	} */


	function UpdateMyData($db){
	// reald one //

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
    	

	$count = mysqli_num_rows($result);

	if($count == 0){
		echo json_encode(array('error' => 'Y', 'msg' => 'Email ID not exists into system'), true);
	}else{
		
        
		$update = "";
		if($_POST['fname'] != ''){	
			$fname = mysqli_real_escape_string($db, $_POST['fname']);
			$update .= " fname='$fname'";
		}
		if($_POST['lname'] != ''){
			$lname = mysqli_real_escape_string($db, $_POST['lname']);
			if(strlen($update) > 2){
				$update .= ", lname='$lname'";
			}else{
				$update .= " lname='$lname'";
			}
		}
		if($_POST['tagline'] != ''){
			$tagline = mysqli_real_escape_string($db, $_POST['tagline']);
			if(strlen($update) > 2){
				$update .= ", tagline='$tagline'";

			}else{
				$update .= " tagline='$tagline'";
			}
		}
		if($_POST['city'] != ''){
			$city = mysqli_real_escape_string($db, $_POST['city']);
			if(strlen($update) > 2){
				$update .= ", city='$city'";
			}else{
				$update .= " city='$city'";
			}
		}
		if($_POST['description'] != ''){
			$description = mysqli_real_escape_string($db, $_POST['description']);
			if(strlen($update) > 2){
				$update .= ", description='$description'";
			}else{
				$update .= " description='$description'";
			}
		}
		if($_POST['email'] != ''){
			$email = mysqli_real_escape_string($db, $_POST['email']);
			if(strlen($update) > 2){
				$update .= ", email='$email'";
			}else{
				$update .= "email='$email'";
			}
		}
		if($_POST['username'] != ''){
			$username = mysqli_real_escape_string($db, $_POST['username']);
			if(strlen($update) > 2){
				$update .= ", username='$username'";
			}else{
				$update .= "username='$username'";
			}
		}
		if($_POST['cpassword'] != '' && $_POST['npassword'] != '' && $_POST['rnpassword'] != '' && $_POST['npassword'] == $_POST['npassword']){
			$npassword = mysqli_real_escape_string($db, $_POST['npassword']);
			$cpassword = mysqli_real_escape_string($db, $_POST['cpassword']);
			$sql = "SELECT * FROM register WHERE email = '$email' and password='$cpassword'";
			$result = mysqli_query($db, $sql);
			$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
			if(count($row)){
				if(strlen($update) > 2){
					$update .= ", password='$npassword'";
				}else{
					$update .= " password='$npassword'";
				}	
			}else{
				echo json_encode(array('error' => 'N', 'msg' => 'The password does not match!'), true);
			}
		}
	} 
    

	
	if (isset($_FILES["file"]["type"])){
		
       
		$validextensions = array(
				"jpeg",
				"jpg",
				"png",
				"JPG",
				"PNG"
			);
			$temporary = explode(".", $_FILES["file"]["name"]);

			$file_extension = end($temporary);
			if ($_FILES["file"]["size"] && ($_FILES["file"]["size"] < 8000000) //Approx. 100kb files can be uploaded.
			 ){
					if ($_FILES["file"]["error"] > 0){
						echo "Return Code: " . $_FILES["file"]["error"] . "<br/><br/>";
					}else{
						$fileName = 'profile_'.time().'.'.$file_extension;
						$sourcePath = $_FILES['file']['tmp_name']; // Storing source path of the file in a variable
						$targetPath = "../../images/upload/" . $fileName; // Target path where file is to be stored
						move_uploaded_file($sourcePath, $targetPath); // Moving Uploaded file

						$fileName = mysqli_real_escape_string($db, $fileName);
						if(strlen($update) > 2){
							$update .= ", profile='$fileName'";
						}else{
							$update .= " profile='$fileName'";
						}
						$_SESSION['profile'] = ($fileName) ? 'images/upload/'.$fileName  : 'images/user-avatar-placeholder.png';

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

function getHomeSearchResults($db){
		$data = array();
			if($_GET['cid'] == ''){
				echo json_encode(array('error' => 'Y', 'msg' => 'city not found on requested data'), true);
				return true;
			}
			$cid = mysqli_real_escape_string($db, $_GET['cid']);
			$sql = "SELECT category,scategory  FROM user_services WHERE city='$cid'";
			$result = mysqli_query($db, $sql);
			$row = mysqli_fetch_all($result, MYSQLI_ASSOC);

	// print_r($row);
			$sql = "SELECT * FROM categories WHERE ";
			foreach ($row as $key => $value) {
				if($key == 0){
					$sql .= 'id='.$value['category'];
				}else{
					$sql .= ' OR id='.$value['category'];
				}
			}

			$category = mysqli_query($db, $sql);
			$data['category'] = mysqli_fetch_all($category, MYSQLI_ASSOC);

			foreach ($data['category'] as $key => $value) {

				$id = mysqli_real_escape_string($db, $value['id']);
				$sql = "SELECT name,category,id FROM subcategories WHERE category='$id' ";
				$subcategories = mysqli_query($db, $sql);
				$subcategories = mysqli_fetch_all($subcategories, MYSQLI_ASSOC);

				$data['category'][$key]['subcategories'] = array();

				foreach ($row as $value1) {
					foreach ($subcategories as $value2) {
						if($value1['scategory'] == $value2['id']){
							array_push($data['category'][$key]['subcategories'], $value2);
						}

					}
				}

			}

			echo json_encode(array('error' => 'N', 'data' => $data), true);
		}

function getSearchResult($db){
	
}
function getProductCategory($db){
	
	if($_GET['code'] == ''){
  	echo json_encode(array('error' => 'Y', 'msg' => 'code not found on requested data'), true);
  	return true;
  }
  $code = mysqli_real_escape_string($db, $_GET['code']);

	$sql = "SELECT * FROM subcategories WHERE category='$code'";
	$result = mysqli_query($db, $sql);
	$row = mysqli_fetch_all($result, MYSQLI_ASSOC);

	echo json_encode(array('error' => 'N', 'data' => $row), true);
}

function getOnlineStatus($db){
	if($_POST){
		if($_POST['email'] == ''){
	  	echo json_encode(array('error' => 'Y', 'msg' => 'email not found on requested data'), true);
	  	return true;
	  }

		if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
	  	echo json_encode(array('error' => 'Y', 'msg' => 'email address not valid on requested data'), true);
	  	return true;
	  }

	  if($_GET['code'] == ''){
	  	echo json_encode(array('error' => 'Y', 'msg' => 'status not found on requested data'), true);
	  	return true;
	  }

		$email = mysqli_real_escape_string($db, $_POST['email']);
		$code = mysqli_real_escape_string($db, $_GET['code']);

		$sql = "UPDATE register SET status = '$code' WHERE email = '$email'";
		mysqli_query($db, $sql);
    if(mysqli_affected_rows($db)) {
    		echo json_encode(array('error' => 'N', 'msg' => 'Status Updated Sucessfully'));
    	return true;
    }else {
    	echo json_encode(array('error' => 'Y', 'msg' => 'results not updated on requested data or already Updated'));
    	return true;
    }
	}else{
		session_start();
		if(isset($_SESSION['email'])){

			if($_GET['code'] == ''){
		  	echo json_encode(array('error' => 'Y', 'msg' => 'status not found on requested data'), true);
		  	return true;
		  }
			
			$email = mysqli_real_escape_string($db, $_SESSION['email']);
			$code = mysqli_real_escape_string($db, $_GET['code']);
			
			$sql = "UPDATE register SET status = '$code' WHERE email = '$email'";
			mysqli_query($db, $sql);
	    if(mysqli_affected_rows($db)) {
	    		$_SESSION['status'] = ($_GET['code'] == '0' || $_GET['code'] == 0) ? 'user-invisible' : 'user-online';
	        echo json_encode(array('error' => 'N', 'msg' => 'Status Updated Sucessfully'));
	    	return true;
	    }else {
	    	echo json_encode(array('error' => 'Y', 'msg' => 'results not updated on requested data or already Updated'));
	    	return true;
	    }
		}else{
			echo json_encode(array('error' => 'Y', 'msg' => 'results not updated on requested data'));
    	return true;
		}
	}
}
function getCountries($db){
	$sql = "SELECT * FROM countries";
	$result = mysqli_query($db, $sql);
	$row = mysqli_fetch_all($result, MYSQLI_ASSOC);
	echo json_encode($row, true);
}

function getStates($db){
	if($_GET['code'] > 0){
		$code = mysqli_real_escape_string($db, $_GET['code']);
		$sql = "SELECT * FROM states WHERE country_id='$code'";
	}else{
		$sql = "SELECT * FROM states";
	}
	$result = mysqli_query($db, $sql);
	$row = mysqli_fetch_all($result, MYSQLI_ASSOC);
	echo json_encode($row, true);
}
function getCities($db){
	$sql = "SELECT * FROM city";
	$result = mysqli_query($db, $sql);
	$row = mysqli_fetch_all($result, MYSQLI_ASSOC);
	echo json_encode(array('error' => 'N', 'data' => $row), true);
}

function getCategories($db){
	$sql = "SELECT * FROM categories";
	$result = mysqli_query($db, $sql);
	$row = mysqli_fetch_all($result, MYSQLI_ASSOC);
	echo json_encode(array('error' => 'N', 'data' => $row), true);
}

function getSubCategories($db){
	
	$code = mysqli_real_escape_string($db, $_GET['code']);

	$sql = "SELECT * FROM subcategories WHERE category='$code'";
	$result = mysqli_query($db, $sql);
	$row = mysqli_fetch_all($result, MYSQLI_ASSOC);
	echo json_encode(array('error' => 'N', 'data' => $row), true);
}

function getProfile($db){

	if($_POST){

		if($_POST['email'] == '' && !filter_var(test_input($_POST["email"]), FILTER_VALIDATE_EMAIL)){
    	echo json_encode(array('error' => 'Y', 'msg' => 'email not found on requested data'));
    	return true;
    }

		$email = mysqli_real_escape_string($db, $_POST['email']);
		// $sql = "SELECT id,fname,lname,email,status,username,city,profile,tagline,nationality,speak,description,response_time,response_time_rate,order_completion,on_time_delivery,positive_rate FROM register WHERE email='$email' ";
		$sql = "SELECT register.id,register.fname,register.lname,register.email,register.status,register.username,city.name as city,register.profile,register.tagline,register.speak,register.description,register.response_time,register.response_time_rate,register.order_completion,register.on_time_delivery,register.positive_rate FROM register, city WHERE email='$email' and city.id=register.city";

		$result = mysqli_query($db, $sql);
		$data = mysqli_fetch_array($result, MYSQLI_ASSOC);
		
		$data['username'] = (isset($data['username'])) ? $data['username'] : "";
		$data['email'] = (isset($data['email'])) ? $data['email'] : "";
		$data['loggedat'] = (isset($data['loggedat'])) ? $data['loggedat'] : "";
		$data['city'] = (isset($data['city'])) ? $data['city'] : "";
		$data['profile'] = (isset($data['profile'])) ? URL.'images/upload/'.$data['profile'] : "";
		$data['fname'] = (isset($data['fname'])) ? $data['fname'] : "";
		$data['lname'] = (isset($data['lname'])) ? $data['lname'] : "";
		$data['tagline'] = (isset($data['tagline'])) ? $data['tagline'] : "";
		$data['description'] = (isset($data['description'])) ? $data['description'] : "";
		$data['tagline'] = (isset($data['tagline'])) ? $data['tagline'] : "";
		$data['nationality'] = (isset($data['nationality'])) ? $data['nationality'] : "";
		$data['speak'] = (isset($data['speak'])) ? $data['speak'] : "";
		$data['todos'] = (isset($data['todos'])) ? $data['todos'] : 0;
		
		$uid = mysqli_real_escape_string($db, $data['id']);
		$sql = "SELECT sum(rate) as totalRate, count(*) as totalRateCount FROM service_review WHERE userid='$uid'";
		$result = mysqli_query($db, $sql);

		$rateData = mysqli_fetch_array($result, MYSQLI_ASSOC);
		if($rateData && $rateData['totalRate'] && $rateData['totalRateCount']){
			$data['rate'] = $rateData['totalRate']/$rateData['totalRateCount'];
		}else{
			$data['rate'] = 0;
		}

		$uid = mysqli_real_escape_string($db, $data['id']);
		$sql = "SELECT * FROM balance WHERE userid='$uid' ";
		$result = mysqli_query($db, $sql);
		$earnings = mysqli_fetch_array($result, MYSQLI_ASSOC);

		$data['earnings'] = array();
		$data['earnings']['balance'] = (isset($earnings['balance'])) ? $earnings['balance'] : 0;
		$data['earnings']['balance_in_month'] = (isset($earnings['balance_in_month'])) ? $earnings['balance_in_month'] : 0;
		$data['earnings']['selling_price'] = (isset($earnings['selling_price'])) ? $earnings['selling_price'] : 0;
		$data['earnings']['active_orders'] = (isset($earnings['active_orders'])) ? $earnings['active_orders'] : 0;
		$data['earnings']['pending_clearance'] = (isset($earnings['pending_clearance'])) ? $earnings['pending_clearance'] : 0;
		$data['earnings']['cancelled_orders'] = (isset($earnings['cancelled_orders'])) ? $earnings['cancelled_orders'] : 0;

		$data['maintains'] = array();
		$data['maintains']['seller_level'] = (isset($data['seller_level'])) ? $data['seller_level'] : '3';
		$data['maintains']['evaluation'] = (isset($data['evaluation'])) ? $data['evaluation'] : 'Jan 15 2019';
		$data['maintains']['response_time'] = (isset($data['response_time'])) ? $data['response_time'] : '1 Hours';
		$data['maintains']['response_time_rate'] = (isset($data['response_time_rate'])) ? $data['response_time_rate'] : 0;
		$data['maintains']['order_completion'] = (isset($data['order_completion'])) ? $data['order_completion'] : 0;
		$data['maintains']['on_time_delivery'] = (isset($data['on_time_delivery'])) ? $data['on_time_delivery'] : 0;
		$data['maintains']['positive_rate'] = (isset($data['positive_rate'])) ? $data['positive_rate'] : 0;

		$data['statistics'] = array();
		$data['statistics']['views'] = (isset($data['views'])) ? $data['views'] : 0;
		$data['statistics']['impressions'] = (isset($data['impressions'])) ? $data['impressions'] : 0;
		$data['statistics']['clicks'] = (isset($data['clicks'])) ? $data['clicks'] : 0;		
			/*$data['work'] = (isset($data['work'])) ? $data['work'] : 0;
			$data['hrate'] = (isset($data['hrate'])) ? $data['hrate'] : 0;
			$data['jdone'] = (isset($data['jdone'])) ? $data['jdone'] : 0;
			$data['rhire'] = (isset($data['rhire'])) ? $data['rhire'] : 0;*/
		
		echo json_encode(array('error' => 'N', 'data' => $data), true);
	}else{
		session_start();
		if(isset($_SESSION['email'])){
			$email = mysqli_real_escape_string($db, $_SESSION['email']);
			$sql = "SELECT * FROM register WHERE email='$email' ";

			$result = mysqli_query($db, $sql);
			$result = mysqli_fetch_all($result, MYSQLI_ASSOC);
			echo json_encode(array('error' => 'N', 'data' => $result), true);
		}else{
			echo json_encode(array('error' => 'Y', 'msg' => 'Email not presents !'), true);		
		}
	}
}

function getMyProfile($db){

	if($_POST){

		if($_POST['email'] == '' && !filter_var(test_input($_POST["email"]), FILTER_VALIDATE_EMAIL)){
    	echo json_encode(array('error' => 'Y', 'msg' => 'email not found on requested data'));
    	return true;
    }

		$email = mysqli_real_escape_string($db, $_POST['email']);
		$sql = "SELECT register.id,register.fname,register.lname,register.email,register.status,register.username,city.name as city,register.profile,register.tagline,register.speak,register.description,register.response_time,register.response_time_rate,register.order_completion,register.on_time_delivery,register.positive_rate FROM register, city WHERE email='$email' and city.id=register.city";

		$result = mysqli_query($db, $sql);
		$data = mysqli_fetch_array($result, MYSQLI_ASSOC);
		
		$data['username'] = (isset($data['username'])) ? $data['username'] : "";
		$data['email'] = (isset($data['email'])) ? $data['email'] : "";
		$data['loggedat'] = (isset($data['loggedat'])) ? $data['loggedat'] : "";
		$data['city'] = (isset($data['city'])) ? $data['city'] : "";
		$data['profile'] = (isset($data['profile'])) ? URL.'/images/upload/'.$data['profile'] : "";
		$data['fname'] = (isset($data['fname'])) ? $data['fname'] : "";
		$data['lname'] = (isset($data['lname'])) ? $data['lname'] : "";
		$data['tagline'] = (isset($data['tagline'])) ? $data['tagline'] : "";
		$data['description'] = (isset($data['description'])) ? $data['description'] : "";
		$data['tagline'] = (isset($data['tagline'])) ? $data['tagline'] : "";
		$data['nationality'] = "";
		$data['speak'] = (isset($data['speak'])) ? $data['speak'] : "";
		
		$uid = mysqli_real_escape_string($db, $data['id']);
		$sql = "SELECT sum(rate) as totalRate, count(*) as totalRateCount FROM service_review WHERE userid='$uid'";
		$result = mysqli_query($db, $sql);

		$rateData = mysqli_fetch_array($result, MYSQLI_ASSOC);
		if($rateData && $rateData['totalRate'] && $rateData['totalRateCount']){
			$data['rate'] = $rateData['totalRate']/$rateData['totalRateCount'];
		}else{
			$data['rate'] = 0;
		}
		
		$uid = mysqli_real_escape_string($db, $data['id']);
		$sql = "SELECT * FROM balance WHERE userid='$uid' ";
		$result = mysqli_query($db, $sql);
		$earnings = mysqli_fetch_array($result, MYSQLI_ASSOC);

		echo json_encode(array('error' => 'N', 'data' => $data), true);
	}else{
		session_start();
		if(isset($_SESSION['email'])){
			$email = mysqli_real_escape_string($db, $_SESSION['email']);
			$sql = "SELECT * FROM register WHERE email='$email' ";

			$result = mysqli_query($db, $sql);
			$result = mysqli_fetch_all($result, MYSQLI_ASSOC);
			echo json_encode(array('error' => 'N', 'data' => $result), true);
		}else{
			echo json_encode(array('error' => 'Y', 'msg' => 'Email not presents !'), true);		
		}
	}
}

function getMyDashboard($db){

	if($_POST){

		if($_POST['email'] == '' && !filter_var(test_input($_POST["email"]), FILTER_VALIDATE_EMAIL)){
    	echo json_encode(array('error' => 'Y', 'msg' => 'email not found on requested data'));
    	return true;
    }

		$email = mysqli_real_escape_string($db, $_POST['email']);
		$sql = "SELECT id,fname,lname,email,status,username,city,profile,tagline,nationality,speak,description,response_time,response_time_rate,order_completion,on_time_delivery,positive_rate FROM register WHERE email='$email' ";

		$result = mysqli_query($db, $sql);
		$data = mysqli_fetch_array($result, MYSQLI_ASSOC);
		
		$data['profile'] = (isset($data['profile'])) ? URL.'/images/upload/'.$data['profile'] : "";
		$data['todos'] = (isset($data['todos'])) ? $data['todos'] : 0;
		
		$uid = mysqli_real_escape_string($db, $data['id']);
		$sql = "SELECT * FROM balance WHERE userid='$uid' ";
		$result = mysqli_query($db, $sql);
		$earnings = mysqli_fetch_array($result, MYSQLI_ASSOC);

		$data['earnings'] = array();
		$data['earnings']['balance'] = (isset($earnings['balance'])) ? $earnings['balance'] : 0;
		$data['earnings']['balance_in_month'] = (isset($earnings['balance_in_month'])) ? $earnings['balance_in_month'] : 0;
		$data['earnings']['selling_price'] = (isset($earnings['selling_price'])) ? $earnings['selling_price'] : 0;
		$data['earnings']['active_orders'] = (isset($earnings['active_orders'])) ? $earnings['active_orders'] : 0;
		$data['earnings']['pending_clearance'] = (isset($earnings['pending_clearance'])) ? $earnings['pending_clearance'] : 0;
		$data['earnings']['cancelled_orders'] = (isset($earnings['cancelled_orders'])) ? $earnings['cancelled_orders'] : 0;

		$data['maintains'] = array();
		$data['maintains']['response_time'] = (isset($data['response_time'])) ? $data['response_time'] : '1 Hours';
		$data['maintains']['response_time_rate'] = (isset($data['response_time_rate'])) ? $data['response_time_rate'] : 0;
		$data['maintains']['order_completion'] = (isset($data['order_completion'])) ? $data['order_completion'] : 0;
		$data['maintains']['on_time_delivery'] = (isset($data['on_time_delivery'])) ? $data['on_time_delivery'] : 0;
		$data['maintains']['positive_rate'] = (isset($data['positive_rate'])) ? $data['positive_rate'] : 0;

		$data['statistics'] = array();
		$data['statistics']['views'] = (isset($data['views'])) ? $data['views'] : 0;
		$data['statistics']['impressions'] = (isset($data['impressions'])) ? $data['impressions'] : 0;
		$data['statistics']['clicks'] = (isset($data['clicks'])) ? $data['clicks'] : 0;		
		
		echo json_encode(array('error' => 'N', 'data' => $data), true);

	}else{
		session_start();
		if(isset($_SESSION['email'])){
			$email = mysqli_real_escape_string($db, $_SESSION['email']);
			$sql = "SELECT * FROM register WHERE email='$email' ";

			$result = mysqli_query($db, $sql);
			$result = mysqli_fetch_all($result, MYSQLI_ASSOC);
			echo json_encode(array('error' => 'N', 'data' => $result), true);
		}else{
			echo json_encode(array('error' => 'Y', 'msg' => 'Email not presents !'), true);		
		}
	}
}