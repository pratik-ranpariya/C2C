<?php
	include("v1/config.php");
	if(!isset($_SESSION)) 
	{ 
	    session_start(); 
	} 
	if(isset($_GET['sid'])){

		$cid = mysqli_real_escape_string($db, $_GET['sid']);
		$sql = "SELECT * FROM user_services WHERE id = '$cid'";
		$result = mysqli_query($db, $sql);
		$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
	}

	$sql = "SELECT * FROM city";
	$result = mysqli_query($db, $sql);
	$citydata = mysqli_fetch_all($result, MYSQLI_ASSOC);

	$userid = mysqli_real_escape_string($db, $_SESSION['id']);

	// $sql = "SELECT postrequest.id, postrequest.description,postrequest.time,postrequest.type,postrequest.budget,postrequest.posterid, categories.name as category, subcategories.name as scategory,register.profile,register.username, user_services.id as serviceid from postrequest, categories, subcategories, register,user_services,sendoffer where 
	// 	postrequest.category = categories.id 
	// and postrequest.scategory = subcategories.id 
	// and postrequest.posterid = register.id 
	// and postrequest.posterid <> '$userid' 
	// and postrequest.revoke='N' 
	// and user_services.userid = '$userid' 
	// and user_services.category = postrequest.category 
	// and user_services.scategory = postrequest.scategory 
	// GROUP BY id";

	$sql = "SELECT postrequest.id, postrequest.description, postrequest.time, postrequest.type, postrequest.budget, postrequest.posterid,user_services.id as serviceid,register.profile,register.username,categories.name as category, subcategories.name as scategory
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
	$requests = mysqli_fetch_all($result,MYSQLI_ASSOC);
	$temp = array();
	foreach ($requests as $value) {
		$postrequestid = mysqli_real_escape_string($db, $value['id']);
		$sql = "SELECT count(*) as total FROM sendoffer WHERE userid='$userid' and postrequestid='$postrequestid'";
		$result = mysqli_query($db, $sql);
		if(mysqli_fetch_array($result,MYSQLI_ASSOC)['total'] == 0){
			array_push($temp, $value);
		}
	}
	$requests = $temp;
	$requestscount = count($requests);
?>
<!doctype html>
<html lang="en">
<head>

<!-- Basic Page Needs
================================================== -->
<title>DailyNeeds | Add Service</title>
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
				<center><h3><strong>Buyer Requests : DailyNeeds</strong></h3></center>
			</div>
	
			<!-- Row -->
			<div class="row">

				<!-- Dashboard Box -->
				<div class="col-xl-8 offset-xl-2">
					<div class="dashboard-box margin-top-0">

						<!-- Headline -->
						<div class="headline">
							<h3><i class="icon-material-outline-supervisor-account"></i> <?php echo $requestscount;?> Offer</h3>
						</div>

						<div class="content">
							<ul class="dashboard-box-list">
								<?php 
									if($requestscount){
										foreach ($requests as $key => $value) { 

											if($value['type'] == 'h'){
												$type = 'Hours';
											}else if($value['type'] == 'd'){
												$type = 'Days';
											}else if($value['type'] == 'm'){
												$type = 'Months';
											}else{
												$type = '';
											}
											?>
										
											<li id="offer_<?php echo $value['id'];?>">
												<!-- Overview -->
												<div class="freelancer-overview manage-candidates">
													<div class="freelancer-overview-inner">

														<!-- Avatar -->
														<div class="freelancer-avatar">
															<a href="#"><img class="sellerprofile" src="images/upload/<?php echo $value['profile'];?>" alt=""></a>
														</div>

														<!-- Name -->
														<div class="freelancer-name">
															<h4><?php echo $value['category'].' '.$value['scategory'];?></h4>

															<!-- Details -->
															<span class="freelancer-detail-item">
																	<div class="col-xl-8">
																		<?php echo $value['description'];?>
																	</div>
																</span>
															<!-- Bid Details -->
															<ul class="dashboard-task-info bid-info">
																<li><strong>$<?php echo $value['budget'];?></strong><span>Budget</span></li>
																<li><strong><?php echo $value['time'].' '.$type;?> </strong><span>Delivery Time</span></li>
															</ul>

															<!-- Buttons -->
															<div class="buttons-to-right always-visible margin-top-25 margin-bottom-0">
																<a href="#small-dialog-2" class="popup-with-zoom-anim button ripple-effect" onclick="setOfferData('<?php echo $_SESSION['id'];?>', '<?php echo $value['serviceid']?>', '<?php echo $value['id']?>');"><i class="icon-feather-mail"></i> Send Offer</a>
															</div>
														</div>
													</div>
												</div>
											</li>

									<?php }
									}else{?>
										<li>
											<div class="job-listing">
												<div class="job-listing-details">
													 No Result Found!
												</div>
											</div>
										</li>
								<?php }?>
							</ul>
						</div>
					</div>
				</div>

			</div>
			<!-- Row / End -->

		<br><br>

		</div>
	</div>
	<!-- Dashboard Content / End -->

