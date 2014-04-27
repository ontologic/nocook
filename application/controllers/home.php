<?php

class Home extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('menuitem_model');
        $this->load->model('menuitemtype_model');
        $this->load->model('restaurant_model');
        $this->load->model('address_model');
        $this->load->model('order_model');
        $this->load->model('gift_model');

        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->helper('language');

        $this->load->library('form_validation');
        $this->load->library('cart');
        $this->load->library('session');
        $this->load->library('ion_auth');

        $this->lang->load('auth');

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
        $this->form_validation->set_rules('zip', 'Zip Code', 'required|exact_length[5]');
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
        if(!$this->restaurant_model->does_restaurant_exist($zip))
        {
            redirect('home/zip');
        }
        $restaurantId = $this->get_restaurant_id($zip);
        $data['menu'] = $this->menuitem_model->get_menuitems($restaurantId);
        $data['menuTypes'] = $this->menuitemtype_model->get_menutypes_with_prices($restaurantId);
        $data['restaurant'] = $this->restaurant_model->get_restaurant($restaurantId);
        $data['zip'] = $zip;
        $this->load->view('home/menu', $data);
    }

    private function get_restaurant_id($zip)
    {
        $restaurant = $this->restaurant_model->get_restaurant_by_zip($zip);
        $restaurantId = $restaurant['id'];
        return $restaurantId;
    }

    public function order($zip = '')
    {
        if($zip == '')
        {
            redirect('home/zip');
        }
        //TODO: figure out how to do this!
        $this->form_validation->set_rules('1', '1', 'callback_order_validation');
        if ($this->form_validation->run() === FALSE)
        {
            $restaurantId = $this->get_restaurant_id($zip);
            $data['menu'] = $this->menuitem_model->get_menuitems($restaurantId);
            $data['menuTypes'] = $this->menuitemtype_model->get_menutypes_with_prices($restaurantId);
            $data['restaurant'] = $this->restaurant_model->get_restaurant($restaurantId);
            $this->load->view('home/order', $data);
        }
        else
        {
            $restaurant = $this->restaurant_model->get_restaurant_by_zip($zip);
            $this->session->set_userdata('restaurant', $restaurant);
            $this->session->set_userdata('is_gift', false);
            $data = array();
            foreach ($_POST as $itemId => $quantity)
            {
                //echo 'q:' . $quantity . ' item:' . $itemId . '<br>';
                $menuItem = $this->menuitem_model->get_menuitem_with_price($itemId);
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
            redirect('home/delivery');
        }
    }

    //Form validation for order POST
    public function order_validation()
    {
        $totalQuantity = 0;
        foreach ($_POST as $itemId => $quantity)
        {
            if(!is_int($itemId)){ break; }
            if($quantity < 0)
            {
                $this->form_validation->set_message('order_validation', 'All quantities must be positive values.');
                return false;
            }
            $totalQuantity += $quantity;
        }
        if($totalQuantity == 0)
        {
            $this->form_validation->set_message('order_validation', 'You must order at least one item.');
            return false;
        }
        return true;
    }

    public function gift($zip = '')
    {
        if($zip == '')
        {
            redirect('home/zip');
        }
        $this->form_validation->set_rules('1', '1', 'callback_order_validation');
        if ($this->form_validation->run() === FALSE)
        {
            $restaurantId = $this->get_restaurant_id($zip);
            $data['menu'] = $this->menuitem_model->get_menuitems($restaurantId);
            $data['menuTypes'] = $this->menuitemtype_model->get_menutypes_with_prices($restaurantId);
            $data['restaurant'] = $this->restaurant_model->get_restaurant($restaurantId);
            $this->load->view('home/gift', $data);
        }
        else
        {
            $restaurant = $this->restaurant_model->get_restaurant_by_zip($zip);
            $this->session->set_userdata('restaurant', $restaurant);
            $this->session->set_userdata('is_gift', true);
            $data = array();
            foreach ($_POST as $itemId => $quantity)
            {
                //echo 'q:' . $quantity . ' item:' . $itemId . '<br>';
                $menuItem = $this->menuitem_model->get_menuitem_with_price($itemId);
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

    //Form validation for order POST
    public function gift_validation()
    {
        $totalQuantity = 0;
        foreach ($_POST as $itemId => $quantity)
        {
            if(!is_int($itemId)){ break; }
            if($quantity < 0)
            {
                $this->form_validation->set_message('gift_validation', 'All quantities must be positive values.');
                return false;
            }
            $totalQuantity += $quantity;
        }
        if($totalQuantity == 0)
        {
            $this->form_validation->set_message('order_validation', 'You must order at least one item.');
            return false;
        }
        return true;
    }

    public function delivery()
    {
        $this->form_validation->set_rules('lineOne', 'Address Line One', 'required');
        $this->form_validation->set_rules('city', 'City', 'required');
        $this->form_validation->set_rules('state', 'State', 'required');
        $this->form_validation->set_rules('zip', 'Zip Code', 'required|exact_length[5]');
        $this->form_validation->set_rules('telephone', 'Telephone', 'required');
        if ($this->form_validation->run() === FALSE)
        {
            $this->load->view('home/delivery');
            return;
        }
        else
        {
            $this->session->set_userdata('delivery', $_POST);
            redirect('home/confirm');
        }
    }

    public function confirm()
    {
        //TODO: handle this if navigating directly to confirm?
        $is_gift = $this->session->userdata('is_gift');
        if ($_SERVER['REQUEST_METHOD'] === 'GET')
        {
            if(!$is_gift)
            {
                $deliveryData = $this->session->userdata('delivery');
                print_r($deliveryData);
                echo '<br><br>';
            }
            //print_r($data);
            print_r($this->cart->contents());
            echo '<br><br>';
            echo $this->cart->total();
            echo '<form action="confirm" method="POST">';
            echo '<form action="" method="POST">
                  <script
                    src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                    data-key="pk_test_NFIOMm4WLLZSkhEElOZn0KdH"
                    data-amount="'.($this->cart->total()*100).'"
                    data-name="Not Cooking Tonight"
                    data-description="$'.$this->cart->total().'"
                    data-image="../assets/img/salad.jpg">
                  </script>
                </form>';
            echo '</form>';
        }
        else if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            require_once(APPPATH.'libraries/stripe/Stripe.php');
            Stripe::setApiKey("sk_test_4FLke6Tf0Ss8M0V9l9uUKifA");
            $token = $_POST['stripeToken'];
            try
            {
                $cartTotal = $this->cart->total();
                $charge = Stripe_Charge::create(array(
                        "amount" => ($cartTotal * 100), //amount in cents
                        "currency" => "usd",
                        "card" => $token)
                );

                //print_r($charge); echo $charge['id']; echo $charge['amount'];
                //print_r($this->session->all_userdata());

                if(!$is_gift)
                {
                    $deliveryData = $this->session->userdata('delivery');
                    $address = $this->address_model->insert_address($deliveryData['lineOne'], $deliveryData['lineTwo'],
                        $deliveryData['city'], $deliveryData['state'], $deliveryData['zip'], $deliveryData['telephone']);

                    $restaurant = $this->session->userdata('restaurant');
                    $order = $this->order_model->insert_order($restaurant['id'], $address, date_default_timezone_get());
                    $amountInDecimal = $charge['amount'] / 100;
                    $this->order_model->insert_order_payment($order, $charge['id'], $amountInDecimal);

                    $cartContents = $this->cart->contents();
                    foreach ($cartContents as $item)
                    {
                        $this->order_model->insert_order_menuitem($order, $item['id'], $item['qty']);
                    }
                }
                else
                {
                    $restaurant = $this->session->userdata('restaurant');
                    $gift = $this->gift_model->insert_gift($restaurant['id'], 'runtheexe@gmail.com');
                    $amountInDecimal = $charge['amount'] / 100;
                    $this->gift_model->insert_gift_payment($gift, $charge['id'], $amountInDecimal);

                    $cartContents = $this->cart->contents();
                    foreach ($cartContents as $itemtype)
                    {
                        $this->gift_model->insert_gift_menuitemtype($gift, $itemtype['id'], $itemtype['qty']);
                    }
                }
                redirect('home/checkout');
            }
            catch(Stripe_InvalidRequestError $e)
            {
                //Bad (pub/private key mismatch) or repeat usage of token
                echo $e;
                return;
            }
            catch(Stripe_CardError $e)
            {
                //The card has been declined
                echo $e;
                return;
            }
            catch(Exception $e)
            {
                echo 'oh, shit?';
            }
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
        $order = $this->order_model->get_order(8);
        print_r($order);
        //$this->load->view('home/orders');
    }

    //log the user in
    function login()
    {
        $this->data['title'] = "Login";

        //validate form input
        $this->form_validation->set_rules('identity', 'Identity', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == true)
        {
            //check to see if the user is logging in
            //check for "remember me"
            $remember = (bool) $this->input->post('remember');

            if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember))
            {
                //if the login is successful
                //redirect them back to the home page
                $this->session->set_flashdata('message', $this->ion_auth->messages());
                $dashGroups = array('admin', 'Operator', 'Manager');
                if ($this->ion_auth->in_group($dashGroups)) {
                    redirect('dash', 'refresh');
                }
                else {
                    redirect('/', 'refresh');
                }
            }
            else
            {
                //if the login was un-successful
                //redirect them back to the login page
                $this->session->set_flashdata('message', $this->ion_auth->errors());
                redirect('home/login', 'refresh'); //use redirects instead of loading views for compatibility with MY_Controller libraries
            }
        }
        else
        {
            //the user is not logging in so display the login page
            //set the flash data error message if there is one
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

            $this->data['identity'] = array('name' => 'identity',
                'id' => 'identity',
                'type' => 'text',
                'value' => $this->form_validation->set_value('identity'),
            );
            $this->data['password'] = array('name' => 'password',
                'id' => 'password',
                'type' => 'password',
            );

            $this->load->view('home/login', $this->data);
        }
    }

    //log the user out
    function logout()
    {
        $this->data['title'] = "Logout";

        //log the user out
        $logout = $this->ion_auth->logout();

        //redirect them to the login page
        $this->session->set_flashdata('message', $this->ion_auth->messages());
        redirect('/', 'refresh');
    }
}