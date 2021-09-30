<?php include('recommanded.php'); 
error_reporting(0);
session_start();
?>
<!doctype html>
<html lang="en">
<head>

<!-- Basic Page Needs
================================================== -->
<title>DailyNeeds</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

<!-- CSS
================================================== -->
<link rel="stylesheet" href="css/style.css?v=122">
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
<style type="text/css">
	#wrapper{
	display: none;
}
.preloader {
  display: flex;
  justify-content: center;
  align-items: center;
  width: 100%;
  height: 100%;
}

.preloader_full-screen {
  height: 100vh;
}

.circle {
  position: relative;
  width: 26px;
  height: 26px;
  border-radius: 50%;
}

.circle_green {
  background-color: #ffa500;
  transform: translateX(13px);
  animation: animate-green 2s linear infinite;
}

.circle_red {
  background-color: #ffa500;
  transform: translateX(-13px);
  animation: animate-red 2s linear infinite;
}

@keyframes animate-green {
  0% {
    background-color: #ffa500;
  }

  3% {
    background-color: #ffa500;
    transform: translateX(13px);
  }
  
  9% {
    background-color: #ffa500;
    transform: translateX(-20px);
  }
  
  14% {
    transform: translateX(2px);
  }

  18% {
    transform: translateX(-12px);
  }

  21% {
    transform: translateX(-3px);
  }

  23% {
    transform: translateX(-9px);
  }

  24% {
    transform: translateX(-7px);
  }

  30% {
    transform: translateX(-7px) scale(1);
    animation-timing-function: cubic-bezier(.6, 0, 1, 1);
  }

  43% {
    z-index: -1;
    transform: translateX(13px) scale(.6);
    animation-timing-function: cubic-bezier(0, 0, .4, 1);
  }

  56% {
    z-index: 1;
    transform: translateX(33px) scale(1);
    animation-timing-function: cubic-bezier(.6, 0, 1, 1);
  }
  
  69% {
    transform: translateX(13px) scale(1.4);
    animation-timing-function: cubic-bezier(0, 0, .4, 1);
  }

  82% {
    z-index: 1;
    background-color: #ffa500;
    transform: translateX(-7px) scale(1);
    animation-timing-function: ease-in;
  }

  98% {
    background-color: #ffa500;
    transform: translateX(13px);
  }

  100% {
    background-color: #ffa500;
  }
}

@keyframes animate-red {
  0% {
    background-color: #ffa500;
  }

  3% {
    background-color: #ffa500;
    transform: translateX(-13px);
  }
  
  9% {
    background-color: #ffa500;
    transform: translateX(20px);
  }
  
  14% {
    transform: translateX(-2px);
  }

  18% {
    transform: translateX(12px);
  }

  21% {
    transform: translateX(3px);
  }

  23% {
    transform: translateX(9px);
  }

  24% {
    transform: translateX(7px);
  }

  30% {
    transform: translateX(7px) scale(1);
    animation-timing-function: cubic-bezier(.6, 0, 1, 1);
  }

  43% {
    transform: translateX(-13px) scale(1.4);
    animation-timing-function: cubic-bezier(0, 0, .4, 1);
  }

  56% {
    transform: translateX(-33px) scale(1);
    animation-timing-function: cubic-bezier(.6, 0, 1, 1);
  }

  69% {
    transform: translateX(-13px) scale(.6);
    animation-timing-function: cubic-bezier(0, 0, .4, 1);
  }

  82% {
    background-color: #ffa500;
    transform: translateX(7px) scale(1);
    animation-timing-function: ease-in;
  }

  98% {
    background-color: #ffa500;
    transform: translateX(-13px);
  }

  100% {
    background-color: #ffa500;
  }
}
</style>
</head>
<body>
<div id="preloader" class="preloader preloader_full-screen">
  <div class="circle circle_green"></div>
  <div class="circle circle_red"></div>
</div>
<a href="#small-dialog-1" id="small-dia" class="popup-with-zoom-anim log-in-button"></a>
<!-- Wrapper -->
<div id="wrapper">

<!-- Header Container
================================================== -->
<?php include("views/header.php");?>
<div class="clearfix"></div>
<!-- Header Container / End -->



