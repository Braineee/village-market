<?php

if(isset($_GET['cat']) && $_GET['cat'] != ''){
	//get all details for the product
    extract($_GET);

    try{
        // Get the name of the category
        $get_cat_name = DB::getInstance()->get("ref_product_category", array("category_code","=",$cat));
        $category_name = $get_cat_name->first()->category_name;
        $category_description = $get_cat_name->first()->category_description;

        // get all categories
        $get_all_cat = DB::getInstance()->all("ref_product_category");
        $category_list = $get_all_cat->results();

        // get the list of items under this category
        $get_cat = DB::getInstance()->get("products", array("product_category","=",$cat));

    }catch(Exception $e){

        die($e->getMessage());
        //die();

    }

	if($get_cat->error() == true){

        die('please reload this page');

	}

}else{

    header('Location: ?pg=home');

}
?>
<body class="animsition">
	<!-- Title Page -->
	<section class="bg-title-page p-t-50 p-b-40 flex-col-c-m" style="background-image: url(images/master-slide-08.jpg);">
		<h2 class="l-text2 t-center">
            <?php if(isset($category_name)){echo $category_name;}?>
		</h2>
		<p class="m-text13 t-center">
            <?php if(isset($category_description)){echo $category_description;}?>
		</p>
	</section>


	<!-- Content page -->
	<section class="bgwhite p-t-55 p-b-65">
		<div class="container">
			<div class="row">
				<div class="col-sm-6 col-md-4 col-lg-3 p-b-50">
					<div class="leftbar p-r-20 p-r-0-sm">
						<!--  -->
						<h4 class="m-text14 p-b-7">
							Categories
						</h4>

						<ul class="p-b-54">

                            <?php


                                isset($category_list)? list_categories($category_list) : "";


                                function list_categories($category_list){
                                    try{
                                        // loop through the list of categories
                                        foreach($category_list as $category){
                            ?>
							<li class="p-t-4">
								<a href="?pg=category&cat=<?php if(isset($category->category_code)){echo $category->category_code;} ?>" class="s-text13">
									<?php if(isset($category->category_name)){echo $category->category_name;} ?>
								</a>
              </li>
                            <?php
                                        }
                                    }catch(Exception $e){
                                        //die($e->getMessage());
                                        die("Goto Home page");
                                    }
                                }
                            ?>

						</ul>
						<!--div class="search-product pos-relative bo4 of-hidden">
							<input class="s-text7 size6 p-l-23 p-r-50" type="text" name="search-product" placeholder="Search Products...">

							<button class="flex-c-m size5 ab-r-m color2 color0-hov trans-0-4">
								<i class="fs-12 fa fa-search" aria-hidden="true"></i>
							</button>
						</div-->
					</div>
				</div>

				<div class="col-sm-6 col-md-8 col-lg-9 p-b-50">
					<!--  -->
					<div class="flex-sb-m flex-w p-b-35">
						<!--span class="s-text8 p-t-5 p-b-5">
							Showing 1–12 of 16 results
						</span-->
                    </div>
                    <?php
                        if($get_cat->count() == 0){
                            echo '
                                <div class="alert alert-dismissable alert-danger block">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <strong>Oops!, &ensp; No Item was found in this category</strong>
                                </div>
                            ';
                        }
                    ?>
					<!-- Product -->
					<div class="row">
                        <?php
                            // loop all the product in this category
                            foreach($get_cat->results() as $cat_items){
                        ?>
						<div class="col-sm-12 col-md-6 col-lg-4 p-b-50">
							<!-- Block2 -->
							<div class="block2">
								<div class="block2-img wrap-pic-w of-hidden pos-relative block2-labelnew">
									<img src="images/product_picture/<?php echo $cat_items->product_picture; ?>" height="300px" width="900px" alt="IMG-PRODUCT">

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
								</div>

								<div class="block2-txt p-t-20">
									<a href="?pg=item-detail&item=<?php echo $cat_items->product_id; ?>" class="block2-name dis-block s-text3 p-b-5">
                                        <?php if(isset($cat_items->product_name)){echo $cat_items->product_name;} ?>
									</a>
									<span class="block2-price m-text6 p-r-5">
                                        &#8358;<?php if(isset($cat_items->product_price)){echo number_format($cat_items->product_price);} ?>
									</span>
								</div>
							</div>
                        </div>
                        <?php
                            }
                        ?>
                    </div>
					<!-- Pagination -->
					<!--div class="pagination flex-m flex-w p-t-26">
						<a href="#" class="item-pagination flex-c-m trans-0-4 active-pagination">1</a>
						<a href="#" class="item-pagination flex-c-m trans-0-4">2</a>
					</div-->
				</div>
			</div>
		</div>
	</section>
