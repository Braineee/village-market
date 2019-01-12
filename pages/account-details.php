<?php
require_once ("config/Config.php");
require_once (ROOT_PATH . "core/init.php");

// redirect the user to the login page if the user is not loggedin
if(!$user->isLoggedin()){
  echo "<script> location.replace('?pg=login'); </script>";
  die();
}else{
  //gett he users DETAILSif($user->isLoggedin() && $user_id){
    try{
      //get the user details
      $get_customer_details = DB::getInstance()->
      get('customers', array('customer_id','=',$_SESSION['user_id']));
      $customer_details = $get_customer_details->first();

      $_POST['firstname'] = $customer_details->firstname;
      $_POST['lastname'] = $customer_details->lastname;
      $_POST['phone'] = $customer_details->phone;
      $_POST['email'] = $customer_details->email;
      $_POST['address'] = $customer_details->address;
      $_POST['state'] = $customer_details->state_id;

    }catch(Exception $e){
      die('<a href="?pg=home" class="btn btn-success">Goto homepage</a>');
    }
}

?>


<div class="container margin-top-40">
  <h3 class="purple"><strong>Dashboard</strong></h3>
  <hr>
</div>

<section class="">
      <div class="container">
          <div class="row">
              <div class="col-md-3 col-sm-12 checkout-padding">
                <?php
                  include "inc/dashboard_navbar.php";
                ?>
              </div>

              <div class="col-md-9 col-sm-12 checkout-padding border-left-show">
                <h6 style="margin-bottom:20px;">ACCOUNT DETAILS</h6>
                <div id="error">
                  <!-- display the errors here -->
                </div>
                <?php
                  if(Session::exists('home')){
                    echo "<div class='alert alert-dismissable alert-success'>
                              <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                  <span aria-hidden='true'>&times;</span>
                              </button>

                                  <li><i class='fa fa-check'></i>&ensp;<strong>". Session::flash('home') . "</strong></li>

                          </div>";
                  }
                ?>
                  <div class="payment-option-background checkout-padding">
                    <form method="POST" name="update_details">
                      <div class="form-group">
                        <label for="firstname">First name</label>
                        <input type="text"
                        class="form-control"
                        id="firstname"
                        name="firstname"
                        placeholder="Enter first name here"
                        value="<?php if(isset($_POST['firstname'])){ echo $_POST['firstname']; }?>">
                      </div>
                      <div class="form-group">
                        <label for="lastname">Last name</label>
                        <input type="text"
                        class="form-control"
                        id="lastname"
                        name="lastname"
                        placeholder="Enter last name here"
                        value="<?php if(isset($_POST['lastname'])){ echo $_POST['lastname']; }?>">
                      </div>
                      <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email"
                        class="form-control"
                        id="email"
                        name="email"
                        placeholder="Enter email here"
                        value="<?php if(isset($_POST['email'])){ echo $_POST['email']; }?>"
                        disabled="true">
                      </div>
                      <div class="form-group">
                        <label for="phone">Phone number</label>
                        <input type="phone"
                        class="form-control"
                        id="phone"
                        name="phone"
                        placeholder="Enter phone number here"
                        value="<?php if(isset($_POST['phone'])){ echo $_POST['phone']; }?>">
                      </div>
                      <div class="form-group">
                          <label for="state">State</label>
                          <select class="form-control" id="state" name="state">
                              <option value="">Select State</option>
                              <?php
                                try{
                                  // get the list of states
                                  $get_states = DB::getInstance()->all('ref_states_code');
                                  // loop through the list of state
                                  foreach($get_states->results() as $state) {
                              ?>
                              <option value="<?php echo $state->state_id; ?>" <?php if($_POST['state'] == $state->state_id){ echo "selected"; }?>><?php echo $state->state; ?></option>
                              <?php
                                  }
                                }catch(Exception $e){
                                  die('<a href="?pg=home" class="btn btn-success">Goto homepage</a>');
                                }
                              ?>
                          </select>
                      </div>
                      <div class="form-group">
                        <label for="address">Address</label>
                        <textarea class="form-control" id="address" rows="3" name="address"><?php if(isset($_POST['address'])){ echo $_POST['address']; }?></textarea>
                        <small style="color:#f00;">NB: Include house number in address, kindly note that the address you provide here will be used as your billing and shipping address.</small>
                      </div>
                      <input type="hidden" name="form_token" value="<?php echo hash_hmac('sha256', Token::generate_unique('update_details'), $token); ?>">
                      <button type="submit" name="update_details" id="update_details" class="btn btn-success">UPDATE DETAILS</button>
                    </form>


                    <br>
                    <br>
                    <h6><b>CHANGE PASSWORD</b></h6>
                    <hr>
                    <form method="POST" name="change_password">
                      <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password here">
                      </div>
                      <div class="form-group">
                        <label for="new_password">New Password</label>
                        <input type="password" class="form-control" id="new_password" name="new_password" placeholder="Enter new password here">
                      </div>
                      <div class="form-group">
                        <label for="con_password">Confirm Passowrd</label>
                        <input type="password" class="form-control" id="con_password" name="con_password" placeholder="Please new password again">
                      </div><br>
                      <input type="hidden" name="form_token" value="<?php echo hash_hmac('sha256', Token::generate_unique('update_pass'), $token); ?>">
                      <button type="submit" name="change_password" id="change_password" class="btn btn-success">UPDATE PASSWORD</button>
                    </form>
                  </div>
              </div>
          </div>

          <div class="col-md-6 col-sm-12 margin-top-40">

          </div>
      </div>
      <br>
  		<br>
      <br>
</section>
