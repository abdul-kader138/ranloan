<?php
/**
* 
*/
class Category_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
	}

	function index()
	{

	}

	function get_categories()
	{
		$data = $this->db->get('category');
		return $data->result();
	}

}
?>