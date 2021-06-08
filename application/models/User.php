<?php

    //User Model
    class User extends CI_Model {

        protected $table;

        public function __construct() {
            parent::__construct();

            $this->table = 'users';
        }

        public function all() {
            return $this->db->get($this->table)->result();
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