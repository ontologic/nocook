<?php
class Restaurant_model extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }

    public function create_restaurant($name, $address, $tax_percent, $stripe_public_key, $stripe_secret_key)
    {
        $data = array(
            'name' => $name,
            'address' => $address,
            'tax_percent' => $tax_percent,
            'stripe_public_key' => $stripe_public_key,
            'stripe_secret_key' => $stripe_secret_key
        );
        return $this->db->insert('restaurant', $data);
    }

    public function create_restaurant_zip($restaurant, $zip)
    {
        $data = array(
            'restaurant' => $restaurant,
            'zip' => $zip
        );
        return $this->db->insert('restaurant_zip', $data);
    }

    public function does_restaurant_exist($zip)
    {
        $query = $this->db->get_where('restaurant_zip', array('zip'=>$zip));
        $restaurant = $query->row_array();
        //Is this terrible?
        return (!empty($restaurant));
    }

    public function get_restaurant_by_zip($zip)
    {
        $this->db->select('*');
        $this->db->from('restaurant');
        $this->db->join('restaurant_zip', 'restaurant.id = restaurant_zip.restaurant');
        $this->db->where('restaurant_zip.zip', $zip);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function get_restaurant_zips($restaurant)
    {
        $query = $this->db->get_where('restaurant_zip', array('restaurant'=>$restaurant));
        return $query->result_array();
    }

    public function get_restaurant($restaurant)
    {
        $query = $this->db->get_where('restaurant', array('id'=>$restaurant));
        return $query->row_array();
    }

    public function get_restaurant_with_address($restaurant)
    {
        $this->db->select('*');
        $this->db->from('restaurant');
        $this->db->join('address', 'restaurant.address = address.id');
        $this->db->where('restaurant.id', $restaurant);
        $query = $this->db->get();
        return $query->row_array();

        $query = $this->db->get_where('restaurant', array('id'=>$restaurant));
        return $query->row_array();
    }

    public function get_restaurants()
    {
        $query = $this->db->get('restaurant');
        return $query->result_array();
    }

    public function update_restaurant($id, $name, $tax_percent, $stripe_public_key, $stripe_secret_key,
        $lineOne, $lineTwo, $city, $state, $zip, $telephone)
    {
        $data = array(
            'name' => $name,
            'tax_percent' => $tax_percent,
            'stripe_public_key' => $stripe_public_key,
            'stripe_secret_key' => $stripe_secret_key
        );
        $this->db->where('id', $id);
        $this->db->update('restaurant', $data);
        $restaurant = $this->get_restaurant($id);
        $data = array(
            'line_one' => $lineOne,
            'line_two' => $lineTwo,
            'city' => $city,
            'state' => $state,
            'zip' => $zip,
            'telephone' => $telephone
        );
        $this->db->where('id', $restaurant['address']);
        $this->db->update('address', $data);
    }

    public function delete_restaurant_zip($restaurant, $zip)
    {
        echo $restaurant;
        echo $zip;
        $this->db->delete('restaurant_zip', array('restaurant' => $restaurant, 'zip' => $zip));
    }
}