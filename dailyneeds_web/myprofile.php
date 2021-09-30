<?php 
include("v1/config.php");
$sql = "SELECT * FROM city";
$result = mysqli_query($db, $sql);
$cities = mysqli_fetch_all($result,MYSQLI_ASSOC);

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
<!doctype html>
<html lang="en">
<head>

<!-- Basic Page Needs
================================================== -->
<title>DailyNeeds | MyProfile</title>
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
<!-- Header Container / End -->


	<!-- Dashboard Content
	================================================== -->
	<div class="dashboard-content-container" data-simplebar>
		<div class="dashboard-content-inner" >
			
			<!-- Dashboard Headline -->
			<div class="dashboard-headline">
				<center><h2><strong>My Profile</strong></h2></center>
			</div>
			
			<form method="post" id="profile-form" enctype="multipart/form-data">
				<!-- Row -->
				<div class="row">
					<!-- Dashboard Box -->
					<div class="col-xl-12">
						<div class="dashboard-box margin-top-0">

							<!-- Headline -->
							<div class="headline">
								<h3><i class="icon-material-outline-account-circle"></i> My Account</h3>
							</div>

							<div class="content with-padding padding-bottom-0">

								<div class="row">

									<div class="col-auto">
										<div class="avatar-wrapper" data-tippy-placement="bottom" title="Change Avatar">
											<img class="profile-pic" src="images/user-avatar-placeholder.png" alt="" />
											<div class="upload-button"></div>
											<input class="file-upload" type="file" name="file" accept="image/*"/>
										</div>
									</div>

									<div class="col">
										<div class="row">

										<!--	<div class="col-xl-6">
												<div class="submit-field">
													<h5>Username</h5>
													<input type="text" name="fname" hidden>
													<input type="text" name="lname" hidden>
													<input type="text" class="with-border" value="<?php echo $userData['username'];?>" name="lname" id="lname" disabled>
												</div>
											</div>

											<div class="col-xl-6">
												<div class="submit-field">
													<h5>Email</h5>
													<input type="text" class="with-border" id="email" value="<?php echo $userData['email'];?>" disabled>
												</div>
											</div> --> 

											<div class="col-xl-6">
												<div class="submit-field">
													<h5>Username</h5>
													<input type="text" class="with-border" name="username" id="username" value="<?php echo $userData['username'];?>">
												</div>
											</div>

											<div class="col-xl-6">
												<div class="submit-field">
													<h5>Email</h5>
													<input type="text" class="with-border" name="email" id="email" value="<?php echo $userData['email'];?>">
												</div>
											</div>
										</div>
									</div>
								</div>

							</div>
						</div>
					</div>

					<!-- Dashboard Box -->
					<div class="col-xl-12">
						<div class="dashboard-box">

							<!-- Headline -->
							<div class="headline">
								<h3><i class="icon-material-outline-face"></i> My Profile</h3>
							</div>

							<div class="content">
								<ul class="fields-ul">
							<li>
							<div class="row">
									<div class="col-xl-6">
										<div class="submit-field">
											<h5>Tagline</h5>
											<input type="text" class="with-border" id="tagline" name="tagline" value="<?php echo $userData['tagline'];?>" placeholder="Enter Tagline">
										</div>
									</div>

									<div class="col-xl-6">
										<div class="submit-field">
											<h5>City</h5>
											<select  data-size="7" id="city" name="city">
												<option value="">Select City</option>
												<?php foreach ($cities as $value) { ?>
													<option value="<?php echo $value['id'];?>" <?php echo ($value['id'] == $userData['city']) ? 'selected' : '';?>><?php echo $value['name'];?></option>
												<?php }?>
											</select>
										</div>
									</div>
									
									<div class="col-xl-12">
										<div class="submit-field">
											<h5>Introduce Yourself</h5>
											<textarea cols="30" rows="5" class="with-border" name="description" id="description" placeholder="Please tell us about any hobbies, additional expertise, or anything else you’d like to add." maxlength="1000"><?php echo $userData['description'];?></textarea>
										</div>
									</div>

								</div></li>
							</ul>
							</div>
						</div>
					</div>

					<!-- Dashboard Box -->
					<div class="col-xl-12">
						<div id="test1" class="dashboard-box">

							<!-- Headline -->
							<div class="headline">
								<h3><i class="icon-material-outline-lock"></i> Password & Security</h3>
							</div>

							<div class="content with-padding">
								<div class="row">
									<div class="col-xl-4">
										<div class="submit-field">
											<h5>Current Password</h5>
											<input type="password" class="with-border" id="cpassword" name="cpassword" minlength="6">
										</div>
									</div>

									<div class="col-xl-4">
										<div class="submit-field">
											<h5>New Password</h5>
											<input type="password" class="with-border" id="npassword" name="npassword" minlength="6">
										</div>
									</div>

									<div class="col-xl-4">
										<div class="submit-field">
											<h5>Repeat New Password</h5>
											<input type="password" class="with-border" id="rnpassword" name="rnpassword" minlength="6">
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					
					<!-- Button -->
					<div class="col-xl-12">
						<input class="button ripple-effect big margin-top-30" type="submit" value="Save Changes" name="Save Changes">
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
<!-- Wrapper / End -->



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
	event.preventDefault();
		if($('#cpassword').val() != ''){
			if($('#npassword').val() == ''){
				swal("Oops", "Password not matched!");
				return false;
			}
			if($('#rnpassword').val() == ''){
				swal("Oops", "Password not matched!");
				return false;
			}
			if($('#npassword').val() != $('#rnpassword').val()){
				swal("Oops", "Password not matched!");
				return false;
			}
		}
		var formData = new FormData(this);
  	console.log("formatsdta ::::: ", formData);
  	$.ajax({
		url: '<?php echo SITE_URL;?>/v1/services/index.php?service=updatemydata',
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
				  window.location = '<?php echo SITE_URL;?>/profile';
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


<!-- Google Autocomplete -->
<script>
	Nationality = '';
	function initAutocomplete() {
		 var options = {
		  types: ['(cities)'],
		  // componentRestrictions: {country: "us"}
		 };

		 var input = document.getElementById('autocomplete-input');
		 var autocomplete = new google.maps.places.Autocomplete(input, options);
	}

	// Autocomplete adjustment for homepage
	if ($('.intro-banner-search-form')[0]) {
	    setTimeout(function(){ 
	        $(".pac-container").prependTo(".intro-search-field.with-autocomplete");
	    }, 300);
	}
	$.ajax({
		url: '<?php echo SITE_URL;?>/v1/services/index.php?service=getProfile',
		type: 'GET',
		success: function(results){
			var results = JSON.parse(results);
			console.log("results ::::: ", results);
			if(results['data'][0]['profile']){
				$('.profile-pic').attr('src', 'images/upload/'+results['data'][0]['profile']);
			}
		},
		error: function(err){
			console.log("err :::::: ",err);
		}
	})
	$.ajax({
		url: '<?php echo SITE_URL;?>/v1/services/index.php?service=country',
		type: 'GET',
		success: function(results){
			var results = JSON.parse(results);
			
			var output = ['<option value="">Select Nationality</option>'];
			console.log("Nationality :::: ", Nationality);
			for (var i = 0; i < results.length; i++) {
				if(Nationality != null && Nationality == results[i]['id']){
					output.push('<option value="'+ results[i]['id'] +'" selected>'+ results[i]['name'] +'</option>');
				}else{
					output.push('<option value="'+ results[i]['id'] +'">'+ results[i]['name'] +'</option>');
				}
			}

			$('#country').html(output.join(''));
		},
		error: function(err){
			console.log("err :::::: ",err);
		}
	})
</script>

<!-- Google API -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAgeuuDfRlweIs7D6uo4wdIHVvJ0LonQ6g&libraries=places&callback=initAutocomplete"></script>

</body>
</html>
