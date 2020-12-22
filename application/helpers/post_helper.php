<?php

function posted()
{
    return array("no" => "No", "si" => "Si");
}

function categories_to_form($categories)
{
    $aCategories = array();

    foreach ($categories as $key => $c) {
        $aCategories[$c->category_id] = $c->name;
    }

    return $aCategories;
}

function url_post_by_id($id, $complete = true)
{

    $CI = &get_instance();
    $post = $CI->Post->find($id);
    return ($complete) ? base_url() . "blog/" . $post->c_url_clean . "/" . $post->url_clean : "blog/" . $post->c_url_clean . "/" . $post->url_clean;
}

if (!function_exists('url_main_img')) {

    function url_main_img($id, $b_base_url = true, $size = "normal")
    {
        $CI = &get_instance();

        $base_url = "";
        if ($b_base_url)
            $base_url = base_url();


        $post = $CI->Post->find($id);

        if ($post->path_image == "") {
            $img = "public/images/example/" . $post->image;
        } else {
            if (file_exists("public/images/example/" . $post->path_image . "/_" . $post->image)) {
                $img = "public/images/example/" . $post->path_image . "/_" . $post->image;
            } else {
                $img = "public/images/example/" . $post->path_image . "/" . $post->image;
            }
        }

        if ($size == "small") {

            if (ENVIRONMENT == 'production') {
                return $base_url . "public/images/small/article/" . $post->url_clean . '.png';
            } else {
                return img_small($img, $post->url_clean . '.png', $b_base_url);
            }
        }

        return $base_url . $img;
    }
}

if (!function_exists('img_small')) {

    function img_small($img, $name, $b_base_url)
    {
        $CI = &get_instance();
        $CI->load->library('image_lib');

        $base_url = "/";
        if ($b_base_url)
            $base_url = base_url();

        if (file_exists('public/images/small/article/' . $name)) {
            return $base_url . "public/images/small/article/" . $name;
        }

        $config['image_library'] = 'gd2';
        $config['source_image'] = $img;
        $config['new_image'] = './public/images/small/article/' . $name; //./public/images/small/article/$name;
        $config['maintain_ratio'] = TRUE;
        $config['width'] = 300;
        $config['height'] = 300;
        $CI->image_lib->clear();
        $CI->image_lib->initialize($config);
        $CI->image_lib->resize();
        return $base_url . "public/images/small/article/" . $name;
    }
}

function create_breadcrumb($action = NULL, $category = NULL, $post = NULL)
{

    $divicion = "";
    $base_url = base_url() . '';
    $breadcrumb = "<ul class='breadcrumb'>";

    $CI = &get_instance();

    if ($action == 'categoria') {
        $breadcrumb .= $divicion . "<li><a href='" . $base_url . "blog/categorias'>Categorías</a></li>";
        $breadcrumb .= $divicion . "<li><a href='#'>" . $category->name . "</a></li>";
    } else
    if ($action == 'post') {
        //***get article by theme_id
        $breadcrumb .= "<li class='breadcrumb-item'><a class='btn btn-sm btn-outline-danger' href='" . $base_url . "blog/categorias'>$divicion<span>Categorías</span></a></li>";
        $breadcrumb .= "<li class='breadcrumb-item'><a class='btn btn-sm btn-outline-danger' href='" . $base_url . "blog/$category->url_clean'>$divicion<span>" . $category->name . "</span></a></li>";
        $breadcrumb .= "<li class='breadcrumb-item' title='$post->title'><a class='btn btn-sm btn-outline-danger' href='#'>$divicion<span>" . character_limiter($post->title, 35) . "</span></a></li>";
    } else
    if ($action == 'ultimo') {
        $breadcrumb .= $divicion . "<li><a href='#'>Último en el Blog</a></li>";
    }
    $breadcrumb .= '</ul>';
    return $breadcrumb;
}

function clean_name($name)
{
    return url_title(convert_accented_characters($name), '-', TRUE);
}

