<?php
class Menuitemtype_model extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }

    public function get_menutypes()
    {
        $query = $this->db->get('menuitemtype');
        return $query->result_array();
    }

    public function get_menutypes_with_prices($restaurant)
    {
        $this->db->select('*');
        $this->db->from('menuitemtype');
        $this->db->join('restaurant_menuitemtype',
            'menuitemtype.id = restaurant_menuitemtype.menuitemtype');
        $this->db->where('restaurant_menuitemtype.restaurant', $restaurant);
        $query = $this->db->get();
        return $query->result_array();
    }
}