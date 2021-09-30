<?php
session_start();
include("../config.php");
date_default_timezone_set('Pacific/Auckland');

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
		case 'getServices':
				getServicess($db);
			break;
		case 'getMyServices':
				getUserServices($db);
			break;
		case 'contact':
				saveContact($db);
			break;
		case 'topUserServices':
				topUserServices($db);
			break;
		case 'sellerRequest':
				sellerRequest($db);
			break;
		case 'getServiceOnUserCategory':
				getServiceOnUserCategory($db);
			break;
		case 'buyerRequest':
				buyerRequest($db);
			break;
		case 'postRequest':
				submitPostRequest($db);
			break;
		case 'postRequestSellers':
				postRequestSellers($db);
			break;
		case 'getpostRequestData':
				postRequestData($db);
			break;
		case 'revokeOffer':
				revokeOffer($db);
			break;
		case 'revokeSellerFromOffer':
				revokeSellerFromOffer($db);
			break;
		case 'sendOffer':
				postSendOffer($db);
			break;
		case 'acceptOffer':
				acceptOffer($db);
			break;
		case 'sendOrderMessages':
				sendOrderMessages($db);
			break;
		case 'sendOrderConfirmation':
				sendOrderConfirmation($db);
			break;
		case 'sendOrderFeeback':
				sendOrderFeeback($db);
			break;
		case 'orderDetails':
				orderDetails($db);
			break;
		case 'makecc':
				makecc($db);
			break;
		case 'manage_sales':
				manage_sales($db);
			break;
		case 'manage_orders':
				manage_orders($db);
			break;
		case 'deliverOrder':
				deliverOrder($db);
			break;
		case 'getCategories':
				getCategories($db);
			break;
		case 'getSubCategories':
				getSubCategories($db);
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
		case 'getNotiList':
				getNotiList($db);
			break;
		case 'addToMyFav':
				addToMyFav($db);
			break;
		case 'getAllCities':
				getAllCities($db);
			break;
		case 'makePayment':
			    makePayment($db);
		    break;
		case 'removeFavorites':
			    removeFavorites($db);
		    break;
		case 'removeService':
			    removeService($db);
		    break;
		case 'getSellerServices':
			    getSellerServices($db);
		    break;
		default:
			// code...
			break;
	}
}else{
	echo json_encode(array(), true);
}

