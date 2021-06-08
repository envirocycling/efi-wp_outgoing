<?php

require APPPATH . 'libraries/REST_Controller.php';

class Outgoings extends REST_Controller {

	public function __construct() {
		parent::__construct();
	}

	public function index_get($id = 0) {

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

		$this->response($data, REST_Controller::HTTP_OK);

	}

	public function index_post() {

		$data = $this->post();

		$res = $this->outgoing->createOrUpdate($data);

		if ($res) {
			$this->response(['Success'], REST_Controller::HTTP_CREATED);
		} else {
			$this->response(['Failed'], REST_Controller::HTTP_BAD_REQUEST);
		}
	}

	// public function index_put($id) {

	// 	$this->response(['Item updated successfully.'], REST_Controller::HTTP_OK);
	// }

	// public function index_delete($id) {

	// 	$this->outgoing->delete('log_id', $id);

	// 	$this->response(['Item deleted successfully.'], REST_Controller::HTTP_OK);
	// }

	// public function duplicate_get() {

	// 	$input = $this->get();

	// 	$data = $this->outgoing->duplicates($input['start_date'], $input['end_date'], $input['branch']);

	// 	if (count($data) > 0) {
	// 		$this->response($data, REST_Controller::HTTP_OK);
	// 	} else {
	// 		$this->response($data, REST_Controller::HTTP_NOT_FOUND);
	// 	}

	// }

}