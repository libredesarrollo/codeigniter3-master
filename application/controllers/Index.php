<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->optional_session_auto(1);
    }

    public function index() {

        $data["keywords"] = "";
        $data["desc"] = "DesarrolloLibre - Desarrollo de aplicaciones web con CSS, HTML, JavaScript y jQuery, desarrollo de apps Android, ListView, RecycleView, notificaciones desarrollo de componentes, desarrollo con Kotlin y Java.";
        $data["imgurl"] = "";
        $data["title"] = "DesarrolloLibre - Desarrollo de aplicaciones web [CSS, HTML, JavaScript, jQuery] y apps Android";
        $data["url"] = base_url();
        $data["schema"] = $this->load->view("blog/utils/schema/default",NULL, TRUE);
        $dataInicio = [];

        $data['body'] = $this->load->view('presentation', $dataInicio, TRUE);
        $this->parser->parse('blog/template/body', $data);
    }

    public function acerca_de() {

        if ($this->uri->uri_string() == 'index/acerda_de')
            show_404();

        $data["title"] = "Acerca de";
        $data["keywords"] = "";
        $data["desc"] = "Acerca de";
        $data["imgurl"] = "";
        $data["title"] = " Acerca de - Blog - [Desarrollo Libre]";
        $data["url"] = "acerda_de";

        $data['body'] = $this->load->view('about', NULL, TRUE);
        $this->parser->parse('blog/template/body', $data);
    }

    public function trabajos() {

        $this->load->model('Job');

        $data['proyects'] = $this->Job->findAll();

        $data["desc"] = "Portafolio de desarrollo de software";
        $data["imgurl"] = "";
        $data["title"] = "Portafolio - Blog - [Desarrollo Libre]";
        $data["url"] = base_url() . "trabajos";

        $view['body'] = $this->load->view('blog/utils/jobs', $data, TRUE);

        $this->parser->parse("blog/template/body", $view);
    }

    public function cursos() {

        $this->load->model('Course');

        $data['courses'] = $this->Course->findAll();

        $data["desc"] = "Cursos de desarrollo de software";
        $data["imgurl"] = base_url() . "uploads/course/0c029-imagen_promosional3.png";
        $data["title"] = "Cursos - Blog - [Desarrollo Libre]";
        $data["url"] = base_url() . "cursos";

        $view['body'] = $this->load->view('blog/utils/courses', $data, TRUE);

        $this->parser->parse("blog/template/body", $view);
    }

}
