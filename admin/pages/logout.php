<?php
//get the configuration for the local server
require_once ("config/Config.php");
require_once (ROOT_PATH . "core/init.php");

$user = new User(); // curent user
$user->logout();
session_destroy();

echo "<script> location.replace('?pg=login'); </script>";
