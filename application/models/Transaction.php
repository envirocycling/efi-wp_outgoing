<?php

/**
 * Transaction model
 */
class Transaction extends MY_Model {

    protected $table;

    public function __construct() {
        parent::__construct();
        $this->table = 'wp_outgoing';
    }

	public function getRange($start, $end) {
		$query = "SELECT * FROM `{$this->table}` WHERE `date_estimated`>='{$start} 00:00:00' AND `date_estimated`<='{$end} 23:59:59';";
		return $this->db->query($query)->result();
	}

    public function getAllOutgoingsWithPagination($limit, $offset) {
        $this->db->limit($limit, $offset);
        return $this->db->get($this->table)->result();
    }

    public function getOutgoing($id) {
        return $this->db->get_where($this->table,['id' => $id])->row();
    }


	public function findOrCreate($data) {

		$branch = $data['branch'];
        $str_no = $data['str_no'];
		$scale_id = $data['scale_id'];

		$query = "
			SELECT
			    *
			FROM
			    `{$this->table}`
			WHERE
			    (
			        `branch` = '{$branch}'
                    AND `str_no` = '{$str_no}' 
			        AND `scale_id` = '{$scale_id}'

			    );
		";

		$result = $this->db->query($query)->result();

		$count = count($result);

		if (!$count) {
			return $this->db->insert($this->table, $data);
		}

		return $result;

	}

	public function createOrUpdate($data) {

		$branch = $data['branch'];
        $str_no = $data['str_no'];
		$trans_id = $data['trans_id'];

		$query = "
			SELECT
			    *
			FROM
			    `{$this->table}`
			WHERE
			    (
			        `branch` = '{$branch}'
                    AND `str_no` = '{$str_no}' 
			        AND `trans_id` = '{$trans_id}'

			    );
		";

		$result = $this->db->query($query)->result();

		$count = count($result);

		if ($count > 0) {
			// Update the existing data
			$this->db->where('branch', $branch);
			$this->db->where('str_no', $str_no);
			$this->db->where('trans_id', $trans_id);
			$this->db->delete($this->table);
		}
		// Insert data
		$res = $this->db->insert($this->table, $data);
		return ($res) ? $this->db->insert_id() : FALSE; 
		
	}

}