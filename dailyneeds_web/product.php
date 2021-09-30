<?php
error_reporting(0);
	include("v1/config.php");
	if(!isset($_SESSION)) 
	{ 
	    session_start(); 
	} 

	if(isset($_SESSION['id'])){
		$sign = 1;
	}else{
		$sign = 0;
	}
	$uid = mysqli_real_escape_string($db, $_GET['uid']);
	$sql = "SELECT username, email, id FROM register WHERE id = '$uid'";
	$result = mysqli_query($db, $sql);
	$userData = mysqli_fetch_array($result,MYSQLI_ASSOC);
	
	if($_GET['sid']){

		$sid = mysqli_real_escape_string($db, $_GET['sid']);
		$sql = "SELECT * FROM user_services WHERE id = '$sid'";
		$result = mysqli_query($db, $sql);
		$user_services = mysqli_fetch_array($result,MYSQLI_ASSOC);

		$uid = mysqli_real_escape_string($db, $userData['id']);
		$serviceid = mysqli_real_escape_string($db, $user_services['id']);
		$sql = "SELECT * FROM service_review WHERE userid = '$uid' and serviceid='$serviceid'";
		$result = mysqli_query($db, $sql);
		$review = mysqli_fetch_all($result,MYSQLI_ASSOC);
		// $review = array();
		$currentTime = date_create();
		foreach ($review as $key => $value) {
			$email = mysqli_real_escape_string($db, $value['email']);
			$sql = "SELECT * FROM register WHERE email = '$email'";
			$result = mysqli_query($db, $sql);
			$reviewdata = mysqli_fetch_array($result,MYSQLI_ASSOC);
			$review[$key]['profile'] = $reviewdata['profile'];
			$review[$key]['username'] = $reviewdata['username'];
			$review[$key]['days_between']  	= date_diff( date_create(date('Y-m-d H:m:s')), date_create($value['date']))->d;
		}
		// echo '<pre>';
		// print_r($review);
		// echo '</pre>';
		// die;
		$reviewCount = count($review);
		if(!isset($_SESSION['id'])){
			$contact_popup = '#sign-in-dialog';
			$contact_class = 'popup-with-zoom-anim log-in-button';
		}else{
			$myid = mysqli_real_escape_string($db, $_SESSION['id']);
			$sql = "SELECT * FROM room WHERE (buyerid='$myid' and freelancerid='$uid')  or (buyerid='$uid' and freelancerid='$myid')";
			$result = mysqli_query($db, $sql);
			$room = mysqli_fetch_all($result, MYSQLI_ASSOC);
			if(count($room)){
				$protocol = stripos($_SERVER['SERVER_PROTOCOL'],'https') === true ? 'https' : 'http';
				$contact_popup = $protocol.'://'.$_SERVER['HTTP_HOST'].'/chat';
				$contact_class = 'log-in-button';
			}else{
				$contact_popup = '#small-dialog-2';
				$contact_class = 'popup-with-zoom-anim log-in-button';
			}
		}


	}else{
		header('Location: http://dailyneeds.co.nz/404');
	}

?>
<!doctype html>
<html lang="en">
<head>

<!-- Basic Page Needs
================================================== -->
<title>DailyNeeds | Product</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

<!-- CSS
================================================== -->
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/colors/blue.css">
<style type="text/css">
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
</style>
</head>
<body>

<!-- Wrapper -->
<div id="wrapper">

