<?php

class Delivery extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('address_model');
        $this->load->model('order_model');
        $this->load->model('restaurant_model');
        $this->load->model('delivery_model');

        $this->load->helper('url');

        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->library('ion_auth');
    }

    public function index($order)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET')
        {
            $order = $this->order_model->get_order($order);
            $restaurantAddress = $this->restaurant_model->get_restaurant_with_address($order['restaurant']);
            $formattedRestaurantAddress = sprintf('%s %s %s, %s %s', $restaurantAddress['line_one'], $restaurantAddress['line_two'],
                $restaurantAddress['city'], $restaurantAddress['state'], $restaurantAddress['zip']);
            $this->data['start'] = $formattedRestaurantAddress;
            echo($formattedRestaurantAddress);

            $deliveryAddress = $this->address_model->get_address($order['address']);
            $formattedDeliveryAddress = sprintf('%s %s %s, %s %s', $deliveryAddress['line_one'], $deliveryAddress['line_two'],
                $deliveryAddress['city'], $deliveryAddress['state'], $deliveryAddress['zip']);
            echo $formattedDeliveryAddress;
            $this->data['end'] = $formattedDeliveryAddress;
            $this->load->view('delivery/index', $this->data);
        }
        else
        {
            $this->delivery_model->insert_delivery($order, 1, '');
            echo 'delivered';
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