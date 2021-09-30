<?php
session_start();
?>
<!doctype html>
<html lang="en">
<head>

<!-- Basic Page Needs
================================================== -->
<title>DailyNeeds | Home</title>
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
<a href="#small-dialog-1" id="small-dia" class="popup-with-zoom-anim log-in-button"></a>
<!-- Wrapper -->
<div id="wrapper">

<!-- Header Container
================================================== -->
<?php include("views/header.php");?>
<?php include("views/session.php");?>
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
						<select style="margin: 0px !important;padding: 0px 18px !important;" id="serviceOptions">
							<option>Select Services</option>
						</select>
						<!-- <input id="intro-keywords" type="text" placeholder="Job Title or Keywords"> -->
					</div>

					<!-- Button -->
					<div class="intro-search-button">
						<button class="button ripple-effect" onclick="window.location.href='jobs-list-layout-full-page-map.html'">Search</button>
					</div>
				</div>
			</div>
		</div>

		<!-- Stats -->
		<!-- <div class="row">
			<div class="col-md-12">
				<ul class="intro-stats margin-top-45 hide-under-992px">
					<li>
						<strong class="counter">1,586</strong>
						<span>Jobs Posted</span>
					</li>
					<li>
						<strong class="counter">3,543</strong>
						<span>Tasks Posted</span>
					</li>
					<li>
						<strong class="counter">1,232</strong>
						<span>Freelancers</span>
					</li>
				</ul>
			</div>
		</div> -->

	</div>
</div>



