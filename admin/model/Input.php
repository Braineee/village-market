<?php
/*
 * USESD FOR STRUCTURING FORM INPUTS FOR EITHER _POST OR _GET
 * Author: DAVID DANIEL
 * Last Edited: 27/04/2017
 * STILL "To Do"
*/
class Input{

	/*
	 * This function grabs the forms method type
	 * Parameters = $type(Sting), $
	 * Return type = Boolean
	*/
	public static function exists($type = 'post'){
		switch($type){
			case 'post':
				return (!empty($_POST)) ? true : false;
			break;
			case 'get':
				return (!empty($_GET)) ? true : false;
			break;
			default:
				return false;
			break;
		}
	}

	/*
	 * This function returns a particular form data
	 * Parameters = $item(Sting), $
	 * Return type = String
	*/	
	public static function get($item){
		if(isset($_POST[$item])){
			return $_POST[$item];
		}else if(isset($_GET)){
			return $_GET[$item];
		}
		return '';
	}
}