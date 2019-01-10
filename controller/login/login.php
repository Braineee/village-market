<?php
require_once ("../../config/Config.php");
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
            $secrete_key = hash_hmac('sha256', Token::generate_unique('login'), $_SESSION['security_token']);

            if(hash_equals($secrete_key, $form_token)){

                $email = sanitize($email, 'string');
                $password = sanitize($password, 'string');

                if(isset($email) && isset($password)){

                    if( $email != " " && $password != " "){

                        $user = new User();

                        $login = $user->login($email, $password, $remember = true);

                        exit(json_encode(['response' => $login]));
                    }else{
                        exit(json_encode(['response' => 'Please enter your email and password']));
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

?>
