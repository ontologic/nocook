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

    public function restaurants()
    {
        $this->authorize();
        $data['restaurants'] = $this->restaurant_model->get_restaurants();
        $this->load->view('dash/restaurants', $data);
    }

    private function authorize()
    {
        if (!$this->ion_auth->logged_in())
        {
            redirect('auth/login', 'refresh');
        }
        elseif (!$this->ion_auth->is_admin())
        {
            return show_error('You must be an administrator to view this page.');
        }
    }
}