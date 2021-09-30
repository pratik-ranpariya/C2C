

<?php include("manage_requestsData.php");?>
<!doctype html>
<html lang="en">
<head>

<!-- Basic Page Needs
================================================== -->
<title>DailyNeeds | Post Requests</title>
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
				<center><h3><strong>Manage Post Requests : DailyNeeds</strong></h3></center>
			</div>
	
			<!-- Row -->
			<div class="row">

				<!-- Dashboard Box -->
				<div class="col-xl-8 offset-xl-2">
					<div class="dashboard-box margin-top-0">

						<!-- Headline -->
						<div class="headline">
							<h3><i class="icon-material-outline-supervisor-account"></i> <?php echo $requestscount;?> Requests</h3>
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
										$postrequestid = mysqli_real_escape_string($db, $value['id']);
										$sql = "SELECT sendoffer.id FROM sendoffer, orders WHERE postrequestid='$postrequestid' and `revoke`='N' and orders.offerid<>sendoffer.id GROUP BY sendoffer.id;";
										$result = mysqli_query($db, $sql);
										$totalSellers = mysqli_fetch_all($result,MYSQLI_ASSOC);

										?>
										
										<li>
											<div class="job-listing">
												<div class="job-listing-details">
													<div class="job-listing-description">
														<h3 class="job-listing-title"><a href="javascript:;"><?php echo $value['category'].' '.$value['scategory'];?></a></h3>
														<div class="job-listing-footer">
															<ul>
																<li><i class="icon-material-outline-date-range"></i> <strong>$<?php echo $value['budget'];?></strong><span> Budget</span></li>
																<li><i class="icon-material-outline-date-range"></i><strong><?php echo $value['time'].' '.$type;?> </strong><span>Delivery Time</span></li>
																<li><i class="icon-material-outline-date-range"></i> Posted on <?php echo date_format(date_create($value['date']), 'd M, Y');?></li>
															</ul>
														</div>
														<br>
														<span class="freelancer-detail-item">
															<div class="">
																<?php echo $value['description'];?>
															</div>
														</span>
													</div>
												</div>
											</div>
											<div class="buttons-to-right always-visible">
												<a href="<?php echo SITE_URL.'/sellerrequest?postrequest='.$value['id']?>" class="button ripple-effect"><i class="icon-material-outline-supervisor-account"></i> Manage Sellers <span class="button-info"><?php echo count($totalSellers);?></span></a>
												
												<a href="javascript:;" class="button gray ripple-effect ico removeRuquest" title="Remove" data-tippy-placement="top" data-index="<?php echo $value['posterid'];?>" data-postrequestid="<?php echo $value['id'];?>" ><i class="icon-feather-trash-2"></i></a>
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
	
	<div class="sign-in-form">
		<ul class="popup-tabs-nav">
			<li><a href="#tab1">Accept Offer</a></li>
		</ul>
		<div class="popup-tabs-container">

			<!-- Tab -->
			<div class="popup-tab-content" id="tab">
				
				<!-- Welcome Text -->
				<div class="welcome-text">
					<h3 id="offermsg">Accept Offer From David</h3>
					<div class="bid-acceptance margin-top-15" id="offerbudget">
					</div>
				</div>

						
				<form id="terms">
					
					<input type="text" name="budget" value="" id="acceptofferbudget" required>
					<input type="text" name="buyerid" value="" id="offerbuyerid" required>
					<input type="text" name="serviceid" value="" id="offerserviceid" required>
					<input type="text" name="sellerid" value="" id="offersellerid" required>
					
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
<a href="#small-dialog-1" class="popup-with-zoom-anim button dark ripple-effect openBOx" hidden></a>
<!-- Send Direct Message Popup
================================================== -->
<div id="small-dialog-1" class="zoom-anim-dialog mfp-hide dialog-with-tabs">

	<!--Tabs -->
	<div class="sign-in-form">

		<div class="popup-tabs-container">
			<!-- Welcome Text -->
			<div class="welcome-text margin-top-50">
				<h3 id="addmsg">Revoke Successfully</h3>
			</div>
				
			<!-- Button -->
			<button class="button full-width button-sliding-icon ripple-effect buttonClick" >Done <i class="icon-material-outline-arrow-right-alt"></i></button>
		</div>
	</div>
</div>
<!-- Send Direct Message Popup / End -->
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
	function acceptOfferData(buyerid, serviceid, postrequestid, sellername, budget){
		$('#offerbuyerid').val(buyerid);
		$('#offerserviceid').val(serviceid);
		$('#offersellerid').val(postrequestid);
		$('#offermsg').text('Accept Offer From '+sellername);
		
		$('#acceptofferbudget').val(budget);
		$('#offerbudget').html('$'+budget);
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
	$('.removeRuquest').click(function(event){
		var indexvalue = $(this).attr("data-index"); 
		var postrequestid = $(this).attr("data-postrequestid");
		var data = {buyerid: indexvalue, postrequestid: postrequestid};
		console.log("data :::::: ", data);
		$.ajax({
			url: '<?php echo SITE_URL;?>/v1/services/service.php?service=revokeOffer',
			type: 'POST',
			data: data,
            success: function(results){
				console.log("results :::::: ", results);
				results = JSON.parse(results);
				if(results['error'] == 'Y'){
					$('addmsg').text(results['msg']);
			  	}else{
			  		$('addmsg').text(results['msg']);
			  	}

			  	$('.openBOx').trigger('click');
				setTimeout(function(){
					$('.mfp-close').trigger('click');
					window.location = '<?php echo SITE_URL;?>/manage_requests';
				},1000);
			},
			error: function(err){
				console.log("err :::::: ",err);
			}
		})
	})
	
</script>

<!-- Google API -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAgeuuDfRlweIs7D6uo4wdIHVvJ0LonQ6g&libraries=places&callback=initAutocomplete"></script>

</body>
</html>