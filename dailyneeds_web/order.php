<?php
	include("v1/config.php");
	date_default_timezone_set('Pacific/Auckland');

	if(!isset($_SESSION)) 
	{ 
	    session_start(); 
	} 
	if(isset($_SESSION['id'])){
		$sign = 1;
	}else{
		$sign = 0;
	}

	if(isset($_GET['cc'])){
		$orderid = mysqli_real_escape_string($db, base64_decode($_GET['cc']));
		$sql = "SELECT offerid,serviceid,`date`,status FROM orders WHERE orders.id='$orderid'";
		$result = mysqli_query($db, $sql);
		$order = mysqli_fetch_array($result,MYSQLI_ASSOC);
		
		$date = $order['date'];
		$serviceid = $order['serviceid'];
		$status = $order['status'];

		if($order['offerid']){

			$sql = "SELECT orders.id,orders.status,orders.offerid,orders.date,orders.buyerid,sendoffer.budget,sendoffer.type as timeType,sendoffer.time,sendoffer.comments as description,categories.name as category,subcategories.name as scategory,register.id as userid, register.username,city.name as userCity,register.profile, user_services.image as serviceImage,user_services.title,user_services.id as serviceId FROM orders,sendoffer,user_services,categories,subcategories,register,city WHERE orders.id='$orderid' and user_services.id=sendoffer.serviceid and user_services.category=categories.id and user_services.scategory=subcategories.id and register.id=sendoffer.userid and sendoffer.id=orders.offerid and city.id=register.city";

			$result = mysqli_query($db, $sql);
			$order = mysqli_fetch_array($result,MYSQLI_ASSOC);

			$userid = mysqli_real_escape_string($db, $order['userid']);
			$serviceId = mysqli_real_escape_string($db, $order['serviceId']);
			$serviceid = $order['serviceId'];

			$userid = mysqli_real_escape_string($db, $order['userid']);
			$buyerid = mysqli_real_escape_string($db, $order['buyerid']);
			$myid = ($buyerid == $_SESSION['id']) ? 'me' : '';
			$myProfile = ($buyerid == $_SESSION['id']) ? $_SESSION['profile'] : $order['profile'];
			$orderid = mysqli_real_escape_string($db, $order['id']);

			$sql = "SELECT order_messages.senderid,order_messages.status,order_messages.receiverid,order_messages.message,register.profile FROM order_messages,register WHERE orderid='$orderid' and register.id=order_messages.senderid ORDER BY  `order_messages`.`date` ASC ";
			$result = mysqli_query($db, $sql);
			$chat = mysqli_fetch_all($result,MYSQLI_ASSOC);

			
		}else{
			$serviceid = mysqli_real_escape_string($db, $order['serviceid']);

			$sql = "SELECT orders.id,orders.status,orders.serviceid,orders.date,orders.buyerid,user_services.price as budget,user_services.id as serviceId,user_services.title,user_services.time,user_services.type as timeType, register.id as userid, register.username,city.name as userCity,register.profile, user_services.image as serviceImage,categories.name as category,subcategories.name as scategory,user_services.description FROM orders,user_services,register,categories,subcategories,city WHERE orders.id='$orderid' and user_services.id='$serviceid' and register.id=user_services.userid and user_services.category=categories.id and user_services.scategory=subcategories.id and city.id=register.city";

			$result = mysqli_query($db, $sql);
			$order = mysqli_fetch_array($result,MYSQLI_ASSOC);
			$order['date'] = $date;
			
			$serviceId = mysqli_real_escape_string($db, $order['serviceId']);

			$userid = mysqli_real_escape_string($db, $order['userid']);
			$buyerid = mysqli_real_escape_string($db, $order['buyerid']);
			$myid = ($buyerid == $_SESSION['id']) ? 'me' : '';
			
			$orderid = mysqli_real_escape_string($db, $order['id']);

			$sql = "SELECT order_messages.senderid,order_messages.status,order_messages.receiverid,order_messages.message,register.profile FROM order_messages,register WHERE orderid='$orderid' and register.id=order_messages.senderid ORDER BY  `order_messages`.`date` ASC ";
			$result = mysqli_query($db, $sql);
			$chat = mysqli_fetch_all($result,MYSQLI_ASSOC);

			$sql = "SELECT status FROM order_messages WHERE senderid='$buyerid' and orderid='$orderid' and status='cancel' limit 1";
			$result = mysqli_query($db, $sql);
			$orderMesage = mysqli_fetch_array($result,MYSQLI_ASSOC);
		}

		$sql = "SELECT register.username,register.profile FROM orders,register WHERE orders.id='$orderid' and register.id=orders.buyerid";
		$result = mysqli_query($db, $sql);
		$posterData = mysqli_fetch_array($result,MYSQLI_ASSOC);	

		$myProfile = $order['profile'];

		$sql = "SELECT count(*) as totalCount from service_review WHERE userid='$userid' and orderid='$orderid'";
		$result = mysqli_query($db, $sql);
		$buyerReviewCount = mysqli_fetch_array($result,MYSQLI_ASSOC)['totalCount'];

		$sql = "SELECT count(*) as totalCount from service_review WHERE userid='$buyerid' and orderid='$orderid'";
		$result = mysqli_query($db, $sql);
		$sellerReviewCount = mysqli_fetch_array($result,MYSQLI_ASSOC)['totalCount'];

		$disable = ($order['status'] == 'pending') ? 'disableClick' : '';
		
		$currentDate = strtotime(date("Y-m-d H:i:s"));
		if($order['timeType'] == 'h'){
			$type = ' hours';
		}else if($order['timeType'] == 'd'){
			$type = ' days';
		}else if($order['timeType'] == 'm'){
			$type = ' months';
		}
		
		$DeliveryTime = $order['time'].$type;

		$orderTime = '+'.$order['time'].$type;
		$orderedDate = date("F j, Y H:i:s", strtotime($orderTime, strtotime(date($order['date']))));
		$orderDate = strtotime($orderedDate);

		$sql = "SELECT count(*) as total, sum(rate) as totalRate FROM service_review WHERE serviceid='$serviceid'";
		$result = mysqli_query($db, $sql);
		$rate = mysqli_fetch_all($result, MYSQLI_ASSOC);
		if((int)$rate[0]['total']){
			$rate = (float)$rate[0]['totalRate']/(int)$rate[0]['total'];
		}else{
			$rate = 0;
		}

	}else{
		header('Location: '.SITE_URL);
	}

	
?>
<!doctype html>
<html lang="en">
<head>

<!-- Basic Page Needs
================================================== -->
<title>DailyNeeds | Order</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

<!-- CSS
================================================== -->
<link rel="stylesheet" href="css/style.css?v=2">
<link rel="stylesheet" href="css/colors/blue.css?v=2">
<style type="text/css">
	.simplebar-scrollbar{
  display: none !important;
 }
 .dashboard-content-container{
  height: 100% !important;
    width: 100% !important;
    overflow: hidden !important;
 }
	div.tabs-header .active{
		background-color: #888 !important;
	}
	div.tabs-header li{
		padding: 0px 20px!important
	}
	.font-weight, #responsive li a{
		font-size: 18px !important;
    	font-weight: 600 !important;
    	padding: 15px 40px !important;
	}
	#responsive .current{
		color: #fff !important;
	}
	#logo{
		border-right: none !important;
	}
	#responsive li a:hover{
		color: #fff !important;
	}
	.disableClick{
	    pointer-events: none;
	    opacity: 0.5 !important;
	}
