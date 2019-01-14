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
    }
} else {
    exit(json_encode(['error' => 'No CSRF token.']));
}

try{
  //prepare query
  $query = "
    SELECT products.*, ref_product_category.* FROM Products
    INNER JOIN ref_product_category ON products.product_category = ref_product_category.category_code
    ORDER BY products.product_id ASC
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
        'product_price' => $products->product_price
    ];
  }
  exit(json_encode(['data' => $json, 'count' => $get_list_of_products->count()]));

}catch(Exception $e){
  die($e->getMessage());
}
