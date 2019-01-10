<?php
//get the configuration for the local server
require_once ("../config/Config.php");
require_once (ROOT_PATH . "core/init.php");


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

        //if quantity does not exist let quantity be 1
        if(!isset($quantity)){
            $quantity = 1;
        }

        //instanciate the product array
        $item = array(
          'ID' => $get_price->first()->product_id,
          'Item_name' => $get_price->first()->product_name,
          'Price' => $get_price->first()->product_price,
          'picture' => $get_price->first()->product_picture,
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

        //instanciate the 'cart' array
        $_SESSION['cart'] = array();

        //if quantity does not exist let quantity be 1
        if(!isset($quantity)){
            $quantity = 1;
        }

        //instanciate the product array
        //instanciate the product array
        $item = array(
          'ID' => $get_price->first()->product_id,
          'Item_name' => $get_price->first()->product_name,
          'Price' => $get_price->first()->product_price,
          'picture' => $get_price->first()->product_picture,
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
