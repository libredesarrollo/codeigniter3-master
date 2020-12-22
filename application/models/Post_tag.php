<?php

class Post_tag extends MY_Model {

    public $table = "post_tags";
    public $table_id = "post_id";


    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    function getByPostId($id) {
        $this->db->select('t.*');
        $this->db->from($this->table . ' as at');
        $this->db->join('tags as t', 't.tag_id = at.tag_id');
        $this->db->group_by('t.tag_id');
        $this->db->order_by('t.name');
        $this->db->where('at.post_id =', $id);

        $query = $this->db->get($this->table);
        return $query->result();
    }

    function getPostByTagId($tag_id) {
        $this->db->select('a.post_id, a.image, a.title, a.description, a.date, t.tag_id as tag_id, c.name as category_name');
        $this->db->from($this->table . ' as at');
        $this->db->join('tags as t', 't.tag_id = at.tag_id');
        $this->db->join('posts as a', 'a.post_id = at.post_id');
        $this->db->join('categories as c', 'c.category_id = a.category_id');
        $this->db->group_by('a.post_id');
        $this->db->order_by('a.post_id', 'desc');
        $this->db->where('at.tag_id =', $tag_id);

        $query = $this->db->get($this->table);
        return $query->result();
    }

    function getPostByTagIdPagination($offset, $tag_id, $enable = 'Si') {
//        $this->db->select('a.id as post_id, a.title, a.description, a.date, t.tag_id as tag_id, c.name as category_name, main_img');
        $this->db->select("a.*, c.url_clean as c_url_clean");
        $this->db->from($this->table . ' as at');
        $this->db->join('tags as t', 't.tag_id = at.tag_id');
        $this->db->join('posts as a', 'a.post_id = at.post_id');
        $this->db->join('categories as c', 'c.category_id = a.category_id');
        $this->db->group_by('a.post_id');
        $this->db->group_by('t.tag_id');

        if (isset($enable))
            $this->db->where('a.posted', $enable);
        $this->db->order_by("a.date", "desc");

        $this->db->where('at.tag_id =', $tag_id);

        $query = $this->db->get($this->table, PAGE_SIZE, $offset);
        return $query->result();
    }

    function getPostByTagsIdPagination($offset, $page_rows, $tags_id, $enable = NULL) {
        $this->db->select('a.id as id, a.title, a.description, a.date, a.url_clean as url_clean, t.tag_id as tag_id, c.name as category_name, main_img, c.url_clean as c_url_clean,');
        $this->db->from($this->table . ' as at');
        $this->db->join('tags as t', 't.tag_id = at.tag_id');
        $this->db->join('post as a', 'a.id = at.post_id');
        $this->db->join('categories as c', 'c.id = a.category_id');
        $this->db->group_by('a.id');
        $this->db->order_by('rand()');
        $this->db->where_in('at.tag_id', $tags_id);

        if (isset($enable)) {
            $this->db->where('a.enable', $enable);
        }


        $query = $this->db->get($this->table, $page_rows, $offset);
        return $query->result();
    }

    function get_post_by_tags_id_pagination_not_id($offset, $page_rows, $tags_id, $enable, $not_aticle_id) {
        $this->db->select('a.id as id, a.title, a.description, a.date, a.url_clean, t.tag_id as tag_id, c.name as category_name, main_img, c.url_clean as c_url_clean');
        $this->db->from($this->table . ' as at');
        $this->db->join('tags as t', 't.tag_id = at.tag_id');
        $this->db->join('post as a', 'a.id = at.post_id');
        $this->db->join('categories as c', 'c.id = a.category_id');
        $this->db->group_by('a.id');
        $this->db->order_by('rand()');
        $this->db->where_in('at.tag_id', $tags_id);
        $this->db->where('a.enable', $enable);

        if (isset($not_aticle_id)) {
            $this->db->where('a.id !=', $not_aticle_id);
        }

        $query = $this->db->get($this->table, $page_rows, $offset);
        return $query->result();
    }

    function tagAdd($postId, $tagId) {
        $this->post_id = $postId;
        $this->tag_id = $tagId;

        $data = array(
            'post_id' => $postId,
            'tag_id' => $tagId
        );

        try {
            $this->db->insert($this->table, $data);
            return $this->db->insert_id();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    function tagRemove($postId, $tagId) {

        try {
            $this->db->where('tag_id', $tagId);
            $this->db->where('post_id', $postId);
            $this->db->delete($this->table, $this);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

}
