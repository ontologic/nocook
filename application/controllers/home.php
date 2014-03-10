<?php

class Home extends CI_Controller {

    function __construct()
    {
        parent::__construct();
//        $this->load->library('ion_auth');
//        $this->load->library('form_validation');
        $this->load->helper('url');
//        $this->load->helper("navigation_helper");
//
//        $this->load->database();
//
//        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
//
//        $this->lang->load('auth');
//        $this->load->helper('language');
    }

    public function index()
    {
        $this->load->view('home/index');
    }

    public function menu()
    {
        $this->load->view('home/menu');
    }

    public function orders()
    {
        $this->load->view('home/orders');
    }
}