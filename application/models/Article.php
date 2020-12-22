<?php

class Article extends CI_Model {

    var $title = '';
    var $body = '';

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    static function get_count_by_categoty_id($category_id) {
        $ci = & get_instance();

        $ci->db->from('article');
        $ci->db->where('category_id = ', $category_id);

        return $ci->db->count_all_results();
    }

    function get_last_id() {

        $this->db->select("id");
        $this->db->order_by("id", "desc");
        $this->db->limit(1);
        $query = $this->db->get('article');

        return $query->row("id");
    }

    function get_all($enable = NULL, $twitter_enable = NULL) {

        $this->db->select('*');
        $this->db->from('article');

        if (isset($enable)) {
            $this->db->where('enable', $enable);
        }

        if (isset($twitter_enable))
            $this->db->where('send_tweet', $twitter_enable);

        $query = $this->db->get();

        return $query->result();
    }

    function get_by_tag_url_clean_and_c_url_clean($url_clean, $data_category, $limit, $not_id) {

        $this->db->select('a.*, c.url_clean as c_url_clean,GROUP_CONCAT(t2.name,"") as tags, GROUP_CONCAT(t2.id,"") as tags_id');
        $this->db->from('article as a');
        $this->db->join('category as c', 'c.id = a.category_id');
        $this->db->join('tag as t', 't.url_clean = "' . $url_clean . '"');
        $this->db->join('article_tag as at', 'at.tag_id = t.id');
        $this->db->join('tag as t2', 't2.id = at.tag_id', 'left');
        $this->db->where('a.id = at.article_id', NULL, FALSE);
        $this->db->where('c.url_clean', $data_category);
        $this->db->order_by('a.id', 'desc');
        $this->db->group_by('a.id');
        if ($limit != "" && is_numeric($limit)) {
            $this->db->limit($limit);
        }

        if ($not_id != "" && is_numeric($not_id)) {
            $this->db->where('a.id !=', $not_id);
        }

        $query = $this->db->get();
        return $query->result();
    }