</style>
</head>
<body>

<!-- Wrapper -->
<div id="wrapper">

<?php include("views/header.php");?>
<?php include("views/session.php");?>

<div class="clearfix"></div>
<!-- Header Container / End -->
<!-- Titlebar
================================================== -->
<div class="single-page-header" data-background-image="images/single-job.jpg">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="single-page-header-inner">
					<div class="left-side">
						<div class="header-image"><a href="javascript:;"><img src="images/services/<?php echo $order['serviceImage'];?>" alt=""></a></div>
						<div class="header-details">
							<h3><?php echo $order['title']?></h3>
							<h4><?php echo $order['category'].' - '.$order['scategory'];?></h4>
							<h5>About the Employer</h5>
							<ul>
								<li><a href="javascript:;"><i class="icon-material-outline-business"></i> <?php echo $order['username'];?></a></li>
								<li><div class="star-rating" data-rating="<?php echo round($rate, 1);?>"></div></li>
								
							</ul>
						</div>
					</div>
					<div class="right-side" id="orderexpire" style="display: none;">
						<div class="salary-box">
							<div class="salary-type">TIME</div>
							<center><div class="salary-amount">LATE</div></center>
						</div>
					</div>
					<?php if(!in_array($order['status'], array('accept', 'o_cancel_acept', 'o_delivery_complete_accept'))){?>
						<div class="right-side" id="orderTiming">
							<!-- <p id="demo"></p> -->
							<div class="salary-box">
									<div class="salary-type">Days</div>
									<div class="salary-amount"><center id="days">--</center></div>
								</div>
								<div class="salary-box">
									<div class="salary-type">Hours</div>
									<div class="salary-amount"><center id="hours">--</center></div>
								</div>
								<div class="salary-box">
									<div class="salary-type">Minutes</div>
									<div class="salary-amount"><center id="minutes">--</center></div>
								</div>
								<div class="salary-box">
									<div class="salary-type">Seconds</div>
									<div class="salary-amount"><center id="seconds">--</center></div>
								</div>
						</div>
				<?php }?>
				</div>
			</div>
		</div>
	</div>
</div>


<!-- Page Content
================================================== -->
<div class="container">
	<div class="row">
		
		<!-- Content -->
		<div class="col-xl-8 col-lg-8 content-right-offset">

			<div class="single-page-section">
				<h3 class="margin-bottom-25">Job Description</h3>
				<p><?php echo $order['description'];?></p>
			</div>

			<div class="single-page-section">
				<h3>RECENT CONVERSATION</h3>
				<p>View your recent inbox conversation with <?php echo $order['username'];?></p>

				<div class="col-xl-12 dashboard-content-container" data-simplebar style="margin-bottom: 50px;">

					<div class="dashboard-content-inner" style="background-color: rgb(255, 255, 255);min-height: 450px;padding: 0px !important;">

						<div class="messages-container margin-top-0" style="border: 2px solid #eee;box-shadow: 0 0px 10px #E0E0E7;">

							<div class="messages-container-inner">

								<!-- Messages -->
								<!-- Messages / End -->

								<!-- Message Content -->
								<div class="message-content" style="height: 700px;">

									<div class="messages-headline">
										<h4><?php echo $order['username'];?></h4>
									</div>
									
									<!-- Message Content Inner -->
									<div class="message-content-inner">
											
											
									</div>
									<!-- Message Content Inner / End -->
									
									<!-- Reply Area -->
									<?php if(!in_array($order['status'], array('accept', 'o_cancel_acept', 'o_delivery_complete_accept'))){?>
										<form class="order-form-message">
										<div class="message-reply">
											<input type="text" name="senderid" value="<?php echo $_SESSION['id']?>" hidden>
											<input type="text" name="receiverid" value="<?php echo ($myid == 'me') ? $order['userid'] : $order['buyerid'];?>" hidden>
											<textarea cols="1" rows="1" id="msg" name="message" placeholder="Your Message" data-autoresize></textarea>
											<input class="button ripple-effect" type="submit" value="Send" name="Send">
										</div></form>
									<?php }?>

								</div>
								<!-- Message Content -->
								<br/><br/>
							</div>
					</div>
			<!-- Messages Container / End -->

					</div>
				</div>


			</div>
		</div>

		<!-- Sidebar -->
		<div class="col-xl-4 col-lg-4">
			<div class="sidebar-container">
				<?php if(!in_array($order['status'], array('accept', 'o_cancel_accept', 'o_delivery_complete_accept'))){?>
						<?php if($order['buyerid'] != $_SESSION['id']){ ?>
							<a href="<?php echo ($sign == 0) ? '#sign-in-dialog' : '#small-dialog-2';?>" onclick="confirmation('<?php echo $order['id'];?>', '<?php echo $order['buyerid']?>', '<?php echo $order['userid']?>','o_delivery_complete')" class="order-messages-deliver-btn apply-now-button popup-with-zoom-anim" style="display: <?php echo (!in_array($order['status'], array('o_cancel_accept', 'o_delivery_complete', 'o_delivery_complete_accept', 'o_cancel'))) ? 'block' : 'none';?>;margin-bottom: 10px;">Deliver Order<i class="icon-material-outline-layers"></i></a>	

							<a href="<?php echo ($sign == 0) ? '#sign-in-dialog' : '#small-dialog-2';?>" onclick="confirmation('<?php echo $order['id'];?>', '<?php echo $order['buyerid']?>', '<?php echo $order['userid']?>','o_seller_cancel')" class="order-messages-cancel-seller-btn apply-now-button popup-with-zoom-anim" style="background-color: #4a4a4a; display: <?php echo (!in_array($order['status'], array('accept', 'o_cancel_accept', 'o_delivery_complete_accept', 'o_cancel'))) ? 'block' : 'none';?>;margin-bottom: 10px;">Cancel Order<i class="icon-feather-x"></i></a>
						<?php }else{?>

						<a href="<?php echo ($sign == 0) ? '#sign-in-dialog' : '#small-dialog-2';?>" onclick="confirmation('<?php echo $order['id'];?>', '<?php echo $order['buyerid']?>', '<?php echo $order['userid']?>','o_delivery_complete_accept')" class="order-messages-accept-order-btn apply-now-button popup-with-zoom-anim" style="background-color: green; display: <?php echo (in_array($order['status'], array('o_delivery_complete'))) ? 'block' : 'none';?>;margin-bottom: 10px;">Accept Order Delivery<i class="icon-material-outline-check"></i></a>	
							
							<a href="<?php echo ($sign == 0) ? '#sign-in-dialog' : '#small-dialog-2';?>" onclick="confirmation('<?php echo $order['id'];?>', '<?php echo $order['buyerid']?>', '<?php echo $order['userid']?>','o_delivery_complete_decline')" class="order-messages-decline-order-btn apply-now-button popup-with-zoom-anim" style="background-color: #4a4a4a; display: <?php echo (in_array($order['status'], array('o_delivery_complete'))) ? 'block' : 'none';?>;margin-bottom: 10px;">Decline Order Delivery<i class="icon-feather-x"></i></a>

						<a href="<?php echo ($sign == 0) ? '#sign-in-dialog' : '#small-dialog-2';?>" onclick="confirmation('<?php echo $order['id'];?>', '<?php echo $order['buyerid']?>', '<?php echo $order['userid']?>','o_buyer_cancel')" class="order-messages-cancel-buyer-btn apply-now-button popup-with-zoom-anim" style="background-color: #4a4a4a; display: <?php echo (!in_array($order['status'], array('accept', 'o_cancel_accept', 'o_delivery_complete_accept', 'o_cancel'))) ? 'block' : 'none';?>;margin-bottom: 10px;">Cancel Order<i class="icon-feather-x"></i></a>

						<?php }?>
							
						<a href="<?php echo ($sign == 0) ? '#sign-in-dialog' : '#small-dialog-2';?>" onclick="confirmation('<?php echo $order['id'];?>', '<?php echo $order['buyerid']?>', '<?php echo $order['userid']?>','o_cancel_accept')" class="order-messages-accept-cancel-btn apply-now-button popup-with-zoom-anim" style="background-color: green; display: <?php echo (!in_array($order['status'], array('o_cancel_accept', 'pending', 'o_delivery_complete_decline'))) ? 'block' : 'none';?>;margin-bottom: 10px;">Accept Cancel Order<i class="icon-material-outline-check"></i></a>	
							
							<a href="<?php echo ($sign == 0) ? '#sign-in-dialog' : '#small-dialog-2';?>" onclick="confirmation('<?php echo $order['id'];?>', '<?php echo $order['buyerid']?>', '<?php echo $order['userid']?>','o_cancel_decline')" class="order-messages-decline-cancel-btn apply-now-button popup-with-zoom-anim" style="background-color: #4a4a4a; display: <?php echo (!in_array($order['status'], array('o_cancel_accept', 'pending', 'o_delivery_complete_decline'))) ? 'block' : 'none';?>;margin-bottom: 10px;">Decline Cancel Order<i class="icon-feather-x"></i></a>

				<?php }?>
				<?php if($order['buyerid'] == $_SESSION['id']){ ?>
					<?php if($order['status'] == 'o_delivery_complete_accept' && !$buyerReviewCount){?>
						<a href="<?php echo ($sign == 0) ? '#sign-in-dialog' : '#small-dialog-1';?>" onclick="make_review('<?php echo $order['id'];?>', '<?php echo $order['buyerid']?>', '<?php echo $order['userid']?>')" class=" apply-now-button popup-with-zoom-anim reviewmake">Make Review<i class="icon-material-outline-arrow-right-alt"></i></a>
					<?php }?>
				<?php }?>

				<?php if($order['buyerid'] != $_SESSION['id']){ ?>
						<a href="<?php echo ($sign == 0) ? '#sign-in-dialog' : '#small-dialog-1';?>" onclick="make_review('<?php echo $order['id'];?>', '<?php echo $order['buyerid']?>', '<?php echo $order['userid']?>')" class="sellerReviewBtn apply-now-button popup-with-zoom-anim reviewmake"
							style="display: <?php echo ($order['status'] == 'o_delivery_complete_accept' && !$sellerReviewCount) ? 'block' : 'none';?>"
							>Make Review<i class="icon-material-outline-arrow-right-alt"></i></a>
				<?php }?>
				
				<!-- Sidebar Widget -->
				<div class="sidebar-widget">
					<div class="job-overview">
						<div class="job-overview-headline">Order Summary</div>
						<div class="job-overview-inner">
							<ul>
								<li>
									<i class="icon-material-outline-location-on"></i>
									<span>Location</span>
									<h5><?php echo $order['userCity'];?></h5>
								</li>
								<li>
									<i class="icon-material-outline-local-atm"></i>
									<span>Budget</span>
									<h5>$<?php echo $order['budget'];?></h5>
								</li>
								<li>
									<i class="icon-material-outline-access-time"></i>
									<span>Delivery Time</span>
									<h5><?php echo $DeliveryTime;?></h5>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>



