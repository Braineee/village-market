<?php
require_once ("../config/Config.php");
require_once (ROOT_PATH . "core/init.php");


if (empty($_SESSION['admin_security_token'])) {
    $_SESSION['admin_security_token'] = bin2hex(random_bytes(32));
}

header('Content-Type: application/json');

$headers = apache_request_headers();
if (isset($headers['CsrfToken'])) {
    if (!hash_equals($headers['CsrfToken'], $_SESSION['admin_security_token'])) {
        exit(json_encode(['error' => 'Wrong CSRF token.']));
        die();
    }
} else {
    exit(json_encode(['error' => 'No CSRF token.']));
    die();
}

//check if there is an id
if(!isset($_POST['id'])){
  exit(json_encode(['error' => 'No ID Specified.']));
  die();
}

//sanitize the inputes
$id = sanitize($_POST['id'], 'int');

if($id == ""){
  exit(json_encode(['error' => 'Invalid ID.']));
  die();
}

// get the product by this id
try{
  //prepare query
  $query = "
    SELECT products.*, ref_product_category.* FROM Products
    INNER JOIN ref_product_category ON products.product_category = ref_product_category.category_code
    WHERE products.product_id = {$id}
  ";
  //run query
  $get_list_of_products = DB::getInstance()->query($query);
  $list_of_products = $get_list_of_products->results();
  foreach($list_of_products as $products){
    $json[] = [
        'id' => $products->product_id,
        'product_name' => $products->product_name,
        'product_description' => $products->product_description,
        'product_category' => $products->category_name,
        'product_price' => $products->product_price,
        'product_picture' => $products->product_picture
    ];
  }
  exit(json_encode(['data' => $json, 'count' => $get_list_of_products->count()]));

}catch(Exception $e){
  die($e->getMessage());
}
