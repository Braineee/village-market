<?php
/*
 * USED FOR HANDLING SESSIONS MANAGEMENT
 * Author: DAVID DANIEL
 * Last Edited: 29/04/2017
 * STILL "To Do"
*/
class Session {
	/*
	 * This function Creates a session
	 * Parameters = $name(Sting), $value(String)
	 * Return type = none
	*/
	public static function put($name, $value){
		return $_SESSION[$name] = $value;
	}

	/*
	 * This function Checks if a session exists
	 * Parameters = $name(Sting),
	 * Return type = boolean
	*/
	public static function exists($name){
		return (isset($_SESSION[$name])) ? true : false;
	}

	/*
	 * This function returns the name of a session
	 * Parameters = $name(Sting),
	 * Return type = string
	*/
	public static function get($name){
		return $_SESSION[$name];
	}

	/*
	 * This function delete a session
	 * Parameters = $name(Sting)
	 * Return type = none
	*/
	public static function delete($name){
		if(self::exists($name)){
			unset($_SESSION[$name]);
		}
	}

	/*
	 * This function is used to desplay temporary message a session
	 * Parameters = $name(Sting), $message(String)
	 * Return type = string
	*/
	public static function flash($name, $message = ''){
		if(self::exists($name)){
			$session = self::get($name);
			self::delete($name);
			return $session;
		}else{
			self::put($name, $message);
		}
	}
}