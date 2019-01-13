$('document').ready(function(){
  $.ajaxSetup({
      headers : {
          'CsrfToken': $('meta[name="csrf-token"]').attr('content')
      }
  });
    // save the picture temporarily
    $('#material_picture').on('change', function(){
        var house_picture = $("#material_picture").prop("files")[0];
        $('img#display_').fadeIn("fast").attr('src',URL.createObjectURL(event.target.files[0]));
    });
});
