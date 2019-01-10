<?php
// MAIL RESPONDER
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require '../../vendor/autoload.php';


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
            $secrete_key = hash_hmac('sha256', Token::generate('reset'), $_SESSION['security_token']);
            if(hash_equals($secrete_key, $form_token)){

                if(isset($_POST['email']) && isset($_POST['number'])){
                    if( $_POST['email'] != " " && $_POST['number'] != " "){

                        //check if the email exists
                        $query = "SELECT * FROM users WHERE email LIKE '$email'";
                        $get_user = DB::getInstance()->query($query);

                        if($get_user->error() == false){

                            if($get_user->count() > 0){

                                //validate the captcha
                                if(isset($_SESSION['captcha_phrase'])){

                                    if($_SESSION['captcha_phrase'] == $number){

                                        // create password reset token
                                        $userId = $get_user->first()->UserId;
                                        $name = $get_user->first()->Firstname;
                                        $email = $get_user->first()->Email;
                                        $token = md5(rand(10,100));

                                        try{
                                            // add the token to the database
                                            $save_token = new Crud();
                                            $save_token->create('password_reset', array(
                                                "email"		    => 	$email,
                                                "token"		    =>	$token,
                                                "created_at"	=>	date('Y-m-d')
                                            ));

                                            // log the event 
                                            $obj = new OS_BR();
                                            $audit = new Crud();
                                            try{
                                                $audit->create('audit_trail', array(
                                                    "user_id"           =>  $userId,
                                                    "event"             =>  'Generated password reset token',
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

                                            // send the password reset mail
                                            include('reset_mail.php');
                                    
                                            try{
                                                                                    
                                                $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
                                                try {
                                                    //Server settingsde
                                                    //$mail->SMTPDebug = 0;                                 // Enable verbose debug output
                                                    $mail->isSMTP();                                      // Set mailer to use SMTP
                                                    $mail->Host = 'server237.web-hosting.com';  // Specify main and backup SMTP servers
                                                    $mail->SMTPAuth = true;                               // Enable SMTP authentication
                                                    $mail->Username = 'support@saucebooks.com';                 // SMTP username
                                                    $mail->Password = 'davidontop2014';                           // SMTP password
                                                    $mail->SMTPSecure = 'tls';                           // Enable TLS encryption, `ssl` also accepted
                                                    $mail->Port =  587;                                    // TCP port to connect to

                                                    //Recipients
                                                    $mail->setFrom('support@saucebooks.com', 'Saucebooks');
                                                    $mail->addAddress($email, $name);     // Add a recipient
                                                    $mail->addReplyTo('support@saucebooks.com', 'Reply');

                                                    //Content
                                                    
                                                    // Set email format to HTML
                                                    //$mail->MsgHTML('HTML code');// Message body                                 
                                                    $mail->Subject = 'Saucebooks account password reset';
                                                    $mail->Body    = $mail_message;
                                                    $mail->isHTML(true); 
                                                    

                                                    $mail->send();

                                                    $data['response'] = 'true';
                                                    echo  json_encode($data);


                                                } catch (Exception $e) {
                                                    $data['response'] = 'Message could not be sent. Mailer Error: '. $mail->ErrorInfo;
                                                    echo  json_encode($data);
                                                }

                                            }catch(Exception $e){
                                                die($e->getMessage());
                                            }

                                        }catch(Exception $e){
                                            die($e->getMessage());
                                        }

                
                                    }else{

                                        $data['response'] = 'The code you entered does not match the code displayed in the box below.';
                                        echo  json_encode($data);

                                    }

                                }else{

                                    echo 'captcha not found';

                                }

                            }else{

                                $data['response'] = 'This user was not found';
                                echo  json_encode($data);

                            }

                        }else{
                            $error['query_name'] = "get_user";
                            $error['error_msg'] = $get_inventory->error_message();
                            echo json_encode($error);
                            die();
                        }

                    }else{
                        $data['response'] = 'Please enter your email and code';
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