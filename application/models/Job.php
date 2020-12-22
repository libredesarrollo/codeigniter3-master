<?php

class Job extends CI_Model {

    public $table = "jobs";
    public $table_id = "post_id";

    function __construct() {
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
    }

    function findAll() {
        $this->db->order_by("job_id", "desc");
        $query = $this->db->get($this->table);
        return $query->result();
    }

}
