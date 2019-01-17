<?php
if(!isset($_GET['order'])){
  echo "<script> location.replace('?pg=orders'); </script>";
  die();
}else{

  //get the order details
  try{

    $order_id = sanitize($_GET['order'], 'int');
    $query = "
      SELECT customers.*, orders.*, order_items.*, customer_payment_methods.*, ref_order_status_codes.*, shipments.* FROM orders
      INNER JOIN customers ON orders.customer_id = customers.customer_id
      INNER JOIN order_items ON orders.order_id = order_items.order_id
      INNER JOIN ref_order_status_codes ON orders.order_status_code = ref_order_status_codes.order_status_code
      INNER JOIN customer_payment_methods ON orders.customer_id = customer_payment_methods.customer_id
      INNER JOIN shipments ON orders.order_id = shipments.order_id
      WHERE orders.order_id = $order_id
    ";
    $get_order_details = DB::getInstance()->query($query);
    $order_details = $get_order_details->results();
  }catch(Exception $e){
    die("<a href='?pg=orders' class='btn btn-success'>Click to back</a>");
  }

  //initilize the has payed status to 0
  $has_payed = 0;
}
?>
<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">View Order</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
      <a href="?pg=orders" class="btn btn-sm btn-success">
        Back
      </a>
    </div>
  </div>
  <div class="">
    <div class="row">
        <div class="col-sm-12 col-md-6">
          <h6>BILLING DETAILS</h6>
          <?php
          if(Session::exists('paid')){
            echo "<div class='alert alert-dismissable alert-success'>
                      <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                          <span aria-hidden='true'>&times;</span>
                      </button>

                          <li><i class='fa fa-check'></i>&ensp;<strong>". Session::flash('paid') . "</strong></li>

                  </div>";
          }
          if(Session::exists('completed')){
            echo "<div class='alert alert-dismissable alert-success'>
                      <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                          <span aria-hidden='true'>&times;</span>
                      </button>

                          <li><i class='fa fa-check'></i>&ensp;<strong>". Session::flash('completed') . "</strong></li>

                  </div>";
          }
          if(Session::exists('cancled')){
            echo "<div class='alert alert-dismissable alert-success'>
                      <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                          <span aria-hidden='true'>&times;</span>
                      </button>

                          <li><i class='fa fa-check'></i>&ensp;<strong>". Session::flash('cancled') . "</strong></li>

                  </div>";
          }
          ?>
          <hr>
          <div class="payment-option-background checkout-padding">
                <table width="100%">
                  <tr>
                    <th>Order number:</th>
                    <td><?php echo $order_details[0]->order_id; ?></td>
                  </tr>
                  <tr>
                    <th>Status:</th>
                    <td><?php echo strtoupper($order_details[0]->order_status_description); ?></td>
                  </tr>
                  <tr>
                    <th>Order for:</th>
                    <td><?php echo ucfirst($order_details[0]->firstname)." ".ucfirst($order_details[0]->lastname); ?></td>
                  </tr>
                  <tr>
                    <th>Email:</th>
                    <td><?php echo $order_details[0]->email; ?></td>
                  </tr>
                  <tr>
                    <th>Phone:</th>
                    <td><?php echo $order_details[0]->phone; ?></td>
                  </tr>
                  <tr>
                    <th>Date:</th>
                    <td><?php echo date_to_word($order_details[0]->date_order_placed); ?></td>
                  </tr>
                  <tr>
                    <th>Payment Method:</th>
                    <td>
                      <?php
                        try{
                          $get_payment_method = DB::getInstance()
                          ->get('ref_payment_methods',array('payment_method_code','=',$order_details[0]->payment_method_code));
                        }catch(Exception $e){
                          die("<a href='?pg=home' class='btn btn-success'>Goto homepage</a>");
                        }
                        echo $get_payment_method->first()->payment_method;
                      ?>
                    </td>
                  </tr>
                  <tr>
                    <th>Shipping address:</th>
                    <td><?php echo $order_details[0]->address; ?></td>
                  </tr>
                </table>
            </div>
            <br>
            <h6>PAYMENT METHOD</h6>
            <hr>
            <div class="">
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
                  <?php if($get_payment_method->first()->payment_method_code == 1){echo '<br><img src="../images/icons/bank_transfer.png" width="50%" alt="payment_logos">';}?>
                  <?php if($get_payment_method->first()->payment_method_code == 2){echo '<br><img src="../images/icons/cash_on_delivery.png" width="50%" alt="payment_logos">';}?>
                  <?php if($get_payment_method->first()->payment_method_code == 3){echo '<br><img src="../images/icons/payment_logo.png" width="50%" alt="payment_logos">';}?>
                </li><br>
                <?php
                  }catch(Exception $e){
                      die('<a href="?pg=home" class="btn btn-success">Goto homepage</a>');
                  }
                ?>
              </ul>
            </div>
            <br>
            <h6>PAYMENT STATUS</h6>
            <hr>
            <div class="payment-option-background checkout-padding">
              <?php
                // GET THE PAYMENT Details
                $get_payment_details = DB::getInstance()->get('payments',array('order_id','=',$order_details[0]->order_id));
                if($get_payment_details->count() > 0){
                  $has_payed = $get_payment_details->count();
                  $payment_details = $get_payment_details->results();
              ?>
              <table width="100%">
                <tr>
                  <th>Payment ID:</th>
                  <td><?php echo $payment_details[0]->payment_id; ?></td>
                </tr>
                <tr>
                  <th>Payment Date:</th>
                  <td><?php echo $payment_details[0]->payment_date; ?></td>
                </tr>
                <tr>
                  <th>Amount Paid:</th>
                  <td><b>&#8358;<?php echo number_format($payment_details[0]->payment_amount); ?></b></td>
                </tr>
              </table>
              <?php
            }else{
              ?>
              <h6>Customer Has not made any payment for this order.</h6>
              <?php
            }
              ?>
            </div>
            <br>
            <h6>OPTIONS</h6>
            <hr>
            <div class="">
              <?php
              if($order_details[0]->order_status_code != 4){
                if($has_payed == 0){
              ?>
              <button type="button" name="button" class="btn btn-primary btn-block" data-id="<?php echo $order_details[0]->order_id; ?>" id='paid'>PAID</button>
              <button type="button" name="button" class="btn btn-danger btn-block" data-id="<?php echo $order_details[0]->order_id; ?>" id='cancled'>CANCLED</button>
              <?php
                }elseif($has_payed > 0){
                  // check if the order is completed
                  if($order_details[0]->order_status_code != 3){
              ?>
              <button type="button" name="button" class="btn btn-success btn-block" data-id="<?php echo $order_details[0]->order_id; ?>" id='completed'>COMPLETED</button>
              <?php
                  }
                }
              }
              ?>
            </div>
            <br>
            <br>
        </div>
        <!--

          ORDER DETAILS

        -->
        <div class="col-sm-12 col-md-6 border-left-show">
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
              <!--div class='alert alert-warning'>
                <li><i class='fa fa-exclamation-circle'></i>&ensp;<strong>N:B</strong><br> Please login to your accont with your email and password to view list of all your orders.</li>
              </div-->
          </div>
        </div>
    </div>
  </div>
</main>
</div>
</div>
<script type="text/javascript" src="<?php echo BASE_URL; ?>ajax/order.js"></script>
