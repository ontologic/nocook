<?php
class Delivery_model extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }

    public function insert_delivery($order, $courier, $delivered)
    {
        $data = array(
            'order' => $order,
            'courier' => $courier,
            'delivered' => $delivered
        );
        $this->db->insert('delivery', $data);
    }
}