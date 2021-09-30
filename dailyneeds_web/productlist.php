<?php include('productData.php'); 
?>
<!doctype html>
<html lang="en">
<head>

<!-- Basic Page Needs
================================================== -->
<title>DailyNeeds | Product List</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

<!-- CSS
================================================== -->
<link rel="stylesheet" href="css/style.css?v=2">
<link rel="stylesheet" href="css/colors/blue.css?v=2">
<style type="text/css">
.active_sub{
  background-color: #ffa500 !important;
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

<div class="clearfix"></div>
<!-- Header Container / End -->

<!-- Spacer -->
<div class="margin-top-90"></div>
<div class="container">
	<div class="dashboard-headline">
		<center><h3><strong><?php echo $categoriesData['name'];?><?php echo isset($subcategoriesData['name']) ? ' / '.$subcategoriesData['name']  : ''; ?></strong></h3></center>
	</div>
	<div class="row">
		<div class="col-xl-3 col-lg-4">
			<div class="sidebar-container">
				<div class="sidebar-widget">
			     <h3>Category </h3>
			     <div class="">
			     <?php foreach ($categoryData as $key => $value) { ?>
			     
			      <div>
			       <a href="<?php echo SITE_URL;?>/productlist?code=<?php echo $_GET['code'];?>&scode=<?php echo $value['id'] ;?>" class="button gray ripple-effect-dark <?php echo isset($_GET['scode']) ? ($_GET['scode'] == $value['id']) ? 'active_sub' : '' : '' ;?>"><?php echo $value['name'];?></a>
			      </div>

			     <?php } ?> 
			     </div>
			    </div>
			</div>
		</div>
		<div class="col-xl-9 col-lg-8 content-left-offset">

			<h3 class="page-title">Search Results</h3>

			<div class="listings-container grid-layout margin-top-35">
				
				<?php
				if($count){

					while($crow = mysqli_fetch_array($nquery)){
						$email = mysqli_real_escape_string($db, $crow['email']);
						$sql = "SELECT username, id FROM register WHERE email = '$email'";
						$result = mysqli_query($db, $sql);
						$row = mysqli_fetch_array($result,MYSQLI_ASSOC);

				?>
				<a href="<?php echo SITE_URL;?>/product?uid=<?php echo $row['id'];?>&sid=<?php echo $crow['id'];?>" class="job-listing">

					<!-- Job Listing Details -->
					<div class="job-listing-details">
						<!-- Logo -->
						<div class="job-listing-company-logo">
							<img src="<?php echo 'images/services/'.$crow['image']; ?>" alt="">
						</div>

						<!-- Details -->
						<div class="job-listing-description">
							<h4 class="job-listing-company"> <?php echo $crow['title']; ?> </h4>
							<h3 class="job-listing-title">Bilingual Event Support Specialist</h3>
						</div>
					</div>

					<!-- Job Listing Footer -->
					<div class="job-listing-footer">
						<ul>
							<li><i class="icon-feather-user"></i> <?php echo $row['username']?></li>
						</ul>
					</div>
				</a>

				<?php
					}
				}else{
				?>
					<!-- Job Listing Details -->
					
					<div class="listings-container grid-layout">
						<div class="job-listing-description">
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
</div>

<?php include("views/footer.php");?>

</div>
<!-- Wrapper / End -->
<?php include("views/model.php");?>


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
<script src="https://sdk.accountkit.com/en_US/sdk.js"></script>
<script type="text/javascript">
	AccountKit_OnInteractive = function(){
    AccountKit.init(
      {
        appId:"381652462609043", 
        state:"abcd", 
        version:"v1.1",
        fbAppEventsEnabled:true
      }
    );
  };

    
  // login callback
  function loginCallback(response) {
    if (response.status === "PARTIALLY_AUTHENTICATED") {
      var code = response.code;
      var csrf = response.state;
        console.log(" code ::::::::::: ", code);
        
        $.post("<?php echo SITE_URL;?>/verify", { code : code, csrf : csrf }, function(result){
            console.log("result :::::::::::::: ", result);
            result = JSON.parse(result);
            console.log("result :::::::::::::: ", result, result.national_number);

            if(typeof result.phone.national_number != 'undefined'){

	            $('#forget-mobile-no').val(result.phone.national_number);
	            $('.forgot-password').trigger('click');

            }else{
            	swal("Oops!", "System Error");
            }
        });
        
    }
    else if (response.status === "NOT_AUTHENTICATED") {
      // handle authentication failure
      swal("Oops!", "Contact Details Not Authenticate!");
    }
    else if (response.status === "BAD_PARAMS") {
      // handle bad parameters
     	swal("Oops!", "Contact Details Not Authenticate!");   
    }
  }
    
    
  function phone_btn_onclick() {
    // you can add countryCode and phoneNumber to set values
    AccountKit.login('PHONE', {}, // will use default values if this is not specified
      loginCallback);
  }
</script>

<script src="https://sdk.accountkit.com/en_US/sdk.js"></script>
<script type="text/javascript">
	AccountKit_OnInteractive = function(){
    AccountKit.init(
      {
        appId:"381652462609043", 
        state:"abcd", 
        version:"v1.1",
        fbAppEventsEnabled:true
      }
    );
  };
 
    
  // login callback
  function loginback(response) {
    if (response.status === "PARTIALLY_AUTHENTICATED") {
      var code = response.code;
      var csrf = response.state;
        console.log(" code ::::::::::: ", code);
        
        $.post("<?php echo SITE_URL;?>/verify", { code : code, csrf : csrf }, function(result){
            console.log("result :::::::::::::: ", result);
            result = JSON.parse(result);
            console.log("result :::::::::::::: ", result, result.national_number);

            if(typeof result.phone.national_number != 'undefined'){
				console.log("result :::::::::::::: ", result);
	            $('#emailaddress-rgstr').val(result.phone.national_number);
	            $('#register-account-form').trigger('submit');
				console.log("result ::::12");
            }else{
            	swal("Oops!", "System Error");
            }
        });
        
    }
    else if (response.status === "NOT_AUTHENTICATED") {
      // handle authentication failure
      swal("Oops!", "Contact Details Not Authenticate!");
    }
    else if (response.status === "BAD_PARAMS") {
      // handle bad parameters
     	swal("Oops!", "Contact Details Not Authenticate!");   
    }
  }
    
    
  function phone_btn_click() {
    // you can add countryCode and phoneNumber to set values
    AccountKit.login('PHONE', {}, // will use default values if this is not specified
      loginback);
  }
</script>


<script>
<script type="text/javascript">

var sess = '<?php echo (isset($_SESSION['email'])) ? 1 : 0?>';
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
			console.log("results :::::: ", results);
			var results = JSON.parse(results);

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


	$('#login-form').submit(function(event){
		event.preventDefault();
	  	var formData = new FormData(this);
	  	$.ajax({
			url: '<?php echo SITE_URL;?>/v1/services/login.php?service=login',
			type: 'POST',
			data:formData,
            cache:false,
            contentType: false,
            processData: false,
			success: function(results){
				var results = JSON.parse(results);
				console.log("results L::::: ", results);
				if(results['error'] == 'N'){
					window.location = "<?php echo $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];?>";
				}else{
					console.log("results['msg'] ::::: ", results['msg']);
					swal("Oops", results['msg']);
				}
			},
			error: function(err){
				console.log("err :::::: ",err);
			}
		})
	})
	$('#forget-form').submit(function(event){
		event.preventDefault();
			if($('#forget-npassword').val() == $('#forget-ncpassword').val()){
				var formData = new FormData(this);
		  	$.ajax({
					url: '<?php echo SITE_URL;?>/v1/services/login.php?service=forgetPassword',
					type: 'POST',
					data:formData,
		            cache:false,
		            contentType: false,
		            processData: false,
					success: function(results){
						console.log("results L::::: ", results);
						var results = JSON.parse(results);
						if(results['error'] == 'N'){
							window.location = "<?php echo $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];?>";
						}else{
							console.log("results['msg'] ::::: ", results['msg']);
							swal("Oops", results['msg']);
						}
					},
					error: function(err){
						console.log("err :::::: ",err);
					}
				})
	  	}else{
				swal("Oops!", "Password does not match!");
			}
	})
$( "#register-account-form" ).submit(function( event ) {
	  	event.preventDefault();
	  	var formData = new FormData(this);
		var mobile = formData.get('mobile');
		console.log("formatsdta sumit 1234 ::::: ", formData.has('mobile'),mobile,mobile == '');
		if(mobile == '') {
			console.log("1");
			phone_btn_click();
		}
	  	else {
			console.log("2");
	  	
	  		$.ajax({
			url: '<?php echo SITE_URL;?>/v1/services/login.php?service=register',
			type: 'POST',
			data:formData,
            cache:false,
            contentType: false,
            processData: false,
			success: function(results) {
				var results = JSON.parse(results);
				console.log("results :::::: ", results,mobile);
				console.log("results['error'] :::::: ", results['error']);

				if(results['error'] == 'N') {
					window.location = "<?php echo $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];?>";

				} else {
					swal("Oops", results['msg']);
					console.log("results ::::::5594 ", results,mobile);
					if(mobile== results['data']){
						console.log("results ::::::5595 ", results,mobile);
						$('#emailaddress-rgstr').val('');
					}
					
				}
			},
			error: function(err){
				console.log("err :::::: ",err);
			}
		})
	  }
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
		url: '<?php echo SITE_URL;?>/v1/services/service.php?service=services',
		type: 'GET',
		success: function(results){
			console.log("results ::::::: ", results);
			var results = JSON.parse(results);
			
			var output = [];
			for (var i = 0; i < results.length; i++) {
				output.push('<option value="'+ results[i]['id'] +'">'+ results[i]['name'] +'</option>');
			}
			
			$('#categoryOptions').html(output.join(''));

			
		},
		error: function(err){
			console.log("err :::::: ",err);
		}
	})

	$( "#service-post-form" ).submit(function( event ) {
	  	event.preventDefault();
	  	var formData = new FormData(this);
	  	console.log("formatsdta ::::: ", formData);
	  	$.ajax({
			url: '<?php echo SITE_URL;?>/v1/services/service.php?service=addService',
			type: 'POST',
			data:formData,
            cache:false,
            contentType: false,
            processData: false,
			success: function(results){
				console.log("results :::::: ", results);
				results = JSON.parse(results);
				if(results['error'] == 'Y'){
			  		$('.closeable').addClass('error');
			  		$('#successmsg').html('<strong>Problem </strong> '+results['msg']);
			  	}else{
			  		$('.closeable').addClass('success');
			  		$('#successmsg').html('<strong>Success </strong> '+results['msg']);
			  	}

			  	$('.closeable').fadeIn();
			  	setTimeout(function(){
			  		$('.closeable').fadeOut();
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