<?php 
	include("v1/config.php");
	if(!isset($_SESSION)) 
	{ 
	    session_start(); 
	}
	if($_GET['cid'] == ''  || (int)$_GET['cid'] == 0){
		echo json_encode(array('error' => 'Y', 'msg' => 'city not found on requested data'), true);
		return true;
	}
	$_GET['category'] = 0;
	$_GET['scategory'] = 0;
	$_GET['userid'] = isset($_SESSION['id']) ? (int)$_SESSION['id'] : (int)0;
	$_GET['search'] = $_GET['code'];
	
	if($_GET['search'] == ''){
		echo json_encode(array('error' => 'Y', 'msg' => 'search not found on requested data'), true);
		return true;
	}
	// if($_GET['userid'] == ''){
	// 	echo json_encode(array('error' => 'Y', 'msg' => 'userid not found on requested data'), true);
	// 	return true;
	// }
		$userid = mysqli_real_escape_string($db, $_GET['userid']);
		if((int)$_GET['cid'] > 0){
			$cid = mysqli_real_escape_string($db, $_GET['cid']);
			
			if((int)$_GET['scategory'] == 0 && (int)$_GET['category'] == 0 && (int)$_GET['search'] == 0){
				$sql = "SELECT register.speak, register.username, register.profile as userprofile, register.description as userDescription, user_services.id, user_services.userid, city.name as cityName, user_services.category, user_services.scategory, user_services.image, user_services.description, user_services.title,user_services.price, categories.name as category, subcategories.name as scategory FROM user_services, categories, subcategories, city, register  WHERE user_services.city = city.id and categories.id = user_services.category and subcategories.id = user_services.scategory and user_services.city = '$cid'
					and user_services.userid = register.id and user_services.userid<>'$userid' GROUP BY id";
			}else if((int)$_GET['scategory'] > 0 && (int)$_GET['category'] == 0){
		  	$scategory = mysqli_real_escape_string($db, $_GET['scategory']);
				$sql = "SELECT register.speak, register.username, register.profile as userprofile, register.description as userDescription, user_services.id, user_services.userid, city.name as cityName, user_services.category, user_services.scategory, user_services.image, user_services.description, user_services.title,user_services.price, categories.name as category, subcategories.name as scategory FROM user_services, categories, subcategories, city, register  WHERE user_services.city = city.id and categories.id = user_services.category and subcategories.id = user_services.scategory and user_services.scategory = '$scategory' and user_services.city = '$cid' and user_services.userid<>'$userid' GROUP BY id";
			}else if((int)$_GET['category'] > 0 && (int)$_GET['scategory'] == 0){
		  	$category = mysqli_real_escape_string($db, $_GET['category']);
				$sql = "SELECT register.speak, register.username, register.profile as userprofile, register.description as userDescription, user_services.id, user_services.userid, city.name as cityName, user_services.category, user_services.scategory, user_services.image, user_services.description, user_services.title,user_services.price, categories.name as category, subcategories.name as scategory FROM user_services, categories, subcategories, city,register  WHERE user_services.city = city.id and categories.id = user_services.category and subcategories.id = user_services.scategory and user_services.category = '$category' and user_services.city = '$cid' and user_services.userid = register.id and user_services.userid<>'$userid' GROUP BY id";
		  }else if((int)$_GET['category'] > 0 && (int)$_GET['scategory'] > 0){
		  	$category = mysqli_real_escape_string($db, $_GET['category']);
		  	$scategory = mysqli_real_escape_string($db, $_GET['scategory']);
				$sql = "SELECT register.speak, register.username, register.profile as userprofile, register.description as userDescription, user_services.id, user_services.userid, city.name as cityName, user_services.category, user_services.scategory, user_services.image, user_services.description, user_services.title,user_services.price, categories.name as category, subcategories.name as scategory FROM user_services, categories, subcategories, city,register  WHERE user_services.city = city.id and categories.id = user_services.category and subcategories.id = user_services.scategory and user_services.category = '$category' and user_services.scategory = '$scategory' and user_services.city = '$cid' and user_services.userid = register.id and user_services.userid<>'$userid' GROUP BY id";
		  }

		  if(strlen($_GET['search']) > 1){
		  	$search = mysqli_real_escape_string($db, $_GET['search']);
		  	$sql = "SELECT register.speak, register.username, register.profile as userprofile, register.description as userDescription, user_services.id, user_services.userid, city.name as cityName, user_services.category, user_services.scategory, user_services.image, user_services.description, user_services.title,user_services.price, categories.name as category, subcategories.name as scategory FROM user_services, categories, subcategories, city,register WHERE user_services.city = city.id and categories.id = user_services.category and subcategories.id = user_services.scategory and user_services.title LIKE '$search%' and user_services.city = '$cid' and user_services.userid = register.id and user_services.userid<>'$userid' GROUP BY id";
		  }
		}
	$query = mysqli_query($db, $sql);
	$row = mysqli_fetch_row($query);

	$rows = $row[0];
 
	$page_rows = 10;
 
	$last = ceil($rows/$page_rows);
 
	if($last < 1){
		$last = 1;
	}
 
	$pagenum = 1;
 
	if(isset($_GET['pn'])){
		$pagenum = preg_replace('#[^0-9]#', '', $_GET['pn']);
	}
 
	if ($pagenum < 1) { 
		$pagenum = 1; 
	} 
	else if ($pagenum > $last) { 
		$pagenum = $last; 
	}
 
	$limit = 'LIMIT ' .($pagenum - 1) * $page_rows .',' .$page_rows;

	if((int)$_GET['cid'] > 0){
			$cid = mysqli_real_escape_string($db, $_GET['cid']);
			
			if((int)$_GET['scategory'] == 0 && (int)$_GET['category'] == 0 && (int)$_GET['search'] == 0){
				$sql = "SELECT register.speak, register.username, register.profile as userprofile, register.description as userDescription, user_services.id, user_services.userid, city.name as cityName, user_services.category, user_services.scategory, user_services.image, user_services.description, user_services.title,user_services.price, categories.name as category, subcategories.name as scategory FROM user_services, categories, subcategories, city, register  WHERE user_services.city = city.id and categories.id = user_services.category and subcategories.id = user_services.scategory and user_services.city = '$cid'
					and user_services.userid = register.id and user_services.userid<>'$userid' GROUP BY id ".$limit;
			}else if((int)$_GET['scategory'] > 0 && (int)$_GET['category'] == 0){
		  	$scategory = mysqli_real_escape_string($db, $_GET['scategory']);
				$sql = "SELECT register.speak, register.username, register.profile as userprofile, register.description as userDescription, user_services.id, user_services.userid, city.name as cityName, user_services.category, user_services.scategory, user_services.image, user_services.description, user_services.title,user_services.price, categories.name as category, subcategories.name as scategory FROM user_services, categories, subcategories, city, register  WHERE user_services.city = city.id and categories.id = user_services.category and subcategories.id = user_services.scategory and user_services.scategory = '$scategory' and user_services.city = '$cid' and user_services.userid<>'$userid' GROUP BY id ".$limit;
			}else if((int)$_GET['category'] > 0 && (int)$_GET['scategory'] == 0){
		  	$category = mysqli_real_escape_string($db, $_GET['category']);
				$sql = "SELECT register.speak, register.username, register.profile as userprofile, register.description as userDescription, user_services.id, user_services.userid, city.name as cityName, user_services.category, user_services.scategory, user_services.image, user_services.description, user_services.title,user_services.price, categories.name as category, subcategories.name as scategory FROM user_services, categories, subcategories, city,register  WHERE user_services.city = city.id and categories.id = user_services.category and subcategories.id = user_services.scategory and user_services.category = '$category' and user_services.city = '$cid' and user_services.userid = register.id and user_services.userid<>'$userid' GROUP BY id ".$limit;
		  }else if((int)$_GET['category'] > 0 && (int)$_GET['scategory'] > 0){
		  	$category = mysqli_real_escape_string($db, $_GET['category']);
		  	$scategory = mysqli_real_escape_string($db, $_GET['scategory']);
				$sql = "SELECT register.speak, register.username, register.profile as userprofile, register.description as userDescription, user_services.id, user_services.userid, city.name as cityName, user_services.category, user_services.scategory, user_services.image, user_services.description, user_services.title,user_services.price, categories.name as category, subcategories.name as scategory FROM user_services, categories, subcategories, city,register  WHERE user_services.city = city.id and categories.id = user_services.category and subcategories.id = user_services.scategory and user_services.category = '$category' and user_services.scategory = '$scategory' and user_services.city = '$cid' and user_services.userid = register.id and user_services.userid<>'$userid' GROUP BY id ".$limit;
		  }

		  if(strlen($_GET['search']) > 1){
		  	$search = mysqli_real_escape_string($db, $_GET['search']);
		  	$sql = "SELECT register.speak, register.username, register.profile as userprofile, register.description as userDescription, user_services.id, user_services.userid, city.name as cityName, user_services.category, user_services.scategory, user_services.image, user_services.description, user_services.title,user_services.price, categories.name as category, subcategories.name as scategory FROM user_services, categories, subcategories, city,register WHERE user_services.city = city.id and categories.id = user_services.category and subcategories.id = user_services.scategory and user_services.title LIKE '$search%' and user_services.city = '$cid' and user_services.userid = register.id and user_services.userid<>'$userid' GROUP BY id ".$limit;
		  }
		}
	$query = mysqli_query($db, $sql);
	$count = mysqli_num_rows($query);
 	$paginationCtrls = '<ul>';
 	if($last != 1){
 
	if ($pagenum > 1) {
        $previous = $pagenum - 1;
		$paginationCtrls .= '<li class="pagination-arrow"><a href="'.$_SERVER['PHP_SELF'].'?code='.$_GET["code"].'&cid='.$_GET['cid'].'&pn='.$previous.'" class="btn btn-default"><i class="icon-material-outline-keyboard-arrow-left"></i></a></li>';
 
		for($i = $pagenum-4; $i < $pagenum; $i++){
			if($i > 0){
		        $paginationCtrls .= '<li><a href="'.$_SERVER['PHP_SELF'].'?code='.$_GET["code"].'&cid='.$_GET['cid'].'&pn='.$i.'">'.$i.'</a></li>';
			}
	    }
    }
 	
 	$paginationCtrls .= '<li><a href="javascript:;">'.$pagenum.'</a></li>';
 
	for($i = $pagenum+1; $i <= $last; $i++){
		$paginationCtrls .= '<li><a href="'.$_SERVER['PHP_SELF'].'?code='.$_GET["code"].'&cid='.$_GET['cid'].'&pn='.$i.'">'.$i.'</a></li>';
		if($i >= $pagenum+4){
			break;
		}
	}
 
    if ($pagenum != $last) {
        $next = $pagenum + 1;
        $paginationCtrls .= ' <li class="pagination-arrow"><a href="'.$_SERVER['PHP_SELF'].'?code='.$_GET["code"].'&cid='.$_GET['cid'].'&pn='.$next.'"><i class="icon-material-outline-keyboard-arrow-right"></i></a></li>';
    }
	}
	
	if (!$query) {
	  printf("Error: %s\n", mysqli_error($db));
	  exit();
	}
	$data = mysqli_fetch_all($query, MYSQLI_ASSOC);
	foreach ($data as $key => $value) {
		
		$serviceid = mysqli_real_escape_string($db, $value['id']);
		$userid = mysqli_real_escape_string($db, $_GET['userid']);
		$sql = "SELECT * FROM favorites WHERE userid='$userid' and serviceid='$serviceid'";
		$result = mysqli_query($db, $sql);
		$favdata = mysqli_fetch_all($result, MYSQLI_ASSOC);
		$data[$key]['favorite'] = count($favdata) ? 'Y' : 'N';
		$serviceUserid = mysqli_real_escape_string($db, $value['userid']);
		$sql = "SELECT count(*) as total, sum(rate) as totalRate FROM service_review WHERE userid='$serviceUserid' and serviceid='$serviceid'";
		$result = mysqli_query($db, $sql);
		$rate = mysqli_fetch_all($result, MYSQLI_ASSOC);
		if((int)$rate[0]['total']){
			$data[$key]['rating'] = number_format((float)$rate[0]['totalRate']/(int)$rate[0]['total'], 2, '.', '');
		}else{
			$data[$key]['rating'] = 0;
		}
		$data[$key]['response_time'] = '1 Hours';
	}
