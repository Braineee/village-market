<body class="animsition">

<!-- Slide1 -->
<section class="slide1">
    <div class="wrap-slick1">
        <div class="slick1">
            <div class="item-slick1 item1-slick1" style="background-image: url(images/master-slide-01.jpg);">
                <div class="wrap-content-slide1 sizefull flex-col-c-m p-l-15 p-r-15 p-t-150 p-b-170">
                    <span class="caption1-slide1 m-text1 t-center animated visible-false m-b-15" data-appear="fadeInDown">

                    </span>

                    <h2 class="caption2-slide1 xl-text1 t-center animated visible-false m-b-37 add-shadow-light" data-appear="fadeInUp">
                        Fruits & Vegetables
                    </h2>

                    <div class="wrap-btn-slide1 w-size1 animated visible-false" data-appear="zoomIn">
                        <!-- Button -->
                        <a href="product.html" class="flex-c-m size2 bo-rad-23 s-text2 bgwhite hov1 trans-0-4">
                            Shop Now
                        </a>
                    </div>
                </div>
            </div>
            <div class="item-slick1 item1-slick1" style="background-image: url(images/master-slide-03.jpg);">
                <div class="wrap-content-slide1 sizefull flex-col-c-m p-l-15 p-r-15 p-t-150 p-b-170">
                    <span class="caption1-slide1 m-text1 t-center animated visible-false m-b-15" data-appear="fadeInDown">

                    </span>

                    <h2 class="caption2-slide1 xl-text1 t-center animated visible-false m-b-37 add-shadow-light" data-appear="fadeInUp">
                        Fresh Sea Foods
                    </h2>

                    <div class="wrap-btn-slide1 w-size1 animated visible-false" data-appear="zoomIn">
                        <!-- Button -->
                        <a href="product.html" class="flex-c-m size2 bo-rad-23 s-text2 bgwhite hov1 trans-0-4">
                            Shop Now
                        </a>
                    </div>
                </div>
            </div>

            <div class="item-slick1 item2-slick1" style="background-image: url(images/master-slide-07.jpg);">
                <div class="wrap-content-slide1 sizefull flex-col-c-m p-l-15 p-r-15 p-t-150 p-b-170">
                    <span class="caption1-slide1 m-text1 t-center animated visible-false m-b-15" data-appear="rollIn">

                    </span>

                    <h2 class="caption2-slide1 xl-text1 t-center animated visible-false m-b-37 add-shadow-light" data-appear="lightSpeedIn">
                        Meats & Sea Foods
                    </h2>

                    <div class="wrap-btn-slide1 w-size1 animated visible-false" data-appear="slideInUp">
                        <!-- Button -->
                        <a href="product.html" class="flex-c-m size2 bo-rad-23 s-text2 bgwhite hov1 trans-0-4">
                            Shop Now
                        </a>
                    </div>
                </div>
            </div>

            <div class="item-slick1 item3-slick1" style="background-image: url(images/master-slide-06.jpg);">
                <div class="wrap-content-slide1 sizefull flex-col-c-m p-l-15 p-r-15 p-t-150 p-b-170">
                    <span class="caption1-slide1 m-text1 t-center animated visible-false m-b-15" data-appear="rotateInDownLeft">

                    </span>

                    <h2 class="caption2-slide1 xl-text1 t-center animated visible-false m-b-37 add-shadow-light" data-appear="rotateInUpRight">
                        Raw Food Items
                    </h2>

                    <div class="wrap-btn-slide1 w-size1 animated visible-false" data-appear="rotateIn">
                        <!-- Button -->
                        <a href="product.html" class="flex-c-m size2 bo-rad-23 s-text2 bgwhite hov1 trans-0-4">
                            Shop Now
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Product -->
<section class="newproduct bgwhite p-t-45 p-b-105">
    <!--
    * loop through the list of categories
    * nested loop - loop throught the product under each of those category
    -->
    <?php
        try{
            //get the list of category
            $get_cat_list = DB::getInstance()->get('ref_product_category',array("show_on_homepage","=",1));

            $cat_list_results = $get_cat_list->results();

            $cat_list_count = $get_cat_list->count();

            if($cat_list_count > 0){


                foreach($cat_list_results as $category){
    ?>
    <br>
    <div class="container">
        <div class="sec-title p-b-60">
            <h3 class="m-text5 t-center">
                <?php echo $category->category_name; ?>
            </h3>
        </div>

        <!-- Slide2 -->
        <div class="wrap-slick2">
            <div class="slick2">
                <?php

                    try{
                        $all_item = DB::getInstance()->get("products", array("product_category","=",$category->category_code));
                        $counter = 0;
                    }catch(Exception $e){
                        //die($e->getMessage());
                        die();
                    }

                    if($all_item->error() == true){
                        die('please reload this page');
                    }

                    if($all_item->count() == 0){
                        echo '
                            <div class="alert alert-danger block">
                                <strong><b>Oops!...</b><br><br>No Item was found in this category.</strong>
                            </div>
                        ';
                    }

                    // loop through the products
                    while($all_item->count() > $counter){
                ?>
                    <div class="item-slick2 p-l-15 p-r-15">
                        <!-- Block2 -->
                        <div class="block2">
                            <div class="block2-img wrap-pic-w of-hidden pos-relative block2-labelnew">

                                <img src="images/product_picture/<?php echo $all_item->results()[$counter]->product_picture ?>" height="300px" width="900px" alt="IMG-PRODUCT">
                                <?php
                                  if($all_item->results()[$counter]->out_of_stock == 1)
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
                                        <button class="flex-c-m size1 bg4 bo-rad-23 hov1 s-text1 trans-0-4 add_cartt" data-quantity="1" data-name="<?php echo $all_item->results()[$counter]->product_name?>" data-id="<?php echo $all_item->results()[$counter]->product_id ?>">
                                            Add to Cart
                                        </button>
                                    </div>
                                </div>
                              <?php } ?>
                            </div>

                            <div class="block2-txt p-t-20">
                                <a href="?pg=item-detail&item=<?php echo $all_item->results()[$counter]->product_id ?>" class="block2-name dis-block s-text3 p-b-5">
                                    <?php echo $all_item->results()[$counter]->product_name ?> &ensp; <!--span class="btn btn-primary btn-sm"><i class="fa fa-eye"></i></span-->
                                </a>

                                <span class="block2-price m-text6 p-r-5">
                                    &#8358;<?php echo number_format($all_item->results()[$counter]->product_price) ?>
                                </span>
                            </div>
                        </div>
                    </div>
                <?php
                    $counter ++;
                    }
                ?>
            </div>
        </div>
        <br>
        <br>
        <div class="p-t-20 t-center">
            <!-- Button -->
            <a href="?pg=category&cat=<?php echo $category->category_code; ?>" class=" btn w-size6 bo-rad-23 m-text3 trans-0-4 purple-botton"> View all </a>

        </div>
    </div>
    <br>
    <hr>
    <?php
                }// close category loop
            }// close category iff
        }catch(Exception $e){
            die($e->getMessage());
        }// close try
    ?>


   </section>


<!-- Shipping -->
<section class="shipping bgwhite p-b-46">
    <div class="flex-w p-l-15 p-r-15">
        <div class="flex-col-c w-size5 p-l-15 p-r-15 p-t-16 p-b-15 respon1">
            <h4 class="m-text12 t-center">
                <img src="images/icons/bank_transfer.png" width="50%" alt="payment_logos">
            </h4>
        </div>

        <div class="flex-col-c w-size5 p-l-15 p-r-15 p-t-16 p-b-15 bo2 respon2">
            <h4 class="m-text12 t-center">
                <img src="images/icons/cash_on_delivery.png" width="50%" alt="payment_logos">
            </h4>
        </div>

        <div class="flex-col-c w-size5 p-l-15 p-r-15 p-t-16 p-b-15 respon1">
            <h4 class="m-text12 t-center">
                <img src="images/icons/payment_logo.png" width="50%" alt="payment_logos">
            </h4>


        </div>
    </div>
</section>