function removeFavorites($db){
	if(isset($_POST['userid']) && isset($_POST['serviceid'])){

		$userid = mysqli_real_escape_string($db, $_POST['userid']);
		$serviceid = mysqli_real_escape_string($db, $_POST['serviceid']);

		$sql = "DELETE FROM favorites WHERE serviceid='$serviceid' and userid='$userid'";
		mysqli_query($db, $sql);
		if(mysqli_affected_rows($db)) {
			echo json_encode(array('error' => 'N', 'msg' => 'your favorite services removed!'), true);
			return true;
		}else{
			echo json_encode(array('error' => 'N', 'msg' => 'service id or userid not found into database!'), true);
			return true;	
		}
		
	}else{
		echo json_encode(array('error' => 'Y', 'msg' => 'user id or service id not found'), true);
		return true;
	}
}
function getSellerServices($db){
	
	if(isset($_POST['sellerid']) && isset($_POST['userid'])){

		$sellerid = mysqli_real_escape_string($db, $_POST['sellerid']);

		$sql = "SELECT * FROM user_services WHERE userid='$sellerid'";
		$result = mysqli_query($db, $sql);
		$service = mysqli_fetch_all($result,MYSQLI_ASSOC);

		foreach ($service as $key => $value) {
			$serviceid = mysqli_real_escape_string($db, $value['id']);
			$userid = mysqli_real_escape_string($db, $_POST['userid']);
			$sql = "SELECT * FROM favorites WHERE userid='$userid' and serviceid='$serviceid'";
			$result = mysqli_query($db, $sql);
			$favdata = mysqli_fetch_all($result, MYSQLI_ASSOC);
			$service[$key]['favorite'] = count($favdata) ? 'Y' : 'N';
			$service[$key]['image'] = URL.'/images/services/'.$value['image'];
			$service[$key]['rating'] = '4.5';
		}
		echo json_encode(array('error' => 'N', 'msg' => '', 'data' => $service), true);
		return true;	

	}else{
		echo json_encode(array('error' => 'Y', 'msg' => 'services not found!'), true);
		return true;
	}
}
function removeService($db){
	if(isset($_POST['userid']) && isset($_POST['serviceid'])){

		$userid = mysqli_real_escape_string($db, $_POST['userid']);
		$serviceid = mysqli_real_escape_string($db, $_POST['serviceid']);

		$sql = "SELECT count(*) as totalCount, id from sendoffer WHERE userid='$userid' and serviceid='$serviceid'";
		$result = mysqli_query($db, $sql);
		$sendOfferData = mysqli_fetch_array($result,MYSQLI_ASSOC);
		if($sendOfferData != null && (int)$sendOfferData['totalCount']){

			$sql = "SELECT count(*) as totalCount from orders WHERE offerid='$userid' and status<>'o_delivery_complete_accept' and status<>'o_cancel_accept'";
			$result = mysqli_query($db, $sql);
			$orders = mysqli_fetch_array($result,MYSQLI_ASSOC)['totalCount'];
			if($orders != null && (int)$orders){
				echo json_encode(array('error' => 'Y', 'msg' => 'Your Service Working On Order!'), true);
				return true;
			}else{
				
				$sql = "DELETE FROM sendoffer WHERE userid='$userid' and serviceid='$serviceid'";
				mysqli_query($db, $sql);

				$sql = "DELETE FROM user_services WHERE id='$serviceid' and userid='$userid'";
				mysqli_query($db, $sql);
				if(mysqli_affected_rows($db)) {
					echo json_encode(array('error' => 'N', 'msg' => 'Your Services Removed!'), true);
					return true;
				}else{
					echo json_encode(array('error' => 'N', 'msg' => 'Service not Found!'), true);
					return true;	
				}
			}
		}else{

			$sql = "DELETE FROM user_services WHERE id='$serviceid' and userid='$userid'";
			mysqli_query($db, $sql);
			if(mysqli_affected_rows($db)) {
				echo json_encode(array('error' => 'N', 'msg' => 'Your Services Removed!'), true);
				return true;
			}else{
				echo json_encode(array('error' => 'N', 'msg' => 'Service not Found!'), true);
				return true;	
			}
		}
	}else{
		echo json_encode(array('error' => 'Y', 'msg' => 'Data not Found!'), true);
		return true;
	}
}
function makePayment($db){
	/*error_reporting(E_ALL);
	ini_set('display_errors', 'on');*/

	if(!empty($_POST['stripeToken'])){

	    //get token, card and user info from the form
		  try{

		    $token  = $_POST['stripeToken'];
		    $name = $_POST['name'];
		    $email = $_POST['email'];
		    $card_num = $_POST['card_num'];
		    $card_cvc = $_POST['cvc'];
		    $card_exp_month = $_POST['exp_month'];
		    $card_exp_year = $_POST['exp_year'];
		    $orderid = mysqli_real_escape_string($db, base64_decode((string)$_POST['orderid']));


		    if(isset($_POST['userid'])){
    			$userid = mysqli_real_escape_string($db, $_POST['userid']);

    		}else{
    			if(isset($_SESSION['id'])){
    				$userid = mysqli_real_escape_string($db, $_SESSION['id']);
    			}else{
    				echo json_encode(array('error'=> 'Y', 'msg' => 'userid not found!', 'data' => $_POST), true);
        		return true;
    			}	
    		}
    		

    		$sql = "SELECT * FROM orders WHERE id='$orderid' and status='pending'";
    		$result = mysqli_query($db, $sql);
    		$orderData = mysqli_fetch_array($result,MYSQLI_ASSOC);


    		
    		if(mysqli_num_rows($result)){

    			//include Stripe PHP library
			    require_once('../vendor/stripe-php/init.php');
                
			    
			    //set api key
			    $stripe = array(
			      "secret_key"      => "sk_test_DlWf6AhPCkT0GZ8Hz8DOGV8p",
			      "publishable_key" => "pk_test_sJESCQSxFaq8wjW2rYrZLRaT"
			    );



			    
			    \Stripe\Stripe::setApiKey($stripe['secret_key']);
			    
			    //add customer to stripe
			    $customer = \Stripe\Customer::create(array(
			        'email' => $email,
			        'source'  => $token
			    ));

			    
			    //item information
			    $itemName = "Service Payment";
			    $itemNumber = $_POST['orderid'];
			    $itemPrice = $_POST['price'];
			    $currency = "nzd";
			    $orderID = "SKA-".$_POST['orderid'];
			    
			    //charge a credit or a debit card
			    $charge = \Stripe\Charge::create(array(
			        'customer' => $customer->id,
			        'amount'   => ($itemPrice * 100),
			        'currency' => $currency,
			        'description' => $itemName,
			        'metadata' => array(
			            'order_id' => $orderID
			        )
			    ));
			    
			    //retrieve charge details
			    $chargeJson = $charge->jsonSerialize();
			    
			    
			    //check whether the charge is successful
			    if($chargeJson['amount_refunded'] == 0 && empty($chargeJson['failure_code']) && $chargeJson['paid'] == 1 && $chargeJson['captured'] == 1){
			        //order details 
			        $amount = $chargeJson['amount'];
			        $balance_transaction = $chargeJson['balance_transaction'];
			        $currency = $chargeJson['currency'];
			        $status = $chargeJson['status'];
			        $date = date("Y-m-d H:i:s");
			        if($status == 'succeeded'){
				        	//insert tansaction data into the database
				        $sql = "INSERT INTO stripe_orders (userid,name,email,card_num,card_cvc,card_exp_month,card_exp_year,item_name,item_number,item_price,item_price_currency,paid_amount,paid_amount_currency,txn_id,payment_status,created,modified) VALUES('".$userid."','".$name."','".$email."','".$card_num."','".$card_cvc."','".$card_exp_month."','".$card_exp_year."','".$itemName."','".$itemNumber."','".$itemPrice."','".$currency."','".$amount."','".$currency."','".$balance_transaction."','".$status."','".$date."','".$date."')";
				        $insert = $db->query($sql);
				        $last_insert_id = $db->insert_id;
			       
			        }else{
			        	echo json_encode(array('error'=> 'Y', 'msg' => 'Transaction has been failed', 'data' => array()), true);
		            return true;
			        }
			        // if order inserted successfully
			        if($last_insert_id && $status == 'succeeded'){
			        		$sql = "UPDATE orders SET payment='cleared', `date`='$date', updatedat='$date' WHERE id='$orderid'";
									mysqli_query($db, $sql);
									$_SESSION['cc'] = $orderid;
									if(mysqli_affected_rows($db)) {

										$userid = mysqli_real_escape_string($db, $orderData['userid']);
										$sql = "INSERT INTO orders_track (orderid,userid,active,new) VALUES ('$orderid','$userid', '1', '1')";
										mysqli_query($db, $sql);
										
										if(mysqli_affected_rows($db)) {
											echo json_encode(array('error'=> 'N', 'msg' => 'The transaction was successful', 'data' => array('orderid' => $last_insert_id)), true);
			            		return true;
										}else{
											echo json_encode(array('error'=> 'N', 'msg' => 'The transaction was successful & Tracking in procced!', 'data' => array('orderid' => $last_insert_id)), true);
		            			return true;
										}
									}else{
										echo json_encode(array('error'=> 'N', 'msg' => 'The transaction was successful and order not tracked', 'data' => array('orderid' => $last_insert_id)), true);
		          			return true;
									}
							}else{
			            echo json_encode(array('error'=> 'Y', 'msg' => 'Transaction has been failed', 'data' => array()), true);
			            return true;
			        }
			    }
			    else{
			        echo json_encode(array('error'=> 'Y', 'msg' => 'Transaction has been failed', 'data' => array()), true);
		        	return true;
			    }	
    		}
    		else{
    			echo "error";
    			echo json_encode(array('error'=> 'Y', 'msg' => 'order not valid!', 'data' => $_POST), true);
        	return true;
    		}
		  die;  

	    } catch(\Stripe\Error\Card $e) {
			  // Since it's a decline, \Stripe\Error\Card will be caught
			  $body = $e->getJsonBody();
			  $err  = $body['error'];
			  echo json_encode(array('error'=> 'Y', 'msg' => $err['message'], 'data' => array()), true);
	    	return true;

			} catch (\Stripe\Error\RateLimit $e) {
			  // Too many requests made to the API too quickly
			  $body = $e->getJsonBody();
			  $err  = $body['error'];
			  echo json_encode(array('error'=> 'Y', 'msg' => $err['message'], 'data' => array()), true);
	    	return true;
			} catch (\Stripe\Error\InvalidRequest $e) {
			  // Invalid parameters were supplied to Stripe's API
			  $body = $e->getJsonBody();
			  $err  = $body['error'];
			  echo json_encode(array('error'=> 'Y', 'msg' => $err['message'], 'data' => array()), true);
	    	return true;
			} catch (\Stripe\Error\Authentication $e) {
			  // Authentication with Stripe's API failed
			  // (maybe you changed API keys recently)
			  $body = $e->getJsonBody();
			  $err  = $body['error'];
			  echo json_encode(array('error'=> 'Y', 'msg' => $err['message'], 'data' => array()), true);
	    	return true;
			} catch (\Stripe\Error\ApiConnection $e) {
			  // Network communication with Stripe failed
			  $body = $e->getJsonBody();
			  $err  = $body['error'];
			  echo json_encode(array('error'=> 'Y', 'msg' => $err['message'], 'data' => array()), true);
	    	return true;
			} catch (\Stripe\Error\Base $e) {
			  // Display a very generic error to the user, and maybe send
			  // yourself an email
			  $body = $e->getJsonBody();
			  $err  = $body['error'];
			  echo json_encode(array('error'=> 'Y', 'msg' => $err['message'], 'data' => array()), true);
	    	return true;
			} catch (Exception $e) {
			  // Something else happened, completely unrelated to Stripe
			  $body = $e->getJsonBody();
			  $err  = $body['error'];
			  echo json_encode(array('error'=> 'Y', 'msg' => $err['message'], 'data' => array()), true);
	    	return true;
			}
	}else{
	    echo json_encode(array('error'=> 'Y', 'msg' => 'Form submission error', 'data' => array()), true);
	    return true;
	}
}
function orderDetails($db){
	// print_r($_GET);die;
	if(isset($_GET['cc'])){

		// $orderid = mysqli_real_escape_string($db, base64_decode($_GET['cc']));
		$orderid = mysqli_real_escape_string($db, $_GET['cc']);

		$sql = "SELECT offerid,serviceid,`date`,status FROM orders WHERE orders.id='$orderid'";
		$result = mysqli_query($db, $sql);
		$order = mysqli_fetch_array($result,MYSQLI_ASSOC);
		
		$date = $order['date'];
		$serviceid = $order['serviceid'];
		$status = $order['status'];
		if($order['offerid']){

			$sql = "SELECT orders.id,orders.status,orders.offerid,orders.date,orders.buyerid,sendoffer.budget,sendoffer.type as timeType,sendoffer.time,sendoffer.comments as description,categories.name as category,subcategories.name as scategory,register.id as userid, register.username,register.city as userCity,register.profile, user_services.image as serviceImage,user_services.title,user_services.id as serviceId FROM orders,sendoffer,user_services,categories,subcategories,register WHERE orders.id='$orderid' and user_services.id=sendoffer.serviceid and user_services.category=categories.id and user_services.scategory=subcategories.id and register.id=sendoffer.userid and sendoffer.id=orders.offerid";

			$result = mysqli_query($db, $sql);
			$data['order'] = mysqli_fetch_array($result,MYSQLI_ASSOC);
			$userid = mysqli_real_escape_string($db, $data['order']['userid']);
			$serviceId = mysqli_real_escape_string($db, $data['order']['serviceId']);
			$serviceid = $data['order']['serviceId'];

			$userid = mysqli_real_escape_string($db, $data['order']['userid']);
			$buyerid = mysqli_real_escape_string($db, $data['order']['buyerid']);
			$orderid = mysqli_real_escape_string($db, $data['order']['id']);

		}else{
			$serviceid = mysqli_real_escape_string($db, $order['serviceid']);

			$sql = "SELECT orders.id,orders.status,orders.serviceid,orders.date,orders.buyerid,user_services.price as budget,user_services.id as serviceId,user_services.title,user_services.time,user_services.type as timeType, register.id as userid, register.username,register.city as userCity,register.profile, user_services.image as serviceImage,categories.name as category,subcategories.name as scategory,user_services.description FROM orders,user_services,register,categories,subcategories WHERE orders.id='$orderid' and user_services.id='$serviceid' and register.id=user_services.userid and user_services.category=categories.id and user_services.scategory=subcategories.id";

			$result = mysqli_query($db, $sql);
			$data['order'] = mysqli_fetch_array($result,MYSQLI_ASSOC);
			$order['date'] = $date;
			
			$serviceId = mysqli_real_escape_string($db, $data['order']['serviceId']);

			$userid = mysqli_real_escape_string($db, $data['order']['userid']);
			$buyerid = mysqli_real_escape_string($db, $data['order']['buyerid']);
			$orderid = mysqli_real_escape_string($db, $data['order']['id']);

		
		}

		$sql = "SELECT register.username FROM orders,register WHERE orders.id='$orderid' and register.id=orders.buyerid";
		$result = mysqli_query($db, $sql);
		$data['buyerinfo'] = mysqli_fetch_array($result,MYSQLI_ASSOC);	

		$sql = "SELECT count(*) as totalCount from service_review WHERE userid='$userid' and orderid='$orderid'";
		$result = mysqli_query($db, $sql);
		$data['BuyerReviewCount'] = mysqli_fetch_array($result,MYSQLI_ASSOC)['totalCount'];

		$sql = "SELECT count(*) as totalCount from service_review WHERE userid='$buyerid' and orderid='$orderid'";
		$result = mysqli_query($db, $sql);
		$data['SellerReviewCount'] = mysqli_fetch_array($result,MYSQLI_ASSOC)['totalCount'];

		if(isset($data['order']['profile'])){
			$data['order']['profile'] = URL.'/images/upload/'.$data['order']['profile'];
		}
		if(isset($data['order']['serviceImage'])){
			$data['order']['serviceImage'] = URL.'/images/services/'.$data['order']['serviceImage'];
		}
		if(isset($data['order']['date'])){
			$data['order']['date'] = date_format(date_create($data['order']['date']), 'd M, Y');
		}
		if(isset($data['order']['id']) && $data['BuyerReviewCount']){
			$orderid = mysqli_real_escape_string($db, $data['order']['id']);
			$sql = "SELECT service_review.price,service_review.date,service_review.userid,service_review.serviceid,service_review.orderid,service_review.rate,service_review.text,register.profile as seller_profile FROM service_review,register WHERE orderid='$orderid' and register.email=service_review.email";

			$result = mysqli_query($db, $sql);
			$data['BuyerReview'] = mysqli_fetch_array($result,MYSQLI_ASSOC);
			$data['BuyerReview']['date'] = date_format(date_create($data['BuyerReview']['date']), 'd M, Y');
			$data['BuyerReview']['seller_profile'] = URL.'/images/upload/'.$data['BuyerReview']['seller_profile'];
		}

		if(isset($data['order']['id']) && $data['SellerReviewCount']){
			$orderid = mysqli_real_escape_string($db, $data['order']['id']);
			$sql = "SELECT service_review.price,service_review.date,service_review.userid,service_review.serviceid,service_review.orderid,service_review.rate,service_review.text,register.profile as buyer_profile FROM service_review,register WHERE orderid='$orderid' and register.email=service_review.email";

			$result = mysqli_query($db, $sql);
			$data['SellerReview'] = mysqli_fetch_array($result,MYSQLI_ASSOC);
			$data['SellerReview']['date'] = date_format(date_create($data['SellerReview']['date']), 'd M, Y');
			$data['SellerReview']['buyer_profile'] = URL.'/images/upload/'.$data['SellerReview']['buyer_profile'];
		}
		
		echo json_encode(array('error' => 'N', 'data' => $data), true);
		return true;


	}else{
		echo json_encode(array('error' => 'Y', 'msg' => 'Order ID not Valid'), true);
		return true;
	}
}
/*function orderDetails($db){
	// print_r($_GET);die;
	if(isset($_GET['cc'])){

		// $orderid = mysqli_real_escape_string($db, base64_decode($_GET['cc']));
		$orderid = mysqli_real_escape_string($db, $_GET['cc']);

		$sql = "SELECT offerid,serviceid,`date`,status FROM orders WHERE orders.id='$orderid'";
		$result = mysqli_query($db, $sql);
		$order = mysqli_fetch_array($result,MYSQLI_ASSOC);
		
		$date = $order['date'];
		$serviceid = $order['serviceid'];
		$status = $order['status'];
		if($order['offerid']){

			$sql = "SELECT orders.id,orders.status,orders.offerid,orders.date,orders.buyerid,sendoffer.budget,sendoffer.type as timeType,sendoffer.time,sendoffer.comments as description,categories.name as category,subcategories.name as scategory,register.id as userid, register.username,register.city as userCity,register.profile, user_services.image as serviceImage,user_services.title,user_services.id as serviceId FROM orders,sendoffer,user_services,categories,subcategories,register WHERE orders.id='$orderid' and user_services.id=sendoffer.serviceid and user_services.category=categories.id and user_services.scategory=subcategories.id and register.id=sendoffer.userid and sendoffer.id=orders.offerid";

			$result = mysqli_query($db, $sql);
			$data['order'] = mysqli_fetch_array($result,MYSQLI_ASSOC);
			$userid = mysqli_real_escape_string($db, $data['order']['userid']);
			$serviceId = mysqli_real_escape_string($db, $data['order']['serviceId']);
			$serviceid = $data['order']['serviceId'];

			$userid = mysqli_real_escape_string($db, $data['order']['userid']);
			$buyerid = mysqli_real_escape_string($db, $data['order']['buyerid']);
			$orderid = mysqli_real_escape_string($db, $data['order']['id']);

			$sql = "SELECT order_messages.senderid,order_messages.status,order_messages.receiverid,order_messages.message FROM order_messages WHERE orderid='$orderid'";
			$result = mysqli_query($db, $sql);
			$data['chat'] = mysqli_fetch_all($result,MYSQLI_ASSOC);

			
		}else{
			$serviceid = mysqli_real_escape_string($db, $order['serviceid']);

			$sql = "SELECT orders.id,orders.status,orders.serviceid,orders.date,orders.buyerid,user_services.price as budget,user_services.id as serviceId,user_services.title,user_services.time,user_services.type as timeType, register.id as userid, register.username,register.city as userCity,register.profile, user_services.image as serviceImage,categories.name as category,subcategories.name as scategory,user_services.description FROM orders,user_services,register,categories,subcategories WHERE orders.id='$orderid' and user_services.id='$serviceid' and register.id=user_services.userid and user_services.category=categories.id and user_services.scategory=subcategories.id";

			$result = mysqli_query($db, $sql);
			$data['order'] = mysqli_fetch_array($result,MYSQLI_ASSOC);
			$order['date'] = $date;
			
			$serviceId = mysqli_real_escape_string($db, $data['order']['serviceId']);

			$userid = mysqli_real_escape_string($db, $data['order']['userid']);
			$buyerid = mysqli_real_escape_string($db, $data['order']['buyerid']);
			$orderid = mysqli_real_escape_string($db, $data['order']['id']);

			$sql = "SELECT order_messages.senderid,order_messages.status,order_messages.receiverid,order_messages.message FROM order_messages WHERE orderid='$orderid'";
			$result = mysqli_query($db, $sql);
			$data['chat'] = mysqli_fetch_all($result,MYSQLI_ASSOC);

		}

		$sql = "SELECT register.username FROM orders,register WHERE orders.id='$orderid' and register.id=orders.buyerid";
		$result = mysqli_query($db, $sql);
		$data['buyerinfo'] = mysqli_fetch_array($result,MYSQLI_ASSOC);	

		$sql = "SELECT count(*) as totalCount from service_review WHERE userid='$userid' and orderid='$orderid'";
		$result = mysqli_query($db, $sql);
		$data['reviewCount'] = mysqli_fetch_array($result,MYSQLI_ASSOC)['totalCount'];

		if(isset($data['order']['profile'])){
			$data['order']['profile'] = URL.'/images/upload/'.$data['order']['profile'];
		}
		if(isset($data['order']['serviceImage'])){
			$data['order']['serviceImage'] = URL.'/images/upload/'.$data['order']['serviceImage'];
		}
		if(isset($data['order']['date'])){
			$data['order']['date'] = date_format(date_create($data['order']['date']), 'd M, Y');
		}

		echo json_encode(array('error' => 'N', 'data' => $data), true);
		return true;

	}else{
		echo json_encode(array('error' => 'Y', 'msg' => 'Order ID not Valid'), true);
		return true;
	}
}*/
function sendOrderFeeback($db){
	if($_POST['orderid'] == ''){
  	echo json_encode(array('error' => 'Y', 'msg' => 'orderid not found on requested data'), true);
  	return true;
  }
  if($_POST['userid'] == ''){
  	echo json_encode(array('error' => 'Y', 'msg' => 'userid not found on requested data'), true);
  	return true;
  }	
  if($_POST['message'] == ''){
  	echo json_encode(array('error' => 'Y', 'msg' => 'message not found on requested data'), true);
  	return true;
  }
  if($_POST['rating'] == ''){
  	echo json_encode(array('error' => 'Y', 'msg' => 'rating not found on requested data'), true);
  	return true;
  }

  $userid = mysqli_real_escape_string($db, $_POST['userid']);
  $sql ="SELECT * FROM register WHERE id='$userid'";
  $result = mysqli_query($db, $sql);
	$userData = mysqli_fetch_all($result, MYSQLI_ASSOC);
	if($userData != null && count($userData)){
		
		$orderid = mysqli_real_escape_string($db, $_POST['orderid']);
	  $sql ="SELECT serviceid,offerid,buyerid FROM orders WHERE id='$orderid'";
	  $result = mysqli_query($db, $sql);
		$orderData = mysqli_fetch_array($result, MYSQLI_ASSOC);
	  

	  if($orderData['offerid'] != 0){
	  	$offerid = mysqli_real_escape_string($db, $orderData['offerid']);
	  	$sql ="SELECT budget,serviceid FROM sendoffer WHERE id='$offerid'";
		  $result = mysqli_query($db, $sql);
			$serviceData = mysqli_fetch_array($result, MYSQLI_ASSOC);
	  }else{
	  	$serviceid = mysqli_real_escape_string($db, $orderData['serviceid']);
	  	$sql ="SELECT price as budget,id as serviceid FROM user_services WHERE id='$serviceid'";
		  $result = mysqli_query($db, $sql);
			$serviceData = mysqli_fetch_array($result, MYSQLI_ASSOC);
	  }
	  $budget = mysqli_real_escape_string($db, $serviceData['budget']);
	  $serviceid = mysqli_real_escape_string($db, $serviceData['serviceid']);
	  
	  $userid = mysqli_real_escape_string($db, $_POST['userid']);
	  $email = mysqli_real_escape_string($db, $userData[0]['email']);
	  $rate = mysqli_real_escape_string($db, $_POST['rating']);
	  $message = mysqli_real_escape_string($db, $_POST['message']);
	  if($orderData['buyerid'] == $_POST['userid']){
	  	$buyerReviewed = 0;
	  }else{
	  	$buyerReviewed = 1;
	  }
	  $sql = "INSERT INTO service_review (email,price,userid,serviceid,orderid,rate,`text`) VALUES ('$email','$budget', '$userid', '$serviceid', '$orderid', '$rate','$message')";
		mysqli_query($db, $sql);

		if(mysqli_affected_rows($db)) {
			echo json_encode(array('error' => 'N', 'msg' => 'Your Feedback Successfully Completed', 'data' => array('buyerReviewed' => $buyerReviewed)), true);
			return true;		
		}else{
			echo json_encode(array('error' => 'Y', 'msg' => 'Your Feedback not Completed', 'data' => array('buyerReviewed' => '')), true);
			return true;	
		}
	}else{
		echo json_encode(array('error' => 'Y', 'msg' => 'Data not Found!', 'data' => array('buyerReviewed' => '')), true);
		return true;
	}
  
}
function sendOrderMessages($db){
	if($_GET['code'] == ''){
  	echo json_encode(array('error' => 'Y', 'msg' => 'code not found on requested data'), true);
  	return true;
  }
  if($_POST['senderid'] == ''){
  	echo json_encode(array('error' => 'Y', 'msg' => 'senderid not found on requested data'), true);
  	return true;
  }
  if($_POST['receiverid'] == ''){
  	echo json_encode(array('error' => 'Y', 'msg' => 'receiverid not found on requested data'), true);
  	return true;
  }

  $senderid = mysqli_real_escape_string($db, $_POST['senderid']);
  $receiverid = mysqli_real_escape_string($db, $_POST['receiverid']);
	$message = mysqli_real_escape_string($db, $_POST['message']);

	$orderid = mysqli_real_escape_string($db, $_GET['code']);
	
	$sql = "INSERT INTO order_messages (orderid,senderid, receiverid,message) VALUES ('$orderid','$senderid', '$receiverid', '$message')";
	mysqli_query($db, $sql);

	if(mysqli_affected_rows($db)) {
		echo json_encode(array('error' => 'N', 'msg' => 'your message Successfully Delivered', 'message' => $_POST['message']), true);
		return true;		
	}else{
		echo json_encode(array('error' => 'Y', 'msg' => 'your message not completed'), true);
		return true;	
	}
}

