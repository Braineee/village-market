<?php
//get the configuration for the local server
require_once ("../config/Config.php");
require_once (ROOT_PATH . "core/init.php");  


if(isset($_SESSION['cart'])){

    $cart_count = count($_SESSION['cart']);

    $count =  $cart_count;
        
    echo  json_encode($count);
    
}
