<?php
class Gift_model extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }

    public function get_get($gift)
    {

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