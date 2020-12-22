<?php

Class Contact extends CI_Model {

    private $table = 'contacts';
    private $table_id = 'contact_id';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function find($id) {

        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where($this->table_id . ' = ', $id);

        $query = $this->db->get();
        return $query->row();
    }

    function save($name, $email, $message) {

        $data = array(
            'name' => $name,
            'email' => $email,
            'message' => $message
        );

        try {
            $this->db->insert($this->table, $data);
            return $this->db->insert_id();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

}
