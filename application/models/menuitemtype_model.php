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

    public function get_menuitemtype($item)
    {
        $query = $this->db->get_where('menuitem', array('id'=>$item));
        return $query->row_array();
    }
}