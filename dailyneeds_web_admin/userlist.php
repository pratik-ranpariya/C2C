<?php
error_reporting(0);
 include('v1/config.php');
session_start();
if(empty($_SESSION['username']))
{
     header('Location:index.php');
}
$db = mysqli_connect("localhost","root","","newmagic");
 define('SITE_URL', 'http://localhost/dailyneeds/dailyneeds/html/dailyneeds_web_admin/'); 
 ?> 
<!doctype html>
<html lang="en">


<head>

<!-- Basic Page Needs
================================================== -->
<title>DailyNeeds | User Payments</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

<!-- CSS
================================================== -->
<link rel="stylesheet" href="css/sweetalert.min.css">
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/colors/blue.css">
<style type="text/css">
table td{
	display: table-cell !important;
	width: 10% !important;
	border-bottom: none !important;
	background-color: #eee !important;
}
table th{
	display: table-cell !important;
	width: 10% !important;
}
table{
	padding: 9px !important;
}
.near_by_hotel_wrapper{
	background:#f5f5f5;
	}
.custom_table {
    border-collapse: separate;
    border-spacing: 0 10px;
    margin-top: -3px !important;
}
.custom_table thead tr th {
	padding: 0px 8px;
	font-size: 16px;
	border: 0 none !important;
	border-top: 0 none !important;
}
.custom_table tbody tr {
    -moz-box-shadow: 0 2px 3px #e0e0e0;
    -webkit-box-shadow: 0 2px 3px #e0e0e0;
    box-shadow: 0 2px 3px #e0e0e0;
}
.near_by_hotel_wrapper table tr td {
	border-right: 1px solid #d2d1d1;
}

.custom_table tbody tr td {
	background: #fff none repeat scroll 0 0;
	border-top: 0 none !important;
	margin-bottom: 20px;
	padding: 10px 8px;
	font-size: 16px;
}
.near_by_hotel_wrapper table tr td {
    border-right: 1px solid #d2d1d1;
}
.responsive{
	overflow-x:auto !important;
}
tr td,tr th{
	min-width: 100px !important;
	text-align: left !important;
}
option{
	margin: 10px !important;
}
.succ{
	border: 2px solid green;
    font-size: 20px;
    font-weight: 800;
    color: green;
    padding: 3px 8px;
    border-radius: 4px;
}
.nosucc{
	border: 2px solid red;
    font-size: 20px;
    font-weight: 800;
    color: red;
    padding: 3px 8px;
    border-radius: 4px;
}
</style>
</head>
<body class="gray">

<!-- Wrapper -->
<div id="wrapper">

<!-- Header Container
================================================== -->
<?php include('header.php');?>
<div class="clearfix"></div>
<!-- Header Container / End -->


