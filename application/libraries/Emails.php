<?php

class Emails
{

    var $config;

    public function __construct()
    {
        $CI = &get_instance();
        $CI->load->library("email");

        $config['protocol'] = 'smtp';
        $config['smtp_host'] = 'smtp.ipage.com';
        $config['smtp_port'] = 25;
        $config['charset'] = 'utf-8';
        $config['mailtype'] = 'html';
        $config['smtp_user'] = 'info@desarrollolibre.net';
        $config['smtp_pass'] = 'THd4kZ73zR!Ku.!';

        $CI->email->initialize($config);
    }

    public function contact($id)
    {

        $CI = &get_instance();

        $CI->load->model('Contact');
        $contact = $CI->Contact->find($id);

        $subject = 'Contacto de ' . $contact->email;
        $data['contact'] = $contact;
        $html = $CI->load->view('email/contact', $data, TRUE);

        $pos = strrpos($contact, "???");
        if ($pos === false) {
            $this->send_email("andres29111990@gmail.com", $subject, $html);
        }
        $CI->Contact->delete($id);

        // echo $CI->email->print_debugger();
    }

    private function send_email($email, $subject, $html)
    {
        $CI = &get_instance();
        $CI->email->from('andres@desarrollolibre.net', 'Andrés');
        $CI->email->to($email);

        $CI->email->subject($subject);
        $CI->email->message($html);

        $CI->email->send();
    }
}