function sendOrderConfirmation($db){
	if(!isset($_POST['orderid']) || $_POST['orderid'] == ''){
  	echo json_encode(array('error' => 'Y', 'msg' => 'orderid not found on requested data'), true);
  	return true;
  }
  if(!isset($_POST['receiverid']) || $_POST['receiverid'] == ''){
  	echo json_encode(array('error' => 'Y', 'msg' => 'receiverid not found on requested data'), true);
  	return true;
  }
  if(!isset($_POST['senderid']) || $_POST['senderid'] == ''){
  	echo json_encode(array('error' => 'Y', 'msg' => 'senderid not found on requested data'), true);
  	return true;
  }
  if(!isset($_POST['message']) || $_POST['message'] == ''){
  	echo json_encode(array('error' => 'Y', 'msg' => 'message not found on requested data'), true);
  	return true;
  }
  if(!($_POST['status']) || $_POST['status'] == ''){
  	echo json_encode(array('error' => 'Y', 'msg' => 'status not found on requested data'), true);
  	return true;
  }
  if(!isset($_POST['isSeller']) || $_POST['isSeller'] == ''){
  	echo json_encode(array('error' => 'Y', 'msg' => 'status not found on requested data'), true);
  	return true;
  }
  if($_POST['status'] == 'o_delivery_complete'){
  	$noti = 'Seller Delivered your Order!';
  }else if($_POST['status'] == 'o_delivery_complete_accept'){
  	$noti = 'Your Order Delivery Accepted From Buyer!';
  }else if($_POST['status'] == 'o_delivery_complete_decline'){
  	$noti = 'Your Order Delivery Declined From Buyer!';
  }else if($_POST['status'] == 'o_seller_cancel'){
  	$noti = 'Your Order Cancel From Seller';
  }else if($_POST['status'] == 'o_buyer_cancel'){
  	$noti = 'Your Order Cancel From Buyer';
  	
  }else if($_POST['status'] == 'o_cancel_accept'){
  	$noti = 'Your Order Cancellation Accepted From';
  	if((int)$_POST['isSeller']){
  		$noti .= ' Seller!';
  	}else{
  		$noti .= ' Buyer!';
  	}
  }else if($_POST['status'] == 'o_cance_decline'){
  	$noti = 'Your Order Cancellation Declined From';
  	if((int)$_POST['isSeller']){
  		$noti .= ' Seller!';
  	}else{
  		$noti .= ' Buyer!';
  	}
  }else{
  	$noti = '';
  }
  
  $orderid = mysqli_real_escape_string($db, $_POST['orderid']);
	$status = mysqli_real_escape_string($db, $_POST['status']);
	$sql = "UPDATE orders SET status='$status' WHERE id='$orderid'";
	mysqli_query($db, $sql);
	if(mysqli_affected_rows($db)) {

			$userid = mysqli_real_escape_string($db, $_POST['receiverid']);
			$orderid = mysqli_real_escape_string($db, $_POST['orderid']);
			$link = mysqli_real_escape_string($db, URL.'/order?cc='.base64_encode($orderid).'&confirm=1');
			$sql = "INSERT INTO notification (userid,orderid,link,comments) VALUES ('$userid','$orderid', '$link', '$noti')";
			mysqli_query($db, $sql);

			if($_POST['status'] == 'o_delivery_complete'){

				$sql = "UPDATE orders_track SET active='0',new='0',delivered='1' WHERE orderid='$orderid'";
				mysqli_query($db, $sql);
				echo json_encode(array('error' => 'N', 'msg' => 'your order Successfully Delivered', 'data' => array('orderid' => $orderid,'receiverid' => $_POST['receiverid'], 'senderid' => $_POST['senderid'], 'message' => $_POST['message'], 'status' => $_POST['status'])), true);
		  		return true;	

			}else if($_POST['status'] == 'o_delivery_complete_accept'){

				$sql = "UPDATE orders_track SET active='0',new='0',delivered='0',completed='1' WHERE orderid='$orderid'";
				mysqli_query($db, $sql);
				echo json_encode(array('error' => 'N', 'msg' => 'your order Successfully Completed', 'data' => array('orderid' => $orderid,'receiverid' => $_POST['receiverid'], 'senderid' => $_POST['senderid'], 'message' => $_POST['message'], 'status' => $_POST['status'])), true);
		  		return true;	

			}else if($_POST['status'] == 'o_cancel_accept'){

				$sql = "UPDATE orders_track SET active='0',new='0',delivered='0',cancelled='1' WHERE orderid='$orderid'";
				mysqli_query($db, $sql);
				echo json_encode(array('error' => 'N', 'msg' => 'your order Successfully Cancelled', 'data' => array('orderid' => $orderid,'receiverid' => $_POST['receiverid'], 'senderid' => $_POST['senderid'], 'message' => $_POST['message'], 'status' => $_POST['status'])), true);
		  		return true;	

			}else if($_POST['status'] == 'o_delivery_complete_decline' || $_POST['status'] == 'o_cancel_decline'){

				$sql = "UPDATE orders_track SET active='1',new='1',delivered='0',cancelled='0' WHERE orderid='$orderid'";
				mysqli_query($db, $sql);
				echo json_encode(array('error' => 'N', 'msg' => 'your order Completion Declined!', 'data' => array('orderid' => $orderid,'receiverid' => $_POST['receiverid'], 'senderid' => $_POST['senderid'], 'message' => $_POST['message'], 'status' => $_POST['status'])), true);
		  		return true;

			}else if($_POST['status'] == 'o_seller_cancel' || $_POST['status'] == 'o_buyer_cancel'){

				$sql = "UPDATE orders_track SET active='1',new='1',delivered='0',cancelled='0' WHERE orderid='$orderid'";
				mysqli_query($db, $sql);
				echo json_encode(array('error' => 'N', 'msg' => 'your order Successfully cancelled', 'data' => array('orderid' => $orderid,'receiverid' => $_POST['receiverid'], 'senderid' => $_POST['senderid'], 'message' => $_POST['message'], 'status' => $_POST['status'])), true);
		  		return true;

			}else{
				echo json_encode(array('error' => 'N', 'msg' => 'your order Successfully Delivered', 'data' => array('orderid' => $orderid,'receiverid' => $_POST['receiverid'], 'senderid' => $_POST['senderid'], 'message' => $_POST['message'], 'status' => $_POST['status'])), true);
	  			return true;		
			}
	}else{
		echo json_encode(array('error' => 'N', 'msg' => 'order status already updated', 'data' => $_POST), true);
		return true;	
	}
}
function deliverOrder($db){
	if(!isset($_POST['orderid']) || $_POST['orderid'] == ''){
  	echo json_encode(array('error' => 'Y', 'msg' => 'orderid not found on requested data'), true);
  	return true;
  }

  $orderid = mysqli_real_escape_string($db, $_POST['orderid']);
  $sql = "SELECT orders.*,balance.id as balanceid, balance.pending_clearance,balance.selling_price,balance.balance,balance.balance_in_month FROM orders,balance WHERE orders.id='$orderid' and balance.userid=orders.userid";

  $result = mysqli_query($db, $sql);
	$orderData = mysqli_fetch_array($result, MYSQLI_ASSOC);

	if($orderData['offerid']){
		$offerid = mysqli_real_escape_string($db, $orderData['offerid']);
		$sql ="SELECT budget from sendoffer where id='$offerid'";
		$result = mysqli_query($db, $sql);
		$orderData['budget'] = mysqli_fetch_array($result, MYSQLI_ASSOC)['budget'];
	}else{
		$serviceid = mysqli_real_escape_string($db, $orderData['serviceid']);
		$sql ="SELECT user_services.price as budget from user_services where id='$serviceid'";
		$result = mysqli_query($db, $sql);
		$orderData['budget'] = mysqli_fetch_array($result, MYSQLI_ASSOC)['budget'];
	}

	$updatedat = date('Y-m-d H:i:s');
	$sql = "UPDATE orders SET updatedat='$updatedat' WHERE id='$orderid' and status='o_delivery_complete_accept'";
	mysqli_query($db, $sql);


	$balanceid = mysqli_real_escape_string($db, $orderData['balanceid']);
	$pending_clearance = mysqli_real_escape_string($db, $orderData['pending_clearance']+$orderData['budget']);
	$sql = "UPDATE balance SET pending_clearance='$pending_clearance' WHERE id='$balanceid'";
	mysqli_query($db, $sql);

	if(mysqli_affected_rows($db)) {
		
		$userid = mysqli_real_escape_string($db, $orderData['buyerid']);
		$orderid = mysqli_real_escape_string($db, $orderData['id']);
		/*$link = mysqli_real_escape_string($db, URL.'/order?cc='.base64_encode($orderid));
		$sql = "INSERT INTO notification (userid,orderid,link,comments) VALUES ('$userid','$orderid', '$link', 'your order mark as completed')";
		mysqli_query($db, $sql);

		if(mysqli_affected_rows($db)) {
			$sql = "UPDATE orders_track SET active='0',new='0',delivered='0',completed='1' WHERE orderid='$orderid'";
			mysqli_query($db, $sql);

			if(mysqli_affected_rows($db)) {
				
				$sql = "UPDATE postrequest SET status='complete' WHERE orderid='$orderid'";
				mysqli_query($db, $sql);

				echo json_encode(array('error' => 'N', 'msg' => 'your order Successfully Delivered'), true);
	  		return true;		
			}else{
				echo json_encode(array('error' => 'Y', 'msg' => 'Order Tracking not completed'), true);
  			return true;	
			}
		}else{
			echo json_encode(array('error' => 'Y', 'msg' => 'Notification not completed'), true);
  		return true;	
		}*/
		echo json_encode(array('error' => 'N', 'msg' => 'your order Successfully Delivered'), true);
		return true;
	}else{
		echo json_encode(array('error' => 'Y', 'msg' => 'Balance not completed'), true);
  	return true;
	}
}
function makecc($db){
	if($_POST['cc'] == ''){
  	echo json_encode(array('error' => 'Y', 'msg' => 'cc not found on requested data'), true);
  	return true;
  }

  $orderid = base64_decode($_POST['cc']);
  $orderid = mysqli_real_escape_string($db, $orderid);

	// $sql = "SELECT orders.id,orders.offerid, orders.userid FROM orders,sendoffer WHERE orders.id='$orderid' and sendoffer.id=orders.offerid";
	
	// $result = mysqli_query($db, $sql);
	// $orderData = mysqli_fetch_array($result, MYSQLI_ASSOC);

	$sql = "SELECT id,userid,buyerid FROM orders WHERE id='$orderid'";
  $result = mysqli_query($db, $sql);
	$orderData = mysqli_fetch_array($result, MYSQLI_ASSOC);

	// $orderid = mysqli_real_escape_string($db, $orderData['id']);
	$userid = mysqli_real_escape_string($db, $orderData['userid']);
	$sql = "UPDATE orders SET payment='cleared' WHERE id='$orderid'";
	mysqli_query($db, $sql);
	// $result = mysqli_query($db, $sql);

	if(mysqli_affected_rows($db)) {
		
		$sql = "INSERT INTO payment (payment_type,userid,orderid) VALUES ('paypal','$userid', '$orderid')";
		mysqli_query($db, $sql);
		if(mysqli_affected_rows($db)) {

			$sql = "INSERT INTO orders_track (orderid,userid,active, new) VALUES ('$orderid','$userid', '1', '1')";
			mysqli_query($db, $sql);
			if(mysqli_affected_rows($db)) {
				echo json_encode(array('error' => 'N', 'msg' => 'Service Success'), true);	
				return true;	
			}else{
				echo json_encode(array('error' => 'Y', 'msg' => 'Service Failed of Order Tracking'), true);	
				return true;	
			}

		}else{
			echo json_encode(array('error' => 'Y', 'msg' => 'Service Failed of Payment'), true);
			return true;
		}

	}else{
	  echo json_encode(array('error' => 'Y', 'msg' => 'Service Failed of Orders'), true);
	  return true;	
	}
}
function manage_sales($db){
	if($_POST['userid'] == ''){
  	echo json_encode(array('error' => 'Y', 'msg' => 'userid not found on requested data'), true);
  	return true;
  }
  if($_POST['status'] == ''){
  	echo json_encode(array('error' => 'Y', 'msg' => 'status not found on requested data'), true);
  	return true;
  }
  if($_GET['limit'] == ''){
  	echo json_encode(array('error' => 'Y', 'msg' => 'limit not found on requested data'), true);
  	return true;
  }
  if($_GET['pn'] == ''){
  	echo json_encode(array('error' => 'Y', 'msg' => 'page number not found on requested data'), true);
  	return true;
  }

	$userid = mysqli_real_escape_string($db, $_POST['userid']);
	// $postrequestid = mysqli_real_escape_string($db, $_POST['postrequestid']);

	if($_POST['status'] == 'active'){
		$sql = "SELECT count(*) FROM orders_track WHERE userid='$userid' and active='1'";
	}else if($_POST['status'] == 'completed'){
		$sql = "SELECT count(*) FROM orders_track WHERE userid='$userid' and completed='1'";
	}else if($_POST['status'] == 'delivered'){
		$sql = "SELECT count(*) FROM orders_track WHERE userid='$userid' and delivered='1'";
	}else if($_POST['status'] == 'cancelled'){
		$sql = "SELECT count(*) FROM orders_track WHERE userid='$userid' and cancelled='1'";
	}else{
		echo json_encode(array('error' => 'Y', 'data' => [], 'msg' => 'status not available or invalid'), true);
		return true;
	}

	$temp = array('data' =>array());
	$query=mysqli_query($db,$sql);
	$row = mysqli_fetch_row($query);
	$temp['total_offer_count'] = $row[0];
 
	$rows = $row[0];
 
	$page_rows = $_GET['limit'];
 
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
 // sendoffer.comments as description,sendoffer.time as deliverytime,sendoffer.type as timetype,
	$limit = 'LIMIT ' .($pagenum - 1) * $page_rows .',' .$page_rows;
 	if($_POST['status'] == 'active'){
		$sql = "SELECT orders.id as orderid, orders.date,orders.offerid,orders.serviceid,orders_track.active,orders_track.delivered,orders_track.completed,orders_track.cancelled,orders_track.new,register.username,register.profile as sellerProfile FROM orders,orders_track,register WHERE orders_track.active='1' and orders.userid='$userid' and orders.status<>'o_cancel_accept' and orders.status<>'o_delivery_complete_accept' and orders_track.orderid=orders.id and orders_track.userid='$userid' and register.id=orders.buyerid GROUP BY orderid $limit";
	}else if($_POST['status'] == 'completed'){
		$sql = "SELECT orders.id as orderid, orders.date,orders.offerid,orders.serviceid,orders_track.active,orders_track.delivered,orders_track.completed,orders_track.cancelled,orders_track.new,register.username,register.profile as sellerProfile FROM orders,orders_track,register WHERE orders_track.completed='1' and orders.userid='$userid' and (orders.status='o_delivery_complete' or orders.status='o_delivery_complete_accept') and orders_track.orderid=orders.id and orders_track.userid='$userid' and register.id=orders.buyerid GROUP BY orderid $limit";
	}else if($_POST['status'] == 'delivered'){
		// $sql = "SELECT count(*) FROM orders_track WHERE userid='$userid' and delivered='1'";
		$sql = "SELECT orders.id as orderid, orders.date,orders.offerid,orders.serviceid,orders_track.active,orders_track.delivered,orders_track.completed,orders_track.cancelled,orders_track.new,register.username,register.profile as sellerProfile FROM orders,orders_track,register WHERE orders_track.delivered='1' and orders.userid='$userid' and orders.status='o_delivery_complete' and orders_track.orderid=orders.id and orders_track.userid='$userid' and register.id=orders.buyerid GROUP BY orderid  $limit";
	}else if($_POST['status'] == 'cancelled'){
		// $sql = "SELECT count(*) FROM orders_track WHERE userid='$userid' and cancelled='1'";
		$sql = "SELECT orders.id as orderid, orders.date,orders.offerid,orders.serviceid,orders_track.active,orders_track.delivered,orders_track.completed,orders_track.cancelled,orders_track.new,register.username,register.profile as sellerProfile FROM orders,orders_track,register WHERE orders_track.cancelled='1' and orders.userid='$userid' and orders.status='o_cancel_accept' and orders_track.orderid=orders.id and orders_track.userid='$userid' and register.id=orders.buyerid GROUP BY orderid  $limit";
	}
 	

	$result = mysqli_query($db, $sql);
	$requests = mysqli_fetch_all($result,MYSQLI_ASSOC);
	$count = mysqli_num_rows($result);
 	$data['data'] = $requests;
 	
 	
 	foreach ($data['data'] as  $key => $value) {
			
			if($value['offerid'] != 0){
				
				$offerid = mysqli_real_escape_string($db, $value['offerid']);
				$sql = "SELECT sendoffer.budget as price, sendoffer.time, sendoffer.type, user_services.title, sendoffer.comments as description, user_services.image FROM sendoffer, user_services WHERE sendoffer.id='$offerid' and user_services.id=sendoffer.serviceid";
				
				$result = mysqli_query($db, $sql);
				$services = mysqli_fetch_array($result,MYSQLI_ASSOC);

			}else if($value['serviceid'] != 0){
				
				$serviceid = mysqli_real_escape_string($db, $value['serviceid']);
				$sql = "SELECT description, price, `time`, type, image, title FROM user_services WHERE id='$serviceid'";
				
				$result = mysqli_query($db, $sql);
				$services = mysqli_fetch_array($result,MYSQLI_ASSOC);

			}
			$temper = array(
				'orderid' => $value['orderid'],
				'description' => $services['description'],
				'deliverytime' => $services['time'],
				'serviceTitle' => $services['title'],
				'budget' => $services['price'],
				'serviceImage' => URL.'/images/services/'.$services['image'],
				'username' => isset($value['username']) ? $value['username']: '',
				'timetype' => $services['type'],
				'date' => date_format(date_create($value['date']), 'd M, Y'),
				'username' => $value['username'],
				'sellerProfile' => URL.'/images/upload/'.$value['sellerProfile']
			);
			array_push($temp['data'], $temper);
	}

	echo json_encode(array('error' => 'N', 'data' => $temp), true);
	return true;
}

