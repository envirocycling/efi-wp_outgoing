<?php

/**
 * Transaction details model
 */
class Detail extends MY_Model {

    protected $table;

    public function __construct() {
        parent::__construct();
        $this->table = 'wp_outgoing_details';
    }

    public function getById($id) {
        $res = $this->db->get_where($this->table, ['trans_id' => $id])->result();
        return $res ? $res : null;
    }

}