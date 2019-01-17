<?php
if(!isset($_GET['product'])){
  echo "<script> location.replace('?pg=products'); </script>";
  die();
}else{
  $id = $_GET['product'];

  //pass the id into the edit session
  $_SESSION['edit_id'] = $_GET['product'];

  // get the product by this id
  try{
    //prepare query
    $query = "
      SELECT products.*, ref_product_category.* FROM Products
      INNER JOIN ref_product_category ON products.product_category = ref_product_category.category_code
      WHERE products.product_id = {$id}
    ";
    //run query
    $get_list_of_products = DB::getInstance()->query($query);
    $list_of_products = $get_list_of_products->first();

    $_POST['id'] = $list_of_products->product_id;
    $_POST['product_name'] = $list_of_products->product_name;
    $_POST['product_description'] = $list_of_products->product_description;
    $_POST['product_category'] = $list_of_products->category_name;
    $_POST['product_category_code'] = $list_of_products->product_category;
    $_POST['product_price'] = $list_of_products->product_price;
    $_POST['product_picture'] = $list_of_products->product_picture;

  }catch(Exception $e){
    die('<a href="?pg=home" class="btn btn-success">Goto homepage</a>');
  }
}
var_dump($_POST);
?>
<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Update Product</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
      <a href="?pg=products" class="btn btn-sm btn-success">
        Back
      </a>
    </div>
  </div>
  <div class="">
    <div class="row">
        <div class="col-sm-12 col-md-6">
          <div id="error">
            <!-- error goes here -->
          </div>
          <form name="update-product-form" class="form-control" method="post">
            <div class="form-group">
              <label for="product_name">Name <abbr class="required" title="required">*</abbr></label>
              <input
                    type="text"
                    id="product_name"
                    name="product_name"
                    class="form-control"
                    placeholder="Enter name of product here"
                    value = "<?php if(isset($_POST['product_name'])){ echo $_POST['product_name']; }?>">
            </div>

            <label for="product_price">Price<abbr class="required" title="required">*</abbr></label>
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text">&#8358;</span>
              </div>
              <input
                    type="number"
                    class="form-control"
                    id="product_price"
                    name="product_price"
                    placeholder="Enter price for product here"
                    value = "<?php if(isset($_POST['product_price'])){ echo $_POST['product_price']; }?>">
            </div>

            <div class="form-group">
              <label for="product_price">Category <abbr class="required" title="required">*</abbr></label>
              <select class="form-control" name="product_category" id="product_category">
                <option value="">Select product category</option>
                <?php
                try{

                  //get the list of categories
                  $categories = DB::getInstance()
                  ->all('ref_product_category');
                  foreach($categories->results() as $category){
                ?>
                <option value="<?= $category->category_code; ?>"
                  <?php if(isset($_POST['product_category_code'])){
                          if($_POST['product_category_code'] == $category->category_code){
                            echo "selected";
                          }
                        }?>><?= $category->category_name; ?></option>
                  <?php
                  }
                }catch(Exception $e){
                  die('<a href="?pg=dashboard" class="btn btn-success">Err: Click This button to go to dashboard</a>');
                }
                ?>
              </select>
            </div>

            <div class="form-group">
              <label for="product_desc">Description <abbr class="required" title="required">*</abbr></label>
              <textarea name="product_desc" id="product_desc" class="form-control" ><?php if(isset($_POST['product_description'])){ echo $_POST['product_description']; }?></textarea>
            </div>
            <br>
            <div class="form-group">
              <button type="submit" name="update-product" id="update-product" class="btn btn-success btn-block">Update This Product</button>
            </div>
        </div>
        <div class="col-sm-12 col-md-6 text-center border-left-show">
          <div>
            <label for="product_image">
              <img src="<?= BASE_URL ?>assets/img/box_image.png" width="60%" id="display_" alt="product_img">
            </label>
          </div>
          <div class="text-danger">
            <strong>NB: Click the box to select an image for this product</strong>
            <input type="file" style="display:none;" name="product_image" id="product_image">
          </div>
        </div>
        </form>
    </div>
  </div>
</main>
</div>
</div>
<script type="text/javascript" src="<?php echo BASE_URL; ?>ajax/product.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL; ?>ajax/pre_save.js"></script>