function manage_orders($db){
	if($_POST['userid'] == ''){
  	echo json_encode(array('error' => 'Y', 'msg' => 'userid not found on requested data'), true);
  	return true;
  }	
  if($_GET['limit'] == ''){
  	echo json_encode(array('error' => 'Y', 'msg' => 'limit not found on requested data'), true);
  	return true;
  }
  if($_GET['pn'] == ''){
  	echo json_encode(array('error' => 'Y', 'msg' => 'page number not found on requested data'), true);
  	return true;
  }

	$userid = mysqli_real_escape_string($db, $_POST['userid']);
	
	$sql = "SELECT count(*) FROM `orders` WHERE buyerid='$userid' and payment='cleared'";
	// and status<>'o_delivery_complete_accept' and and status<>'o_cancel_accept'

	$query=mysqli_query($db,$sql);
	$row = mysqli_fetch_row($query);
	$data['total_offer_count'] = $row[0];
 
	$rows = $row[0];
 
	$page_rows = $_GET['limit'];
 
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
 	
 	$sql = "SELECT offerid,serviceid,`date`,id FROM orders WHERE orders.buyerid='$userid' and orders.payment='cleared'";
	$result = mysqli_query($db, $sql);
	$confirmOrder = mysqli_fetch_all($result,MYSQLI_ASSOC);
	$temp = array();

	foreach ($confirmOrder as $value) {
		$date = $value['date'];
		if($value['offerid']){
			$id = mysqli_real_escape_string($db, $value['id']);
			$sql = "SELECT orders.id,sendoffer.comments as description,sendoffer.time,sendoffer.type,sendoffer.budget,categories.name as category,subcategories.name as scategory,user_services.image as serviceImage,user_services.title as title,user_services.id as serviceid, orders.date FROM sendoffer, orders, categories, subcategories, user_services WHERE orders.buyerid='$userid' and sendoffer.id=orders.offerid and user_services.id=sendoffer.serviceid and categories.id=user_services.category and subcategories.id=user_services.scategory and orders.id='$id' and orders.payment='cleared' $limit";

		 	$requests=mysqli_query($db,$sql);
		 	$requests = mysqli_fetch_array($requests,MYSQLI_ASSOC);

		}else{
			$serviceid = mysqli_real_escape_string($db, $value['serviceid']);
			$id = mysqli_real_escape_string($db, $value['id']);
			$sql = "SELECT orders.id,user_services.description,user_services.price as budget,user_services.time,user_services.type,categories.name as category,subcategories.name as scategory,user_services.image as serviceImage,user_services.title as title,user_services.id as serviceid FROM orders,user_services,categories,subcategories WHERE orders.buyerid='$userid' and user_services.id='$serviceid' and categories.id=user_services.category and subcategories.id=user_services.scategory and orders.id='$id' and orders.payment='cleared' $limit";
			
			
			$requests=mysqli_query($db,$sql);
			$requests = mysqli_fetch_array($requests,MYSQLI_ASSOC);
		}
		array_push($temp, $requests);
	}

	$count = count($temp);
 	$data['data'] = $temp;
 	
 	foreach ($data['data'] as  $key => $value) {
		$data['data'][$key]['serviceImage'] = URL.'/images/services/'.$value['serviceImage'];
		$data['data'][$key]['date'] = date_format(date_create($value['date']), 'd M, Y');
		$data['data'][$key]['status'] = 'Active';
	}

	echo json_encode(array('error' => 'N', 'data' => $data), true);
	return true;
}
function postRequestSellers($db){

    

	if($_POST['userid'] == ''){
  	echo json_encode(array('error' => 'Y', 'msg' => 'userid not found on requested data'), true);
  	return true;
  }	
  if($_POST['postrequestid'] == ''){
  	echo json_encode(array('error' => 'Y', 'msg' => 'postrequestid not found on requested data'), true);
  	return true;
  }
  if($_GET['limit'] == ''){
  	echo json_encode(array('error' => 'Y', 'msg' => 'limit not found on requested data'), true);
  	return true;
  }
  if($_GET['pn'] == ''){
  	echo json_encode(array('error' => 'Y', 'msg' => 'page number not found on requested data'), true);
  	return true;
  }

	$userid = mysqli_real_escape_string($db, $_POST['userid']);
	$postrequestid = mysqli_real_escape_string($db, $_POST['postrequestid']);
	
	 $sql = "SELECT count(*) FROM sendoffer,orders WHERE sendoffer.revoke='N' and sendoffer.postrequestid='$postrequestid' and orders.offerid<>sendoffer.id GROUP BY sendoffer.id";
   
	$query=mysqli_query($db,$sql);
	$row = mysqli_fetch_row($query);
	
	$data['total_offer_count'] = $row[0];
 
	$rows = $row[0];
 
	$page_rows = $_GET['limit'];
 
	$last = ceil($rows/$page_rows);
 
	if($last < 1){
		echo "case1";
		$last = 1;
	}
 
	$pagenum = 1;
 
	if(isset($_GET['pn'])){
		echo "case2";
		$pagenum = preg_replace('#[^0-9]#', '', $_GET['pn']);
	}
 
	if ($pagenum < 1) { 
		$pagenum = 1;
		echo "case3"; 

	} 
	else if ($pagenum > $last) { 
		$pagenum = $last;
		echo "case4"; 
	}
   

	$limit = 'LIMIT ' .($pagenum - 1) * $page_rows .',' .$page_rows;
	
 	// $nquery=mysqli_query($db,"select * from `user_services` where email='$email' $limit");
 	
 	 

 	 $sql = "SELECT postrequest.id,postrequest.posterid,sendoffer.userid,sendoffer.id as offerid,sendoffer.comments as description,sendoffer.serviceid,sendoffer.budget,sendoffer.time,sendoffer.type,sendoffer.date,categories.name as category,subcategories.name as scategory, register.username,register.profile as sellerProfile, register.id as sellerid FROM postrequest,sendoffer,categories,subcategories,register,orders WHERE sendoffer.revoke='N' and sendoffer.postrequestid='$postrequestid' and postrequest.id='$postrequestid' and postrequest.category=categories.id and postrequest.scategory=subcategories.id and orders.offerid<>sendoffer.id and register.id=sendoffer.userid GROUP BY sendoffer.id $limit";
    
	$result = mysqli_query($db, $sql);
	$requests = mysqli_fetch_all($result,MYSQLI_ASSOC);
	$count = mysqli_num_rows($result);

 	$data['data'] = $requests;
 	
 	if($last != 1){
	 
		if ($pagenum > 1) {
	      $previous = $pagenum - 1;
				$data['previous'] = $previous;
	 
			if ($pagenum != $last) {
	        $next = $pagenum + 1;
	     		$data['next'] = $next;   
	    }
		}
	}
	foreach ($data['data'] as  $key => $value) {
		$data['data'][$key]['sellerProfile'] = URL.'/images/upload/'.$value['sellerProfile'];
		$data['data'][$key]['date'] = date_format(date_create($value['date']), 'd M, Y');
		$data['data'][$key]['rating'] = '4.5';

		$buyerid = mysqli_real_escape_string($db, $_POST['userid']);
		$freelancerid = mysqli_real_escape_string($db, $data['data'][$key]['userid']);
		$serviceid = mysqli_real_escape_string($db, $data['data'][$key]['serviceid']);
		$sql = "SELECT * FROM room WHERE (buyerid='$buyerid' and freelancerid='$freelancerid')  or (buyerid='$freelancerid' and freelancerid='$buyerid')";
		$result = mysqli_query($db, $sql);
		$room = mysqli_fetch_all($result,MYSQLI_ASSOC);
		$data['data'][$key]['room'] = count($room) ? $room[0]['room'] : '';
	}

	echo json_encode(array('error' => 'N', 'data' => $data), true);
	return true;
}
function revokeOffer($db){
	if($_POST['buyerid'] == ''){
  	echo json_encode(array('error' => 'Y', 'msg' => 'buyerid not found on requested data'), true);
  	return true;
  }	
  if($_POST['postrequestid'] == ''){
  	echo json_encode(array('error' => 'Y', 'msg' => 'category not found on requested data'), true);
  	return true;
  }
  
  $postrequestid = mysqli_real_escape_string($db, $_POST['postrequestid']);
  $sql = "UPDATE postrequest SET `revoke`='Y' WHERE id='$postrequestid'";
 	mysqli_query($db, $sql);

 	if(mysqli_affected_rows($db)) {
 		echo json_encode(array('error' => 'N', 'msg' => 'Revoke Added Successfully', 'postrequestid'=>$_POST['postrequestid']), true);
 		return true;
  }else{
    echo json_encode(array('error' => 'Y', 'msg' => 'Revoke Failed'), true);
    return true;
  }
}

