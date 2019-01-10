<?php
/*
 * USED FOR HANDELING REDIRECTION
 * Author: DAVID DANIEL
 * Last Edited: 27/04/2017
 * STILL "To Do"
*/
class Redirect {
	/*
	 * This function Handles page redirection
	 * Parameters = $location(Sting), $
	 * Return type = none
	*/
	public static function to($location = null){
		if($location){
			if(is_numeric($location)){
				switch($location){
					case 404:
							header('HTTP/1.0 404 Not Found');
							include 'includes/errors/404.php';
							exit();
					break;
				}
			}
			header("Location: ". $location);
			exit();
		}
	}
}