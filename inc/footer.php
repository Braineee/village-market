<!-- Footer -->
<footer class="bg6 p-t-45 p-b-43 p-l-45 p-r-45">
		<div class="flex-w p-b-90">
			<div class="w-size6 p-t-30 p-l-15 p-r-15 respon3">
				<h4 class="s-text12 p-b-30">
					CONTACT US:
				</h4>

				<div>
					<p class="s-text7 w-size27">
						8th floor, 379 Hudson St, New York, NY 10018<br>
						Or call: <br>
						(+1) 96 716 6879<br>
						(+1) 96 716 6879<br>
						Email:<br>
						<a href="mailto:info@kpopvillagemarket.com" style="color:#fff;">info@kpopvillagemarket.com</a>

					</p>

					<div class="flex-m p-t-30">
						<a href="#" class="fs-18 color1 p-r-20 fa fa-facebook"></a>
						<a href="#" class="fs-18 color1 p-r-20 fa fa-instagram"></a>
						<a href="#" class="fs-18 color1 p-r-20 fa fa-pinterest-p"></a>
						<a href="#" class="fs-18 color1 p-r-20 fa fa-snapchat-ghost"></a>
						<a href="#" class="fs-18 color1 p-r-20 fa fa-youtube-play"></a>
					</div>
				</div>
			</div>

			<div class="w-size7 p-t-30 p-l-15 p-r-15 respon4">
				<h4 class="s-text12 p-b-30">
					Categories
				</h4>

				<ul>
					<?php
						// get all categories
							$get_all_cat2 = DB::getInstance()->all("ref_product_category");

							$category_list2 = $get_all_cat2->results();

							isset($category_list2)? list_categories2($category_list2) : "";

							function list_categories2($category_list2){

											// loop through the list of categories
											foreach($category_list2 as $category2){
					?>
					<li class="p-b-9">
						<a href="?pg=category&cat=<?php if(isset($category2->category_code)){echo $category2->category_code;} ?>" class="s-text7">
							<?php if(isset($category2->category_name)){echo $category2->category_name;} ?>
						</a>
					</li>
					<?php
											}
								}

					?>
				</ul>
			</div>

			<div class="w-size7 p-t-30 p-l-15 p-r-15 respon4">
				<h4 class="s-text12 p-b-30">
					Links
				</h4>

				<ul>

					<li class="p-b-9">
						<a href="#" class="s-text7">
							About Us
						</a>
					</li>
					<li class="p-b-9">
						<a href="#" class="s-text7">
							Privacy Policy
						</a>
					</li>
					<li class="p-b-9">
						<a href="#" class="s-text7">
							Terms & Condition
						</a>
					</li>
					<li class="p-b-9">
						<a href="#" class="s-text7">
							Help & FAQ
						</a>
					</li>
				</ul>
			</div>

			<div class="w-size8 p-t-30 p-l-15 p-r-15 respon3">
				<h4 class="s-text12 p-b-30">
					Sign In
				</h4>


					<div class="effect1 w-size9">
						<input class="s-text7 bg6 w-full p-b-5" type="text" name="email_" placeholder="Enter your email">
						<span class="effect1-line"></span>
					</div>

					<div class="w-size2 p-t-20">
						<!-- Button -->
						<button type="submit" class="flex-c-m size2 bg4 bo-rad-23 hov1 m-text3 trans-0-4">
							Sign In
						</button>
					</div>
			</div>
		</div>
	</footer>



	<!-- Back to top -->
	<div class="btn-back-to-top bg0-hov" id="myBtn">
		<span class="symbol-btn-back-to-top">
			<i class="fa fa-angle-double-up" aria-hidden="true"></i>
		</span>
	</div>

	<!-- Container Selection1 -->
	<div id="dropDownSelect1"></div>


<!--===============================================================================================-->
	<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/vendor/bootstrap/js/popper.js"></script>
	<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/vendor/select2/select2.min.js"></script>
	<script type="text/javascript">
		$(".selection-1").select2({
			minimumResultsForSearch: 20,
			dropdownParent: $('#dropDownSelect1')
		});
	</script>
	<script>
		$(document).ready(function(){
		    $('[data-toggle="tooltip"]').tooltip();
		});
	</script>
<!--===============================================================================================-->
	<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/vendor/slick/slick.min.js"></script>
	<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/slick-custom.js"></script>
<!--===============================================================================================-->
	<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/vendor/lightbox2/js/lightbox.min.js"></script>
<!--===============================================================================================-->
	<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/vendor/sweetalert/sweetalert.min.js"></script>
<!--===============================================================================================-->
	<script type="text/javascript" src="<?php echo BASE_URL; ?>ajax/addtocart.js"></script>
	<script type="text/javascript" src="<?php echo BASE_URL; ?>ajax/load_cart.js"></script>
	<script type="text/javascript" src="<?php echo BASE_URL; ?>ajax/get_cart_item.js"></script>
	<script type="text/javascript" src="<?php echo BASE_URL; ?>ajax/checkout.js"></script>
	<script type="text/javascript" src="<?php echo BASE_URL; ?>ajax/update.js"></script>
<!--===============================================================================================-->
	<script src="<?php echo BASE_URL; ?>assets/js/main.js"></script>

</body>
</html>
