<?php

class Blog extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->optional_session_auto(1);
    }

    public function tema($postId = null)
    {
        $post = $this->Post->find($postId);

        if (!isset($post))
            show_404();

        redirect("blog/$post->c_url_clean/$post->url_clean", "location", 301);
    }

    /*     * **********************************REDIRECCIONES */

    public function index($num_page = 1)
    {

        $num_page--;
        $num_post = $this->Post->count();
        $last_page = ceil($num_post / PAGE_SIZE);

        if ($num_page < 0) {
            $num_page = 0;
        } elseif ($num_page > $last_page) {
            // TODO
            $num_page = 0;
        }

        $offset = $num_page * PAGE_SIZE;

        $data = $this->build_header();

        $data['last_page'] = $last_page;
        $data['current_page'] = $num_page;
        $data['token_url'] = 'blog/';
        $data['posts'] = $this->Post->getPagination($offset);
        $data['last_page'] = $last_page;
        $data['pagination'] = true;
        $view['body'] = $this->load->view("blog/utils/post_list", $data, TRUE);
        $this->parser->parse("blog/template/body", $view);
    }

    public function tags($url_clean, $num_page = 1)
    {

        $tag = $this->Tag->findUrl_clean($url_clean);

        if (!$tag)
            show_404();

        $num_page--;
        $num_post = count($this->Post_tag->getPostByTagId($tag->tag_id));
        $last_page = ceil($num_post / PAGE_SIZE);

        if ($num_page < 0) {
            $num_page = 0;
        } elseif ($num_page > $last_page) {
            // TODO
            $num_page = 0;
        }

        $offset = $num_page * PAGE_SIZE;

        $data = $this->build_header();

        $data['last_page'] = $last_page;
        $data['current_page'] = $num_page;
        $data['token_url'] = 'blog/' . $url_clean . '/';
        $data['posts'] = $this->Post_tag->getPostByTagIdPagination($offset, $tag->tag_id);
        $data['last_page'] = $last_page;
        $data['pagination'] = true;
        $view['body'] = $this->load->view("blog/utils/post_list", $data, TRUE);
        $this->parser->parse("blog/template/body", $view);
    }

    public function category_detail($c_clean_url)
    {

        if (count($this->uri->segments) < 2) {
            redirect("blog/$c_clean_url", "location", 301);
        }

        $category = $this->Category->GetByUrlClean($c_clean_url);

        if (!isset($category)) {
            show_404();
        }

        if ($category->body == "") {
            redirect("/blog/$c_clean_url/1", "location", 301);
        }

        $view['body'] = $this->load->view("blog/utils/category_detail", ["category" => $category], TRUE);
        $this->parser->parse("blog/template/body", $view);
    }

    // list

    public function category($c_clean_url, $num_page = 1)
    {

        $category = $this->Category->GetByUrlClean($c_clean_url);

        if (!isset($category)) {
            show_404();
        }

        $num_page--;
        $num_post = $this->Post->countByCUrlClean($c_clean_url);
        $last_page = ceil($num_post / PAGE_SIZE);

        if ($num_page < 0 || $num_page > $last_page) {
            redirect('/blog/category' . $c_clean_url, "location", 301);
        }

        $offset = $num_page * PAGE_SIZE;

        $data = $this->build_header();

        $data['last_page'] = $last_page;
        $data['current_page'] = $num_page;
        $data['token_url'] = 'blog/' . $c_clean_url . '/';
        $data['posts'] = $this->Post->getPagination($offset, 'Si', 'desc', $c_clean_url);
        $data['last_page'] = $last_page;
        $data['pagination'] = true;
        $view['body'] = $this->load->view("blog/utils/post_list", $data, TRUE);
        $this->parser->parse("blog/template/body", $view);
    }

    public function categories()
    {

        $data['categories'] = $this->Category->findAll();
     //   var_dump($data['categories']);
        $view['body'] = $this->load->view("blog/utils/category/categories", $data, TRUE);
        $this->parser->parse("blog/template/body", $view);
    }

    public function post_view($c_clean_url, $clean_url = null)
    {

        if (ENVIRONMENT === 'production')
            $this->output->cache(PAGE_CACHE);

        if (strpos($this->uri->uri_string(), 'blog/post_view') !== false)
            show_404();

        if (!isset($clean_url)) {
            show_404();
        }

        $post = $this->Post->GetByUrlClean($clean_url);

        if (!isset($post)) {
            show_404();
        }

        $category = $this->Category->GetByUrlClean($c_clean_url);

        if (!isset($category)) {
            show_404();
        }

        $this->load->model('Course');

        $cources = $this->Course->findByCategoryIdAndDistintPost($post->category_id, $post->post_id);

        $data = $this->build_header(APP_NAME . ' ' . $post->title, $post->description, PROJECT_IMAGE_POST . $post->image, base_url() . $post->url_clean);

        $data["imgurl"] = url_main_img($post->post_id);
        $data["title"] = str_replace('"', '\'', $post->title);
        $data["desc"] = str_replace('"', '\'', $post->description);
        $data["url"] = base_url() . 'blog/' . $post->c_url_clean . '/' . $post->url_clean;

        $data['post'] = $post;
        $data['cources'] = $cources;
        //var_dump($cources);
        $data['category'] = $category;
        $data["tags"] = $this->Post_tag->getByPostId($post->post_id);

        $view["schema"] = $this->load->view("blog/utils/schema/post", ['post' => $post], TRUE);

        $view['body'] = $this->load->view("blog/utils/post_detail", $data, TRUE);
        $this->parser->parse("blog/template/body", $view);

        //if (ENVIRONMENT === 'production')
    }

    public function search()
    {

        $search = $this->input->get_post("search");
        $category_id = $this->input->get_post("category_id");

        if ($search == "") {
            return "";
        }

        $searchs = explode(" ", $search);
        $posts = $this->Post->getBySearch($searchs, $category_id);
        $data['posts'] = $posts;
        $data['pagination'] = false;
        $this->load->view("blog/utils/post_list", $data);
    }

    /*
     * create channel rss
     */

    public function rss()
    {

        //***upload model
        $this->load->model('article', '', TRUE);
        $this->load->model('category', '', TRUE);

        //***get last articles
        $data_rss["posts"] = $this->Post->getPagination(30);

        $this->load->view('blog/rss', $data_rss);
    }

    /**/

    private function build_header($title = '', $description = '', $imgurl = '', $url = '')
    {
        $data['title'] = $title;
        $data['desc'] = $description;
        $data['imgurl'] = $imgurl;
        $data['url'] = $url;

        return $data;
    }
}
