<?php
session_start();
include("../config.php");

if($_GET['service']){
	switch ($_GET['service']) {
		case 'addService':
				addService($db);
			break;
		case 'services':
				getServices($db);
			break;
		case 'recommands':
				getRecommands($db);
			break;
		case 'getProfile':
				getProfile($db);
			break;
		case 'contact':
				saveContact($db);
			break;
		case 'getServices':
				getServicess($db);
			break;
		case 'getMyServices':
				getUserServices($db);
			break;
		case 'postRequest':
				submitPostRequest($db);
			break;
		case 'getpostRequestData':
				postRequestData($db);
			break;
		case 'getCategories':
				getCategories($db);
			break;
		case 'getSubCategories':
				getSubCategories($db);
			break;
		case 'manage_order':
				manage_order($db);
			break;
		case 'ManageOrderData':
				ManageOrderData($db);
			break;
		case 'getMyReviews':
				ManageReviewData($db);
			break;
		case 'getPopSubCategories':
				getPopSubCategories($db);
			break;
		case 'getFavList':
				getFavList($db);
			break;
		case 'addToMyFav':
				addToMyFav($db);
			break;
		case 'getNotiList':
				getNotiList($db);
			break;
		case 'notiSeen':
				notiSeen($db);
			break;
		
		default:
			// code...
			break;
	}
}else{
	echo json_encode(array(), true);
}

function manage_order($db){
	
}
function notiSeen($db){
	if($_POST['userid'] == '' || (int)$_POST['userid'] == 0){
  	echo json_encode(array('error' => 'Y', 'msg' => 'userid not found on requested data'), true);
  	return true;
  }
  if($_POST['notificationid'] == '' || (int)$_POST['notificationid'] == 0){
  	echo json_encode(array('error' => 'Y', 'msg' => 'notificationid not found on requested data'), true);
  	return true;
  }
	$userid = mysqli_real_escape_string($db, $_POST['userid']);
	$notificationid = mysqli_real_escape_string($db, $_POST['notificationid']);	
	$sql = "UPDATE notification SET is_seen='Y' WHERE userid='$userid' and id='$notificationid'";
	mysqli_query($db, $sql);
	if(mysqli_affected_rows($db)) {
 		echo json_encode(array('error' => 'N', 'msg' => 'Notification Updated Sucessfully'), true);
 	}else {
 		echo json_encode(array('error' => 'N', 'msg' => 'Notifcation Not Updated'), true);
 	}
}
function getNotiList($db){
	if($_POST['userid'] == '' || (int)$_POST['userid'] == 0){
  	echo json_encode(array('error' => 'Y', 'msg' => 'userid not found on requested data'), true);
  	return true;
  }

  $userid = mysqli_real_escape_string($db, $_POST['userid']);
	$sql = "SELECT id,comments, `date`, is_seen from notification where userid='$userid'";
	$result = mysqli_query($db, $sql);
	$data = mysqli_fetch_all($result, MYSQLI_ASSOC);

	echo json_encode(array('error' => 'N', 'data' => $data), true);
	return true;

}

function addToMyFav($db){
	if($_POST['userid'] == '' || (int)$_POST['userid'] == 0){
  	echo json_encode(array('error' => 'Y', 'msg' => 'userid not found on requested data'), true);
  	return true;
  }
  if($_POST['serviceid'] == '' || (int)$_POST['serviceid'] == 0){
  	echo json_encode(array('error' => 'Y', 'msg' => 'serviceid not found on requested data'), true);
  	return true;
  }
	
	$userid = mysqli_real_escape_string($db, $_POST['userid']);
	$serviceid = mysqli_real_escape_string($db, $_POST['serviceid']);  

  $sql = "INSERT INTO favorites (userid, serviceid) VALUES ('$userid','$serviceid')";
 	mysqli_query($db, $sql);

 	if(mysqli_affected_rows($db)) {
 		echo json_encode(array('error' => 'N', 'msg' => 'favourites Successfully Posted'), true);
 	}else{
 		echo json_encode(array('error' => 'N', 'msg' => 'favourites not Posted'), true);
 	}
}

