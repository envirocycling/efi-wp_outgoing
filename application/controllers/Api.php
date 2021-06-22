<?php

require APPPATH . 'libraries/REST_Controller.php';

class Api extends REST_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper('app_helper');
	}

	/**
	 * Auth endpoint
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

						//$exp = (3 * 24 * 60 * 60);
						$exp = 60;
						set_cookie('token', $token, $exp, null, null, null, FALSE, TRUE );

						return $this->response(['token' => $token], REST_Controller::HTTP_OK);
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

    /**
     * Outgoing end points
     */
    public function outgoings_get($id = 0) {

        $token = get_cookie('token');

		if($token) {

			if(verifyToken($token)) {
				if($this->get()) {

					$start_date = $this->get('start_date');
					$end_date = $this->get('end_date');

					$data = $this->outgoing->getRange($start_date, $end_date);

				} else {

					if (!empty($id)) {

						$data = $this->outgoing->getWhere('id', $id);

						if(!$data) {
							return $this->response(['Not Found'], REST_Controller::HTTP_NOT_FOUND);
						}

					} else {
						$data = $this->outgoing->all();
					}

				}

				return $this->response($data, REST_Controller::HTTP_OK);
			} else {

				return $this->response(['message' => 'Unauthorized'], REST_Controller::HTTP_UNAUTHORIZED);

			}
		}

		return $this->response(['message' => 'Unauthorized'], REST_Controller::HTTP_UNAUTHORIZED);

	}

	public function outgoings_post() {

		$data = $this->post();

		$res = $this->outgoing->createOrUpdate($data);

		if ($res) {
			$this->response(['Success'], REST_Controller::HTTP_CREATED);
		} else {
			$this->response(['Failed'], REST_Controller::HTTP_BAD_REQUEST);
		}
	}
     /** 
      * End Outgoing end point
     */

	public function details_get($id = 0) {

        $data = ['msg' => 'test data'];

		$this->response($data, REST_Controller::HTTP_OK);

	}

	public function details_post() {

		$data = $this->post();

		$this->response(['data' => $data, 'status' => 'success'], REST_Controller::HTTP_CREATED);
	
    }
}