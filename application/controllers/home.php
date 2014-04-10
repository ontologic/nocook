<?php

class Home extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('menuitem_model');
        $this->load->model('menuitemtype_model');
        $this->load->model('restaurant_model');
        $this->load->model('order_model');
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->library('cart');
//      $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
//
//      $this->lang->load('auth');
//      $this->load->helper('language');
    }

    public function index()
    {
        $this->load->view('home/index');
    }

    public function zip()
    {
        $this->form_validation->set_rules('zip', 'Zip Code', 'required');
        $this->form_validation->set_rules('zip', 'Zip Code', 'exact_length[5]');
        if ($this->form_validation->run() === FALSE)
        {
            $this->load->view('home/zip');
            return;
        }
        else
        {
            $zip = $_POST['zip'];
            if($this->restaurant_model->does_restaurant_exist($zip))
            {
                redirect('home/menu/'.$zip);
            }
            else
            {
                echo 'No restaurant for that zip.';
                $this->load->view('home/zip');
            }
        }
    }

    public function menu($zip = '')
    {
        if($zip == '')
        {
            redirect('home/zip');
        }
        $this->form_validation->set_rules('1', '1', 'callback_order_check');
        if ($this->form_validation->run() === FALSE)
        {
            $restaurant = $this->restaurant_model->get_restaurant_by_zip($zip);
            $restaurantId = $restaurant['id'];
            $data['menu'] = $this->menuitem_model->get_menuitems($restaurantId);
            $data['menuTypes'] = $this->menuitemtype_model->get_menutypes();
            $data['restaurant'] = $this->restaurant_model->get_restaurant($restaurantId);
            $this->load->view('home/menu', $data);
        }
        else
        {
            //print_r($_POST);
            //echo '<br><br/>';
            $data = array();
            foreach ($_POST as $itemId => $quantity)
            {
                if(!is_int($itemId)){ break; }
                //echo 'q:' . $quantity . ' item:' . $itemId . '<br>';
                $menuItem = $this->menuitem_model->get_menuitem($itemId);
                //print_r($menuItem);
                $itemToAdd = array(
                    'id'      => $itemId,
                    'qty'     => $quantity,
                    'price'   => $menuItem['price'],
                    'name'    => $menuItem['name']
                );
                array_push($data, $itemToAdd);
            }
            //print_r($data);
            $this->cart->destroy();
            $this->cart->insert($data);
            //print_r($this->cart->contents());
            redirect('home/confirm');
        }
    }

    public function order_check()
    {
        $totalQuantity = 0;
        foreach ($_POST as $itemId => $quantity)
        {
            if(!is_int($itemId)){ break; }
            if($quantity < 0)
            {
                $this->form_validation->set_message('order_check', 'All quantities must be positive values.');
                return false;
            }
            $totalQuantity += $quantity;
        }
        if($totalQuantity == 0)
        {
            $this->form_validation->set_message('order_check', 'You must order at least one item.');
            return false;
        }
        return true;
    }

    public function confirm()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET')
        {
            //print_r($data);
            print_r($this->cart->contents());
            echo '<br><br>';
            echo $this->cart->total();
            echo '<form action="confirm" method="POST">';
            echo '<form action="" method="POST">
                  <script
                    src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                    data-key="pk_test_6pRNASCoBOKtIshFeQd4XMUh"
                    data-amount="'.($this->cart->total()*100).'"
                    data-name="Not Cooking Tonight"
                    data-description="$'.$this->cart->total().'"
                    data-image="../assets/img/salad.jpg">
                  </script>
                </form>';
            //echo '<input type="submit"></form>';
            echo '</form>';
        }
        else if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            //echo $_POST['stripeToken'];
            redirect('home/checkout');
        }
        else
        {
            show_404();
        }
    }

    public function checkout()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET')
        {
            echo 'order complete';
        }
        else
        {
            show_404();
        }
    }

    public function orders()
    {
        $this->load->view('home/orders');
    }
}