<!-- Dashboard Container -->
<div class="dashboard-container">

	<?php include('dashboard-leftlayout.php');?>
	<!-- Dashboard Content
	================================================== -->
	<div class="dashboard-content-container" data-simplebar>
		<div class="dashboard-content-inner" >

						<div class="col-xl-12" style="margin-bottom:20px;">
						<div id="test1" class="dashboard-box">

							<div class="content with-padding" style="padding: 20px 10px 0px 20px;">
								<form action="" method="post">
									<div class="row">
										<div class="col-xl-3">
											<div class="submit-field">
												<input type="number" class="with-border" id="myText" placeholder="Add QRCode..." name="qr_code_length">
											</div>
										</div>
										

										<div class="col-xl-3">
											<div class="submit-field">
												<button class="button ripple-effect" style="width:100%;text-align:center;" onclick="myFunction()">GENERATE QRCODE</button>
											</div>
										</div>

                                    
										<div class="col-xl-3">
											<div class="submit-field">
												<input type="text" class="with-border" placeholder="Search Mobile Number..." name="search" required>
											</div>
										</div>
										

										<div class="col-xl-3">
											<div class="submit-field">
												<button href="#" class="button ripple-effect" type="submit" for="search-form" style="width:100%;text-align:center;">SEARCH</button>
											</div>
										</div>
									

									</div></form>
									<script>
									function myFunction() {

								if(document.getElementById("myText").value <= '0' || document.getElementById("myText").value == ''){
									alert("can't insert 0 value");
									return false;
								}

									var string="http://digicopsindia.com/newmagic/public/genrate_qr/"+document.getElementById("myText").value;
									 window.location=string;	
									alert(document.getElementById("myText").value+"Qrcode Inserted successfully");
									}
									</script>
							</div>
						</div>
					</div>
					<br>
			
			<!-- Dashboard Headline -->
			<div class="dashboard-headline">
				<h3>User List</h3>
			</div>
			<!-- Row -->
		<div class="row">



			
			<div class="col-xl-12 col-md-12 responsive">
				<table class="table no-border custom_table dataTable no-footer dtr-inline" style="width: 100%;background-color:#fff;">
				    <thead>
				      <tr>
				        <th class="text-center">S.No</th>
				        <th class="text-center">Name</th>
				        <th class="text-center">Mobile Number</th>
				        <th class="text-center">Device Id</th>
				        <th class="text-center">Active</th>
				        <th class="text-center">QRCode</th>
				        <th class="text-center">Block</th>
				      </tr>
				    </thead>
				    <tbody style="background-color: #eee;" id="services">

				    <?php

				   if(isset($_REQUEST['id'])){
					  $id=$_REQUEST['id'];
					  mysqli_query($db,"UPDATE users SET is_active = '0' WHERE id = '$id' ");
					}

						if($_POST){
		if(isset($_POST['search']) && $_POST['search'] != ''){
			$search .= "users.mobile_number LIKE '".$_POST['search']."%'";
		}
		
		if($search != ''){
			$query=mysqli_query($db,"select count(id) from `users` WHERE $search");
		}else{
			$query=mysqli_query($db,"select count(id) from `users`");
		}
	}else{
		$query=mysqli_query($db,"select count(id) from `users`");
	}
	$row = mysqli_fetch_row($query);
 	// print_r($row);die;
	$rows = $row[0];
 	$requestscount = $rows;
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

				        $search = '';
				    	$search .= "users.mobile_number Like '".$_POST['search']."%'";

					    if($search != ''){
				            $sql = "SELECT * FROM users WHERE $search $limit";
					    }else{
				            $sql = "SELECT * FROM users $limit"; 
				        }



			        	$result = mysqli_query($db, $sql);





			        	 	$paginationCtrls = '<ul>';
 	
 	if($last != 1){
 
	if ($pagenum > 1) {
        $previous = $pagenum - 1;
		$paginationCtrls .= '<li class="pagination-arrow"><a href="'.$_SERVER['PHP_SELF'].'?pn='.$previous.'" class="btn btn-default"><i class="icon-material-outline-keyboard-arrow-left"></i></a></li>';
 
		for($i = $pagenum-4; $i < $pagenum; $i++){
			if($i > 0){
		        $paginationCtrls .= '<li><a href="'.$_SERVER['PHP_SELF'].'?pn='.$i.'">'.$i.'</a></li>';
			}
	    }
    }
 	
 	$paginationCtrls .= '<li><a href="javascript:;">'.$pagenum.'</a></li>';
 
	for($i = $pagenum+1; $i <= $last; $i++){
		$paginationCtrls .= '<li><a href="'.$_SERVER['PHP_SELF'].'?pn='.$i.'">'.$i.'</a></li>';
		if($i >= $pagenum+4){
			break;
		}
	}
 
    if ($pagenum != $last) {
        $next = $pagenum + 1;
        $paginationCtrls .= ' <li class="pagination-arrow"><a href="'.$_SERVER['PHP_SELF'].'?pn='.$next.'"><i class="icon-material-outline-keyboard-arrow-right"></i></a></li>';
    }
	}




						If($result){
							$con = 1;

							If(mysqli_num_rows($result)>0)
                            {
                            	while($value=mysqli_fetch_array($result, MYSQLI_ASSOC))
                                {
			            ?> 
				    			<tr>
					    			<td><?php echo $con ?></td>
					    			<td><?php echo $value['username'];?></td>
					    			<td><?php echo $value['mobile_number']?></td>
					    			<td><?php echo $value['device_id']?></td>
					    			<td><span class="<?php echo ($value['is_active'] == '0') ? 'nosucc' : 'succ';?>">
					    				<?php echo $value['is_active'];?></span></td>
					    				
					    			<td><?php 
						    			$sql1 = "SELECT * FROM users_to_qr_codes where user_id=".$value['id'];
							            $results = mysqli_query($db, $sql1);
							            while ($valuee = @mysqli_fetch_array($results)) {

							            	$sql2 = "SELECT * FROM qr_codes where id=".$valuee['qr_code_id'];
							            	   $result1 = mysqli_query($db, $sql2);
							                       while ($valueee = @mysqli_fetch_array($result1)) {


						                echo $valueee['qr_code'] ?><?php  echo ($valuee['user_id'] >= '2') ? ',' : '|'?>
					    		        <?php } } ?>
					    		    </td>


					    		<td class="text-center">
					    			<?php 
                                        if($value['is_active'] == '1'){ ?>

                                        	<button onclick="archiveFunction2('<?php SITE_URL ?>userlist.php?id=<?php echo $value['id'] ?>')" id="<?php SITE_URL ?>userlist.php?id=<?php echo $value['id'] ?>" class="button" style="background-color:#d93a21;width: 60px !important;height: 45px;" type="submit" ><i class="icon-material-outline-lock"></i>
										</button>

										<?php

                                        }else{ ?>

                                        	<button onclick="archiveFunction('<?php echo $value['id'] ?>')" id="<?php echo $value['id'] ?>" class="button" style="background-color:green;width: 60px !important;height: 45px;" type="submit" class="btn ripple-infinite btn-round btn-primary" ><i class="icon-material-outline-lock-open"></i>
										</button>
                                        <?php  }  ?>
					    			 </td>
											       
					    		</tr>
					    		
				    	<?php $con++;} }else{ ?>
				    		<tr>
				    			<td colspan="8"><center>No Record Found!</center></td>
				    		</tr> 
				    	<?php } }?>
				    	
				    </tbody>
				  </table>
			</div>	

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
		
			
			<?php include('footer.php');?>
		</div>
	</div>
	<!-- Dashboard Content / End -->

