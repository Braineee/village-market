<?php
require_once ("config/Config.php");
require_once (ROOT_PATH . "core/init.php");
?>

	<!-- Title Page -->
	<section class="bg-title-page p-t-40 p-b-50 flex-col-c-m" style="background-image: url(images/heading-pages-01.jpg);">
		<h2 class="l-text2 t-center add-shadow-light">
			Cart
		</h2>
	</section>


	<div class="container" style="margin-top: 20px;">
		<div class="alert alert-success block">
			<a href="?pg=home" class="btn btn-success btn-sm">
				Continue Shopping
			</a>
			&ensp;
			<strong>"<b><span id="show_quantity"></span></b> have been added to your cart".</strong>
		</div>
	</div>

	<!-- Cart -->
	<section class="cart bgwhite p-t-70 p-b-100 padding-top-10">
		<div class="container">
			<!-- Cart item -->
			<div class="container-table-cart pos-relative">
				<div class="wrap-table-shopping-cart bgwhite">
					<table class="table-shopping-cart" id="list-cart-item">
						<!-- cart items would be listed here -->
					</table>
				</div>
			</div>

			<div class="flex-w flex-sb-m p-t-25 p-b-25 bo8 p-l-35 p-r-60 p-lr-15-sm">
				<div class="flex-w flex-m w-full-sm">
					<div class="size11 bo4 m-r-10">
						<input class="sizefull s-text7 p-l-22 p-r-22" type="text" name="coupon-code" placeholder="Coupon Code">
					</div>

					<div class="size12 trans-0-4 m-t-10 m-b-10 m-r-10">
						<!-- Button --->
						<button class="flex-c-m sizefull bg1 bo-rad-23 hov1 s-text1 trans-0-4">
							Apply coupon
						</button>
					</div>
				</div>

				<div class="size10 trans-0-4 m-t-10 m-b-10">
					<!-- Button -->
					<form method="POST">
						<input type="submit" value="clear cart" name="clear_cart" class="flex-c-m sizefull bg1 bo-rad-23 hov1 s-text1 trans-0-4" style="padding:10px">
					</form>
				</div>
			</div>

			<!-- Total -->
			<div class="bo9 w-size18 p-l-40 p-r-40 p-t-30 p-b-38 m-t-30 m-r-0 m-l-auto p-lr-15-sm">
				<h5 class="m-text20 p-b-24">
					Cart Totals
				</h5>

				<!--  -->
				<div class="flex-w flex-sb-m p-b-12">
					<span class="s-text18 w-size19 w-full-sm">
						Subtotal:
					</span>

					<span class="m-text21 w-size20 w-full-sm">
						<input type="hidden" id="sub_total" value="">
						&#8358;<span id="total_price">0</span>
					</span>
				</div>

				<!--  -->
				<div class="flex-w flex-sb bo10 p-t-15 p-b-20">
					<span class="s-text18 w-size19 w-full-sm">
						Shipping:
					</span>

					<div class="w-size20 w-full-sm">

						<span class="s-text19">
							Shipping Location
						</span>
						<?php
							try{
								// get all the shippment methods
								$get_all_shippments = DB::getInstance()->all('shippment_option');

								// loop thru all shippment methods
								foreach($get_all_shippments->results() as $shippment_option){
						?>
						<div class="of-hidden w-size21 m-t-8 m-b-12">
							<input type="radio" class="shipping_method"
							name="shipping_method" id="shipping_method"
							data-id="<?php echo $shippment_option->shippment_option_code; ?>">
							<?php echo $shippment_option->shippment_option_desc; ?>:
							<b>&#8358;<?php echo number_format($shippment_option->shippment_option_price); ?></b>
						</div>
						<?php
								}
							}catch(Exception $e){
								die('Go to homepage');
							}
						?>
						<p class="s-text8 p-b-23">
							N:B: your items would arrive within 42hrs of purchase.
						</p>
					</div>
				</div>

				<!--  -->
				<div class="flex-w flex-sb-m p-t-26 p-b-30">
					<span class="m-text22 w-size19 w-full-sm">
						Total:
					</span>

					<span class="m-text21 w-size20 w-full-sm">
						<input type="hidden" id="total_" value="0">
						&#8358;<span id="total_price_">0</span>
					</span>
				</div>

				<div class="size15 trans-0-4">
					<!-- Button -->
					<button class="flex-c-m sizefull bg1 bo-rad-23 hov1 s-text1 trans-0-4" id="proceed_to_checkout" name="proceed_to_checkout">
						Proceed to Checkout
					</button>
				</div>
			</div>
		</div>
	</section>
