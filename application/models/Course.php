<?php

class Course extends CI_Model {

    public $table = "courses";
    public $table_id = "course_id";

    function __construct() {
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
    }

    function findAll() {
        $this->db->order_by("course_id", "desc");
        $this->db->select('co.*, p.url_clean, c.url_clean as c_url_clean');
        $this->db->from("$this->table as co");
        $this->db->join("posts as p", "co.post_id = p.post_id");
        $this->db->join("categories as c", "c.category_id = p.category_id");
        $query = $this->db->get();
        return $query->result();
    }

    function findByCategoryIdAndDistintPost($category_id, $post_id) {
        $this->db->order_by("course_id", "desc");
        $this->db->select('co.*, p.url_clean, c.url_clean as c_url_clean');
        $this->db->from("$this->table as co");
        $this->db->join("posts as p", "co.post_id = p.post_id");
        $this->db->join("categories as c", "c.category_id = p.category_id");
        $this->db->where("c.category_id", $category_id);
        $this->db->where("p.post_id !=", $post_id);
        $query = $this->db->get();
        return $query->result();
    }

}
