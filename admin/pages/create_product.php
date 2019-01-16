<form name="create-product-form" Method="POST" role="form">
<div class="row">
  <div class="col-sm-12 col-md-6">
    <div id="error">
      <!-- error goes here -->
    </div>
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
</div>
<div class="modal-footer">
<input type="hidden" name="form_token" value="<?php echo hash_hmac('sha256', Token::generate_unique('create_product'), $token); ?>">
<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
<button type="button" class="btn btn-primary btn-sm" id="create-product_">Create This Product</button>
</div>
</form>
