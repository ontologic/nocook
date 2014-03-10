<?php

class Menuitem extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('menuitem_model');
        $this->load->helper('url');
    }

    public function create($restaurant, $type)
    {
        if($restaurant == null || $type == null)
        {
            show_404();
        }
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('description', 'Description', 'required');
        if ($this->form_validation->run() === FALSE)
        {
            $this->load->view('dash/menuitem/create');
        }
        else
        {
            $this->menuitem_model->insert_menuitem($restaurant, $type,
                $this->input->post('name'), $this->input->post('description'));
            redirect('menu/index/'.$restaurant);
        }
    }

    public function edit($id)
    {
        if($id == null)
        {
            show_404();
        }
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('description', 'Description', 'required');
        if ($this->form_validation->run() === FALSE)
        {
            $data['menuItem'] = $this->menuitem_model->get_menuitem($id);
            $this->load->view('dash/menuitem/edit', $data);
        }
        else
        {
            $this->menuitem_model->update_menuitem($id,
                $this->input->post('name'), $this->input->post('description'));
            redirect('menu/index/'.'1');
        }
    }
}