</div>
<!-- Dashboard Container / End -->

</div>



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
    <script src="js/sweetalert.min.js"></script>
<script type="text/javascript">

  function archiveFunction2(id) {
  event.preventDefault(); // prevent form submit
  var form = event.target.form; // storing the form
          swal({
    title: "Are you sure?",
    text: "are you sure you want to block this user.",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: "#DD6B55",
    confirmButtonText: "Yes continue !",
    cancelButtonText: "No, cancel please!",
    closeOnConfirm: false,
    closeOnCancel: false
  },
  function(isConfirm){
    if (isConfirm) {
      swal("Good job!", "Blocked User!", "success");
      $.ajax({
      url: ''+id,
      type: 'POST',
      success: function(results){
        console.log("results::",results);
            location.reload(); // then reload the page.(3)
      }
    }); 
    } else {
      swal("Cancelled", "Request Cancelled!", "error");
    }
  });
  } 

</script>
<script type="text/javascript">

function archiveFunction(id) {
	event.preventDefault(); // prevent form submit
	var form = event.target.form; // storing the form
	        swal({
	  title: "Are you sure unblock user?",
	  text: "are you sure you want to unblock this user.",
	  type: "warning",
	  showCancelButton: true,
	  confirmButtonColor: "#DD6B55",
	  confirmButtonText: "Yes continue !",
	  cancelButtonText: "No, cancel please!",
	  closeOnConfirm: false,
	  closeOnCancel: false
	},
	function(isConfirm){
	  if (isConfirm) {
	  	swal("Good job!", "Blocked User!", "success");
	    console.log("ID:::",id);
	    $.ajax({
			url: '<?php echo URL;?>/adm_services/service.php?service=unblockuser&id='+id,
			type: 'POST',
			success: function(results){
				console.log("results::",results);
		        location.reload(); // then reload the page.(3)
			}
		});	     
	  } else {
	    swal("Cancelled", "Request Cancelled!", "error");
	  }
	});
}	
</script>
<script>
	$('#category').on('change', function() {
	  	var subcategory = document.getElementById("subcategory");
		  for (var i = 0; i < subcategory.length; i++){
		   
		    	var option = subcategory.options[i];
		    	$(option).hide();
		    	$('.s-'+this.value).show();
		    	if(this.value == 'all'){
		    		$(option).show();
		    	}
		  }
	});
</script>
<script>
$(function(){

})
function triggerDashboard(){
	$('.trigger-title').trigger('click');
}
</script>



</body>
</html>