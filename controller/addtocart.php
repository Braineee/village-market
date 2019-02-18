<?php
//get the configuration for the local server
require_once ("../config/Config.php");
require_once (ROOT_PATH . "core/init.php");

if (empty($_SESSION['security_token'])) {
    $_SESSION['security_token'] = bin2hex(random_bytes(32));
}

header('Content-Type: application/json');

$headers = apache_request_headers();
if (isset($headers['CsrfToken'])) {
    if (!hash_equals($headers['CsrfToken'], $_SESSION['security_token'])) {
        exit(json_encode(['error' => 'Wrong CSRF token.']));
    }
} else {
    exit(json_encode(['error' => 'No CSRF token.']));
}

if(isset($_POST)){

    extract($_POST);

    $is_exists = false;

    //create a new array of products

    // create a new cart id and push product to cart id

    if(isset($_SESSION['cart'])){

        //get the price of the item
        $get_price = DB::getInstance()->get("products", array("product_id","=",$id));
        if($get_price->error() == true){
            die('please reload this page');
        }

        //tranfer the the array_count_values
        $get_all_details = $get_price->first();

        //if quantity does not exist let quantity be 1
        if(!isset($quantity)){
            $quantity = 1;
        }

        // check if there is an offer on this product
        $bonus_item_check = DB::getInstance()->get('offers', array('product_id', '=', $id));
        if($bonus_item_check->error() == true){
            die('please reload this page');
        }
        if($bonus_item_check->count() > 0){
          $item_price = $bonus_item_check->first()->bonus_price;
        }else{
          $item_price = $get_all_details->product_price;
        }

        //instanciate the product array
        $item = array(
          'ID' => $get_all_details->product_id,
          'Item_name' => $get_all_details->product_name,
          'Price' => $item_price,
          'picture' => $get_all_details->product_picture,
          'Quantity' => $quantity
        );


        for($i=0; $i< count($_SESSION['cart']); $i++){

            //chek if the item has been added previously
            if(intval($_SESSION['cart'][$i]['ID']) == intval($item['ID'])){
                //check to see if there is change in quantity
                if(intval($_SESSION['cart'][$i]['Quantity']) == intval($item['Quantity'])){
                    $is_exists = true;
                    break;
                }else{
                    //edit the quantity
                    $_SESSION['cart'][$i]['Quantity'] = $item['Quantity'];
                    $data =  'OK';
                    echo  json_encode($data);
                    die();
                }
            }
        }

        if($is_exists == false){
            //push the item to the 'cart' array
            array_push($_SESSION['cart'], $item);

            //var_dump($_SESSION['cart']);

            $data =  'OK';

            echo  json_encode($data);

        }else{

            $data =  'already_exist';

            echo  json_encode($data);

        }

    }else{

        //get the price of the item
        $get_price = DB::getInstance()->get("products", array("product_id","=",$id));
        if($get_price->error() == true){
            die('please reload this page');
        }

        //tranfer the the array_count_values
        $get_all_details = $get_price->first();

        //instanciate the 'cart' array
        $_SESSION['cart'] = array();

        //if quantity does not exist let quantity be 1
        if(!isset($quantity)){
            $quantity = 1;
        }

        // check if there is an offer on this product
        $bonus_item_check = DB::getInstance()->get('offers', array('product_id', '=', $id));
        if($bonus_item_check->error() == true){
            die('please reload this page');
        }
        if($bonus_item_check->count() > 0){
          $item_price = $bonus_item_check->first()->bonus_price;
        }else{
          $item_price = $get_all_details->product_price;
        }

        //instanciate the product array
        $item = array(
          'ID' => $get_all_details->product_id,
          'Item_name' => $get_all_details->product_name,
          'Price' => $item_price,
          'picture' => $get_all_details->product_picture,
          'Quantity' => $quantity
        );


        for($i=0; $i< count($_SESSION['cart']); $i++){

            //chek if the item has been added previously
            if(intval($_SESSION['cart'][$i]['ID']) == intval($item['ID'])){
                //check to see if there is change in quantity
                if(intval($_SESSION['cart'][$i]['Quantity']) == intval($item['Quantity'])){
                    $is_exists = true;
                    break;
                }else{
                    //edit the quantity
                    $_SESSION['cart'][$i]['Quantity'] = $item['Quantity'];
                    $data =  'OK';
                    echo  json_encode($data);
                    die();
                }
            }
        }

        if($is_exists == false){
            //push the item to the 'cart' array
            array_push($_SESSION['cart'], $item);

            //var_dump($_SESSION['cart']);

            $data =  'OK';

            echo  json_encode($data);

        }else{

            $data =  'already_exist';

            echo  json_encode($data);

        }

    }

}