<!-- Header Container
================================================== -->
<?php include("views/header.php");?>
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
						<div class="header-image"><a href="<?php echo 'images/services/'.$user_services['image'];?>"><img src="<?php echo 'images/services/'.$user_services['image'];?>" alt=""></a></div>
						<div class="header-details">
							<h3><?php echo $user_services['title'];?></h3>
							<h5>About the Employer</h5>
							<ul>
								<li><a href="javascript:;"><i class="icon-feather-user"></i><?php echo $userData['username'];?></a></li>
							</ul>
						</div>
					</div>
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
			
			<!-- Description -->
			<div class="single-page-section">
				<h3 class="margin-bottom-25">Project Description</h3>
				<p><?php echo $user_services['description']?></p>
			</div>

			<div class="clearfix"></div>
			
		</div>
		

		<!-- Sidebar -->
		<div class="col-xl-4 col-lg-4">
			<div class="sidebar-container">

				<div class="sidebar-widget">
					<div class="bidding-widget">
						<div class="bidding-headline"><h3>Bid on this job!</h3></div>
						<div class="bidding-inner">

							<?php 

								$sql = "SELECT count(*) as total, id, payment FROM orders WHERE buyerid='$myid' and userid='$uid' and serviceid='$sid' and status<>'o_delivery_complete_accept' and status<>'o_cancel_accept'";
								$result = mysqli_query($db, $sql);
								$orderData = mysqli_fetch_all($result, MYSQLI_ASSOC);
								if(count($orderData) && (int)$orderData[0]['total']){
									if($orderData[0]['payment'] == 'pending'){

									?>
										<a href="<?php echo ($sign == 0) ? '#sign-in-dialog' : SITE_URL.'/checkout_confirmation?cc='.base64_encode((string)$orderData[0]['id']);?>" class="button ripple-effect move-on-hover full-width margin-top-30" style="color: #FFF;"><span>Make Job</span></a>

							<?php
									}else{?>
										<a href="<?php echo ($sign == 0) ? '#sign-in-dialog' : 'javascript:;';?>" onclick="orderAlready();" class="button ripple-effect move-on-hover full-width margin-top-30" style="color: #FFF;"><span>Make Job</span></a>
							<?php	}
								}else{
							?>
								<a href="<?php echo ($sign == 0) ? '#sign-in-dialog' : '#small-dialog-1';?>" class="popup-with-zoom-anim button ripple-effect move-on-hover full-width margin-top-30" style="color: #FFF;"><span>Make Job</span></a>
							<?php		
								}

							?>
							<a href="<?php echo $contact_popup;?>" class="<?php echo $contact_class;?>"><button class="button ripple-effect move-on-hover full-width margin-top-30"><span>Contact Me</span></button></a>

						</div>
					</div>
				</div>

			

			</div>
		</div>

		<div class="col-xl-12 col-md-12">
			<!-- Freelancers Bidding -->
			<div class="boxed-list margin-bottom-60">
				<div class="boxed-list-headline">
					<h3><i class="icon-material-outline-group"></i> Reviews</h3>
				</div>
				<ul class="boxed-list-ul">
					<?php 
						if($reviewCount){
							foreach ($review as $value) { ?>
								
								<li>
									<div class="bid">
										<div class="bids-avatar">
											<div class="freelancer-avatar">
												<a href="javascript:;"><img src="<?php echo ($value['profile'] != '' || $value['profile']) ? 'images/upload/'.$value['profile'] : 'images/user-avatar-placeholder.png';?>" style="width:62px;height: 62px" alt=""></a>
											</div>
										</div>
										<div class="bids-content">
											<div class="freelancer-name">
												<h4><a href="javascript:;"><?php echo $value['username'];?> <img class="flag" src="images/flags/gb.svg" alt="" title="United Kingdom" data-tippy-placement="top"></a></h4>
												<p><?php echo $value['text'];?></p>
												<div class="star-rating" data-rating="<?php echo $value['rate'];?>"></div>
											</div>
										</div>
										<div class="bids-bid">
											<div class="bid-rate">
												<div class="rate">$<?php echo $value['price'];?></div>
												<span>in <?php echo $value['days_between'];?> days</span>
											</div>
										</div>
									</div>
								</li>
						<?php }
						}else{ ?>
							<li>
								<center><h3 class="job-listing-title">No Reviews !</h3></center>
							</li>
						
					<?php }?>
				</ul>
			</div>
		</div>

	</div>
</div>

