//on click of the proceed to checkout button
$('body').on('click', '#proceed_to_checkout', function(){
    //check if the final_balance is available.
    if($('#total_').val() == 0){
        swal("NOTICE", "Please select shipping method", "warning");
    }else{
        window.location.href = "?pg=checkout";
    }
});

$('.shipping_method').on('change', function(){
    //let nameProduct = $(this).parent().parent().parent().find('.block2-name').html();
    let id = $(this).attr('data-id');
    $.ajax({

        type: 'POST',

        dataType: 'json',

        url:  'controller/shippment_option.php',

        data: {id:id},

        success: function(response){
            if(response.response == 'OK'){
                $('#total_price_').html(formatMoney(response.total));
                $('#total_').val(response.total);
            }else{
                console.log(response);
            }
        }
    })
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
