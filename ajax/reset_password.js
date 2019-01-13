$('document').ready(function(){
  $.ajaxSetup({
      headers : {
          'CsrfToken': $('meta[name="csrf-token"]').attr('content')
      }
  });
    //check the password
    $('#password').on('change', function(){
        let password_ = $('#password').val();
        if(password_ == ""){
            $('.wrong-password').html('Please enter your password');
            $('#change_password').attr("disabled", true);
        }else{
            $('.wrong-password').html('');
            $('#change_password').attr("disabled", false);
        }
    });

    //check the confirm password
    $('#confirm_password').on('change', function(){
        let con_password_ = $('#confirm_password').val();
        if(con_password_ == ""){
            $('.wrong-confirm_password').html('Please re-enter your password again');
            $('#change_password').attr("disabled", true);
        }else{
            $('.wrong-confirm_password').html('');
            $('#change_password').attr("disabled", false);
        }
    });

    // reset the password
    $( "form" ).submit(function( e ) {
        e.preventDefault();
        //get the required values
        let token = $('meta[name="csrf-token"]').attr('content');
        let form_token = $('#form_token').val();
        let password_ = $('#password').val();
        let con_password_ = $('#confirm_password').val();
        const password_reset_token_ = $('#password_reset_token').val();

        // repeat the check
        if(password_ == "" || con_password_ == ""){
            if(password_ == ""){
                $('.wrong-password').html('Please enter your new password');
                $('#change_password').attr("disabled", true);
            }else if(con_password_ == ""){
                $('.wrong-password').html('Please re-enter your password again');
            }
        }else{
            $('#change_password').attr("disabled", false);

            //check if the new password matches the confirm password
            if(password_ == con_password_){
                change_password();
            }else{
                $("#message").html('<div class="alert alert-danger role="alert"><strong><i class="fa fa-check"></i></strong>&ensp; The password you re-entered does not match the new password.</div>');
            }
        }

        // change the password
        function change_password(){
            var form_data = new FormData();
            form_data.append("crsf_token",token);
            form_data.append("form_token",form_token);
            form_data.append("password",password_);
            form_data.append("confirm_password",con_password_);
            form_data.append("password_reset_token",password_reset_token_);

            $.ajax({
                type: 'POST',
                url: 'controller/login/change_password.php',
                data: form_data,
                datatype:'script',
                cache:false,
                contentType:false,
                processData:false,
                beforeSend: function(){
                    $("#message").fadeOut();
                    $("#change_password").html('<img src="assets/img/loader.gif">&ensp;Please wait...');
                    $("#change_password").attr("disabled", true);
                },
                success: function(response){
                    //alert(response);
                    var msg = JSON.parse(response);
                    if(msg.response == 'updated'){
                        $("#message").fadeIn(1000,function(){
                            $("#change_password").html('<img src="assets/img/loader.gif">&ensp;Redirecting...');
                            $("#change_password").attr("disabled", true);
                            $("#message").html('<div class="alert alert-success"><strong><i class="fa fa-check"></i></strong>&ensp; Your password has been updated successfully, You would be redirected to the login page shortly.</div>');
                            setTimeout(() => { window.location.href = '?pg=login'; }, 5000); // redirect the user to the login page
                        });
                    }else{
                        $("#message").fadeIn(1000,function(){
                            $("#message").html('<div class="alert alert-danger" role="alert"><strong><i class="fa fa-exclamation-triangle"></i></strong>&ensp;'+ msg.response +'</div>');
                            $("#change_password").html('CHANGE PASSWORD');
                            $("#change_password").attr("disabled", false);
                        });
                    }
                }
            });
        }
    });

});
