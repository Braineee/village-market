<?php
require_once ("config/Config.php");
require_once (ROOT_PATH . "core/init.php");

// redirect the user to the login page if the user is not loggedin
if(!$user->isLoggedin()){
  echo "<script> location.replace('?pg=login'); </script>";
  die();
}

// check if the view id exists
if(!isset($_GET['id'])){
  echo "<script> location.replace('?pg=orders'); </script>";
  die();
}

$order_id = $_GET['id'];

//get the order details
try{
  $query = "
    SELECT customers.*, orders.*, order_items.*, customer_payment_methods.*, shipments.*, ref_order_status_codes.* FROM orders
    INNER JOIN customers ON orders.customer_id = customers.customer_id
    INNER JOIN order_items ON orders.order_id = order_items.order_id
    INNER JOIN customer_payment_methods ON orders.customer_id = customer_payment_methods.customer_id
    INNER JOIN ref_order_status_codes ON orders.order_status_code = ref_order_status_codes.order_status_code
    INNER JOIN shipments ON orders.order_id = shipments.order_id
    WHERE orders.order_id = $order_id
  ";
  $get_order_details = DB::getInstance()->query($query);

  if($get_order_details->count() > 0){

    $order_details = $get_order_details->results();

  }else{
    die("<a href='?pg=checkout' class='btn btn-success'>Please click this button to checkout</a>");
  }

}catch(Exception $e){
  die("<a href='?pg=home' class='btn btn-success'>Goto homepage</a>");
}
?>



<div class="container margin-top-40 dashboard_heading">
  <h3 class="purple"><strong>Dashboard</strong></h3>
  <hr>
</div>

<section class="">
      <div class="container">
          <div class="row">
              <div class="col-md-3 col-sm-12 checkout-padding dashboard_content">
                <?php
                  include "inc/dashboard_navbar.php";
                ?>
              </div>

              <!--
                  ORDER
              -->

              <div class="col-md-6 col-sm-12 checkout-padding border-left-show">
                <h6 style="margin-bottom:20px;">ORDERS DETAILS</h6>
                  <div class="payment-option-background checkout-padding">
                      <p style="margin-bottom:20px;">Order #<?= $order_id; ?> was placed on <?= date_to_word($order_details[0]->date_order_placed); ?>. <br> <b>STATUS: <?= $order_details[0]->order_status_description; ?></b>.</p>
                      <table class="table table-hover table-responsive">
                          <thead class="table-head">
                              <th width="200px;">Item</th>
                              <th width="100px;">QTY</th>
                              <th>Price</th>
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
                              <td style="color: #b20000;"><?php echo "<a href='?pg=item-detail&item={$get_item_name->first()->product_id}'> {$get_item_name->first()->product_name} </a>"; ?></b></td>
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
                              <th >
                                  TOTAL
                              </th>
                              <th></th>
                              <?php
                                  //calculate grand total
                                  $grand_total = $total + $shippment_price;
                              ?>
                              <td ><b>&#8358;<?php if(isset($grand_total)){ echo number_format($grand_total); }?></b></td>
                          </tr>
                          <tr>
                              <td >
                                  SHIPPING ADDRESS:
                              </td>
                              <td></td>
                              <td >
                                <?php echo $order_details[0]->address; ?>.
                              </td>
                          </tr>
                      </table>
                      <!-- print -->
                      <button type="button" class="btn btn-success" onclick="print()" name="button">Print</button>
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
