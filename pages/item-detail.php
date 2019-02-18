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

  $get_item = $get_item->first();

}else{

    header('Location: index.php');

}
?>
<body class="animsition">

	<!-- Product Detail -->
	<div class="container bgwhite p-t-35 p-b-80">
		<div class="flex-w flex-sb">
			<div class="w-size13 p-t-30 respon5">
				<div class="wrap-slick3 flex-sb flex-w">
					<div class="wrap-slick3-dots"></div>
					<div class="slick3">
						<div class="item-slick3" data-thumb="images/product_picture/<?php echo $get_item->product_picture ?>">
							<div class="wrap-pic-w">
								<img src="images/product_picture/<?php echo $get_item->product_picture ?>" alt="IMG-PRODUCT">
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="w-size14 p-t-30 respon5">
				<h4 class="product-detail-name m-text16 p-b-13">
					<?php echo $get_item->product_name ?>
				</h4>
        <?php
        // check if there is an offer on this product
        $bonus_item_check = DB::getInstance()->get('offers', array('product_id', '=', $get_item->product_id));
        if($bonus_item_check->error() == true){
            die('please reload this page');
        }
        $is_a_bonus = false;
        if($bonus_item_check->count() > 0){
          $is_a_bonus = true;
          $item_price = $bonus_item_check->first()->bonus_price;
        }else{
          $item_price = $get_item->product_price;
        }
        ?>
				<span class="m-text17">
            <?php
              if($is_a_bonus == true){
            ?>
            <span class="text-danger" style="font-size:20px;"><strike>&#8358;<?php echo number_format($get_item->product_price); ?></strike></span><br>
            <?php
              }
            ?>
            &#8358;<?php echo number_format($item_price); ?>
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
                                            if(intval($_SESSION['cart'][$i]['ID']) == intval($get_item->product_id)){
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
										data-id="<?php echo $get_item->product_id ?>"
										data-name="<?php echo $get_item->product_name?>">


								<button class="btn-num-product-up color1 flex-c-m size7 bg8 eff2">
									<i class="fs-12 fa fa-plus" aria-hidden="true"></i>
								</button>
							</div>

							<div class="btn-addcart-product-detail size9 trans-0-4 m-t-10 m-b-10">
								<!-- Button -->
                <?php
                  if(!$get_item->out_of_stock == 1){
                ?>
								<button class="flex-c-m sizefull bg1 bo-rad-23 hov1 s-text1 trans-0-4" id="add_quantity">
									Add to Cart
								</button>
              <?php } ?>
							</div>
						</div>
					</div>
				</div>

				<div class="p-b-45">
					<span class="s-text8 m-r-35">SKU: <?php echo $get_item->product_id ?></span>
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
							<?php echo $get_item->product_description ?>
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
                    $category = $get_item->product_category;
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

                $related_item_ = $related_item->results();
                $related_item_count = $related_item->count();

                // loop through the productss
                while($related_item_count > $counter){

                  //check if the product is slashed
                  $bonus_item_check = DB::getInstance()->get('offers', array('product_id', '=', $related_item_[$counter]->product_id));
                  if($bonus_item_check->error() == true){
                      die('please reload this page');
                  }
                  $is_bonus = false;
                  if($bonus_item_check->count() > 0){
                    $is_bonus = true;
                    $bonus_old_price = $bonus_item_check->first()->real_price;
                    $bonus_price = $bonus_item_check->first()->bonus_price;
                  }

            ?>


					<div class="item-slick2 p-l-15 p-r-15">
						<!-- Block2 -->
						<div class="block2">
              <?php
                if($is_bonus == true){
                  //there is a price slash on this product
              ?>
              <div class="block2-img wrap-pic-w of-hidden pos-relative block2-labelsale">
              <?php
                }else{
                 // there is no price slash on this product
              ?>
              <div class="block2-img wrap-pic-w of-hidden pos-relative block2-labelnew">
              <?php
                }
              ?>
								<img src="images/product_picture/<?php echo $related_item_[$counter]->product_picture ?>" height="300px" width="900px" alt="IMG-PRODUCT">

                <?php
                  if($related_item_[$counter]->out_of_stock == 1)
                    {
                      echo '<div class="over-lay">OUT OF STOCK!</div>';
                    }else{
                ?>
                <div class="block2-overlay trans-0-4">
                  <a href="#" class="block2-btn-addwishlist hov-pointer trans-0-4">
                    <i class="icon-wishlist icon_heart_alt" aria-hidden="true"></i>
                    <i class="icon-wishlist icon_heart dis-none" aria-hidden="true"></i>
                  </a>
                  <div class="block2-btn-addcart w-size1 trans-0-4">
                    <!-- Button -->
                    <button class="flex-c-m size1 bg4 bo-rad-23 hov1 s-text1 trans-0-4 add_cartt" data-quantity="1" data-name="<?php echo $cat_items->product_name?>" data-id="<?php echo $cat_items->product_id ?>">
                      Add to Cart
                    </button>
                  </div>
                </div>
                <?php } ?>
							</div>

							<div class="block2-txt p-t-20">
								<a href="?pg=item-detail&item=<?php echo $related_item_[$counter]->product_id; ?>" class="block2-name dis-block s-text3 p-b-5">
                                    <?php echo $related_item_[$counter]->product_name ?>
								</a>

                <?php
                  if($is_bonus == true){
                    //there is a price slash on this product
                ?>
                <span class="block2-oldprice m-text7 p-r-5">
                  &#8358;<?php echo number_format($bonus_old_price) ?>
                </span>

                <span class="block2-newprice m-text8 p-r-5">
                  &#8358;<?php echo number_format($bonus_price) ?>
                </span>
                <?php
                  }else{
                   // there is no price slash on this product
                ?>
                <span class="block2-price m-text6 p-r-5">
                    &#8358;<?php echo number_format($related_item_[$counter]->product_price) ?>
								</span>
                <?php
                  }
                ?>
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