?>
<!doctype html>
<html lang="en">
<head>

<!-- Basic Page Needs
================================================== -->
<title>DailyNeeds | Product List</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

<!-- CSS
================================================== -->
<link rel="stylesheet" href="css/style.css?v=2">
<link rel="stylesheet" href="css/colors/blue.css?v=2">
<style type="text/css">
.active_sub{
  background-color: #ffa500 !important;
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
	.intro-banner:after, .intro-banner:before{
		background: #FFF !important;
	}
</style>
</head>
<body>

<!-- Wrapper -->
<div id="wrapper">

<?php include("views/header.php");?>

<div class="clearfix"></div>
<!-- Header Container / End -->
<div class="intro-banner" style="padding: 0px !important;">
	<div class="container">
		
		
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
							<input type="text" id="search_text" value="<?php echo isset($_GET['search']) ? $_GET['search'] : '';?>" name="search_text" placeholder="Search Services" maxlength="20" style="box-shadow: 0 1px 4px 0 rgba(0, 0, 0, .12);">
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
<!-- Spacer -->
<div class="margin-top-90"></div>

<div class="container">
	<div class="row">
		<center>
		<div class="col-xl-9 col-lg-8 content-left-offset">

			<div class="listings-container grid-layout margin-top-35">
				
				<?php
				if($count){

					foreach ($data as $value) {
						
				?>
				<a href="<?php echo SITE_URL;?>/product?uid=<?php echo $value['userid'];?>&sid=<?php echo $value['id'];?>" class="job-listing">

					<!-- Job Listing Details -->
					<div class="job-listing-details">
						<!-- Logo -->
						<div class="job-listing-company-logo">
							<img src="<?php echo 'images/services/'.$value['image']; ?>" alt="">
						</div>

						<!-- Details -->
						<div class="job-listing-description">
							<h4 class="job-listing-company"> <?php echo $value['title']; ?> </h4>
							<h3 class="job-listing-title">Bilingual Event Support Specialist</h3>
						</div>
					</div>

					<!-- Job Listing Footer -->
					<div class="job-listing-footer">
						<ul>
							<li><i class="icon-feather-user"></i> <?php echo $value['username']?></li>
						</ul>
					</div>
				</a>

				<?php
					}
				}else{
				?>
					<!-- Job Listing Details -->
					
					<div class="listings-container grid-layout">
						<div class="job-listing-description">
							<center><h3 class="job-listing-title">No Results Found !</h3></center>
						</div>
					</div>
					
				
				<?php }?>


			</div>

			<!-- Pagination -->
			<div class="clearfix"></div>
			<div class="row">
				<div class="col-md-12">
					<!-- Pagination -->
					<div class="pagination-container margin-top-30 margin-bottom-60">
						<nav class="pagination">
							<?php echo $paginationCtrls; ?>
						</nav>
					</div>
				</div>
			</div>
			<!-- Pagination / End -->

		</div>
		</center>
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

var sess = '<?php echo (isset($_SESSION['email'])) ? 1 : 0?>';
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
			console.log("results :::::: ", results);
			var results = JSON.parse(results);

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

	$.ajax({
		url: '<?php echo SITE_URL;?>/v1/services/service.php?service=services',
		type: 'GET',
		success: function(results){
			console.log("results ::::::: ", results);
			var results = JSON.parse(results);
			
			var output = [];
			for (var i = 0; i < results.length; i++) {
				output.push('<option value="'+ results[i]['id'] +'">'+ results[i]['name'] +'</option>');
			}
			
			$('#categoryOptions').html(output.join(''));

			
		},
		error: function(err){
			console.log("err :::::: ",err);
		}
	})

	$( "#service-post-form" ).submit(function( event ) {
	  	event.preventDefault();
	  	var formData = new FormData(this);
	  	console.log("formatsdta ::::: ", formData);
	  	$.ajax({
			url: '<?php echo SITE_URL;?>/v1/services/service.php?service=addService',
			type: 'POST',
			data:formData,
            cache:false,
            contentType: false,
            processData: false,
			success: function(results){
				console.log("results :::::: ", results);
				results = JSON.parse(results);
				if(results['error'] == 'Y'){
			  		$('.closeable').addClass('error');
			  		$('#successmsg').html('<strong>Problem </strong> '+results['msg']);
			  	}else{
			  		$('.closeable').addClass('success');
			  		$('#successmsg').html('<strong>Success </strong> '+results['msg']);
			  	}

			  	$('.closeable').fadeIn();
			  	setTimeout(function(){
			  		$('.closeable').fadeOut();
			  	},1500);
			},
			error: function(err){
				console.log("err :::::: ",err);
			}
		})
	});

	$(function(){
		$.ajax({
			url: '<?php echo SITE_URL;?>/v1/services/index.php?service=city',
			type: 'GET',
			success: function(results){
				var results = JSON.parse(results);
				var city = '<?php echo $_GET['cid'];?>';
				var output = ['<option value="">Select City</option>'];
				for (var i = 0; i < results.data.length; i++) {
					console.log("city :::::::::::: ", city, results.data[i].id);
					if(city == results.data[i].id.toString()){
						output.push('<option value="'+ results.data[i]['id'] +'" selected>'+ results.data[i]['name'] +'</option>');
					}else{
						output.push('<option value="'+ results.data[i]['id'] +'">'+ results.data[i]['name'] +'</option>');
					}
				}

				$('#cityOptions').html(output.join(''));
			},
			error: function(err){
				console.log("err :::::: ",err);
			}
		})
		
	})



</script>

<!-- Google API -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAgeuuDfRlweIs7D6uo4wdIHVvJ0LonQ6g&libraries=places&callback=initAutocomplete"></script>

</body>
</html>