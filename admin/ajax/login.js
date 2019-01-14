$('document').ready(function(){
    $.ajaxSetup({
        headers : {
            'CsrfToken': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // check the email
    $('#email').on('change', function(){
        var email_ = $('#email').val();
        if(email_ == ""){
          error_alert('Please enter your email address');
          $('#login').attr("disabled", true);
        }else{
            $('#login').attr("disabled", false);
        }
    });

    //check the password
    $('#password').on('change', function(){
        var password_ = $('#password').val();
        if(password_ == ""){
          error_alert('Please enter your password');
          $('#login').attr("disabled", true);
        }else{
            $('#login').attr("disabled", false);
        }
    });

    $( "form" ).submit(function( e ) {
        e.preventDefault();

        var email_ = $('#email').val();
        var password_ = $('#password').val();

        if(email_ == "" || password_ == ""){
            if(email_ == ""){
              error_alert('Please enter your email address');
              $('#login').attr("disabled", true);
            }else if(password_ == ""){
              error_alert('Please enter your password');
              $('#login').attr("disabled", true);
            }
        }else{
            $('#login').attr("disabled", false);

            //check if the email is valid
            if ( email_.indexOf('@') > -1 && email_.indexOf('.') > -1 ){
                confirm_login_details();
            }else{
                error_alert('Please enter a valid email');
            }
        }

        // confirm the login details
        function confirm_login_details(){
            form = $("form").serialize();
            $.ajax({
                method: 'POST',
                url: 'controller/login.php',
                data: form,
                cache:false,
                beforeSend: function(){
                    $("#error").fadeOut();
                    $("#login").html('Please wait...');
                    $("#login").attr("disabled", true);
                },
                success: function(response){
                    if(response.response == 'true'){
                        $("#login").html('Sign in...');
                        $("#login").attr("disabled", true);
                        window.location.href = '?pg=dashboard';
                    }else{
                        $("#error").fadeIn(1000,function(){
                          error_alert(response.response);
                          $("#login").html('LOGIN');
                          $("#login").attr("disabled", false);
                        });
                    }
                }
            });
        }

        function error_alert(value){
          $('#error').html(`<div class="alert alert-danger" role="alert"><strong><i class="fa fa-exclamation-triangle"></i></strong>&ensp;${value}</div>`);
        }
    });//ends login
});
