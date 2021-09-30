<!doctype html>
<html lang="en">
<head>

<!-- Basic Page Needs
================================================== -->
<title>DailyNeeds | Contact</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

<!-- CSS
================================================== -->
<link rel="stylesheet" href="css/style.css?v=1">
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
<div class="clearfix"></div>
<!-- Header Container / End -->

<!-- Titlebar
================================================== -->
<div id="titlebar" class="gradient">
	<div class="container">
		<div class="row">
			
		</div>
	</div>
</div>


<!-- Content
================================================== -->
<div class="dashboard-headline">
	<center><h3><strong>Contact Us : DailyNeeds</strong></h3></center>
</div>

<!-- Container -->
<div class="container">
	<div class="row">

		<div class="col-xl-8 col-lg-8 offset-xl-2 offset-lg-2">
			<div class="notification closeable" style="display: none;">
				<p id="successmsg"></p>
				<a class="close" href="#"></a>
			</div>
			<section id="contact" class="margin-bottom-60">
				<h3 class="headline margin-top-15 margin-bottom-35">Any questions? Feel free to contact us!</h3>

				<form method="post" name="contact-form" id="contact-form" autocomplete="on">
					<div class="row">
						<div class="col-md-6">
							<div class="input-with-icon-left">
								<input class="with-border" name="name" type="text" id="name" placeholder="Your Name" required="required" />
								<i class="icon-material-outline-account-circle"></i>
							</div>
						</div>

						<div class="col-md-6">
							<div class="input-with-icon-left">
								<input class="with-border" name="email" type="email" id="email" placeholder="Email Address" pattern="^[A-Za-z0-9](([_\.\-]?[a-zA-Z0-9]+)*)@([A-Za-z0-9]+)(([\.\-]?[a-zA-Z0-9]+)*)\.([A-Za-z]{2,})$" required="required" />
								<i class="icon-material-outline-email"></i>
							</div>
						</div>
					</div>

					<div class="input-with-icon-left">
						<input class="with-border" name="subject" type="text" id="subject" placeholder="Subject" required="required" />
						<i class="icon-material-outline-assignment"></i>
					</div>

					<div>
						<textarea class="with-border" name="comments" cols="40" rows="5" id="comments" placeholder="Message" spellcheck="true" required="required"></textarea>
					</div>

					<input type="submit" class="submit button margin-top-15" id="submit" value="Submit Message" />

				</form>
			</section>

		</div>

	</div>
</div>
<!-- Container / End -->

<?php include("views/footer.php");?>

</div>
<!-- Wrapper / End -->
<?php include("views/model.php");?>


<!-- Scripts
================================================== -->
<script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script><script src="js/jquery-3.3.1.min.js"></script>
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
			
			if(results['error'] == 'N'){
				window.location = "<?php echo $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];?>";
			}else{
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


$( "#contact-form" ).submit(function( event ) {
  	event.preventDefault();
  	var formData  = $( this ).serializeArray();
  	var requestData = {};
	for (var i = 0; i < formData.length; i++) {
		requestData[formData[i].name] = formData[i].value;
 	}
  	console.log("formatsdta ::::: ", formData);

  	$.ajax({
		url: '<?php echo SITE_URL;?>/v1/services/service.php?service=contact',
		type: 'POST',
		data: requestData,
        success: function(results){
			data = JSON.parse(results);
			if(data['error'] == 'N'){
				$('.closeable').addClass('success');
		  		$('#successmsg').html('<strong>Success </strong> '+data['msg']);
			}else{
				$('.closeable').addClass('error');
				$('#successmsg').html('<strong>Problem </strong> '+data['msg']);
			}

			$('.closeable').fadeIn();
		  	setTimeout(function(){
		  		$('.closeable').fadeOut();
		  		$('.mfp-close').trigger('click');

		  	},1500);
		},
		error: function(err){
			console.log("err :::::: ",err);
		}
	})
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

<!-- Maps -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAgeuuDfRlweIs7D6uo4wdIHVvJ0LonQ6g&libraries=places"></script>
<script src="js/infobox.min.js"></script>
<script src="js/markerclusterer.js"></script>
<script src="js/maps.js"></script>

</body>
</html>