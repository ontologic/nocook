<?php
class Order_model extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }

    public function get_order($order)
    {
        $this->db->select('*');
        $this->db->from('order_menuitem');
        $this->db->join('menuitem', 'order_menuitem.menuitem = menuitem.id');
        $this->db->join('menuitemtype', 'menuitem.menuitemtype = menuitemtype.id');
        $this->db->where('order_menuitem.order', $order);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function insert_order($restaurant, $address, $date)
    {
        $data = array(
            'restaurant' => $restaurant,
            'address' => $address,
            'delivery_date' => $date
        );
        $this->db->insert('order', $data);
        return $this->db->insert_id();
    }

    public function insert_order_menuitem($order, $menuitem, $quantity)
    {
        $data = array(
            'order' => $order,
            'menuitem' => $menuitem,
            'quantity' => $quantity
        );
        $this->db->insert('order_menuitem', $data);
    }
}