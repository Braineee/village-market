<?php
	if(isset($_POST)){
		if(isset($_POST['clear_cart'])){
			$_SESSION['cart'] = array();
			$_SESSION['grand_total'] = 0;
			$_SESSION['shipping_option'] = array();
		}
	}
?>
<!-- Header -->
<header class="header1">
		<!-- Header desktop -->
		<div class="container-menu-header">
			<div class="topbar">
				<div class="topbar-social">
					<a href="#" class="topbar-social-item fa fa-facebook"></a>
					<a href="#" class="topbar-social-item fa fa-instagram"></a>
					<a href="#" class="topbar-social-item fa fa-pinterest-p"></a>
					<a href="#" class="topbar-social-item fa fa-snapchat-ghost"></a>
					<a href="#" class="topbar-social-item fa fa-youtube-play"></a>
				</div>

				<span class="topbar-child1">
					Welcome to kpopvillage Online market
				</span>

				<div class="topbar-child2">
					<span class="topbar-email">
						<a href="mailto:info@kpopvillagemarket.com">info@kpopvillagemarket.com</a>
					</span>
				</div>
			</div>

			<div class="wrap_header">
				<!-- Logo -->
				<a href="?pg=home" class="logo">
					<img src="images/icons/logo.png" width="40px" height="70px" alt="IMG-LOGO">
				</a>

				<!-- Menu -->
				<div class="wrap_menu">
					<nav class="menu">
						<ul class="main_menu">
							<li>
								<a href="?pg=home">Home</a>
							</li>

							<!--
							loop through the categories
							get the first 6 category
							put the first 7 items in an array
							-->
							<?php
								try{

									$get_category = DB::getInstance()->all('ref_product_category');

									$category = $get_category->results();
									$first_6 = array();

									for($i=0 ; $i<6 ; $i++){

							?>
							<li>
								<a href="?pg=category&cat=<?php echo ucfirst($category[$i]->category_code); ?>"><?php echo ucfirst($category[$i]->category_name); ?></a>
							</li>
							<?php
										array_push($first_6, $category[$i]->category_name);
									}
								}catch(Exception $e){

								}
							?>
							<li>
								<a href="#">Others</a>
								<ul class="sub_menu">
								<?php
									try{
										$get_category_dropdow = DB::getInstance()->all('ref_product_category');

										 foreach($get_category_dropdow->results() as $category_dropdown) {

											if(!in_array($category_dropdown->category_name, $first_6)){
								?>

									<li><a href="?pg=category&cat=<?php echo ucfirst($category_dropdown->category_code); ?>"><?php echo ucfirst($category_dropdown->category_name); ?></a></li>

								<?php
											}

										}
									}catch(Exception $e){

									}
								?>
								</ul>
							</li>
						</ul>
					</nav>
				</div>
				&ensp;
				&ensp;
				&ensp;

				<!-- Header Icon -->
				<div class="header-icons">
					<a href="#" class="header-wrapicon1 dis-block" style="color:#56164c;">
						 <img src="images/icons/icon-header-01.png" class="header-icon1" alt="ICON"> &nbsp;
						 <?php
							 isset($username)? $msg = "<span class='purple'><a href='?pg=orders'>{$username}</a>"  :  $msg = "<span class=><a href='?pg=login'>Sign In</a></sapn>";
							 echo $msg;
						 ?>
					</a>

					<span class="linedivide1"></span>

					<div class="header-wrapicon2">
						<img src="images/icons/icon-header-02.png" class="header-icon1 js-show-header-dropdown" alt="ICON" id="get_cart_item">
						<span class="header-icons-noti" id="cart_count">0</span>

						<!-- Header cart noti -->
						<div class="header-cart header-dropdown">
							<ul class="header-cart-wrapitem list-item" id="list-item">

							</ul>

							<div class="header-cart-total">
								Total: <b> &#8358;<span class="totalprice" id="totalprice">0</span></b>
							</div>

							<div class="header-cart-buttons">
								<div class="header-cart-wrapbtn">
									<!-- Button -->
									<form method="POST">
										<input type="submit" value="clear cart" name="clear_cart" class="flex-c-m size1 bg1 bo-rad-20 hov1 s-text1 trans-0-4">
									</form>
								</div>
								<div class="header-cart-wrapbtn">
									<!-- Button -->
									<a href="?pg=cart" class="flex-c-m size1 bg1 bo-rad-20 hov1 s-text1 trans-0-4">
										View Cart
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Header Mobile -->
		<div class="wrap_header_mobile">
			<!-- Logo moblie -->
			<a href="?pg=home" class="logo-mobile">
				<img src="images/icons/logo.png" alt="IMG-LOGO">
				<!--span id="print_nav">Kpopvillage.com</span>
				<span id="print_nav">info@Kpopvillagemarket.com</span-->
			</a>

			<!--printing nav -->
			<div class="btn-show-menu" id="print_nav">
				<!-- Header Icon mobile -->
				<div class="header-icons-mobile">
					<a href="#" class="header-wrapicon1 dis-block">
					</a>
				</div>
			</div>
			<!-- Button show menu -->
			<div class="btn-show-menu">
				<!-- Header Icon mobile -->
				<div class="header-icons-mobile">
					<a href="#" class="header-wrapicon1 dis-block">
						<img src="images/icons/icon-header-01.png" class="header-icon1" alt="ICON">
					</a>

					<span class="linedivide2"></span>

					<div class="header-wrapicon2">
						<img src="images/icons/icon-header-02.png" class="header-icon1 js-show-header-dropdown" alt="ICON">
						<span class="header-icons-noti" id="cart_count2">0</span>

						<!-- Header cart noti -->
						<div class="header-cart header-dropdown">
							<ul class="header-cart-wrapitem list-item2" id="list-item2">

							</ul>

							<div class="header-cart-total">
								Total: &#8358;<span id="totalprice2">0</span>
							</div>

							<div class="header-cart-buttons">
								<div class="header-cart-wrapbtn">
									<!-- Button -->
									<form method="POST">
										<input type="submit" value="clear cart" name="clear_cart" class="flex-c-m size1 bg1 bo-rad-20 hov1 s-text1 trans-0-4">
									</form>
								</div>

								<div class="header-cart-wrapbtn">
									<!-- Button -->
									<a href="?pg=cart" class="flex-c-m size1 bg1 bo-rad-20 hov1 s-text1 trans-0-4">
										View Cart
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="btn-show-menu-mobile hamburger hamburger--squeeze">
					<span class="hamburger-box">
						<span class="hamburger-inner"></span>
					</span>
				</div>
			</div>
		</div>

		<!-- Menu Mobile -->
		<div class="wrap-side-menu" >
			<nav class="side-menu">
				<ul class="main-menu">
					<li class="item-topbar-mobile p-l-20 p-t-8 p-b-8">
						<span class="topbar-child1">
							<a href="mailto:info@kpopvillagemarket.com">info@kpopvillagemarket.com</a>
						</span>
					</li>

					<li class="item-topbar-mobile p-l-20 p-t-8 p-b-8 text-center">
						<div class="topbar-child2-mobile">
							<div class="topbar-language rs1-select2">
								<?php
									isset($username)? $msg = "<span class='purple'><a href='?pg=dashboard'>{$username}</a> &nbsp; | &nbsp;<a href='?pg=logout'>logout</a></sapn>"  :  $msg = "<span class=><a href='?pg=login'>Sign In</a></sapn>";
									echo $msg;
								?>
							</div>
						</div>
					</li>

					<li class="item-topbar-mobile p-l-10">
						<div class="topbar-social-mobile">
							<a href="#" class="topbar-social-item fa fa-facebook purple"></a>
							<a href="#" class="topbar-social-item fa fa-instagram purple"></a>
							<a href="#" class="topbar-social-item fa fa-pinterest-p purple"></a>
							<a href="#" class="topbar-social-item fa fa-snapchat-ghost purple"></a>
							<a href="#" class="topbar-social-item fa fa-youtube-play purple"></a>
						</div>
					</li>


					<li class="item-menu-mobile">
						<a href="?pg=home">Home</a>
					</li>

					<?php
						try{
							for($i=0 ; $i<6 ; $i++){
					?>
					<li class="item-menu-mobile">
						<a href="?pg=category&cat=<?php echo ucfirst($category[$i]->category_code); ?>"><?php echo ucfirst($category[$i]->category_name); ?></a>
					</li>
					<?php
							}
						}catch(Exception $e){

						}
					?>

					<li class="item-menu-mobile">
						<a href="index.php">Others</a>
						<ul class="sub-menu">
							<?php
								try{

									 foreach($get_category_dropdow->results() as $category_dropdown) {

										if(!in_array($category_dropdown->category_name, $first_6)){
							?>
								<li><a href="?pg=category&cat=<?php echo ucfirst($category_dropdown->category_code); ?>"><?php echo ucfirst($category_dropdown->category_name); ?></a></li>
							<?php
										}

									}
								}catch(Exception $e){

								}
							?>
						</ul>
						<i class="arrow-main-menu fa fa-angle-right" aria-hidden="true"></i>
					</li>

				</ul>
			</nav>
		</div>
	</header>
