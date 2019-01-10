<?php
/*
 * USESD FOR SECURING/ENCRYPTING PASSWORDS
 * Author: DAVID DANIEL
 * Last Edited: 27/04/2017
 * STILL "To Do"
*/

class Hash {

	/*
	 * This function creates a hashed password
	 * Parameters = $string(Sting), $salt(string)
	 * Return type = String
	*/
	public static function make($string, $salt = ''){
		return hash('sha256', $string . $salt);
	}

	/*
	 * This function creates a salt value
	 * Parameters = $lenght(Sting), 
	 * Return type = special chars
	*/
	public static function salt($length){		
		if(function_exists('mcrypt_create_iv')){
			return mcrypt_create_iv($length);
		}else{
			return openssl_random_pseudo_bytes($length);
		}
	}

	/*
	 * This function makes a password unique to itself
	 * Parameters = none
	 * Return type = String
	*/
	public static function unique(){
		return self::make(uniqid());
	}
}