<!-- Intro Banner
================================================== -->
<!-- add class "disable-gradient" to enable consistent background overlay -->
<div class="intro-banner" data-background-image="images/home-background.jpg">
	<div class="container">
		
		<!-- Intro Headline -->
		<div class="row">
			<div class="col-md-12">
				<div class="banner-headline">
					<h3>
						<strong>We bring people together. Love unites them...</strong>
					</h3>
				</div>
			</div>
		</div>
		
		<!-- Search Bar -->
		<div class="row">
			<div class="col-md-12">
				<div class="intro-banner-search-form margin-top-95">
						<!-- Search Field -->
						<div class="intro-search-field with-autocomplete">
							<label for="autocomplete-input" class="field-title ripple-effect">Where?</label>
							<div class="input-with-icon">
								<!-- <input id="autocomplete-input" type="text" placeholder="Online Job"> -->
								<select style="margin: 0px !important;padding: 0px 18px !important;" id="cityOptions">
									<option value="">Select City</option>
								</select>
							</div>
						</div>

						<!-- Search Field -->
						<div class="intro-search-field">
							<label for ="intro-keywords" class="field-title ripple-effect">What Service you want?</label>
							<!-- <select style="margin: 0px !important;padding: 0px 18px !important;" id="serviceOptions">
								<option>Select Services</option>
							</select> -->
							<input type="text" id="search_text" name="search_text" placeholder="Search Services" maxlength="20" style="box-shadow: 0 1px 4px 0 rgba(0, 0, 0, .12);">
						</div>
					<!-- Button -->
					<div class="intro-search-button">
						<button class="button ripple-effect search">Search</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>



<!-- Membership Plans -->
<div class="section padding-top-60 padding-bottom-75">
	<div class="container">
		<div class="row">


			<!-- Section Headline -->
			<div class="col-xl-12 col-md-12">
				<div class="section-headline centered margin-top-0 margin-bottom-45">
					<h3><strong>Recommended Services</strong></h3>
				</div>
			</div>

			<div class="col-xl-12 col-md-12">
				<!-- Tabs Container -->
				<div class="tabs">
					<div class="tabs-header" style="background: #ffa500 !important">
						<ul class="col-xl-12" style="width: auto !important;flex-wrap: nowrap !important;" id="recommands">
							<?php foreach ($recommands as $key => $value) { 
								if($key == 0){
									$active = 'active';
								}else{
									$active = '';
								}
								?>
								<li class="<?php echo $active;?>"><a class="font-weight" id="tabb-<?php echo $key;?>" href="#tab-<?php echo $key;?>" data-tab-id="<?php echo $key;?>"><?php echo $value['name'];?></a></li>	
							<?php }?>
						</ul>
						<div class="tab-hover"></div>
					</div>
					<!-- Tab Content -->
					<div class="tabs-content" id="tab-recommands">
						<div class="tab active" data-tab-id="0">
							<div class="section white padding-top-0 padding-bottom-10 full-width-carousel-fix">
								<div class="container">
									<div class="row">
										<div class="col-xl-12">
											<div class="blog-carousel1">
												<?php foreach ($recommands[0]['tab'] as $key => $value) { ?>
													<a href="<?php echo SITE_URL;?>/productlist?code=<?php echo $recommands[0]['id']."&scode=".$value['id'];?>" class="blog-compact-item-container">
														<div class="blog-compact-item">
															<img src="<?php echo SITE_URL ;?>/images/category/subcategory/<?php echo $value['image'] ;?>" alt="">
															<div class="blog-compact-item-content">
																
															</div>
														</div>
													</a>
												<?php } ?>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="tab active" data-tab-id="1">
							<div class="section white padding-top-0 padding-bottom-10 full-width-carousel-fix">
								<div class="container">
									<div class="row">
										<div class="col-xl-12">
											<div class="blog-carousel2">
												<?php foreach ($recommands[1]['tab'] as $key => $value) { ?>
													<a href="<?php echo SITE_URL;?>/productlist?code=<?php echo $recommands[1]['id']."&scode=".$value['id'];?>" class="blog-compact-item-container">
														<div class="blog-compact-item">
															<img src="<?php echo SITE_URL ;?>/images/category/subcategory/<?php echo $value['image'] ;?>" alt="">
															<div class="blog-compact-item-content">
																
															</div>
														</div>
													</a>
												<?php } ?>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="tab active" data-tab-id="2">
							<div class="section white padding-top-0 padding-bottom-10 full-width-carousel-fix">
								<div class="container">
									<div class="row">
										<div class="col-xl-12">
											<div class="blog-carousel3">
												<?php foreach ($recommands[2]['tab'] as $key => $value) { ?>
													<a href="<?php echo SITE_URL;?>/productlist?code=<?php echo $recommands[2]['id']."&scode=".$value['id'];?>" class="blog-compact-item-container">
														<div class="blog-compact-item">
															<img src="<?php echo SITE_URL ;?>/images/category/subcategory/<?php echo $value['image'] ;?>" alt="">
															<div class="blog-compact-item-content">
																
															</div>
														</div>
													</a>
												<?php } ?>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="tab active" data-tab-id="3">
							<div class="section white padding-top-0 padding-bottom-10 full-width-carousel-fix">
								<div class="container">
									<div class="row">
										<div class="col-xl-12">
											<div class="blog-carousel4">
												<?php foreach ($recommands[3]['tab'] as $key => $value) { ?>
													<a href="<?php echo SITE_URL;?>/productlist?code=<?php echo $recommands[3]['id']."&scode=".$value['id'];?>" class="blog-compact-item-container">
														<div class="blog-compact-item">
															<img src="<?php echo SITE_URL ;?>/images/category/subcategory/<?php echo $value['image'] ;?>" alt="">
															<div class="blog-compact-item-content">
																
															</div>
														</div>
													</a>
												<?php } ?>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="tab active" data-tab-id="4">
							<div class="section white padding-top-0 padding-bottom-10 full-width-carousel-fix">
								<div class="container">
									<div class="row">
										<div class="col-xl-12">
											<div class="blog-carousel5">
												<?php foreach ($recommands[4]['tab'] as $key => $value) { ?>
													<a href="<?php echo SITE_URL;?>/productlist?code=<?php echo $recommands[4]['id']."&scode=".$value['id'];?>" class="blog-compact-item-container">
														<div class="blog-compact-item">
															<img src="<?php echo SITE_URL ;?>/images/category/subcategory/<?php echo $value['image'] ;?>" alt="">
															<div class="blog-compact-item-content">
																
															</div>
														</div>
													</a>
												<?php } ?>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

				</div>
				<!-- Tabs Container / End -->
			</div>

		</div>
	</div>
