<?php
class Menuitem_model extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }

    public function get_menuitem($id)
    {
        $query = $this->db->get_where('menuitem', array('id' => $id));
        return $query->row_array();
    }

    public function get_menuitems($restaurant)
    {
        $query = $this->db->get_where('menuitem', array('restaurant' => $restaurant));
        return $query->result_array();
    }

    public function insert_menuitem($restaurant, $type, $name, $description)
    {
        $data = array(
            'restaurant' => $restaurant,
            'menuitemtype' => $type,
            'name' => $name,
            'description' => $description
        );
        return $this->db->insert('menuitem', $data);
    }

    public function update_menuitem($id, $name, $description)
    {
        $data = array(
            'name' => $name,
            'description' => $description
        );
        $this->db->where('id', $id);
        return $this->db->update('menuitem', $data);
    }

    public function delete_menuitem($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('menuitem');
    }
}