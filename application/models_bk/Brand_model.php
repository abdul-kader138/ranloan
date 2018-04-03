<?php
class Brand_model extends CI_Model
{
	public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
	
    public function fetch_brand_data()
    {
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get('brand');
        $result = $query->result();
        return $result;
    }
}