</div>
<!-- Membership Plans / End-->



<!-- Popular Job Categories -->
<div class="section margin-top-65 margin-bottom-30">
	<div class="container">
		<div class="row" id="Categories">

			<!-- Section Headline -->
			<div class="col-xl-12">
				<div class="section-headline centered margin-top-0 margin-bottom-45">
					<h3><strong>All Categories</strong></h3>
				</div>
			</div>
			<?php foreach ($all_category as $key => $value) { ?>
			   <div class="col-xl-3 col-md-6">
			    <a href="<?php echo SITE_URL;?>/productlist?code=<?php echo $value['id']?>" class="photo-box small" data-background-image="<?php echo SITE_URL ;?>/images/category/<?php echo $value['image'] ;?>">
			     <div class="photo-box-content">
			      <h3 style="font-weight: 700px;font-size: 20px;"></h3>
			     </div>
			    </a>
			   </div>
		  	<?php } ?>
		</div>
	</div>
</div>
<!-- Features Cities / End -->

<?php if(count($services)){?>
<!-- Highest Rated Freelancers -->
<div class="section gray padding-top-65 padding-bottom-70 full-width-carousel-fix">
	<div class="container">
		<div class="row">

			<div class="col-xl-12">
				<!-- Section Headline -->
				<div class="section-headline margin-top-0 margin-bottom-25">
					<h3>Top Services</h3>
					
				</div>
			</div>

			<div class="col-xl-12">
				<div class="default-slick-carousel freelancers-container freelancers-grid-layout">

					<?php 
						foreach ($services as $key => $value) {
						
						if(isset($value['fname'])){
							$fname = $value['fname'];
						}else{
							$fname = '';
						}
						if(isset($value['fname'])){
							$lname = $value['lname'];
						}else{
							$lname = '';
						}
						
					?>
						<!--Freelancer -->
						<div class="freelancer">

							<!-- Overview -->
							<div class="freelancer-overview">
								<div class="freelancer-overview-inner">
									
									<!-- Avatar -->
									<div class="freelancer-avatar">
										<a href="javascript:;"><img src="images/services/<?php echo $value['image'];?>" alt="" style="height: 100px;width: 100px;"></a>
									</div>

									<!-- Name -->
									<div class="freelancer-name">
										<h4><a href="javascript:;"><?php echo $value['title'];?> <img class="flag" src="" alt="" title="United Kingdom" data-tippy-placement="top"></a></h4>
										<span><?php echo $fname.' '.$lname;?></span>
									</div>

									<!-- Rating -->
									<div class="freelancer-rating">
										<div class="star-rating" data-rating="<?php echo $value['rating'];?>"></div>
									</div>
								</div>
							</div>
							
							<!-- Details -->
							<div class="freelancer-details">
								<div class="freelancer-details-list">
									<ul>
										<li>Location <strong><i class="icon-material-outline-location-on"></i> <?php echo $value['cityName'];?></strong></li>
										<li>Price <strong>$<?php echo $value['price'];?></strong></li>
										<li>Job Success <strong>95%</strong></li>
									</ul>
								</div>
								<a href="<?php echo SITE_URL.'/product?uid='.$value['userid'].'&sid='.$value['id']?>" class="button button-sliding-icon ripple-effect">View Service <i class="icon-material-outline-arrow-right-alt"></i></a>
							</div>
						</div>
						<!-- Freelancer / End -->

					<?php } ?>
				</div>
			</div>

		</div>
	</div>
</div>
<!-- Highest Rated Freelancers / End-->
<?php }?>
<div class="section margin-top-65 margin-bottom-30">
	<div class="container">
		<div class="row">
			<div class="col-xl-12">
				<center><a href="<?php echo isset($_SESSION['id']) ? SITE_URL.'/orderrequest' : '#sign-in-dialog'?>" class="<?php echo !isset($_SESSION['id']) ? 'popup-with-zoom-anim log-in-button' : ''?>"><button class="button ripple-effect ">Get Free Quotes</button></a></center>
			</div>
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
<script src="https://unpkg.com/@pusher/chatkit/dist/web/chatkit.js"></script>
<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
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

