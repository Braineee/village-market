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
    SELECT customers.*, ref_states_code.* FROM customers
    INNER JOIN ref_states_code ON customers.state_id = ref_states_code.state_id
    ORDER BY customers.customer_id ASC
  ";
  //run query
  $get_list_of_customers = DB::getInstance()->query($query);
  $list_of_customers = $get_list_of_customers->results();
  foreach($list_of_customers as $customers){
    $json[] = [
        'id' => $customers->customer_id,
        'customer_firstname' => $customers->firstname,
        'customer_lastname' => $customers->lastname,
        'customer_phone' => $customers->phone,
        'customer_email' => $customers->email,
        'customer_state' => $customers->state,
        'customer_username' => $customers->username,
        'customer_address' => $customers->address
    ];
  }
  exit(json_encode(['data' => $json, 'count' => $get_list_of_customers->count()]));

}catch(Exception $e){
  die($e->getMessage());
}
