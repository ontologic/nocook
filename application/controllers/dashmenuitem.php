<?php

class Dashmenuitem extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('menuitem_model');

        $this->load->helper('url');
        $this->load->helper('form');

        $this->load->library('form_validation');
        $this->load->library('ion_auth');
    }

    public function create($type)
    {
        if($type == null)
        {
            show_404();
        }
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('description', 'Description', 'required');
        if ($this->form_validation->run() === FALSE)
        {
            $this->load->view('dash/menuitem/create');
        }
        else
        {
            $restaurant = $this->ion_auth->user()->row()->restaurant;
            $this->menuitem_model->insert_menuitem($restaurant, $type,
                $this->input->post('name'), $this->input->post('description'));
            redirect('dash/menu/');
        }
    }

    public function edit($id)
    {
        if($id == null)
        {
            show_404();
        }
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('description', 'Description', 'required');
        $this->form_validation->set_rules('price', 'Price', 'required');
        $this->form_validation->set_rules('price', 'Price', 'decimal');
        if ($this->form_validation->run() === FALSE)
        {
            $data['menuItem'] = $this->menuitem_model->get_menuitem($id);
            $this->load->view('dash/menuitem/edit', $data);
        }
        else
        {
            $this->menuitem_model->update_menuitem($id,
                $this->input->post('name'), $this->input->post('description'));
            redirect('dash/menu/');
        }
    }

    public function delete($id)
    {
        if($id == null)
        {
            show_404();
        }
        if (!$_POST)
        {
            $data['menuItem'] = $this->menuitem_model->get_menuitem($id);
            $this->load->view('dash/menuitem/delete', $data);
        }
        else
        {
            $this->menuitem_model->delete_menuitem($id);
            redirect('dash/menu/');
        }
    }
}