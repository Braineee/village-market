<!DOCTYPE html>
<html lang="en">
<head>
	<title>Product Detail</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php
		$token = $_SESSION['security_token'];
	?>
	<meta name="csrf-token" content="<?= $_SESSION['security_token'] ?>">
<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="images/icons/favicon.png"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>assets/vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>assets/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>assets/css/fonts/themify/themify-icons.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>assets/css/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>assets/css/fonts/elegant-font/html-css/style.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>assets/vendor/animate/animate.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>assets/vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>assets/vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>assets/vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>assets/vendor/slick/slick.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>assets/css/util.css">
	<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>assets/css/main.css">
<!--===============================================================================================-->
<!-- JQUERY AND JAVASCRIPT -->
<!--===============================================================================================-->
	<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/vendor/jquery/jquery-3.2.1.min.js"></script>
</head>
<!-- print styling -->
<style>
@media print{
	body{
		font-size: 11px;
	}
	.dashboard_content{
		display: none;
	}
	footer{
		display: none;
	}
	.btn{
		display: none;
	}
	.dashboard_heading{
		display: none;
	}
	.btn-show-menu{
		display: none;
	}
	#print_nav{
		display: block;
	}

}
</style>
