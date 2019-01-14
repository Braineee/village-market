<?php
	class Cookie{
		/*
		 * This function check if the user session exists
		 * Parameters = $name(string)
		 * Return type = boolean
		*/
		public static function exists($name){
			return (isset($_COOKIE[$name])) ? true : 	false; 
		}

		/*
		 * This function gets a user session 
		 * Parameters = $name(string)
		 * Return type = boolean
		*/
		public static function get($name){
			return $_COOKIE[$name];
		}

		/*
		 * This function creates a cookie
		 * Parameters = $name(string), $value(string), $expiry(Integer)
		 * Return type = boolean
		*/
		public static function put($name, $value, $expiry){
			if (setcookie($name, $value, time()+$expiry, '/')){
				return true;
			}
			return false;
		}

		/*
		 * This function deletes a user cookie
		 * Parameters = $name(string)
		 * Return type = boolean
		*/
		public static function delete($name){
			if(isset($value)){
				Self::put($name, $value, time()-1);
			}
		}
	}
?>