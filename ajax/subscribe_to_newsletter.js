$('document').ready(function(){
  $.ajaxSetup({
      headers : {
          'CsrfToken': $('meta[name="csrf-token"]').attr('content')
      }
  });

    // reset the password
    $( 'form[name="subscribe"]').submit(function( e ) {
        e.preventDefault();
        alert('it got here');
        if($('.sub-email').val() == ''){
          $(".subscribe_message").fadeIn(1000,function(){
              $(".subscribe_message").html('<div class="alert alert-danger" role="alert"><strong><i class="fa fa-exclamation-triangle"></i></strong>&ensp;Please enter your email</div>');
          });
        }else{
          email_ = $('.sub-email').val();
          //check if the email is valid
          if ( email_.indexOf('@') > -1 && email_.indexOf('.') > -1 ){
              subscribe();
          }else{
            $(".subscribe_message").html('<div class="alert alert-danger" role="alert"><strong><i class="fa fa-exclamation-triangle"></i></strong>&ensp;Please enter a valid email</div>');
          }
        }

        function subscribe(){
            var form_data = $('form[name="subscribe"]').serialize();
            $.ajax({
                type: 'POST',
                url: 'controller/SubscribeToNewsLetter.php',
                data: form_data,
                datatype:'script',
                cache:false,
                contentType:false,
                processData:false,
                beforeSend: function(){
                    $(".subscribe_message").fadeOut();
                    $(".subscribe").html('Subscribing...');
                    $(".subscribe").attr("disabled", true);
                },
                success: function(response){
                    if(response.success){
                        $(".subscribe_message").fadeIn(1000,function(){
                            $(".subscribe").html('subscribe');
                            $(".subscribe").attr("disabled", true);
                            $(".subscribe_message").html('<div class="alert alert-success"><strong><i class="fa fa-check"></i></strong>&ensp; You have successfully subscribed to our news letter.</div>');
                        });
                    }else if(response.error){
                        $(".subscribe_message").fadeIn(1000,function(){
                            $(".subscribe_message").html('<div class="alert alert-danger" role="alert"><strong><i class="fa fa-exclamation-triangle"></i></strong>&ensp;'+ response.message +'</div>');
                            $(".subscribe").html('subscribe');
                            $(".subscribe").attr("disabled", false);
                        });
                    }else{
                        $(".subscribe_message").fadeIn(1000,function(){
                            $(".subscribe_message").html('<div class="alert alert-danger" role="alert"><strong><i class="fa fa-exclamation-triangle"></i></strong>&ensp; An error occoured</div>');
                            $(".subscribe").html('subscribe');
                            $(".subscribe").attr("disabled", false);
                        });
                    }
                }
            });
        }
    });

});
