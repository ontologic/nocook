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
        $this->form_validation->set_rules('zip', 'Zip Code', 'required|exact_length[5]|callback_zip_validation');
        if ($this->form_validation->run() === FALSE)
        {
            $this->data['zip'] = array(
                'name' => 'zip',
                'id' => 'zip',
                'type' => 'text',
                'value' => $this->form_validation->set_value('zip'),
            );
            $this->load->view('home/zip', $this->data);
            return;
        }
        else
        {
            $zip = $this->input->post('zip');
            $this->session->set_userdata('zip', $zip);
            redirect('home/menu/'.$zip);
        }
    }

    public function zip_validation()
    {
        $zip = $this->input->post('zip');
        if(!$this->restaurant_model->does_restaurant_exist($zip))
        {
            $this->form_validation->set_message('zip_validation', 'No restaurant exists for zip '.$zip.'.');
            return false;
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
        $data['menuTypes'] = $this->menuitemtype_model->get_menutypes();
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

    public function amount()
    {
        $this->form_validation->set_rules('adults', 'Adults', 'required|callback_amount_validation');
        $this->form_validation->set_rules('children', 'Children', 'required');
        $this->form_validation->set_rules('type', 'Type', 'required');
        if ($this->form_validation->run() === FALSE)
        {
            $this->data['adults'] = array(
                'name' => 'adults',
                'id' => 'adults',
                'type' => 'text',
                'value' => $this->form_validation->set_value('adults'),
            );
            $this->data['children'] = array(
                'name' => 'children',
                'id' => 'children',
                'type' => 'text',
                'value' => $this->form_validation->set_value('children'),
            );
            $this->data['self'] = array(
                'name' => 'type',
                'id' => 'type',
                'type' => 'radio',
                'value' => '1',
            );
            $this->data['gift'] = array(
                'name' => 'type',
                'id' => 'type',
                'type' => 'radio',
                'value' => '2',
            );
            $this->load->view('home/amount', $this->data);
        }
        else
        {
            $adults = $this->input->post('adults');
            $children = $this->input->post('children');
            $type = $this->input->post('type');
            $this->session->set_userdata('adults', $adults);
            $this->session->set_userdata('children', $children);
            $this->session->set_userdata('type', $type);
            //print_r($this->session->all_userdata());
            redirect('home/receiver', 'refresh');
        }
    }

    public function amount_validation()
    {
        $adults = $this->input->post('adults');
        $children = $this->input->post('children');
        $total = $adults + $children;
        if($total <= 0)
        {
            $this->form_validation->set_message('amount_validation', 'You must order for at least one person.');
            return false;
        }
        return true;
    }

    public function receiver()
    {
        $this->form_validation->set_rules('first', 'First Name', 'required');
        $this->form_validation->set_rules('last', 'Last Name', 'required');
        $this->form_validation->set_rules('address', 'Address', 'required');
        $this->form_validation->set_rules('telephone', 'Telephone', 'required');
        //$this->form_validation->set_rules('zip', 'Zip', 'required');
        if ($this->form_validation->run() === FALSE)
        {
            $this->data['first'] = array(
                'name' => 'first',
                'id' => 'first',
                'type' => 'text',
                'value' => $this->form_validation->set_value('first'),
            );
            $this->data['last'] = array(
                'name' => 'last',
                'id' => 'last',
                'type' => 'text',
                'value' => $this->form_validation->set_value('last'),
            );
            $this->data['address'] = array(
                'name' => 'address',
                'id' => 'address',
                'type' => 'text',
                'value' => $this->form_validation->set_value('address'),
            );
            $this->data['zip'] = array(
                'name' => 'telephone',
                'id' => 'telephone',
                'type' => 'text',
                'value' => $this->session->userdata('zip'),
                'readonly' => 'true'
            );
            $this->data['telephone'] = array(
                'name' => 'telephone',
                'id' => 'telephone',
                'type' => 'text',
                'value' => $this->form_validation->set_value('telephone'),
            );
            $this->load->view('home/receiver', $this->data);
            return;
        }
        else
        {
            $this->session->set_userdata('receiver', $_POST);
            //print_r($this->session->all_userdata());
            redirect('home/notify');
        }
    }

    public function notify()
    {
        $this->form_validation->set_rules('notification', 'Delivery Type', 'required');
        if ($this->form_validation->run() === FALSE)
        {
            $this->data['note'] = array(
                'name' => 'note',
                'id' => 'note',
                'type' => 'textarea',
                'value' => $this->form_validation->set_value('note')
            );
            $this->load->view('home/notify', $this->data);
        }
        else
        {
            $this->session->set_userdata('notification', $_POST);
            //print_r($this->session->all_userdata());
            redirect('home/choose', 'refresh');
        }
    }

    public function choose()
    {
        $this->form_validation->set_rules('picking', 'Delivery Type', 'callback_choose_validation|required');
        if ($this->form_validation->run() === FALSE)
        {
            $this->data['picking'] = array(
                'name' => 'picking',
                'id' => 'picking',
                'type' => 'text',
                'value' => $this->form_validation->set_value('picking')
            );
            $this->data['date'] = array(
                'name' => 'date',
                'id' => 'date',
                'type' => 'text',
                'value' => $this->form_validation->set_value('date')
            );
            $this->load->view('home/choose', $this->data);
        }
        else
        {
            $this->session->set_userdata('choose', $_POST);
            //print_r($this->session->all_userdata());
            redirect('home/order', 'refresh');
        }
    }

    public function choose_validation()
    {
        $picking = $this->input->post('picking');
        $date = $this->input->post('date');
        if($picking == 'true' && empty($date))
        {
            $this->form_validation->set_message('choose_validation', 'You must choose a delivery date.');
            return false;
        }
        return true;
    }

    public function order()
    {
        $zip = $this->session->userdata('zip');
        $restaurant = $this->restaurant_model->get_restaurant_by_zip($zip);
        $menu = $this->menuitem_model->get_menuitems($restaurant['id']);
        $menuTypes = $this->menuitemtype_model->get_menutypes();
        $firstMenuType = reset($menuTypes);

        $this->form_validation->set_rules($firstMenuType['id'], $firstMenuType['id'], 'callback_order_validation');
        if ($this->form_validation->run() === FALSE)
        {
            $data['restaurant'] = $restaurant;
            $data['menu'] = $menu;
            $data['menuTypes'] = $menuTypes;
            $this->load->view('home/order', $data);
        }
        else
        {
            //print_r($_POST);
            $restaurant = $this->restaurant_model->get_restaurant_by_zip($zip);
            $this->session->set_userdata('restaurant', $restaurant);
            $data = array();
            foreach ($_POST as $itemId)
            {
                //echo 'q:' . $quantity . ' item:' . $itemId . '<br>';
                $menuItem = $this->menuitem_model->get_menuitem($itemId);
                //print_r($menuItem);
                $itemToAdd = array(
                    'id'      => $itemId,
                    'qty'     => 2,
                    'price'   => 42,
                    'name'    => $menuItem['name']
                );
                array_push($data, $itemToAdd);
            }
            //print_r($data);
            $this->cart->destroy();
            $this->cart->insert($data);
            print_r($this->cart->contents());
            echo '<br/><br/>';
            print_r($this->session->all_userdata());
            //redirect('home/delivery');
        }
    }

    public function order_validation()
    {
        $selectedTypes = count($_POST);
        $menuTypes = $this->menuitemtype_model->get_menutypes();
        if($selectedTypes != count($menuTypes))
        {
            $this->form_validation->set_message('order_validation', 'Please make a choice for each item type.');
            return false;
        }
        return true;
    }

    public function confirm()
    {
        if(!$this->ion_auth->logged_in())
        {
            redirect('home/login/home_confirm');
            return;
        }

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
            $restaurant = $this->session->userdata('restaurant');
            $subtotal = $this->cart->total();
            $tax = round((($restaurant['tax_percent'] / 100) * $subtotal), 2);
            $total = ($tax + $subtotal);
            print_r($this->cart->contents());
            echo '<br><br>';
            echo 'tax: '.$tax;
            echo '<br><br>';
            echo 'total: '.$total;
            echo '<br><br>';
            echo 'username: '.$this->ion_auth->user()->row()->username;
            echo ' id: '.$this->ion_auth->user()->row()->id;
            echo '<br><br>';
            echo '<form action="confirm" method="POST">';
            echo '<form action="" method="POST">
                  <script
                    src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                    data-key="pk_test_NFIOMm4WLLZSkhEElOZn0KdH"
                    data-amount="'.($total * 100).'"
                    data-name="Not Cooking Tonight"
                    data-description="$'.$total.'"
                    data-image="../assets/img/salad.jpg"
                    data-email="'.$this->ion_auth->user()->row()->email.'">
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
                $restaurant = $this->session->userdata('restaurant');
                $subtotal = $this->cart->total();
                $tax = round((($restaurant['tax_percent'] / 100) * $subtotal), 2);
                $total = ($tax + $subtotal);
                $charge = Stripe_Charge::create(array(
                        "amount" => ($total * 100), //amount in cents
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

                    $user_id = $this->ion_auth->user()->row()->id;
                    $restaurant = $this->session->userdata('restaurant');
                    $order = $this->order_model->insert_order($user_id, $restaurant['id'], $address, date_default_timezone_get());
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
                    $user_id = $this->ion_auth->user()->row()->id;
                    $restaurant = $this->session->userdata('restaurant');
                    $gift = $this->gift_model->insert_gift($user_id, $restaurant['id'], 'runtheexe@gmail.com');
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
        $order = $this->order_model->get_order_menuitems(8);
        print_r($order);
        //$this->load->view('home/orders');
    }

    //create a new user
    function register($redirect = null)
    {
        if ($this->ion_auth->logged_in())
        {
            redirect('home', 'refresh');
        }

        $tables = $this->config->item('tables','ion_auth');

        //validate form input
        $this->form_validation->set_rules('first_name', $this->lang->line('create_user_validation_fname_label'), 'required|xss_clean');
        $this->form_validation->set_rules('last_name', $this->lang->line('create_user_validation_lname_label'), 'required|xss_clean');
        $this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'required|valid_email|is_unique['.$tables['users'].'.email]');
        $this->form_validation->set_rules('password', $this->lang->line('create_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
        $this->form_validation->set_rules('password_confirm', $this->lang->line('create_user_validation_password_confirm_label'), 'required');

        if ($this->form_validation->run() == true)
        {
            $username = strtolower($this->input->post('first_name')) . ' ' . strtolower($this->input->post('last_name'));
            $email    = strtolower($this->input->post('email'));
            $password = $this->input->post('password');

            $additional_data = array(
                'first_name' => $this->input->post('first_name'),
                'last_name'  => $this->input->post('last_name')
            );
        }
        if ($this->form_validation->run() == true && $this->ion_auth->register($username, $password, $email, $additional_data))
        {
            //log the user in
            $this->ion_auth->login($this->input->post('email'), $this->input->post('password'));

            //check to see if we are creating the user
            //redirect them back to the admin page
            $this->session->set_flashdata('message', $this->ion_auth->messages());
            if($redirect != null)
            {
                $target = str_replace("_", "/", $redirect);
                redirect($target, 'refresh');
                return;
            }
            redirect('/', 'refresh');
            return;
        }
        else
        {
            //display the create user form
            //set the flash data error message if there is one
            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

            $this->data['first_name'] = array(
                'name'  => 'first_name',
                'id'    => 'first_name',
                'type'  => 'text',
                'value' => $this->form_validation->set_value('first_name'),
            );
            $this->data['last_name'] = array(
                'name'  => 'last_name',
                'id'    => 'last_name',
                'type'  => 'text',
                'value' => $this->form_validation->set_value('last_name'),
            );
            $this->data['email'] = array(
                'name'  => 'email',
                'id'    => 'email',
                'type'  => 'text',
                'value' => $this->form_validation->set_value('email'),
            );
            $this->data['password'] = array(
                'name'  => 'password',
                'id'    => 'password',
                'type'  => 'password',
                'value' => $this->form_validation->set_value('password'),
            );
            $this->data['password_confirm'] = array(
                'name'  => 'password_confirm',
                'id'    => 'password_confirm',
                'type'  => 'password',
                'value' => $this->form_validation->set_value('password_confirm'),
            );

            $this->load->view('home/register', $this->data);
        }
    }

    //log the user in
    public function login($redirect = null)
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
                    return;
                }
                else {
                    if($redirect != null)
                    {
                        $target = str_replace("_", "/", $redirect);
                        redirect($target, 'refresh');
                        return;
                    }
                    redirect('/', 'refresh');
                    return;
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
            //for building the register link
            $this->data['redirect'] = $redirect;

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
    public function logout()
    {
        $this->data['title'] = "Logout";

        //log the user out
        $logout = $this->ion_auth->logout();

        //redirect them to the login page
        $this->session->set_flashdata('message', $this->ion_auth->messages());
        redirect('/', 'refresh');
    }

    public function redeem($id)
    {
        if($id == null)
        {
            show_404();
        }
    }
}