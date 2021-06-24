<?php

    //User Model
    class User extends MY_Model {

        protected $table;

        public function __construct() {
            parent::__construct();

            $this->table = 'users';
        }


        //Add a user
        public function addUser($data) {
            $this->db->insert($this->table, $data);
        }

        //get a user
        public function getUser($username) {
            return $this->db->get_where($this->table,['username' => $username])->row();
        }
    }