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

// flag product as out of stock
try{
  $paid_order = new Crud();
  $paid_order->update('orders','order_id',$id, array('order_status_code' => 2));

  //get the orders
  $get_order = DB::getInstance()->get('orders', array('order_id','=',$id));
  $order_id = $get_order->first();

  //mark the payment datefmt_create
  $mark_payment = new Crud();
  $paid_order->
  create('payments', array(
      'order_id' => $id,
      'payment_date' => date('Y-m-d'),
      'payment_amount' => $order_id->total,
      'payment_status' => 2,
      'staff_id' => $_SESSION['admin_id']
  ));

  Session::flash('paid', 'Order has been flagged as paid successfully!');

  exit(json_encode(['paid']));

}catch(Exception $e){
  die($e->getMessage());
}
