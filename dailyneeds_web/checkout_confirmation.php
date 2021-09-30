<?php include('checkout_orderData.php'); 

?>
<!doctype html>
<html lang="en">
<head>

<!-- Basic Page Needs
================================================== -->
<title>DailyNeeds | Offer Checkout</title>
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



.wrap {
z-index: 999999999;
  position: absolute;
  top: 50%;
  left: 50%;
  -webkit-transform: translate(-50%, -50%);
          transform: translate(-50%, -50%);
}

.text {
  color: #fbae17;
  display: inline-block;
  margin-left: 5px;
}

.bounceball {
  position: relative;
  display: inline-block;
  height: 37px;
  width: 15px;
}
.bounceball:before {
  position: absolute;
  content: '';
  display: block;
  top: 0;
  width: 15px;
  height: 15px;
  border-radius: 50%;
  background-color: #fbae17;
  -webkit-transform-origin: 50%;
          transform-origin: 50%;
  -webkit-animation: bounce 500ms alternate infinite ease;
          animation: bounce 500ms alternate infinite ease;
}

@-webkit-keyframes bounce {
  0% {
    top: 30px;
    height: 5px;
    border-radius: 60px 60px 20px 20px;
    -webkit-transform: scaleX(2);
            transform: scaleX(2);
  }
  35% {
    height: 15px;
    border-radius: 50%;
    -webkit-transform: scaleX(1);
            transform: scaleX(1);
  }
  100% {
    top: 0;
  }
}

@keyframes bounce {
  0% {
    top: 30px;
    height: 5px;
    border-radius: 60px 60px 20px 20px;
    -webkit-transform: scaleX(2);
            transform: scaleX(2);
  }
  35% {
    height: 15px;
    border-radius: 50%;
    -webkit-transform: scaleX(1);
            transform: scaleX(1);
  }
  100% {
    top: 0;
  }
}

.blur-filter {
    -webkit-filter: blur(2px);
    -moz-filter: blur(2px);
    -o-filter: blur(2px);
    -ms-filter: blur(2px);
    filter: blur(200px);
    overflow: hidden;
    height: 100%;
}

.bodydisable {
    height: '100%';
    overflow: 'hidden';
    width: '100%';
}
.simplebar-scroll-content{
	min-height: 650px !important;
}
</style>
</head>
<body>

<div class="wrap" style="display: none;">
  <div class="loading">
    <div class="bounceball"></div>
    <div class="text"><h3 style="font-weight: 600;color: #fbae17;">NOW LOADING WAIT!!</h3></div>
  </div>
</div>

<!-- Wrapper -->
<div id="wrapper" class="">

<?php include("views/header.php");?>
<?php include("views/session.php");?>

<div class="clearfix"></div>
<!-- Header Container / End -->


	<!-- Dashboard Content
	================================================== -->
	<div class="dashboard-content-container" data-simplebar style="background:#fff;height:auto;">
		<div class="dashboard-content-inner">
			<!-- Dashboard Headline -->
			<div class="dashboard-headline">
				<center><h3><strong> Offer Checkout : DailyNeeds</strong></h3></center>
			</div>
			<!-- Container -->
			<div class="container">
				<form id="payment-checkout-form" novalidate>
					<div class="row">
						<div class="col-xl-8 col-lg-8 content-right-offset">
							<!-- Hedline -->
							<h3 >Payment Method</h3>
								<!-- Payment Methods Accordion -->
								<div class="payment margin-top-30">

									<div class="payment-tab" style="display: none;">
										<div class="payment-tab-trigger">
											<input checked id="paypal" name="cardType" type="radio" value="paypal">
											<label for="paypal">PayPal</label>
											<img class="payment-logo paypal" src="https://i.imgur.com/ApBxkXU.png" alt="">
										</div>

										<div class="payment-tab-content">
											<div class="">
												<div class="card-label">
													<input id="email" name="email" type="email" placeholder="Paypal Email Address">
												</div>
											</div>
											<h6>You will be redirected to PayPal to complete payment.</h6>
										</div>
									</div>


									<div class="payment-tab payment-tab-active">
										<div class="payment-tab-trigger">
											<input type="radio" checked name="cardType" id="creditCart" value="creditCard">
											<label for="creditCart">Credit / Debit Card</label>
											<img class="payment-logo" src="https://i.imgur.com/IHEKLgm.png" alt="">
										</div>

										<div class="payment-tab-content">
											<div class="row payment-form-row">

												<div class="col-md-6">
													<div class="card-label">
														<input id="nameOnCard" name="nameOnCard" class="card-holder" value="" required type="text" placeholder="Cardholder Name">
													</div>
												</div>

												<div class="col-md-6">
													<div class="card-label">
														<input id="cardNumber" name="cardNumber"  class="card-number" value="" placeholder="Credit Card Number" required type="number">
													</div>
												</div>

												<div class="col-md-4">
													<div class="card-label">
														<input id="expiryDate" placeholder="Expiry Month" size="2" value="" maxlength="2" class="card-expiry-month" required oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" type = "number" maxlength = "2">
													</div>
												</div>

												<div class="col-md-4">
													<div class="card-label">
														<label for="expiryDate">Expiry Year</label>
														<input id="expirynDate" placeholder="Expiry Year" size="4" value=""  class="card-expiry-year" required oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" type = "number" maxlength = "4">
													</div>
												</div>

												<div class="col-md-4">
													<div class="card-label">
														<input id="cvv" required oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" type = "number" maxlength = "3" size="3" class="card-cvc" value=""  placeholder="CVV">
													</div>
												</div>

											</div>
										</div>
									</div>

								</div>
							<!-- Payment Methods Accordion / End -->
								<button type="submit" class="payment-btn button big ripple-effect margin-top-40 margin-bottom-65">Proceed Payment</button>
								<!-- <a href="javascript:;" class="procced-payment button big ripple-effect margin-top-40 margin-bottom-65">Proceed Payment</a> -->
						</div>


						<!-- Summary -->
						<div class="col-xl-4 col-lg-4 margin-top-0 margin-bottom-60">
							
							<!-- Summary -->
							<div class="boxed-widget summary margin-top-0">
								<div class="boxed-widget-headline">
									<h3>Summary</h3>
								</div>
								<div class="boxed-widget-inner">
									<ul>
										<li>Standard Plan <span>$<?php echo $data['budget'];?></span></li>
										<li id="vat">VAT (0%) <span>$00.00</span></li>
										<li class="total-costs">Final Price <span id="finalPrice">$00.00</span></li>
									</ul>
								</div>
							</div>
							<!-- Summary / End -->

							<!-- Checkbox -->
							<div class="checkbox margin-top-30">
								<input type="checkbox" id="two-step" required checked>
								<label for="two-step"><span class="checkbox-icon"></span>  I agree to the <a href="#">Terms and Conditions</a> and the <a href="#">Automatic Renewal Terms</a></label>
							</div>
						</div>

					</div>
				</form>
			</div>
			<!-- Container / End -->
		<br><br>

		</div>
	</div>
	<!-- Dashboard Content / End -->