<!-- Membership Plans -->
<div class="section padding-top-60 padding-bottom-75">
	<div class="container">
		<div class="row">


			<!-- Section Headline -->
			<div class="col-xl-12 col-md-12">
				<div class="section-headline centered margin-top-0 margin-bottom-45">
					<h3>Recommended</h3>
				</div>
			</div>

			<div class="col-xl-12 col-md-12">
				<!-- Tabs Container -->
				<div class="tabs">
					<div class="tabs-header" style="background: #ffa500 !important">
						<ul class="col-xl-12" style="width: auto !important;flex-wrap: nowrap !important;" id="recommands">
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
											<div class="blog-carousel" id="tabs-anchor0">
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
											<div class="blog-carousel" id="tabs-anchor1">
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
											<div class="blog-carousel" id="tabs-anchor2">
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
											<div class="blog-carousel" id="tabs-anchor3">
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
											<div class="blog-carousel" id="tabs-anchor4">
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
					<h3>All Categories</h3>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Features Cities / End -->


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

					<!--Freelancer -->
					<div class="freelancer">

						<!-- Overview -->
						<div class="freelancer-overview">
							<div class="freelancer-overview-inner">
								
								<!-- Bookmark Icon -->
								<span class="bookmark-icon"></span>
								
								<!-- Avatar -->
								<div class="freelancer-avatar">
									<div class="verified-badge"></div>
									<a href="single-freelancer-profile.html"><img src="images/user-avatar-big-01.jpg" alt=""></a>
								</div>

								<!-- Name -->
								<div class="freelancer-name">
									<h4><a href="single-freelancer-profile.html">Tom Smith <img class="flag" src="" alt="" title="United Kingdom" data-tippy-placement="top"></a></h4>
									<span>UI/UX Designer</span>
								</div>

								<!-- Rating -->
								<div class="freelancer-rating">
									<div class="star-rating" data-rating="5.0"></div>
								</div>
							</div>
						</div>
						
						<!-- Details -->
						<div class="freelancer-details">
							<div class="freelancer-details-list">
								<ul>
									<li>Location <strong><i class="icon-material-outline-location-on"></i> London</strong></li>
									<li>Rate <strong>$60 / hr</strong></li>
									<li>Job Success <strong>95%</strong></li>
								</ul>
							</div>
							<a href="single-freelancer-profile.html" class="button button-sliding-icon ripple-effect">View Profile <i class="icon-material-outline-arrow-right-alt"></i></a>
						</div>
					</div>
					<!-- Freelancer / End -->

					<!--Freelancer -->
					<div class="freelancer">

						<!-- Overview -->
						<div class="freelancer-overview">
							<div class="freelancer-overview-inner">
								
								<!-- Bookmark Icon -->
								<span class="bookmark-icon"></span>
								
								<!-- Avatar -->
								<div class="freelancer-avatar">
									<div class="verified-badge"></div>
									<a href="single-freelancer-profile.html"><img src="images/user-avatar-big-02.jpg" alt=""></a>
								</div>

								<!-- Name -->
								<div class="freelancer-name">
									<h4><a href="#">David Peterson <img class="flag" src="" alt="" title="Germany" data-tippy-placement="top"></a></h4>
									<span>iOS Expert + Node Dev</span>
								</div>

								<!-- Rating -->
								<div class="freelancer-rating">
									<div class="star-rating" data-rating="5.0"></div>
								</div>
							</div>
						</div>
						
						<!-- Details -->
						<div class="freelancer-details">
							<div class="freelancer-details-list">
								<ul>
									<li>Location <strong><i class="icon-material-outline-location-on"></i> Berlin</strong></li>
									<li>Rate <strong>$40 / hr</strong></li>
									<li>Job Success <strong>88%</strong></li>
								</ul>
							</div>
							<a href="single-freelancer-profile.html" class="button button-sliding-icon ripple-effect">View Profile <i class="icon-material-outline-arrow-right-alt"></i></a>
						</div>
					</div>
					<!-- Freelancer / End -->

					<!--Freelancer -->
					<div class="freelancer">

						<!-- Overview -->
						<div class="freelancer-overview">
							<div class="freelancer-overview-inner">
								<!-- Bookmark Icon -->
								<span class="bookmark-icon"></span>
								
								<!-- Avatar -->
								<div class="freelancer-avatar">
									<a href="single-freelancer-profile.html"><img src="images/user-avatar-placeholder.png" alt=""></a>
								</div>

								<!-- Name -->
								<div class="freelancer-name">
									<h4><a href="#">Marcin Kowalski <img class="flag" src="" alt="" title="Poland" data-tippy-placement="top"></a></h4>
									<span>Front-End Developer</span>
								</div>

								<!-- Rating -->
								<div class="freelancer-rating">
									<div class="star-rating" data-rating="4.9"></div>
								</div>
							</div>
						</div>
						
						<!-- Details -->
						<div class="freelancer-details">
							<div class="freelancer-details-list">
								<ul>
									<li>Location <strong><i class="icon-material-outline-location-on"></i> Warsaw</strong></li>
									<li>Rate <strong>$50 / hr</strong></li>
									<li>Job Success <strong>100%</strong></li>
								</ul>
							</div>
							<a href="single-freelancer-profile.html" class="button button-sliding-icon ripple-effect">View Profile <i class="icon-material-outline-arrow-right-alt"></i></a>
						</div>
					</div>
					<!-- Freelancer / End -->

					<!--Freelancer -->
					<div class="freelancer">

						<!-- Overview -->
						<div class="freelancer-overview">
								<div class="freelancer-overview-inner">
								<!-- Bookmark Icon -->
								<span class="bookmark-icon"></span>
								
								<!-- Avatar -->
								<div class="freelancer-avatar">
									<div class="verified-badge"></div>
									<a href="single-freelancer-profile.html"><img src="images/user-avatar-big-03.jpg" alt=""></a>
								</div>

								<!-- Name -->
								<div class="freelancer-name">
									<h4><a href="#">Sindy Forest <img class="flag" src="" alt="" title="Australia" data-tippy-placement="top"></a></h4>
									<span>Magento Certified Developer</span>
								</div>

								<!-- Rating -->
								<div class="freelancer-rating">
									<div class="star-rating" data-rating="5.0"></div>
								</div>
							</div>
						</div>
						
						<!-- Details -->
						<div class="freelancer-details">
							<div class="freelancer-details-list">
								<ul>
									<li>Location <strong><i class="icon-material-outline-location-on"></i> Brisbane</strong></li>
									<li>Rate <strong>$70 / hr</strong></li>
									<li>Job Success <strong>100%</strong></li>
								</ul>
							</div>
							<a href="single-freelancer-profile.html" class="button button-sliding-icon ripple-effect">View Profile <i class="icon-material-outline-arrow-right-alt"></i></a>
						</div>
					</div>
					<!-- Freelancer / End -->
					
					<!--Freelancer -->
					<div class="freelancer">

						<!-- Overview -->
						<div class="freelancer-overview">
								<div class="freelancer-overview-inner">
								<!-- Bookmark Icon -->
								<span class="bookmark-icon"></span>
								
								<!-- Avatar -->
								<div class="freelancer-avatar">
									<a href="single-freelancer-profile.html"><img src="images/user-avatar-placeholder.png" alt=""></a>
								</div>

								<!-- Name -->
								<div class="freelancer-name">
									<h4><a href="#">Sebastiano Piccio <img class="flag" src="" alt="" title="Italy" data-tippy-placement="top"></a></h4>
									<span>Laravel Dev</span>
								</div>

								<!-- Rating -->
								<div class="freelancer-rating">
									<div class="star-rating" data-rating="4.5"></div>
								</div>
							</div>
						</div>
						
						<!-- Details -->
						<div class="freelancer-details">
							<div class="freelancer-details-list">
								<ul>
									<li>Location <strong><i class="icon-material-outline-location-on"></i> Milan</strong></li>
									<li>Rate <strong>$80 / hr</strong></li>
									<li>Job Success <strong>89%</strong></li>
								</ul>
							</div>
							<a href="single-freelancer-profile.html" class="button button-sliding-icon ripple-effect">View Profile <i class="icon-material-outline-arrow-right-alt"></i></a>
						</div>
					</div>
					<!-- Freelancer / End -->
								
					<!--Freelancer -->
					<div class="freelancer">

						<!-- Overview -->
						<div class="freelancer-overview">
								<div class="freelancer-overview-inner">
								<!-- Bookmark Icon -->
								<span class="bookmark-icon"></span>
								
								<!-- Avatar -->
								<div class="freelancer-avatar">
									<a href="single-freelancer-profile.html"><img src="images/user-avatar-placeholder.png" alt=""></a>
								</div>

								<!-- Name -->
								<div class="freelancer-name">
									<h4><a href="#">Gabriel Lagueux <img class="flag" src="" alt="" title="France" data-tippy-placement="top"></a></h4>
									<span>WordPress Expert</span>
								</div>

								<!-- Rating -->
								<div class="freelancer-rating">
									<div class="star-rating" data-rating="5.0"></div>
								</div>
							</div>
						</div>
						
						<!-- Details -->
						<div class="freelancer-details">
							<div class="freelancer-details-list">
								<ul>
									<li>Location <strong><i class="icon-material-outline-location-on"></i> Paris</strong></li>
									<li>Rate <strong>$50 / hr</strong></li>
									<li>Job Success <strong>100%</strong></li>
								</ul>
							</div>
							<a href="single-freelancer-profile.html" class="button button-sliding-icon ripple-effect">View Profile <i class="icon-material-outline-arrow-right-alt"></i></a>
						</div>
					</div>
					<!-- Freelancer / End -->


				</div>
			</div>

		</div>
	</div>
