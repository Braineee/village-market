<?php
//get the configuration for the local server
require_once ("config/Config.php");
require_once (ROOT_PATH . "core/init.php");

//process the billing
if(Input::exists()){
  if(isset($_POST['form_token'])){// check if the there is a form token
    if(isset($_POST['submit'])){
      if(Token::check($_POST['form_token'])){// validate the token
        //check if is loggedin
        if($user->isLoggedin()){
          try{
            $validation_error = false;
            $errors = array();
            //sanitize the inputs and check if the inputs are not empy strings
            foreach($_POST as $key => $value){
              // sanitze the inputs
              $sanitized_value = sanitize($value, 'string');
              //check if the value is not Empty
              if($sanitized_value != ''){//replace the post value with the sanitizes value
                $_POST[$key] = $sanitized_value;
              }else{
                $validation_error = true;
                switch($key){
                  case 'payment_method' :
                    array_push($errors, "Please select a payment option.");
                  break;
                  case 'state' :
                    array_push($errors, "Please select a {$key}.");
                  break;
                  case 'con_password' :
                    array_push($errors, "Please enter your password again.");
                  break;
                  default:
                    array_push($errors, "Please enter your {$key}.");
                  break;
                }
              }
            }

            //check for any error
            if($validation_error == false && (count($errors) == 0)){
              extract($_POST);

                // update customer details, update if change occurs
                $update_customer = new Crud();
                $update_customer
                ->update('customers','customer_id',$_SESSION['user_id'], array(
                  'firstname' => $firstname,
                  'lastname' => $lastname,
                  'phone' => $phone,
                  'address' => $address,
                  'state_id' => $state
                ));

                // update customers payment method
                  //check if payment method exists for this customer ["yes":update | "no":create ]
                  $get_payment_method = DB::getInstance()
                  ->get("customer_payment_methods", array("customer_id","=",$_SESSION['user_id']));

                  if($get_payment_method->count() == 0){
                    //create customer payment method
                    $create_payment_method = new Crud();
                    $create_payment_method
                    ->create('customer_payment_methods', array(
                      'customer_id' => $_SESSION['user_id'],
                      'payment_method_code' => $payment_method,
                      'date_updated' =>  date('Y-m-d')
                    ));
                  }else{
                    //update customer payment method
                    $update_payment_method = new Crud();
                    $update_payment_method
                    ->update('customer_payment_methods','customer_id', $_SESSION['user_id'], array(
                      'payment_method_code' => $payment_method,
                      'date_updated' =>  date('Y-m-d')
                    ));
                  }

                // add customers order/order items to db from cart
                  //add the order to orders table
                  $generate_order_id = mt_rand(10000, 99999);
                  $add_order = new Crud();
                  $add_order
                  ->create('orders', array(
                    'order_id' => $generate_order_id,
                    'customer_id' => $_SESSION['user_id'],
                    'nos_of_item' => count($_SESSION['cart']),
                    'total' => $_SESSION['grand_total'],
                    'order_status_code' => 1,
                    'date_order_placed' =>  date('Y-m-d')
                   ));

                  //add the items to the order-items table
                  foreach($_SESSION['cart'] as $cart_item){
                    $add_order_items = new Crud();
                    $add_order_items
                    ->create('order_items', array(
                      'order_id' => $generate_order_id,
                      'product_id' => $cart_item['ID'],
                      'order_item_ status_code' => 4,
                      'order_item_quantity' => $cart_item['Quantity'],
                      'order_item_price' => intVal($cart_item['Price']) * intVal($cart_item['Quantity'])
                     ));
                  }

                  //add shipment
                  $add_shippment_method = new Crud();
                  $add_shippment_method
                  ->create('shipments', array(
                    'order_id' => $generate_order_id,
                    'shipment_date' => date('Y-m-d'),
                    'shippment_option_code' => $_SESSION['shipping_option']
                  ));

                // procced to invoice page for final payment
                $_SESSION['order_id'] = $generate_order_id;
                echo"<script>window.location.href='?pg=order_invoice'</script>";

            }else{ // validation was not passed
              // list the validation errors
              foreach($errors as $error){
                echo "<div class='alert alert-dismissable alert-danger'>
                          <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                              <span aria-hidden='true'>&times;</span>
                          </button>

                              <li><i class='fa fa-exclamation'></i>&ensp;<strong>".$error."</strong></li>

                      </div>";
        			}
            }

          }catch(Exception $e){
            die('<a href="?pg=home" class="btn btn-success">Goto homepage</a>');
            //die($e->getMessage());
          }

        }else{// user is not logged in create a new user and save billing details

          try{
            $validation_error = false;
            $errors = array();
            //sanitize the inputs and check if the inputs are not empy strings
            foreach($_POST as $key => $value){
              // sanitze the inputs
              $sanitized_value = sanitize($value, 'string');
              //check if the value is not Empty
              if($sanitized_value != ''){//replace the post value with the sanitizes value
                $_POST[$key] = $sanitized_value;
              }else{
                $validation_error = true;
                switch($key){
                  case 'payment_method' :
                    array_push($errors, "Please select a payment option.");
                  break;
                  case 'state' :
                    array_push($errors, "Please select a {$key}.");
                  break;
                  case 'con_password' :
                    array_push($errors, "Please enter your password again.");
                  break;
                  default:
                    array_push($errors, "Please enter your {$key}.");
                  break;
                }
              }
            }

            //check if the password matches
            if($_POST['password'] != $_POST['con_password']){
              $validation_error = true;
              array_push($errors, "The password you entered does not match, please check.");
            }

            //check if the email is unique
            $get_email_unique = DB::getInstance()->get('customers', array('email','=',$_POST['password']));
            if($get_email_unique->count() > 0){
              $validation_error = true;
              array_push($errors, "This email already exists");
            }

            //check for any error
            if($validation_error == false && (count($errors) == 0)){
              extract($_POST);
              // add the customer to database / create customer account / login customer
                //add the customer to the db
                $salt = Hash::salt(32);
                $password = Hash::make($password, $salt);
                $add_customer = new Crud();
                $add_customer
                ->create('customers',array(
                  'firstname' => $firstname,
                  'lastname' => $lastname,
                  'phone' => $phone,
                  'email' => $email,
                  'address' => $address,
                  'state_id' => $state,
                  'username' => $username,
                  'password' => $password,
                  'salt' => $salt,
                  'date_registered' => date('Y-m-d')
                ));

              //get the customer DETAILS
              $get_customer_details = DB::getInstance()
              ->get('customers', array('password','=',$password));
              $customer_details = $get_customer_details->first();

            // add customers payment method
            $create_payment_method = new Crud();
            $create_payment_method
            ->create('customer_payment_methods', array(
              'customer_id' => $customer_details->customer_id,
              'payment_method_code' => $payment_method,
              'date_updated' =>  date('Y-m-d')
            ));


            // add customers order/order items to db from cart
              //add the order to orders table
              $generate_order_id = mt_rand(10000, 99999);
              $add_order = new Crud();
              $add_order
              ->create('orders', array(
                'order_id' => $generate_order_id,
                'customer_id' => $customer_details->customer_id,
                'nos_of_item' => count($_SESSION['cart']),
                'total' => $_SESSION['grand_total'],
                'order_status_code' => 1,
                'date_order_placed' =>  date('Y-m-d')
               ));

              //add the items to the order-items table
              foreach($_SESSION['cart'] as $cart_item){
                $add_order_items = new Crud();
                $add_order_items
                ->create('order_items', array(
                  'order_id' => $generate_order_id,
                  'product_id' => $cart_item['ID'],
                  'order_item_ status_code' => 4,
                  'order_item_quantity' => $cart_item['Quantity'],
                  'order_item_price' => intVal($cart_item['Price']) * intVal($cart_item['Quantity'])
                 ));
              }

              //add shipment
              $add_shippment_method = new Crud();
              $add_shippment_method
              ->create('shipments', array(
                'order_id' => $generate_order_id,
                'shipment_date' => date('Y-m-d'),
                'shippment_option_code' => $_SESSION['shipping_option']
              ));

              // procced to invoice page for final payment
              $_SESSION['order_id'] = $generate_order_id;
              echo"<script>window.location.href='?pg=order_invoice'</script>";

            }else{

                echo "<div class='alert alert-dismissable alert-danger'>
                          <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                              <span aria-hidden='true'>&times;</span>
                          </button>

                              <li><i class='fa fa-exclamation'></i>&ensp;<strong>";
                              foreach($errors as $error){ echo $error.'<br>'; }
                echo "</strong></li>

                      </div>";
            }

          }catch(Exception $e){
            die('<a href="?pg=home" class="btn btn-success">Goto homepage</a>');
            //die($e->getMessage());
          }
        }
      }
    }
  }
}
