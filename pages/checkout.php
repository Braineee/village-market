<?php
// proccess the customer billing details
include 'controller/proccess_billing.php';

?>

<div class="container margin-top-40">
    <h3 class="purple"><strong>Checkout</strong></h3>
    <hr>
    <?php
      // verify if there are items in the cart
      if(isset($_SESSION['cart']) && $_SESSION['cart'] == []){
        die('<a href="?pg=home" class="btn btn-success">No order yet, click this button to continue shopping</a>');
      }

      // verify if there is a shippment option available
      if(isset($_SESSION['shipping_option']) && $_SESSION['shipping_option'] == []){
        die('<a href="?pg=cart" class="btn btn-success">Click this button to select shipping method</a>');
      }else{
        //verify the grand total
        include "controller/verify_grand_total.php";
        verify_grand_total($_SESSION['shipping_option']);
      }

      if($user->isLoggedin() && $user_id){
        try{
          //get the user details
          $get_customer_details = DB::getInstance()->
          get('customers', array('customer_id','=',$user_id));
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
</div>


	<!-- Checkout detail entry form -->
  <form method="POST">
	<section class="">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-sm-12 checkout-padding">
                  <h6>BILLING DETAILS</h6>
                  <hr>
                  <div class="payment-option-background checkout-padding">
                      <?php
                      if($user->isLoggedin()){
                      ?>
                      <div class="form-group">
                          <label for="firstname">
                              First name
                              <abbr class="required" title="required">*</abbr>
                          </label>
                          <input type="text"
                                 class="form-control"
                                 id="firstname"
                                 name="firstname"
                                 value="<?php if(isset($_POST['firstname'])){ echo $_POST['firstname']; }?>"
                                 placeholder="enter your first name here">
                      </div>
                      <div class="form-group">
                          <label for="lastname">
                              Last name
                              <abbr class="required" title="required">*</abbr>
                          </label>
                          <input type="text"
                                  class="form-control"
                                  id="lastname"
                                  name="lastname"
                                  value="<?php if(isset($_POST['lastname'])){ echo $_POST['lastname']; }?>"
                                  placeholder="enter your Last name here">
                      </div>
                      <div class="form-group">
                          <label for="phone">
                              Phone
                              <abbr class="required" title="required">*</abbr>
                          </label>
                          <input type="phone" class="form-control" id="phone" name="phone" value="<?php if(isset($_POST['phone'])){ echo $_POST['phone']; }?>" placeholder="enter your phone number here">
                      </div>
                      <div class="form-group">
                          <label for="phone">
                              Email address
                              <abbr class="required" title="required">*</abbr>
                          </label>
                          <input type="email"
                                  class="form-control"
                                  id="email"
                                  name="email"
                                  value="<?php if(isset($_POST['email'])){ echo $_POST['email']; }?>"
                                  placeholder="enter your email address here"
                                  disabled="true">
                      </div>
                      <div class="form-group">
                          <label for="address">
                              Street address
                              <abbr class="required" title="required">*</abbr>
                          </label>
                          <textarea
                            class="form-control"
                            id="address"
                            name="address"
                            rows="3"
                            value=""><?php if(isset($_POST['address'])){ echo $_POST['address']; }?></textarea>
                          <small style="color:#f00;">NB: Include house number in address, kindly note that the address you provide here will be used as your billing and shipping address.</small>
                      </div>
                      <div class="form-group">
                          <label for="state">State</label>
                          <abbr class="required" title="required">*</abbr>
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
                      <?php
                      }else{
                      ?>
                        <div class="form-group">
                            <label for="firstname">
                                First name
                                <abbr class="required" title="required">*</abbr>
                            </label>
                            <input type="text"
                                    class="form-control"
                                    id="firstname"
                                    name="firstname"
                                    value="<?php if(isset($_POST['firstname'])){ echo $_POST['firstname']; }?>"
                                    placeholder="enter your first name here">
                        </div>
                        <div class="form-group">
                            <label for="lastname">
                                Last name
                                <abbr class="required" title="required">*</abbr>
                            </label>
                            <input type="text"
                                    class="form-control"
                                    id="lastname"
                                    name="lastname"
                                    value="<?php if(isset($_POST['lastname'])){ echo $_POST['lastname']; }?>"
                                    placeholder="enter your Last name here">
                        </div>
                        <div class="form-group">
                            <label for="phone">
                                Phone
                                <abbr class="required" title="required">*</abbr>
                            </label>
                            <input type="phone"
                                   class="form-control"
                                   id="phone"
                                   name="phone"
                                   value="<?php if(isset($_POST['phone'])){ echo $_POST['phone']; }?>"
                                   placeholder="enter your phone number here">
                        </div>
                        <div class="form-group">
                            <label for="phone">
                                Email address
                                <abbr class="required" title="required">*</abbr>
                            </label>
                            <input type="email"
                                    class="form-control"
                                    id="email"
                                    name="email"
                                    value="<?php if(isset($_POST['email'])){ echo $_POST['email']; }?>"
                                    placeholder="enter your email address here">
                        </div>
                        <div class="form-group">
                            <label for="address">
                                Street address
                                <abbr class="required" title="required">*</abbr>
                            </label>
                            <textarea class="form-control" id="address" name="address" rows="3"></textarea>
                            <small style="color:#f00;">NB: Include house number in address, kindly note that the address you provide here will be used as your billing and shipping address.</small>
                        </div>
                        <div class="form-group">
                            <label for="state">State</label>
                            <abbr class="required" title="required">*</abbr>
                            <select class="form-control" id="state" name="state">
                              <option value="">Select State</option>
                              <?php
                                try{
                                  // get the list of states
                                  $get_states = DB::getInstance()->all('ref_states_code');
                                  // loop through the list of state
                                  foreach($get_states->results() as $state){
                              ?>
                              <option value="<?php echo $state->state_id; ?>"><?php echo $state->state; ?></option>
                              <?php
                                  }
                                }catch(Exception $e){
                                  die('<a href="?pg=home" class="btn btn-success">Goto homepage</a>');
                                }
                              ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="username">
                                Account username
                                <abbr class="required" title="required">*</abbr>
                            </label>
                            <input type="text"
                                    class="form-control"
                                    id="username"
                                    name="username"
                                    value="<?php if(isset($_POST['username'])){ echo $_POST['username']; }?>"
                                    placeholder="enter your username">
                        </div>
                        <div class="form-group">
                            <label for="password">
                                Account password
                                <abbr class="required" title="required">*</abbr>
                            </label>
                            <input type="password"
                                    class="form-control"
                                    id="password"
                                    name="password"
                                    value="<?php if(isset($_POST['password'])){ echo $_POST['password']; }?>"
                                    placeholder="enter your password">
                        </div>
                        <div class="form-group">
                            <label for="con_password">
                                Confirm password
                                <abbr class="required" title="required">*</abbr>
                            </label>
                            <input type="password"
                                    class="form-control"
                                    id="con_password"
                                    name="con_password"
                                    value="<?php if(isset($_POST['con_password'])){ echo $_POST['con_password']; }?>"
                                    placeholder="enter your password again">
                        </div>

                      <?php
                      }
                      ?>
                    </div>

                    <br>
                    <h6>PAYMENT OPTION</h6>
                    <hr>
                    <div class="payment-option-background checkout-padding">
                      <ul>
                        <?php
                          try{
                            // get all the payment method
                            $get_all_payment = DB::getInstance()->all('ref_payment_methods');

                            // loop thru all payment methods
                            foreach($get_all_payment->results() as $payment_option){
                        ?>
                        <li>
                          <input type="radio"
                                  class="payment_method"
                                  name="payment_method"
                                  id="payment_method"
                                  value = "<?php echo $payment_option->payment_method_code; ?>"
                                  data-id="<?php echo $payment_option->payment_method_code; ?>"
                                  checked="<?php if($payment_option->payment_method_code == 3){ echo 'checked'; }?>">

                          <strong><?php echo $payment_option->payment_method; ?></strong>:
                          <br>
                          <?php echo $payment_option->payment_method_description; ?>
                          <?php if($payment_option->payment_method_code == 1){echo '<br><img src="images/icons/bank_transfer.png" width="30%" alt="payment_logos">';}?>
                          <?php if($payment_option->payment_method_code == 2){echo '<br><img src="images/icons/cash_on_delivery.png" width="30%" alt="payment_logos">';}?>
                          <?php if($payment_option->payment_method_code == 3){echo '<br><img src="images/icons/payment_logo.png" width="30%" alt="payment_logos">';}?>
                        </li><br>
                        <?php
                            }
                          }catch(Exception $e){
                            //die($e->getMessage());
                            die('<a href="?pg=home" class="btn btn-success">Goto homepage</a>');
                          }
                        ?>
                      </ul>
                      <input type="hidden" name="form_token" value="<?php echo Token::generate(); ?>">
                      <input type="submit" name="submit" value="Place Order" class="btn btn-lg btn-success">
                    </div>
                </div>

                <!--
                    ORDER
                -->

                <div class="col-md-6 col-sm-12 checkout-padding">
                <h6>YOUR ORDER</h6>
                <hr>
                    <div class="payment-option-background checkout-padding">
                        <table class="table table-hover table-responsive">
                            <thead class="table-head">
                                <th>Item</th>
                                <th>Quantity</th>
                                <th>Total</th>
                            </thead>
                            <?php
                                try{
                                    //loop through the list of items
                                    if(isset($_SESSION['cart']) && $_SESSION['cart'] != []){
                                        $total = 0;

                                        foreach($_SESSION['cart'] as $cart_item){
                                            if(isset($cart_item)){
                                                $_Price = 0;
                                                $_Price = intVal($cart_item['Price']) * intVal($cart_item['Quantity']);

                                                $total = $total + $_Price;

                            ?>
                            <tr>
                                <td style="color: #b20000;"><?php echo $cart_item['Item_name']; ?></td>
                                <td><b><?php echo $cart_item['Quantity']; ?></b></td>
                                <td style="color: #b20000;"><b>&#8358;<?php echo number_format($_Price); ?></b></td>
                            </tr>
                            <?php
                                            }
                                        }

                                    }else{
                                        die('<a href="?pg=home" class="btn btn-success">No order yet, continue shopping</a>');
                                    }
                                }catch(Exception $e){
                                    die('<a href="?pg=home" class="btn btn-success">Goto homepage</a>');
                                }
                            ?>
                            <tr>
                                <th>Subtotal</th>
                                <th></th>
                                <td><b>&#8358;<?php if(isset($total)){ echo number_format($total); } ?></b></td>
                            </tr>
                            <tr>
                                <th>
                                    <?php
                                    try{
                                        if(isset($_SESSION['shipping_option']) && $_SESSION['shipping_option'] != []){
                                            // get shipping details
                                            $get_shippment_option = DB::getInstance()->get("shippment_option", array("shippment_option_code","=",$_SESSION['shipping_option']));

                                            echo $get_shippment_option->first()->shippment_option_desc;

                                        }else{
                                          die('<a href="?pg=cart" class="btn btn-success">Click this button to select shipping method</a>');
                                        }
                                    }catch(Exception $e){
                                        die('<a href="?pg=home" class="btn btn-success">Goto homepage</a>');
                                    }
                                    ?>
                                </th>
                                <th></th>
                                <td><b>&#8358;<?php try{if(isset($get_shippment_option)){ echo number_format($get_shippment_option->first()->shippment_option_price); }}catch(Exception $e){die('<a href="?pg=home" class="btn btn-success">Goto homepage</a>');} ?></b></td>
                            </tr>
                            <tr>
                                <th class="text-20">
                                    TOTAL
                                </th>
                                <th></th>
                                <td class="text-20"><b>&#8358;<?php if(isset($_SESSION['grand_total'])){ echo number_format($_SESSION['grand_total']); }?></b></td>
                            </tr>
                        </table>
                        <!--br>
                        <a href="?pg=cart" class="btn btn-md btn-block btn-success">Go back to cart</a-->
                    </div>

                </div>
            </div>
        </div>
        <br>
    		<br>
        <br>
	</section>
  </form>

<!-- Shipping >
<section class="shipping bgwhite p-t-62 p-b-46">
    <div class="flex-w p-l-15 p-r-15">
        <div class="flex-col-c w-size5 p-l-15 p-r-15 p-t-16 p-b-15 respon1">
            <h4 class="m-text12 t-center">
                Free Delivery Worldwide
            </h4>

            <a href="#" class="s-text11 t-center">
                Click here for more info
            </a>
        </div>

        <div class="flex-col-c w-size5 p-l-15 p-r-15 p-t-16 p-b-15 bo2 respon2">
            <h4 class="m-text12 t-center">
                30 Days Return
            </h4>

            <span class="s-text11 t-center">
                Simply return it within 30 days for an exchange.
            </span>
        </div>

        <div class="flex-col-c w-size5 p-l-15 p-r-15 p-t-16 p-b-15 respon1">
            <h4 class="m-text12 t-center">
                Store Opening
            </h4>

            <span class="s-text11 t-center">
                Shop open from Monday to Sunday
            </span>
        </div>
    </div>
</section-->
