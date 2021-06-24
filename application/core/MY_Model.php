<?php

/**
 * Based model
 */
class MY_Model extends CI_Model {

    protected $table;

    public function __construct() {
        parent::__construct();
    }

    public function all() {
        return $this->db->get($this->table)->result();
    }

	public function getWhere($field, $value) {
		return $this->db->get_where($this->table, [$field => $value])->row_array();
	}

	public function getWhereMultiple($where) {
		return $this->db->get_where($this->table, $where)->result();
	}

    public function create($data) {
        $res = $this->db->insert($this->table, $data);
        if($res) {
            return $this->db->insert_id();
        }
        
        return false;
    }

	public function createMultiple($data) {
		return $this->db->insert_batch($this->table, $data);
	}

	public function delete($field, $value) {
		$this->db->delete($this->table, array($field => $value));
	}

}