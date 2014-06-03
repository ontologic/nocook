<?php

class Dashmenu extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('menuitem_model');
        $this->load->model('menuitemtype_model');
        $this->load->model('restaurant_model');

        $this->load->helper('url');

        $this->load->library('ion_auth');
    }

    public function index()
    {
        $restaurant = $this->ion_auth->user()->row()->restaurant;
        $data['menu'] = $this->menuitem_model->get_menuitems($restaurant);
        $data['menuTypes'] = $this->menuitemtype_model->get_menutypes();
        $data['restaurant'] = $this->restaurant_model->get_restaurant($restaurant);
        $this->load->view('dash/menu/index', $data);
    }
}