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
  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">Open modal for @mdo</button>
  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-whatever="@fat">Open modal for @fat</button>
  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-whatever="@getbootstrap">Open modal for @getbootstrap</button>

  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">New message</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form>
            <div class="form-group">
              <label for="recipient-name" class="col-form-label">Recipient:</label>
              <input type="text" class="form-control" id="recipient-name">
            </div>
            <div class="form-group">
              <label for="message-text" class="col-form-label">Message:</label>
              <textarea class="form-control" id="message-text"></textarea>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Send message</button>
        </div>
      </div>
    </div>
  </div>
</main>
</div>
</div>



<script type="text/javascript" src="<?php echo BASE_URL; ?>ajax/product.js"></script>
