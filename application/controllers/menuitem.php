<?php

class Menuitem extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('menuitem_model');
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('form_validation');
    }

    public function create($restaurant, $type)
    {
        if($restaurant == null || $type == null)
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
            //TODO: redirect to restaurant that owns item
            redirect('menu/index/'.'1');
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
            //TODO: redirect to restaurant that owns item
            redirect('menu/index/'.'1');
        }
    }
}