<?php include("views/footer.php");?>

</div>
<!-- Wrapper / End -->

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
<!-- <script src="js/counterup.min.js"></script> -->
<script src="js/magnific-popup.min.js"></script>
<script src="js/slick.min.js"></script>
<script src="js/custom.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/socket.io/2.1.1/socket.io.js"></script>
<script src="js/chatscript.js?v=3232"></script>
<!-- Snackbar // documentation: https://www.polonel.com/snackbar/ -->
<!-- Stripe JavaScript library -->
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<!-- jQuery is used only for this example; it isn't required to use Stripe -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script type="text/javascript">
//set your publishable key

Stripe.setPublishableKey('pk_test_sJESCQSxFaq8wjW2rYrZLRaT');
//callback to handle the response from stripe
function stripeResponseHandler(status, response) {
    console.log("status :::::::: ",status);
    console.log("response :::::::: ",response)
    if (response.error) {
        //enable the submit button
        $('#payBtn').removeAttr("disabled");
        //display the errors on the form
        $(".payment-errors").html(response.error.message);
    } else {
    	event.preventDefault();
	  	var formData = new FormData(this);
        var form$ = $("#paymentFrm");
        //get token id
        var token = response['id'];
        //insert the token into the form
        form$.append("<input type='hidden' name='stripeToken' value='" + token + "' />");
        //submit form to the server
        form$.get(0).submit();
    }
}
$(document).ready(function() {
		
		var budget = '<?php echo $data['budget'];?>';
		var cal = Math.round((2.5*parseInt(budget))/100);
		$('#vat').html('VAT 2.5% <span>($'+cal.toFixed(2)+')</span>');
		cal = parseFloat(budget)+cal;
		$('#finalPrice').text('$'+cal.toFixed(2));

    //on form submit
    $("#payment-checkout-form").submit(function(event) {
    		event.preventDefault();
    		var pattern = /^\d+$/;
    		var paymentType = $("input[name='cardType']:checked").val();
    		console.log("data ::::::: paymentType ::: ", paymentType);

    		if($('.card-expiry-year').val() == '' || !pattern.test($('.card-expiry-year').val()) || $('.card-expiry-year').val().length != 4){
    			alert("Expiry Year not Valid!");
    			return true;
    		}
    		if($('.card-cvc').val() == '' || !pattern.test($('.card-cvc').val()) || $('.card-cvc').val().length != 3){
    			alert("CVV not Valid!");
    			return true;
    		}
    		if($('.card-expiry-month').val() == '' || !pattern.test($('.card-expiry-month').val()) || $('.card-expiry-month').val().length != 2){
    			alert("Expiry Moth not Valid!");
    			return true;
    		}
    		if($('.card-number').val() == '' || !pattern.test($('.card-number').val()) || $('.card-number').val().length != 16){
    			alert("Card Number not Valid!");
    			return true;
    		}
    		
    		if(typeof cal == 'undefined' || cal == null || cal == 0){
    			alert("budget should be 0");
    			return true;
    		}
    		$('#wrapper').addClass('blur-filter');
    		$('#wrapper').css('pointer-events', 'none');

				$('.wrap').css('display', 'block');
				$('body').addClass('bodydisable');
    		if(paymentType == 'creditCard'){
  				  //create single-use token to charge the user
		        Stripe.createToken({
		            number: $('.card-number').val(),
		            cvc: $('.card-cvc').val(),
		            exp_month: $('.card-expiry-month').val(),
		            exp_year: $('.card-expiry-year').val()
		        }, (status, response)=>{
		        	if(status == 200){
		        		$('.payment-btn').attr("disabled", "disabled");
		        		if(typeof response.id != 'undefined'){
			        		var data = {
			        								orderid: '<?php echo $_GET['cc'];?>',
			        								name: '<?php echo $_SESSION['username'];?>', email: '<?php echo $_SESSION['email'];?>',
			        								card_num: $('.card-number').val(), cvc: $('.card-cvc').val(),
									            exp_month: $('.card-expiry-month').val(),
									            exp_year: $('.card-expiry-year').val(),
									            stripeToken: response.id,
									            price: cal
									          };

									$.ajax({
				        		url: '<?php echo SITE_URL;?>/v1/services/service.php?service=makePayment',
				        		type: 'POST',
				        		data: data,
				        		success: (response)=>{
				        			response = JSON.parse(response);
				        			if(response.error != 'Y'){
				        				var orderdata = {cc: '<?php echo base64_decode($_GET['cc'])?>', buyerid: '<?php echo $_SESSION['id'];?>', userid: '<?php echo $data['userid']?>'};
					        			socket.emit('createRoomforOrder', orderdata);
					        			setTimeout(function(){
													window.location = '<?php echo SITE_URL;?>/order_confirmation';
												},2000);
				        			}else{
				        				$('#wrapper').removeClass('blur-filter');
				        				$('#wrapper').removeAttr('style');
								    		$('.wrap').css('display', 'none');
												$('body').removeClass('bodydisable');
				        				swal("Oops!", response.msg);
				        				$('.payment-btn').removeAttr("disabled");
				        			}
				        		},
				        		error: (error)=>{
				        			console.log("error with payment");
				        			$('#wrapper').removeClass('blur-filter');
				        			$('#wrapper').removeAttr('style');
							    		$('.wrap').css('display', 'none');
											$('body').removeClass('bodydisable');
			        				swal("Oops!", error);
			        				$('.payment-btn').removeAttr("disabled");
				        		}
				        	})
			        	}else{
			        		console.log("error with payment");
		        			$('#wrapper').removeClass('blur-filter');
		        			$('#wrapper').removeAttr('style');
					    		$('.wrap').css('display', 'none');
									$('body').removeClass('bodydisable');
	        				swal("Oops!", 'Fail Transcation!');
	        				$('.payment-btn').removeAttr("disabled");
			        	}
		        	}else{
		        		console.log("error with payment");
	        			$('#wrapper').removeClass('blur-filter');
	        			$('#wrapper').removeAttr('style');
				    		$('.wrap').css('display', 'none');
								$('body').removeClass('bodydisable');
        				swal("Oops!", 'Fail Transcation!');
        				$('.payment-btn').removeAttr("disabled");
		        	}
		        });
    		}else{
    			console.log("error with payment");
    			$('#wrapper').removeClass('blur-filter');
    			$('#wrapper').removeAttr('style');
	    		$('.wrap').css('display', 'none');
					$('body').removeClass('bodydisable');
  				swal("Oops!", 'Fail Transcation!');
  				$('.payment-btn').removeAttr("disabled");
    			return false;
    		}
        //submit from callback
        return false;
    });
});
</script>



