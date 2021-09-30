<?php
include("v1/config.php");
session_start();
if(isset($_SESSION['logged_in']) == 'Y'){
    $_SESSION['layoutActive'] = 'active';    
    header('Location:'.URL.' userlist.php');

}
$errmsg="";
if (!empty($_POST))
{
    $db = mysqli_connect("localhost","root","","newmagic");

    $username =$_POST['username'];
    $password =$_POST['password'];
    $sql = "SELECT * FROM login_adminpanel WHERE username = '$username' AND password = '$password' ";

    $result = mysqli_query($db, $sql);

    // echo $result;
    if (@mysqli_num_rows($result) == 1)
    {
             $_SESSION['username']=$username;
             header('Location:'.URL.'userlist.php');
             $errmsg="sucess";
        
    }    
     else
    {
     $errmsg="Email or Password are incorrect!!!";
    }

    mysqli_close($db);
}

?>

<!doctype html>
<html lang="en">
<head>

<!-- Basic Page Needs
================================================== -->
<title>Dailyneeds | Login</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

<!-- CSS
================================================== -->
<link rel="stylesheet" href="css/style.css?v=1">
<link rel="stylesheet" href="css/colors/blue.css">
<style type="text/css">
@media(max-width:1099px) {
    #logo img {
        border: none;
        max-width: 160px !important;
        height: auto
    }
}    
</style>
</head>
<body class="gray">

<!-- Wrapper -->
<div id="wrapper">

<!-- Dashboard Container -->
<div class="dashboard-container">

    <!-- Dashboard Content
    ================================================== -->
    <div class="dashboard-content-container" data-simplebar>
        <div class="dashboard-content-inner" style="padding-top: 20px !important;">
            <!-- Row -->
            <div class="row">

                <!-- Dashboard Box -->
                <div class="col-xl-4 offset-xl-4" style="padding-left: 0px;padding-right: 0px;">
                    <div class="dashboard-box margin-top-0">

                        <!-- Headline -->
                        <div class="headline">
                            <h3><i class="icon-feather-folder-plus"></i> Admin Login Form</h3>
                        </div>

                        <div class="content with-padding padding-bottom-10">
                            <div class="row">

                            <form method="post" style="width: 200% !important">
                                <div class="col-xl-12">
                                    <div class="submit-field">
                                        <h5>Email</h5>
                                        <input type="name" class="with-border" name="username" id="emailaddress" placeholder="Enter UserName" required>
                                    </div>
                                </div>

                                <div class="col-xl-12">
                                    <div class="submit-field">
                                        <h5>Password</h5>
                                        <input type="password" class="with-border" name="password" id="password" placeholder="Enter Password" required>
                                    </div>
                                </div>
                                <?php $errmsg ?>

                                <div class="col-xl-12">
                                    <div class="submit-field">
                                        <button type="submit" class="button ripple-effect big margin-top-30">
                                            <i class="icon-feather-plus"></i>
                                             Login
                                        </button>
                                    </div>
                                </div>
                            </form>    

                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- Row / End -->



        </div>
    </div>
    <!-- Dashboard Content / End -->

</div>
<!-- Dashboard Container / End -->

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

</body>
</html>