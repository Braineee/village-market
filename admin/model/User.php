<?php

/*

 * USED FOR POSTING AND RETRIVAL OF USER DATA TO THE DATA BASE (NB: this method class can be substituted for any othe class)

 * Author: DAVID DANIEL

 * Last Edited: 30/04/2017

 * STILL "To Do"

*/

class User {

	private $_db,

			$_data,

			$_sessionName,

			$_cookieName,

			$_isLoggedin;



	/*

	 * This is the pseudo construct function for the User class

	 * Parameters = none

	 * Return type = string

	*/

	public function __construct($user = null){

		//$this->_db = DB::getInstance();

		$this->_db = DB::getInstance();



		$this->_sessionName = Config::get('session/session_name');

		$this->_cookieName = Config::get('remember/cookies_name');



		if(!$user){

			if(Session::exists($this->_sessionName)){

				$user = Session::get($this->_sessionName);

				if($this->find($user)){

					$this->_isLoggedin = true;

				}else{

					$this->_isLoggedin = false;

				}

			}

		}else {

			$this->find($user);

		}

	}



	/*

	 * This function updates a users data in the database

	 * Parameters = $fields(array), $id(integer)

	 * Return type = none

	*/

	public function update($colMatch, $fields = array(), $id = null){



		if(!$id && $this->isLoggedin()){

			$id = $this->data()->staff_id;

		}



		if(!$this->_db->update('users',$colMatch, $fields, $id)){

			throw new Exception('There Was an error Updating.');

		}

	}



	/*

	 * This function creates a new users data in the database

	 * Parameters = $fields(array))

	 * Return type = none

	*/

	public function create($fields = array()){

		if (!$this->_db->insert('users', $fields)) {

			throw new Exception('There was a problem creating your account');

		}

	}



	/*

	 * This function finds a users data in the database

	 * Parameters = $user(string)

	 * Return type = boolean

	*/

	public function find($user = null){

		if($user){

			$field = (is_numeric($user)) ? 'staff_id' : 'email';

			$data = $this->_db->get('staffs', array($field, '=', $user));



			if($data->count()){

				$this->_data = $data->first();

				return true;

			}

		}



		return false;

	}



	/*

	 * This function validates a users login details i.e password and username

	 * Parameters = $username(string), $password(string)

	 * Return type = boolean

	*/

	public function login($email = null, $password = null, $remember = false){



		if(!$email && !$password && $this->exists()){

			//log in the user

			Session::put($this->_sessionName, $this->data()->staff_id);

		}else{

			$user =  $this->find($email);

			if($user){

				if($this->data()->password === Hash::make($password, $this->data()->salt)){

					if($this->data()->is_blocked == 0){

						Session::put($this->_sessionName, $this->data()->staff_id);

						if($remember){

							$staff_id = $this->data()->staff_id;

							$DateLoggedIn = date('Y-m-d');

							$TimeLoggedIn = date('H:i:s');

							$hash = Hash::unique();



							$hashCheck = DB::getInstance()->query("SELECT * FROM user_session WHERE staff_id LIKE '$staff_id'");



							if(!$hashCheck->count()){

								//

								$log_user = DB::getInstance()->query("INSERT INTO user_session (staff_id, Hash, DateLoggedin, TimeLoggedin)VALUES('$staff_id','$hash','$DateLoggedIn', '$TimeLoggedIn')");



							}else{

								$hash = $hashCheck->first()->hash;

							}

							Cookie::put($this->_cookieName, $hash, Config::get('remember/cookies_expiry'));

						}

						return 'true';

					}else{

						return "You have been blocked";

					}

				}else{

					return "You entered a wrong password";

				}

			}else{

				return "This email hasn't been registered";

			}

		}



		return false;

	}



	/*

	 * This function checks for  a users role/permission

	 * Parameters = $key(string)

	 * Return type = boolean

	*/

	public function hasPermission($key){

		$group = $this->_db->get('groups', array('GroupId', '=', $this->data()->Group));

		if($group->count()){

			$permissions = json_decode($group->first()->Permissions, true);



			if($permissions[$key] == true){

				return true;

			}

		}

		return false;

	}



	/*

	 * This function logs a users out of the system

	 * Parameters = none

	 * Return type = none

	*/

	public function logout(){

		$staff_id = $this->data()->staff_id;

		$this->_db->query("DELETE from user_session where staff_id like '$staff_id'");



		Session::delete($this->_sessionName);

		if(isset($this->_cookieName)){

			Cookie::delete($this->_cookieName);

		}



	}



	/*

	 * This function Fetches all data relating to the current user from the database

	 * Parameters = none

	 * Return type = object

	*/

	public function data(){

		return $this->_data;

	}



	/*

	 * This function checks the login status of a user

	 * Parameters = none

	 * Return type = boolean

	*/

	public function isLoggedin(){

		return $this->_isLoggedin;

	}



	/*

	 * This function checks if a particular user exists

	 * Parameters = none

	 * Return type = boolean

	*/

	public function exists(){

		return (!empty($this->_data)) ? true : false;

	}

}
