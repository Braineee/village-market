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
          url:  'controller/GetCustomers.php'
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
                  <td>${ value.customer_firstname} ${value.customer_lastname}</td>
                  <td>${ value.customer_phone}</td>
                  <td>${ value.customer_email}</td>
                  <td>${ value.customer_username}</td>
                  <td>${ value.customer_state}</td>
                  <td>${ value.customer_address}</td>
              </tr>`;
      });

      $("#customer-table").html(row);
    }
});
