<?php

class Dash extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('restaurant_model');
        $this->load->helper('url');
        $this->load->library('ion_auth');
    }

    public function index()
    {
        $this->authorize();
        $this->load->view('dash/index');
    }

    private function authorize()
    {
        $dashGroups = array('admin', 'Operator');
        if (!$this->ion_auth->logged_in())
        {
            redirect('home/login', 'refresh');
        }
        else if (!$this->ion_auth->in_group($dashGroups))
        {
            return show_error('You must be an administrator to view this page.');
        }
    }
}