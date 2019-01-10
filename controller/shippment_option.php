<?php
//get the configuration for the local server
require_once ("../config/Config.php");
require_once (ROOT_PATH . "core/init.php");  

if(isset($_POST)){

    extract($_POST);
    if(isset($id)){

        $total = 0;
        $shippment_price = 0;

        try{
            //get the shippin method that matches this id
            $get_shippment_option = DB::getInstance()->get("shippment_option", array("shippment_option_code","=",$id));
            //get the price
            $shippment_price = $get_shippment_option->first()->shippment_option_price;

            // calculate item total in cart
            if(isset($_SESSION['cart'])){
                for($i=0; $i< count($_SESSION['cart']); $i++){
            
                    if(isset($_SESSION['cart'][$i])){
                        $price = $_SESSION['cart'][$i]['Price'];
            
                        $_Price = intVal($price) * intVal($_SESSION['cart'][$i]['Quantity']);
            
                        $total = $total + $_Price;
                    }
                }
            }else{
                //if cart doesn't exist return the shippment price to 0
                $shippment_price = 0;
            } 

            // calculate the grand total: add sipping price and total price of item (store in session Grand total)
            $grand_total = $total + $shippment_price;
            $_SESSION['grand_total'] = $grand_total;
            $_SESSION['shipping_option'] = $id;

            $data['total'] = $_SESSION['grand_total'];
            $data['response'] = 'OK';

            echo json_encode($data);

        }catch(Exception $e){
            die($e->getMessage());
        }
    }else{
        echo '2';
    }
}else{
    echo '1';
}