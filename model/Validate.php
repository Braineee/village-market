<?php
/*
 * USED FOR POSTING AND RETRIVAL OF USER DATA TO THE DATA BASE (NB: this method class can be substituted for any othe class)
 * Author: DAVID DANIEL
 * Last Edited: 29/04/2017
 * STILL "To Do"
*/
class Validate{
	private $_passed = false,
			$_errors = array(),
			$_db = null;

	/*
	 * This is the pseudo construct function for the Validate class
	 * Parameters = none
	 * Return type = string
	*/
	public function __construct(){
		//$this->_db = DB::getInstance();
		$this->_db = DB::getInstance();
	}

	/*
	 * This function is used to validate a user input from the form on submittion
	 * Parameters = $source(string), $items(array)
	 * Return type = none
	*/
	public function check($source, $items = array()){
		foreach($items as $item => $rules){
			foreach($rules as $rule => $rule_value){

				$value = $source[$item];
				$item = escape($item);

				if($rule === 'required' && (empty($value) || $value == '')){
					$this->addError("{$item} is required");
				}else if(!empty($value)){
					switch($rule){
						case 'min':
							if(strlen($value) < $rule_value){
								$this->addError("{$item} must be a minimum of {$rule_value} characters.");
							}
						break;
						case 'max':
							if(strlen($value) > $rule_value){
								$this->addError("{$item} must be a maximum of {$rule_value} characters.");
							}
						break;
						case 'matches':
							if($value != $source[$rule_value]){
								$this->addError("{$rule_value} must match {$item}");
							}
						break;
						case 'unique':
							$check = $this->_db->get($rule_value, array($item, '=', $value ));
							if ($check->count()){
								$this->addError("{$item} already exists.");
							}
						break;
					}
				}
			}
		}

		if (!$this->errors() == NULL){
			$this->_passed = true;
		}
		return $this;
	}

	/*
	 * This function stores the list of errors generated during validation of the submited form
	 * Parameters = $error(string)
	 * Return type = none
	*/
	private function addError($error){
		$this->_errors[] = $error;
	}

    /*
	 * This function returns the errors generated
	 * Parameters = none
	 * Return type = object
	*/
    public function errors(){
    	return $this->_errors;
    }

    /*
	 * This function checks and returns a boolean if the validation was successful
	 * Parameters = none
	 * Return type = boolean
	*/
    public function passed(){
    	return $this->_passed;
    }
}
