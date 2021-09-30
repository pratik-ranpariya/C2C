<?php include('sellerrequestData.php'); ?>
<!doctype html>
<html lang="en">
<head>

<!-- Basic Page Needs
================================================== -->
<title>DailyNeeds | Seller Requests</title>
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
  min-height: 1100px !important;
 }
 .dashboard-content-inner{
  min-height: 1100px !important;
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
				<center><h3><strong>Seller Requests : DailyNeeds</strong></h3></center>
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
											?>
										
											<li id="offer_<?php echo $value['id'];?>">
												<!-- Overview -->
												<div class="freelancer-overview manage-candidates">
													<div class="freelancer-overview-inner">

														<!-- Avatar -->
														<div class="freelancer-avatar">
															<a href="javascript:;"><img src="images/upload/<?php echo $value['sellerProfile'];?>" alt="" class="sellerprofile"></a>
														</div>

														<!-- Name -->
														<div class="freelancer-name">
															<h4><a href="javascript:;"><?php echo $value['category'].' '.$value['scategory'];?> <img class="flag" src="images/flags/de.svg" alt="" title="Germany" data-tippy-placement="top"></a></h4>

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
																<a href="#small-dialog-2" class="popup-with-zoom-anim button ripple-effect" onclick="acceptOfferData('<?php echo $value['posterid']?>', '<?php echo $value['username']?>', '<?php echo $value['offerid']?>', '<?php echo $value['userid']?>','<?php echo $value['budget']?>');"><i class="icon-material-outline-check"></i> Accept Offer</a>
																
																<a href="javascript:;" class="button gray ripple-effect ico removeRuquest" title="Remove" data-tippy-placement="top" data-index="<?php echo $value['posterid'];?>" data-userid="<?php echo $value['userid']?>" data-offerid="<?php echo $value['offerid']?>" ><i class="icon-feather-trash-2"></i></a>
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
					
					<input type="text" name="postrequestid" value="<?php echo $_GET['postrequest'];?>" id="postrequestid" required hidden>
					<input type="text" name="offerid" value="" id="offerid" required hidden>
					<input type="text" name="sellerid" value="" id="sellerid" required hidden>
					
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
	function acceptOfferData(buyerid, sellername, offerid, sellerid, budget){
		$('#offerid').val(offerid);
		$('#sellerid').val(sellerid);
		$('#offermsg').text('Accept Offer From '+sellername);
		
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
		var userid = $(this).attr("data-userid");
		var offerid = $(this).attr("data-offerid");
		var data = {buyerid: indexvalue, offerid: offerid, userid: userid};
		console.log("data :::::: ", data);
		$.ajax({
			url: '<?php echo SITE_URL;?>/v1/services/service.php?service=revokeSellerFromOffer',
			type: 'POST',
			data: data,
            success: function(results){
				console.log("results :::::: ", results);
				results = JSON.parse(results);
				if(results['error'] == 'Y'){
					$('#addmsg').text(results['msg']);
			  	}else{
			  		$('#addmsg').text(results['msg']);
			  	}

			  	$('.openBOx').trigger('click');
				setTimeout(function(){
					$('.mfp-close').trigger('click');
					location.reload();
					// window.location = '<?php echo SITE_URL;?>/manage_requests';
				},1000);
			},
			error: function(err){
				console.log("err :::::: ",err);
			}
		})
	})
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






</script>

<!-- Google API -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAgeuuDfRlweIs7D6uo4wdIHVvJ0LonQ6g&libraries=places&callback=initAutocomplete"></script>

</body>
</html>