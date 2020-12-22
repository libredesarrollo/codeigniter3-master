<?php

class Post extends MY_Model
{

    public $table = "posts";
    public $table_id = "post_id";

    function getPagination($offset = 0, $posted = 'Si', $order = 'desc', $c_url_clean = null)
    {

        $this->db->select('p.*, c.url_clean as c_url_clean, c.name as category');
        $this->db->from("$this->table as p");
        $this->db->join("categories as c", "c.category_id = p.category_id");
        $this->db->where("posted", $posted);
        if (isset($c_url_clean))
            $this->db->where("c.url_clean", $c_url_clean);
        $this->db->order_by("date", $order);
        $this->db->order_by("post_id", $order);
        $this->db->limit(PAGE_SIZE, $offset);
        $query = $this->db->get();

        return $query->result();
    }

    function getByIds($ids)
    {

        $this->db->select('p.*, c.url_clean as c_url_clean, c.name as category');
        $this->db->from("$this->table as p");
        $this->db->join("categories as c", "c.category_id = p.category_id");
        $this->db->where_in("post_id", $ids);
        $query = $this->db->get();

        return $query->result();
    }

    function GetByUrlClean($url_clean, $posted = 'Si')
    {

        $this->db->select('p.*, c.url_clean as c_url_clean, c.name as category');
        $this->db->from("$this->table as p");
        $this->db->join("categories as c", "c.category_id = p.category_id");
        $this->db->where("posted", $posted);
        $this->db->where("p.url_clean", $url_clean);

        $query = $this->db->get();

        return $query->row();
    }

    function find($post_id, $posted = null)
    {

        $this->db->select('p.*, c.url_clean as c_url_clean, c.name as category');
        $this->db->from("$this->table as p");
        $this->db->join("categories as c", "c.category_id = p.category_id");
        if ($posted)
            $this->db->where("posted", $posted);
        $this->db->where("p.post_id", $post_id);

        $query = $this->db->get();

        return $query->row();
    }

    function countByCUrlClean($c_url_clean, $posted = 'Si')
    {

        $this->db->select('COUNT(p.post_id) as count');
        $this->db->from("$this->table as p");
        $this->db->join("categories as c", "c.category_id = p.category_id");
        $this->db->where("posted", $posted);
        $this->db->where("c.url_clean", $c_url_clean);
        $query = $this->db->get();
        return $query->row()->count;
    }

    function getBySearch($searchs, $category_id = null, $posted = 'Si', $order = 'desc')
    {
        $this->db->select('p.*, c.url_clean as c_url_clean, c.name as category');
        $this->db->from("$this->table as p");
        $this->db->join("categories as c", "c.category_id = p.category_id");
        $this->db->where("posted", $posted);

        foreach ($searchs as $key => $search) {
            $this->db->like('p.title', $search);
        }

        if ($category_id != null && $category_id != "")
            $this->db->where("c.category_id", $category_id);

        $this->db->order_by("created_at", $order);
        $query = $this->db->get();

        return $query->result();
    }

    function getGUP($user_id, $posted = 'Si', $order = 'desc')
    {
        $this->db->select('p.*, c.url_clean as c_url_clean, c.name as category, gup.group_user_post_id');
        $this->db->from("$this->table as p");
        $this->db->join("categories as c", "c.category_id = p.category_id");
        $this->db->join("group_user_posts as gup", "p.post_id = gup.post_id", 'left');
        $this->db->where("posted", $posted);
        $this->db->where('gup.user_id', $user_id);

        $this->db->order_by("created_at", $order);
        $query = $this->db->get();

        return $query->result();
    }

    function getBeforeById($post_id)
    {

        $this->db->select('p.*, c.url_clean as c_url_clean');
        $this->db->from("$this->table as p");
        $this->db->join("categories as c", "c.category_id = p.category_id");
        $this->db->order_by("post_id", "desc");
        $this->db->or_where('post_id <', $post_id);
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->row();
    }

    function getAfterById($post_id = NULL)
    {
        $this->db->select('p.*, c.url_clean as c_url_clean');
        $this->db->from("$this->table as p");
        $this->db->join("categories as c", "c.category_id = p.category_id");
        $this->db->order_by("post_id", "asc");
        $this->db->or_where('post_id >', $post_id);
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->row();
    }

    function get_by_tag_url_clean_and_c_url_clean($url_clean, $data_category, $limit, $not_id, $ids)
    {

        $this->db->select('a.*, c.url_clean as c_url_clean,GROUP_CONCAT(t2.name,"") as tags, GROUP_CONCAT(t2.tag_id,"") as tags_id');
        $this->db->from('posts as a');
        $this->db->join('categories as c', 'c.category_id = a.category_id');
        $this->db->join('tags as t', 't.url_clean = "' . $url_clean . '"');
        $this->db->join('post_tags as at', 'at.tag_id = t.tag_id');
        $this->db->join('tags as t2', 't2.tag_id = at.tag_id', 'left');
        $this->db->where('a.post_id = at.post_id', NULL, FALSE);
        $this->db->where('c.url_clean', $data_category);
        $this->db->order_by('a.post_id', 'desc');
        $this->db->group_by('a.post_id');
        if ($limit != "" && is_numeric($limit)) {
            $this->db->limit($limit);
        }

        if ($ids != "") {
            $ids = explode(",", $ids);
            $this->db->where_in("a.post_id", $ids);
        }

        if ($not_id != "" && is_numeric($not_id)) {
            $this->db->where('a.post_id !=', $not_id);
        }

        $query = $this->db->get();
        return $query->result();
    }

    function get_by_title_and_c_url_clean($array_titles, $data_category, $limit, $not_id, $ids, $data_bound)
    {

        $this->db->select('a.*, c.url_clean as c_url_clean');
        $this->db->from('posts as a');
        //        $this->db->join('category as c', 'c.url_clean = "' . $data_category . '"');
        $this->db->join('categories as c', 'c.category_id = a.category_id');

        $like_statements = array();
        foreach ($array_titles as $title)
            $like_statements[] = "a.title LIKE '%" . $title . "%'";
        //            $this->db->or_like('a.title', $title, 'both');
        $like_string = "(" . implode(' OR ', $like_statements) . ")";
        $this->db->where($like_string, NULL, FALSE);

        $this->db->order_by('a.post_id', 'desc');
        $this->db->group_by('a.post_id');
        if ($limit != "" && is_numeric($limit)) {
            $this->db->limit($limit);
        }

        if ($ids != "") {
            $ids = explode(",", $ids);
            $this->db->where_in("a.post_id", $ids);
        }

        if ($not_id != "" && is_numeric($not_id)) {
            $this->db->where('a.post_id !=', $not_id);
        }

        if ($data_category != "") {
            $this->db->where('c.url_clean', $data_category);
        }

        if ($data_bound != "") {
            $this->db->like('a.title', $data_bound, 'both');
        }

        //        $this->db->where('', NULL, FALSE);
        $query = $this->db->get();
        return $query->result();
    }
}