function revokeSellerFromOffer($db){
	if($_POST['userid'] == ''){
  	echo json_encode(array('error' => 'Y', 'msg' => 'userid not found on requested data'), true);
  	return true;
  }	
  if($_POST['buyerid'] == ''){
  	echo json_encode(array('error' => 'Y', 'msg' => 'buyerid not found on requested data'), true);
  	return true;
  }
  if($_POST['offerid'] == ''){
  	echo json_encode(array('error' => 'Y', 'msg' => 'offerid not found on requested data'), true);
  	return true;
  }
  
  $offerid = mysqli_real_escape_string($db, $_POST['offerid']);

  $sql = "UPDATE sendoffer SET `revoke`='Y' WHERE id='$offerid'";
  mysqli_query($db, $sql);

 	if(mysqli_affected_rows($db)) {
 		echo json_encode(array('error' => 'N', 'msg' => 'Revoke Added Successfully', 'offerid'=>$_POST['offerid']), true);
 		return true;
  }else{
    echo json_encode(array('error' => 'Y', 'msg' => 'Revoke Failed'), true);
    return true;
  }
}

function getServiceOnUserCategory($db){
	if($_POST['userid'] == ''){
  	echo json_encode(array('error' => 'Y', 'msg' => 'userid not found on requested data'), true);
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
  $userid = mysqli_real_escape_string($db, $_POST['userid']);
  $category = mysqli_real_escape_string($db, $_POST['category']);
  $scategory = mysqli_real_escape_string($db, $_POST['scategory']);

  $sql = "SELECT user_services.id, user_services.title as service_title,user_services.description,user_services.image,categories.name as category,subcategories.name as scategory FROM user_services, categories, subcategories WHERE user_services.userid='$userid' and user_services.category='$category' and user_services.scategory='$scategory' and categories.id ='$category' and subcategories.id='$scategory'";

	$result = mysqli_query($db, $sql);
	$data = mysqli_fetch_array($result,MYSQLI_ASSOC);

	$data['image'] = URL.'/images/services/'.$data['image'];

	echo json_encode(array('error' => 'N', 'data' => $data), true);
	return true;
}
function buyerRequest($db){

	if($_POST['userid'] == ''){
  	echo json_encode(array('error' => 'Y', 'msg' => 'userid not found on requested data'), true);
  	return true;
  }
  $userid = mysqli_real_escape_string($db, $_POST['userid']);
	/*$sql = "SELECT postrequest.id, postrequest.posterid as buyerid, postrequest.description,postrequest.time,postrequest.type,postrequest.date,postrequest.budget, categories.name as category, subcategories.name as scategory,register.profile,register.username, user_services.id as serviceid from postrequest, categories, subcategories, register,user_services where postrequest.category = categories.id and postrequest.scategory = subcategories.id and postrequest.posterid = register.id and postrequest.posterid <> '$userid' and user_services.userid = '$userid' and user_services.category = postrequest.category and user_services.scategory = postrequest.scategory GROUP BY id";*/

	$sql = "SELECT postrequest.id, postrequest.description, postrequest.time, postrequest.type, postrequest.budget, postrequest.date,postrequest.posterid,user_services.id as serviceid,register.profile,register.username,categories.name as category, subcategories.name as scategory,
		subcategories.id as sub_cat_id,
		categories.id as cat_id
		FROM postrequest,user_services,register,categories, subcategories
		WHERE postrequest.posterid <>  '$userid'
		AND user_services.userid = '$userid'
		AND user_services.category = postrequest.category
		AND user_services.scategory = postrequest.scategory
		AND register.id = postrequest.posterid
		AND categories.id = user_services.category 
		AND subcategories.id = user_services.scategory
		GROUP BY id";

	$result = mysqli_query($db, $sql);
	$data = mysqli_fetch_all($result,MYSQLI_ASSOC);

	$result = mysqli_query($db, $sql);
	$requests = mysqli_fetch_all($result,MYSQLI_ASSOC);
	$temp = array();
	foreach ($requests as $key => $value) {
		
		$requests[$key]['profile'] = URL.'/images/upload/'.$value['profile'];
	 	$requests[$key]['date'] = date_format(date_create($value['date']),"M d, Y");

		$postrequestid = mysqli_real_escape_string($db, $value['id']);
		$sql = "SELECT count(*) as total FROM sendoffer WHERE userid='$userid' and postrequestid='$postrequestid'";
		$result = mysqli_query($db, $sql);
		$result = mysqli_fetch_array($result,MYSQLI_ASSOC);
		$requests[$key]['offer_sent_count'] = $result['total'];
		
		if($requests[$key]['offer_sent_count'] == 0){
			array_push($temp, $requests[$key]);
		}
	}
	echo json_encode(array('error' => 'N', 'data' => $temp, 'counts' => count($temp)), true);
	return true;

}
function sellerRequest($db){

	if($_POST['userid'] == ''){
  	echo json_encode(array('error' => 'Y', 'msg' => 'userid not found on requested data'), true);
  	return true;
  }
  $userid = mysqli_real_escape_string($db, $_POST['userid']);

  $sql = "SELECT postrequest.id, postrequest.posterid as buyerid,sendoffer.comments as description,user_services.id as serviceid,sendoffer.time,sendoffer.type,sendoffer.date,sendoffer.budget, categories.name as category, subcategories.name as scategory,register.profile,register.username, postrequest.date from postrequest, categories, subcategories, register,user_services,sendoffer where postrequest.category = categories.id and postrequest.scategory = subcategories.id and postrequest.posterid = register.id and postrequest.posterid = '$userid' and user_services.id = sendoffer.serviceid and sendoffer.postrequestid = postrequest.id GROUP BY id";

	$result = mysqli_query($db, $sql);
	$data = mysqli_fetch_all($result,MYSQLI_ASSOC);

	foreach ($data as $key => $value) {
		$data[$key]['profile'] = URL.'/images/upload/'.$value['profile'];
	 	$data[$key]['date'] = date_format(date_create($value['date']),"M d, Y");

	 	$postrequestid = mysqli_real_escape_string($db, $value['id']);
		$sql = "SELECT count(*) as total FROM sendoffer WHERE postrequestid='$postrequestid'";
		
		$result = mysqli_query($db, $sql);
		$data[$key]['offer_sent_count'] = mysqli_fetch_array($result,MYSQLI_ASSOC)['total'];

	}
	
	echo json_encode(array('error' => 'N', 'data' => $data, 'counts' => count($data)), true);
	return true;

}
function postSendOffer($db){

	if($_POST['comments'] == ''){
  	echo json_encode(array('error' => 'Y', 'msg' => 'comments not found on requested data'), true);
  	return true;
  }
  if($_POST['serviceid'] == ''){
  	echo json_encode(array('error' => 'Y', 'msg' => 'serviceid not found on requested data'), true);
  	return true;
  }
  if($_POST['postrequestid'] == ''){
  	echo json_encode(array('error' => 'Y', 'msg' => 'postrequestid not found on requested data'), true);
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

	  if($_POST['requesterid'] == ''){
	  	echo json_encode(array('error' => 'Y', 'msg' => 'requesterid not found on requested data'), true);
	  	return true;
	  }
		$requesterid = mysqli_real_escape_string($db, $_POST['requesterid']);
  }else{
  	$requesterid = mysqli_real_escape_string($db, $_SESSION['id']);
  }

  $postrequestid = mysqli_real_escape_string($db, $_POST['postrequestid']);
  $serviceid = mysqli_real_escape_string($db, $_POST['serviceid']);
  $comments = mysqli_real_escape_string($db, $_POST['comments']);
	$time = mysqli_real_escape_string($db, $_POST['time']);
	$type = mysqli_real_escape_string($db, $_POST['type']);  
	$budget = mysqli_real_escape_string($db, $_POST['budget']);  

  
  $sql = "INSERT INTO sendoffer (userid,serviceid,postrequestid,comments,`time`,type,budget) VALUES ('$requesterid','$serviceid','$postrequestid','$comments','$time','$type','$budget')";
 	mysqli_query($db, $sql);
 	
 	if(mysqli_affected_rows($db)) {
 		echo json_encode(array('error' => 'N', 'msg' => 'Offer Successfully Sent!!'), true);
 		return true;
 	}else{
 		echo json_encode(array('error' => 'N', 'msg' => 'Offer not Sent'), true);
 		return true;
 	}

}
function acceptOffer($db){

	if(isset($_POST['postrequestid']) && isset($_POST['postrequestid'])){

		if($_POST['postrequestid'] == ''){
	  	echo json_encode(array('error' => 'Y', 'msg' => 'budget not found on requested data'), true);
	  	return true;
	  }
	  if($_POST['offerid'] == ''){
	  	echo json_encode(array('error' => 'Y', 'msg' => 'offerid not found on requested data'), true);
	  	return true;
	  }
	  $postrequestid = mysqli_real_escape_string($db, $_POST['postrequestid']);
  	$offerid = mysqli_real_escape_string($db, $_POST['offerid']);
	}else{
		if($_POST['serviceid'] == ''){
	  	echo json_encode(array('error' => 'Y', 'msg' => 'serviceid not found on requested data'), true);
	  	return true;
	  }		
	}

  if($_POST['sellerid'] == ''){
  	echo json_encode(array('error' => 'Y', 'msg' => 'sellerid not found on requested data'), true);
  	return true;
  }

  $sellerid = mysqli_real_escape_string($db, $_POST['sellerid']);

  if(isset($_POST['postrequestid']) && isset($_POST['postrequestid'])){
		$sql = "SELECT sendoffer.id as offerid, postrequest.posterid as buyerid FROM postrequest,sendoffer WHERE postrequest.id='$postrequestid' and sendoffer.postrequestid='$postrequestid' and sendoffer.id='$offerid' and sendoffer.userid='$sellerid'";
		$result = mysqli_query($db, $sql);
		$postrequest = mysqli_fetch_all($result, MYSQLI_ASSOC);
		
		if(!count($postrequest)){
			echo json_encode(array('error' => 'Y', 'msg' => 'post request not found !'), true);
	  	return true;
		}
		$offerid = mysqli_real_escape_string($db, $postrequest[0]['offerid']);
		$buyerid = mysqli_real_escape_string($db, $postrequest[0]['buyerid']);
		$serviceid = 0;
	}else{
		$offerid =0;
		$serviceid = mysqli_real_escape_string($db, $_POST['serviceid']);
		$buyerid = mysqli_real_escape_string($db, $_SESSION['id']);
	}

	$sellerid = mysqli_real_escape_string($db, $_POST['sellerid']);

	$sql = "SELECT count(*) as total, id FROM orders WHERE userid='$sellerid' and buyerid='$buyerid' and serviceid='$serviceid' and offerid='$offerid' and status='pending'";
	$result = mysqli_query($db, $sql);
	$orderData = mysqli_fetch_array($result, MYSQLI_ASSOC);
	if($orderData == null || $orderData['total'] == 0){

		$sql = "INSERT INTO orders (userid, buyerid, offerid, serviceid) VALUES ('$sellerid','$buyerid', '$offerid', '$serviceid')";
	 	mysqli_query($db, $sql);

	 	if(mysqli_affected_rows($db)) {
	 			echo json_encode(array('error' => 'N', 'msg' => 'Order Successfully Posted', 'order' => base64_encode((string)mysqli_insert_id($db)), 'orderid' => (string)mysqli_insert_id($db)), true);
	 	}else{
	 		echo json_encode(array('error' => 'N', 'msg' => 'Order not Posted'), true);
	 	}
	}else{
		echo json_encode(array('error' => 'N', 'msg' => 'Order Already Posted', 'order' => base64_encode((string)$orderData['id']), 'orderid' => (string)(string)$orderData['id']), true);
	}

}

function encrypt($pure_string) {
    $dirty = array("+", "/", "=");
    $clean = array("_PLUS_", "_SLASH_", "_EQUALS_");
    $iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
    $_SESSION['iv'] = mcrypt_create_iv($iv_size, MCRYPT_RAND);
    $encrypted_string = mcrypt_encrypt(MCRYPT_BLOWFISH, ENCR, utf8_encode($pure_string), MCRYPT_MODE_ECB, IV);
    $encrypted_string = base64_encode($encrypted_string);
    return str_replace($dirty, $clean, $encrypted_string);
}

function getAllCities($db){
	$sql = "SELECT * from city";
	$result = mysqli_query($db, $sql);
	$data = mysqli_fetch_all($result, MYSQLI_ASSOC);

	echo json_encode(array('error' => 'N', 'data' => $data), true);
	return true;
}
function getNotiList($db){
	if($_POST['userid'] == '' || (int)$_POST['userid'] == 0){
  	echo json_encode(array('error' => 'Y', 'msg' => 'userid not found on requested data'), true);
  	return true;
  }

  $userid = mysqli_real_escape_string($db, $_POST['userid']);
	$sql = "SELECT comments, `date`,id,is_seen from notification where userid='$userid'";
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
	$sql = "SELECT user_services.title as service_title, user_services.id as service_id, user_services.image from user_services, favorites where user_services.id=favorites.serviceid and favorites.userid='$userid' and user_services.userid <> '$userid' GROUP BY service_id";
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
	$sql = "SELECT subcategories.name, subcategories.id as scatid, categories.id as catid from user_services, subcategories, categories where subcategories.id = user_services.scategory and categories.id = subcategories.category and user_services.city='$cid' GROUP BY scatid";
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
function ManageReviewData($db){

	if($_POST['userid'] == ''){
  	echo json_encode(array('error' => 'Y', 'msg' => 'userid not found on requested data'), true);
  	return true;
  }

  $userid = mysqli_real_escape_string($db, $_POST['userid']);

	$sql = "SELECT service_review.price, service_review.rate,service_review.date,service_review.text,service_review.text, register.username as buyer_name, register.profile as buyer_profile, user_services.title as service_title, subcategories.name as subcategory FROM service_review, user_services, subcategories, register WHERE user_services.id = service_review.serviceid and register.email=service_review.email and subcategories.id=user_services.scategory and service_review.userid = '$userid'";

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

function postRequestData($db){

	if($_POST['userid'] == ''){
  	echo json_encode(array('error' => 'Y', 'msg' => 'userid not found on requested data'), true);
  	return true;
  }

  if($_GET['limit'] == ''){
  	echo json_encode(array('error' => 'Y', 'msg' => 'limit not found on requested data'), true);
  	return true;
  }
  if($_GET['pn'] == ''){
  	echo json_encode(array('error' => 'Y', 'msg' => 'page number not found on requested data'), true);
  	return true;
  }


	$userid = mysqli_real_escape_string($db, $_POST['userid']);
	$sql = "SELECT count(postrequest.id) FROM postrequest, categories, subcategories WHERE postrequest.posterid='$userid' and postrequest.revoke='N' and categories.id=postrequest.category and subcategories.id=postrequest.scategory and postrequest.status<>'complete'";

	$query=mysqli_query($db,$sql);
	$row = mysqli_fetch_row($query);
 	$requestscount = $row[0];
 	$total_offer_count = $row[0];
	$rows = $row[0];
 
	$page_rows = $_GET['limit'];
 
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
	
	/*$sql = "SELECT postrequest.id, postrequest.description,postrequest.time,postrequest.type,postrequest.budget,postrequest.posterid, categories.name as category, subcategories.name as scategory,register.profile,register.username from postrequest, categories, subcategories, register,user_services where postrequest.category = categories.id and postrequest.scategory = subcategories.id and postrequest.posterid = register.id and postrequest.posterid <> '$userid' and user_services.userid = '$userid' and user_services.category = postrequest.category and user_services.scategory = postrequest.scategory GROUP BY id";
	
	$result = mysqli_query($db, $sql);
	$postrequest = mysqli_fetch_all($result, MYSQLI_ASSOC);*/


	$sql = "SELECT postrequest.id,postrequest.time,postrequest.type,postrequest.date,postrequest.budget,postrequest.posterid,postrequest.description, categories.name as category, subcategories.name as scategory FROM postrequest, categories, subcategories WHERE postrequest.posterid='$userid' and postrequest.revoke='N' and categories.id=postrequest.category and subcategories.id=postrequest.scategory and postrequest.status<>'complete' $limit";

	$result = mysqli_query($db, $sql);
	$requests = mysqli_fetch_all($result,MYSQLI_ASSOC);
	$data = $requests;
 	$count = mysqli_num_rows($result);

	foreach ($data as $key => $value) {
		// $data['data'][$key]['sellerProfile'] = URL.'/images/upload/'.$value['sellerProfile'];
		$data[$key]['date'] = date_format(date_create($value['date']), 'd M, Y');
		$postrequestid = mysqli_real_escape_string($db, $value['id']);
		$sql = "SELECT count(*) as total FROM sendoffer WHERE postrequestid='$postrequestid' and `revoke`='N'";
		$result = mysqli_query($db, $sql);
		$data[$key]['totalSellers'] = mysqli_fetch_array($result,MYSQLI_ASSOC)['total'];
	}
	echo json_encode(array('error' => 'N', 'data' => $data, 'total_offer_count' => $total_offer_count), true);
	return true;
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
	$posterid = mysqli_real_escape_string($db, $_POST['posterid']);
  }else{
  	$posterid = mysqli_real_escape_string($db, $_SESSION['id']);
  }	

  
  $description = mysqli_real_escape_string($db, $_POST['description']);
  $category = mysqli_real_escape_string($db, $_POST['category']);
  $scategory = mysqli_real_escape_string($db, $_POST['scategory']);
  $time = mysqli_real_escape_string($db, $_POST['time']); 
  $type = mysqli_real_escape_string($db, $_POST['type']); 
  $budget = mysqli_real_escape_string($db, $_POST['budget']);

  $sql = "SELECT city FROM register WHERE id='$posterid'";
	$result = mysqli_query($db, $sql);

  $sql = "INSERT INTO postrequest (description, category, scategory, `time`, type, budget, posterid) VALUES ('$description','$category','$scategory','$time','$type','$budget','$posterid')";
 	mysqli_query($db, $sql);

 	if(mysqli_affected_rows($db)) {
 		if(isset($_POST['suggest']) && (string)$_POST['suggest'] != '' && (int)$_POST['category'] == 8 && (int)$_POST['scategory'] == 52){
 			$suggest = mysqli_real_escape_string($db, $_POST['suggest']);
 			$sql = "INSERT INTO suggestservices (userid, suggest_text) VALUES ('$posterid', '$suggest')";
 			mysqli_query($db, $sql);

 			echo json_encode(array('error' => 'N', 'msg' => 'request Successfully Posted'), true);
 			return true;
 		}else{
 			echo json_encode(array('error' => 'N', 'msg' => 'request Successfully Posted'), true);
 			return true;	
 		}
 	}else{
 		echo json_encode(array('error' => 'N', 'msg' => 'request not Posted'), true);
 	}

}
function topUserServices(){
	
}
function getUserServices($db){
	if($_POST['email'] == ''){
  	echo json_encode(array('error' => 'Y', 'msg' => 'email not found on requested data'), true);
  	return true
;  }
  $email = mysqli_real_escape_string($db, $_POST['email']);
  
  /*$sql = "SELECT a.id, a.category, a.scategory, a.image, a.description, a.title,a.price a.time,a.type,b.name,s.rate FROM user_services a, categories b WHERE a.category = b.id and a.email = '$email'";*/

  $sql = "SELECT user_services.id, user_services.image, user_services.title, user_services.description, user_services.price, user_services.time, user_services.type, categories.name as category, subcategories.name as scategory ,user_services.city FROM user_services,categories,subcategories WHERE email='$email' and categories.id=user_services.category and subcategories.id=user_services.scategory";

  $result = mysqli_query($db, $sql);
  if (!$result) {
    printf("Error: %s\n", mysqli_error($db));
    exit();
	}
	$data = mysqli_fetch_all($result, MYSQLI_ASSOC);
	foreach ($data as $key => $value) {
		
		$id = mysqli_real_escape_string($db, $value['id']);
		
		$sql = "SELECT sum(rate) as totalrate, count(*) as totalcount FROM service_review WHERE serviceid='$id'";
		$result = mysqli_query($db, $sql);
		$result = mysqli_fetch_array($result, MYSQLI_ASSOC);
		if(isset($result['totalrate']) && $result['totalrate'] && $result['totalcount']){
			$data[$key]['rate'] = $result['totalrate']/$result['totalcount'];
		}else{
			$data[$key]['rate'] = 0;
		}
		$data[$key]['image'] = URL.'/images/services/'.$value['image'];
		$data[$key]['service_title'] = $value['title'];
	}

	echo json_encode(array('error' => 'N', 'data' => $data), true);
}

function getServicess($db){
	if($_GET['cid'] == ''  || (int)$_GET['cid'] == 0){
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
  if($_GET['userid'] == ''){
  	echo json_encode(array('error' => 'Y', 'msg' => 'userid not found on requested data'), true);
  	return true;
  }
  	$userid = mysqli_real_escape_string($db, $_GET['userid']);
 	 if((int)$_GET['cid'] > 0){
  	$cid = mysqli_real_escape_string($db, $_GET['cid']);
  	if((int)$_GET['scategory'] == 0 && (int)$_GET['category'] == 0 && (int)$_GET['search'] == 0){
  		    $sql = "SELECT register.speak, register.username, register.profile as userprofile, register.description as userDescription, user_services.id, user_services.userid, city.name as cityName, user_services.category, user_services.scategory, user_services.image, user_services.description, user_services.title,user_services.price, categories.name as category, subcategories.name as scategory FROM user_services, categories, subcategories, city, register  WHERE user_services.city = city.id and categories.id = user_services.category and subcategories.id = user_services.scategory and user_services.city = '$cid'
  			    and user_services.userid = register.id and user_services.userid<>'$userid' GROUP BY id";
  	}else if((int)$_GET['scategory'] > 0 && (int)$_GET['category'] == 0){
	  	$scategory = mysqli_real_escape_string($db, $_GET['scategory']);
			$sql = "SELECT register.speak, register.username, register.profile as userprofile, register.description as userDescription, user_services.id, user_services.userid, city.name as cityName, user_services.category, user_services.scategory, user_services.image, user_services.description, user_services.title,user_services.price, categories.name as category, subcategories.name as scategory FROM user_services, categories, subcategories, city, register  WHERE user_services.city = city.id and categories.id = user_services.category and subcategories.id = user_services.scategory and user_services.scategory = '$scategory' and user_services.city = '$cid' and user_services.userid<>'$userid' GROUP BY id";
		}else if((int)$_GET['category'] > 0 && (int)$_GET['scategory'] == 0){
	  	$category = mysqli_real_escape_string($db, $_GET['category']);
			$sql = "SELECT register.speak, register.username, register.profile as userprofile, register.description as userDescription, user_services.id, user_services.userid, city.name as cityName, user_services.category, user_services.scategory, user_services.image, user_services.description, user_services.title,user_services.price, categories.name as category, subcategories.name as scategory FROM user_services, categories, subcategories, city,register  WHERE user_services.city = city.id and categories.id = user_services.category and subcategories.id = user_services.scategory and user_services.category = '$category' and user_services.city = '$cid' and user_services.userid = register.id and user_services.userid<>'$userid' GROUP BY id";
	  }else if((int)$_GET['category'] > 0 && (int)$_GET['scategory'] > 0){
	  	$category = mysqli_real_escape_string($db, $_GET['category']);
	  	$scategory = mysqli_real_escape_string($db, $_GET['scategory']);
			$sql = "SELECT register.speak, register.username, register.profile as userprofile, register.description as userDescription, user_services.id, user_services.userid, city.name as cityName, user_services.category, user_services.scategory, user_services.image, user_services.description, user_services.title,user_services.price, categories.name as category, subcategories.name as scategory FROM user_services, categories, subcategories, city,register  WHERE user_services.city = city.id and categories.id = user_services.category and subcategories.id = user_services.scategory and user_services.category = '$category' and user_services.scategory = '$scategory' and user_services.city = '$cid' and user_services.userid = register.id and user_services.userid<>'$userid' GROUP BY id";
	  }

	  if(strlen($_GET['search']) > 1){
	  	$search = mysqli_real_escape_string($db, $_GET['search']);
	  	$sql = "SELECT register.speak, register.username, register.profile as userprofile, register.description as userDescription, user_services.id, user_services.userid, city.name as cityName, user_services.category, user_services.scategory, user_services.image, user_services.description, user_services.title,user_services.price, categories.name as category, subcategories.name as scategory FROM user_services, categories, subcategories, city,register WHERE user_services.city = city.id and categories.id = user_services.category and subcategories.id = user_services.scategory and user_services.title LIKE '$search%' and user_services.city = '$cid' and user_services.userid = register.id and user_services.userid<>'$userid' GROUP BY id";
	  }
  }

  $result = mysqli_query($db, $sql);
  if (!$result) {
    printf("Error: %s\n", mysqli_error($db));
    exit();
	}
	$data = mysqli_fetch_all($result, MYSQLI_ASSOC);
	foreach ($data as $key => $value) {
		
		$serviceid = mysqli_real_escape_string($db, $value['id']);
		$userid = mysqli_real_escape_string($db, $_GET['userid']);
		$sql = "SELECT * FROM favorites WHERE userid='$userid' and serviceid='$serviceid'";
		$result = mysqli_query($db, $sql);
		$favdata = mysqli_fetch_all($result, MYSQLI_ASSOC);
		$data[$key]['favorite'] = count($favdata) ? 'Y' : 'N';
		$data[$key]['image'] = URL.'/images/services/'.$value['image'];
		$data[$key]['userprofile'] = URL.'/images/upload/'.$value['userprofile'];
		$serviceUserid = mysqli_real_escape_string($db, $value['userid']);
		$sql = "SELECT count(*) as total, sum(rate) as totalRate FROM service_review WHERE userid='$serviceUserid' and serviceid='$serviceid'";
		$result = mysqli_query($db, $sql);
		$rate = mysqli_fetch_all($result, MYSQLI_ASSOC);
		if((int)$rate[0]['total']){
			$data[$key]['rating'] = number_format((float)$rate[0]['totalRate']/(int)$rate[0]['total'], 2, '.', '');
		}else{
			$data[$key]['rating'] = 0;
		}
		$data[$key]['response_time'] = '1 Hours';
	}

	echo json_encode(array('error' => 'N', 'data' => $data), true);
}
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
	$tab_recommands = mysqli_fetch_all($result, MYSQLI_ASSOC);

	for($i=0; $i<count($data['recommands']); $i++){
		$data['recommands'][$i]['tab'] = array();
		for($j=0; $j<count($tab_recommands); $j++){
			if($tab_recommands[$j]['category'] == $data['recommands'][$i]['id']){
				array_push($data['recommands'][$i]['tab'], $tab_recommands[$j]);
			}
		}		
	}

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

		  if($_POST["email"] == ''){
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

  	if(isset($_GET['sid'])){
  		$sid = mysqli_real_escape_string($db, $_GET['sid']);
  		$sql = "SELECT id FROM user_services WHERE id = '$sid'";	
  	}else{
  		if($_POST['category'] == ''){
		  	echo json_encode(array('error' => 'Y', 'msg' => 'category not found on requested data'), true);
		  	return true;
		  }
		  if($_POST['scategory'] == ''){
		  	echo json_encode(array('error' => 'Y', 'msg' => 'scategory not found on requested data'), true);
		  	return true;
		  }
			$sql = "SELECT id FROM user_services WHERE email = '$email' and title = '$title' and city = '$city'";
  	}

		$result = mysqli_query($db, $sql);
		$row = mysqli_fetch_array($result,MYSQLI_ASSOC);

		$count = mysqli_num_rows($result);
		if($count && isset($_GET['sid'])){

		$price = mysqli_real_escape_string($db, $_POST['price']);
	    $description = mysqli_real_escape_string($db, $_POST['description']);
	    $time = mysqli_real_escape_string($db, $_POST['time']);
	    $type = mysqli_real_escape_string($db, $_POST['type']);

		if (isset($_FILES["file"]) && $_FILES["file"]["type"] != '' && isset($_FILES["file"]["type"])){
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

								
						    $fileName = mysqli_real_escape_string($db, $fileName);

						    // $sql = "UPDATE user_services SET (title, email, description, category, scategory, city, image, price) VALUES ('$title','$email','$description','$category','$scategory','$city', '$fileName', '$price')";
						    $sql = "UPDATE user_services SET title='$title', email='$email', description='$description', city='$city', image='$fileName', price='$price', `time`='$time', type='$type' WHERE id='$sid'";

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
			}else{
				$sql = "UPDATE user_services SET title='$title', description='$description', city='$city', price='$price', `time`='$time', type='$type' WHERE id='$sid'";
			}

			mysqli_query($db, $sql);

     	if(mysqli_affected_rows($db)) {
     		echo json_encode(array('error' => 'N', 'msg' => 'Service Updated Successfully'), true);
     		return true;
      }else{
        echo json_encode(array('error' => 'Y', 'msg' => 'Service Failed'), true);
        return true;
      }

		}else if($count && !isset($_GET['sid'])){
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

								// $price = mysqli_real_escape_string($db, $_POST['price']);
						  //   $category = mysqli_real_escape_string($db, $_POST['category']);
						  //   $scategory = mysqli_real_escape_string($db, $_POST['scategory']);
						  //   $description = mysqli_real_escape_string($db, $_POST['description']);
						  //   $fileName = mysqli_real_escape_string($db, $fileName);
						  //   $time = mysqli_real_escape_string($db, $_POST['time']);
						  //   $type = mysqli_real_escape_string($db, $_POST['type']);

						     $sql = "SELECT id FROM register where email='$email'";
							$result = mysqli_query($db, $sql);
							$registerData = mysqli_fetch_array($result, MYSQLI_ASSOC);

							$userid = mysqli_real_escape_string($db, $registerData['id']);

						    $sql = "INSERT INTO user_services (title, email, userid, description, category, scategory, city, image, price, `time`, type) VALUES ('".$_POST['title']."','".$_POST['email']."', '".$_POST['userid']."', '".$_POST['description']."','".$_POST['category']."','".$_POST['scategory']."','".$_POST['city']."', '".$fileName."', '".$_POST['price']."', '".$_POST['time']."', '".$_POST['type']."')";
					     	mysqli_query($db, $sql);

					     	if(mysqli_affected_rows($db)) {
					     		if(isset($_POST['suggest']) && (string)$_POST['suggest'] != '' && (int)$_POST['category'] == 8 && (int)$_POST['scategory'] == 52){
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

