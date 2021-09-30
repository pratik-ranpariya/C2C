<?php
	include("v1/config.php");
	if(!isset($_SESSION)) 
	{ 
	    session_start();
	    if(!isset($_SESSION['id'])){
				session_start();
				session_destroy();
				header('Location: http://dailyneeds.co.nz');
			}
	}else{
		if(!isset($_SESSION['id'])){
			session_start();
			session_destroy();
			header('Location: http://dailyneeds.co.nz');
		}
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
 .dashboard-content-container{
  min-height: 1100px !important;
  height: auto !important;
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
				<center><h3><strong><?php echo (isset($_GET['sid'])) ? 'Edit' : 'Create'?> your Service Post With : DailyNeeds</strong></h3></center>
			</div>
	
			<!-- Row -->
			<form method="post" id="service-post-form">
				<div class="row">
					<!-- Dashboard Box -->
					<div class="col-xl-8 offset-xl-2">
						<div class="notification closeable" style="display: none;">
							<p id="successmsg"></p>
							<a class="close" href="#"></a>
						</div>
						<div class="dashboard-box margin-top-0">

							<!-- Headline -->
							<div class="headline">
								<h3><i class="icon-feather-folder-plus"></i> Service <?php echo (isset($_GET['sid'])) ? 'Edit' : 'Submission'?> Form</h3>
							</div>

							<div class="content with-padding padding-bottom-10">
								<div class="row">

									<input type="text" name="userid" value="<?php echo isset($_SESSION['id']) ? $_SESSION['id'] : ''?>" hidden>
									<div class="col-xl-6">
										<div class="submit-field">
											<h5>Service Title *</h5>
											<input type="text" value="<?php echo (isset($row['title'])) ? $row['title'] : '';?>" class="with-border" name="title" maxlength="50" required>
										</div>
									</div>
									<div class="col-xl-6">
										<div class="submit-field">
											<h5>Price *</h5>
											<input type="text" class="with-border" value="<?php echo (isset($row['price'])) ? $row['price'] : '';?>" name="price" maxlength="11" required>
										</div>
									</div>

									<div class="col-xl-6">
										<div class="submit-field">
											<h5>Select City *</h5>
											<select  data-size="7" title="Select City" name="city" id="cityOptions" maxlength="20" style="padding-bottom: 0px;padding-top: 0px;" required>
												<?php foreach ($citydata as $value) { ?>
													<option value="<?php echo $value['id'];?>" <?php echo (isset($row['city']) && $row['city'] == $value['id']) ? 'selected' : '';?> ><?php echo $value['name'];?></option>
												<?php } ?>
											</select>
										</div>
									</div>

									<div class="col-xl-6">
										<div class="submit-field">
											<h5>Select Category *</h5>
											<select  data-size="7" name="category" id="categoryOptions" maxlength="20" style="padding-bottom: 0px;padding-top: 0px;" <?php echo (isset($_GET['sid'])) ? 'disabled' : ''?> required>
											</select>
										</div>
									</div>

									<div class="col-xl-6">
										<div class="submit-field">
											<h5>Select Sub Category *</h5>
											<select  data-size="7" name="scategory" id="scategoryOptions" maxlength="50" style="padding-bottom: 0px;padding-top: 0px;" <?php echo (isset($_GET['sid'])) ? 'disabled' : ''?> required>
												<option value="">Select Sub Category</option>
											</select>
										</div>
									</div>
									<?php if(!isset($_GET['sid'])){?>
									<div class="col-xl-6" style="display: none;" id="suggestbox">
										<div class="submit-field">
											<h5>Suggest Other ?</h5>
											<div class="input-with-icon">
												<div id="autocomplete-container">
													<input class="with-border" type="text" placeholder="" value="" name="suggest" maxlength="50">
												</div>
											</div>
										</div>
									</div>
									<?php }?>
									<div class="col-xl-6">
										<div class="submit-field">
											<h5>Delivered Time *</h5>
											<div class="input-with-icon">
												<div id="autocomplete-container">
													<input class="with-border" type="number" placeholder="Add Time" value="<?php echo (isset($row['time'])) ? $row['time'] : '';?>" name="time" required>
												</div>
											</div>
										</div>
									</div>
									<div class="col-xl-6">
										<div class="submit-field">
											<h5>Select Time Type</h5>
											<select  data-size="7" name="type" style="padding-bottom: 0px;padding-top: 0px;" required>
												<option <?php echo (isset($row['type']) && $row['type'] == '') ? 'selected' : '';?>>Select Time Type</option>
												<option value="h" <?php echo (isset($row['type']) && $row['type'] == 'h') ? 'selected' : '';?>>Hour's</option>
												<option value="d" <?php echo (isset($row['type']) && $row['type'] == 'd') ? 'selected' : '';?>>Days</option>
												<option value="m" <?php echo (isset($row['type']) && $row['type'] == 'm') ? 'selected' : '';?>>Months</option>
											</select>
										</div>
									</div>

									<div class="col-xl-12">
										<div class="submit-field">
											<h5>Service Description *<h6>(Max. 200 Characters)</h6></h5>
											<textarea cols="30" rows="5" class="with-border" name="description" id="descriptionId" minlength="10" maxlength="200" required><?php echo (isset($row['description'])) ? $row['description'] : '';?></textarea>

											<?php if(isset($row['image'])){?>
											<div class="freelancer-avatar">
												<img class="sellerprofile" src="images/services/<?php echo $row['image'];?>" alt="">
											</div>	
											<?php }?>

											<div class="uploadButton margin-top-30">
												<input class="uploadButton-input" type="file" accept="image/*" name="file" id="upload" <?php echo (isset($_GET['sid'])) ? '' : 'required'?>/>
												<label class="uploadButton-button ripple-effect" for="upload">Upload File</label>
												<span class="uploadButton-file-name">Image or document that might be helpful in describing your job</span>
											</div>
										</div>
									</div>
									<a href="#small-dialog-2" class="popup-with-zoom-anim button dark ripple-effect openBOx"></a>

								</div>
							</div>
						</div>
					</div>

					<div class="col-xl-12">
						<center>
							<?php if(isset($_GET['sid'])){?>
								<button type="submit" class="post-service button ripple-effect big margin-top-30">Update Service <i class="icon-feather-plus"></i></button>
								<button type="button" class="remove-service button ripple-effect big margin-top-30" style="margin-left: 10px;background-color: #ca0000;">Delete Service <i class="icon-feather-trash-2"></i></button>
							<?php }else{?>
								<button type="submit" class="post-service button ripple-effect big margin-top-30">Post A Service <i class="icon-feather-plus"></i></button>
							<?php }?>
							</center>
					</div>
				</div>
			</form>
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
<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
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
	var city = '<?php echo (isset($row['city'])) ? $row['city'] : '';?>';
	var category = '<?php echo (isset($row['category'])) ? $row['category'] : '';?>';
	var scategory = '<?php echo (isset($row['scategory'])) ? $row['scategory'] : '';?>';

	$.ajax({
		url: '<?php echo SITE_URL;?>/v1/services/index.php?service=city',
		type: 'GET',
		success: function(results){
			console.log("add service data for city :::::: ",results);
			var results = JSON.parse(results);
			var output = ['<option value"">Select City</option>'];
			results = results.data;
			for (var i = 0; i < results.length; i++) {
				if(city != '' && city == results[i]['id']){
					output.push('<option value="'+ results[i]['id'] +'" selected>'+ results[i]['name'] +'</option>');
				}else{
					output.push('<option value="'+ results[i]['id'] +'">'+ results[i]['name'] +'</option>');
				}
			}
			if(output.length){
				$('#cityOptions').html(output.join(''));
			}
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
					if(category != '' && category == results[i]['id']){
						output.push('<option value="'+ results[i]['id'] +'" selected>'+ results[i]['name'] +'</option>');
						$.ajax({
							url: '<?php echo SITE_URL;?>/v1/services/index.php?service=scategories&code='+results[i]['id'],
							type: 'GET',
							success: function(results){
								// console.log("results ::::::: ", results);
								var results = JSON.parse(results);
								if(results['error'] == 'N'){
									results = results.data;
									var output = ['<option value"">Select Sub Category</option>'];
									for (var i = 0; i < results.length; i++) {
										if(scategory != '' && scategory == results[i]['id']){
											output.push('<option value="'+ results[i]['id'] +'" selected>'+ results[i]['name'] +'</option>');
										}else{
											output.push('<option value="'+ results[i]['id'] +'">'+ results[i]['name'] +'</option>');
										}
									}
									
									$('#scategoryOptions').html(output.join(''));
								}

								
							},
							error: function(err){
								console.log("err :::::: ",err);
							}
						})
					}else{
						output.push('<option value="'+ results[i]['id'] +'">'+ results[i]['name'] +'</option>');
					}
				}
				
				$('#categoryOptions').html(output.join(''));
			}	
			
		},
		error: function(err){
			console.log("err :::::: ",err);
		}
	})
	$('#scategoryOptions').change(function(){
		var id = this.value;
		if(id == '52' || id == 52){
			$('#suggestbox').css('display', 'block');
		}else{
			$('#suggestbox').css('display', 'none');
		}
	})
	$( "#categoryOptions" ).change(function() {
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
							if(scategory != '' && scategory == results[i]['id']){
								output.push('<option value="'+ results[i]['id'] +'" selected>'+ results[i]['name'] +'</option>');
							}else{
								output.push('<option value="'+ results[i]['id'] +'">'+ results[i]['name'] +'</option>');
							}
						}
						$('#scategoryOptions').html(output.join(''));
					}
				},
				error: function(err){
					console.log("err :::::: ",err);
				}
			})
	});
	$('.remove-service').click(function(){
		swal({
		    title: "Are you sure?",
		    text: "",
		    icon: "warning",
		    buttons: true,
		    dangerMode: true,
		  })
		  .then((willDelete) => {
			  	var id = '<?php echo (isset($_GET['sid'])) ? $_GET['sid'] : '';?>';
			  	var userid = '<?php echo (isset($_SESSION['id'])) ? $_SESSION['id'] : '';?>';
			  	if(id && id != '' && userid && userid != ''){
			  		var url = '<?php echo SITE_URL;?>/v1/services/service.php?service=removeService';
			  	}else{
			  		window.location='<?php echo SITE_URL;?>/myservices';
			  	}
			  	$.ajax({
					url: url,
					type: 'POST',
					data: {serviceid: id, userid: userid},
					success: function(results){
						console.log("results :::::: ", results);
						results = JSON.parse(results);
						if(results.error == 'Y'){
							swal("Oops!", results['msg']);
						}else{
							window.location='<?php echo SITE_URL;?>/myservices';
						}
					}
				})
			})
	})
	$( "#service-post-form" ).submit(function( event ) {
	  	event.preventDefault();
	  	var formData = new FormData(this);
	  	console.log("formatsdta ::::: ", formData);
	  	console.log("$('#descriptionId').val() :::::::::::::::: ", $('#descriptionId').val());
	  	if($('#descriptionId').val().length <= 200){

	  		var id = '<?php echo (isset($_GET['sid'])) ? $_GET['sid'] : '';?>';
	  		if(id && id != ''){
	  			var url = '<?php echo SITE_URL;?>/v1/services/service.php?service=addService&sid='+id;
	  		}else{
	  			var url = '<?php echo SITE_URL;?>/v1/services/service.php?service=addService';
	  		}
	  		$.ajax({
	  			url: url,
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

	  				$('#service-post-form')[0].reset();
	  				$('.uploadButton-file-name').html('Image or document that might be helpful in describing your job');
	  				$('.openBOx').trigger('click');
	  				setTimeout(function(){
	  					$('.mfp-close').trigger('click');	
	  					window.location='<?php echo SITE_URL;?>/myservices';

	  				},1000);
	  			},
	  			error: function(err){
	  				console.log("err :::::: ",err);
	  			}
	  		})
	  	}else{
	  		swal("Oops", "Description, No more then 200 character");
	  	}
	});




</script>
</script>

</body>
</html>