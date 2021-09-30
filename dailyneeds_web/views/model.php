<?php 
	if(!isset($db)) 
	{ 
	    include("v1/config.php");
	} 

	if(!isset($_SESSION)) 
	{ 
	    session_start(); 
	} 

	$sql = "SELECT * FROM city";
	$result = mysqli_query($db, $sql);
	$cities = mysqli_fetch_all($result,MYSQLI_ASSOC);
?>
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
						<input type="email" class="input-text with-border" name="email" id="emailaddress" placeholder="Email Address" required/>
					</div>

					<div class="input-with-icon-left">
						<i class="icon-material-outline-lock"></i>
						<input type="password" class="input-text with-border" name="password" id="password" placeholder="Password" required/>
					</div>
					<a href="javascript:;" onclick="phone_btn_onclick();" class="forgot-password">Forgot Password?</a>
					<a href="#small-dialog-4"  class="popup-with-zoom-anim log-in-button forgot-password" hidden></a>
				</form>
				
				<!-- Button -->
				<button class="button full-width button-sliding-icon ripple-effect" type="submit" form="login-form">Log In <i class="icon-material-outline-arrow-right-alt"></i></button>
				
				

			</div>

			<!-- Register -->
			<div class="popup-tab-content" id="register">
				
				<!-- Welcome Text -->
				<div class="welcome-text">
					<h3>Let's create your account!</h3>
				</div>

				<form id="register-account-form" enctype="multipart/form-data" method="post">
					<div class="input-with-icon-left">
						<i class="icon-feather-user"></i>
						<input type="text" class="input-text with-border" name="username" id="emailaddress-register" placeholder="Enter User Name" minlength="3" required/>
					</div>
					<div class="input-with-icon-left">
						<i class="icon-material-baseline-mail-outline"></i>
						<input type="email" class="input-text with-border" name="email" id="emailaddress-register" placeholder="Enter Email Address" required/>
					</div>
					<div class="input-with-icon-left">
						<i class="icon-feather-phone"></i>
						<input type="number"  class="input-text with-border" name="mobile" id="emailaddress-rgstr" placeholder="Enter Mobile Number" minlength="10" maxlength="10" hidden>
						
					</div>

					<div class="input-with-icon-left">
						<i class="icon-material-outline-location-city"></i>
						<div style="padding-left: 45px;">
							<select name="city" class="input-text with-border" placeholder="Enter City" style="padding-bottom: 10px;" required>
								<option value="">Select City</option>
								<?php foreach ($cities as $value) {?>
									<option value="<?php echo $value['id'];?>"><?php echo $value['name'];?></option>
								<?php }?>
							</select>
						</div>
					</div>

					<div class="input-with-icon-left" title="Should be at least 8 characters long" data-tippy-placement="bottom">
						<i class="icon-material-outline-lock"></i>
						<input type="password" class="input-text with-border" name="password" id="password-register" placeholder="Password" minlength="6" required/>
					</div>
					<div class="uploadButton margin-top-30">
						<input class="uploadButton-input" type="file" accept="image/*" id="upload" name="file">
						<label class="uploadButton-button ripple-effect" for="upload">Upload Profile Picture</label>
						<span class="uploadButton-file-name">Images or documents that might be helpful in describing your job</span>
					</div>
				

				   <input type="checkbox" name="checkbox" style="width: 25px; height: 25px;" required> <font color="orange"> I accept the</font> <a href="t&c.php"><u>Terms and Conditions</u></a>
				
				<!-- Button -->
				<button class="margin-top-10 button full-width button-sliding-icon ripple-effect" type="submit" form="register-account-form">Register <i class="icon-material-outline-arrow-right-alt"></i></button>
                  </form>

			</div>
		</div>
	</div>
</div>
<!-- Sign In Popup / End -->

<div id="small-dialog-4" class="zoom-anim-dialog mfp-hide dialog-with-tabs">

	<!--Tabs -->
	<div class="sign-in-form">

		<ul class="popup-tabs-nav">
		</ul>

		<div class="popup-tabs-container">

			<!-- Tab -->
			<div class="popup-tab-content" id="tab2">
				
				<!-- Welcome Text -->
				<div class="welcome-text">
					<h3>Forget Password!</h3>
					<span>Have you remember? <a href="#sign-in-dialog" class="popup-with-zoom-anim log-in-button">Login!</a></span>
				</div>
					
				<!-- Form -->
				<form method="post" id="forget-form" oninput="result.value=!!cpassword.value&&(password.value==cpassword.value)?'Match!':'Nope!'">
					<div class="input-with-icon-left" title="Should be at least 8 characters long" data-tippy-placement="bottom">
						<i class="icon-material-outline-lock"></i>
						<input type="password" class="input-text with-border" name="password" id="forget-npassword" placeholder="Enter New Password" minlength="6" required/>
					</div>
					<input type="text" name="mobile_no" id="forget-mobile-no" hidden>
					<div class="input-with-icon-left" title="Should be at least 8 characters long" data-tippy-placement="bottom">
						<i class="icon-material-outline-lock"></i>
						<input type="password" class="input-text with-border" name="cpassword" id="forget-ncpassword" placeholder="Enter Confirm Password" minlength="6" required/>
					</div>
					<output name="result"></output>
				</form>		
				
				<!-- Button -->
				<button class="button full-width button-sliding-icon ripple-effect" type="submit" form="forget-form">Submit <i class="icon-material-outline-arrow-right-alt"></i></button>

			</div>

		</div>
	</div>
</div>

<script src="https://sdk.accountkit.com/en_US/sdk.js"></script>
<script type="text/javascript">

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