<?php include("views/footer.php");?>

</div>
<!-- Wrapper / End -->
<?php include("views/model.php");?>

<!-- Leave a Review for Freelancer Popup
================================================== -->
<div id="small-dialog-2" class="zoom-anim-dialog mfp-hide dialog-with-tabs">

	<!--Tabs -->
	<div class="sign-in-form">

		<ul class="popup-tabs-nav">
		</ul>

		<div class="popup-tabs-container">

			<!-- Tab -->
			<div class="popup-tab-content" id="tab2">
				
				<!-- Welcome Text -->
				<div class="welcome-text">
					<h3 id="titlefordelivery">Deliver Order To <?php echo $posterData['username'];?></h3>
					<span>Please provide a description or any instructions for your project</span>
				</div>
					
				<!-- Form -->
				<form method="post" id="leave-message-form" class="">
					<input type="text" value="<?php echo $order['id'];?>" name="orderid" id="orderid" hidden>
					<input type="text" value="" name="status" id="status" hidden>
					<input type="text" value="" name="isSeller" id="isSeller" hidden>
					<input type="text" value="" name="senderid" id="senderid" hidden>
					<input type="text" value="" name="receiverid" id="receiverid" hidden>
					<textarea class="with-border" placeholder="Leave your Message here" name="message" id="message2" cols="7" required></textarea>
					<div class="notification closeable" style="display: none;">
						<p id="successmsg"></p>
						<a class="close" href="#"></a>
					</div>
				
				<!-- Button -->
				<button class="button full-width button-sliding-icon ripple-effect" type="submit" form="leave-message-form">Send<i class="icon-material-outline-arrow-right-alt"></i></button>
				</form>

			</div>

		</div>
	</div>
</div>
<!-- Leave a Review Popup / End -->

<!-- Leave a Review for Freelancer Popup
================================================== -->
<div id="small-dialog-1" class="zoom-anim-dialog mfp-hide dialog-with-tabs">

	<!--Tabs -->
	<div class="sign-in-form">

		<ul class="popup-tabs-nav">
		</ul>

		<div class="popup-tabs-container">

			<!-- Tab -->
			<div class="popup-tab-content" id="tab2">
				
				<!-- Welcome Text -->
				<div class="welcome-text">
					<?php if($order['buyerid'] == $_SESSION['id']){?>
						<h3 id="titlefordelivery1">Review/Feedback Order To <?php echo $order['username'];?></h3>
					<?php }else{?>
						<h3 id="titlefordelivery1">Review/Feedback Order To <?php echo $posterData['username'];?></h3>
					<?php }?>	
					<span>Please make review or any feeback of your project</span>
				</div>
					
				<!-- Form -->
				<form method="post" id="feeback-message-form" class="">
					<?php if($order['buyerid'] == $_SESSION['id']){?>
						<input type="text" value="<?php echo $order['id'];?>" name="orderid" id="orderid" hidden>
						<input type="text" value="<?php echo $order['userid'];?>" name="userid" id="userid" hidden>
						<input type="text" value="0" name="isSeller" id="isSeller" hidden>
					<?php }else{?>
						<input type="text" value="<?php echo $order['id'];?>" name="orderid" id="orderid" hidden>
						<input type="text" value="<?php echo $order['buyerid'];?>" name="userid" id="userid" hidden>
						<input type="text" value="1" name="isSeller" id="isSeller" hidden>
					<?php }?>	
					<div class="feedback-yes-no">
						<strong>Your Rating</strong>
						<div class="leave-rating">
							<input type="radio" name="rating" id="rating-1" value="1"/>
							<label for="rating-1" class="icon-material-outline-star"></label>
							<input type="radio" name="rating" id="rating-2" value="2"/>
							<label for="rating-2" class="icon-material-outline-star"></label>
							<input type="radio" name="rating" id="rating-3" value="3"/>
							<label for="rating-3" class="icon-material-outline-star"></label>
							<input type="radio" name="rating" id="rating-4" value="4"/>
							<label for="rating-4" class="icon-material-outline-star"></label>
							<input type="radio" name="rating" id="rating-5" value="5"/>
							<label for="rating-5" class="icon-material-outline-star"></label>
						</div><div class="clearfix"></div>
					</div>
					<textarea class="with-border" placeholder="Leave your Review here" name="message" id="message2" cols="7" required></textarea>
					<div class="notification closeable" style="display: none;">
						<p id="successmsg"></p>
						<a class="close" href="#"></a>
					</div>
				
				<!-- Button -->
				<button class="button full-width button-sliding-icon ripple-effect review-button" type="submit" form="feeback-message-form">Send<i class="icon-material-outline-arrow-right-alt"></i></button>
				</form>

			</div>

		</div>
	</div>
