<?php
//get the configuration for the local server
$_SERVER["DOCUMENT_ROOT"] = "C:/xampp/htdocs/smartbookz";
require_once ($_SERVER["DOCUMENT_ROOT"] . "/config/Config.php");
require_once (ROOT_PATH . "core/init.php"); 

if(Input::exists()){
    if(isset($_POST['crsf_token']) && isset($_POST['form_token'])){
        //extract post
        extract($_POST);
        //validate the session token
        if(hash_equals($_SESSION['security_token'], $crsf_token)){
            //validate the form-tokens
            $secrete_key = hash_hmac('sha256', Token::generate('change_password'), $_SESSION['security_token']);
            if(hash_equals($secrete_key, $form_token)){



                // check if the input is not empty
                if(isset($_POST['confirm_password']) && isset($_POST['password']) && isset($_POST['password_reset_token'])){
                    if( $_POST['confirm_password'] != " " && $_POST['password'] != " " && $_POST['password_reset_token'] != " "){

                        // check if the password matches 
                        if($confirm_password == $password){
                            //validate the reset token
                            $query = "SELECT * FROM password_reset 
                                      INNER JOIN users ON password_reset.email = users.Email
                                      WHERE token like '$password_reset_token' AND used = 0";

                            $find_token = DB::getInstance()->query($query);
                            if($find_token->error() == false){
                                //check if there is a token for this request
                                if($find_token->count() > 0){
                                    /**
                                     * Process the request
                                     */
                                    $salt = Hash::salt(32);
                                    $password = Hash::make($password, $salt);
                                    $userId = $find_token->first()->UserId;
                                    $email = $find_token->first()->email;

                                    try{
                                        //update the new password
                                        $user = new User();
                                        //var_dump($userId);
                                        //var_dump($salt);
                                        $user->update('UserId', $userId, array(
                                            "Password"			=> 	$password,
                                            "Salt"				=>	$salt
                                        ));

                                        //update the token
                                        $password_reset = new Crud();

                                        $password_reset->update('password_reset','token', '"'.$password_reset_token.'"', array(
                                            "used"	=>	1
                                        ));
                                        
                                        //log the details of approval
                                        $obj = new OS_BR();
                                        $audit = new Crud();
                                        try{
                                            $audit->create('audit_trail', array(
                                                                "user_id"           =>  $userId,
                                                                "event"             =>  'Changed Password',
                                                                "ip"                =>  $obj->get_client_ip_env(),
                                                                "os"                =>  $obj->showInfo('os'),
                                                                "browser"           =>  $obj->showInfo('browser'),
                                                                "browser_version"   =>  $obj->showInfo('version'),
                                                                "url"               =>  'https:/'.$_SERVER['REQUEST_URI'],
                                                                "date"              =>  date('Y-m-d'),
                                                                "time"              =>  date('H:i a')
                                                           ));
                                        }catch(Exception $e){
                                            die($e->getMessage());
                                        }

                                        $data['response'] = 'updated';
                                        echo  json_encode($data);

                                    }catch(Exception $e){
                                        die($e->getMessage());
                                    }

                                }else{
                                    $data['response'] = 'This token has been used';
                                    echo  json_encode($data);
                                }
                            }else{
                                $data['response'] = 'There was an error proccessing this request';
                                echo  json_encode($data);
                            }

                        }else{
                            $data['response'] = 'The password you re-entered does not match the new password';
                            echo  json_encode($data);
                        }
                        
                    }else{
                        $data['response'] = 'Please enter your new password and confirm the password again';
                        echo  json_encode($data);
                    }
                }else{
                    $data['response'] = 'Please fill in the required fields';
                    echo  json_encode($data);
                }



            }else{
                die('Sorry!..Please Reload this page.');
            }
        }else{
            Redirect::to('?pg=login');
        }
    }else{
        Redirect::to('?pg=login');
    }
}else{
	$data['response']= 'input was not found';
	echo json_encode($data);
}
?>