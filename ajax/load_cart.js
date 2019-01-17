$.ajaxSetup({
    headers : {
        'CsrfToken': $('meta[name="csrf-token"]').attr('content')
    }
});

load_cart();

function load_cart(){
    $.ajax({

        type: 'POST',

        dataType: 'json',

        url:  'controller/get_cart_items.php',

    }).done(function(data){

        //alert(data.count);

        if(data.count == 0){
            $("#show_quantity").html(`No item`);
            $("#list-cart-item").html("");
            $("#total_price").html(0);
            $("#sub_total").val(0);
        }else{
            //alert('manage_row');
            manage_Row(data.data);
            $("#total_price").html(data.total);
            $("#sub_total").val(data.total);
            if(data.count > 1){
                $("#show_quantity").html(`${data.count} items`);
            }else{
                $("#show_quantity").html(`${data.count} item`);
            }


        }

    });
}


function manage_Row(data){
    let rows = '';
    rows += `<tr class="table-head">

                <th class="column-1"></th>
                <th class="column-2">Product</th>
                <th class="column-3">Price</th>
                <th class="column-4 p-l-70">Quantity</th>
                <th class="column-1">Total</th>
                <th class="column-1"></th>
                <th class="column-5"></th>
            </tr>`;
    $.each(data, function(key, value){

        rows += `<tr class="table-row">
                    <td class="column-1">
                        <div class="cart-img-product b-rad-4 o-f-hidden">
                            <img src="images/product_picture/${value.picture}" width="920px" alt="IMG-PRODUCT">
                        </div>
                    </td>
                    <td class="column-2">${value.Item_name}</td>
                    <td class="column-3">&#8358;${value.Price}</td>
                    <td class="column-5" align="center">
                        <div class="flex-w bo5 of-hidden w-size17">
                            <button class="btn-num-product-down color1 flex-c-m size7 bg8 eff2">
                                <i class="fs-12 fa fa-minus" aria-hidden="true"></i>
                            </button>

                            <input class="size8 m-text18 t-center num-product" type="number" name="num-product1" value="${value.Quantity}" id="${value.ID}product_quantity" data-name="${value.Item_name}">

                            <button class="btn-num-product-up color1 flex-c-m size7 bg8 eff2">
                                <i class="fs-12 fa fa-plus" aria-hidden="true"></i>
                            </button>
                        </div>
                    </td>
                    <td class="column-5" style="padding-left:40px; padding-right:10px;">&#8358;${value.totalcost}</td>
                    <td class="column-3">
                        <button class="flex-c-m sizefull bg1 bo-rad-23 hov1 s-text1 trans-0-4" id="update_cart" data-id="${value.ID}" style="padding:5px;">
                            <small>Update </small>
                        </button>
                    </td>
                    <td class="column-2" style="padding-left:0px; padding-right:80px;">
                        <strong><button type="button" class="close" id="remove_cart" data-id="${value.ID}" data-toggle="tooltip" data-placement="bottom" title="Remove this item">
                            <span aria-hidden="true">&times;</span>
                        </button></strong>
                    </td>
                </tr>`;
    });

    $("#list-cart-item").html(rows);
}


//update cart
$('body').on('click','#update_cart', function(){
    let skuProduct = $(this).attr('data-id');
    let quantityProduct = $(`#${skuProduct}product_quantity`).val();
    let nameProduct = $(`#${skuProduct}product_quantity`).attr('data-name');
    //console.log(`product_id:${skuProduct}, quantity:${quantityProduct}, name:${nameProduct}`);

    $.ajax({

        type: 'POST',

        dataType: 'json',

        url:  'controller/addtocart.php',

        data: {name: nameProduct, id: skuProduct, quantity: quantityProduct},
        beforeSend: function(){
          $("#update_cart").html('<small>please wait...</small>');
          $("#update_cart").attr("disabled", true);
        },
        success: function(response){
            if(response == 'OK'){
                get_cart_count();
                load_cart();
                $("#update_cart").html('<small>Update </small>');
                $("#update_cart").attr("disabled", false);
                swal(nameProduct, quantityProduct+" of "+ nameProduct +" has been added to cart !", "success");
            }else if(response == 'already_exist'){
                get_cart_count();
                $("#update_cart").html('<small>Update </small>');
                $("#update_cart").attr("disabled", false);
                swal(nameProduct, "Has already been added to cart", "info");
            }
        }
    })
});



//remove cart
$('body').on('click','#remove_cart', function(){
    let skuProduct = $(this).attr('data-id');
    let nameProduct = $(`#${skuProduct}product_quantity`).attr('data-name');
    //console.log(`product_id:${skuProduct}, quantity:${quantityProduct}, name:${nameProduct}`);

    $.ajax({

        type: 'POST',

        dataType: 'json',

        url:  'controller/removefromcart.php',

        data: {id: skuProduct},

        success: function(response){
            if(response == 'OK'){
                get_cart_count();
                load_cart();
                swal(nameProduct, `${nameProduct} has been added removed from cart !`, "success");
            }else if(response == 'could_not_find_item'){
                get_cart_count();
                load_cart();
                swal(nameProduct, "was not found", "info");
            }
        }
    })
});
