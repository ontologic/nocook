<?php
class Menuitemtype_model extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }

    public function get_menutypes()
    {
        $query = $this->db->get('menuitem_type');
        return $query->result_array();
    }
}