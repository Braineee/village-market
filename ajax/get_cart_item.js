$.ajaxSetup({
    headers : {
        'CsrfToken': $('meta[name="csrf-token"]').attr('content')
    }
});


$('#get_cart_item').on('click', function(){
    $.ajax({

        type: 'POST',

        dataType: 'json',

        url:  'controller/get_cart_items.php',

    }).done(function(data){

        //alert(data.data);

        if(data.count == 0){


        }else{

            manageRow(data.data);
            $("#totalprice").html(data.total);
            $("#totalprice2").html(data.total);
        }

    });
});

function manageRow(data){
    let rows = '';
    $.each(data, function(key, value){

        rows += `<li class="header-cart-item">
                    <div class="header-cart-item-img">
                        <img src="images/product_picture/${value.picture}" width="320px" height="320px" alt="IMG">
                    </div>

                    <div class="header-cart-item-txt">
                        <a href="#" class="header-cart-item-name">
                            ${value.Item_name}
                        </a>

                        <span class="header-cart-item-info">
                            ${value.Quantity} x &#8358;${value.Price}
                        </span>
                    </div>
                </li>`
    });

    $("#list-item").html(rows);
    $("#list-item2").html(rows);
}