    function get_by_title_and_c_url_clean($array_titles, $data_category, $limit, $not_id, $data_bound) {

        $this->db->select('a.*, c.url_clean as c_url_clean');
        $this->db->from('article as a');
//        $this->db->join('category as c', 'c.url_clean = "' . $data_category . '"');
        $this->db->join('category as c', 'c.id = a.category_id');

        $like_statements = array();
        foreach ($array_titles as $title)
            $like_statements[] = "a.title LIKE '%" . $title . "%'";
//            $this->db->or_like('a.title', $title, 'both');
        $like_string = "(" . implode(' OR ', $like_statements) . ")";
        $this->db->where($like_string, NULL, FALSE);

        $this->db->order_by('a.id', 'dedsc');
        $this->db->group_by('a.id');
        if ($limit != "" && is_numeric($limit)) {
            $this->db->limit($limit);
        }

        if ($not_id != "" && is_numeric($not_id)) {
            $this->db->where('a.id !=', $not_id);
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

    function get_by_category_id($category_id = null) {

        if (!isset($category_id))
            $category_id = $this->input->get_post('category_id');

        $this->db->select('a.*, c.url_clean as c_url_clean');
        $this->db->from('article as a');
        $this->db->join('category as c', 'c.id = a.category_id');
        $this->db->order_by('id', 'desc');
        $this->db->where('category_id = ', $category_id);

        $query = $this->db->get();
        return $query->result();
    }

    function get_by_theme_id_pagination($offset = 0, $page_rows = 10, $theme_id = NULL) {

        if ($theme_id == NULL)
            $theme_id = $this->input->get_post('theme_id');

        $this->db->select();
        $this->db->where('theme_id', $theme_id);
        $this->db->order_by("date", "desc");
        $query = $this->db->get('article', $page_rows, $offset);
        return $query->result();
    }

    function get_article_by_search_pagination($offset = 0, $page_rows = 10, $names) {

        $this->db->select("a.id, a.date, a.description, a.title, a.url_clean, c.url_clean as c_url_clean");
        $this->db->from('article as a');
        $this->db->join('category as c', 'c.id = a.category_id');

        foreach ($names as $key => $name) {
            $this->db->like('a.title', $name);
        }
        $this->db->where('a.enable', 'Y');
        $this->db->order_by("a.date", "desc");
//        $query = $this->db->get('article', $page_rows, $offset);
        $query = $this->db->get();
        return $query->result();
    }

    function get_article_by_search($names) {

        $this->db->select("id, title, url_clean, main_img, description");
        foreach ($names as $key => $name) {
            $this->db->like('title', $name);
        }
        $this->db->order_by("date", "desc");
        $query = $this->db->get('article');
        return $query->result();
    }

    function get_by_id($article_id = NULL) {
        if ($article_id == NULL)
            $article_id = $this->input->get_post('article_id');

        $query = $this->db->get_where('article', array('id' => $article_id));
        return $query->row();
    }

    function get_by_url_clean($url_clean = NULL) {
        return $this->db->get_where('article', array('url_clean' => $url_clean))->row();
    }

    function get_by_id_compiled($article_id = NULL) {
        if ($article_id == NULL)
            $article_id = $this->input->get_post('article_id');

        $query = $this->db->get_where('article', array('id' => $article_id));
        return $query->row();
    }

    function get_by_id_active($article_id = NULL, $enable = 'Y') {

        if ($article_id == NULL)
            $article_id = $this->input->get_post('article_id');

        $this->db->select();
        $this->db->where('id', $article_id);
        $this->db->where('enable', $enable);

        $query = $this->db->get('article');
        return $query->row();
    }

    function get_before_by_id($article_id = NULL) {
        if ($article_id == NULL)
            $article_id = $this->input->get_post('article_id');

        $this->db->select();
        $this->db->order_by("id", "desc");
        $this->db->or_where('id <', $article_id);
        $this->db->limit(1);
        $query = $this->db->get('article');
        return $query->row();
    }

    function get_after_by_id($article_id = NULL) {
        if ($article_id == NULL)
            $article_id = $this->input->get_post('article_id');

        $this->db->select();
        $this->db->order_by("id", "asc");
        $this->db->or_where('id >', $article_id);
        $this->db->limit(1);
        $query = $this->db->get('article');
        return $query->row();
    }

    function get_by_theme_id($theme_id = NULL) {
        if ($theme_id == NULL)
            $theme_id = $this->input->get_post('theme_id');

        $this->db->where('theme_id', $theme_id);
        $this->db->order_by("date", "asc");
        $query = $this->db->get('article');

        // $query = $this->db->get_where('article', array('theme_id' => $theme_id));
        return $query->result_array();
    }

    function get_by_body($match) {

        $this->db->like('body', $match);
        $this->db->order_by("date", "asc");
        $query = $this->db->get('article');

        return $query->result_array();
    }

    function get_by_title($match) {

        $this->db->like('title', $match);
        $this->db->order_by("date", "asc");
        $query = $this->db->get('article');

        return $query->result_array();
    }

    function insert() {

        $this->keywords = $this->input->post('keywords');
        $this->category_id = $this->input->post('category_id');
        $this->description = $this->input->post('description');
        $this->url_clean = $this->input->post('url_clean');
        $this->title = ($this->input->post('title') === "") ? "Sin título" : $this->input->post('title');
        $this->body = ($this->input->post('body') === "") ? "Sin contenido" : minify_html($this->input->post('body'));
        $this->web_content = $this->input->post('web_content');
        $this->main_img = $this->input->post('main_img');
        $this->add_code = $this->input->post('add_code');
        $this->enable = $this->input->post('enable');
        $this->date = date('Y-m-d H:i:s', strtotime(str_replace('-', '/', date('Y-m-d H:i:s'))));

        try {
            $this->db->insert('article', $this);
            return $this->db->insert_id();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    function update() {

        $this->keywords = $this->input->post('keywords');
        $this->description = $this->input->post('description');
        $this->url_clean = $this->input->post('url_clean');
        $this->title = ($this->input->post('title') === "") ? "Sin título" : $this->input->post('title');
        $this->body = ($this->input->post('body') === "") ? "Sin contenido" : minify_html($this->input->post('body'));
        $this->web_content = $this->input->post('web_content');
        $this->path_img = rtrim($this->input->post('path_img'), ", ");
        $this->add_code = $this->input->post('add_code');
        $this->enable = $this->input->post('enable');
        $this->db->set('update_in', 'NOW()', FALSE);

        try {
            $this->db->update('article', $this, array('id' => $this->input->post('id')));
            return intval($this->input->post('id'));
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    function update2($main_img, $body, $title, $id) {

        $this->main_img = $main_img;
        $this->body = $body;
        $this->title = $title;

        try {
            $this->db->update('article', $this, array('id' => $id));
            return intval($id);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    function main_img($main_img, $id) {

        $data = array(
            'main_img' => $main_img
        );

        try {
            $this->db->update('article', $data, array('id' => $id));
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    function url_clean($url_clean, $id) {

        $data = array(
            'url_clean' => $url_clean
        );

        try {
            $this->db->update('article', $data, array('id' => $id));
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    function path_img($path_img, $id) {

        $data = array(
            'path_img' => $path_img
        );

        try {
            $this->db->update('article', $data, array('id' => $id));
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    function main_img_quality($main_img_quality, $id) {

        $data = array(
            'main_img_quality' => $main_img_quality
        );

        try {
            $this->db->update('article', $data, array('id' => $id));
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    function column_name() {
        $query = $this->db->get_where('information_schema.columns', array('table_name' => 'article'));
        return $query->result_array();
    }

    function get_last_pagination($offset = 0, $page_rows = 10, $enable = 'Y', $twitter_enable = null) {

        $this->db->select("a.*, GROUP_CONCAT(t.name,'') as tags, GROUP_CONCAT(t.id,'') as tags_id, c.url_clean as c_url_clean");
        $this->db->from('article as a');
        $this->db->join('article_tag as at', 'at.article_id = a.id', 'left');
        $this->db->join('category as c', 'c.id = a.category_id');
        $this->db->join('tag as t', 't.id = at.tag_id', 'left');

        if (isset($enable))
            $this->db->where('enable', $enable);

        if (isset($twitter_enable))
            $this->db->where('send_tweet', $twitter_enable);

        $this->db->order_by("date", "desc");

        $this->db->limit($page_rows, $offset);
        $this->db->group_by("a.id");
        $query = $this->db->get();

        return $query->result();
    }

    function get_by_category_id_pagination($offset = 0, $page_rows = 10, $category_id = NULL, $enable = NULL) {

        $this->db->select("a.*, GROUP_CONCAT(t.name,'') as tags, GROUP_CONCAT(t.id,'') as tags_id, c.url_clean as c_url_clean");
        $this->db->from('article as a');
        $this->db->join('category as c', 'c.id = a.category_id');
        $this->db->where('category_id', $category_id);

        if (!isset($category_id))
            $category_id = $this->input->get_post('category_id');

        if (!isset($category_id))
            return null;

        if (isset($enable))
            $this->db->where('a.enable', $enable);

        $this->db->join('article_tag as at', 'at.article_id = a.id', 'left');
        $this->db->join('tag as t', 't.id = at.tag_id', 'left');
        $this->db->order_by("date", "desc");
        $this->db->limit($page_rows, $offset);
        $this->db->group_by("a.id");
        $query = $this->db->get();

        return $query->result();
    }

    function auto_increment($value) {
        $this->db->query('ALTER TABLE ' . $this->table . ' AUTO_INCREMENT ' . $value);
    }

}