function getFavList($db){
	if($_POST['userid'] == '' || (int)$_POST['userid'] == 0){
  	echo json_encode(array('error' => 'Y', 'msg' => 'userid not found on requested data'), true);
  	return true;
  }

  $userid = mysqli_real_escape_string($db, $_POST['userid']);
	$sql = "SELECT user_services.title as service_title, user_services.id as service_id, user_services.image from user_services, favorites where favorites.serviceid = user_services.id and user_services.userid <> '$userid'";
	$result = mysqli_query($db, $sql);
	$data = mysqli_fetch_all($result, MYSQLI_ASSOC);

	foreach ($data as $key => $value) {
		$data[$key]['image'] = URL.'/images/services/'.$value['image'];
	}
	echo json_encode(array('error' => 'N', 'data' => $data), true);
	return true;

}

function getPopSubCategories($db){
	if($_GET['cid'] == '' || (int)$_GET['cid'] == 0){
  	echo json_encode(array('error' => 'Y', 'msg' => 'city not found on requested data'), true);
  	return true;
  }
  $cid = mysqli_real_escape_string($db, $_GET['cid']);
	$sql = "SELECT subcategories.name, subcategories.id from user_services, subcategories where subcategories.id = user_services.scategory and user_services.city='$cid'";
	$result = mysqli_query($db, $sql);
	$subcategories = mysqli_fetch_all($result, MYSQLI_ASSOC);
	echo json_encode(array('error' => 'N', 'data' => $subcategories), true);
	return true;
}

