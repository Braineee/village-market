<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Customers</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
      <!--a href="?pg=create_product" class="btn btn-sm btn-success">
        <span data-feather="plus"></span>
        Product
      </a-->
    </div>
  </div>
  <?php
    if(Session::exists('product_created')){
      echo "<div class='alert alert-dismissable alert-success'>
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>

                    <li><i class='fa fa-check'></i>&ensp;<strong>". Session::flash('product_created') . "</strong></li>

            </div>";
    }
  ?>
  <div class="table-responsive">
    <table class="table table-striped table-sm">
      <thead>
        <tr>
          <th>#</th>
          <th>ID</th>
          <th>Name</th>
          <th>Phone</th>
          <th>Email</th>
          <th>Username</th>
          <th>State</th>
          <th>Address</th>
        </tr>
      </thead>
      <tbody id="customer-table">
      <!-- loop the records here -->
      </tbody>
    </table>
  </div>
</main>
</div>
</div>
<script type="text/javascript" src="<?php echo BASE_URL; ?>ajax/customer.js"></script>
