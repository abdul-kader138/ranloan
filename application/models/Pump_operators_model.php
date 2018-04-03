<?php

class Pump_operators_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();

	}

	function index()
	{

	}

	function get_operators()
	{
		$data = $this->db->query("SELECT * FROM pump_operators ORDER BY operator_name ASC ");
		return $data->result();
		
		
	}
	function search_operators()
	{
		$operator_name = $this->input->get('operator_name');
		$id = $this->input->get('id');
		$status = $this->input->get('status');
		if ($status == "Enabled")
		{
			$status = '1';
		}
		else if ($status == "Disabled")
		{
			$status = '0';
		}
		
		else 
		{
			$status = NULL;
		}
		
		/*if ($operator_name == "" && $id == "" && $status == "select")
		{
			$data = $this->db->get('pump_operators');
			return $data->result();
		}
		else
		{
			//$where = "operator_name = '$operator_name' OR id = '$id' OR status = '$status'";
			$this->db->where('operator_name', $operator_name);
			$this->db->or_where('id', $id);
			$this->db->or_where('status', $status);
			//$data = $this->db->query('SELECT * from pump_operators where operator_name=$operator_name OR id=$id OR status=$status');
//			$data = $this->db->get('pump_operators');
			return $data->result();
		}*/
		$sort ="";
		if (!empty($operator_name)) {
	        $sort .= " AND operator_name LIKE '%$operator_name%' ";
	    }

	    if (!empty($id)) {
	        $sort .= " AND id LIKE '%$id%' ";
	    }

	    if ($status == '1' || $status == '0') {
	        $sort .= " AND status LIKE '%$status%' ";
	    }
	    
	    
			$data = $this->db->query("SELECT * FROM pump_operators WHERE operator_dob != '0000-00-00' $sort ORDER BY operator_name ASC ");
		    return $data->result();	
		
		
	}
	function create_operator()
	{

		$new_pump_operator_data = array(
			'operator_name' => $this->input->post('operator_name'), 
			'operator_cnic' => $this->input->post('operator_cnic'), 
			'operator_address' => $this->input->post('operator_address'), 
			'operator_dob' =>date('Y-m-d', strtotime(strip_tags($this->input->post('operator_dob')))),// $this->input->post('operator_dob'), 
			'operator_telephone_number' => $this->input->post('operator_telephone_number'), 
			'operator_mobile_number' => $this->input->post('operator_mobile_number'), 
			'commission_type' => $this->input->post('commission_type'), 
			'outlet_id' => $this->input->post('outlet_id'), 
			'commission_ap' => $this->input->post('commission_ap'), 
 			'assigned_pump_id' => '0', 
			'status' => '1'

		);
                //print_r($new_pump_operator_data);exit;
		$insert = $this->db->insert('pump_operators', $new_pump_operator_data);
		return $insert;
	}

	function change_operator_status($id)
	{
		$this->db->where('id', $id);
		$data = $this->db->get('pump_operators');
		$result = $data->result();
		foreach ($result as $row) {
		
			if ($row->status == '1')
			{
				$this->db->set('status', '0');
				$this->db->where('id', $id);
				$this->db->update('pump_operators');
				return true;

			}
			else if ($row->status == '0')
			{
				$this->db->set('status', '1');
				$this->db->where('id', $id);
				$this->db->update('pump_operators');
				return true;
			}
			else
				return false;
		}
	}

	function edit_operator($id)
	{
		$this->db->where('id', $id);
		$data = $this->db->get('pump_operators');
		return $data->result();
	}

	function update_operator($id)
	{
		$updated_pump_operator_data = array(
			'operator_name' => $this->input->post('operator_name'), 
			'operator_cnic' => $this->input->post('operator_cnic'), 
			'operator_address' => $this->input->post('operator_address'), 
			'operator_dob' => date('Y-m-d', strtotime(strip_tags($this->input->post('operator_dob')))), 
			'operator_telephone_number' => $this->input->post('operator_telephone_number'), 
			'operator_mobile_number' => $this->input->post('operator_mobile_number'), 
			'commission_type' => $this->input->post('commission_type'), 
			'outlet_id' => $this->input->post('outlet_id'), 
			'commission_ap' => $this->input->post('commission_ap'), 
			'assigned_pump_id' => '0'

		);

		$this->db->set($updated_pump_operator_data);
		$this->db->where('id', $id);
		return $this->db->update('pump_operators');

	}

	function delete_operator($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('pump_operators');
		return true;
	}

}

?>