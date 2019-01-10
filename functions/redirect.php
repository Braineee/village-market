<?php
//Redirects the user to a new page using javascript
function redirect($page){
	echo "<script> location.replace('".$page."'); </script>";
}