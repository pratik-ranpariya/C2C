<?php 
include('notification_header.php');
//date_default_timezone_set('Pacific/Auckland');
 date_default_timezone_set('Asia/Kolkata');
 // define("SITE_URL", "http://dailyneeds.co.nz");
  define("SITE_URL", "http://localhost/mytest/dailyneeds/html/dailyneeds_web/");

if(!isset($_SESSION)) 
{ 
    session_start(); 
} 

$uri_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri_segments = explode('/', $uri_path)[1];

?>


<!-- Header Container
================================================== -->
<header id="header-container" class="fullwidth ">

	<!-- Header -->
	<div id="header" style="background-color: #ffa500 !important">
		<div class="container">
			
			<!-- Left Side Content -->
			<div class="left-side">
				
				<!-- Logo -->
				<div id="logo" style="padding-left: 20px !important">
					<a href="<?php echo SITE_URL;?>"><img src="images/logo.png" alt=""></a>
				</div>

				<!-- Main Navigation -->
				<nav id="navigation" style="float: right; margin-right: 40px;">
					<?php if (isset($_SESSION['logged_in'])) { ?>
						<ul id="responsive" style="margin-top: 8px;">
							<li><a href="<?php echo SITE_URL;?>" class="<?php echo ($uri_segments == '' || $uri_segments == 'Home') ? 'current' : '';?>">Home</a>
							</li>
							<li style="margin-right: -20px; margin-left: -20px;"><a href="javascript:;" class="aheader <?php echo $uri_segments == 'Services' ? 'current' : '';?>">Selling</a>
								<ul class="dropdown-nav" style="margin-top: 30px;">
									<li><a href="<?php echo SITE_URL;?>/orders" class="<?php echo $uri_segments == 'orders' ? 'current' : '';?>">My Jobs</a></li>
									<li><a href="<?php echo SITE_URL;?>/buyerrequest" class="<?php echo $uri_segments == 'buyerrequest' ? 'current' : '';?>">Buyer Requests</a></li>
								</ul>
							</li>
							<li style="margin-right: -20px; margin-left: -20px;"><a href="javascript:;" class="aheader <?php echo $uri_segments == 'Services' ? 'current' : '';?>">Buying</a>
								<ul class="dropdown-nav" style="margin-top: 30px;">
									<li><a href="<?php echo SITE_URL;?>/orderrequest" class="<?php echo $uri_segments == 'orderrequest' ? 'current' : '';?>">Post A Job</a></li>
									<li><a href="<?php echo SITE_URL;?>/orders_manage" class="<?php echo $uri_segments == 'orders_manage' ? 'current' : '';?>">Manage Jobs</a></li>
									<li><a href="<?php echo SITE_URL;?>/manage_requests" class="<?php echo $uri_segments == 'manage_requests' ? 'current' : '';?>">Manage Requests</a></li>
								</ul>
							</li>
							<li style="margin-right: -20px; margin-left: -20px;"><a href="javascript:;" class="aheader <?php echo $uri_segments == 'Services' ? 'current' : '';?>">Services</a>
								<ul class="dropdown-nav" style="margin-top: 30px;">
									<li><a href="<?php echo SITE_URL;?>/myservices" class="<?php echo $uri_segments == 'myservices' ? 'current' : '';?>">My Services</a></li>
									<li><a href="<?php echo SITE_URL;?>/addservices" class="<?php echo $uri_segments == 'addservices' ? 'current' : '';?>">Add Services</a></li>
								</ul>
							</li>
							<li><a href="<?php echo SITE_URL;?>/chat" class="aheader <?php echo $uri_segments == 'chat' ? 'current' : '';?>">Inbox</a></li>
							<li><a href="<?php echo SITE_URL;?>/contact" class="aheader <?php echo $uri_segments == 'contact' ? 'current' : '';?>">Contact</a>
							</li>

						</ul>
					<?php }else{?>
						<ul id="responsive" style="margin-top: 8px;">

							<li><a href="<?php echo SITE_URL;?>" class="aheader <?php echo $uri_segments == '' ? 'current' : '';?>">Home</a></li>

							<li><a href="#sign-in-dialog" class="popup-with-zoom-anim log-in-button">Login / Signup</a></li>

							<li><a href="<?php echo SITE_URL;?>/contact" class="aheader <?php echo $uri_segments == 'contact' ? 'current' : '';?>">Contact</a></li>

						</ul>
					<?php }?>
				</nav>
				<div class="clearfix"></div>
				<!-- Main Navigation / End -->
				
			</div>
			<!-- Left Side Content / End -->

			<?php if (isset($_SESSION['logged_in'])) { ?>
			<!-- Right Side Content / End -->
			<div class="right-side" style="background-color: #ffa500 !important;">

				<div class="header-widget hide-on-mobile">
					<div class="header-notifications">
						<div class="header-notifications-trigger">
							<a href="#"><i class="icon-feather-bell"></i></a>
						</div>
						<div class="header-notifications-dropdown">
							<div class="header-notifications-headline">
								<h4>Notifications</h4>
							</div>
							<div class="header-notifications-content">
								<div class="header-notifications-scroll" data-simplebar>
									<ul>
										<?php foreach ($notification as $value) { ?>
											<li class="notifications-not-read">
												<a href="<?php echo $value['link'];?>">
													<span class="notification-icon"><i class="icon-material-outline-group"></i></span>
													<span class="notification-text">
														<strong><?php echo $value['comments'];?></strong>
													</span>
												</a>
											</li>
										<?php }?>
									</ul>
								</div>
							</div>

						</div>

					</div>

				</div>

				<!-- User Menu -->
				<div class="header-widget" style="border: transparent !important;">

					<!-- Messages -->
					<div class="header-notifications user-menu">
						<div class="header-notifications-trigger">
							<a href="#">
								<div class="user-avatar <?php echo ($_SESSION['status'] == 'user-online') ? 'status-online' : '';?>">
									<img class="myprofile" src="<?php echo (isset($_SESSION['profile']) == '') ? $_SESSION['profile'] : 'images/user-avatar-placeholder.png';?>" alt="" style="height: 42px;">
								</div>
							</a>
						</div>

						<!-- Dropdown -->
						<div class="header-notifications-dropdown" style="margin-top: 20px;">

							<!-- User Status -->
							<div class="user-status">
								<!--  -->

								<!-- User Name / Avatar -->
								<div class="user-details">
									<div class="user-avatar <?php echo ($_SESSION['status'] == 'user-online') ? 'status-online' : '';?>"><img class="myprofile" src="<?php echo (isset($_SESSION['profile'])) ? 'images/upload/'.$_SESSION['profile'] : 'images/user-avatar-placeholder.png';?>" alt="" style="height: 42px;"></div>
									<div class="user-name">
										<?php echo $_SESSION['username'];?><span><?php echo $_SESSION['email'];?></span>
									</div>
								</div>
								
								<!-- User Status Switcher -->
								<div class="status-switch" id="snackbar-user-status">
									<label class="user-online <?php echo ($_SESSION['status'] == 'user-online') ? 'current-status' : '';?>">Online</label>
									<label class="user-invisible <?php echo ($_SESSION['status'] == 'user-invisible') ? 'current-status' : '';?>">Invisible</label>
									<!-- Status Indicator -->
									<span class="status-indicator <?php echo ($_SESSION['status'] == 'user-invisible') ? 'right' : '';?>" aria-hidden="true"></span>
								</div>	
						</div>
						
						<ul class="user-menu-small-nav">
							<li><a href="<?php echo SITE_URL;?>/profile"><i class="icon-material-outline-dashboard"></i> Profile</a></li>
							<li><a href="<?php echo SITE_URL;?>/logout"><i class="icon-material-outline-power-settings-new"></i> Logout</a></li>
						</ul>

						</div>
					</div>

				</div>
				<!-- User Menu / End -->

				<!-- Mobile Navigation Button -->
				<span class="mmenu-trigger">
					<button class="hamburger hamburger--collapse" type="button">
						<span class="hamburger-box">
							<span class="hamburger-inner"></span>
						</span>
					</button>
				</span>

			</div>
			<!-- Right Side Content / End -->
			<?php }?>

		</div>
	</div>
	<!-- Header / End -->

</header>
