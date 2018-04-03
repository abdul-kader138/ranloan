<?php //
class Bdt_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
	
	public function getOutletUserWise($user_outlet, $user_role)
	{
		if($user_role == 1)
		{
			$query = $this->db->get('outlets');
			return $query->result();
		}
		else
		{
			$this->db->where('id',$user_outlet);
			$query = $this->db->get('outlets');
			return $query->result();
		}
	}
	
	public function getAccountNumber($account_number)
	{
		$this->db->where('id',$account_number);
		$this->db->limit('1');
		$query = $this->db->get('bank_accounts');
		return !empty($query->row()->account_number)?$query->row()->account_number:'';
	}
	
	
	public function getPaymentMethod()
	{
		return $this->db->get('payment_method')->result();
	}
	
	public function getBankAccountNumber()
	{
		return $this->db->get('bank_accounts')->result();
	}
	
	public function getBankAccount_notsel($bank_accounts_id)
	{
		$this->db->where('id !=',$bank_accounts_id);
		$query = $this->db->get('bank_accounts');
		return $query->result();
	}
	public function getPaymentname($pay_id)
	{
		$this->db->where('id',$pay_id);
		$this->db->limit(1);
		$query = $this->db->get('payment_method');
		return $query->row()->name;
	}
	
	public function getBankName($id)
	{
		$this->db->where('id',$id);
		$this->db->limit(1);
		$query = $this->db->get('bank_accounts');
		return $query->row()->account_number;
	}
	
	public function getBankTransform()
	{
		$this->db->select('bank_transfers.*,outlets.name as outletname,users.fullname');
		$this->db->from('bank_transfers');
		$this->db->join('outlets','outlets.id = bank_transfers.outlet_id','left');
		$this->db->join('users','users.id = bank_transfers.created_by','left');
//		$this->db->join('payment_method','payment_method.id = bank_transfers.bank_from','left');
//		if(!empty($this->input->get('payment_type')))
//		{
//			$this->db->where('bank_transfers.bank_from',$this->input->get('payment_type'));
//		}
//		if(!empty($this->input->get('outlet')))
//		{
//			$this->db->where('bank_transfers.outlet_id',$this->input->get('outlet'));
//		}
		if(!empty($this->input->get('start_date')))
		{
			$this->db->where('DATE_FORMAT(bank_transfers.transfer_date,"%Y-%m-%d") >=',date('Y-m-d',strtotime($this->input->get('start_date'))));
		}
		if(!empty($this->input->get('end_date')))
		{
			$this->db->where('DATE_FORMAT(bank_transfers.transfer_date,"%Y-%m-%d") <=',date('Y-m-d',strtotime($this->input->get('end_date'))));
		}
		
		$query = $this->db->get();
		return $query->result();
	}
	
	
	public function getBankSignleRecord($id)
	{
		$this->db->select('bank_transfers.*,outlets.name as outletname,users.fullname');
		$this->db->from('bank_transfers');
		$this->db->join('outlets','outlets.id = bank_transfers.outlet_id','left');
		$this->db->join('users','users.id = bank_transfers.created_by','left');
		$this->db->where('bank_transfers.id',$id);
		$query = $this->db->get();
		return $query->row();
	}
	
	
}
