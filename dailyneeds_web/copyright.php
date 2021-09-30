<!doctype html>
<html lang="en">
<head>

<!-- Basic Page Needs
================================================== -->
<title>DailyNeeds | Copyright Policy</title>
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
	<center><h3><strong>Copyright Policy : DailyNeeds</strong></h3></center>
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
				<p><b><h5>Copyright Site Structure & Symbol</h5></b>
				<h5>Copyright © 2019 Daily Needs Limited</h5></p>
					
				<h3 class="headline margin-top-35 margin-bottom-15">Copyright Statement</h3>
				<p>Information on this website or our mobile applications and services is owned or otherwise provided by Daily Needs
Limited (trading as DailyNeeds). All material on this website or our mobile applications and services, including,
without limitation, text, images, graphics, layout, look-and-feel and any other information contained on or in this
website or mobile applications and services (collectively, 'content'), is subject to copyright and other proprietary
rights, including but not limited to the Copyright Act 1994 (New Zealand) and international copyrights, trademarks or
other intellectual property rights and laws.
</p>
				<p>Unless otherwise stated, copyright in the content and behaviours of this website or our mobile applications and
services is owned by or licensed to Daily Needs Limited. Daily Needs Limited authorises you to access and view
content on this website, print individual pages and download a single copy of the material of this website for your
personal, non-commercial use.
</p>
				<p>Trademarks, logos and service marks (collectively, 'marks') displayed on this website or mobile applications and
services are registered or unregistered Marks of Daily Needs Limited or others, are the property of their respective
owners, and may not be used without prior written permission of the owner of such marks.</p>				
				
				<h3 class="headline margin-top-35 margin-bottom-15">Copyright infringement</h3>
				<p>If you believe any material displayed on this website or our mobile applications and services infringes your copyright,
you may issue us a notice pursuant to the Copyright Act 1994 to request that the matter be investigated.</p>

				<h3 class="headline margin-top-35 margin-bottom-15">Physical Address</h3>
				<p><h5>7 Oakmont Place</h5>
				<h5>Rototuna, Hamilton</h5>
				<h5>New Zealand</h5></p>

				<h3 class="headline margin-top-35 margin-bottom-15">Contact Us via Email</h3>
				<p><b>support@dailyneeds.co.nz</b></p>
				
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