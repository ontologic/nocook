<?php
class Order_model extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }

    public function get_order($id)
    {
        $query = $this->db->get_where('order', array('id'=>$id));
        return $query->row_array();
    }

    public function get_order_menuitems($order)
    {
        $this->db->select('*');
        $this->db->from('order_menuitem');
        $this->db->join('menuitem', 'order_menuitem.menuitem = menuitem.id');
        $this->db->join('menuitemtype', 'menuitem.menuitemtype = menuitemtype.id');
        $this->db->where('order_menuitem.order', $order);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function insert_order($user, $restaurant, $address, $date)
    {
        $data = array(
            'user' => $user,
            'restaurant' => $restaurant,
            'address' => $address,
            'delivery_date' => $date
        );
        $this->db->insert('order', $data);
        return $this->db->insert_id();
    }

    public function insert_order_payment($order, $stripeId, $amount)
    {
        $data = array(
            'order' => $order,
            'stripe_id' => $stripeId,
            'amount' => $amount
        );
        $this->db->insert('order_payment', $data);
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