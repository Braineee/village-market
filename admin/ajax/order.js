$('document').ready(function(){
    var input_err = false;
    $.ajaxSetup({
        headers : {
            'CsrfToken': $('meta[name="csrf-token"]').attr('content')
        }
    });

    //get the list of products
    get_orders();

    function get_orders(){
      $.ajax({
          type: 'POST',
          dataType: 'json',
          url:  'controller/GetOrders.php'
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
                  <td>${ value.order_firstname} ${value.order_lastname}</td>
                  <td>${ value.order_no_of_item}</td>
                  <td>&#8358;${formatMoney(value.order_total_amount)}</td>`;
      if(value.order_status == 'Pending'){
        row+=     `<td><span class="label-warning">${ value.order_status }</span></td>`;
      }else if(value.order_status == 'Paid'){
        row+=     `<td><span class="label-primary">${ value.order_status }</span></td>`;
      }else if(value.order_status == 'Completed'){
        row+=     `<td><span class="label-success">${ value.order_status }</span></td>`;
      }else if(value.order_status == 'Cancelled'){
        row+=     `<td><span class="label-danger">${ value.order_status }</span></td>`;
      }
        row+=    `<td>${ value.order_date_placed}</td>
                  <td><a href="?pg=view-order&order=${ value.id }" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i></a></td>
              </tr>`;
      });

      $("#order-table").html(row);
    }


    //flag out of stock
    $('body').on('click', '#paid', function(){
      let id = $(this).attr('data-id');
      swal({
            title: 'Confirm',
            text: "Do you really want to flag this order as paid",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, Flag this order!',
            showLoaderOnConfirm: true
          }, function(){
            $.ajax({
              type: 'POST',
              url: 'controller/PaidOrder.php',
              dataType: 'json',
              data: {id: id},
              beforeSend: function(){
                $("#paid").html('Please wait...');
                $("#paid").attr("disabled", true);
              },
              success: function(response){
                if(response == 'paid'){
                  window.location.href=`?pg=view-order&order=${id}`;
                }else{
                  toastr.error('Order was not flagged','Failed!' ,{timeOut:4000});
                  $("#paid").html('PAID');
                  $("#paid").attr("disabled", false);
                }
              }
            });
        });
    });

    //flag as Completed
    $('body').on('click', '#completed', function(){
      let id = $(this).attr('data-id');
      swal({
            title: 'Confirm',
            text: "Do you really want to flag this order as completed",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, Flag this order!',
            showLoaderOnConfirm: true
          }, function(){
            $.ajax({
              type: 'POST',
              url: 'controller/CompletedOrder.php',
              dataType: 'json',
              data: {id: id},
              beforeSend: function(){
                $("#completed").html('Please wait...');
                $("#completed").attr("disabled", true);
              },
              success: function(response){
                if(response == 'completed'){
                  window.location.href=`?pg=view-order&order=${id}`;
                }else{
                  toastr.error('Order was not flagged','Failed!' ,{timeOut:4000});
                  $("#completed").html('COMPLETE');
                  $("#completed").attr("disabled", false);
                }
              }
            });
        });
    });

    //flag as cancled
    $('body').on('click', '#cancled', function(){
      let id = $(this).attr('data-id');
      swal({
            title: 'Confirm',
            text: "Do you really cancle this order?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, cancle this order!',
            showLoaderOnConfirm: true
          }, function(){
            $.ajax({
              type: 'POST',
              url: 'controller/CancleOrder.php',
              dataType: 'json',
              data: {id: id},
              beforeSend: function(){
                $("#cancled").html('Please wait...');
                $("#cancled").attr("disabled", true);
              },
              success: function(response){
                if(response == 'cancled'){
                  window.location.href=`?pg=view-order&order=${id}`;
                }else{
                  toastr.error('Order was not flagged','Failed!' ,{timeOut:4000});
                  $("#cancled").html('CANCLE');
                  $("#cancled").attr("disabled", false);
                }
              }
            });
        });
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
