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
        die();
    }
} else {
    exit(json_encode(['error' => 'No CSRF token.']));
    die();
}

// check if the there is a request
if(!isset($_POST)){
  exit(json_encode(['error' => 'No request sent.']));
  die();
}

// get the values of the request
extract($_POST);

//check if the post request has a form tokens
if(!isset($form_token)){
  exit(json_encode(['error' => 'Form token not found.']));
  die();
}

//validate the form-tokens
$secrete_key = hash_hmac('sha256', Token::generate_unique('subscribe'), $_SESSION['security_token']);
if(!hash_equals($secrete_key, $form_token)){
  exit(json_encode(['error' => 'Wrong form token.']));
  die();
}

// validate the inputs
if(!isset($email_) && $email_ == ''){
  exit(json_encode(['error' => 'Please enter your email address.']));
  die();
}

try{

  //check if the mail already exists
  $get_mail = DB::getInstance()->get('subscribed_to_news_letter', array('customer_email', '=', $email_));
  if($get_mail->count() > 0){
    exit(json_encode(['error' => 'This email address has been subscribed already.']));
    die();
  }

}catch(Exception $e){
  exit(json_encode(['error' => 'Could not check if email is subscribed already.']));
  die($e->getMessage());
}


try{

  //save the email address
  $save_email = new Crud();
  $save_email->create('subscribed_to_news_letter', array(
    'customer_email' => $email_
  ));

  exit(json_encode(['success' => 'You have successfully subscribed to our newsletter.']));

}catch(Exception $e){

  exit(json_encode(['error' => 'Could not subscribe email.']));

}
