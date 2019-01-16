<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <?php
  		$token = $_SESSION['admin_security_token'];
  	?>
  	<meta name="csrf-token" content="<?= $_SESSION['admin_security_token'] ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../../../favicon.ico">

    <title>Dashboard Template for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>assets/css/main.css">
    <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>assets/css/sweetalert.css">
    <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>assets/css/toastr.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>assets/fonts/css/font-awesome.min.css">

    <script type="text/javascript" src="<?= BASE_URL; ?>assets/js/jquery-3.2.1.min.js"></script>
  </head>