</div>
<!-- Highest Rated Freelancers / End-->


<!-- Footer
================================================== -->
<div id="footer">
	
	<!-- Footer Top Section -->
	<div class="footer-top-section">
		<div class="container">
			<div class="row">
				<div class="col-xl-12">

					<!-- Footer Rows Container -->
					<div class="footer-rows-container">
						
						<!-- Left Side -->
						<div class="footer-rows-left">
							<div class="footer-row">
								<div class="footer-row-inner footer-logo">
									<img src="images/logo2.png" alt="">
								</div>
							</div>
						</div>
						
						<!-- Right Side -->
						<div class="footer-rows-right">

							<!-- Social Icons -->
							<div class="footer-row">
								<div class="footer-row-inner">
									<ul class="footer-social-links">
										<li>
											<a href="#" title="Facebook" data-tippy-placement="bottom" data-tippy-theme="light">
												<i class="icon-brand-facebook-f"></i>
											</a>
										</li>
										<li>
											<a href="#" title="Twitter" data-tippy-placement="bottom" data-tippy-theme="light">
												<i class="icon-brand-twitter"></i>
											</a>
										</li>
										<li>
											<a href="#" title="Google Plus" data-tippy-placement="bottom" data-tippy-theme="light">
												<i class="icon-brand-google-plus-g"></i>
											</a>
										</li>
										<li>
											<a href="#" title="LinkedIn" data-tippy-placement="bottom" data-tippy-theme="light">
												<i class="icon-brand-linkedin-in"></i>
											</a>
										</li>
									</ul>
									<div class="clearfix"></div>
								</div>
							</div>
							
							<!-- Language Switcher -->
							<div class="footer-row">
								<div class="footer-row-inner">
									<select class="selectpicker language-switcher" data-selected-text-format="count" data-size="5">
										<option selected>English</option>
										<option>Français</option>
										<option>Español</option>
										<option>Deutsch</option>
									</select>
								</div>
							</div>
						</div>

					</div>
					<!-- Footer Rows Container / End -->
				</div>
			</div>
		</div>
	</div>
	<!-- Footer Top Section / End -->

	<!-- Footer Middle Section -->
	<div class="footer-middle-section">
		<div class="container">
			<div class="row">

				<!-- Links -->
				<div class="col-xl-2 col-lg-2 col-md-3">
					<div class="footer-links">
						<h3>For Candidates</h3>
						<ul>
							<li><a href="#"><span>Browse Jobs</span></a></li>
							<li><a href="#"><span>Add Resume</span></a></li>
							<li><a href="#"><span>Job Alerts</span></a></li>
							<li><a href="#"><span>My Bookmarks</span></a></li>
						</ul>
					</div>
				</div>

				<!-- Links -->
				<div class="col-xl-2 col-lg-2 col-md-3">
					<div class="footer-links">
						<h3>For Employers</h3>
						<ul>
							<li><a href="#"><span>Browse Candidates</span></a></li>
							<li><a href="#"><span>Post a Job</span></a></li>
							<li><a href="#"><span>Post a Task</span></a></li>
							<li><a href="#"><span>Plans & Pricing</span></a></li>
						</ul>
					</div>
				</div>

				<!-- Links -->
				<div class="col-xl-2 col-lg-2 col-md-3">
					<div class="footer-links">
						<h3>Helpful Links</h3>
						<ul>
							<li><a href="#"><span>Contact</span></a></li>
							<li><a href="#"><span>Privacy Policy</span></a></li>
							<li><a href="#"><span>Terms of Use</span></a></li>
						</ul>
					</div>
				</div>

				<!-- Links -->
				<div class="col-xl-2 col-lg-2 col-md-3">
					<div class="footer-links">
						<h3>Account</h3>
						<ul>
							<li><a href="#"><span>Log In</span></a></li>
							<li><a href="#"><span>My Account</span></a></li>
						</ul>
					</div>
				</div>

				<!-- Newsletter -->
				<div class="col-xl-4 col-lg-4 col-md-12">
					<h3><i class="icon-feather-mail"></i> Sign Up For a Newsletter</h3>
					<p>Weekly breaking news, analysis and cutting edge advices on job searching.</p>
					<form action="#" method="get" class="newsletter">
						<input type="text" name="fname" placeholder="Enter your email address">
						<button type="submit"><i class="icon-feather-arrow-right"></i></button>
					</form>
				</div>
			</div>
		</div>
	</div>
	<!-- Footer Middle Section / End -->
	
	<!-- Footer Copyrights -->
	<div class="footer-bottom-section">
		<div class="container">
			<div class="row">
				<div class="col-xl-12">
					© 2018 <strong>DailyNeeds</strong>. All Rights Reserved.
				</div>
			</div>
		</div>
	</div>
	<!-- Footer Copyrights / End -->

