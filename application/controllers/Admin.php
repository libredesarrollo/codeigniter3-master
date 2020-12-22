<?php

class Admin extends MY_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->library('Form_validation');
        $this->load->library('grocery_CRUD');

        $this->load->helper('form');
        $this->load->helper('string');
        $this->load->helper('Breadcrumb_helper');

        $this->init_session_auto(9);
    }

    public function migrate_article_description_to_post() {
        $this->load->model('Article');
        $articles = $this->Article->get_all();

        for ($i = 1; $i < count($articles); $i++) {
            $save = array(
                "description" => $articles[$i]->description,
            );

            $this->Post->update($articles[$i]->id, $save);
        }
    }

    /*  public function migrate_article_to_post(){
      $this->load->model('article');
      $articles = $this->article->get_all();

      for($i=309; $i<count($articles); $i++){
      $save = array(
      "post_id" => $articles[$i]->id,
      "url_clean" => $articles[$i]->url_clean,
      "title" => $articles[$i]->title,
      "content" => $articles[$i]->body,
      "category_id" => $articles[$i]->category_id,
      "title" => $articles[$i]->title,
      "description" => $articles[$i]->description,
      "created_at" => $articles[$i]->date,
      "date" => $articles[$i]->date,
      "web_content" => $articles[$i]->web_content,
      "path_image" => $articles[$i]->path_img,
      "description" => $articles[$i]->description,
      "image" => $articles[$i]->main_img,
      'posted' => 'si'
      );

      $this->Post->insert($save);
      }
      } */

    public function index() {
        redirect('admin/post_list');
    }

    public function user_crud() {
        $crud = new grocery_CRUD();

        $crud->set_theme('bootstrap-v4');
        $crud->set_table('users');
        $crud->set_subject('Usuario');

        $crud->where("auth_level", 9);

        $state = $crud->getState();

        $crud->columns('username', 'email', 'avatar');

        // editando el registro
        if ($state == 'edit' || $state == 'update' || $state == 'update_validation') {
            $crud->fields('auth_level', 'created_at', 'user_id', 'avatar');
        } else {
            $crud->fields('auth_level', 'created_at', 'user_id', 'username', 'email', 'passwd', 'avatar');
            $crud->set_rules('email', 'email', 'required|valid_email|is_unique[' . config_item('user_table') . '.email]');
            $crud->set_rules('username', 'Usuario', 'max_length[50]|is_unique[' . config_item('user_table') . '.username]|required');
            $crud->set_rules('passwd', 'Contraseña', 'min_length[8]|required|max_length[72]|callback_validate_passwd');
        }

        $crud->callback_before_insert(array($this, 'user_before_insert_callback'));
        $crud->callback_after_upload(array($this, 'user_after_upload_callback'));

        $crud->display_as('passwd', 'Contraseña');
        $crud->display_as('username', 'Usuario');

        $crud->field_type('auth_level', 'hidden');
        $crud->field_type('created_at', 'hidden');
        $crud->field_type('user_id', 'hidden');
        $crud->field_type('passwd', 'password');
        $crud->set_field_upload('avatar', 'uploads/user', 'png|jpg');

        $crud->unset_jquery();
        $crud->unset_clone();
        $crud->unset_read();

        $output = $crud->render();
        $view["grocery_crud"] = json_encode($output);
        $view['breadcrumb'] = breadcrumb_admin("users");
        $view["title"] = "Usuario";
        $this->parser->parse("admin/template/body", $view);
    }

    /*     * ***
     * CRUD PARA LOS POST
     */

    public function post_list() {

        $crud = new grocery_CRUD();

        $crud->set_theme('bootstrap-v4');
        $crud->set_table('posts');
        $crud->set_subject('Post');
        $crud->columns('post_id', 'title', 'description', 'created_at', 'posted', 'Opciones');

        $crud->callback_before_insert(array($this, 'category_iu_before_callback'));
        $crud->callback_before_update(array($this, 'category_iu_before_callback'));

        $crud->set_rules('name', 'Nombre', 'required|min_length[10]|max_length[100]');

        $crud->callback_column('Opciones', array($this, 'articles_options'));

        $crud->order_by('post_id', 'desc');

        $crud->unset_jquery();
        $crud->unset_add();
        $crud->unset_clone();
        $crud->unset_read();
        $crud->unset_edit();

        $crud->add_action('Editar', '', 'admin/post_save', 'edit-icon');

        $output = $crud->render();
        $view["body"] = '<a class="mb-3 btn btn-success btn-sm" href="' . base_url() . 'admin/post_save"><i class="fa fa-plus"></i> Crear</a>';
        $view["grocery_crud"] = json_encode($output);
        $view['breadcrumb'] = breadcrumb_admin("posts");
        $view["title"] = "Posts";
        $this->parser->parse("admin/template/body", $view);
    }

    public function post_save($post_id = null) {

        if ($post_id == null) {
            // crear post
            $data['web_content'] = $data['final_content'] = $data['date'] = $data['path_image'] = $data['category_id'] = $data['title'] = $data['image'] = $data['content'] = $data['description'] = $data['posted'] = $data['url_clean'] = "";
            $view["title"] = "Crear Post";
        } else {
            // edicion post
            $post = $this->Post->find($post_id);
            if (!isset($post)) {
                show_404();
            }

            $data['title'] = $post->title;
            $data['content'] = str_replace("<p>&nbsp;</p>", "", $post->content);
            $data['web_content'] = $post->web_content;
            $data['final_content'] = $post->final_content;
            $data['description'] = $post->description;
            $data['posted'] = $post->posted;
            $data['url_clean'] = $post->url_clean;
            $data['image'] = $post->image;
            $data['path_image'] = $post->path_image;
            $data['category_id'] = $post->category_id;
            $data['date'] = $post->date;
            $data['post'] = $post;
            $view["title"] = "Actualizar Post";
        }

        // para el listado de categorias
        $data['categories'] = categories_to_form($this->Category->findAll());

        if ($this->input->server('REQUEST_METHOD') == "POST") {

            $this->form_validation->set_rules('title', 'Título', 'required|min_length[10]|max_length[165]');
            $this->form_validation->set_rules('content', 'Contenido', 'required|min_length[10]');
            $this->form_validation->set_rules('description', 'Descripción', 'max_length[300]');
            $this->form_validation->set_rules('posted', 'Descripción', 'required');

            $data['title'] = $this->input->post("title");
            $data['content'] = $this->input->post("content");
            $data['web_content'] = $this->input->post("web_content");
            $data['final_content'] = $this->input->post("final_content");
            $data['description'] = $this->input->post("description");
            $data['posted'] = $this->input->post("posted");
            $data['url_clean'] = $this->input->post("url_clean");

            if ($this->form_validation->run()) {
                // nuestro form es valido

                $url_clean = $this->input->post("url_clean");

                if ($url_clean == "") {
                    $url_clean = clean_name($this->input->post("title"));
                }

                $save = array(
                    'title' => $this->input->post("title"),
                    'content' => $this->input->post("content"),
                    'path_image' => $this->input->post("path_image"),
                    'web_content' => $this->input->post("web_content"),
                    'description' => $this->input->post("description"),
                    'posted' => $this->input->post("posted"),
                    'category_id' => $this->input->post("category_id"),
                    'date' => $this->input->post("date"),
                    'final_content' => $this->input->post("final_content"),
                    'url_clean' => $url_clean
                );

                if ($post_id == null)
                    $post_id = $this->Post->insert($save);
                else {
                    $this->Post->update($post_id, $save);
                    $this->output->delete_cache('/blog/' . $post->c_url_clean . '/' . $post->url_clean);
                }

                $post = $this->Post->find($post_id);

                $this->upload($post_id, true, $this->input->post("title"));

                redirect("admin/post_save/$post_id");
            }
        }

        $data["data_posted"] = posted();
        $view['breadcrumb'] = breadcrumb_admin("posts");
        $view["body"] = $this->load->view("admin/post/save", $data, TRUE);

        $this->parser->parse("admin/template/body", $view);
    }

    public function post_delete($post_id = null) {
        if ($post_id == null) {
            echo 0;
        } else {
            $this->Post->delete($post_id);
            echo 1;
        }
    }

    /*     * ***
     * CRUD PARA LOS CATEGORY
     */

    public function category_crud() {

        $crud = new grocery_CRUD();

        $crud->set_theme('bootstrap-v4');
        $crud->set_table('categories');
        $crud->set_subject('Categoria');
        $crud->columns('category_id', 'name');
        $crud->fields('name', 'url_clean','body');

        $crud->callback_before_insert(array($this, 'category_iu_before_callback'));
        $crud->callback_before_update(array($this, 'category_iu_before_callback'));

        $crud->set_rules('name', 'Nombre', 'required|min_length[3]|max_length[100]');

        $crud->unset_texteditor('body');

        $crud->unset_jquery();
        $crud->unset_clone();
        $crud->unset_read();
        //$crud->field_type('url_clean', 'hidden');

        $output = $crud->render();
        $view["grocery_crud"] = json_encode($output);
        $view['breadcrumb'] = breadcrumb_admin("categories");
        $view["title"] = "Categories";
        $this->parser->parse("admin/template/body", $view);
    }

    /*     * ***
     * CRUD PARA LOS TAGS
     */

    public function tag_crud() {

        $crud = new grocery_CRUD();

        $crud->set_theme('bootstrap-v4');
        $crud->set_table('tags');
        $crud->set_subject('Tags');
        $crud->columns('tag_id', 'name');

        $crud->callback_before_insert(array($this, 'category_iu_before_callback'));
        $crud->callback_before_update(array($this, 'category_iu_before_callback'));

        $crud->set_rules('name', 'Nombre', 'required|min_length[3]|max_length[100]');
       // $crud->set_field_upload('image', 'uploads/category');

        $crud->unset_jquery();
        $crud->unset_clone();
        $crud->unset_read();

        $output = $crud->render();
        $view["grocery_crud"] = json_encode($output);
        $view['breadcrumb'] = breadcrumb_admin("tags");
        $view["title"] = "Tags";
        $this->parser->parse("admin/template/body", $view);
    }

    public function tags($id) {

        if (!isset($id)) {
            show_404();
            return;
        }

        //*** load the model and get theme
        $post = $data['post'] = $this->Post->find($id);

        if (!isset($post)) {
            show_404();
            return;
        }

        $data['tags'] = $this->Tag->getAll();
        $data['my_tags'] = $this->Post_tag->getByPostId($id);
        $data['post_id'] = $id;

        $view["body"] = $this->load->view('admin/post/tags', $data, TRUE);
        $view['breadcrumb'] = breadcrumb_admin("tags");
        $view["title"] = "Tags";
        $this->parser->parse("admin/template/body", $view);
    }

    function tag_add() {

        // data form
        $articleId = $this->input->get_post('post_id');
        $tagId = $this->input->get_post('tag_id');

        // add the tag to the article
        $this->Post_tag->tagAdd($articleId, $tagId);
    }

    function tag_remove() {

        // data form
        $articleId = $this->input->get_post('post_id');
        $tagId = $this->input->get_post('tag_id');

        // add the tag to the article
        $this->Post_tag->tagRemove($articleId, $tagId);
    }

    public function category_delete($category_id = null) {
        if ($category_id == null) {
            echo 0;
        } else {
            $this->Category->delete($category_id);
            echo 1;
        }
    }

    function images_server() {
        $data["images"] = all_images();
        $this->load->view("admin/post/image", $data);
    }

    function upload($post_id = null, $primary = true, $title = null) {

        $image = "upload";

        if ($post_id == null) {
            return;
        }

        $post = $this->Post->find($post_id);

        if ($title != null)
            $title = clean_name($title);

        // configuraciones de carga
        $config['upload_path'] = 'public/images/example/' . $post->path_image;
        if ($title != null)
            $config['file_name'] = $title;
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = 5000;
        $config['overwrite'] = TRUE;

        //cargamos la libreria
        $this->load->library('upload', $config);

        if ($this->upload->do_upload($image)) {
            // se cargo la imagen
            // datos del upload
            $data = $this->upload->data();

            if ($title != null && $post_id != null) {
                $save = array(
                    'image' => $title . $data["file_ext"]
                );
                if ($primary)
                    $this->Post->update($post_id, $save);
            } else {
                $title = $data["file_name"];
                echo json_encode(array("fileName" => $title, "uploaded" => 1, "url" => "/" . 'public/images/example/' . $post->path_image . "/" . $title));
            }

            $this->resize_image($data['full_path']);
        } else if (!empty($_FILES[$image]['name'])) {
            //echo $this->upload->display_errors();
            $this->session->set_flashdata('text', $this->upload->display_errors());
            $this->session->set_flashdata('type', 'danger');
        }
    }

    public function jobs_crud() {

        try {
            $crud = new grocery_CRUD();

            $crud->set_theme('bootstrap-v4');
            $crud->set_table('jobs');
            $crud->set_subject('Portafolio');

            $crud->edit_fields('name');
            $crud->columns('job_id', 'name', 'description', 'image', 'date');
            $crud->fields('name', 'description', 'image', 'date');

            if (ENVIRONMENT == "development") {
                $crud->set_field_upload('image', 'uploads/portafolio', 'png|jpg|gif');
            } else {
                
            }

            $crud->unset_texteditor('description', 'full_text');
            $crud->unset_delete();
            $crud->unset_read();
            $crud->unset_bootstrap();
            $crud->unset_jquery();

            $output = $crud->render();
            $view["grocery_crud"] = json_encode($output);
            $view['breadcrumb'] = breadcrumb_admin("jobs");
            $view["title"] = "Jobs";
            $this->parser->parse("admin/template/body", $view);
        } catch (Exception $e) {
            show_error($e->getMessage() . ' --- ' . $e->getTraceAsString());
        }
    }

    public function courses_crud() {

        try {
            $crud = new grocery_CRUD();

            $crud->set_theme('bootstrap-v4');
            $crud->set_table('courses');
            $crud->set_subject('Cursos');

            $crud->edit_fields('name');
            $crud->columns('course_id', 'name', 'image', 'date', 'post_id');
            $crud->fields('name', 'description', 'image', 'post_id');
            
            $crud->display_as('post_id', 'Post');
            $crud->display_as('course_id', 'Course');

            $crud->set_relation('post_id', 'posts', 'title');

            $crud->set_field_upload('image', 'uploads/course', 'png|jpg|gif');
            $crud->callback_after_upload(array($this, 'courses_callback_after_upload'));

            $crud->unset_texteditor('description', 'full_text');
            $crud->unset_delete();
            $crud->unset_read();
            $crud->unset_bootstrap();
            $crud->unset_jquery();

            $output = $crud->render();
            $view["grocery_crud"] = json_encode($output);
            $view['breadcrumb'] = breadcrumb_admin("jobs");
            $view["title"] = "Cursos";
            $this->parser->parse("admin/template/body", $view);
        } catch (Exception $e) {
            show_error($e->getMessage() . ' --- ' . $e->getTraceAsString());
        }
    }

    function resize_image($path_image) {
        $config['image_library'] = 'gd2';
        $config['source_image'] = $path_image;
        $config['maintain_ratio'] = TRUE;
        $config['width'] = 1500;
        $config['height'] = 800;

        $this->load->library('image_lib', $config);

        $this->image_lib->resize();
    }

    function create_path() {

        $path = $this->input->get('path_img');
        $id = $this->input->get('id');

        $this->create_path_move_file($path, $id);
    }

    private function create_path_move_file($path, $id) {

        $post = null;
        if ($id)
            $post = $this->Post->find($id);

        $msj = "";
        if (isset($path) && $path !== "") {
            $msj = $this->create_dir($path);

            if ($post && $post->image != "" && $post->path_image != "" && $post->path_image != $path) {
                $root_dir = 'public/images/example/';
                if (!rename($root_dir . $post->path_image . '/' . $post->image, $root_dir . $path . '/' . $post->image)) {
                    $msj .= "\nError al mover $post->image";
                }
            }

            $save = array(
                'path_image' => $path
            );

            if ($id)
                $this->Post->update($id, $save);
        } else {
            $msj = "El path no es valido";
        }
//        echo $msj;
    }

    private function create_dir($dir) {
        $dir = 'public/images/example/' . $dir;

        //if not exist, create the dir
        if (!is_dir($dir)) {
            mkdir($dir, 0755, TRUE);
            $msj = "path creado";
        } else {
            $msj = "path ya existe";
        }
        return $msj;
    }

    public function contact() {

        try {
            $crud = new grocery_CRUD();
            $crud->set_theme('bootstrap-v4');

            $crud->order_by('date', 'desc');

            $crud->set_table('contacts');
            $crud->set_subject('Contactos');

            $crud->columns('contact_id', 'name', 'email', 'message', 'date');

            $crud->display_as('contact_id', 'Id');
            $crud->display_as('name', 'Nombre');
            $crud->display_as('message', 'Mensaje');
            $crud->display_as('date', 'Fecha');

            $crud->unset_bootstrap();
            $crud->unset_add();
            $crud->unset_edit();
            $crud->unset_jquery();

            $output = $crud->render();
            $view["grocery_crud"] = json_encode($output);
            $view['breadcrumb'] = breadcrumb_admin("jobs");
            $view["title"] = "Cursos";
            $this->parser->parse("admin/template/body", $view);
        } catch (Exception $e) {
            show_error($e->getMessage() . ' --- ' . $e->getTraceAsString());
        }
    }

    /*     * *************
      Calback
     * */

    function category_iu_before_callback($post_array, $pk = null) {
        if ($post_array['url_clean'] == "") {
            $post_array['url_clean'] = clean_name($post_array["name"]);
        }

        return $post_array;
    }

    function user_before_insert_callback($post_array) {
        $post_array['passwd'] = $this->authentication->hash_passwd($post_array['passwd']);
        $post_array['user_id'] = $this->User->get_unused_id();
        $post_array['created_at'] = date('Y-m-d H:i:s');
        $post_array['auth_level'] = 9;

        return $post_array;
    }

    function user_after_upload_callback($uploader_response, $field_info, $files_to_upload) {
        $this->load->library('Image_moo');
        //Is only one file uploaded so it ok to use it with $uploader_response[0].
        $file_uploaded = $field_info->upload_path . '/' . $uploader_response[0]->name;
        $this->image_moo->load($file_uploaded)->resize(500, 500)->save($file_uploaded, true);

        return true;
    }

    function portafolio_tag_callback_url($value, $row) {
        $href = base_url() . 'admin/portafolio_tags/' . $row->job_id;
        return "<a href='$href'><i class='fa fa-eye'></i></a>";
    }

    function articles_options($value, $row) {

        $href = base_url() . 'admin/tags/' . $row->post_id;

        $tag = "<div class='actions'>";
        $tag .= "<a class='btn btn-default mr-1' data-toggle='tooltip' data-placement='top' data-original-title='Tags' target='_blank' href='" . base_url() . "admin/tags/$row->post_id'><i class='fa fa-tags'></i></a>";
//        $tag .= "<a class='btn btn-default mr-1' data-toggle='tooltip' data-placement='top' data-original-title='tweets' target='_blank' href='" . base_url() . "admin/article_tweets/$row->post_id'><i class='fa fa-twitter'></i></a>";
        $tag .= "<a class='btn btn-default' data-toggle='tooltip' data-placement='top' data-original-title='Ver' target='_blank' href='" . base_url() . "blog/tema/$row->post_id'><i class='fa fa-eye'></i></a>";
        $tag . "</div>";

        return $tag;
    }

    function post_display_blog($format=1) {

        $data_type = $this->input->get('data_type') == "" ? null : $this->input->get('data_type');
        $data_content = $this->input->get('data_content') == "" ? null : $this->input->get('data_content');
        $data_category = $this->input->get('data_category') == "" ? null : $this->input->get('data_category');
        $data_col = $this->input->get('data_col') == "" ? null : $this->input->get('data_col');
        $data_limit = $this->input->get('data_limit') == "" ? null : $this->input->get('data_limit');
        $data_not_id = $this->input->get('data_not_id') == "" ? null : $this->input->get('data_not_id');
        $data_ids = $this->input->get('data_ids') == "" ? null : $this->input->get('data_ids');
        $data_bound = $this->input->get('data_bound') == "" ? null : $this->input->get('data_bound');

        return html_content_format($format,
                $data_type, $data_content, $data_category, $data_col, $data_limit, $data_ids, $data_not_id, $data_bound);
    }

    function history_blog(){
        
        $ids = $this->input->get('ids');

        return history($ids);
    }

    function courses_callback_after_upload($uploader_response, $field_info, $files_to_upload) {
        $this->load->library('image_moo');

        //Is only one file uploaded so it ok to use it with $uploader_response[0].
        $file_uploaded = $field_info->upload_path . '/' . $uploader_response[0]->name;

        $this->image_moo->load($file_uploaded)->resize(700, 600)->save($file_uploaded, true);

        return true;
    }

}