</div>
<!-- Leave a Review Popup / End -->



<!-- Scripts
================================================== -->
<script src="js/jquery-3.3.1.min.js"></script>
<script src="js/jquery-migrate-3.0.0.min.js"></script>
<script src="js/mmenu.min.js"></script>
<script src="js/tippy.all.min.js"></script>
<script src="js/simplebar.min.js"></script>
<script src="js/bootstrap-slider.min.js"></script>
<script src="js/bootstrap-select.min.js"></script>
<script src="js/snackbar.js"></script>
<script src="js/clipboard.min.js"></script>
<script src="js/counterup.min.js"></script>
<script src="js/magnific-popup.min.js"></script>
<script src="js/slick.min.js"></script>
<script src="js/custom.js"></script>
<script src="js/jquery.countdownTimer.js"></script>
<script src="js/jquery.countdownTimer.min.js"></script>
<!-- Snackbar // documentation: https://www.polonel.com/snackbar/ -->
<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/socket.io/2.1.1/socket.io.js"></script>
<script src="js/chatscript.js?v=32"></script>

<script>
socket.on( 'disconnect', function () {
    location.reload();
});
var newDate = '<?php echo $currentDate;?>';
var orderDate = '<?php echo $orderedDate;?>';
console.log("newDate :::::::::::::: ", newDate);
console.log("orderDate :::::::::::::: ", orderDate);

var orderTime = '<?php echo $orderTime;?>';
console.log("orderTime :::::::::::::: ", orderTime);
// Set the date we're counting down to
var countDownDate = new Date(orderDate).getTime();

// Update the count down every 1 second
var x = setInterval(function() {

  // Get todays date and time
  var now = new Date().getTime();

  // Find the distance between now and the count down date
  var distance = countDownDate - now;

  // Time calculations for days, hours, minutes and seconds
  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);

  // Display the result in the element with id="demo"
  /*document.getElementById("demo").innerHTML = days + "d " + hours + "h "
  + minutes + "m " + seconds + "s ";*/
  $('#days').html((days).toLocaleString('en-US', {minimumIntegerDigits: 2, useGrouping:false}));
  $('#hours').html((hours).toLocaleString('en-US', {minimumIntegerDigits: 2, useGrouping:false}));
  $('#minutes').html((minutes).toLocaleString('en-US', {minimumIntegerDigits: 2, useGrouping:false}));
  $('#seconds').html((seconds).toLocaleString('en-US', {minimumIntegerDigits: 2, useGrouping:false}));

  $('#orderexpire').css('display', 'none');
  // If the count down is finished, write some text 
  if (distance < 0) {
    clearInterval(x);
    // document.getElementById("demo").innerHTML = "EXPIRED";
    $('#orderexpire').css('display', 'block');
    $('#orderTiming').css('display', 'none');
  }
}, 1000);

$('#msg').keypress(function(e) {
    if (e.keyCode == 13 && e.shiftKey)
    {	

    }else if(e.keyCode == 13){
    	var msg = $("#msg").val().replace(/\n/g, "");
    	if (msg != "")
	    {
        $('.order-form-message').submit();
    		$('#msg').val('');
	    }
	    return false;
    	

    }
});

joinConnection('<?php echo $_SESSION['id'];?>', '<?php echo base64_decode($_GET['cc']);?>');

function joinConnection(myid, orderid){
	var data = {myid: myid, orderid: orderid};
	console.log("data ::::::: ", data);
	socket.emit("joinConnectionOnOrder", data);
}

/*socket.on('sendOrderMessages', (data)=>{
	var data = data.data;
	var id = '<?php echo $_SESSION['id']?>';
	var buyerid = '<?php echo $order['buyerid']?>';
	console.log("data: ::::::::: ", data, id);
	// location.reload();
})*/


var orderid = '<?php echo base64_decode($_GET['cc']);?>';
console.log("orderid ::::::::::::::::::::::::::::: ", orderid);
socket.emit('sendOrderMessagesList', {'orderid': orderid});

socket.on('reloadPage', (data)=>{
	location.reload();
})

