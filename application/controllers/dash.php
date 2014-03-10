<?php

class Dash extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('restaurant_model');
        $this->load->helper('url');
    }

    public function index()
    {
        $this->load->view('dash/index');
    }

    public function restaurants()
    {
        $data['restaurants'] = $this->restaurant_model->get_restaurants();
        $this->load->view('dash/restaurants', $data);
    }
}