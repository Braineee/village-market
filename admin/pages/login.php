<?php
   if($admin->isLoggedin()){
        echo "<script> location.replace('?pg=dashboard'); </script>";
        die();
    }
?>
<div class="container" style="margin-top:30px">
  <div class="col-md-4">
      <div class="panel panel-default">
      <div class="panel-heading"><h3 class="panel-title"><strong>Admin</strong></h3></div>
      <hr>
      <div id="error" class="error-login"></div>
        <div class="panel-body">
           <form role="form">
            <div class="form-group">
              <label for="email">Email</label>
              <input type="email" class="form-control" id="email" name="email" placeholder="Enter email">
            </div>
            <div class="form-group">
              <label for="password">Password <!--a href="/sessions/forgot_password">(forgot password)</a--></label>
              <input type="password" class="form-control" id="password" name="password" placeholder="Password">
            </div>
            <input type="hidden" name="form_token" value="<?php echo hash_hmac('sha256', Token::generate_unique('login'), $token); ?>">
            <button type="submit" class="btn btn-md btn-danger" id="login">LOGIN</button>
          </form>
        </div>
    </div>
  </div>
</div>
<script type="text/javascript" src="<?php echo BASE_URL; ?>ajax/login.js"></script>