socket.on('sendOrderMessagesList', (data)=>{
	console.log("data ::::::: ", data);
	
	if(data.orderStatus == 'o_cancel_accept'){
		$('.order-form-message').css('display', 'none');
		$('#orderTiming').css('display', 'none');
	}

	var id = '<?php echo $_SESSION['id']?>';
	var buyerid = '<?php echo $order['buyerid']?>';
	var userid = '<?php echo $order['userid']?>';
	var orderStatus = data.orderStatus;
	
	var orderHint = '';
	if(orderStatus == 'o_buyer_cancel' || orderStatus == 'o_seller_cancel'){
		orderHint = '<h6><em>Order Cancelled!</em></h6>';
	}else if(orderStatus == 'o_cancel_accept'){
		orderHint = '<h6><em>Order Cancel Accepted!</em></h6>';
	}else if(orderStatus == 'o_cancel_decline'){
		orderHint = '<h6><em>Order Cancel Declined!</em></h6>';
	}else if(orderStatus == 'o_delivery_complete_decline'){
		orderHint = '<h6><em>Order Delivery Complete Declined!</em></h6>';
	}else if(orderStatus == 'o_delivery_complete_accept'){
		orderHint = '<h6><em>Order Delivery Complete Accepted!</em></h6>';
	}else if(orderStatus == 'o_delivery_complete'){
		orderHint = '<h6><em>Order Delivered!</em></h6>';
	}

	if(buyerid == id){
		console.log("buyerid :::::::: orderStatus ::::::::::: ", orderStatus);
		if(orderStatus == 'o_delivery_complete'){
			$('.order-messages-cancel-buyer-btn').css('display', 'none');
			$('.order-messages-accept-cancel-btn').css('display', 'none');
			$('.order-messages-decline-cancel-btn').css('display', 'none');

			$('.order-messages-accept-order-btn').css('display', 'block');
			$('.order-messages-decline-order-btn').css('display', 'block');

		}else if(orderStatus == 'o_seller_cancel'){
			$('.order-messages-cancel-buyer-btn').css('display', 'none');
			$('.order-messages-accept-order-btn').css('display', 'none');
			$('.order-messages-decline-order-btn').css('display', 'none');

			$('.order-messages-accept-cancel-btn').css('display', 'block');
			$('.order-messages-decline-cancel-btn').css('display', 'block');
		
		}else if(orderStatus == 'o_buyer_cancel'){
			$('.order-messages-cancel-buyer-btn').css('display', 'none');
			$('.order-messages-accept-order-btn').css('display', 'none');
			$('.order-messages-decline-order-btn').css('display', 'none');

			$('.order-messages-accept-cancel-btn').css('display', 'none');
			$('.order-messages-decline-cancel-btn').css('display', 'none');
		
		}else if(orderStatus == 'o_cancel_decline'){
			$('.order-messages-cancel-buyer-btn').css('display', 'block');
			$('.order-messages-accept-order-btn').css('display', 'none');
			$('.order-messages-decline-order-btn').css('display', 'none');

			$('.order-messages-accept-cancel-btn').css('display', 'none');
			$('.order-messages-decline-cancel-btn').css('display', 'none');
		
		}else if(orderStatus == 'o_cancel_accept'){
			$('.order-messages-cancel-buyer-btn').css('display', 'none');
			$('.order-messages-accept-order-btn').css('display', 'none');
			$('.order-messages-decline-order-btn').css('display', 'none');

			$('.order-messages-accept-cancel-btn').css('display', 'none');
			$('.order-messages-decline-cancel-btn').css('display', 'none');

			$('.order-form-message').css('display', 'none');
			$('#orderTiming').css('display', 'none');
		
		}else{
			console.log("else part ")
			$('.order-messages-cancel-buyer-btn').css('display', 'block');

			$('.order-messages-accept-order-btn').css('display', 'none');
			$('.order-messages-decline-order-btn').css('display', 'none');
			$('.order-messages-accept-cancel-btn').css('display', 'none');
			$('.order-messages-decline-cancel-btn').css('display', 'none');
		}
	}else{
		if(orderStatus == 'o_delivery_complete'){
			$('.order-messages-cancel-seller-btn').css('display', 'none');
			$('.order-messages-deliver-btn').css('display', 'none');

			$('.order-messages-accept-cancel-btn').css('display', 'none');
			$('.order-messages-decline-cancel-btn').css('display', 'none');

		}else if(orderStatus == 'o_buyer_cancel'){
			$('.order-messages-cancel-seller-btn').css('display', 'none');
			$('.order-messages-deliver-btn').css('display', 'none');

			$('.order-messages-accept-cancel-btn').css('display', 'block');
			$('.order-messages-decline-cancel-btn').css('display', 'block');
		
		}else if(orderStatus == 'o_seller_cancel'){
			$('.order-messages-cancel-seller-btn').css('display', 'none');
			$('.order-messages-deliver-btn').css('display', 'none');

			$('.order-messages-accept-cancel-btn').css('display', 'none');
			$('.order-messages-decline-cancel-btn').css('display', 'none');
		
		}else if(orderStatus == 'o_delivery_complete_accept'){
			$('.order-messages-cancel-seller-btn').css('display', 'none');
			$('.order-messages-deliver-btn').css('display', 'none');

			$('.order-messages-accept-cancel-btn').css('display', 'none');
			$('.order-messages-decline-cancel-btn').css('display', 'none');	

			$('.order-form-message').css('display', 'none');
			$('#orderTiming').css('display', 'none');
		
		}else if(orderStatus == 'o_delivery_complete_decline'){
			$('.order-messages-cancel-seller-btn').css('display', 'block');
			$('.order-messages-deliver-btn').css('display', 'block');

			$('.order-messages-accept-cancel-btn').css('display', 'none');
			$('.order-messages-decline-cancel-btn').css('display', 'none');	
	
		}else if(orderStatus == 'o_cancel_accept'){

			$('.order-messages-cancel-seller-btn').css('display', 'none');
			$('.order-messages-deliver-btn').css('display', 'none');

			$('.order-messages-accept-cancel-btn').css('display', 'none');
			$('.order-messages-decline-cancel-btn').css('display', 'none');

			$('.order-form-message').css('display', 'none');
			$('#orderTiming').css('display', 'none');
			
		}else{
			$('.order-messages-cancel-seller-btn').css('display', 'block');
			$('.order-messages-deliver-btn').css('display', 'block');

			$('.order-messages-accept-cancel-btn').css('display', 'none');
			$('.order-messages-decline-cancel-btn').css('display', 'none');									
		}
	}

	var data = data.data;
	for (var i = 0; i < data.length; i++) {

		if(data[i].senderid == id){
			var msg = '<div class="message-bubble me">'+
					'<div class="message-bubble-inner">'+
						'<div class="message-avatar"><img src="<?php echo $_SESSION['profile'];?>" alt="" /></div>'+
						'<div class="message-text">'+
							'<p>'+data[i]['message']+'</p>';

							if(orderStatus == data[i].status){
								msg += orderHint;
							}
								
		}else{
			var senderprofile = '';
			if(parseInt(data[i].receiverid) != parseInt(buyerid)){
				senderprofile = 'images/upload/<?php echo $posterData['profile'];?>';
			}else{
				senderprofile = 'images/upload/<?php echo $myProfile;?>';
			}
			var msg = '<div class="message-bubble">'+
					'<div class="message-bubble-inner">'+
						'<div class="message-avatar"><img src="'+senderprofile+'" alt="" /></div>'+
						'<div class="message-text"><p>'+data[i]['message']+'</p>';
							
							if(orderStatus == data[i].status){
								msg += orderHint;
							}
		}

		msg += '</div>'+
					'<div class="clearfix"></div>'+
				'</div>';

		$('.message-content-inner').append(msg);
							
	}
	
	$('#msg').val('');
	$('#msg').css('height', '48px !important');
	$(".message-content-inner").animate({ scrollTop: $('.message-content-inner').prop("scrollHeight")}, 0);
	$('.popup-with-zoom-anim').magnificPopup({
		type: 'inline',
		fixedContentPos: false,
		fixedBgPos: true,
		overflowY: 'auto',
		closeBtnInside: true,
		preloader: false,
		midClick: true,
		removalDelay: 300,
		mainClass: 'my-mfp-zoom-in'
	});
	$('.mfp-image').magnificPopup({
		type: 'image',
		closeOnContentClick: true,
		mainClass: 'mfp-fade',
		image: {
			verticalFit: true
		}
	});
})
socket.on('sendOrderMessages', (data)=>{
	var orderStatus = data.orderStatus;
	var data = data.data;
	console.log("Receive sendOrderMessages data :::: ",data);
	var id = '<?php echo $_SESSION['id']?>';
	var buyerid = '<?php echo $order['buyerid']?>';
	var userid = '<?php echo $order['userid']?>';

	console.log("buyerid :::::::: ", buyerid);
	console.log("id :::::::: ", id);
	console.log("userid :::::::: ", userid);
	
	var orderHint = '';
	if(orderStatus == 'o_buyer_cancel' || orderStatus == 'o_seller_cancel'){
		orderHint = '<h6><em>Order Cancelled!</em></h6>';
	}else if(orderStatus == 'o_cancel_accept'){
		orderHint = '<h6><em>Order Cancel Accepted!</em></h6>';
	}else if(orderStatus == 'o_cancel_decline'){
		orderHint = '<h6><em>Order Cancel Declined!</em></h6>';
	}else if(orderStatus == 'o_delivery_complete_decline'){
		orderHint = '<h6><em>Order Delivery Complete Declined!</em></h6>';
	}else if(orderStatus == 'o_delivery_complete_accept'){
		orderHint = '<h6><em>Order Delivery Complete Accepted!</em></h6>';
	}else if(orderStatus == 'o_delivery_complete'){
		orderHint = '<h6><em>Order Delivered!</em></h6>';
	}
	
	if(data.senderid == id && data.senderid != buyerid){
		if(orderStatus == 'o_delivery_complete'){
			$('.order-messages-cancel-seller-btn').css('display', 'none');
			$('.order-messages-deliver-btn').css('display', 'none');

			$('.order-messages-accept-cancel-btn').css('display', 'none');
			$('.order-messages-decline-cancel-btn').css('display', 'none');

		}else if(orderStatus == 'o_seller_cancel'){
			$('.order-messages-cancel-seller-btn').css('display', 'none');
			$('.order-messages-deliver-btn').css('display', 'none');

			$('.order-messages-accept-cancel-btn').css('display', 'none');
			$('.order-messages-decline-cancel-btn').css('display', 'none');
		
		}else if(orderStatus == 'o_buyer_cancel'){
			$('.order-messages-cancel-seller-btn').css('display', 'none');
			$('.order-messages-deliver-btn').css('display', 'none');

			$('.order-messages-accept-cancel-btn').css('display', 'none');
			$('.order-messages-decline-cancel-btn').css('display', 'none');
		
		}else if(orderStatus == 'o_delivery_complete_decline'){
			$('.order-messages-cancel-seller-btn').css('display', 'block');
			$('.order-messages-deliver-btn').css('display', 'block');

			$('.order-messages-accept-cancel-btn').css('display', 'none');
			$('.order-messages-decline-cancel-btn').css('display', 'none');	
		
		}else if(orderStatus == 'o_delivery_complete_decline'){
			$('.order-messages-cancel-seller-btn').css('display', 'block');
			$('.order-messages-deliver-btn').css('display', 'block');

			$('.order-messages-accept-cancel-btn').css('display', 'none');
			$('.order-messages-decline-cancel-btn').css('display', 'none');	
	
		}else if(orderStatus == 'o_cancel_accept'){

			$('.order-messages-cancel-seller-btn').css('display', 'none');
			$('.order-messages-deliver-btn').css('display', 'none');

			$('.order-messages-accept-cancel-btn').css('display', 'none');
			$('.order-messages-decline-cancel-btn').css('display', 'none');

			$('.order-form-message').css('display', 'none');
			$('#orderTiming').css('display', 'none');
			
		}else{
			$('.order-messages-cancel-seller-btn').css('display', 'block');
			$('.order-messages-deliver-btn').css('display', 'block');

			$('.order-messages-accept-cancel-btn').css('display', 'none');
			$('.order-messages-decline-cancel-btn').css('display', 'none');									
		}

		var msg = '<div class="message-bubble me">'+
				'<div class="message-bubble-inner">'+
					'<div class="message-avatar"><img src="<?php echo $_SESSION['profile'];?>" alt="" /></div>'+
					'<div class="message-text">'+
						'<p>'+data['message']+'</p>'+orderHint;

	}else if(data.receiverid == id && data.receiverid != buyerid){
		if(orderStatus == 'o_delivery_complete'){
			$('.order-messages-cancel-seller-btn').css('display', 'none');
			$('.order-messages-deliver-btn').css('display', 'none');

			$('.order-messages-accept-cancel-btn').css('display', 'none');
			$('.order-messages-decline-cancel-btn').css('display', 'none');

		}else if(orderStatus == 'o_seller_cancel'){
			$('.order-messages-cancel-seller-btn').css('display', 'none');
			$('.order-messages-deliver-btn').css('display', 'none');

			$('.order-messages-accept-cancel-btn').css('display', 'none');
			$('.order-messages-decline-cancel-btn').css('display', 'none');
		
		}else if(orderStatus == 'o_buyer_cancel'){
			$('.order-messages-cancel-seller-btn').css('display', 'none');
			$('.order-messages-deliver-btn').css('display', 'none');

			$('.order-messages-accept-cancel-btn').css('display', 'block');
			$('.order-messages-decline-cancel-btn').css('display', 'block');
		
		}else if(orderStatus == 'o_delivery_complete_accept'){
			$('.order-messages-cancel-seller-btn').css('display', 'none');
			$('.order-messages-deliver-btn').css('display', 'none');

			$('.order-messages-accept-cancel-btn').css('display', 'none');
			$('.order-messages-decline-cancel-btn').css('display', 'none');	
			
			$('.order-form-message').css('display', 'none');
			$('#orderTiming').css('display', 'none');

		}else if(orderStatus == 'o_delivery_complete_decline'){
			$('.order-messages-cancel-seller-btn').css('display', 'block');
			$('.order-messages-deliver-btn').css('display', 'block');

			$('.order-messages-accept-cancel-btn').css('display', 'none');
			$('.order-messages-decline-cancel-btn').css('display', 'none');	
	
		}else if(orderStatus == 'o_cancel_accept'){

			$('.order-messages-cancel-seller-btn').css('display', 'none');
			$('.order-messages-deliver-btn').css('display', 'none');

			$('.order-messages-accept-cancel-btn').css('display', 'none');
			$('.order-messages-decline-cancel-btn').css('display', 'none');

			$('.order-form-message').css('display', 'none');
			$('#orderTiming').css('display', 'none');
			
		}else{
			$('.order-messages-cancel-seller-btn').css('display', 'block');
			$('.order-messages-deliver-btn').css('display', 'block');

			$('.order-messages-accept-cancel-btn').css('display', 'none');
			$('.order-messages-decline-cancel-btn').css('display', 'none');									
		}

		/*var msg = '<div class="message-bubble">'+
				'<div class="message-bubble-inner">'+
					'<div class="message-avatar"><img src="<?php echo $_SESSION['profile'];?>" alt="" /></div>'+
					'<div class="message-text">'+
						'<p>'+data['message']+'</p>';*/

		var senderprofile = '';
		if(parseInt(data.receiverid) != parseInt(buyerid)){
			senderprofile = 'images/upload/<?php echo $posterData['profile'];?>';
		}else{
			senderprofile = 'images/upload/<?php echo $myProfile;?>';
		}
		var msg = '<div class="message-bubble">'+
				'<div class="message-bubble-inner">'+
					'<div class="message-avatar"><img src="'+senderprofile+'" alt="" /></div>'+
					'<div class="message-text"><p>'+data['message']+'</p>'+orderHint;

	}

	if(data.senderid == id && data.senderid == buyerid){
		if(orderStatus == 'o_delivery_complete'){
			$('.order-messages-cancel-buyer-btn').css('display', 'none');
			$('.order-messages-accept-cancel-btn').css('display', 'none');
			$('.order-messages-decline-cancel-btn').css('display', 'none');

			$('.order-messages-accept-order-btn').css('display', 'block');
			$('.order-messages-decline-order-btn').css('display', 'block');

		}else if(orderStatus == 'o_seller_cancel'){
			$('.order-messages-cancel-buyer-btn').css('display', 'none');
			$('.order-messages-accept-order-btn').css('display', 'none');
			$('.order-messages-decline-order-btn').css('display', 'none');

			$('.order-messages-accept-cancel-btn').css('display', 'block');
			$('.order-messages-decline-cancel-btn').css('display', 'block');
		
		}else if(orderStatus == 'o_buyer_cancel'){
			$('.order-messages-cancel-buyer-btn').css('display', 'none');
			
			$('.order-messages-accept-order-btn').css('display', 'none');
			$('.order-messages-decline-order-btn').css('display', 'none');

			$('.order-messages-accept-cancel-btn').css('display', 'none');
			$('.order-messages-decline-cancel-btn').css('display', 'none');
		
		}else if(orderStatus == 'o_cancel_decline'){
			$('.order-messages-cancel-buyer-btn').css('display', 'block');
			$('.order-messages-accept-order-btn').css('display', 'none');
			$('.order-messages-decline-order-btn').css('display', 'none');

			$('.order-messages-accept-cancel-btn').css('display', 'none');
			$('.order-messages-decline-cancel-btn').css('display', 'none');
		
		}else if(orderStatus == 'o_cancel_accept'){
			$('.order-messages-cancel-buyer-btn').css('display', 'none');
			$('.order-messages-accept-order-btn').css('display', 'none');
			$('.order-messages-decline-order-btn').css('display', 'none');

			$('.order-messages-accept-cancel-btn').css('display', 'none');
			$('.order-messages-decline-cancel-btn').css('display', 'none');

			$('.order-form-message').css('display', 'none');
			$('#orderTiming').css('display', 'none');
		
		}else if(orderStatus == 'o_delivery_complete_accept'){
			$('.order-messages-cancel-buyer-btn').css('display', 'none');

			$('.order-messages-accept-order-btn').css('display', 'none');
			$('.order-messages-decline-order-btn').css('display', 'none');
			$('.order-messages-accept-cancel-btn').css('display', 'none');
			$('.order-messages-decline-cancel-btn').css('display', 'none');

			$('.order-form-message').css('display', 'none');
			$('#orderTiming').css('display', 'none');

			location.reload();

		}else{
			$('.order-messages-cancel-buyer-btn').css('display', 'block');

			$('.order-messages-accept-order-btn').css('display', 'none');
			$('.order-messages-decline-order-btn').css('display', 'none');
			$('.order-messages-accept-cancel-btn').css('display', 'none');
			$('.order-messages-decline-cancel-btn').css('display', 'none');
		}
		var senderprofile = '';
		if(parseInt(data.receiverid) != parseInt(buyerid)){
			senderprofile = 'images/upload/<?php echo $posterData['profile'];?>';
		}else{
			senderprofile = 'images/upload/<?php echo $myProfile;?>';
		}
		var msg = '<div class="message-bubble me">'+
				'<div class="message-bubble-inner">'+
					'<div class="message-avatar"><img src="'+senderprofile+'" alt="" /></div>'+
					'<div class="message-text"><p>'+data['message']+'</p>'+orderHint;

	}else if(data.receiverid == id && data.receiverid == buyerid){
		if(orderStatus == 'o_delivery_complete'){
			$('.order-messages-cancel-buyer-btn').css('display', 'none');
			$('.order-messages-accept-cancel-btn').css('display', 'none');
			$('.order-messages-decline-cancel-btn').css('display', 'none');

			$('.order-messages-accept-order-btn').css('display', 'block');
			$('.order-messages-decline-order-btn').css('display', 'block');

		}else if(orderStatus == 'o_seller_cancel'){
			$('.order-messages-cancel-buyer-btn').css('display', 'none');
			$('.order-messages-cancel-seller-btn').css('display', 'none');
			$('.order-messages-accept-order-btn').css('display', 'none');
			$('.order-messages-decline-order-btn').css('display', 'none');

			$('.order-messages-accept-cancel-btn').css('display', 'block');
			$('.order-messages-decline-cancel-btn').css('display', 'block');
		
		}else if(orderStatus == 'o_buyer_cancel'){
			$('.order-messages-cancel-buyer-btn').css('display', 'none');
			$('.order-messages-accept-order-btn').css('display', 'none');
			$('.order-messages-decline-order-btn').css('display', 'none');

			$('.order-messages-accept-cancel-btn').css('display', 'block');
			$('.order-messages-decline-cancel-btn').css('display', 'block');
		
		}else if(orderStatus == 'o_cancel_decline'){
			$('.order-messages-cancel-buyer-btn').css('display', 'block');
			$('.order-messages-accept-order-btn').css('display', 'none');
			$('.order-messages-decline-order-btn').css('display', 'none');

			$('.order-messages-accept-cancel-btn').css('display', 'none');
			$('.order-messages-decline-cancel-btn').css('display', 'none');
		
		}else if(orderStatus == 'o_cancel_accept'){
			$('.order-messages-cancel-buyer-btn').css('display', 'none');
			$('.order-messages-accept-order-btn').css('display', 'none');
			$('.order-messages-decline-order-btn').css('display', 'none');

			$('.order-messages-accept-cancel-btn').css('display', 'none');
			$('.order-messages-decline-cancel-btn').css('display', 'none');

			$('.order-form-message').css('display', 'none');
			$('#orderTiming').css('display', 'none');
		
		}else{
			$('.order-messages-cancel-buyer-btn').css('display', 'block');

			$('.order-messages-accept-order-btn').css('display', 'none');
			$('.order-messages-decline-order-btn').css('display', 'none');
			$('.order-messages-accept-cancel-btn').css('display', 'none');
			$('.order-messages-decline-cancel-btn').css('display', 'none');
		}
		var senderprofile = '';
		if(parseInt(data.receiverid) != parseInt(buyerid)){
			senderprofile = 'images/upload/<?php echo $posterData['profile'];?>';
		}else{
			senderprofile = 'images/upload/<?php echo $myProfile;?>';
		}
		var msg = '<div class="message-bubble">'+
				'<div class="message-bubble-inner">'+
					'<div class="message-avatar"><img src="'+senderprofile+'" alt="" /></div>'+
					'<div class="message-text"><p>'+data['message']+'</p>'+orderHint;
	
	}

	msg += '</div>'+
				'<div class="clearfix"></div>'+
			'</div>';

	if(typeof data.receiverid != 'undefined' && typeof buyerid != 'undefined'){
		$('.message-content-inner').append(msg);
	}
	
	$('#msg').val('');
	$('#msg').css('height', '48px !important');
	$(".message-content-inner").animate({ scrollTop: $('.message-content-inner').prop("scrollHeight")}, 0);
	$('.popup-with-zoom-anim').magnificPopup({
		type: 'inline',
		fixedContentPos: false,
		fixedBgPos: true,
		overflowY: 'auto',
		closeBtnInside: true,
		preloader: false,
		midClick: true,
		removalDelay: 300,
		mainClass: 'my-mfp-zoom-in'
	});
	$('.mfp-image').magnificPopup({
		type: 'image',
		closeOnContentClick: true,
		mainClass: 'mfp-fade',
		image: {
			verticalFit: true
		}
	});

})

