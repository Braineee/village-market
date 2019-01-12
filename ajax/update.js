$('document').ready(function(){
    var input_err = false;
    $.ajaxSetup({
        headers : {
            'CsrfToken': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('form[name="update_details"]').on('submit', function(e){
      e.preventDefault();
      //verify the inputes
      if(
        $('#firstname').val() == "" ||
        $('#lastname').val() == "" ||
        $('#phone').val() == "" ||
        $('#email').val() == "" ||
        $('#state').val() == "" ||
        $('#address').val() == ""
      ){
        input_err = true;
        error_alert('Please enter all required details to update your account');
      }else{
        input_err = false;
      }

      //there are no error
      if(input_err == false){
        form = $(this).serialize();
        $.ajax({
            method: 'POST',
            url: 'controller/update_account.php',
            data: form,
            cache:false,
            beforeSend: function(){
                $("#error").fadeOut();
                $("#update_details").html('<img src="assets/img/loader.gif">&ensp;Please wait...');
                $("#update_details").attr("disabled", true);
            },
            success: function(response){
                if(response.response == 'updated'){
                    //$("#update_details").html('<img src="assets/img/loader.gif">&ensp;Sign in...');
                    $("#update_details").attr("disabled", true);
                    window.location.href = '?pg=account-details';
                }else{
                    $("#error").fadeIn(1000,function(){
                      error_alert(response.response);
                      $("#update_details").html('UPDATE DETAILS');
                      $("#update_details").attr("disabled", false);
                    });
                }
            }
        });
      }
    });

    $('form[name="change_password"]').on('submit', function(e){
      e.preventDefault();
      //verify the inputes
      if(
        $('#password').val() == "" ||
        $('#new_password').val() == "" ||
        $('#con_password').val() == ""
      ){
        input_err = true;
        error_alert('Please enter all required details to update your password');
      }else{
        input_err = false;
      }

      //there are no error
      if(input_err == false){
        form_ = $(this).serialize();
        console.log(form_);
        $.ajax({
            method: 'POST',
            url: 'controller/update_password.php',
            data: form_,
            cache:false,
            beforeSend: function(){
                $("#error").fadeOut();
                $("#change_password").html('<img src="assets/img/loader.gif">&ensp;Please wait...');
                $("#change_password").attr("disabled", true);
            },
            success: function(response){
                if(response.response == 'updated'){
                    //$("#change_password").html('<img src="assets/img/loader.gif">&ensp;Sign in...');
                    $("#change_password").attr("disabled", true);
                    window.location.href = '?pg=account-details';
                }else{
                    $("#error").fadeIn(1000,function(){
                      error_alert(response.response);
                      $("#change_password").html('UPDATE DETAILS');
                      $("#change_password").attr("disabled", false);
                    });
                }
            }
        });
      }
    });

    function error_alert(value){
      $('#error').html(`<div class="alert alert-danger" role="alert"><strong><i class="fa fa-exclamation-triangle"></i></strong>&ensp;${value}</div>`);
    }
});
