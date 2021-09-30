<?php
if(!isset($_SESSION['logged_in']) && !isset($_SESSION['id'])){
	header('Location: '.SITE_URL);
}
?>