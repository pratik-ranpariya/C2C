<?php
 
	include("v1/config.php");
	if(!isset($_SESSION)) 
	{ 
	    session_start(); 
	} 
	if(isset($_SESSION['email'])){
		
		$userid = mysqli_real_escape_string($db, $_SESSION['id']);
		$sql = "SELECT updatedat,id,status from orders where userid='$userid'";
		$result = mysqli_query($db, $sql);
		$orderData = mysqli_fetch_all($result, MYSQLI_ASSOC);
		$response = array();
		$order_completion = 0;
		foreach ($orderData as $key => $value) {
			if($value['status'] == 'accept'){
				$order_completion++;
			}
			$orderid = mysqli_real_escape_string($db, $value['id']);
			$updatedat = mysqli_real_escape_string($db, $value['updatedat']);
			$sql = "SELECT AVG(TIMESTAMPDIFF(HOUR,'$updatedat',date)) AS timediff FROM order_messages WHERE orderid='$orderid'";
			$result = mysqli_query($db, $sql);
			array_push($response, mysqli_fetch_array($result, MYSQLI_ASSOC)['timediff']);
		}
		if($response){
			$average = array_sum($response)/count($response);
			$average_rate = number_format((100-($average/100)), 2, '.', '');
			if($average_rate >= 100){
				$average_rate = 100;
			}
		}else{
			$average = 0;
			$average_rate = 0;
		}
		if(count($orderData)){
			$order_completion = number_format(($order_completion/count($orderData))*100, 2, '.', '');
			if($order_completion >= 100){
				$order_completion = 100;
			}
		}else{
			$order_completion = 0;
		}

		$sql = "UPDATE register SET response_time='$average',response_time_rate='$average_rate',order_completion='$order_completion'";
		mysqli_query($db, $sql);

		$email = mysqli_real_escape_string($db, $_SESSION['email']);
		$sql = "SELECT * FROM register WHERE email='$email' ";

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
		$data['nationality'] = (isset($data['nationality'])) ? $data['nationality'] : "";
		$data['speak'] = (isset($data['speak'])) ? $data['speak'] : "";
		$data['work'] = (isset($data['work'])) ? $data['work'] : "";
		
		$uid = mysqli_real_escape_string($db, $data['id']);
		$sql = "SELECT * FROM balance WHERE userid='$uid' ";
		$result = mysqli_query($db, $sql);
		$earnings = mysqli_fetch_array($result, MYSQLI_ASSOC);

		$data['earnings'] = array();
		$data['earnings']['balance'] = (isset($earnings['balance'])) ? $earnings['balance'] : 0;
		if($data['earnings']['balance'] >= 100){
			$data['withdrawal'] = 1;
		}else{
			$data['withdrawal'] = 0;
		}
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
		
		
		$email = mysqli_real_escape_string($db, $_SESSION['email']);

		$userid = mysqli_real_escape_string($db, $_SESSION['id']);
		$sql = "SELECT count(service_review.date) FROM service_review, user_services, subcategories, register WHERE user_services.id = service_review.serviceid and register.email=service_review.email and subcategories.id=user_services.scategory and service_review.userid = '$userid'";

		$query=mysqli_query($db, $sql);
		$row = mysqli_fetch_row($query);
	 
		$rows = $row[0];
	 
		$page_rows = 1;
	 
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
	 	
	 	$sql = "SELECT service_review.price, service_review.rate,service_review.date,service_review.text,service_review.text, register.username as buyer_name, register.profile as buyer_profile, user_services.title as service_title, subcategories.name as subcategory FROM service_review, user_services, subcategories, register WHERE user_services.id = service_review.serviceid and register.email=service_review.email and subcategories.id=user_services.scategory and service_review.userid = '$userid' $limit";

	 	$nquery = mysqli_query($db, $sql);
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

		$currentTime = date_create();

		$nquery = mysqli_fetch_all($nquery, MYSQLI_ASSOC);
		foreach ($nquery as $key => $value) {
			$nquery[$key]['buyer_profile'] = URL.'/images/upload/'.$value['buyer_profile'];
			$nquery[$key]['buyer_name'] = $value['buyer_name'];
			$nquery[$key]['days_ago']  	= date_diff( date_create(date('Y-m-d H:m:s')), date_create($value['date']))->d;
			$nquery[$key]['buyer_profile'] = ($value['buyer_profile']) ? 'images/upload/'.$value['buyer_profile']  : 'images/user-avatar-placeholder.png';
			$nquery[$key]['date'] = date_create($value['date']);
		}

	}else{
		$data = array();
	}