$('document').ready(function(){
  $.ajaxSetup({
      headers : {
          'CsrfToken': $('meta[name="csrf-token"]').attr('content')
      }
  });
    // save the picture temporarily
    $('#product_image').on('change', function(){
        var house_picture = $("#product_image").prop("files")[0];
        $('img#display_').fadeIn("fast").attr('src',URL.createObjectURL(event.target.files[0]));
    });
});
