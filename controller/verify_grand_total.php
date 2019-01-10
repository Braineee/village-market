<?php
function verify_grand_total($shippment_id){
  $total = 0;
  //verify the grand total
  try{
      //get the shippin method that matches this id
      $get_shippment_option = DB::getInstance()->get("shippment_option", array("shippment_option_code","=",$shippment_id));
      //get the price
      $shippment_price = $get_shippment_option->first()->shippment_option_price;
      // calculate item total in cart
      if(isset($_SESSION['cart'])){
          for($i=0; $i< count($_SESSION['cart']); $i++){
              if(isset($_SESSION['cart'][$i])){
                  $price = $_SESSION['cart'][$i]['Price'];
                  $_Price = intVal($price) * intVal($_SESSION['cart'][$i]['Quantity']);
                  $total = $total + $_Price;
              }
          }
      }else{
          //if cart doesn't exist return the shippment price to 0
          $shippment_price = 0;
      }
      // calculate the grand total: add sipping price and total price of item (store in session Grand total)
      $grand_total = $total + $shippment_price;
      $_SESSION['grand_total'] = $grand_total;
  }catch(Exception $e){
      die('<a href="?pg=home" class="btn btn-success">Goto homepage</a>');
  }
}
