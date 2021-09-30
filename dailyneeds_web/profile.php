<?php include('profileData.php'); 
?>
<!doctype html>
<html lang="en">
<head>

<!-- Basic Page Needs
================================================== -->
<title>DailyNeeds | Profile</title>
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
<?php include("views/session.php");?>
<div class="clearfix"></div>
<!-- Header Container / End -->


<!-- Titlebar
================================================== -->
<div class="single-page-header freelancer-header" data-background-image="images/home-background.jpg">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="single-page-header-inner">
					<div class="left-side">
						<div class="header-image freelancer-avatar"><img src="<?php echo ($data['profile']) ? 'images/upload/'.$data['profile'] : 'images/user-avatar-placeholder.png';?>" alt="" class="usernamePic"></div>
						<div class="header-details">
							<h3 class="usernameh3"> <?php echo $data['username'];?> <span> <?php echo $data['tagline'];?> </span></h3>
							<ul>
								<li><?php echo $data['work'];?> Works</li>
								<li>
									<a href="<?php echo SITE_URL;?>/myprofile" class="awheader apply-now-button">Edit Profile</a>
								</li>
								<li>
									<a href="<?php echo SITE_URL;?>/emailverification" class="awheader apply-now-button">Verify Email</a>
								</li>
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
			
			<!-- Page Content -->
			<div class="single-page-section">
				<h3 class="margin-bottom-25">About Me</h3>
				<p><?php echo $data['description'];?></p>
			</div>

			<!-- Boxed List -->
			<div class="boxed-list margin-bottom-60">
				<div class="boxed-list-headline">
					<h3><i class="icon-material-outline-thumb-up"></i> Work History and Feedback</h3>
				</div>
				<ul class="boxed-list-ul">
					
					<?php
						if($count){

							foreach ($nquery as $key => $value) {
							
						?>	
							
							<li>
								<div class="boxed-list-item">
									<!-- Content -->
									<div class="item-image">
										<img src="<?php echo $value['buyer_profile'];?>" alt="">
									</div>
									<div class="item-content">
										<h3><?php echo $value['service_title'];?></h3>
										<h5><?php echo $value['service_title'];?>,<?php echo $value['subcategory'];?><span><?php echo $value['buyer_name'];?></span></h5>
										<div class="item-details margin-top-10">
											<div class="star-rating" data-rating="<?php echo $value['rate'];?>"></div>
											<div class="detail-item"><i class="icon-material-outline-date-range"></i><?php echo date_format($value['date'],"d M y");?></div>
										</div>
										<div class="item-description">
											<p><?php echo $value['text'];?></p>
										</div>
									</div>
								</div>
							</li>
						<?php }
					}else{?>
							<li>
								<div class="boxed-list-item">
									<!-- Content -->
									No Feedback Found!
								</div>
							</li>
					<?php }?>
				</ul>

				<!-- Pagination -->
				<div class="clearfix"></div>
				<div class="pagination-container margin-top-40 margin-bottom-10">
					<nav class="pagination">
						<?php echo $paginationCtrls; ?>
					</nav>
				</div>
				<div class="clearfix"></div>
				<!-- Pagination / End -->

			</div>
			<!-- Boxed List / End -->

		</div>
		

		<!-- Sidebar -->
		<div class="col-xl-4 col-lg-4">
			<div class="sidebar-container">
				
				<!-- Profile Overview -->
				<div class="profile-overview">
					<div class="overview-item"><strong>$<?php echo $data['earnings']['balance'];?></strong><span>Balance</span></div>
					<div class="overview-item"><strong>$<?php echo $data['earnings']['balance_in_month'];?></strong><span>One Month Balance</span></div>
					<div class="overview-item"><strong>$<?php echo $data['earnings']['selling_price'];?></strong><span>Selling Price</span></div>
					<div class="overview-item"><strong><?php echo $data['earnings']['active_orders'];?></strong><span>Active Orders</span></div>
					<div class="overview-item"><strong>$<?php echo $data['earnings']['pending_clearance'];?></strong><span>Pending Clearance</span></div>
					<div class="overview-item"><strong><?php echo $data['earnings']['cancelled_orders'];?></strong><span>Cancelled Orders</span></div>
				</div>

				<!-- Button -->
				<a href="orderrequest.php" class="apply-now-button ">Make an Offer <i class="icon-material-outline-arrow-right-alt"></i></a>

				<!-- Freelancer Indicators -->
				<div class="sidebar-widget">
					<div class="freelancer-indicators">

						<!-- Indicator -->
						<div class="indicator">
							<strong><?php echo $data['maintains']['response_time_rate'];?>%</strong>
							<div class="indicator-bar" data-indicator-percentage="<?php echo $data['maintains']['response_time_rate'];?>"><span></span></div>
							<span>Response Time</span>
						</div>

						<!-- Indicator -->
						<div class="indicator">
							<strong><?php echo $data['maintains']['order_completion'];?>%</strong>
							<div class="indicator-bar" data-indicator-percentage="<?php echo $data['maintains']['order_completion'];?>"><span></span></div>
							<span>Order Completion</span>
						</div>
						
						<!-- Indicator -->
						<div class="indicator">
							<strong><?php echo $data['maintains']['on_time_delivery'];?>%</strong>
							<div class="indicator-bar" data-indicator-percentage="<?php echo $data['maintains']['on_time_delivery'];?>"><span></span></div>
							<span>On Time Delivery</span>
						</div>	
											
						<!-- Indicator -->
						<div class="indicator">
							<strong><?php echo $data['maintains']['positive_rate'];?>%</strong>
							<div class="indicator-bar" data-indicator-percentage="<?php echo $data['maintains']['positive_rate'];?>"><span></span></div>
							<span>Positive Rating</span>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>
</div>


<!-- Spacer -->
<div class="margin-top-15"></div>

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

$(function(){
	var myProfile = $('.myprofile').attr('src');
	$('.usernamePic').attr('src', myProfile);
})
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

	// Autocomplete adjustment for homepage
	if ($('.intro-banner-search-form')[0]) {
	    setTimeout(function(){ 
	        $(".pac-container").prependTo(".intro-search-field.with-autocomplete");
	    }, 300);
	}

	/*$.ajax({
		url: '<?php echo SITE_URL;?>/v1/services/index.php?service=getProfile',
		type: 'GET',
		success: function(results){
			console.log("results ::::::: ", results);
			var results = JSON.parse(results);
			$('.usernameh3').html(results.data[0]['username']+'<span>'+results.data[0]['tagline']+'</span>');
			$(".usernamePic").attr("src","images/upload/"+results.data[0]['profile']);
		},
		error: function(err){
			console.log("err :::::: ",err);
		}
	})*/

</script>

<!-- Google API -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAgeuuDfRlweIs7D6uo4wdIHVvJ0LonQ6g&libraries=places&callback=initAutocomplete"></script>

</body>
</html>