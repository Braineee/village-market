<?php
/*
 * USED FOR HANDELING TOKEN GENERATTION AND VALIDATION
 * Author: DAVID DANIEL
 * Last Edited: 29/04/2017
 * STILL "To Do"
*/
class Token {

	/*
	 * This function Generates a token
	 * Parameters = none
	 * Return type = string
	*/
	public static function generate(){
		return Session::put(Config::get('session/token_name'), md5(uniqid()));
	}


	/*
	 * This function Generates a token
	 * Parameters = none
	 * Return type = string
	*/
	public static function generate_unique($value){

		return 'this'.$value."r@T";

	}


	/*
	 * This function validates a token
	 * Parameters = $token(Sting),
	 * Return type = boolean
	*/
	public static function check($token){
		$tokenName = Config::get('session/token_name');

		if (Session::exists($tokenName) && $token === Session::get($tokenName)){
			Session::delete($tokenName);
			return true;
		}

		return false;
	}


}
