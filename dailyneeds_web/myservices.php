<?php include('myserviceData.php'); 
// echo '<pre>';
// print_r($nquery);
// echo '</pre>';
// die;
?>
<!doctype html>
<html lang="en">
<head>

<!-- Basic Page Needs
================================================== -->
<title>DailyNeeds | MyServices</title>
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
				<div class="section-headline centered margin-top-45 margin-bottom-30">
					<h3><strong>My Services</strong></h3>
				</div>
			</div>
		<div class="col-xl-12 col-md-12">
			
			
			<div class="listings-container grid-layout margin-top-35">
				
				<?php
				if($count){

					while($crow = mysqli_fetch_array($nquery)){

						$cid = mysqli_real_escape_string($db, $crow['city']);
						$sql = "SELECT name FROM city WHERE id = '$cid'";
						$result = mysqli_query($db, $sql);
						$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
				?>	
				<!-- Job Listing -->
				<a href="<?php echo SITE_URL;?>/addservices?sid=<?php echo $crow['id']?>" class="job-listing">

					<div class="row">
						<!-- Job Listing Details -->
						<div class="job-listing-details">
							<!-- Logo -->
							<div class="col-md-4">
								<div class="header-image freelancer-avatar">
									<img class="img-responsive" src="images/services/<?php echo $crow['image']?>" alt="" style="border-radius: 10px;">
								</div>
							</div>
							<div class="col-md-8">
								<!-- Details -->
								<div class="job-listing-description">
									<h3 class="job-listing-company"><?php echo $crow['title']?></h3>
									<h4 class="job-listing-title"><?php echo $crow['description'];?></h4>
								</div>
							</div>
						</div>
					</div>

					<!-- Job Listing Footer -->
					<div class="job-listing-footer">
						<ul>
							<li><i class="icon-material-outline-location-on"></i> <?php echo $row['name']?></li>
							<li><i class="icon-material-outline-account-balance-wallet"></i> $<?php echo $crow['price']?></li>
						</ul>
					</div>
				</a>

				<?php
					}
				}else{
				?>
					<!-- Job Listing Details -->
					
					<div class="listings-container grid-layout">
						<div class="job-listing-description" style="margin:0 auto">
							<center><h3 class="job-listing-title">No Results Found !</h3></center>
						</div>
					</div>
					
				
				<?php }?>	

			</div>
			<!-- Pagination -->
			<div class="clearfix"></div>
			<div class="row">
				<div class="col-md-12">
					<!-- Pagination -->
					<div class="pagination-container margin-top-30 margin-bottom-60">
						<nav class="pagination">
							<?php echo $paginationCtrls; ?>
						</nav>
					</div>
				</div>
			</div>
			<!-- Pagination / End -->
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

	// Autocomplete adjustment for homepage
	if ($('.intro-banner-search-form')[0]) {
	    setTimeout(function(){ 
	        $(".pac-container").prependTo(".intro-search-field.with-autocomplete");
	    }, 300);
	}

</script>

<!-- Google API -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAgeuuDfRlweIs7D6uo4wdIHVvJ0LonQ6g&libraries=places&callback=initAutocomplete"></script>

</body>
</html>