<?php include("views/footer.php");?>

</div>
<!-- Wrapper / End -->

<!-- Send Direct Message Popup
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
					<h3>Send Offer</h3>
				</div>
					
				<!-- Form -->
				<form method="post" id="submit-offer-form">
					<input type="text" name="userid" value="" id="sendofferuserid" hidden>
					<input type="text" name="serviceid" value="" id="serviceid" hidden>
					<input type="text" name="postrequestid" value="" id="postrequestid" hidden>
					<div class="submit-field">
						<h5>Budget</h5>
						<input type="number" name="budget" placeholder="Enter Budget" value="" id="budget" required>
					</div>
					<div class="submit-field">
						<h5>Time</h5>
						<input type="number" name="time" placeholder="Enter Delivery Time" value="" id="time" required>
					</div>
					<div class="submit-field">
						<h5>Select Time Type</h5>
						<select  data-size="7" title="Select Category" name="type" style="padding-bottom: 0px;padding-top: 0px;" required>
							<option>Select Time Type</option>
							<option value="h">Hour's</option>
							<option value="d">Days</option>
							<option value="m">Month</option>
						</select>
					</div>
					<textarea name="comments" cols="10" placeholder="Description" class="with-border" required></textarea>
				</form>
				
				<!-- Button -->
				<button class="button full-width button-sliding-icon ripple-effect" type="submit" form="submit-offer-form">Send <i class="icon-material-outline-arrow-right-alt"></i></button>

			</div>

		</div>
	</div>
</div>
<!-- Send Direct Message Popup / End -->
<a href="#small-dialog-1" class="popup-with-zoom-anim button dark ripple-effect openBOx" hidden></a>
<!-- Bid Acceptance Popup
================================================== -->
<div id="small-dialog-1" class="zoom-anim-dialog mfp-hide dialog-with-tabs">
	<!--Tabs -->
	<div class="sign-in-form">

		<div class="popup-tabs-container">
			<!-- Welcome Text -->
			<div class="welcome-text margin-top-50">
				<h3 id="addmsg">Service Successfully Added !</h3>
			</div>
				
			<!-- Button -->
			<button class="button full-width button-sliding-icon ripple-effect buttonClick" >Done <i class="icon-material-outline-arrow-right-alt"></i></button>
		</div>
	</div>
</div>
<!-- Bid Acceptance Popup / End -->


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

<!-- Snackbar // documentation: https://www.polonel.com/snackbar/ -->
<script>
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

	function setOfferData(userid, serviceid, postrequestid){
		$('#sendofferuserid').val(userid);
		$('#serviceid').val(serviceid);
		$('#postrequestid').val(postrequestid);
	}
	function initAutocomplete() {
		 var options = {
		  types: ['(cities)'],
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
	
	$( "#submit-offer-form" ).submit(function( event ) {
	  	event.preventDefault();
	  	var offerid = $('#postrequestid').val();
	  	console.log("offerid ::::::: ", offerid);
	  	var formData = new FormData(this);
	  	console.log("formatsdta ::::: ", formData);
	  	$.ajax({
			url: '<?php echo SITE_URL;?>/v1/services/service.php?service=sendOffer',
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
			  	}

			  	$('#submit-offer-form')[0].reset();
			  	$('.openBOx').trigger('click');
				setTimeout(function(){
					$('.mfp-close').trigger('click');
					window.location = '<?php echo SITE_URL;?>/buyerrequest';
				},1000);
			},
			error: function(err){
				console.log("err :::::: ",err);
			}
		})
	});






</script>

<!-- Google API -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAgeuuDfRlweIs7D6uo4wdIHVvJ0LonQ6g&libraries=places&callback=initAutocomplete"></script>

</body>
</html>