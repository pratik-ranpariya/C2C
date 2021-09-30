<?php 
	if(!isset($_SESSION)) 
	{ 
	    session_start(); 
	}
?>
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

				<div class="col-xl-2 col-lg-2 col-md-3">
					<div class="footer-links">
						<h3>Helpful Links</h3>
						<ul>
							<li><a href="<?php echo SITE_URL;?>/contact"><span>Contact</span></a></li>
							<li><a href="<?php echo SITE_URL;?>/t&c"><span>Terms and Conditions</span></a></li>
							<li><a href="<?php echo SITE_URL;?>/privacy"><span>Privacy Policy</span></a></li>
							<li><a href="<?php echo SITE_URL;?>/copyright"><span>Copyright Policy</span></a></li>
						</ul>
					</div>
				</div>


				<!-- Links -->
				<?php if (isset($_SESSION['id'])) { ?>
				<div class="col-xl-2 col-lg-2 col-md-3">
					<div class="footer-links">
						<h3>Account</h3>
						<ul>
							<li><a href="<?php echo SITE_URL;?>/profile"><span>My Account</span></a></li>
						</ul>
					</div>
				</div>
				<?php }else{?>
					<div class="col-xl-2 col-lg-2 col-md-3">
					<div class="footer-links">
						<h3>Account</h3>
						<ul>
							<li><a href="#sign-in-dialog" class="popup-with-zoom-anim log-in-button" ><span>Log In</span></a></li>
						</ul>
					</div>
				</div>
				<?php }?>
			</div>
		</div>
	</div>
	<!-- Footer Middle Section / End -->


</div>
<!-- Footer / End -->