<script>
$('.procced-payment').click(function(){
	$('#wrapper').addClass('blur-filter');
	$('.wrap').css('display', 'block');
	$('body').css({
    'height': '100%',
    'overflow': 'hidden',
    'width': '100%'
	})
	$.ajax({
		url: '<?php echo SITE_URL;?>/v1/services/service.php?service=makecc',
		type:'post',
		data: {cc:'<?php echo $_GET['cc']?>'},
		success: function(data){
			console.log("okay ::::::",data);
			var data = JSON.parse(data);
			var orderdata = {cc: '<?php echo base64_decode($_GET['cc'])?>', buyerid: '<?php echo $_SESSION['id'];?>', userid: '<?php echo $data['userid']?>'};
			console.log("data :::::: ", orderdata);
			if(data['error'] == 'N'){
				socket.emit('createRoomforOrder', orderdata);
				setTimeout(function(){
					window.location = '<?php echo SITE_URL;?>/order_confirmation?cc=<?php echo $_GET['cc']?>';
				},2000)
			}else{
				console.log("data :::::::: ", data);
			}
		},
		error: function(){

		}
	})
})


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






</script>

<!-- Google API -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAgeuuDfRlweIs7D6uo4wdIHVvJ0LonQ6g&libraries=places&callback=initAutocomplete"></script>

</body>
</html>