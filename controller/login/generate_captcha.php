<?php
use Gregwar\Captcha\CaptchaBuilder;

//Load Composer's autoloader
require '../../vendor/autoload.php';

//get the configuration for the local server
require_once ($_SERVER["DOCUMENT_ROOT"] . "/config/Config.php");
require_once (ROOT_PATH . "core/init.php"); 

try{
    $builder = new CaptchaBuilder;
    $builder->build();

    // save the captcha phrase
    $_SESSION['captcha_phrase'] = $builder->getPhrase();

    //save the captcha image
    $builder->save('captcha/out.jpg');

    echo 1;

}catch(Exception $e){
    var_dump($e);
}
