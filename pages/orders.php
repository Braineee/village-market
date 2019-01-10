<?php
require_once ("config/Config.php");
require_once (ROOT_PATH . "core/init.php");

// redirect the user to the login page if the user is not loggedin
if(!$user->isLoggedin()){
  echo "<script> location.replace('?pg=login'); </script>";
  die();
}

// get the users order
$query = "
SELECT orders.*, order_items.*, ref_order_status_codes.* FROM orders
INNER JOIN order_items ON orders.order_id = order_items.order_id
INNER JOIN ref_order_status_codes ON orders.order_status_code = ref_order_status_codes.order_status_code
WHERE customer_id = {$user_id} group by orders.order_id
";
$get_users_order = DB::getInstance()->query($query);
$users_order = $get_users_order->results();
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

              <!--
                  ORDER
              -->

              <div class="col-md-9 col-sm-12 checkout-padding border-left-show">
                <h6 style="margin-bottom:20px;">LIST OF ORDERS</h6>
                  <div class="payment-option-background checkout-padding">
                      <table class="table table-hover table-responsive">
                          <thead class="table-head">
                              <th>Order</th>
                              <th>Date</th>
                              <th>Status</th>
                              <th>No. of Items</th>
                              <th>Total</th>
                              <th>Option</th>
                          </thead>
                          <?php
                            //loop through the orders
                            foreach($users_order as $order){
                              $date = date_to_word($order->date_order_placed);
                              $total = number_format($order->total);
                              echo
                              "<tr>
                                  <td>
                                    #{$order->order_id}
                                  </td>
                                  <td>
                                    {$date}
                                  </td>
                                  <td>
                                    {$order->order_status_description}
                                  </td>
                                  <td>
                                    {$order->nos_of_item}
                                  </td>
                                  <td>
                                    &#8358;{$total}
                                  </td>
                                  <td>
                                    <a href='?pg=view&id={$order->order_id}' class='btn btn-success btn-sm'>view</a>
                                  </td>
                              </tr>";
                            }
                          ?>
                      </table>

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
