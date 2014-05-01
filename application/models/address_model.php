<?php
class Address_model extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }

    public function insert_address($line_one, $line_two, $city, $state, $zip, $telephone)
    {
        $data = array(
            'line_one' => $line_one,
            'line_two' => $line_two,
            'city' => $city,
            'state' => $state,
            'zip' => $zip,
            'telephone' => $telephone
        );
        $this->db->insert('address', $data);
        return $this->db->insert_id();
    }

    public function get_address($id)
    {
        $query = $this->db->get_where('address', array('id'=>$id));
        return $query->row_array();
    }
}