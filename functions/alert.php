<?php
function do_alert_swal($title, $message, $type, $location){
    echo '
    <script script type="text/javascript">
        $("document").ready(function(){
            swal({
                title: "'.$title.'",
                text: "'.$message.'",
                type: "'.$type.'",
                showCancelButton: true,
                closeOnConfirm: false,
                showLoaderOnConfirm: true
            }, function () {
                //window.location.href = "?pg='.$location.'";
                swal.hide();
            });
        });
    </script>
    ';
}

function do_alert_info_redirect($title, $message, $location, $type){
    echo '
    <script script type="text/javascript">
        $("document").ready(function(){
            swal({
                title: "'.$title.'",
                text: "'.$message.'",
                type: "'.$type.'",
                showCancelButton: false,
                closeOnConfirm: false,
                showLoaderOnConfirm: true
            }, function () {
                window.location.href = "?pg='.$location.'";
            });
        });
    </script>
    ';
}

function do_alert($message){
    echo '<script>alert('.$message.')</script>';
}