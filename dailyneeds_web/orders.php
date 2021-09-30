<?php include('orderData.php'); 
// echo '<pre>';
// print_r($orderData);
// echo '</pre>';
// die;
?>
<!doctype html>
<html lang="en">
<head>

<!-- Basic Page Needs
================================================== -->
<title>DailyNeeds | Jobs</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

<!-- CSS
================================================== -->
<link rel="stylesheet" href="css/style.css?v=2">
<link rel="stylesheet" href="css/colors/blue.css?v=2">
<style type="text/css">
	div.tabs-header .active{
		background-color: #888 !important;
	}
	div.tabs-header li{
		padding: 0px 20px!important
	}
	div.tabs-header a{
		font-size: 22px !important;
		font-weight: 700 !important;
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
	.section-headline.border-top{
		border-top: none !important;
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


<!-- Container -->
<div class="container">
		<div class="row">
		
		<div class="col-xl-12 col-md-12">
			<div class="dashboard-headline margin-top-45">
				<center><h3><strong>My Jobs : DailyNeeds</strong></h3></center>
			</div>
			
			<!-- Tabs Container -->
			<div class="tabs">
				<div class="tabs-header">
					<ul style="width: auto !important;flex-wrap: nowrap !important;">
						<li class="active"><a href="#tab-1" data-tab-id="1">New</a></li>
						<li><a href="#tab-2" data-tab-id="2">Active</a></li>
						<li><a href="#tab-3" data-tab-id="3">Delivered</a></li>
						<li><a href="#tab-4" data-tab-id="4">Completed</a></li>
						<li><a href="#tab-5" data-tab-id="5">Cancelled</a></li>
					</ul>
					<div class="tab-hover"></div>
					<nav class="tabs-nav">
						<span class="tab-prev"><i class="icon-material-outline-keyboard-arrow-left"></i></span>
						<span class="tab-next"><i class="icon-material-outline-keyboard-arrow-right"></i></span>
					</nav>
				</div>
				<!-- Tab Content -->
				<div class="tabs-content">
					<div class="tab active" data-tab-id="1">
						<div class="col-xl-12">
							<div class="dashboard-box margin-top-0">
								<div class="content">
									<ul class="dashboard-box-list">
										<?php if(count($orderInfo['new'])){?>
										<?php 
										foreach ($orderInfo['new'] as $key => $value) {
											?>
										<li>
											<!-- Job Listing -->
											<div class="job-listing col-xl-8">

												<!-- Job Listing Details -->
												<div class="job-listing-details">

													<!-- Details -->
													<div class="job-listing-description">
														<h3 class="job-listing-title"><a href="<?php echo '/order?cc='.base64_encode($value['id']);?>"><?php echo $value['title'];?></a></h3>

														<!-- Job Listing Footer -->
														<div class="job-listing-footer">
															<ul>
																<li><i class="icon-material-outline-date-range"></i> Posted on <?php echo $value['date'];?></li>
																<li><i class="icon-material-outline-date-range"></i> Expiring on <?php echo $value['delivery_date'];?></li>
															</ul>
														</div>
													</div>
												</div>
											</div>
										</li>
										<?php }
										?>
										<?php }else{?>
											<li>
												<!-- Job Listing -->
												<div class="job-listing col-xl-12">
													<!-- Job Listing Details -->
													<div class="job-listing-details">
														<!-- Details -->
														<div class="job-listing-description">
															<center><h3 class="job-listing-title"><a href="#">No Orders Available </a></h3></center>
														</div>
													</div>
												</div>
											</li>	
										<?php }?>
									</ul>
								</div>
							</div>
						</div>
					</div>
					<div class="tab" data-tab-id="2">
						<div class="col-xl-12">
							<div class="dashboard-box margin-top-0">
								<div class="content">
									<ul class="dashboard-box-list">
										<?php if(count($orderInfo['active'])){?>
											<?php 
											foreach ($orderInfo['active'] as $key => $value) {
												?>
											<li>
												<!-- Job Listing -->
												<div class="job-listing col-xl-8">

													<!-- Job Listing Details -->
													<div class="job-listing-details">

														<!-- Details -->
														<div class="job-listing-description">
															<h3 class="job-listing-title"><a href="<?php echo SITE_URL.'/order?cc='.base64_encode($value['id']);?>"><?php echo $value['title'];?></a></h3>

															<!-- Job Listing Footer -->
															<div class="job-listing-footer">
																<ul>
																	<li><i class="icon-material-outline-date-range"></i> Posted on <?php echo $value['date'];?></li>
																	<li><i class="icon-material-outline-date-range"></i> Expiring on <?php echo $value['delivery_date'];?></li>
																</ul>
															</div>
														</div>
													</div>
												</div>
											</li>
											<?php }
											?>
										<?php }else{?>
											<li>
												<!-- Job Listing -->
												<div class="job-listing col-xl-12">
													<!-- Job Listing Details -->
													<div class="job-listing-details">
														<!-- Details -->
														<div class="job-listing-description">
															<center><h3 class="job-listing-title"><a href="#">No Orders Available </a></h3></center>
														</div>
													</div>
												</div>
											</li>	
										<?php }?>
									</ul>
								</div>
							</div>
						</div>
					</div>
					<div class="tab" data-tab-id="3">
						<div class="col-xl-12">
							<div class="dashboard-box margin-top-0">
								<div class="content">
									<ul class="dashboard-box-list">
										<?php if(count($orderInfo['delivered'])){?>
											<?php 
											foreach ($orderInfo['delivered'] as $key => $value) {
												?>
											<li>
												<!-- Job Listing -->
												<div class="job-listing col-xl-8">

													<!-- Job Listing Details -->
													<div class="job-listing-details">

														<!-- Details -->
														<div class="job-listing-description">
															<h3 class="job-listing-title"><a href="<?php echo SITE_URL.'/order?cc='.base64_encode($value['id']);?>"><?php echo $value['title'];?></a></h3>

															<!-- Job Listing Footer -->
															<div class="job-listing-footer">
																<ul>
																	<li><i class="icon-material-outline-date-range"></i> Posted on <?php echo $value['date'];?></li>
																	<li><i class="icon-material-outline-date-range"></i> Expiring on <?php echo $value['delivery_date'];?></li>
																</ul>
															</div>
														</div>
													</div>
												</div>
											</li>
											<?php }
											?>
										<?php }else{?>
												<li>
													<!-- Job Listing -->
													<div class="job-listing col-xl-12">
														<!-- Job Listing Details -->
														<div class="job-listing-details">
															<!-- Details -->
															<div class="job-listing-description">
																<center><h3 class="job-listing-title"><a href="#">No Orders Available </a></h3></center>
															</div>
														</div>
													</div>
												</li>	
										<?php }?>
									</ul>
								</div>
							</div>
						</div>
					</div>
					<div class="tab" data-tab-id="4">
						<div class="col-xl-12">
							<div class="dashboard-box margin-top-0">
								<div class="content">
									<ul class="dashboard-box-list">
										<?php if(count($orderInfo['completed'])){?>
										<?php 
										foreach ($orderInfo['completed'] as $key => $value) {
											?>
										<li>
											<!-- Job Listing -->
											<div class="job-listing col-xl-8">

												<!-- Job Listing Details -->
												<div class="job-listing-details">

													<!-- Details -->
													<div class="job-listing-description">
														<h3 class="job-listing-title"><a href="<?php echo SITE_URL.'/order?cc='.base64_encode($value['id']);?>"><?php echo $value['title'];?></a></h3>

														<!-- Job Listing Footer -->
														<div class="job-listing-footer">
															<ul>
																<li><i class="icon-material-outline-date-range"></i> Posted on <?php echo $value['date'];?></li>
																<li><i class="icon-material-outline-date-range"></i> Expiring on <?php echo $value['delivery_date'];?></li>
															</ul>
														</div>
													</div>
												</div>
											</div>
										</li>
										<?php }
										?>
										<?php }else{?>
												<li>
													<!-- Job Listing -->
													<div class="job-listing col-xl-12">
														<!-- Job Listing Details -->
														<div class="job-listing-details">
															<!-- Details -->
															<div class="job-listing-description">
																<center><h3 class="job-listing-title"><a href="#">No Orders Available </a></h3></center>
															</div>
														</div>
													</div>
												</li>	
										<?php }?>
									</ul>
								</div>
							</div>
						</div>
					</div>
					<div class="tab" data-tab-id="5">
						<div class="col-xl-12">
							<div class="dashboard-box margin-top-0">
								<div class="content">
									<ul class="dashboard-box-list">
										<?php if(count($orderInfo['cancelled'])){?>
										<?php 
										foreach ($orderInfo['cancelled'] as $key => $value) {
											?>
										<li>
											<!-- Job Listing -->
											<div class="job-listing col-xl-8">

												<!-- Job Listing Details -->
												<div class="job-listing-details">

													<!-- Details -->
													<div class="job-listing-description">
														<h3 class="job-listing-title"><a href="javascript:;"><?php echo $value['title'];?></a></h3>

														<!-- Job Listing Footer -->
														<div class="job-listing-footer">
															<ul>
																<li><i class="icon-material-outline-date-range"></i> Posted on <?php echo $value['date'];?></li>
																<li><i class="icon-material-outline-date-range"></i> Expiring on <?php echo $value['delivery_date'];?></li>
															</ul>
														</div>
													</div>
												</div>
											</div>
										</li>
										<?php }
										?>
										<?php }else{?>
												<li>
													<!-- Job Listing -->
													<div class="job-listing col-xl-12">
														<!-- Job Listing Details -->
														<div class="job-listing-details">
															<!-- Details -->
															<div class="job-listing-description">
																<center><h3 class="job-listing-title"><a href="#">No Orders Available </a></h3></center>
															</div>
														</div>
													</div>
												</li>	
										<?php }?>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- Tabs Container / End -->
		</div>

	</div>
<br><br><br><br>
</div>
<!-- Container / End -->
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
	function initAutocomplete() {
		 var options = {
		  types: ['(cities)'],
		  // componentRestrictions: {country: "us"}
		 };

		 var input = document.getElementById('autocomplete-input');
		 var autocomplete = new google.maps.places.Autocomplete(input, options);
	}
</script>


</body>
</html>