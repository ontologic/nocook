<?php

class Gift extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('gift_model');
        $this->load->model('restaurant_model');
        $this->load->model('menuitem_model');
        $this->load->model('menuitemtype_model');
        $this->load->model('address_model');
        $this->load->model('order_model');

        $this->load->helper('url');

        $this->load->library('form_validation');
        $this->load->library('cart');
        $this->load->library('session');
        $this->load->library('ion_auth');
    }

    public function index($gift)
    {
        $gift = $this->gift_model->get_gift($gift);
        $this->session->set_userdata('gift', $gift);

        //TODO: This will work as long as you have a menuitemtype of 1
        $this->form_validation->set_rules('1', '1', 'callback_gift_validation');
        if ($this->form_validation->run() === FALSE)
        {
            $data['giftItems'] = $this->gift_model->get_gift_menuitemtypes($gift['id']);
            $restaurant = $this->restaurant_model->get_restaurant($gift['restaurant']);
            $data['menu'] = $this->menuitem_model->get_menuitems($restaurant['id']);
            $data['menuTypes'] = $this->menuitemtype_model->get_menutypes_with_prices($restaurant['id']);
            /*print_r($gift);
            echo '<br/><br/>';
            print_r($gift_items);
            echo '<br/><br/>';
            print_r($restaurant);*/
            //echo '<br/><br/>';
            //print_r($menu);

            $this->load->view('gift/index', $data);
        }
        else
        {
            $restaurant = $this->restaurant_model->get_restaurant($gift['restaurant']);
            $this->session->set_userdata('restaurant', $restaurant);
            $data = array();
            foreach ($_POST as $itemId => $quantity)
            {
                $menuItem = $this->menuitem_model->get_menuitem_with_price($itemId);
                $itemToAdd = array(
                    'id'      => $itemId,
                    'qty'     => $quantity,
                    'price'   => $menuItem['price'],
                    'name'    => $menuItem['name']
                );
                array_push($data, $itemToAdd);
            }
            $this->cart->destroy();
            $this->cart->insert($data);
            redirect('gift/delivery');
        }
    }

    //Form validation for order POST
    public function gift_validation()
    {
        $totalQuantity = 0;
        $gift = $this->session->userdata('gift');
        $giftItems = $this->gift_model->get_gift_menuitemtypes($gift['id']);
        $itemTypeCounts = array();
        //Loop over input and sum selected item types (x of item type 1, y of item type 2, etc.)
        foreach ($_POST as $item => $quantity)
        {
            if(!is_int($item)){ break; }
            if($quantity < 0)
            {
                $this->form_validation->set_message('gift_validation', 'All quantities must be positive values.');
                return false;
            }
            $menuItem = $this->menuitemtype_model->get_menuitemtype($item);
            $menuItemType = $menuItem['menuitemtype'];
            if(array_key_exists($menuItemType, $itemTypeCounts))
            {
                $itemTypeCounts[$menuItemType] += $quantity;
            }
            else
            {
                $itemTypeCounts[$menuItemType] = $quantity;
            }
            $totalQuantity += $quantity;
        }
        //print_r($itemTypeCounts);
        $findGiftOfType = function ($menuItemType)
        {
            return function ($giftItem) use ($menuItemType) { return $giftItem['menuitemtype'] == $menuItemType; };
        };
        //Compare the quantity of item type to the quantity that was allotted when the gift was created
        foreach($itemTypeCounts as $itemType => $quantityUserIsOrdering)
        {
            $giftOfType = array_filter($giftItems, $findGiftOfType($itemType));
            $wtf = reset($giftOfType);
            if($wtf['quantity'] != $quantityUserIsOrdering)
            {
                $this->form_validation->set_message('gift_validation', 'You must order the correct amount of each item type.');
                return false;
            }
        }
        if($totalQuantity == 0)
        {
            $this->form_validation->set_message('gift_validation', 'You must order at least one item.');
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
            $this->load->view('gift/delivery');
            return;
        }
        else
        {
            $this->session->set_userdata('delivery', $_POST);
            redirect('gift/checkout');
        }
    }

    public function checkout()
    {
        if(!$this->ion_auth->logged_in())
        {
            redirect('home/login/gift_checkout');
            return;
        }

        $deliveryData = $this->session->userdata('delivery');
        $address = $this->address_model->insert_address($deliveryData['lineOne'], $deliveryData['lineTwo'],
            $deliveryData['city'], $deliveryData['state'], $deliveryData['zip'], $deliveryData['telephone']);

        $user_id = $this->ion_auth->user()->row()->id;
        $restaurant = $this->session->userdata('restaurant');
        $order = $this->order_model->insert_order($user_id, $restaurant['id'], $address, date_default_timezone_get());
        $cartContents = $this->cart->contents();
        foreach ($cartContents as $item)
        {
            $this->order_model->insert_order_menuitem($order, $item['id'], $item['qty']);
        }
        echo 'order complete';
    }
}