<!-- Send Direct Message Popup
================================================== -->
<div id="small-dialog-1" class="zoom-anim-dialog mfp-hide dialog-with-tabs">
	
	<div class="sign-in-form">
		<ul class="popup-tabs-nav">
			<li><a href="#tab1">Make Order</a></li>
		</ul>
		<div class="popup-tabs-container">

			<!-- Tab -->
			<div class="popup-tab-content" id="tab">
				
				<!-- Welcome Text -->
				<div class="welcome-text">
					<h3 id="offermsg">Accept Offer From <?php echo $userData['username'];?></h3>
					<div class="bid-acceptance margin-top-15" id="offerbudget">
						Accept Order From $<?php echo $user_services['price'];?>
					</div>
				</div>

						
				<form id="terms">
					
					<input type="text" name="sellerid" value="<?php echo $userData['id'];?>" id="sellerid" required hidden>
					<input type="text" name="serviceid" value="<?php echo $user_services['id'];?>" id="serviceid" required hidden>
					<div class="radio">
						<input id="radio-1" name="accept_terms" type="radio" required>
						<label for="radio-1"><span class="radio-label"></span>  I have read and agree to the Terms and Conditions</label>
					</div>

				</form>

				<!-- Button -->
				<button class="margin-top-15 button full-width button-sliding-icon ripple-effect" type="submit" form="terms">Accept <i class="icon-material-outline-arrow-right-alt"></i></button>

			</div>

		</div>
	</div>
</div>
<!-- Send Direct Message Popup / End -->

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
					<h3>Send <?php echo $userData['username'];?> A Message</h3>
					<span>Please provide a description or any instructions for your project</span>
				</div>
					
				<!-- Form -->
				<form method="post" id="leave-message-form">
					<input type="text" value="<?php echo $userData['id'];?>" name="freelancerid" hidden>
					<input type="text" value="<?php echo $_SESSION['id'];?>" name="buyerid" hidden>
					<input type="text" value="<?php echo $user_services['id'];?>" name="serviceid" hidden>
					<h6>(Max. 200 Characters)</h6>
					<textarea class="with-border" placeholder="Leave your Message here" name="message" id="message2" cols="7" maxlength="200" required></textarea>
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

<!-- Spacer -->
<div class="margin-top-15"></div>
<!-- Spacer / End-->

<?php include("views/footer.php");?>

</div>
<!-- Wrapper / End -->
<?php include("views/model.php");?>

<!-- <a href="#sign-in-dialog" class="popup-with-zoom-anim log-in-button"></a> -->
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
<script src="http://cdnjs.cloudflare.com/ajax/libs/socket.io/2.1.1/socket.io.js"></script>
<script src="js/chatscript.js?v=2"></script>
<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<!-- Snackbar // documentation: https://www.polonel.com/snackbar/ -->
<script src="https://sdk.accountkit.com/en_US/sdk.js"></script>
<script type="text/javascript">
	AccountKit_OnInteractive = function(){
    AccountKit.init(
      {
        appId:"663509717168378", 
        state:"abcd", 
        version:"v1.0",
        fbAppEventsEnabled:true
      }
    );
  };

    
  // login callback
  function loginCallback(response) {
    if (response.status === "PARTIALLY_AUTHENTICATED") {
      var code = response.code;
      var csrf = response.state;
        console.log(" code ::::::::::: ", code);
        
        $.post("<?php echo SITE_URL;?>/verify", { code : code, csrf : csrf }, function(result){
            console.log("result :::::::::::::: ", result);
            result = JSON.parse(result);
            console.log("result :::::::::::::: ", result, result.national_number);

            if(typeof result.phone.national_number != 'undefined'){

	            $('#forget-mobile-no').val(result.phone.national_number);
	            $('.forgot-password').trigger('click');

            }else{
            	swal("Oops!", "System Error");
            }
        });
        
    }
    else if (response.status === "NOT_AUTHENTICATED") {
      // handle authentication failure
      swal("Oops!", "Contact Details Not Authenticate!");
    }
    else if (response.status === "BAD_PARAMS") {
      // handle bad parameters
     	swal("Oops!", "Contact Details Not Authenticate!");   
    }
  }
    
    
  function phone_btn_onclick() {
    // you can add countryCode and phoneNumber to set values
    AccountKit.login('PHONE', {}, // will use default values if this is not specified
      loginCallback);
  }
</script>
<script>
function orderAlready(){
	swal("Oops!", "Order Already On Progress!");
}
// Snackbar for user status switcher
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

