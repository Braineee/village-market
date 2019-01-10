<?php
if(isset($_GET['item']) && $_GET['item'] != ''){
	//get all details for the product
    extract($_GET);

    try{

        $get_item = DB::getInstance()->get("products", array("product_id","=",$item));

    }catch(Exception $e){

        die($e->getMessage());
        //die();

    }

	if($get_item->error() == true){

        die('please reload this page');

	}

}else{

    header('Location: index.php');

}
?>
<body class="animsition">

	<!-- breadcrumb -->
	<!--div class="bread-crumb bgwhite flex-w p-l-52 p-r-15 p-t-30 p-l-15-sm">
		<a href="index.php" class="s-text16">
			Home
			<i class="fa fa-angle-right m-l-8 m-r-9" aria-hidden="true"></i>
		</a>

		<a href="product.html" class="s-text16">
			Women
			<i class="fa fa-angle-right m-l-8 m-r-9" aria-hidden="true"></i>
		</a>

		<a href="#" class="s-text16">
			T-Shirt
			<i class="fa fa-angle-right m-l-8 m-r-9" aria-hidden="true"></i>
		</a>

		<span class="s-text17">
			Boxy T-Shirt with Roll Sleeve Detail
		</span>
	</div-->

	<!-- Product Detail -->
	<div class="container bgwhite p-t-35 p-b-80">
		<div class="flex-w flex-sb">
			<div class="w-size13 p-t-30 respon5">
				<div class="wrap-slick3 flex-sb flex-w">
					<div class="wrap-slick3-dots"></div>
					<div class="slick3">
						<div class="item-slick3" data-thumb="images/product_picture/<?php echo $get_item->first()->product_picture ?>">
							<div class="wrap-pic-w">
								<img src="images/product_picture/<?php echo $get_item->first()->product_picture ?>" alt="IMG-PRODUCT">
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="w-size14 p-t-30 respon5">
				<h4 class="product-detail-name m-text16 p-b-13">
					<?php echo $get_item->first()->product_name ?>
				</h4>

				<span class="m-text17">
                    &#8358;<?php echo number_format($get_item->first()->product_price); ?>
				</span>


				<!--  -->
				<div class="p-t-33 p-b-60">
					<div class="flex-r-m flex-w p-t-10">
						<div class="w-size16 flex-m flex-w">
							<div class="flex-w bo5 of-hidden m-r-22 m-t-10 m-b-10">
								<button class="btn-num-product-down color1 flex-c-m size7 bg8 eff2">
									<i class="fs-12 fa fa-minus" aria-hidden="true"></i>
								</button>
                                <?php
                                    //check i cart exist previously
                                    isset($_SESSION['cart'])? check_quantity($get_item) : $qaunt = 0;

                                    function check_quantity($get_item){
                                        for($i=0; $i< count($_SESSION['cart']); $i++){
                                            //check the previous quantity
                                            if(intval($_SESSION['cart'][$i]['ID']) == intval($get_item->first()->product_id)){
                                                $qaunt = $_SESSION['cart'][$i]['Quantity'];
                                                break;
                                            }
                                        }
                                    }
								?>

								<input class="size8 m-text18 t-center num-product"
										type="number"
										name="num-product"
										value="<?php if(isset($qaunt)){ echo $qaunt; }else{ echo 1;}?>"
										id="quantityProduct"
										data-id="<?php echo $get_item->first()->product_id ?>"
										data-name="<?php echo $get_item->first()->product_name?>">


								<button class="btn-num-product-up color1 flex-c-m size7 bg8 eff2">
									<i class="fs-12 fa fa-plus" aria-hidden="true"></i>
								</button>
							</div>

							<div class="btn-addcart-product-detail size9 trans-0-4 m-t-10 m-b-10">
								<!-- Button -->
								<button class="flex-c-m sizefull bg1 bo-rad-23 hov1 s-text1 trans-0-4" id="add_quantity">
									Add to Cart
								</button>
							</div>
						</div>
					</div>
				</div>

				<div class="p-b-45">
					<span class="s-text8 m-r-35">SKU: <?php echo $get_item->first()->product_id ?></span>
					<!--span class="s-text8">Categories: Mug, Design</span-->
				</div>

				<!--  -->
				<div class="wrap-dropdown-content bo6 p-t-15 p-b-14 active-dropdown-content">
					<h5 class="js-toggle-dropdown-content flex-sb-m cs-pointer m-text19 color0-hov trans-0-4">
						Description
						<i class="down-mark fs-12 color1 fa fa-minus dis-none" aria-hidden="true"></i>
						<i class="up-mark fs-12 color1 fa fa-plus" aria-hidden="true"></i>
                    </h5>

					<div class="dropdown-content dis-none p-t-15 p-b-23">
						<p class="s-text8">
							<?php echo $get_item->first()->product_description ?>
						</p>
                    </div>
                </div>
                <div class="wrap-dropdown-content bo6 p-t-15 p-b-14 active-dropdown-content">
                    <h5 class="js-toggle-dropdown-content flex-sb-m cs-pointer m-text19 color0-hov trans-0-4">
						Category
						<i class="down-mark fs-12 color1 fa fa-minus dis-none" aria-hidden="true"></i>
						<i class="up-mark fs-12 color1 fa fa-plus" aria-hidden="true"></i>
                    </h5>
                    <div class="dropdown-content dis-none p-t-15 p-b-23">
						<p class="s-text8">
                        <?php
                            $category = $get_item->first()->product_category;
                            $category_name = DB::getInstance()->get("ref_product_category", array("category_code","=",$category));
                            echo $category_name->first()->category_name;
                        ?>
						</p>
                    </div>
				</div>
			</div>
		</div>
	</div>


	<!-- Relate Product -->
	<section class="relateproduct bgwhite p-t-45 p-b-138">
		<div class="container">
			<div class="sec-title p-b-60">
				<h3 class="m-text5 t-center">
					Related Products
				</h3>
            </div>
            <!-- Slide2 -->
			<div class="wrap-slick2">
				<div class="slick2">
            <?php
                // get other items related to the above item

                try{
                    $related_item = DB::getInstance()->get("products",array("product_category","=",$category));
                    $counter = 0;
                }catch(Exception $e){
                    //die($e->getMessage());
                    die();
                }

                if($related_item->error() == true){
                    die('please reload this page');
                }

                // loop through the products
                while($related_item->count() > $counter){

            ?>


					<div class="item-slick2 p-l-15 p-r-15">
						<!-- Block2 -->
						<div class="block2">
							<div class="block2-img wrap-pic-w of-hidden pos-relative block2-labelnew">
								<img src="images/product_picture/<?php echo $related_item->results()[$counter]->product_picture ?>" height="300px" width="900px" alt="IMG-PRODUCT">

								<div class="block2-overlay trans-0-4">
									<a href="#" class="block2-btn-addwishlist hov-pointer trans-0-4">
										<i class="icon-wishlist icon_heart_alt" aria-hidden="true"></i>
										<i class="icon-wishlist icon_heart dis-none" aria-hidden="true"></i>
									</a>

									<div class="block2-btn-addcart w-size1 trans-0-4">
										<!-- Button -->
										<button class="flex-c-m size1 bg4 bo-rad-23 hov1 s-text1 trans-0-4 add_cartt" data-quantity="1" data-name="<?php echo $related_item->results()[$counter]->product_name?>" data-id="<?php echo $related_item->results()[$counter]->product_id ?>">
											Add to Cart
										</button>
									</div>
								</div>
							</div>

							<div class="block2-txt p-t-20">
								<a href="?pg=item-detail&item=<?php echo $related_item->results()[$counter]->product_id; ?>" class="block2-name dis-block s-text3 p-b-5">
                                    <?php echo $related_item->results()[$counter]->product_name ?>
								</a>

								<span class="block2-price m-text6 p-r-5">
                                    &#8358;<?php echo number_format($related_item->results()[$counter]->product_price) ?>
								</span>
							</div>
						</div>
					</div>


            <?php
                $counter++;
                }
            ?>
            	</div>
			</div>
		</div>
	</section>