<script>
$(window).on('load resize',function(){
	$('#tabb-1').trigger('click');
	$('.tabs').trigger('click');
	document.getElementById('preloader').style.display='none';
	document.getElementById('wrapper').style.display='block';
	
});	

$('.blog-carousel1').slick({
	infinite: false,
	slidesToShow: 3,
	slidesToScroll: 1,
	dots: false,
	arrows: true,
	responsive: [{
		breakpoint: 1365,
		settings: {
			slidesToShow: 3,
			dots: true,
			arrows: false
		}
	}, {
		breakpoint: 992,
		settings: {
			slidesToShow: 2,
			dots: true,
			arrows: false
		}
	}, {
		breakpoint: 768,
		settings: {
			slidesToShow: 1,
			dots: true,
			arrows: false
		}
	}]
});
$('.blog-carousel2').slick({
	infinite: false,
	slidesToShow: 3,
	slidesToScroll: 1,
	dots: false,
	arrows: true,
	responsive: [{
		breakpoint: 1365,
		settings: {
			slidesToShow: 3,
			dots: true,
			arrows: false
		}
	}, {
		breakpoint: 992,
		settings: {
			slidesToShow: 2,
			dots: true,
			arrows: false
		}
	}, {
		breakpoint: 768,
		settings: {
			slidesToShow: 1,
			dots: true,
			arrows: false
		}
	}]
});
$('.blog-carousel3').slick({
	infinite: false,
	slidesToShow: 3,
	slidesToScroll: 1,
	dots: false,
	arrows: true,
	responsive: [{
		breakpoint: 1365,
		settings: {
			slidesToShow: 3,
			dots: true,
			arrows: false
		}
	}, {
		breakpoint: 992,
		settings: {
			slidesToShow: 2,
			dots: true,
			arrows: false
		}
	}, {
		breakpoint: 768,
		settings: {
			slidesToShow: 1,
			dots: true,
			arrows: false
		}
	}]
});
$('.blog-carousel4').slick({
	infinite: false,
	slidesToShow: 3,
	slidesToScroll: 1,
	dots: false,
	arrows: true,
	responsive: [{
		breakpoint: 1365,
		settings: {
			slidesToShow: 3,
			dots: true,
			arrows: false
		}
	}, {
		breakpoint: 992,
		settings: {
			slidesToShow: 2,
			dots: true,
			arrows: false
		}
	}, {
		breakpoint: 768,
		settings: {
			slidesToShow: 1,
			dots: true,
			arrows: false
		}
	}]
});
$('.blog-carousel5').slick({
	infinite: false,
	slidesToShow: 3,
	slidesToScroll: 1,
	dots: false,
	arrows: true,
	responsive: [{
		breakpoint: 1365,
		settings: {
			slidesToShow: 3,
			dots: true,
			arrows: false
		}
	}, {
		breakpoint: 992,
		settings: {
			slidesToShow: 2,
			dots: true,
			arrows: false
		}
	}, {
		breakpoint: 768,
		settings: {
			slidesToShow: 1,
			dots: true,
			arrows: false
		}
	}]
});

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

