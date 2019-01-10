<?php
//get the configuration for the local server
require_once ("../config/Config.php");
require_once (ROOT_PATH . "core/init.php");

if(isset($_POST)){

    extract($_POST);

    $has_delete = false;

    if(isset($id)){
        //hand over the cart items
        $temporal_cart = array();
        $temporal_cart = $_SESSION['cart'];

        //clear the session cart
        $_SESSION['cart'] = array();

        //loop over the temp cart
        for($i=0; $i< count($temporal_cart); $i++){
            //if the requeted remove id is not equal to the temporal cart id add it to the sesssion cart
            if(intval($temporal_cart[$i]['ID']) != intval($id)){
                //instanciate the product array
                $item = array('ID' => $temporal_cart[$i]['ID'], 'Item_name' => $temporal_cart[$i]['Item_name'], 'Price' => $temporal_cart[$i]['Price'], 'picture' => $temporal_cart[$i]['picture'], 'Quantity' => $temporal_cart[$i]['Quantity']);
                //push the item to the 'cart' array
                array_push($_SESSION['cart'], $item);
            }
        }

        if(count($_SESSION['cart']) < count($temporal_cart)){
            $temporal_cart = array();
            $has_delete = true;
        }else{
            $temporal_cart = array();
        }

        if($has_delete == true){

            $data =  'OK';

            echo  json_encode($data);

        }else{

            $data =  'could_not_find_item';

            echo  json_encode($data);

        }
    }
}