</div>
<!-- Footer / End -->

</div>
<!-- Wrapper / End -->


<!-- Sign In Popup
================================================== -->
<div id="sign-in-dialog" class="zoom-anim-dialog mfp-hide dialog-with-tabs">

	<!--Tabs -->
	<div class="sign-in-form">

		<ul class="popup-tabs-nav">
			<li><a href="#login">Log In</a></li>
			<li><a href="#register">Register</a></li>
		</ul>

		<div class="popup-tabs-container">

			<!-- Login -->
			<div class="popup-tab-content" id="login">
				
				<!-- Welcome Text -->
				<div class="welcome-text">
					<h3>We're glad to see you again!</h3>
					<span>Don't have an account? <a href="#" class="register-tab">Sign Up!</a></span>
				</div>
					
				<!-- Form -->
				<form method="post" id="login-form">
					<div class="input-with-icon-left">
						<i class="icon-material-baseline-mail-outline"></i>
						<input type="text" class="input-text with-border" name="emailaddress" id="emailaddress" placeholder="Email Address" required/>
					</div>

					<div class="input-with-icon-left">
						<i class="icon-material-outline-lock"></i>
						<input type="password" class="input-text with-border" name="password" id="password" placeholder="Password" required/>
					</div>
					<a href="#" class="forgot-password">Forgot Password?</a>
				</form>
				
				<!-- Button -->
				<button class="button full-width button-sliding-icon ripple-effect" type="submit" form="login-form">Log In <i class="icon-material-outline-arrow-right-alt"></i></button>
				
				<!-- Social Login -->
				<div class="social-login-separator"><span>or</span></div>
				

			</div>

			<!-- Register -->
			<div class="popup-tab-content" id="register">
				
				<!-- Welcome Text -->
				<div class="welcome-text">
					<h3>Let's create your account!</h3>
				</div>

					
				<form id="register-account-form" enctype="multipart/form-data" method="post">
					<div class="input-with-icon-left">
						<i class="icon-material-baseline-mail-outline"></i>
						<input type="text" class="input-text with-border" name="username" id="emailaddress-register" placeholder="Enter User Name" required/>
					</div>
					<div class="input-with-icon-left">
						<i class="icon-material-baseline-mail-outline"></i>
						<input type="text" class="input-text with-border" name="email" id="emailaddress-register" placeholder="Enter Email Address" required/>
					</div>
					<div class="input-with-icon-left">
						<i class="icon-material-baseline-mail-outline"></i>
						<input type="text" class="input-text with-border" name="mobile" id="emailaddress-register" placeholder="Enter Mobile Number" required/>
					</div>

					<div class="input-with-icon-left">
						<i class="icon-material-baseline-mail-outline"></i>
						<input type="text" class="input-text with-border" name="city" id="emailaddress-register" placeholder="Enter City" required/>
					</div>

					<div class="input-with-icon-left" title="Should be at least 8 characters long" data-tippy-placement="bottom">
						<i class="icon-material-outline-lock"></i>
						<input type="password" class="input-text with-border" name="password" id="password-register" placeholder="Password" required/>
					</div>
					<div class="uploadButton margin-top-30">
						<input class="uploadButton-input" type="file" accept="image/*" id="upload" name="file">
						<label class="uploadButton-button ripple-effect" for="upload">Upload Profile Picture</label>
						<span class="uploadButton-file-name">Images or documents that might be helpful in describing your job</span>
					</div>
				</form>
				
				<!-- Button -->
				<button class="margin-top-10 button full-width button-sliding-icon ripple-effect" type="submit" form="register-account-form">Register <i class="icon-material-outline-arrow-right-alt"></i></button>

			</div>

		</div>
	</div>