function getCategories($db){
	$sql = 'SELECT id,name from categories';
	$result = mysqli_query($db, $sql);
	$categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
	echo json_encode(array('error' => 'N', 'data' => $categories), true);
	return true;
}
function getSubCategories($db){
	$sql = 'SELECT id,name,category from subcategories';
	$result = mysqli_query($db, $sql);
	$subcategories = mysqli_fetch_all($result, MYSQLI_ASSOC);
	echo json_encode(array('error' => 'N', 'data' => $subcategories), true);
	return true;
}
function ManageOrderData(){

	if($_POST['email'] == ''){
  	echo json_encode(array('error' => 'Y', 'msg' => 'email not found on requested data'), true);
  	return true;
  }

	$email = mysqli_real_escape_string($db, $_POST['email']);
	$sql = "SELECT * FROM register WHERE email='$email' ";

	$result = mysqli_query($db, $sql);
	$userData = mysqli_fetch_array($result, MYSQLI_ASSOC);

	$uid = mysqli_real_escape_string($db, $userData['id']);
	$sql = "SELECT * FROM orders WHERE userid='$uid' ";
	
	$result = mysqli_query($db, $sql);
	$orderData = mysqli_fetch_all($result, MYSQLI_ASSOC);

	foreach ($orderData as $key => $value) {

		$serviceid = mysqli_real_escape_string($db, $value['serviceid']);
		$sql = "SELECT title FROM user_services WHERE id='$serviceid' and email='$email'";
		
		$result = mysqli_query($db, $sql);
		$orderData[$key]['service_details'] = mysqli_fetch_array($result, MYSQLI_ASSOC);	
		
		$orderid = mysqli_real_escape_string($db, $value['id']);
		$sql = "SELECT * FROM orders_track WHERE orderid='$orderid' and userid='$uid'";
		
		$result = mysqli_query($db, $sql);
		$orderData[$key]['properties'] = mysqli_fetch_array($result, MYSQLI_ASSOC);
		$value['date'] = date_format(date_create($value['date']),"d M Y H:i:s");
		if($value['timetype'] == 'd'){
			$date = strtotime(date("Y-m-d H:i:s", strtotime($value['date'])) . " +".$value['deliverytime']."days");
			$date = date('Y-m-d H:i:s',strtotime('+2 day',strtotime($value['date'])));
			$orderData[$key]['delivery_date'] = date_format(date_create($date),"d M Y H:i:s");
		}else if($value['timetype'] == 'h'){
			$date = date('Y-m-d H:i:s',strtotime('+2 hour',strtotime($value['date'])));
			$orderData[$key]['delivery_date'] = date_format(date_create($date), "d M Y H:i:s");
		}else{
			$date = date('Y-m-d H:i:s',strtotime('+2 month',strtotime($value['date'])));
			$orderData[$key]['delivery_date'] = date_format(date_create($date),"d M Y H:i:s");
		}
		
		$orderData[$key]['date'] = date_format(date_create($value['date']),"d M Y H:i:s");

		echo json_encode(array('error' => 'N', 'data' => $orderData), true);
	}
}
function ManageReviewData($db){

	if($_POST['userid'] == ''){
  	echo json_encode(array('error' => 'Y', 'msg' => 'userid not found on requested data'), true);
  	return true;
  }

  $userid = mysqli_real_escape_string($db, $_POST['userid']);

	$sql = "SELECT service_review.price, service_review.rate,service_review.date,service_review.text, register.username as buyer_name, register.profile as buyer_profile, user_services.title as service_title, subcategories.name as subcategory FROM service_review, user_services, subcategories, register WHERE user_services.id = service_review.serviceid and register.email=service_review.email and subcategories.id=user_services.scategory and service_review.userid = '$userid'";

	$result = mysqli_query($db, $sql);
	$review = mysqli_fetch_all($result,MYSQLI_ASSOC);
	// $review = array();
	$currentTime = date_create();
	foreach ($review as $key => $value) {
		$review[$key]['buyer_profile'] = URL.'/images/upload/'.$value['buyer_profile'];
		$review[$key]['buyer_name'] = $value['buyer_name'];
		$review[$key]['days_ago']  	= date_diff( date_create(date('Y-m-d H:m:s')), date_create($value['date']))->d;
	}

	echo json_encode(array('error' => 'N', 'data' => $review), true);
}
function postRequestData($db){
	if($_POST['userid'] == ''){
  	echo json_encode(array('error' => 'Y', 'msg' => 'userid not found on requested data'), true);
  	return true;
  }
  $userid = mysqli_real_escape_string($db, $_POST['userid']);
	$sql = "SELECT postrequest.id, postrequest.description,postrequest.time,postrequest.date,postrequest.type,postrequest.budget,postrequest.posterid, categories.name as category, subcategories.name as scategory,register.profile,register.username from postrequest, categories, subcategories, register where postrequest.category = categories.id and postrequest.scategory = subcategories.id and postrequest.posterid = register.id and postrequest.posterid <> '$userid'";
	$result = mysqli_query($db, $sql);
	$postrequest = mysqli_fetch_all($result, MYSQLI_ASSOC);

	foreach ($postrequest as $key => $value) {
		$postrequest[$key]['profile'] = URL.'/images/upload/'.$value['profile'];
	}
	echo json_encode(array('error' => 'N', 'data' => $postrequest), true);
	return true;
}

function getUserServices($db){
	if($_POST['email'] == ''){
  	echo json_encode(array('error' => 'Y', 'msg' => 'email not found on requested data'), true);
  	return true;
  }
  $email = mysqli_real_escape_string($db, $_POST['email']);
  
  $sql = "SELECT a.id, a.category, a.scategory, a.image, a.description, a.title,a.price,b.name,s.rate FROM user_services a, categories b, service_review s WHERE a.category = b.id and a.email = '$email' and s.serviceid = a.id and a.userid = s.userid";

  $result = mysqli_query($db, $sql);
  if (!$result) {
    printf("Error: %s\n", mysqli_error($db));
    exit();
	}
	$data = mysqli_fetch_all($result, MYSQLI_ASSOC);
	foreach ($data as $key => $value) {
		
		$id = mysqli_real_escape_string($db, $value['id']);
		
		$sql = "SELECT name FROM subcategories WHERE id='$id'";
		$result = mysqli_query($db, $sql);
		$data[$key]['subcategory'] = mysqli_fetch_array($result, MYSQLI_ASSOC)['name'];
		$data[$key]['image'] = URL.'/images/service/'.$value['image'];
		$data[$key]['service_title'] = $value['title'];
	}

	echo json_encode(array('error' => 'N', 'data' => $data), true);
}

