<?php
function escape($string){
	return trim(filter_input(INPUT_POST,$string, FILTER_SANITIZE_STRING));
	//return htmlentities($string, ENT_QUOTES, 'UTF-8');
}

function sanitize($input, $type){
	if($type == "int"){

		$input_filter = str_replace(['~',"\\",'/',':','*','?','<>','|','=','~','+','^','(',')'],'',$input);
		$input_sanitized = filter_var($input_filter, FILTER_VALIDATE_INT);
		return trim($input_sanitized);

	}elseif($type == 'string'){

		$input_filter = str_replace(['~',"\\",'/',':','*','?','<>','|','=','~','+','^','(',')'],'',$input);
		$input_sanitized = filter_var($input_filter, FILTER_SANITIZE_STRING);
		return trim($input_sanitized);

	}elseif($type == 'float'){

		$input_filter = str_replace(['~',"\\",'/',':','*','?','<>','|','=','~','+','^','(',')'],'',$input);
        $input_sanitized = filter_var($input_filter, FILTER_VALIDATE_FLOAT);
		return trim($input_sanitized);

	}
}
