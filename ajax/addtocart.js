$.ajaxSetup({
    headers : {
        'CsrfToken': $('meta[name="csrf-token"]').attr('content')
    }
});

get_cart_count();


// add to cart
$('.add_cartt').on('click', function(){
    //let nameProduct = $(this).parent().parent().parent().find('.block2-name').html();
    let nameProduct = $(this).attr('data-name');
    let skuProduct = $(this).attr('data-id');
    let quantityProduct = $(this).attr('data-quantity');
    $.ajax({

        type: 'POST',

        dataType: 'json',

        url:  'controller/addtocart.php',

        data: {name: nameProduct, id: skuProduct, quantity: quantityProduct},
        beforeSend: function(){
          $(".add_cartt").html('please wait...');
          $(".add_cartt").attr("disabled", true);
        },
        success: function(response){
            if(response == 'OK'){
                get_cart_count();
                $(".add_cartt").html('Add to Cart');
                $(".add_cartt").attr("disabled", false);
                swal(nameProduct, quantityProduct+" of "+ nameProduct +" has been added to cart !", "success");
            }else if(response == 'already_exist'){
                get_cart_count();
                $(".add_cartt").html('Add to Cart');
                $(".add_cartt").attr("disabled", false);
                swal(nameProduct, "Has already been added to cart", "info");
            }
        }
    })
});


//add quantity
$('#add_quantity').on('click', function(){
    let nameProduct = $('#quantityProduct').attr('data-name');
    let skuProduct = $('#quantityProduct').attr('data-id');
    let quantityProduct = $('#quantityProduct').val();

    /*alert(nameProduct);
    alert(skuProduct);
    alert(quantityProduct);*/
    $.ajax({

        type: 'POST',

        dataType: 'json',

        url:  'controller/addtocart.php',

        data: {name: nameProduct, id: skuProduct, quantity: quantityProduct},
        beforeSend: function(){
          $("#add_quantity").html('please wait...');
          $("#add_quantity").attr("disabled", true);
        },
        success: function(response){
            if(response == 'OK'){
                get_cart_count();
                $("#add_quantity").html('Add to Cart');
                $("#add_quantity").attr("disabled", false);
                swal(nameProduct, quantityProduct+" of "+ nameProduct +" has been added to cart !", "success");
            }else if(response == 'already_exist'){
                get_cart_count();
                $("#add_quantity").html('Add to Cart');
                $("#add_quantity").attr("disabled", false);
                swal(nameProduct, "Has already been added to cart", "info");
            }
        }
    })
});



function get_cart_count(){
    $.ajax({

        type: 'POST',

        dataType: 'json',

        url:  'controller/get_cart.php',

        success: function(response){
            $("#cart_count").html(response);
            $("#cart_count2").html(response);
        }
    })
}
