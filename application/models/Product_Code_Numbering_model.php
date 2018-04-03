<?php
class Product_Code_Numbering_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

	public function UpdateProduct_Code_Numbering($id,$data)
	{
		$this->db->where('id',$id);
		$this->db->update('product_code_numbering',$data);
		return true;
	}
	
	public function ValidationCategoryandSubcategory($category,$sub_category)
	{
		$this->db->where('category',$category);
		$this->db->where('sub_category',$sub_category);
		$query = $this->db->get('product_code_numbering');
		return $query->num_rows();
	}
	
	public function getProductCodeCategorySubcategory($category,$sub_category)
	{
		
		$this->db->select('product_code_numbering.*,product_code_numbering.sub_category as sub_id ,category.name as categoryname,sub_category.sub_category,sub_category.prefix');
		$this->db->from('product_code_numbering');
		$this->db->join('category','category.id = product_code_numbering.category','left');
		$this->db->join('sub_category','sub_category.id = product_code_numbering.sub_category','left');
		$this->db->where('product_code_numbering.category',$category);
		$this->db->where('product_code_numbering.sub_category',$sub_category);
		$this->db->limit(1);
		$query = $this->db->get();
		return $query->row();
	}
	
	public function InsertNumbering($data)
	{
		$this->db->insert('product_code_numbering',$data);
		return true;
	}
	

	public function getProductNO($id)
	{
		$this->db->select('product_code_numbering.*,product_code_numbering.sub_category as sub_id ,category.name as categoryname,sub_category.sub_category,sub_category.prefix');
		$this->db->from('product_code_numbering');
		$this->db->join('category','category.id = product_code_numbering.category','left');
		$this->db->join('sub_category','sub_category.id = product_code_numbering.sub_category','left');
		$this->db->where('product_code_numbering.id',$id);
		$query = $this->db->get();
		return $query->row();
	}
	
	
	public function getProductCodeNumberingDate()
	{
		$this->db->select('product_code_numbering.*,product_code_numbering.sub_category as sub_id ,category.name as categoryname,sub_category.sub_category,sub_category.prefix');
		$this->db->from('product_code_numbering');
		$this->db->join('category','category.id = product_code_numbering.category','left');
		$this->db->join('sub_category','sub_category.id = product_code_numbering.sub_category','left');
		$query = $this->db->get();
		return $query->result();
	}
	
	public function getSubCategory($category_id)
	{
		$this->db->where('category_id_fk',$category_id);
		$query = $this->db->get('sub_category');
		return $query->result();
	}
	
	
	
}
