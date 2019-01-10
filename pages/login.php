<?php
   if($user->isLoggedin()){
        echo "<script> location.replace('?pg=dashboard'); </script>";
        die();
    }
?>
<div class="container margin-top-40">
    <h3 class="purple"><strong>Sign in</strong></h3>
    <hr>
    <br>
</div>

<section class="">
      <div class="container">
          <div class="row">
            <div class="col-md-6">
              <!-- error div-->
              <div id="error" class="error-login"></div>
              <div class="payment-option-background checkout-padding">
                <form name="login_form" Method="POST">

                  <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="Email">
                    <small id="emailHelp" class="form-text text-muted">Please enter the email you registered when filling billing details or the email you entered when signing up.</small>
                  </div>

                  <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" class="form-control" placeholder="Password">
                  </div>

                  <input type="hidden" name="form_token" value="<?php echo hash_hmac('sha256', Token::generate_unique('login'), $token); ?>">
                  <button type="submit" id="login" class="btn btn-primary" value="Log In" >SIGN IN</button>
                  <br>
                  <br>

                  <div id="formFooter">
                    <a class="underlineHover login-a" href="?pg=forgot_password">Forgot Password?</a>
                  </div>

                </form>
              </div>
            </div>
          <div class="col-md-6 border-left-show">

          </div>
        </div>
      </div>
    <br>
    <br>
    <br>
</section>
<script type="text/javascript" src="<?php echo BASE_URL; ?>ajax/login.js"></script>
