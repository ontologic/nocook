<?php
class Restaurant_model extends CI_Model {

    public function __construct()
    {
        $this->load->database();
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