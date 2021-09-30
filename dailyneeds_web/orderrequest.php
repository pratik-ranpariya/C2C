<?
if(!isset($_SESSION)) 
{ 
    session_start(); 
} 

if(!isset($_SESSION['id'])){
	session_start();
	session_destroy();
	header('Location: http://dailyneeds.co.nz');
}

?>
<!doctype html>
<html lang="en">
<head>

<!-- Basic Page Needs
================================================== -->
<title>DailyNeeds | Order Request</title>
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
	.dashboard-container{
	  height: auto !important;
	 }
	 .dashboard-content-container{
	  height: auto !important;
	 }
	 .simplebar-track{
	  display: none !important;
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
	<div class="dashboard-content-container" style="height: 600px" data-simplebar>
		<div class="dashboard-content-inner" >
			
			<!-- Dashboard Headline -->
			<div class="dashboard-headline">
				<center><h3><strong>Post A Request : DailyNeeds</strong></h3></center>
			</div>
	
			<!-- Row -->
			<form method="post" id="post-service-form">
				<!-- Row -->
			<div class="row">

				<!-- Dashboard Box -->
				<div class="col-xl-8 offset-xl-2">
					<div class="dashboard-box margin-top-0">

						<!-- Headline -->
						<div class="headline">
							<h3><i class="icon-feather-folder-plus"></i> Post A Request To The Seller Community</h3>
						</div>
						<input type="text" name="posterid", value="<?php echo $_SESSION['id'];?>" hidden>
						<div class="content with-padding padding-bottom-10">
							<div class="row">

								<div class="col-xl-12">
									<div class="submit-field">
										<h5>Description *<h6>(Max. 200 Characters)</h6></h5>
										<textarea cols="30" rows="5" class="with-border" name="description" minlength="10" maxlength="200" required></textarea>
									</div>
								</div>


								<div class="col-xl-6">
									<div class="submit-field">
										<h5>Select Category *</h5>
										<select id="category" name="category" style="padding-bottom: 0px;padding-top: 0px;" required>
											<option>Select Category</option>
										</select>
									</div>
								</div>

								<div class="col-xl-6">
									<div class="submit-field">
										<h5>Select Subcategory *</h5>
										<select  id="scategory" name="scategory" style="padding-bottom: 0px;padding-top: 0px;" required>
											<option>Select Sub Category</option>
										</select>
									</div>
								</div>
								<!-- <div class="col-xl-6" style="display: none;" id="suggestbox">
									<div class="submit-field">
										<h5>Suggest Other ?</h5>
										<div class="input-with-icon">
											<div id="autocomplete-container">
												<input class="with-border" type="text" placeholder="" value="" name="suggest" maxlength="50" required>
											</div>
										</div>
									</div>
								</div> --> 
								<div class="col-xl-6">
									<div class="submit-field">
										<h5>Delivered Time *</h5>
										<div class="input-with-icon">
											<div id="autocomplete-container">
												<input class="with-border" type="number" placeholder="Add Time" name="time" required>
											</div>
										</div>
									</div>
								</div>
								<div class="col-xl-6">
									<div class="submit-field">
										<h5>Select Time *</h5>
										<select  data-size="7" title="Select Category" style="padding-bottom: 0px;padding-top: 0px;" name="type" required>
											<option>Select Time</option>
											<option value="h">Hour's</option>
											<option value="d">Days</option>
											<option value="m">Month</option>
										</select>
									</div>
								</div>
								<div class="col-xl-6">
									<div class="submit-field">
										<h5>Budget *</h5>
										<div class="input-with-icon">
											<div id="autocomplete-container">
												<input class="with-border" type="number" placeholder="Add Budget" name="budget" required>
											</div>
										</div>
									</div>
								</div>
								<div class="col-xl-12">
									<button class="button ripple-effect big margin-top-30"><i class="icon-feather-plus" type="submit" form="post-service-form"></i> Post </Button>
								</div>
							</div>
						</div>
					</div>
				</div>

				

			</div>
			<!-- Row / End -->
			</form>
			<!-- Row / End -->

		<br><br>

		</div>
	</div>
	<!-- Dashboard Content / End -->
<a href="#small-dialog-2" class="popup-with-zoom-anim button dark ripple-effect openBOx" hidden></a>

<!-- Send Direct Message Popup
================================================== -->
<div id="small-dialog-2" class="zoom-anim-dialog mfp-hide dialog-with-tabs">

	<!--Tabs -->
	<div class="sign-in-form">

		<div class="popup-tabs-container">
			<!-- Welcome Text -->
			<div class="welcome-text margin-top-50">
				<h3 id="addmsg"></h3>
			</div>
				
			<!-- Button -->
			<button class="button full-width button-sliding-icon ripple-effect buttonClick" >Done <i class="icon-material-outline-arrow-right-alt"></i></button>
		</div>
	</div>
</div>
<!-- Send Direct Message Popup / End -->

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

	$.ajax({
		url: '<?php echo SITE_URL;?>/v1/services/index.php?service=city',
		type: 'GET',
		success: function(results){
			var results = JSON.parse(results);
			
			var output = [];
			for (var i = 0; i < results.length; i++) {
				// console.log("results ::::::: ", results[i]);
				output.push('<option value="'+ results[i]['id'] +'">'+ results[i]['name'] +'</option>');
			}

			$('#cityOptions').html(output.join(''));
		},
		error: function(err){
			console.log("err :::::: ",err);
		}
	})

	$.ajax({
		url: '<?php echo SITE_URL;?>/v1/services/index.php?service=categories',
		type: 'GET',
		success: function(results){
			// console.log("results ::::::: ", results);
			var results = JSON.parse(results);
			if(results['error'] == 'N'){
				results = results.data;
				var output = ['<option value"">Select Category</option>'];
				for (var i = 0; i < results.length; i++) {
					output.push('<option value="'+ results[i]['id'] +'">'+ results[i]['name'] +'</option>');
				}
				
				$('#category').html(output.join(''));
			}	
			
		},
		error: function(err){
			console.log("err :::::: ",err);
		}
	})
	$('#scategory').change(function(){
			var id = this.value;
			if(id == '52' || id == 52){
				$('#suggestbox').css('display', 'block');
			}else{
				$('#suggestbox').css('display', 'none');
			}
	})
	$( "#category" ).change(function() {
		  $.ajax({
				url: '<?php echo SITE_URL;?>/v1/services/index.php?service=scategories&code='+this.value,
				type: 'GET',
				success: function(results){
					// console.log("results ::::::: ", results);
					var results = JSON.parse(results);
					if(results['error'] == 'N'){
						results = results.data;
						var output = ['<option value"">Select Sub Category</option>'];
						for (var i = 0; i < results.length; i++) {
							output.push('<option value="'+ results[i]['id'] +'">'+ results[i]['name'] +'</option>');
						}
						
						$('#scategory').html(output.join(''));
					}

					
				},
				error: function(err){
					console.log("err :::::: ",err);
				}
			})
	});

	$( "#post-service-form" ).submit(function( event ) {
		 
	  	event.preventDefault();
	  	var formData = new FormData(this);
	  	console.log("formatsdta ::::: ", formData);
	  	$.ajax({
			url: '<?php echo SITE_URL;?>/v1/services/service.php?service=postRequest',
			type: 'POST',
			data:formData,
            cache:false,
            contentType: false,
            processData: false,
			success: function(results){
				console.log("results :::::: ", results);
				results = JSON.parse(results);

				if(results['error'] == 'Y'){
					$('#addmsg').text(results['msg']);
			  	}else{
			  		$('#addmsg').text(results['msg']);
			  	}

			  	$('#post-service-form')[0].reset();
			  	$('.openBOx').trigger('click');
				setTimeout(function(){
					$('.mfp-close').trigger('click');
					window.location = '<?php echo SITE_URL;?>/manage_requests'

				},1500);
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