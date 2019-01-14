<?php
//get the configuration for the local server
require_once ("config/Config.php");
require_once (ROOT_PATH . "core/init.php");

if (!isset($_GET["pg"]) || $_GET["pg"] == ""){
    $_GET["pg"] = "dashbaord";
}

$user = new User(); //current user

// TODO! : check if the user is logged in
if($user->isLoggedin()){
    $user_id = $user->data()->customer_id;

    $_SESSION['user_id'] = $user_id;
}

// Check if pg exits
if (isset($_GET["pg"])){
    //If pg exists, assign its value to $page_name
    $page_name = $_GET["pg"];
}

// include the header file
include(ROOT_PATH . "inc/head.php");

//include the navbar
include(ROOT_PATH . "inc/navbar.php");

//include the sidebar
include(ROOT_PATH . "inc/sidebar.php");

//check the file
$filename = ROOT_PATH ."pages/" . $page_name . ".php";

if (file_exists($filename)) {
    // Pass the $page_name to the include path bellow
    include(ROOT_PATH . "pages/". $page_name .".php");
}else{
    include(ROOT_PATH . "pages/not_found.php");
}

//include footer
include(ROOT_PATH . "inc/footer.php");
