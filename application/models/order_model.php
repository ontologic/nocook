<?php
class Order_model extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }

    public function insert_menuitem($restaurant, $type, $name, $description)
    {
        $data = array(
            'restaurant' => $restaurant,
            'type' => $type,
            'name' => $name,
            'description' => $description
        );
        return $this->db->insert('menuitem', $data);
    }
}