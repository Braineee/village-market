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
            $secrete_key = hash_hmac('sha256', Token::generate_unique('update_pass'), $_SESSION['security_token']);

            if(hash_equals($secrete_key, $form_token)){

              $validation_error = false;
              //sanitize the inputs and check if the inputs are not empy strings
              foreach($_POST as $key => $value){
                // sanitze the inputs
                //if($key != '')
                $sanitized_value = filter_var($value, FILTER_SANITIZE_STRING);
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
                  //get the old password_
                  $old_password = DB::getInstance()
                  ->get('customers',array('customer_id','=',$_SESSION['user_id']));

                  // update customer details, update if change occurs
                  if($old_password->first()->password === Hash::make($password, $old_password->first()->salt)){
                    if($new_password == $con_password){
                      $salt = Hash::salt(32);
                      $real_password = Hash::make($new_password, $salt);
                      $update_customer = new Crud();
                      $update_customer
                      ->update('customers','customer_id',$_SESSION['user_id'], array(
                        "Password" =>  $real_password,
                        "Salt" =>  $salt,
                      ));
                      Session::flash('home','Your password has been updated successfully');
                      exit(json_encode(['response' => 'updated']));
                    }else{
                      exit(json_encode(['response' => 'The password you did not match please confirm']));
                    }
                  }else{
                    exit(json_encode(['response' => 'The password you entered is incorrect']));
                  }
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
