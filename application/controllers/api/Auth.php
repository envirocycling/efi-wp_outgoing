<?php

require APPPATH . 'libraries/REST_Controller.php';

class Auth extends REST_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper('app_helper');
	}

	public function unauthorized_get() {
        return $this->response(['message' => 'Unauthorized'], REST_Controller::HTTP_UNAUTHORIZED);
    }

	// public function getcookie_get() {
	// 	$token = getToken('token');
	// 	print_r($token);
	// }

	// public function setcookie_get() {
	// 	$data = array(
	// 		'user_id' => 123,
	// 		'name' => 'John Doe'
	// 	);
		
	// 	$token = generateToken($data);

	// 	if($token) {
	// 		setToken($token);
	// 		$cookie = getToken('token');
	// 		return $this->response(['token' => $cookie], REST_Controller::HTTP_OK);
	// 	}
					
	// 	return $this->response(['error' => 'Something went wrong'], REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
	// }

	/**
	 * Auth endpoint
	 * 
	 * @return OBJECT
	 */
	 public function login_post() {

        $username = $this->post('username');
		$password = $this->post('password');

        if(empty($username) || empty($password)) {

            return $this->response(['error' => 'Username and Password must not empty'], REST_Controller::HTTP_BAD_REQUEST);

        } else {
            $user = $this->user->getUser($username);
            if($user) {

                if($this->bcrypt->check_password($password, $user->password)) {

					$data = array(
						'user_id' => $user->id,
						'name' => $user->name
					);

					$token = generateToken($data);

					if($token) {

						setToken($token);

						$cookie = getToken('token');

						return $this->response(['token' => $cookie], REST_Controller::HTTP_OK);
					}
					
					return $this->response(['error' => 'Something went wrong'], REST_Controller::HTTP_INTERNAL_SERVER_ERROR);

                } else {
                    return $this->response(['error' => 'Invalid password'], REST_Controller::HTTP_UNAUTHORIZED);
                }

            }else {

            	return $this->response(['error' => 'Invalid Username'], REST_Controller::HTTP_UNAUTHORIZED);

            }
        }
	 }

	
	public function register_post() {

		$name = $this->post('name');
		$username = $this->post('username');
		$password = $this->post('password');

		if(
			empty($name) || 
			empty($username) || 
			empty($password)) {

            return $this->response(['error' => 'Bad Request'], REST_Controller::HTTP_BAD_REQUEST);

        } else {

			$user = $this->user->getUser($username);

			if($user) {
				return $this->response(['error' => 'User already exists'], REST_Controller::HTTP_BAD_REQUEST);
			}

			$hashedPassword = $this->bcrypt->hash_password($password);

			$res = $this->user->addUser([
				'name' => $name,
				'username' => $username,
				'password' => $hashedPassword
			]);

			return $this->response(['message' => 'Success'], REST_Controller::HTTP_CREATED);
		}
		

	}

	public function logout_post() {
		removeToken('token');
		return $this->response(['message' => 'Success'], REST_Controller::HTTP_OK);
	}

}