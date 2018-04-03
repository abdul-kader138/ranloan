<?php
//defined('BASEPATH') OR exit('No direct script access allowed');

class Staff_model extends CI_Model
{
    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
    }

    public function record_staff_count()
    {
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get('staff');
        $this->db->save_queries = false;

        return $query->num_rows();
    }

    public function fetch_staff_data()
    {

		$this->db->order_by('id', 'DESC');
		$this->db->select('staff.*,outlets.name as assign_outlet_name');
		$this->db->from('staff');
		$this->db->join('outlets','outlets.id = staff.assign_outlet	');
		$query = $this->db->get();
		return  $query->result();
    }
 public function fetch_sale_history($cust_id)
    {

			$this->db->where("created_by", $cust_id);
			$query = $this->db->get("orders");
			return  $query->result();
    }
		
	
	
}
