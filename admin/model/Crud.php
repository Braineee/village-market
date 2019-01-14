<?php
/*
 * USED FOR POSTING AND RETRIVAL OF CRUD DATA TO THE DATA BASE (NB: this method class can be substituted for any othe class)
 * Author: DAVID DANIEL
 * Last Edited: 30/04/2017
 * STILL "To Do"
*/
class Crud {
	private $_db,
			$_sessionName,
			$_cookieName;

	/*
	 * This is the pseudo construct function for the Crud class
	 * Parameters = none
	 * Return type = string
	*/
	public function __construct(){
        $this->_db = DB::getInstance();
		$this->_sessionName = Config::get('session/session_name');
		$this->_cookieName = Config::get('remember/cookies_name');
	}
    
    /*
	 * This function creates a new table data in the database
	 * Parameters = $fields(array))
	 * Return type = none
	*/
	public function create($tablename, $fields = array()){
		if (!$this->_db->insert($tablename, $fields)) {
			//$this->_db->error_message();
			throw new Exception('There was a problem creating data');
		}
    }
    

    /*
	 * This function updates a table data in the database
	 * Parameters = $fields(array), $id(integer)
	 * Return type = none
    */
	public function update($tablename, $colMatch, $id = null, $fields = array()){
		if(!$this->_db->update($tablename, $colMatch, $id, $fields)){
			throw new Exception('There Was an error Updating.');
		}
	}

    
    /*
	 * This function deletes a table data in the database
	 * Parameters = $fields(array), $id(integer)
	 * Return type = none
    */

	public function delete($tablename, $colMatch, $id = null){
		if(!$this->_db->delete($tablename, array($colMatch, "=", $id))){
			throw new Exception('There Was an error deleting.');
        }
	}



	public function error_message(){
		return $this->_db->error_message();
	}
}