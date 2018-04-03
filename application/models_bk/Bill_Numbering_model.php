<?php
class Bill_Numbering_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getBrand()
    {
		$this->db->where('status','0');
		$query = $this->db->get('brand');
		return $query->result();
    }
	
    public function getSupplier()
    {
		$this->db->where('status','1');
		$query = $this->db->get('suppliers');
		return $query->result();
    }
	
    public function getCategory()
    {
		$this->db->where('status','1');
		$query = $this->db->get('category');
		return $query->result();
    }
	
    public function getSubCategory()
    {
		$this->db->where('status','0');
		$query = $this->db->get('sub_category');
		return $query->result();
    }
	
	public function SubmitBillNumbering($data)
	{
		$this->db->insert('bill_numbering',$data);
		return true;
	}

	//add by a3frt start

	public function get_BillNumbering()
	{
		$this->db->from('bill_numbering');
		$this->db->join('users', 'bill_numbering.user_id = users.id', 'left');
		$this->db->order_by("bill_numbering.id", "ASC");
		$query = $this->db->get(); 
		return $query->result();
	}

	// add by a3frt End
	
	public function getProductCodeNumbering()
	{
		$query = $this->db->select('product_code_numbering.*,users.fullname');
		$query = $this->db->from('product_code_numbering');
		$query = $this->db->join('users','users.id = product_code_numbering.user_id','left');
		$query = $this->db->get();
		return $query->result();
	}
}
