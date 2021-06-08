<?php

require APPPATH . 'libraries/REST_Controller.php';

class Users extends REST_Controller {

	public function __construct() {
		parent::__construct();
	}

	public function index_get($username = '') {

		if ($username) {
			$data = $this->user->getUser($username);

            if(!$data) {
                return $this->response(['Not Found'], REST_Controller::HTTP_NOT_FOUND);
            }

		} else {
			$data = $this->user->all();
		}

		$this->response($data, REST_Controller::HTTP_OK);
	}

	public function index_post() {

		// $data = $this->post();

		// $res = $this->outgoing->createOrUpdate($data);

		// if ($res) {
		// 	$this->response(['Success'], REST_Controller::HTTP_CREATED);
		// } else {
		// 	$this->response(['Failed'], REST_Controller::HTTP_BAD_REQUEST);
		// }
	}
}