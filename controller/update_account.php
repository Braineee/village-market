<?php
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
        //extract post
        extract($_POST);
        //validate the session token
        if(isset($form_token)){
            //validate the form-tokens
            $secrete_key = hash_hmac('sha256', Token::generate_unique('update_details'), $_SESSION['security_token']);

            if(hash_equals($secrete_key, $form_token)){

              $validation_error = false;
              //sanitize the inputs and check if the inputs are not empy strings
              foreach($_POST as $key => $value){
                // sanitze the inputs
                $sanitized_value = sanitize($value, 'string');
                //check if the value is not Empty
                if($sanitized_value != ''){//replace the post value with the sanitizes value
                  $_POST[$key] = $sanitized_value;
                }else{
                  $validation_error = true;
                }
              }

              extract($_POST);
              
              if($validation_error == false){
                try{
                  // update customer details, update if change occurs
                  $update_customer = new Crud();
                  $update_customer
                  ->update('customers','customer_id',$_SESSION['user_id'], array(
                    'firstname' => $firstname,
                    'lastname' => $lastname,
                    'phone' => $phone,
                    'address' => $address,
                    'state_id' => $state
                  ));
                  Session::flash('home','Your details has been updated successfully');
                  exit(json_encode(['response' => 'updated']));

                }catch(Exception $e){
                  die($e->getMessage());
                }
              }else{
                  exit(json_encode(['response' => 'Please fill in the required fields']));
              }
            }else{
                exit(json_encode(['error' => 'wrong from token.']));
            }
        }else{
            exit(json_encode(['error' => 'no form token.']));
        }
}else{
	exit(json_encode(['error' => 'input was not found.']));
}
