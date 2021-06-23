<?php

require APPPATH . 'libraries/REST_Controller.php';

class Transaction extends REST_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper('app_helper');

        //check_auth();
	}




    /**
     * Outgoing end points
	 * 
	 * @return OBJECT
     */
    public function outgoings_get($id = 0) {

        $x = $this->input->cookie('token');

        die(var_dump($x));

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