$('#leave-message-form').submit(function(event){
	event.preventDefault();
  	var formData  = $( this ).serializeArray();
	console.log("formData ::::::: ", formData);
	sendMessage(formData);
})

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
// Snackbar for user status switcher
$('#snackbar-user-status label').click(function() { 
	Snackbar.show({
		text: 'Your status has been changed!',
		pos: 'bottom-center',
		showAction: false,
		actionText: "Dismiss",
		duration: 3000,
		textColor: '#fff',
		backgroundColor: '#383838'
	}); 
}); 

// Snackbar for "place a bid" button
$('#snackbar-place-bid').click(function() { 
	Snackbar.show({
		text: 'Your bid has been placed!',
	}); 
}); 


// Snackbar for copy to clipboard button
$('.copy-url-button').click(function() { 
	Snackbar.show({
		text: 'Copied to clipboard!',
	}); 
});

// accept order by user service
$( "#terms" ).submit(function( event ) {
	  	event.preventDefault();
	  	var formData = new FormData(this);
	  	$.ajax({
			url: '<?php echo SITE_URL;?>/v1/services/service.php?service=acceptOffer',
			type: 'POST',
			data:formData,
            cache:false,
            contentType: false,
            processData: false,
			success: function(results){
				console.log("results :::::: ", results);
				results = JSON.parse(results);
				if(results['error'] == 'Y'){
					$('addmsg').text(results['msg']);
			  	}else{
			  		$('addmsg').text(results['msg']);
			  		window.location = '<?php echo SITE_URL;?>/checkout_confirmation?cc='+results['order'];
			  	}

			  	// $('.openBOx').trigger('click');
				setTimeout(function(){
					// $('.mfp-close').trigger('click');
					// window.location = '<?php echo SITE_URL;?>/checkout_confirmation?cc='+results['order'];
				},1000);
			},
			error: function(err){
				console.log("err :::::: ",err);
			}
		})
	});

$('#login-form').submit(function(event){
		event.preventDefault();
	  	var formData = new FormData(this);
	  	$.ajax({
			url: '<?php echo SITE_URL;?>/v1/services/login.php?service=login',
			type: 'POST',
			data:formData,
            cache:false,
            contentType: false,
            processData: false,
			success: function(results){
				var results = JSON.parse(results);
				console.log("results L::::: ", results);
				if(results['error'] == 'N'){
					window.location = "<?php echo $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];?>";
				}else{
					swal("Oops", results['msg']);
				}
			},
			error: function(err){
				console.log("err :::::: ",err);
			}
		})
	})
	$('#forget-form').submit(function(event){
		event.preventDefault();
			if($('#forget-npassword').val() == $('#forget-ncpassword').val()){
				var formData = new FormData(this);
		  	$.ajax({
					url: '<?php echo SITE_URL;?>/v1/services/login.php?service=forgetPassword',
					type: 'POST',
					data:formData,
		            cache:false,
		            contentType: false,
		            processData: false,
					success: function(results){
						console.log("results L::::: ", results);
						var results = JSON.parse(results);
						if(results['error'] == 'N'){
							window.location = "<?php echo $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];?>";
						}else{
							console.log("results['msg'] ::::: ", results['msg']);
							swal("Oops", results['msg']);
						}
					},
					error: function(err){
						console.log("err :::::: ",err);
					}
				})
	  	}else{
				swal("Oops!", "Password does not match!");
			}
	})
	$( "#register-account-form" ).submit(function( event ) {
	  	event.preventDefault();
	  	var formData = new FormData(this);
	  	console.log("formatsdta ::::: ", formData);
	  	$.ajax({
			url: '<?php echo SITE_URL;?>/v1/services/login.php?service=register',
			type: 'POST',
			data:formData,
            cache:false,
            contentType: false,
            processData: false,
			success: function(results){
				console.log("results :::::: ", results);
				console.log("results['error'] :::::: ", results['error']);

				if(results['error'] == 'N'){
					window.location = "<?php echo $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];?>";
				}else{
					swal("Oops", results['msg']);
				}
			},
			error: function(err){
				console.log("err :::::: ",err);
			}
		})
	});
</script>

</body>
</html>