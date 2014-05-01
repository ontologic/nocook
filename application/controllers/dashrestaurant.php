<?php

class Dashrestaurant extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('restaurant_model');
        $this->load->model('address_model');

        $this->load->helper('url');
        $this->load->helper('form');

        $this->load->library('ion_auth');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $this->authorize_admin();
        $data['restaurants'] = $this->restaurant_model->get_restaurants();
        $this->load->view('dash/restaurant/index', $data);
    }

    private function authorize_admin()
    {
        if (!$this->ion_auth->logged_in())
        {
            redirect('home/login', 'refresh');
        }
        else if (!$this->ion_auth->is_admin()){
            return show_error('You must be an administrator to view this page.');
        }
    }

    public function create()
    {
        $this->authorize_admin();
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('tax_percent', 'Tax Percent', 'required');
        $this->form_validation->set_rules('tax_percent', 'Tax Percent', 'decimal');
        $this->form_validation->set_rules('stripe_public_key', 'Stripe Public Key', 'required');
        $this->form_validation->set_rules('stripe_secret_key', 'Stripe Secret Key', 'required');

        $this->form_validation->set_rules('lineOne', 'Address Line One', 'required');
        $this->form_validation->set_rules('city', 'City', 'required');
        $this->form_validation->set_rules('state', 'State', 'required');
        $this->form_validation->set_rules('zip', 'Zip Code', 'required|exact_length[5]');
        $this->form_validation->set_rules('telephone', 'Telephone', 'required');
        if ($this->form_validation->run() === FALSE)
        {
            $this->load->view('dash/restaurant/create');
        }
        else
        {
            $address = $this->address_model->insert_address($this->input->post('lineOne'), $this->input->post('lineTwo'),
                $this->input->post('city'), $this->input->post('state'), $this->input->post('zip'), $this->input->post('telephone'));
            $this->restaurant_model->create_restaurant($this->input->post('name'), $address, $this->input->post('tax_percent'),
                $this->input->post('stripe_public_key'), $this->input->post('stripe_secret_key'));
            redirect('dash/restaurant/index');
        }
    }

    public function edit($id)
    {
        $this->authorize_admin();
        if($id == null)
        {
            show_404();
        }
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('tax_percent', 'Tax Percent', 'required');
        $this->form_validation->set_rules('tax_percent', 'Tax Percent', 'decimal');
        $this->form_validation->set_rules('stripe_public_key', 'Stripe Public Key', 'required');
        $this->form_validation->set_rules('stripe_secret_key', 'Stripe Secret Key', 'required');

        $this->form_validation->set_rules('lineOne', 'Address Line One', 'required');
        $this->form_validation->set_rules('city', 'City', 'required');
        $this->form_validation->set_rules('state', 'State', 'required');
        $this->form_validation->set_rules('zip', 'Zip Code', 'required|exact_length[5]');
        $this->form_validation->set_rules('telephone', 'Telephone', 'required');
        if ($this->form_validation->run() === FALSE)
        {
            $data['restaurant'] = $this->restaurant_model->get_restaurant_with_address($id);
            $this->load->view('dash/restaurant/edit', $data);
        }
        else
        {
            $this->restaurant_model->update_restaurant($id,
                $this->input->post('name'), $this->input->post('tax_percent'),
                $this->input->post('stripe_public_key'), $this->input->post('stripe_secret_key'),
                $this->input->post('lineOne'), $this->input->post('lineTwo'),
                $this->input->post('city'), $this->input->post('state'), $this->input->post('zip'), $this->input->post('telephone')
            );
            redirect('dash/restaurant/index');
        }
    }

    public function zip($id)
    {
        $this->authorize_admin();
        if($id == null)
        {
            show_404();
        }
        $this->form_validation->set_rules('zip', 'Zip Code', 'required|exact_length[5]|callback_zip_validation');
        if ($this->form_validation->run() === FALSE)
        {
            $data['zips'] = $this->restaurant_model->get_restaurant_zips($id);
            $this->load->view('dash/restaurant/zip', $data);
        }
        else
        {
            $this->restaurant_model->create_restaurant_zip($id, $this->input->post('zip'));
            redirect('dash/restaurant/zip/index/'.$id);
        }
    }

    //Form validation for order POST
    public function zip_validation()
    {
        $zip = $this->input->post('zip');
        if($this->restaurant_model->does_restaurant_exist($zip))
        {
            $this->form_validation->set_message('zip_validation', 'Zip code '.$zip.' is already assigned to another restaurant.');
            return false;
        }
        return true;
    }

    public function delete_zip($zip)
    {
        $this->authorize_admin();
        $restaurant = $this->restaurant_model->get_restaurant_by_zip($zip);
        $this->restaurant_model->delete_restaurant_zip($restaurant['id'], $zip);
        redirect('dash/restaurant/zip/index/'.$restaurant['id']);
    }
}