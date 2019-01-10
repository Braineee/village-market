<?php
    // redirect to dahboard if the user is logged in already
    if($user->isLoggedin()){
        header("location:?pg=dashboard");
    }
?>
<body style="background-color:#fff;  background-repeat: no-repeat; background-size: cover;" class="login-body">
<div class="wrapper-login fadeInDown">
  <div id="formContent">

    <!-- Icon --> <br><br>
    <div class="fadeIn first">
        <img src="assets/img/smartbook_logo.png" width="40%" alt="smartbookz Logo">
    </div><br>
    <h2 class="login-h2">Password Recovery</h2><br><br>
    <!-- message div-->
    <div id="message">
    </div>
    <!-- Login Form -->
    <form role="form">
      <input type="text" id="email" class="login-input fadeIn second" name="email" placeholder="email"><br>
      <span class='wrong-email'></span>
      <input type="text" id="number" class="login-input fadeIn second" name="number" placeholder="confirm code below"><br>
      <span class='wrong-password'></span><br><br>
      <div id="captcha"></div><br>
      <input type="hidden" id="form_token" name="form_token" value="<?php echo hash_hmac('sha256', Token::generate('reset'), $token); ?>">
      <button type="submit" id="get_password" class="button_login fadeIn fourth" value="Reset Password">RESET PASSWORD</button>
    </form>

    <!-- Remind Passowrd -->
    <div id="formFooter">
      <a class="underlineHover login-a" href="?pg=login">Login</a>
    </div>

  </div>
</div>
<script src="<?php echo BASE_URL; ?>ajax/forgot_password.js"></script>