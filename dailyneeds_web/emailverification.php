<?php 
include("v1/config.php");

if(!isset($_SESSION)) 
{ 
	session_start(); 
} 
if(isset($_SESSION['id'])){
	$userid = mysqli_real_escape_string($db, $_SESSION['id']);
	$sql = "SELECT * FROM register WHERE id='$userid'";
	$result = mysqli_query($db, $sql);
	$userData = mysqli_fetch_array($result,MYSQLI_ASSOC);
}else{
	header('Location: http://localhost/DailyNeeds');
}

?>
<!DOCTYPE html>  
<html lang="en">
<head>

	<title>Verify Your email</title>

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
			min-height: 1600px !important;
		}
		.dashboard-content-inner{
			min-height: 1600px !important;
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
	</style>
</head>
<body>

	<!-- Wrapper -->
	<div id="wrapper">

		<?php include("views/header.php");?>
		<?php include("views/session.php");?>

		<div class="clearfix"></div>
		<?php

		error_reporting(0);

		$code = $_POST["code"];
		$csrf_nonce = $_POST["csrf_nonce"];
		$ch = curl_init();

//Here are the set URL elements
		$fb_app_id = '381652462609043';
		$ak_secret = '361dcd649493c12f00520b40e7276548';
		$token = 'AA|'.$fb_app_id.'|'.$ak_secret;
  // Here we are going to get access tokens
		$url = 'https://graph.accountkit.com/v1.1/access_token?grant_type=authorization_code&code='.$_POST["code"].'&access_token='.$token;
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_URL,$url);
		$result=curl_exec($ch);
		$info = json_decode($result); 

  // Get the account information
		$url = 'https://graph.accountkit.com/v1.1/me/?access_token='.$info->access_token;
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_URL,$url);
		$result=curl_exec($ch);
		curl_close($ch);
		$final = json_decode($result);  


		?>
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons">
		<link  href="https://code.getmdl.io/1.1.3/material.indigo-pink.min.css">
		<script src="https://sdk.accountkit.com/en_US/sdk.js"></script>
		<script>
  // initialize Account Kit with CSRF 
  AccountKit_OnInteractive = function(){
  	AccountKit.init(
  	{
  		appId:'381652462609043',         
  		state:"{{csrf}}", 
  		version:"v1.1"
  	}
  	);
  };
  // login callback
  function loginCallback(response) {
  	console.log(response);
  	if (response.status === "PARTIALLY_AUTHENTICATED") {
  		document.getElementById("code").value = response.code;
  		document.getElementById("csrf_nonce").value = response.state;
  		document.getElementById("profile-form").submit();

  	}


  	if (response.status === "NOT_AUTHENTICATED") {
      // handle authentication failure
      console.log("Authentication failure");
  }
  else if (response.status === "BAD_PARAMS") {
      // handle bad parameters
      console.log("Bad parameters");
  }
}

  // phone form submission handler
  function phone_btn_onclick() {
    // you can add countryCode and phoneNumber to set values
    AccountKit.login('PHONE', {}, 
    	loginCallback);
}
  // email form submission handler
  function email_btn_onclick() {  
  	AccountKit.login('EMAIL', {}, 
  		loginCallback);
  }

</script>

<div class="dashboard-content-container" data-simplebar>
	<div class="dashboard-content-inner" >

		<!-- Dashboard Headline -->
		<div class="dashboard-headline">
			<center><h3><strong>Verify Email</strong></h3></center>
		</div>

		<form method="post" id="profile-form" enctype="multipart/form-data">
			<!-- Row -->
			<div class="row">
				<!-- Dashboard Box -->
				<div class="col-xl-12">
					<div class="dashboard-box margin-top-0">

						<!-- Headline -->
						<div class="headline">
							<h3><i class="icon-material-outline-account-circle">
							</i> Verify Email</h3>
						</div>

						<div class="content with-padding padding-bottom-0">

							<div class="row">

								<div class="col-auto">
									<div class="avatar-wrapper"  title="Change Avatar">
										<img class="profile-pic" src="images/upload/<?php echo ($userData['profile']) ?>" alt="" />
										<div class="upload-button"></div>

									</div>
								</div>

								<div class="col">
									<div class="row">


										<div class="col-xl-6" >
											<div class="submit-field" >
												<h5>Email</h5>
												<input type="text" class="with-border" onclick="email_btn_onclick();"  name="email" id="email"  value="<?=$final->email->address?>" >
											</div>

											<input type="hidden" name="code" id="code">
											<input type="hidden" name="csrf_nonce" id="csrf_nonce"> 				
											<!-- Button -->
												<input class="button ripple-effect big margin-top-30" type="submit" value="Verify" name="Save Changes">
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- Row / End -->
		</form>

		<br><br>

	</div>
</div>
<!-- Dashboard Content / End -->

<?php include("views/footer.php");?>

</div>

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
<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<!-- Snackbar // documentation: https://www.polonel.com/snackbar/ -->
<script>
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

	$('#profile-form').submit(function(){
		var formData = new FormData(this);
		console.log("formatsdta ::::: ", formData);
		$.ajax({
			url: '<?php echo SITE_URL;?>updatedata.php?service=updatemydata',
			type: 'POST',
			data:formData,
			cache:false,
			contentType: false,
			processData: false,
			success: function(results){
				results = JSON.parse(results);
				if(results['error'] == 'N'){
					swal("Great! Profile Update Successfully")
					.then((value) => {
						window.location = '<?php echo SITE_URL;?>profile.php';
					});
				}else{
					swal("Oops!", results.msg);
				}
			},
			error: function(err){
				console.log("err :::::: ",err);
			}
		})
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
</script>
</center>
</body>
</html>       