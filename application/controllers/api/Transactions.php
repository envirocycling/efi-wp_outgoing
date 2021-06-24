<?php

require APPPATH . 'libraries/REST_Controller.php';

class Transactions extends REST_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper('app_helper');
        checkAuth();
	}

    /**
     * Outgoing end points
	 * 
	 * @return OBJECT
     */
    public function outgoings_get($id = 0) {

        if($this->get()) {
            $start_date = $this->get('start_date');
            $end_date = $this->get('end_date');
            $data = $this->transaction->getRange($start_date, $end_date);
        } else {
            if (!empty($id)) {
                $data = $this->transaction->getWhere('id', $id);
                if(!$data) {
                    return $this->response(['Not Found'], REST_Controller::HTTP_NOT_FOUND);
                }
            } else {
                $data = $this->transaction->all();
            }
        }
        return $this->response($data, REST_Controller::HTTP_OK);
	}

	public function outgoings_post() {
		$data = $this->post();

		$id = $this->transaction->createOrUpdate($data);

		if ($id) {
			$this->response(['trans_id' => $id], REST_Controller::HTTP_CREATED);
		} else {
			$this->response(['Failed'], REST_Controller::HTTP_BAD_REQUEST);
		}
	}

	public function details_get($trans_id) {

        $detail = $this->detail->getWhere('trans_id',$trans_id);

        die(var_dump($detail));
        
		$this->response($data, REST_Controller::HTTP_OK);
	}

	public function details_post() {
		$data = $this->post();
		$this->response(['data' => $data, 'status' => 'success'], REST_Controller::HTTP_CREATED);
    }

    public function createdetails_post() {
		$data = $this->post("data");

        $this->detail->delete('wp_outgoing_id', $data[0]['wp_outgoing_id']);
        
        $res = $this->detail->createMultiple($data);

        if($res) {
            return $this->response(['data' => ['details' => $data, 'count' => $res]], REST_Controller::HTTP_CREATED);
        }
		
        return $this->response(['error' => 'Internal server error'], REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
    }
}