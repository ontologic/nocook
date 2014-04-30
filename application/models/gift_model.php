<?php
class Gift_model extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }

    public function get_gift($gift)
    {
        $query = $this->db->get_where('gift', array('id'=>$gift));
        return $query->row_array();
    }

    public function get_gift_menuitemtypes($gift)
    {
        $this->db->select('*');
        $this->db->from('gift_menuitemtype');
        $this->db->join('menuitemtype', 'gift_menuitemtype.menuitemtype = menuitemtype.id');
        $this->db->where('gift_menuitemtype.gift', $gift);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function insert_gift($from_user, $restaurant, $recipient)
    {
        $data = array(
            'from_user' => $from_user,
            'restaurant' => $restaurant,
            'recipient' => $recipient
        );
        $this->db->insert('gift', $data);
        return $this->db->insert_id();
    }

    public function insert_gift_payment($gift, $stripeId, $amount)
    {
        $data = array(
            'gift' => $gift,
            'stripe_id' => $stripeId,
            'amount' => $amount
        );
        $this->db->insert('gift_payment', $data);
    }

    public function insert_gift_menuitemtype($gift, $menuitemtype, $quantity)
    {
        $data = array(
            'gift' => $gift,
            'menuitemtype' => $menuitemtype,
            'quantity' => $quantity
        );
        $this->db->insert('gift_menuitemtype', $data);
    }
}