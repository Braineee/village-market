<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Products</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
      <!--div class="btn-group mr-2">
        <button class="btn btn-sm btn-outline-secondary">Share</button>
        <button class="btn btn-sm btn-outline-secondary">Export</button>
      </div-->
      <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#create-product">
        <span data-feather="plus"></span>
        Product
      </button>
    </div>
  </div>
  <div class="table-responsive">
    <table class="table table-striped table-sm">
      <thead>
        <tr>
          <th>#</th>
          <th>ID</th>
          <th>Name</th>
          <th>Category</th>
          <th>Price</th>
          <th>Option</th>
        </tr>
      </thead>
      <tbody id="product-table">
      <!-- loop the records here -->
      </tbody>
    </table>
  </div>
</main>
</div>
</div>

<!-- create product Modal -->
<div class="modal fade" id="create-product" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New Product</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form name="create-product-form" Method="POST">
        <div class="row">
          <div class="col-sm-12 col-md-6">
              <div class="form-group">
                <label for="product_name">Name <abbr class="required" title="required">*</abbr></label>
                <input type="text" id="product_name" name="product_name" class="form-control" placeholder="Enter name of product here">
              </div>

              <div class="form-group">
                <label for="product_price">Price <abbr class="required" title="required">*</abbr></label>
                <input type="number" id="product_price" name="product_price" class="form-control" placeholder="Enter price for product here">
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
                  <option value="<?= $category->category_code; ?>"><?= $category->category_name; ?></option>
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
                <textarea name="product_desc" id="product_desc" class="form-control">Enter description here</textarea>
              </div>
          </div>
          <div class="col-sm-12 col-md-6 text-center border-left-show">
            <div>
              <label for="product_image">
                <img src="<?= BASE_URL ?>assets/img/box_image.png" width="70%" id="display_" alt="product_img">
              </label>
            </div>
            <div class="text-danger">
              <strong>NB: Click the box to select an image for this product</strong>
              <input type="file" style="display:none;" name="product_image" id="product_image">
            </div>
          </div>
        </div>
        </form>
      </div>
      <div class="modal-footer">
        <input type="hidden" name="form_token" value="<?php echo hash_hmac('sha256', Token::generate_unique('login'), $token); ?>">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary btn-sm" id="create-product">Create This Product</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript" src="<?php echo BASE_URL; ?>ajax/product.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL; ?>ajax/pre_save.js"></script>