function image_post($post_id)
{
    $CI = &get_instance();
    $post = $CI->Post->find($post_id);

    if ($post->path_image != "")
        $post->path_image .= "/";

    if (isset($post) && $post->image != "")
        return base_url() . "public/images/example/" . $post->path_image . $post->image;
    return base_url() . "assets/img/logo_black.png";
}

function image_category($url_clean)
{
    return base_url() . "public/images/logos/" . $url_clean . ".svg";
}

function all_images()
{
    $CI = &get_instance();
    $CI->load->helper('directory');

    $dir = "uploads/post";
    $files = directory_map($dir);

    return $files;
}

function get_all_categories()
{
    $CI = &get_instance();
    return $CI->Category->findAll();
}

if (!function_exists('create_past_article')) {

    function create_past_article($postId)
    {

        $CI = &get_instance();

        $post = $CI->Post->getBeforeById($postId);


        $url = NULL;
        $title = NULL;

        if ($postId > 1 && isset($post)) {
            $url = base_url() . 'blog/' . $post->c_url_clean . '/' . $post->url_clean;
            $title = $post->title;
        }

        return array('href' => $url, 'title' => character_limiter($title, 20));
    }
}


if (!function_exists('create_next_article')) {

    function create_next_article($postId)
    {

        $CI = &get_instance();


        $post = $CI->Post->getAfterById($postId);

        $url = NULL;
        $title = NULL;

        if ($postId > 1 && isset($post)) {
            $url = base_url() . 'blog/' . $post->c_url_clean . '/' . $post->url_clean;
            $title = $post->title;
        }

        return array('href' => $url, 'title' => character_limiter($title, 20));
    }
}

function get_filenames($source_dir, $include_path = FALSE, $_recursion = FALSE)
{
    static $_filedata = array();

    if ($fp = @opendir($source_dir)) {
        // reset the array and make sure $source_dir has a trailing slash on the initial call
        if ($_recursion === FALSE) {
            $_filedata = array();
            $source_dir = rtrim(realpath($source_dir), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
        }

        while (FALSE !== ($file = readdir($fp))) {
            if (is_dir($source_dir . $file) && $file[0] !== '.') {
                get_filenames($source_dir . $file . DIRECTORY_SEPARATOR, $include_path, TRUE);
            } elseif ($file[0] !== '.') {
                $_filedata[] = ($include_path === TRUE) ? $source_dir . $file : $file;
            }
        }

        closedir($fp);
        return $_filedata;
    }

    return FALSE;
}

if (!function_exists('html_content_format')) {

    function html_content_format($format, $data_type = null, $data_content = null, $data_category = null, $data_col = null, $data_limit = null, $data_ids, $data_not_id = null, $data_bound = null)
    {

        $CI = &get_instance();

        $articles = NULL;

        switch ($data_type) {
            case "tag":
                $articles = $CI->Post->get_by_tag_url_clean_and_c_url_clean($data_content, $data_category, $data_limit, $data_not_id, $data_ids);
                break;
            case "title":
                $articles = $CI->Post->get_by_title_and_c_url_clean(explode(',', $data_content), $data_category, $data_limit, $data_not_id, $data_ids, $data_bound);
                break;
            case "ids":
                $rids = explode(",", $data_ids);
                $articles = $CI->Post->getByIds($rids);
                break;
        }

        if ($articles !== null) {
            if ($format == 1)
                $CI->load->view('blog/articles_box_list', array("articles" => $articles, "data_col" => $data_col));
            else
                $CI->load->view('blog/articles_box_list_description', array("articles" => $articles, "data_col" => $data_col));
        }


        foreach ($articles as $key => $a) {
            url_main_img($a->post_id, true, "small");
        }
    }
}

if (!function_exists('history')) {

    function history($ids)
    {

        $CI = &get_instance();

        $rids = explode(",", $ids);

        $articles = $CI->Post->getByIds($rids);

        if ($articles !== null)
            $CI->load->view('blog/articles_history', array("articles" => $articles));

        foreach ($articles as $key => $a) {
            url_main_img($a->post_id, true, "small");
        }
    }
}