function submitPostRequest($db){
	if($_POST['description'] == ''){
  	echo json_encode(array('error' => 'Y', 'msg' => 'description not found on requested data'), true);
  	return true;
  }
  if($_POST['category'] == ''){
  	echo json_encode(array('error' => 'Y', 'msg' => 'category not found on requested data'), true);
  	return true;
  }
  if($_POST['scategory'] == ''){
  	echo json_encode(array('error' => 'Y', 'msg' => 'scategory not found on requested data'), true);
  	return true;
  }
  if($_POST['time'] == ''){
  	echo json_encode(array('error' => 'Y', 'msg' => 'time not found on requested data'), true);
  	return true;
  }
  if($_POST['type'] == ''){
  	echo json_encode(array('error' => 'Y', 'msg' => 'type not found on requested data'), true);
  	return true;
  }
  if($_POST['budget'] == ''){
  	echo json_encode(array('error' => 'Y', 'msg' => 'budget not found on requested data'), true);
  	return true;
  }	

  if(!isset($_SESSION['id'])){
	  if($_POST['posterid'] == ''){
	  	echo json_encode(array('error' => 'Y', 'msg' => 'posterid not found on requested data'), true);
	  	return true;
	  }
	  $posterid = mysqli_real_escape_string($db, $_SESSION['id']);
  }else{
  	$posterid = mysqli_real_escape_string($db, $_POST['posterid']);
  }

  $description = mysqli_real_escape_string($db, $_POST['description']);
  $category = mysqli_real_escape_string($db, $_POST['category']);
  $scategory = mysqli_real_escape_string($db, $_POST['scategory']);
  $time = mysqli_real_escape_string($db, $_POST['time']); 
  $type = mysqli_real_escape_string($db, $_POST['type']); 
  $budget = mysqli_real_escape_string($db, $_POST['budget']);
  

  $sql = "INSERT INTO postrequest (description, category, scategory, `time`, type, budget, posterid) VALUES ('$description','$category','$scategory','$time','$type','$budget','$posterid')";
 	mysqli_query($db, $sql);

 	if(mysqli_affected_rows($db)) {
 		echo json_encode(array('error' => 'N', 'msg' => 'request Successfully Posted'), true);
 	}else{
 		echo json_encode(array('error' => 'N', 'msg' => 'request not Posted'), true);
 	}

}
function getServicess($db){

	if($_GET['cid'] == '' || (int)$_GET['cid'] == 0){
  	echo json_encode(array('error' => 'Y', 'msg' => 'city not found on requested data'), true);
  	return true;
  }
  if($_GET['category'] == ''){
  	echo json_encode(array('error' => 'Y', 'msg' => 'category not found on requested data'), true);
  	return true;
  }
  if($_GET['scategory'] == ''){
  	echo json_encode(array('error' => 'Y', 'msg' => 'scategory not found on requested data'), true);
  	return true;
  }
  if($_GET['search'] == ''){
  	echo json_encode(array('error' => 'Y', 'msg' => 'search not found on requested data'), true);
  	return true;
  }

  /*if((int)$_GET['cid'] > 0 && strlen($_GET['search']) == 1 && (int)$_GET['search'] == 0){
  	$cid = mysqli_real_escape_string($db, $_GET['cid']);
		$sql = "SELECT user_services.id, user_services.userid, user_services.category, user_services.scategory, user_services.image, user_services.description, user_services.title,user_services.price, categories.name as category, subcategories.name as scategory FROM user_services, categories, subcategories  WHERE categories.id = user_services.category and subcategories.id = user_services.scategory and user_services.city = '$cid'";

  }*/
  if((int)$_GET['cid'] > 0){
  	$cid = mysqli_real_escape_string($db, $_GET['cid']);
  	if((int)$_GET['scategory'] == 0 && (int)$_GET['category'] == 0 && (int)$_GET['search'] == 0){
  		$sql = "SELECT user_services.id, user_services.userid, user_services.category, user_services.scategory, user_services.image, user_services.description, user_services.title,user_services.price, categories.name as category, subcategories.name as scategory FROM user_services, categories, subcategories  WHERE categories.id = user_services.category and subcategories.id = user_services.scategory and user_services.city = '$cid'";
  	}

  	if((int)$_GET['scategory'] > 0 && (int)$_GET['category'] == 0){
	  	$scategory = mysqli_real_escape_string($db, $_GET['scategory']);
			$sql = "SELECT user_services.id, user_services.userid, user_services.category, user_services.scategory, user_services.image, user_services.description, user_services.title,user_services.price, categories.name as category, subcategories.name as scategory FROM user_services, categories, subcategories  WHERE categories.id = user_services.category and subcategories.id = user_services.scategory and user_services.scategory = '$scategory' and user_services.city = '$cid'";

	  }
	  if((int)$_GET['category'] > 0 && (int)$_GET['scategory'] == 0){
	  	$category = mysqli_real_escape_string($db, $_GET['category']);
			$sql = "SELECT user_services.id, user_services.userid, user_services.category, user_services.scategory, user_services.image, user_services.description, user_services.title,user_services.price, categories.name as category, subcategories.name as scategory FROM user_services, categories, subcategories  WHERE categories.id = user_services.category and subcategories.id = user_services.scategory and user_services.category = '$category' and user_services.city = '$cid'";
	  }
	  if((int)$_GET['category'] > 0 && (int)$_GET['scategory'] > 0){
	  	$category = mysqli_real_escape_string($db, $_GET['category']);
	  	$scategory = mysqli_real_escape_string($db, $_GET['scategory']);
			$sql = "SELECT user_services.id, user_services.userid, user_services.category, user_services.scategory, user_services.image, user_services.description, user_services.title,user_services.price, categories.name as category, subcategories.name as scategory FROM user_services, categories, subcategories  WHERE categories.id = user_services.category and subcategories.id = user_services.scategory and user_services.category = '$category' and user_services.scategory = '$scategory' and user_services.city = '$cid'";
	  }

	  if(strlen($_GET['search']) > 1){
	  	$search = mysqli_real_escape_string($db, $_GET['search']);
	  	$sql = "SELECT user_services.id, user_services.userid, user_services.category, user_services.scategory, user_services.image, user_services.description, user_services.title,user_services.price, categories.name as category, subcategories.name as scategory FROM user_services, categories, subcategories  WHERE categories.id = user_services.category and subcategories.id = user_services.scategory and user_services.title LIKE '$search%' and user_services.city = '$cid'";
	  }
  }

  $result = mysqli_query($db, $sql);
  if (!$result) {
    printf("Error: %s\n", mysqli_error($db));
    exit();
	}
	$data = mysqli_fetch_all($result, MYSQLI_ASSOC);
	foreach ($data as $key => $value) {
		$data[$key]['image'] = URL.'/images/services/'.$value['image'];
		$data[$key]['rating'] = '4.5';
	}

	echo json_encode(array('error' => 'N', 'data' => $data), true);
}
/*function getServicess($db){
	if($_GET['cid'] == ''){
  	echo json_encode(array('error' => 'Y', 'msg' => 'city not found on requested data'), true);
  	return true;
  }
  $cid = mysqli_real_escape_string($db, $_GET['cid']);
  
  $sql = 'SELECT a.id, a.scategory, a.image, a.description, a.title, b.name,a.price,a.userid FROM user_services a, categories b WHERE a.category = b.id';

  $result = mysqli_query($db, $sql);
  if (!$result) {
    printf("Error: %s\n", mysqli_error($db));
    exit();
	}
	$data = mysqli_fetch_all($result, MYSQLI_ASSOC);
	$services = array();
	foreach ($data as $key => $value) {
		
		$id = mysqli_real_escape_string($db, $value['id']);
		
		$sql = "SELECT name FROM subcategories WHERE id='$id'";
		$result = mysqli_query($db, $sql);

		$userid = mysqli_real_escape_string($db, $value['userid']);
		$sql = "SELECT rate FROM service_review WHERE userid='$userid'";
		$rating = mysqli_query($db, $sql);

		$temp = array();
		$temp['service_id'] = $value['id'];
		$temp['userid'] = $value['userid'];
		$temp['rating'] = '4.5';
		$temp['image'] = URL.'/images/service/'.$value['image'];
		$temp['service_title'] = (isset($value['title'])) ? $value['title'] : '';
		$temp['description'] = (isset($value['description'])) ? $value['description'] : '';
		$temp['service_title'] = (isset($value['title'])) ? $value['title'] : '';
		$temp['category_name'] = (isset($value['name'])) ? $value['name'] : '';
		$temp['price'] = (isset($value['price'])) ? $value['price'] : '';
		$temp['subcategory_name'] = mysqli_fetch_array($result, MYSQLI_ASSOC)['name'];

		array_push($services, $temp);
	}

	echo json_encode(array('error' => 'N', 'data' => $services), true);
}*/

