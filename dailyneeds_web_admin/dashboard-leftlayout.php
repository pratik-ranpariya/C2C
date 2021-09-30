<?php 
	if(!isset($_SESSION)){
		session_start();
	}

?>
<!-- Dashboard Sidebar
	================================================== -->
	<div class="dashboard-sidebar">
		<div class="dashboard-sidebar-inner" data-simplebar>
			<div class="dashboard-nav-container">

				<!-- Responsive Navigation Trigger -->
				<a href="#" class="dashboard-responsive-nav-trigger" hidden>
					<span class="hamburger hamburger--collapse" >
						<span class="hamburger-box">
							<span class="hamburger-inner"></span>
						</span>
					</span>
					<span class="trigger-title">Dashboard Navigation</span>
				</a>
				
				<!-- Navigation -->
				<div class="dashboard-nav">
					<div class="dashboard-nav-inner">
						
						<ul data-submenu-title="Organize and Manage">
							<li class="<?php echo (isset($_SESSION['activeTab']) && $_SESSION['activeTab'] == 'userlist') ? 'active' : '';?>" ><a href="<?php echo URL.'userlist';?>"><i class="icon-feather-user"></i> UserList</a></li>
						</ul>

						<ul data-submenu-title="Account">
							<li><a href="<?php echo URL.'/logout';?>"><i class="icon-material-outline-power-settings-new"></i> Logout</a></li>
						</ul>
						
					</div>
				</div>
				<!-- Navigation / End -->

			</div>
		</div>
	</div>
	<!-- Dashboard Sidebar / End -->