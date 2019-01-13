$.ajaxSetup({
    headers : {
        'CsrfToken': $('meta[name="csrf-token"]').attr('content')
    }
});

$('document').ready(function(){

    //generate the captcha
    generate_captcha();

    // check the email
    $('#email').on('blur', function(){
        var email_ = $('#email').val();
        if(email_ == ""){
            $('.wrong-email').html('Please enter your email address');
            $('#get_password').attr("disabled", true);
        }else{
            $('.wrong-email').html('');
            $('#get_password').attr("disabled", false);
        }
    });

    //check the password
    $('#number').on('blur', function(){
        var number_ = $('#number').val();
        if(number_ == ""){
            $('.wrong-password').html('Please enter the code below');
            $('#get_password').attr("disabled", true);
        }else{
            $('.wrong-password').html('');
            $('#get_password').attr("disabled", false);
        }
    });




    $( "form" ).submit(function( e ) {
        e.preventDefault();
        //get the required values
        var email_ = $('#email').val();
        var number_ = $('#number').val();

        // repeat the check
        if(email_ == "" || number_ == ""){
            if(email_ == ""){
                $('.wrong-email').html('Please enter your email address');
                $('#get_password').attr("disabled", true);
            }else if(number_ == ""){
                $('.wrong-password').html('Please enter the code below');

            }
        }else{
            $('#get_password').attr("disabled", false);

            //check if the email is valid
            if ( email_.indexOf('@') > -1 && email_.indexOf('.') > -1 ){
                confirm_reset();
            }else{
                $('.wrong-email').html('Please enter a valid email');
            }
        }
    });


    // confirm the login details
    function confirm_reset(){
        var email_ = $('#email').val();
        var number_ = $('#number').val();
        var token = $('meta[name="csrf-token"]').attr('content');
        var form_token = $('#form_token').val();

        var form_data = new FormData();
        form_data.append("crsf_token",token);
        form_data.append("form_token",form_token);
        form_data.append("email",email_);
        form_data.append("number",number_);

        $.ajax({
            type: 'POST',
            url: 'controller/login/reset.php',
            data: form_data,
            datatype:'script',
            cache:false,
            contentType:false,
            processData:false,
            beforeSend: function(){
                $("#message").fadeOut();
                $("#get_password").html('<img src="assets/img/loader.gif">&ensp;Please wait...');
                $("#get_password").attr("disabled", true);
            },
            success: function(response){
                //alert(response);
                var msg = JSON.parse(response);
                if(msg.response == 'true'){
                    $("#message").fadeIn(1000,function(){
                        $("#get_password").html('RESET PASSWORD');
                        $("#get_password").attr("disabled", false);
                        $("#message").html('<div class="alert alert-success"><strong><i class="fa fa-check"></i></strong>&ensp; A password reset token was sent to your email, please check your mail.</div>');
                    });
                }else{
                    $("#message").fadeIn(1000,function(){
                        $("#message").html('<div class="alert alert-danger" role="alert"><strong><i class="fa fa-exclamation-triangle"></i></strong>&ensp;'+ msg.response +'</div>');
                        $("#get_password").html('RESET PASSWORD');
                        $("#get_password").attr("disabled", false);
                    });
                }
            }
        });
    }

    function generate_captcha(){
        $.ajax({
            type: 'POST',
            url: 'controller/login/generate_captcha.php',
            success: function(response){
                response == 1 ? show_captcha() : console.log(response);
                function show_captcha(){
                    $('#captcha').html('<img src="controller/login/captcha/out.jpg" width="50%" />');
                }
            },
            error: function(err){
                console.log(err);
            }
        });
    }
});
