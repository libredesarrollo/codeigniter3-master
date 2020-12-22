<?php

class Tag extends CI_Model {

    var $table = 'tags';

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    function getAll() {
        $this->db->order_by('name');
        $query = $this->db->get($this->table);
        return $query->result();
    }

    function getAllPost() {
        $this->db->select('t.name, t.id, t.url_clean');
        $this->db->order_by('t.name');
        $this->db->distinct();
        $this->db->from($this->table . ' as t');
        $this->db->join('post_tag as at', 'at.tag_id = t.id');

        $query = $this->db->get();
        return $query->result();
    }

    function findUrl_clean($url_clean) {

        $this->db->select();
        $this->db->from($this->table);
        $this->db->where("url_clean", $url_clean);

        $query = $this->db->get();
        return $query->row();
    }

    function url_clean($url_clean, $id) {

        $data = array(
            'url_clean' => $url_clean
        );

        try {
            $this->db->update('tag', $data, array('id' => $id));
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

}