function saveContact($db){
	if($_POST['name'] == ''){
  	echo json_encode(array('error' => 'Y', 'msg' => 'name not found on requested data'), true);
  	return true;
  }

  if($_POST["email"]){

	  if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
	  	echo json_encode(array('error' => 'Y', 'msg' => 'email not valid on requested data'), true);
	  	return true;
	  }
  }

  if($_POST['comments'] == ''){
  	echo json_encode(array('error' => 'Y', 'msg' => 'comments not found on requested data'), true);
  	return true;
  }
  if($_POST['subject'] == ''){
  	echo json_encode(array('error' => 'Y', 'msg' => 'subject not found on requested data'), true);
  	return true;
  }

  $name = mysqli_real_escape_string($db, $_POST['name']);
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $subject = mysqli_real_escape_string($db, $_POST['subject']);
	$comments = mysqli_real_escape_string($db, $_POST['comments']);
	
	if(isset($_SESSION['id'])){
		$userid = mysqli_real_escape_string($db, $_SESSION['id']);
		$sql = "INSERT INTO contact (name,email,subject,comment,userid) VALUES ('$name','$email','$subject','$comments','$userid')";
	}else{
		$sql = "INSERT INTO contact (name,email,subject,comment) VALUES ('$name','$email','$subject','$comments')";
	}
	mysqli_query($db, $sql);

 	if(mysqli_affected_rows($db)) {
 		echo json_encode(array('error' => 'N', 'msg' => 'Message Sent Successfully'), true);
 		return true;
  }else{
    echo json_encode(array('error' => 'Y', 'msg' => 'Service Failed'), true);
    return true;
  }


}
function getRecommands($db){
	$sql = "SELECT * FROM categories WHERE recommands='1' ";
	$result = mysqli_query($db, $sql);
	$data['recommands'] = mysqli_fetch_all($result, MYSQLI_ASSOC);

	$sql = "SELECT * FROM subcategories WHERE ";
	foreach ($data['recommands'] as $key => $value) {
		if($key == 0){
			$sql .= 'category='.(string)$value['id'];
		}else{
			$sql .= ' OR category='.(string)$value['id'];
		}
	}
	$result = mysqli_query($db, $sql);
	$data['tab_recommands'] = mysqli_fetch_all($result, MYSQLI_ASSOC);

	echo json_encode($data, true);
}

