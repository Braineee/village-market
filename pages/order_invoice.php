<?php
require_once ("config/Config.php");
require_once (ROOT_PATH . "core/init.php");
?>


  <div class="container margin-top-40">
      <h3 class="purple"><strong>Order Details</strong></h3>
      <hr>
      <?php
        // verify if there are items in the cart
        if(!isset($_SESSION['order_id']) || $_SESSION['order_id'] == ''){
          die("<a href='?pg=home' class='btn btn-success'>You haven't placed any other yet, click this botton to continue shopping</a>");
        }

        //get the order details
        try{
          $order_id = $_SESSION['order_id'];
          $query = "
            SELECT customers.*, orders.*, order_items.*, customer_payment_methods.*, shipments.* FROM orders
            INNER JOIN customers ON orders.customer_id = customers.customer_id
            INNER JOIN order_items ON orders.order_id = order_items.order_id
            INNER JOIN customer_payment_methods ON orders.customer_id = customer_payment_methods.customer_id
            INNER JOIN shipments ON orders.order_id = shipments.order_id
            WHERE orders.order_id = $order_id
          ";
          $get_order_details = DB::getInstance()->query($query);

          if($get_order_details->count() > 0){

            $order_details = $get_order_details->results();
            echo "<div class='alert alert-dismissable alert-success'>
                      <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                          <span aria-hidden='true'>&times;</span>
                      </button>

                          <li><i class='fa fa-check'></i>&ensp;<strong>Thank you. Your order has been received, please proceed with your payment</strong></li>

                  </div>";
          }else{
            die("<a href='?pg=checkout' class='btn btn-success'>Please click this button to checkout</a>");
          }

        }catch(Exception $e){
          die("<a href='?pg=home' class='btn btn-success'>Goto homepage</a>");
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

                        <div class="form-group">
                            <label class="text-muted">
                                Order number:
                            </label>
                            <h6><b><?php echo $order_details[0]->order_id; ?></b></h6>
                        </div>
                        <div class="form-group">
                            <label class="text-muted">
                                Order for:
                            </label>
                            <h6><b><?php echo ucfirst($order_details[0]->firstname)." ".ucfirst($order_details[0]->lastname); ?></b></h6>
                        </div>
                        <div class="form-group">
                            <label class="text-muted">
                                Email:
                            </label>
                            <h6><b><?php echo $order_details[0]->email; ?></b></h6>
                        </div>
                        <div class="form-group">
                            <label class="text-muted">
                                Phone:
                            </label>
                            <h6><b><?php echo $order_details[0]->phone; ?></b></h6>
                        </div>
                        <div class="form-group">
                            <label class="text-muted">
                                Date:
                            </label>
                            <h6><b><?php echo date_to_word($order_details[0]->date_order_placed); ?></b></h6>
                        </div>
                        <div class="form-group">
                            <label class="text-muted">
                                Payment Method:
                            </label>
                            <?php
                              try{
                                $get_payment_method = DB::getInstance()
                                ->get('ref_payment_methods',array('payment_method_code','=',$order_details[0]->payment_method_code));
                              }catch(Exception $e){
                                die("<a href='?pg=home' class='btn btn-success'>Goto homepage</a>");
                              }
                            ?>
                            <h6><b><?php echo $get_payment_method->first()->payment_method; ?></b></h6>
                        </div>
                        <div class="form-group">
                            <label class="text-muted">
                                Shipping address:
                            </label>
                            <h6><b><?php echo $order_details[0]->address; ?></b></h6>
                        </div>
                    </div>
                    <br>
                    <h6>PAYMENT</h6>
                    <hr>
                    <div class="payment-option-background checkout-padding">
                      <ul>
                        <?php
                          try{
                            // get all the payment method
                            $get_payment_method = DB::getInstance()
                            ->get('ref_payment_methods', array('payment_method_code','=',$order_details[0]->payment_method_code));
                        ?>
                        <li>
                          <strong><?php echo $get_payment_method->first()->payment_method; ?></strong>:<br>
                          <?php echo $get_payment_method->first()->payment_method_description; ?><br>
                          <?php if($get_payment_method->first()->payment_method_code == 1){echo '<br><img src="images/icons/bank_transfer.png" width="50%" alt="payment_logos">';}?>
                          <?php if($get_payment_method->first()->payment_method_code == 2){echo '<br><img src="images/icons/cash_on_delivery.png" width="50%" alt="payment_logos">';}?>
                          <?php if($get_payment_method->first()->payment_method_code == 3){echo '<br><img src="images/icons/payment_logo.png" width="50%" alt="payment_logos">';}?>
                        </li><br>
                        <?php
                          }catch(Exception $e){
                              die('<a href="?pg=home" class="btn btn-success">Goto homepage</a>');
                          }
                        ?>
                      </ul>
                      <?php
                        if($get_payment_method->first()->payment_method_code == 3){
                      ?>
                      <input type="hidden" name="form_token" value="<?php echo Token::generate(); ?>">
                      <input type="submit" name="submit" value="Make Payment" class="btn btn-lg btn-success">
                      <?php
                        }
                      ?>
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
                                    $total = 0;
                                    //loop through the list of items
                                    foreach($order_details as $item){
                                      //get the details of item
                                      $get_item_name = DB::getInstance()
                                      ->get('products', array('product_id','=',$item->product_id));
                            ?>
                            <tr>
                                <td style="color: #b20000;"><?php echo $get_item_name->first()->product_name; ?></b></td>
                                <td style="color: #b20000;"><b><?php echo $item->order_item_quantity; ?></b></td>
                                <td style="color: #b20000;"><b>&#8358;<?php echo number_format($item->order_item_price); ?></b></td>
                            </tr>
                            <?php
                                      $total = $total + $item->order_item_price;
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

                                        // get shipping details
                                        $get_shippment_option = DB::getInstance()->get("shippment_option", array("shippment_option_code","=",$order_details[0]->shippment_option_code));

                                        echo $get_shippment_option->first()->shippment_option_desc;

                                        $shippment_price = $get_shippment_option->first()->shippment_option_price;

                                    }catch(Exception $e){
                                        die('<a href="?pg=home" class="btn btn-success">Goto homepage</a>');
                                    }
                                    ?>
                                </th>
                                <th></th>
                                <td><b>&#8358;<?php try{if(isset($shippment_price)){ echo number_format($shippment_price); }}catch(Exception $e){die('<a href="?pg=home" class="btn btn-success">Goto homepage</a>');} ?></b></td>
                            </tr>
                            <tr>
                                <th class="text-20">
                                    TOTAL
                                </th>
                                <th></th>
                                <?php
                                    //calculate grand total
                                    $grand_total = $total + $shippment_price;
                                ?>
                                <td class="text-20"><b>&#8358;<?php if(isset($grand_total)){ echo number_format($grand_total); }?></b></td>
                            </tr>
                        </table>

                    </div>
                    <br>
                    <div class='alert alert-warning'>
                      <li><i class='fa fa-exclamation-circle'></i>&ensp;<strong>N:B</strong><br> Please login to your accont with your email and password to view list of all your orders.</li>
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
  </form>
<?php

  //delete the cart, shipping_method, grand_total,
  $_SESSION['cart'] = array();
  $_SESSION['grand_total'] = 0;
  $_SESSION['shipping_option'] = array();

?>
