<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Sitemap extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {

        $data["posts"] = $this->Post->findAll('Y');
        $data["categories"] = $this->Category->findAll();
        $data["downloads"] = $filenames = get_filenames('public/download', TRUE, FALSE);

        //var_dump($filenames); inline ../public/download local public/download

        $this->load->view('sitemap', $data);
    }

}

?>
