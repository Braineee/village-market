$('document').ready(function(){
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
          console.log(response);
          if(response.count == 0){
              $('tbody').html('');
              $("#empty").html("<div class='empty'><i class='fas fa-exclamation-triangle'></i>&ensp;NO RECORD FOUND!</div>");
          }else{
            console.log(response.data)
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
                    <button type="button" name="button" data-id="${ value.id }" class="btn btn-info btn-sm"><span data-feather="eye" id="view-product"></span>&nbsp;View</button>
                    <button type="button" name="button" data-id="${ value.id }" class="btn btn-danger btn-sm"><span data-feather="trash" id="delete-product"></span>&nbsp;Delete</button>
                    <button type="button" name="button" data-id="${ value.id }" class="btn btn-warning btn-sm"><span data-feather="flag" id="flag-out-product"></span>&nbsp;Flag as out of stock</button>
                  </td>
              </tr>
              `;
      });
      $("#product-table").html(row);
    }

    //view product


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
});
