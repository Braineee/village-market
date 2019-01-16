<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Products</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
      <!--div class="btn-group mr-2">
        <button class="btn btn-sm btn-outline-secondary">Share</button>
        <button class="btn btn-sm btn-outline-secondary">Export</button>
      </div-->
      <button class="btn btn-sm btn-success">
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

<!-- view product Modal -->
<div class="modal fade" id="view-product-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="product-title"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-sm-12 col-md-6">
            <div id="error">
              <!-- error goes here -->
            </div>
              <div class="form-group">
                <label for="product_name">Name <abbr class="required" title="required">*</abbr></label>
                <input type="text" id="product_name" name="product_name" class="form-control" disabled='true' placeholder="Enter name of product here">
              </div>

              <!--div class="form-group">
                <label for="product_price">Price(&#8358;) <abbr class="required" title="required">*</abbr></label>
                <input type="text" id="product_price" name="product_price" class="form-control" disabled='true' placeholder="Enter price for product here">
              </div-->
              <label for="product_price">Price<abbr class="required" title="required">*</abbr></label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text">&#8358;</span>
                </div>
                <input type="text" class="form-control" id="product_price" name="product_price" disabled='true' placeholder="Enter price for product here">
              </div>

              <div class="form-group">
                <label for="product_price">Category <abbr class="required" title="required">*</abbr></label>
                <input type="text" id="product_category" name="product_category" class="form-control" disabled='true' placeholder="Enter price for product here">
              </div>

              <div class="form-group">
                <label for="product_desc">Description <abbr class="required" title="required">*</abbr></label>
                <textarea name="product_desc" id="product_desc" class="form-control" disabled='true'>Enter description here</textarea>
              </div>
          </div>
          <div class="col-sm-12 col-md-6 text-center border-left-show">
            <div>
              <label for="product_image">
                <img src="" width="70%" id="display_" alt="product_img">
              </label>
            </div>
          </div>
        </div>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript" src="<?php echo BASE_URL; ?>ajax/product.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL; ?>ajax/pre_save.js"></script>
