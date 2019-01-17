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
  SELECT orders.*, customers.*, ref_order_status_codes.* FROM orders
  INNER JOIN customers ON orders.customer_id = customers.customer_id
  INNER JOIN ref_order_status_codes ON orders.order_status_code = ref_order_status_codes.order_status_code
  ORDER BY orders.order_id ASC
  ";
  //run query
  $get_list_of_orders = DB::getInstance()->query($query);
  $list_of_orders = $get_list_of_orders->results();
  foreach($list_of_orders as $order){
    $json[] = [
        'id' => $order->order_id,
        'order_firstname' => $order->firstname,
        'order_lastname' => $order->lastname,
        'order_no_of_item' => $order->nos_of_item,
        'order_total_amount' => $order->total,
        'order_status' => $order->order_status_description,
        'order_date_placed' => $order->date_order_placed
    ];
  }
  exit(json_encode(['data' => $json, 'count' => $get_list_of_orders->count()]));

}catch(Exception $e){
  die($e->getMessage());
}