</div>
<!-- Sign In Popup / End -->

<!-- Edit Review Popup
================================================== -->
<div id="small-dialog-1" class="zoom-anim-dialog mfp-hide dialog-with-tabs">

	<!--Tabs -->
	<div class="sign-in-form">

		<ul class="popup-tabs-nav">
		</ul>

		<div class="popup-tabs-container">

			<!-- Tab -->
			<div class="popup-tab-content" id="tab1">
				
				<!-- Welcome Text -->
				<div class="welcome-text">
					<h3 id="successmsg"></h3>
				</div>
					
				<button class="button full-width button-sliding-icon ripple-effect" type="submit" form="change-review-form">Save Changes <i class="icon-material-outline-arrow-right-alt"></i></button>

			</div>

		</div>
	</div>
</div>
<!-- Edit Review Popup / End -->


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

	$(function(){
		$.ajax({
			url: 'http://localhost/dailyNeeds/v1/services/index.php?service=city',
			type: 'GET',
			success: function(results){
				var results = JSON.parse(results);
				
				var output = ['<option value="">Select City</option>'];
				for (var i = 0; i < results.length; i++) {
					console.log("results ::::::: ", results[i]);
					output.push('<option value="'+ results[i]['id'] +'">'+ results[i]['name'] +'</option>');
				}

				$('#cityOptions').html(output.join(''));
			},
			error: function(err){
				console.log("err :::::: ",err);
			}
		})
		
	})

	$.ajax({
			url: 'http://localhost/dailyNeeds/v1/services/index.php?service=services',
			type: 'GET',
			success: function(results){
				console.log("results ::::::: ", results);
				var results = JSON.parse(results);
				
				var output = ['<option value="">Select Services</option>'];
				for (var i = 0; i < results.length; i++) {
					output.push('<option value="'+ results[i]['id'] +'">'+ results[i]['name'] +'</option>');

					var category = 	'<div class="col-xl-3 col-md-6">'+
									'	<a href="jobs-list-layout-1.html" class="photo-box small" data-background-image="images/featured-city-0'+i+'.jpg">'+
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

	$.ajax({
			url: 'http://localhost/dailyNeeds/v1/services/index.php?service=recommands',
			type: 'GET',
			success: function(results){
				console.log("results ::::::: ", results);
				var results = JSON.parse(results);
				var tabs = [];
				var output = ['<option value="">Select Services</option>'];
				for (var i = 0; i < results['recommands'].length; i++) {
					var active = i==0 ? 'active' : '';
					$('#recommands').append('<li class="'+active+'"><a class="font-weight" href="#tab-'+i+'" data-tab-id="'+i+'">'+results['recommands'][i].name+'</a></li>');
					
					for (var j = 0; j < results.tab_recommands.length; j++) {
						console.log(results.tab_recommands[j]['category'] +"=="+ results['recommands'][i].id);
						if(results.tab_recommands[j]['category'] == results['recommands'][i].id){
							
							var tabs = 	'<a href="pages-blog-post.html" class="blog-compact-item-container">'+
										'	<div class="blog-compact-item">'+
										'		<img src="images/'+results.tab_recommands[j]['image']+'" alt="">'+
										'		<div class="blog-compact-item-content">'+
										'			<ul class="blog-post-tags">'+
										'				<li></li>'+
										'			</ul>'+
										'			<h3>'+results.tab_recommands[j]['name']+'</h3>'+
										'			<p></p>'+
										'		</div>'+
										'	</div>'+
										'</a>';

								$('#tabs-anchor'+i).append(tabs);
						}
					}
				}
			},
			error: function(err){
				console.log("err :::::: ",err);
			}
		})


</script>

<!-- Google API -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAgeuuDfRlweIs7D6uo4wdIHVvJ0LonQ6g&libraries=places&callback=initAutocomplete"></script>

</body>
</html>


