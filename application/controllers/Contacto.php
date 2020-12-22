<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Contacto extends MY_Controller {

    var $controller_name = "";
    var $name = "";

    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        // cargo los modelos comunes
        $this->load->database();
    }

    public function index() {

        $data['name'] = "";
        $data['email'] = "";
        $data['message'] = "";
        $data['send'] = false;

        $view['body'] = $this->load->view('blog/utils/contact', $data, TRUE);
        $this->parser->parse("blog/template/body", $view);
    }

    public function contacto_enviado() {

        $this->load->model('Contact');
        $this->load->Library('Emails');

        $this->form_validation->set_rules('name', 'title', 'required|trim|min_length[2]|max_length[100]');
        $this->form_validation->set_rules('email', 'email', 'required|trim|min_length[10]|max_length[100]');
        $this->form_validation->set_rules('message', 'message', 'required|trim|min_length[2]|max_length[800]');

        $data['name'] = $this->input->post('name');
        $data['email'] = $this->input->post('email');
        $data['message'] = $this->input->post('message');
        $data['send'] = false;

        // verifica si es un post
        if ($this->input->server('REQUEST_METHOD') == 'POST') {

            //$this->load->library('emails');
            // obtengo los parametros del form
            $name = $this->input->post('name');
            $email = $this->input->post('email');
            $message = $this->input->post('message');

            if ($this->form_validation->run()) {
                $data['name'] = "";
                $data['email'] = "";
                $data['message'] = "";
                $data['send'] = true;

                $id = $this->Contact->save(html_escape($name), html_escape($email), html_escape($message));
                $this->emails->contact($id);
                //redirect("/contacto");
            }
        }

        $view['body'] = $this->load->view('blog/utils/contact', $data, TRUE);
        $this->parser->parse("blog/template/body", $view);
    }

}