$('.search').click(function(){
	var city = document.getElementById('cityOptions').value;
	var service = document.getElementById('search_text').value;
	if(city != "" && service != ""){
		window.location = "<?php echo SITE_URL;?>/searchproductlist?code="+service+'&cid='+city+'&pn=1';
	}else{
		swal("Oops", "Please Select City Or Services");
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

	$(function(){
		$.ajax({
			url: '<?php echo SITE_URL;?>/v1/services/index.php?service=city',
			type: 'GET',
			success: function(results){
				var results = JSON.parse(results);
				
				var output = ['<option value="">Select City</option>'];
				for (var i = 0; i < results.data.length; i++) {
					// console.log("results ::::::: ", results[i]);
					output.push('<option value="'+ results.data[i]['id'] +'">'+ results.data[i]['name'] +'</option>');
				}

				$('#cityOptions').html(output.join(''));
			},
			error: function(err){
				console.log("err :::::: ",err);
			}
		})
		
	})
	$('#cityOptions').change(function(event){
		var city = document.getElementById('cityOptions').value;
		$.ajax({
				url: '<?php echo SITE_URL;?>/v1/services/index.php?service=HomeSearch&cid='+city,
				type: 'GET',
				success: function(results){
					// console.log("results ::::::: ", results);
					var results = JSON.parse(results)['data']['category'];
					
					var output = ['<option value="">Select Services</option>'];
					for (var i = 0; i < results.length; i++) {
						output.push('<option value="'+ results[i]['id'] +'">'+ results[i]['name'] +'</option>');
						var image = (results[i]['image']) ? 'images/category/'+results[i]['image'] : '';
						console.log("image :::::: ", image);
						var category = 	'<div class="col-xl-3 col-md-6">'+
										'	<a href="<?php echo SITE_URL;?>/product?code='+results[i]['id']+'" class="photo-box small" data-background-image="'+image+'">'+
										'		<div class="photo-box-content">'+
										'			<h3 style="font-weight: 700px;font-size: 20px;">'+results[i]['name']+'</h3>'+
										'		</div>'+
										'	</a>'+
										'</div>'
						$('#Categories').append(category);
					}
					
					$('#serviceOptions').html(output.join(''));

					
				},
				error: function(err){
					console.log("err :::::: ",err);
				}
		})
	})
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
	  	else 
	  	{
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

	/*$.ajax({
			url: '<?php echo SITE_URL;?>/v1/services/service.php?service=services',
			type: 'GET',
			success: function(results){
				// console.log("results ::::::: ", results);
				var results = JSON.parse(results);
				
				var output = ['<option value="">Select Services</option>'];
				for (var i = 0; i < results.length; i++) {
					output.push('<option value="'+ results[i]['id'] +'">'+ results[i]['name'] +'</option>');

					var category = 	'<div class="col-xl-3 col-md-6">'+
									'	<a href="<?php echo SITE_URL;?>/product?code='+results[i]['id']+'" class="photo-box small" data-background-image="images/featured-city-0'+i+'.jpg">'+
									'		<div class="photo-box-content">'+
									'			<h3 style="font-weight: 700px;font-size: 20px;">'+results[i]['name']+'</h3>'+
									'		</div>'+
									'	</a>'+
									'</div>'
					$('#Categories').append(category);
				}
				
				$('#serviceOptions').html(output.join(''));

				
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


