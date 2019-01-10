<?php
    // redirect to dahboard if the user is logged in already
    if($user->isLoggedin()){
        header("location:?pg=dashboard");
    }
    // check if there is a token attached to this request
    if(isset($_GET['token'])){
        //validate the token
        $token__ = $_GET['token'];
        $query = "SELECT * FROM password_reset WHERE token like '$token__' AND used = 0";
        $find_token = DB::getInstance()->query($query);
        if($find_token->error() == false){
            //check if there is a token for this request
            if($find_token->count() > 0){
                /**
                 * Allow the person to stay on this page
                 */
            }else{
                Redirect::to('?pg=login'); // send user to login page
            }
        }else{
            die('Oops!, Error found.');
        }
    }else{
        Redirect::to('?pg=login'); // send user to login page
    }
?>
<body style="background-color:#fff;  background-repeat: no-repeat; background-size: cover;" class="login-body">
<div class="wrapper-login fadeInDown">
  <div id="formContent">

    <!-- Icon --> <br><br>
    <div class="fadeIn first">
        <img src="assets/img/smartbook_logo.png" width="40%" alt="smartbookz Logo">
    </div><br>
    <!-- message div-->
    <div id="message">
    </div>
    <!-- Login Form -->
    <form role="form">
      <input type="password" id="password" class="login-input fadeIn second" name="password" placeholder="Enter your new password"><br>
      <span class='wrong-password'></span>
      <input type="password" id="confirm_password" class="login-input fadeIn second" name="confirm_password" placeholder="Re-enter your password again"><br>
      <span class='wrong-confirm_password'></span><br>
      <input type="hidden" id="form_token" name="form_token" value="<?php echo hash_hmac('sha256', Token::generate('change_password'), $token); ?>">
      <input type="hidden" id="password_reset_token" name="password_reset_token" value="<?php echo $token__; ?>">
      <button type="submit" id="change_password" class="button_login fadeIn fourth" value="Reset Password">CHANGE PASSWORD</button>
    </form>

    <!-- Remind Passowrd -->
    <div id="formFooter">
      <a class="underlineHover login-a" href="?pg=login">Login</a>
    </div>

  </div>
</div>
<script src="<?php echo BASE_URL; ?>ajax/reset_password.js"></script>