$(function(){
	$(".message-content-inner").animate({ scrollTop: $('.message-content-inner').prop("scrollHeight")}, 0);
})
function confirmation(id, buyerid, userid, status){
	if(status == 'o_buyer_cancel' || status == 'o_seller_cancel'){
		$('#titlefordelivery').text('Order Cancel Request From <?php echo $posterData['username'];?>');	
	}
	if(status == 'o_delivery_complete'){
		$('#titlefordelivery').text('Order Deliver From <?php echo $posterData['username'];?>');	
	}
	if(status == 'o_delivery_complete_accept'){
		$('#titlefordelivery').text('Order Deliver Accept From <?php echo $posterData['username'];?>');	
	}
	if(status == 'o_delivery_complete_decline'){
		$('#titlefordelivery').text('Order Deliver Decline From <?php echo $posterData['username'];?>');	
	}
	if(status == 'o_cancel_decline'){
		$('#titlefordelivery').text('Order Cancel Decline From <?php echo $posterData['username'];?>');	
	}
	if(status == 'o_cancel_accept'){
		$('#titlefordelivery').text('Order Cancel Accept From <?php echo $posterData['username'];?>');	
	}
	// $('#titlefordelivery').text('Decline Order Cancel Request From <?php echo $posterData['username'];?>');
	$('#orderid').val(id);
	$('#status').val(status);
	var sess = '<?php echo $myid;?>';
	if(sess == 'me'){
		$('#isSeller').val('0');
		$('#senderid').val(buyerid);
		$('#receiverid').val(userid);
	}else{
		$('#isSeller').val('1');
		$('#senderid').val(userid);
		$('#receiverid').val(buyerid);
	}
}
function make_review(id){

}

