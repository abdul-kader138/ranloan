<?php
class Sub_category_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    
    public function fetch_sub_category_data()
    {
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get('sub_category');
        return $query->result();
    }
}
