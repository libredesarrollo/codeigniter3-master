<?php

class Category extends MY_Model {

    public $table = "categories";
    public $table_id = "category_id";

    function GetByUrlClean($url_clean) {

        $this->db->select();
        $this->db->from("$this->table");
        $this->db->where("url_clean", $url_clean);

        $query = $this->db->get();

        return $query->row();
    }

    function findAll() {

        $this->db->select();
        $this->db->from("$this->table");
        $this->db->order_by("name");
        //$this->db->where("category_id",1);

        //$query = $this->db->query("SELECT * FROM categories");
        $query = $this->db->get();

        return $query->result();
    }

}