$('.order-form-message').submit(function(event){
	event.preventDefault();
  	var formData  = $( this ).serializeArray();
  	var requestData = {};
	for (var i = 0; i < formData.length; i++) {
		requestData[formData[i].name] = formData[i].value;
 	}
 	requestData['orderid'] = '<?php echo $order['id'];?>';
 	requestData['status'] = null;
 	console.log("send request sendOrderMessages :::::::: ", requestData);
	socket.emit("sendOrderMessages", requestData);

})


/*function getTimeDifference(startDate, endDate, type){
 	var date1 = new Date(startDate);
	var date2 = new Date(endDate);
	var diffMs = (date2 - date1); // milliseconds between now & Christmas
	var one_day = 1000*60*60*24;
	if(type == 'day'){
	  	var date1 = new Date(startDate.getFullYear(), startDate.getMonth(), startDate.getDate(),0,0,0);
	  	var date2 = new Date(endDate.getFullYear(), endDate.getMonth(), endDate.getDate(),0,0,0);
	  	var timeDiff = date2.getTime() - date1.getTime();
	  	var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));
	  	return diffDays;

 	}else if(type == 'hour'){
	  	return Math.round((diffMs % 86400000) / 3600000); 
 	}else if(type == 'minute'){
	  	return Math.round(((diffMs % 86400000) % 3600000) / 60000);
 	}else if(type == 'seconds'){
	  	return Math.round((((diffMs % 86400000) % 3600000) / 60000) / 60000);
 	}else{
	   return Math.round((diffMs / 1000)); 
 	}
}
Date.prototype.addHours= function(h){
    console.log("this.getHours()v ::::: ", this.getHours());
    this.setHours(this.getHours()+h);
    return this;
}*/


	// Snackbar for user status switcher
