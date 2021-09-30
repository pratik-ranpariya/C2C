<?php
include("v1/config.php");

if(!isset($_SESSION['logged_in'])){
	header('Location: '.URL.'admin/login');
}
?>