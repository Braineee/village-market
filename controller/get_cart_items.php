<?php
//get the configuration for the local server
require_once ("../config/Config.php");
require_once (ROOT_PATH . "core/init.php");

if(isset($_SESSION['cart'])){
    $total = 0;

    for($i=0; $i< count($_SESSION['cart']); $i++){

        if(isset($_SESSION['cart'][$i])){
            $price = $_SESSION['cart'][$i]['Price'];

            $_Price = intVal($price) * intVal($_SESSION['cart'][$i]['Quantity']);

            $total = $total + $_Price;

            $json[] = [

                'ID' => $_SESSION['cart'][$i]['ID'],

                'Item_name' => $_SESSION['cart'][$i]['Item_name'],

                'Price' => number_format($_SESSION['cart'][$i]['Price']),

                'picture' => $_SESSION['cart'][$i]['picture'],

                'Quantity' => $_SESSION['cart'][$i]['Quantity'],

                'totalcost' => number_format($_Price)

            ];
        }
    }

    if(isset($json)){
        $data['data'] = $json;
    }

    $data['count'] = $i;

    $data['total'] = number_format($total);

    echo json_encode($data);

}