$('.buttonClick').click(function(){
	$('.mfp-close').trigger('click');
})
$('.status-switch label.user-invisible').click(function(){
	console.log("offline");
	online(0);
	$('.user-avatar').removeClass('status-online');
});
$('.status-switch label.user-online').click(function(){
	console.log("online");
	online(1);
	$('.user-avatar').addClass('status-online');
});

function online(online){
	$.ajax({
		url: '<?php echo SITE_URL;?>/v1/services/index.php?service=online&code='+online,
		type: 'GET',
		success: function(results){
			var results = JSON.parse(results);
			console.log("results :::::: ", results);
		},
		error: function(err){
			console.log("err :::::: ",err);
		}
	})
}
</script>


<script>

$( "#leave-message-form" ).submit(function( event ) {
	  	event.preventDefault();
	  	var formData = new FormData(this);
	  	$.ajax({
			url: '<?php echo SITE_URL;?>/v1/services/service.php?service=sendOrderConfirmation',
			type: 'POST',
			data:formData,
            cache:false,
            contentType: false,
            processData: false,
			success: function(results){
				console.log("results :::::: ", results);
				results = JSON.parse(results);
				$('.mfp-close').trigger('click');
				if(results['error'] == 'Y'){
						swal("Oops!", results['msg']);
			  	}else{
			  		console.log("send request sendOrderMessages :::::::: status valid", results);
			  		socket.emit("sendOrderMessages", results.data);
			  		$('#message2').text('');
			  		if(results.data['status'] == 'o_delivery_complete_accept'){
			  			$.ajax({
								url: '<?php echo SITE_URL;?>/v1/services/service.php?service=deliverOrder',
								type: 'POST',
								data:formData,
					            cache:false,
					            contentType: false,
					            processData: false,
								success: function(results){
									console.log("results :::::: ", results);
									// results = JSON.parse(results);
									if(results['error'] == 'Y'){
										swal("Oops!","Order not completed!");
							  	}else{
							  		swal("Great!","Your Order Delivered to Buyer!");
							  	}
								},
								error: function(err){
									console.log("err :::::: ",err);
									location.reload();
								}
							})
			  		}else{
			  			console.log("::::::: sendOrderConfirmation :::::::");
								// location.reload();
			  		}
			  		
			  	}
			},
			error: function(err){
				console.log("err :::::: ",err);
			}
		})
});
socket.on('make_review', (data)=>{
	$('.sellerReviewBtn').css('display', 'block');
})
$( "#feeback-message-form" ).submit(function( event ) {
	  	event.preventDefault();
	  	var formData = new FormData(this);
	  	$.ajax({
			url: '<?php echo SITE_URL;?>/v1/services/service.php?service=sendOrderFeeback',
			type: 'POST',
			data:formData,
            cache:false,
            contentType: false,
            processData: false,
			success: function(results){
				console.log("results :::::: ", results);
				results = JSON.parse(results);
				if(results['error'] == 'N'){
					if(results['data']['buyerReviewed'] != '' && parseInt(results['data']['buyerReviewed']) == 1){
						socket.emit('make_review', {buyer: true});
					}
					$('.closeable').css('display', 'block');
					$('.closeable').addClass('success');
			  		$('#successmsg').html('<strong>Success </strong> '+results['msg']);
			  		$('.reviewmake').css('display', 'none');
					$('.review-button').css('display', 'none');
			  	}else{
					$('.closeable').addClass('error');
					$('#successmsg').html('<strong>Problem </strong> '+results['msg']);
				}

				$('.closeable').fadeIn();
			  	setTimeout(function(){
			  		$('.closeable').fadeOut();
			  		$('.mfp-close').trigger('click');
			  		location.reload();
			  	},1000);
			},
			error: function(err){
				console.log("err :::::: ",err);
			}
		})
});


</script>
</body>
</html>