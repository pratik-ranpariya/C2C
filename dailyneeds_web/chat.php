<?php
	if(!isset($_SESSION)) 
	{ 
	    session_start(); 
	} 
?>
<!doctype html>
<html lang="en">
<head>

<!-- Basic Page Needs
================================================== -->
<title>DailyNeeds | Chat</title>
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
	.simplebar-track {
	  display: none !important;
	}
	.simplebar-scroll-content{
		overflow-x: hidden !important;
    	overflow-y: hidden !important;
	}
	.dashboard-content-container{
		height: 600px !important;
	}
</style>
</head>
<body>

<!-- Wrapper -->
<div id="wrapper">

<!-- Header Container
================================================== -->
<?php include("views/header.php");?>
<?php include("views/session.php");?>
<div class="clearfix"></div>
<!-- Header Container / End -->

<!-- Titlebar
================================================== -->

<!-- Container -->
<div class="container">
	<div class="row">

<!-- Dashboard Content
	================================================== -->
	<!-- <div class="dashboard-content-container" data-simplebar style="margin-bottom: 50px;">
		<div class="dashboard-content-inner" > -->
			<div class="col-xl-12" data-simplebar style="margin-bottom: 50px;">

				<div class="" style="background-color: rgb(255, 255, 255);">
					<div class="dashboard-headline" style="margin-top: 50px;">
						<center><h3><strong>All Conversations : DailyNeeds</strong></h3></center>
					</div>
					<div class="messages-container margin-top-0" style="border: 2px solid #eee;box-shadow: 0 0px 10px #E0E0E7;">

						<div class="messages-container-inner" style="border-right:2px solid #eee">

							<!-- Messages -->
							<div class="messages-inbox" style="height: 700px;overflow-y: scroll;">
								<ul id="usersData">
								</ul>
							</div>
							<!-- Messages / End -->

							<!-- Message Content -->
							<div class="message-content" style="height: 700px;">

								<div class="messages-headline">
									<h4><?php echo (isset($_SESSION['username'])) ? $_SESSION['username'] : '';?></h4>
								</div>

								<!-- Message Content Inner -->
								<div class="message-content-inner">

								</div>
								<!-- Message Content Inner / End -->

								<!-- Reply Area -->
								<form id="message-form">
									<div class="message-reply">
										<textarea cols="1" rows="1" id="msg" name="msg" placeholder="Your Message" data-autoresize></textarea>
										<input class="button ripple-effect" type="submit" value="Send" name="Send">
									</div></form>

								</div>
								<!-- Message Content -->
								<br/><br/>
							</div>
						</div>
						<!-- Messages Container / End -->

					</div>
				</div>
				<!-- Dashboard Content / End -->	

			</div>
		</div>
		<!-- Container / End -->

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
<script src="js/counterup.min.js"></script>
<script src="js/magnific-popup.min.js"></script>
<script src="js/slick.min.js"></script>
<script src="js/custom.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.1.1/socket.io.js"></script>
<script src="js/chatscript.js?v=222"></script>

<!-- Snackbar // documentation: https://www.polonel.com/snackbar/ -->
<script>
socket.on( 'disconnect', function () {
    location.reload();
});
$(function(){
	myid = '<?php echo $_SESSION["id"];?>';
	oppProfile = '';
	opp = '';
	roomName = '';
	getChatUsers();
	$('.opponentChat').click(function(){
		console.log("click on chat ::::::: ")
	})
})	

$('#msg').keypress(function(e) {
    if (e.keyCode == 13 && e.shiftKey)
    {	

    }else if(e.keyCode == 13){
    	var msg = $("#msg").val().replace(/\n/g, "");
    	if (msg != "")
	    {
        $('#message-form').submit();
    		$('#msg').val('');
	    }
	    return false;
    	

    }
});

function ChangeStatus(data){
	console.log("ChangeStatus data :::: ", data);
	socket.emit('online',data);
}


// "select * from room where (buyerid='2' and freelancerid='2') or (buyerid='2' and freelancerid='2')"


// Snackbar for user status switcher
$('.status-switch label.user-invisible').click(function(){
	console.log("offline");
	online(0);
	ChangeStatus({status: 0, uid: '<?php echo $_SESSION['id']?>'});
	$('.user-avatar').removeClass('status-online');
});
$('.status-switch label.user-online').click(function(){
	console.log("online");
	online(1);
	ChangeStatus({status: 1, uid: '<?php echo $_SESSION['id']?>'});
	$('.user-avatar').addClass('status-online');
});

$('#message-form').submit(function(event){
	event.preventDefault();
	var msg = document.getElementById('msg').value;
	document.getElementById('msg').value = '';
	if(msg.length){
		var data = {msg: msg, room: roomName, senderid: myid, receiverid: opp};
		console.log("data ::::: sendMsg ", data);
		socket.emit('sendMsg',data);
		$('#msg').val('');
		$('#msg').css('height', '48px !important');
	}
})
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

</script>

<!-- Google API -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAgeuuDfRlweIs7D6uo4wdIHVvJ0LonQ6g&libraries=places&callback=initAutocomplete"></script>

</body>
</html>