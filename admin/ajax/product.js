$('document').ready(function(){
    var input_err = false;
    $.ajaxSetup({
        headers : {
            'CsrfToken': $('meta[name="csrf-token"]').attr('content')
        }
    });

    //get the list of products
    get_products();

    function get_products(){
      $.ajax({
          type: 'POST',
          dataType: 'json',
          url:  'controller/GetProducts.php'
      }).done(function(response){
          if(response.count == 0){
              $('tbody').html('');
              $("#empty").html("<div class='empty'><i class='fas fa-exclamation-triangle'></i>&ensp;NO RECORD FOUND!</div>");
          }else{
              $("#empty").html('');
              manageRow(response.data);
          }
      });
    }

    function manageRow(data){
      let i = 1;
      let row = ``;
      $.each(data, function(key, value){
        row+= `<tr>
                  <td>${ i++ }</td>
                  <td>#${ value.id }</td>
                  <td>${ value.product_name }</td>
                  <td>${ value.product_category }</td>
                  <td>&#8358;${ formatMoney(value.product_price) }</td>
                  <td>
                    <button type="button" name="button" data-id="${ value.id }" class="btn btn-outline-info btn-sm" data-toggle="modal" data-target="#view-product-modal" id="view-product"><i class="fa fa-eye"></i></button>
                    <button type="button" name="button" data-id="${ value.id }" class="btn btn-outline-success btn-sm" id="edit-product"><i class="fa fa-edit"></i></button>
                    <button type="button" name="button" data-id="${ value.id }" class="btn btn-outline-danger btn-sm" id="delete-product"><i class="fa fa-trash"></i></button>
                    <button type="button" name="button" data-id="${ value.id }" class="btn btn-outline-warning btn-sm" id="flag-out-product"><i class="fa fa-flag"></i></button>
                  </td>
              </tr>
              `;
      });
      $("#product-table").html(row);
    }

    //view product
    $('body').on('click','#view-product', function(){
      $.ajax({
        type: 'POST',
        url: 'controller/GetProduct.php',
        dataType: 'json',
        data:{id: $(this).attr('data-id')}
      }).done(function(response){
        // fillin the data
        if(response.count > 0){
          let product_data = response.data[0];
          $('#product_desc').html('');
          $('#product_name').val(product_data.product_name);
          $('#product_price').val(formatMoney(product_data.product_price));
          $('#product_category').val(product_data.product_category);
          $('#product_desc').html(product_data.product_description);
          $('#product-title').html(product_data.product_name);
          $('#display_').attr('src',`../images/product_picture/${product_data.product_picture}`);
        }
      });
    });


    //delete product
    $('body').on('click','#delete-product', function(){
      var id = $(this).attr('data-id');
      swal({
            title: 'Confirm Delete ',
            text: "Do you really want to delete this product permanently?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, Delete this product!',
            showLoaderOnConfirm: true
          }, function(){
            $.ajax({
              type: 'POST',
              url: 'controller/DeleteProduct.php',
              dataType: 'json',
              data: {id: id},
              success: function(response){
                alert(response);
                if(response == 'deleted'){
                  toastr.success('Product has been deleted permanently','Deleted!' ,{timeOut:4000});
                  //swal("Deleted!", "Product has been deleted permanently", "success");
                  get_products();
                }else{
                  toastr.error('Product was not deleted','Failed!' ,{timeOut:4000});
                }
              }
            });
        });
    });


    //create product
    $('#create-product_').on('click', function(e){
      e.preventDefault();
      //verify the inputes
      if(
        $('#product_name').val() == "" ||
        $('#product_price').val() == "" ||
        $('#product_category').val() == "" ||
        $('#product_desc').val() == "" ||
        $('#product_image').val() == ""
      ){
        input_err = true;
        error_alert('Please enter all required details needed to create this product.');
      }else{
        input_err = false;
      }

      if(input_err == false){
        var formData = new FormData($('form[name="create-product-form"]').submit());
        $.ajax({
          type: 'POST',
          url: 'controller/CreateProduct.php',
          data:formData,
          datatype:'script',
          cache:false,
          contentType: false,
          processData: false,
          beforeSend: function(){
            //$("#error").fadeOut();
            $("#create-product").html('Creating...');
            $("#create-product").attr("disabled", true);
          },
          success: function(data) {

          },
          error: function(data) {

          }
          });
      }
    });


    // function money formart
    function formatMoney(n, c, d, t) {
        var c = isNaN(c = Math.abs(c)) ? 2 : c,
            d = d == undefined ? "." : d,
            t = t == undefined ? "," : t,
            s = n < 0 ? "-" : "",
            i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
            j = (j = i.length) > 3 ? j % 3 : 0;

        return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
    };

    // error function
    function error_alert(value){
      $('#error').html(`<div class="alert alert-danger" role="alert"><strong><i class="fa fa-exclamation-triangle"></i></strong>&ensp;${value}</div>`);
    }
});