function getServices($db){
	$sql = "SELECT * FROM categories";
	$result = mysqli_query($db, $sql);
	$row = mysqli_fetch_all($result, MYSQLI_ASSOC);
	echo json_encode($row, true);
}

function addService($db){

		if($_POST['title'] == ''){
	  	echo json_encode(array('error' => 'Y', 'msg' => 'title not found on requested data'), true);
	  	return true;
	  }

	  if(isset($_POST["email"])){

		  if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
		  	echo json_encode(array('error' => 'Y', 'msg' => 'email not valid on requested data'), true);
		  	return true;
		  }
	  }else{
	  	$_POST["email"] = $_SESSION['email'];
	  }

	  if($_POST['city'] == ''){
	  	echo json_encode(array('error' => 'Y', 'msg' => 'city not found on requested data'), true);
	  	return true;
	  }

		if($_POST['category'] == ''){
	  	echo json_encode(array('error' => 'Y', 'msg' => 'category not found on requested data'), true);
	  	return true;
	  }

	  if($_POST['description'] == ''){
	  	echo json_encode(array('error' => 'Y', 'msg' => 'description not found on requested data'), true);
	  	return true;
	  }

	  if($_POST['price'] == ''){
	  	echo json_encode(array('error' => 'Y', 'msg' => 'price not found on requested data'), true);
	  	return true;
	  }

		$email = mysqli_real_escape_string($db, $_POST['email']);
		$title = mysqli_real_escape_string($db, $_POST['title']);
  	$city = mysqli_real_escape_string($db, $_POST['city']);

		$sql = "SELECT id FROM user_services WHERE email = '$email' and title = '$title' and city = '$city'";
		$result = mysqli_query($db, $sql);
		$row = mysqli_fetch_array($result,MYSQLI_ASSOC);

		$count = mysqli_num_rows($result);
		if($count){
	      echo json_encode(array('error' => 'Y', 'msg' => 'Service already present into system'), true);
	      return true;
    }else{

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
				if (($_FILES["file"]["size"] < 8000000) //Approx. 100kb files can be uploaded.
				 ){
					if ($_FILES["file"]["error"] > 0){
							echo json_encode(array('error' => 'Y', 'msg' => 'file uploading error !', 'data' => $_FILES['file']['error']));
							return true;
					}else{
						if (file_exists("../../images/services/" . $_FILES["file"]["name"])){
							echo json_encode(array('error' => 'Y', 'msg' => 'service picture already exists!'));
							return true;
						}else{

							$fileName = 'service_'.time().'.'.$file_extension;
							$sourcePath = $_FILES['file']['tmp_name']; // Storing source path of the file in a variable
							$targetPath = "../../images/services/" . $fileName; // Target path where file is to be stored
							move_uploaded_file($sourcePath, $targetPath); // Moving Uploaded file
							
							if (file_exists("../../images/services/" . $fileName)){

								$price = mysqli_real_escape_string($db, $_POST['price']);
						    $category = mysqli_real_escape_string($db, $_POST['category']);
						    $scategory = mysqli_real_escape_string($db, $_POST['scategory']);
						    $description = mysqli_real_escape_string($db, $_POST['description']);
						    $fileName = mysqli_real_escape_string($db, $fileName);

						    /*$sql = "INSERT INTO user_services (title, email, description, category, scategory, city, image) VALUES ('$title','$email','$description','$category','$scategory','$city', '$fileName')";*/
						    
						    $sql = "SELECT id FROM register where email='$email'";
							$result = mysqli_query($db, $sql);
							$registerData = mysqli_fetch_array($result, MYSQLI_ASSOC);

							$userid = mysqli_real_escape_string($db, $registerData['id']);

						    $sql = "INSERT INTO user_services (title, email, userid, description, category, scategory, city, image, price) VALUES ('$title','$email', '$userid', '$description','$category','$scategory','$city', '$fileName', '$price')";

					     	mysqli_query($db, $sql);

					     	if(mysqli_affected_rows($db)) {
					     		if(isset($_POST['suggest']) && $_POST['suggest'] != '' && (int)$category == 8){
					     			$suggest = mysqli_real_escape_string($db, $_POST['suggest']);
					     			$sql = "INSERT INTO suggestservices (userid, suggest_text) VALUES ('$userid', '$suggest')";
					     			mysqli_query($db, $sql);
					     			
					     			echo json_encode(array('error' => 'N', 'msg' => 'Service Added Successfully'), true);
					     			return true;
					     		}else{
					     			echo json_encode(array('error' => 'N', 'msg' => 'Service Added Successfully'), true);
					     			return true;
					     		}
					     		
				        }else{
				          echo json_encode(array('error' => 'Y', 'msg' => 'Service Failed'), true);
				          return true;
				        }
									

							}else{
								echo json_encode(array('error' => 'Y', 'msg' => 'system fault'), true);
								return true;
							}
						}
					}
				}else{
					echo json_encode(array('error' => 'Y', 'msg' => 'Enable to Upload File Size Exceed'), true);
					return true;
				}
			}
		}
}

