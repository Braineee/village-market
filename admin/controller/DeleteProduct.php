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

//delete the material
try{
  $delete_product = new Crud();
  $delete_product->delete('products', 'product_id', $id);
  exit(json_encode(['deleted']));
}catch(Exception $e){
  die($e->getMessage());
}
