<?php
class Restaurant_model extends CI_Model {

    public function __construct()
    {
        $this->load->database();
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

    public function get_restaurant($restaurant)
    {
        $query = $this->db->get_where('restaurant', array('id'=>$restaurant));
        return $query->row_array();
    }

    public function get_restaurants()
    {
        $query = $this->db->get('restaurant');
        return $query->result_array();
    }
}