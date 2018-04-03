<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Purchase_order extends CI_Controller
{
  
    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->library('session');
        $this->load->model('Purchaseorder_model');
        $this->load->model('Bill_Numbering_model');
        $this->load->model('Constant_model');
        $this->load->model('Inventory_model');
        $this->load->model('Pos_model');
		$this->load->model('bdt_model');
        $this->load->library('pagination');
        $settingResult = $this->db->get_where('site_setting');
        $settingData = $settingResult->row();
        $setting_timezone = $settingData->timezone;
        date_default_timezone_set("$setting_timezone");
		
		if(empty($this->session->userdata('user_id')))
		{
			redirect(base_url());
		}
    }

    public function index()
    {
        $this->load->view('dashboard', 'refresh');
    }
	
	public function getOutletPayment()
	{
		$outlet_id = $this->input->post('outletid');
		$getOutletPayment = $this->Constant_model->getOutletWisePaymentMethod($outlet_id);
		$html = '';
		$html.='<option value="">Select Payment Method</option>';
		
		foreach ($getOutletPayment as $pay)
		{
			if($pay->name == "Cheque" || $pay->name == "Cash" || $pay->name == "Credit cards")
			{
				$html.='<option value="'.$pay->id.'">'.$pay->name.'</option>';
			}
		}
		
		$json['payment'] = $html;
		echo json_encode($json);
	}
		
	public function purchase_direct()
	{
		$data['purchaseOrderNumber'] 	= $this->Purchaseorder_model->getPurchaseOrderNumber();
		$data['getOutlets']				= $this->Constant_model->getOutlets();
		$data['getSupplier']			= $this->Constant_model->getSuppliers();
		$userdata						= $this->Pos_model->getUserRoll();
		$data['RollID']					= $userdata->role_id;
		$data['LoginUser']				= $userdata->fullname;
		$outlet_id						= $userdata->outlet_id;
		$format_array = ci_date_format();
		$data['dateformat_ters'] = $format_array['dateformat'];

		if(!empty($outlet_id))
		{
			$data['outlet_id']			= $outlet_id;
			$data['UserOutletName']		= $this->Pos_model->UserOutlet($outlet_id);	
		}
		$this->load->view('purchase_direct',$data);
	}
	

	
	public function InsertPurchaseDirect()
	{
		$us_id		= $this->session->userdata('user_id');
        $tm			= date('Y-m-d H:i:s', time());
		$purchase	= $this->input->post('purchase');
		$po_numb	= $this->input->post('po_number');
		$outletid	= $this->input->post('outlet');
		
		
		foreach ($purchase as $pur_item)
		{
			if(!empty($pur_item['product_id']) && !empty($pur_item['qty']))
			{
				$ins_po_item_data = array(
					'po_id'					=> $po_numb,
					'product_code'			=> $pur_item['product_id'],
					'cost'					=> $pur_item['new_price'],
					'ordered_qty'			=> $pur_item['qty'],
					'bonusqty'				=> $pur_item['bonusqty'],
					'discount_percentage'	=> $pur_item['discount'],
					'discount_amount'		=> $pur_item['sub_discount_amount'],
					'tax'					=> $pur_item['sub_tax'],
					'subTotal'				=> $pur_item['subtotal'],
				);
				$this->Constant_model->insertDataReturnLastId('temporary_purchase_order_items', $ins_po_item_data);
			}
		}
		$html = '';
		
		$temporarydata = $this->Purchaseorder_model->getPurchaseTemporaryData();
		$html_ware		= '';
		$i = 1;
		foreach ($temporarydata as $value)
		{
			$product_code = $value->product_code;
			$product_category	= $this->Purchaseorder_model->getCategoryWareHouseTank($product_code);
			$product_id = $product_category->id;
			$product_name = $product_category->name;
			$totalPurchaseQty = (!empty($value->ordered_qty)?($value->ordered_qty):0) + (!empty($value->bonusqty)?($value->bonusqty):0);
			
			
			$html_ware.='<div class="row MainheaderData" data-val="'.$value->id.'" style="text-align: center; font-size: 13px; color: #388E3C; background-color: #C8E6C9; padding-top: 7px; padding-bottom: 7px; margin-left: 0px; margin-right: 0px;">'.$product_code.'['.$product_name.'] <input style="width:100px;display:inline;" readonly type="text" class="form-control" name="finalpurchase['.$i.'][TotalQtyQty]" id="purchaseqty'.$value->id.'" value="'.$totalPurchaseQty.'"></div>
							<input type="hidden" name="finalpurchase['.$i.'][qty]"  value="'.$value->ordered_qty.'">
							<input id="validation_product_code'.$value->id.'" type="hidden" name="finalpurchase['.$i.'][product_id]"  value="'.$value->product_code.'">
							<input type="hidden" name="finalpurchase['.$i.'][new_price]"  value="'.$value->cost.'">
							<input type="hidden" name="finalpurchase['.$i.'][bonusqty]"  value="'.$value->bonusqty.'">
							<input type="hidden" name="finalpurchase['.$i.'][discount]"  value="'.$value->discount_percentage.'">
							<input type="hidden" name="finalpurchase['.$i.'][sub_discount_amount]"  value="'.$value->discount_amount.'">
							<input type="hidden" name="finalpurchase['.$i.'][sub_tax]"  value="'.$value->tax.'">
							<input type="hidden" name="finalpurchase['.$i.'][subtotal]"  value="'.$value->subTotal.'">

						<table class="table table-bordered table-responsive">
						<thead>
							<tr>
								<th width="20%">Warehouse</th>
								<th width="20%">Quantity</th>
								<th width="20%">Instock Qty</th>
							</tr>
						</thead>
				<tbody>';
			
				$j = 1;
				$getWarehouse = $this->Constant_model->getOutletWareHouse($outletid);
				$qtyi = 1;
				foreach ($getWarehouse as $ware)
				{

					$distributeqty = 0;
					if($qtyi == 1)
					{
						$distributeqty = (!empty($value->ordered_qty)?($value->ordered_qty):0) + (!empty($value->bonusqty)?($value->bonusqty):0);
					}
					$ow_id			= $ware->ow_id;
					$type			= 0;
					$inventory = $this->Purchaseorder_model->CheckInventory($ow_id,$outletid,$type,$product_code);

					$html_ware.='
					<tr>
						<td>'.$ware->s_name.'</td>
						<td>
							<input type="text" name="finalpurchase['.$i.'][tank_warehouse]['.$j.'][qty]" type="text" class="form-control  warehouse_quantity'.$value->id.'" placeholder="0" min="0" max="5" value="'.$distributeqty.'" style="width: 100%;">
							<input name="finalpurchase['.$i.'][tank_warehouse]['.$j.'][ow_id]"  value='.$ware->ow_id.' type="hidden" class="form-control">
							<input name="finalpurchase['.$i.'][tank_warehouse]['.$j.'][outlet_id]"  value='.$outletid.' type="hidden" class="form-control">
							<input name="finalpurchase['.$i.'][tank_warehouse]['.$j.'][type]" value="0" type="hidden" class="form-control">
							<input name="finalpurchase['.$i.'][tank_warehouse]['.$j.'][product_code]" value='.$product_code.' type="hidden" class="form-control">
						</td>';
					if($inventory->num_rows()>0)
					{
						$html_ware.='<td><input readonly  name="finalpurchase['.$i.'][tank_warehouse]['.$j.'][invetory_qty]"  value="'.$inventory->row()->qty.'" type="text" class="form-control"></td>';
					}
					else
					{
						$html_ware.='<td><input readonly name="finalpurchase['.$i.'][tank_warehouse]['.$j.'][invetory_qty]" value="" placeholder="0"  type="text" class="form-control"></td>';
					}
					$html_ware.='</tr>';
					$j++;
					$qtyi++;
				}
			
			
			$html_ware.='
					</tbody>
				</table>
				';
			$i++;
		}
		$html_ware.='<div class="col-md-12" style="text-align:right"><button type="button" class="btn btn-primary SaveData">Save</button>';
		$json['success'] = $html_ware;
		echo json_encode($json);
		
	}
	
	
	public function FinalSubmitPurchaseDirect()
	{
		$us_id = $this->session->userdata('user_id');
        $tm = date('Y-m-d H:i:s', time());
		$supplierDtaData	= $this->Constant_model->getDataOneColumn('suppliers', 'id', $this->input->post('supplier'));
		$supplier_name		= $supplierDtaData[0]->name;
		$supplier_email		= $supplierDtaData[0]->email;
		
		$supplier_tel = $supplierDtaData[0]->tel;
		$supplier_fax = $supplierDtaData[0]->fax;
		
		$outletDtaData		= $this->Constant_model->getDataOneColumn('outlets', 'id', $this->input->post('outlet'));
		$outlet_name		= $outletDtaData[0]->name;
		$outlet_address		= $outletDtaData[0]->address;
		$outlet_contact		= $outletDtaData[0]->contact_number;
		$purchase	= $this->input->post('finalpurchase');
		$po_numb	= $this->input->post('po_number');
		$transcation_date= $this->input->post('transation_date');
		
		
		if(!empty($this->input->post('supplieraddress')))
		{
			$supplier_address = $this->input->post('supplieraddress');
		}
		else
		{
			$supplier_address = $supplierDtaData[0]->address;
		}

		$purchasearray = array(
					'po_number'	=>$this->input->post('po_number'),
					'total_items'			=>$this->input->post('total_items'),
					'discount_amount'		=>$this->input->post('discount_amount'),
					'discount_percentage'	=>$this->input->post('discount_percentage'),
					'tax'					=>$this->input->post('tax_amount'),
					'grandTotal'			=>$this->input->post('total_amount'),
					'supplier_id'			=>$this->input->post('supplier'),
					'purchase_bill_no'		=>$this->input->post('purchase_bill_no'),
					'supplier_name'			=> $supplier_name,
					'transation_date'		=>date( 'Y-m-d', strtotime($transcation_date)),
					'supplier_email'		=> $supplier_email,
					'supplier_address'		=> $supplier_address,
					'supplier_tel'			=> $supplier_tel,
					'supplier_fax'			=> $supplier_fax,
					'outlet_id'				=> $this->input->post('outlet'),
					'outlet_name'			=> $outlet_name,
					'outlet_address'		=> $outlet_address,
					'outlet_contact'		=> $outlet_contact,
					'po_date'				=> date('Y-m-d'),
					'created_user_id'		=> $us_id,
                    'created_datetime'		=> $tm,
                    'status'				=> '6',
					'note'					=> $this->input->post('note'),
				);
		$po_id = $this->Constant_model->insertDataReturnLastId('purchase_order', $purchasearray);
		
		foreach ($purchase as $pur_item)
		{
			if(!empty($pur_item['product_id']) && !empty($pur_item['qty']))
			{
				$ins_po_item_data = array(
					'po_id'					=> $po_id,
					'product_code'			=> $pur_item['product_id'],
					'cost'					=> $pur_item['new_price'],
					'ordered_qty'			=> $pur_item['qty'],
					'bonusqty'				=> $pur_item['bonusqty'],
					'discount_percentage'	=> $pur_item['discount'],
					'discount_amount'		=> $pur_item['sub_discount_amount'],
					'tax'					=> $pur_item['sub_tax'],
					'subTotal'				=> $pur_item['subtotal'],
				);
			 
				$this->Constant_model->UpdateProductPrice($pur_item['product_id'],$pur_item['new_price']);
				$purchase_item_id = $this->Constant_model->insertDataReturnLastId('purchase_order_items', $ins_po_item_data);
				
				
				$bonusqty = !empty($pur_item['bonusqty'])?$pur_item['bonusqty']:0;
				$get_product_report = $this->db->select('*');
				$get_product_report = $this->db->from('product_report');
				$get_product_report = $this->db->where('product_code',$pur_item['product_id']);
				$get_product_report = $this->db->order_by('id','desc');
				$get_product_report = $this->db->limit('1');
				$get_product_report = $this->db->get()->row();

				$opening_balance = $get_product_report->balance_qty;
				$product_balance = $opening_balance + $pur_item['qty'] + $bonusqty;
				
				$product_report = array(
					'product_code'	=> $pur_item['product_id'],
					'opening_qty'	=> $opening_balance,
					'purchase_qty'	=> $pur_item['qty'],
					'bonusqty'		=> !empty($pur_item['bonusqty'])?$pur_item['bonusqty']:0,
					'sales_qty'		=> 0,
					'balance_qty'   => $product_balance,
					'created_by'	=> $this->session->userdata('user_id'),
					'created_date'	=> date('Y-m-d H:i:s'),
				);
				$this->db->insert('product_report',$product_report);
				
				
					
			
				$tank_warehouse = $pur_item['tank_warehouse'];
				foreach ($tank_warehouse as $warehouse)
				{
					if(!empty($warehouse['qty']))
					{
						$ow_id			= $warehouse['ow_id'];
						$outlet_id		= $this->input->post('outlet');
						$product_code	= $warehouse['product_code'];
						$qty			= $warehouse['qty'];
						$type			= $warehouse['type'];
						$inventory = $this->Purchaseorder_model->CheckInventory($ow_id,$outlet_id,$type,$product_code);
						if($inventory->num_rows()>0)
						{
							$totalQtynow_qty = $inventory->row()->qty + $qty; 
							$totalQty = $inventory->row()->qty + $qty; 
							$inventory_id = $inventory->row()->id; 
							$data_inventory = array( 'qty' => $totalQty );
							$this->Purchaseorder_model->data_inventoryUpdate($data_inventory,$inventory_id);
						}
						else
						{
							$totalQtynow_qty = $qty;
							$inserinventory = array('product_code' => $product_code,
								'outlet_id' => $outlet_id,
								'qty' => $qty,
								'ow_id' => $ow_id,
								'type' => $type,
								'date' => date('Y-m-d H:i:s'),
							);
							$inventory_id = $this->Constant_model->insertDataReturnLastId('inventory', $inserinventory);
						}
						
						
							$getStore		= $this->Constant_model->OutletWarehouseget($ow_id);
							$oldstore		= $getStore->s_stock;
							$storeid		= $getStore->store_id;
							$newstoreQty = $oldstore + $qty;

							$data_storeupdate = array(
								's_stock' => $newstoreQty,
								's_stock_upated' => $newstoreQty,
							);
							$this->Constant_model->UpdateStoreInventory($data_storeupdate, $storeid);
						
						
						
					$inventory_changes = array(
						'product_code'		=>	$product_code,
						'outlet_id'			=>	$outlet_id,
						'qty'				=>	$qty,
						'available_qty'		=>	$totalQtynow_qty,
						'tank_warehouse_id'	=>	$ow_id,
						'type'				=>	$type,
						'price'				=>	$pur_item['new_price'],
						'amount'			=>	$pur_item['subtotal'],
						'created_by'		=>	$this->session->userdata('user_id'),
						'created_date'		=>	date('Y-m-d H:i:s'),
						'purchase_sale_type'		=>	1,
					);
					$this->Constant_model->insertDataReturnLastId('inventory_changes', $inventory_changes);
					
						
						$purchase_received = array(
							'purchase_item_id' => $purchase_item_id,
							'purchase_id'	=> $po_id,
							'outlet_id'		=> $outlet_id,
							'tank_qty'		=> $qty,
							'tank_id'		=> $ow_id,
							'type'			=> $type,
							'inventory_id'	=> $inventory_id,
							'created_at'	=> date('Y-m-d H:i:s'),
						);

						$this->Constant_model->insertDataReturnLastId('purchase_received', $purchase_received);
						
					}
				}
			}
		}
		
		$success = $this->Purchaseorder_model->DeletePurchaseItemTemporary();
		if($success)
		{
			$this->session->set_flashdata('alert_msg', array('success', 'Create Purchase Order', "Successfully Created Purchase Received : $po_numb"));
			$json['success'] = true;
		}
		else
		{
			$json['error'] = true;
		}
		echo json_encode($json);
	}
	
	public function SubmitData()
	{
		$purchase_id		= $this->input->post('purchase_id');
		$purchase_bill_no	= $this->input->post('purchase_bill_no');
		$success = $this->Purchaseorder_model->UpdateMainPurchaseStatus($purchase_id,$purchase_bill_no);
		if($success)
		{
			if(!empty($this->input->post('warehouse')))
			{
				$warehouse = $this->input->post('warehouse');
				foreach ($warehouse as $ware)
				{
					if(!empty($ware['qty']) && $ware['qty']!="0")
					{
						$ow_id			= $ware['ow_id'];
						$outlet_id		= $ware['outlet_id'];
						$type			= $ware['type'];
						$product_code	= $ware['product_code'];
						$qty			= $ware['qty'];
						
						
						$storeid		= $ware['store_id'];
						$purchaseid		= $ware['purchase_item_id'];
						$inventory = $this->Purchaseorder_model->CheckInventory($ow_id,$outlet_id,$type,$product_code);
						if($inventory->num_rows()>0)
						{
							$totalQty = $inventory->row()->qty + $qty; 
							$totalQtynow_qty = $inventory->row()->qty + $qty; 
							$inventory_id = $inventory->row()->id; 
							$data_inventory = array('qty' => $totalQty,
								);
							$this->Purchaseorder_model->data_inventoryUpdate($data_inventory,$inventory_id);
						}
						else
						{
							$totalQtynow_qty = $qty;
							$inserinventory = array('product_code' => $product_code,
								'outlet_id' => $outlet_id,
								'qty' => $qty,
								'ow_id' => $ow_id,
								'type' => $type,
								'date' => date('Y-m-d H:i:s'),
							);
							$inventory_id = $this->Constant_model->insertDataReturnLastId('inventory', $inserinventory);
						}
						$stockQty = $this->Purchaseorder_model->getStoreInventory($storeid);
						$newstoreQty = $stockQty + $qty;
						$data_storeupdate = array(
							's_stock' => $newstoreQty,
							's_stock_upated' => $newstoreQty,
						);
						$this->Constant_model->UpdateStoreInventory($data_storeupdate, $storeid);
						
						$purchase_received = array('purchase_item_id' => $purchaseid,
							'purchase_id'	=> $purchase_id,
							'outlet_id'		=> $outlet_id,
							'tank_qty'		=> $qty,
							'tank_id'		=> $ow_id,
							'type'			=> $type,
							'inventory_id'	=> $inventory_id,
							'created_at'	=> date('Y-m-d H:i:s'),
						);
						
						$this->Constant_model->insertDataReturnLastId('purchase_received', $purchase_received);
						
						
						$item_purchase_data = $this->Constant_model->GetPurchaseItemData($purchaseid);
						
						$inventory_changes = array(
								'product_code'		=>	$product_code,
								'outlet_id'			=>	$outlet_id,
								'qty'				=>	$qty,
								'available_qty'		=>	$totalQtynow_qty,
								'tank_warehouse_id'	=>	$ow_id,
								'type'				=>	$type,
								'price'				=>	!empty($item_purchase_data->cost)?$item_purchase_data->cost:0,
								'amount'			=>	!empty($item_purchase_data->subTotal)?$item_purchase_data->subTotal:0,
								'created_by'		=>	$this->session->userdata('user_id'),
								'created_date'		=>	date('Y-m-d H:i:s'),
								'purchase_sale_type'		=>	1,
						);
						$this->Constant_model->insertDataReturnLastId('inventory_changes', $inventory_changes);

						$bonusqty =  !empty($item_purchase_data->bonusqty)?$item_purchase_data->bonusqty:0;
						
						$get_product_report = $this->db->select('*');
						$get_product_report = $this->db->from('product_report');
						$get_product_report = $this->db->where('product_code',$product_code);
						$get_product_report = $this->db->order_by('id','desc');
						$get_product_report = $this->db->limit('1');
						$get_product_report = $this->db->get()->row();

						$opening_balance = $get_product_report->balance_qty;
						$product_balance = $opening_balance + $qty +$bonusqty;

						$product_report = array(
							'product_code'	=> $product_code,
							'opening_qty'	=> $opening_balance,
							'purchase_qty'	=> $qty,
							'bonusqty'		=> $bonusqty,
							'sales_qty'		=> 0,
							'balance_qty'   => $product_balance,
							'created_by'	=> $this->session->userdata('user_id'),
							'created_date'	=> date('Y-m-d H:i:s'),
						);
						$this->db->insert('product_report',$product_report);

						
						
						if(!empty($ware['batch_no']))
						{
							$batch_no		= $ware['batch_no'];
							$expire_date	= $ware['expire_date'];

							foreach( $batch_no as $index => $batch ) {
								if(!empty($batch) || !empty($expire_date[$index]))
								{
									$multi_batch_expire = array('inventory_id' => $inventory_id, 
										'batch_no'		=> $batch, 
										'expirydate'	=> date('Y-m-d', strtotime($expire_date[$index])), 
										'created_date'	=> date('Y-m-d H:i:s'), 
									);
								$this->Constant_model->insertDataReturnLastId('batch_expire_multi', $multi_batch_expire);
								}
							}
						}

						$this->Purchaseorder_model->UpdatePurchaseItemStatus($purchaseid);
					}
				}
			}
			$json['success'] = true;
		}
		else
		{
			$json['eorror'] = true;	
		}
		echo json_encode($json);
	}
	
	
	
	
	public function DeleteTemporyPurchseItemData()
	{
		$success = $this->Purchaseorder_model->DeletePurchaseItemTemporary();
		$json['success'] = true;	
		echo json_encode($json);
	}
	
	public function WareHouseTankReceive()
	{
		$product_code	= $this->input->post('product_code');
		$product_name	= $this->input->post('product_name');
		$ordered_qty	= $this->input->post('ordered_qty');
		$purchaseid		= $this->input->post('purchaseid');
		$i				= $this->input->post('getrow');
		
		$product_category	= $this->Purchaseorder_model->getCategoryWareHouseTank($product_code);
		$outletid			= $product_category->outlet_id_fk;
		$product_id			= $product_category->id;
		
		$html_ware		= '';
	
			$getWarehouse = $this->Constant_model->getOutletWareHouse($outletid);
			$html_ware.='<div class="row"  style="text-align: center; font-size: 13px; color: #388E3C; background-color: #C8E6C9; padding-top: 7px; padding-bottom: 7px; margin-left: 0px; margin-right: 0px;">'.$product_name.'<span style="float:right;border:none; display:none;" class="btn btn-primary product_heading_display'.$purchaseid.'  product_heading" id="'.$purchaseid.'"><i class="fa fa-eye" aria-hidden="true"></i></span></div>
				
						<span id="TankSlideup'.$purchaseid.'">
						<input type="hidden" value="'.$ordered_qty.'" id="ordered_qty'.$purchaseid.'">
						<input type="hidden" value="'.$purchaseid.'" id="purchaseid'.$purchaseid.'">	
						<table class="table table-bordered table-responsive">
						<thead>
							<tr>
								<th width="20%">Warehouse</th>
								<th width="20%">Quantity</th>
								<th width="20%">Instock Qty</th>
								<th width="20%">Batch No</th>
								<th width="20%">Expiry Date</th>
							</tr>
						</thead>
					<tbody>';
	
			foreach ($getWarehouse as $ware)
			{
				$ow_id			= $ware->ow_id;
				$type			= 0;
				$inventory = $this->Purchaseorder_model->CheckInventory($ow_id,$outletid,$type,$product_code);
				
				$html_ware.='
				<tr>
					<td>'.$ware->s_name.'</td>
					<td>
						<input type="text" placeholder="0" name="warehouse['.$i.'][qty]" type="text" class="form-control allqtytankandWarehouse warehouse_quantity'.$purchaseid.'" min="0" max="5" value="" style="width: 100%;">
						<input  name="warehouse['.$i.'][ow_id]" value='.$ware->ow_id.' type="hidden" class="form-control">
						<input  name="warehouse['.$i.'][outlet_id]" value='.$outletid.' type="hidden" class="form-control">
						<input  name="warehouse['.$i.'][type]" value="0" type="hidden" class="form-control">
						<input  name="warehouse['.$i.'][product_code]" value='.$product_code.' type="hidden" class="form-control">
						<input  name="warehouse['.$i.'][purchase_item_id]" value='.$purchaseid.' type="hidden" class="form-control">
						<input  name="warehouse['.$i.'][store_id]" value='.$ware->w_id.' type="hidden" class="form-control">
					</td>';
				if($inventory->num_rows()>0)
				{
						$html_ware.='<td><input placeholder="0" readonly name="warehouse['.$i.'][invetory_qty]" value="'.$inventory->row()->qty.'" type="text" class="form-control"></td>
							<td>
								<input  name="warehouse['.$i.'][batch_no][]" value="'.$inventory->row()->batch_no.'" type="text" class="form-control">
								<span id="item_batch_row'.$i.'"></span>
								<button type="button" class="btn btn-primary AddBatch" id='.$i.'>Add Batch and Expire Date</button>
							</td>';
						
						if($inventory->row()->expire_date!='0000-00-00')
						{
							$dateware = date('m/d/Y',  strtotime($inventory->row()->expire_date));
						}
						else
						{
							$dateware = '';
						}
						$html_ware.='<td><input   name="warehouse['.$i.'][expire_date][]" value="'.$dateware.'" type="text" class="form-control datepicker_class"> 
								<span id="item_expire_row'.$i.'"></span></td>';
							
				}
				else
				{
						$html_ware.='<td><input readonly name="warehouse['.$i.'][invetory_qty]" placeholder="0" value="" type="text" class="form-control"></td>
							<td><input  name="warehouse['.$i.'][batch_no]" value="" placeholder="0" type="text" class="form-control"></td>
							<td><input  name="warehouse['.$i.'][expire_date]" value="" type="text" class="form-control datepicker_class"></td>';
				}
				
				$html_ware.='</tr>';
				$i++;
			}
			$html_ware.='<tr>
							<td colspan="100%"><button type="button" class="btn btn-success add_to_warehouse_one" id="'.$purchaseid.'" style="background-color: green; ">Add To Warehouse</button></td>
						</tr>
					</tbody>
				</table></span><br>';
			$json['row'] = $i;
			$json['html'] = $html_ware;
	
		
		
		echo json_encode($json);
	}
	
	
	
	
	
	
	
	
	
	public function getProductPrice()
	{
		$product_code = $this->input->post('product_code');
		$product = $this->Constant_model->getProductPrice($product_code);
		$json['purchse_price'] = $product->purchase_price;
		echo json_encode($json);
	}
			
	// View Purchase Return Portion
	public function purchase_return()
	{   
                $permisssion_url = 'purchase_return';
		$permission = $this->Constant_model->getPermissionPageWise($permisssion_url);
                
		if($permission->view_menu_right == 0)
		{
			redirect('dashboard');
		}
		$data['getPurchaseReturn']	= $this->Purchaseorder_model->getPurchaseReturn();
		$this->load->view('purchase_return',$data);
	}
	
	public function create_purchase_return()
	{
		$data['getmaxIdPurchaseReturn']	= $this->Constant_model->getmaxIdPurchaseReturn();
		$data['getPaymentType']	= $this->Constant_model->getPaymentType();
		$data['getOutlets']				= $this->Constant_model->getOutlets();
		$data['getSuppliers']			= $this->Constant_model->getSuppliers();
		$userdata						= $this->Pos_model->getUserRoll();
		$data['RollID']					= $userdata->role_id;
		$data['LoginUser']				= $userdata->fullname;
		$outlet_id						= $userdata->outlet_id;
		if(!empty($outlet_id))
		{
			$data['outlet_id']			= $outlet_id;
			$data['UserOutletName']		= $this->Pos_model->UserOutlet($outlet_id);	
		}
		$this->load->view('create_purchase_return',$data);
	}
	
	
	
	
	public function create_purchase_return_batch_expiry()
	{
		$ourlet		 = $this->input->get('outlet');
		$supplier	 = $this->input->get('supplier');
		$code		 = $this->input->get('code');
		$data['qty'] = $this->input->get('qty');
		$type		 = $this->input->get('type');
		$ow_id		 = $this->input->get('ow_id');
		$data['batch_expiry_id'] = $this->input->get('batch_expiry_id');
		$data['type']	= $type;
		$data['ow_id']	= $ow_id;
		if($type == 0)
		{
			$store =  $this->Constant_model->StoreSingleData($ow_id);
			$data['store_tank'] = $store->s_name;
		}
		else
		{
			$tank =  $this->Constant_model->TankSingleData($ow_id);
			$data['store_tank'] = $tank->fuel_tank_number;
		}
		
		$data['getmaxIdPurchaseReturn']	= $this->Constant_model->getmaxIdPurchaseReturn();
		
		$data['getOutlets']		= $this->Constant_model->GetOutletDetail($ourlet);
		$data['getSuppliers']	= $this->Constant_model->getSuppliersSingle($supplier);
		
		$data['product_code']	= $code;
		
		$getProductSingle		= $this->Constant_model->getProductSingle($code);
		$userdata				= $this->Pos_model->getUserRoll();
		$data['RollID']			= $userdata->role_id;
		$data['LoginUser']		= $userdata->fullname;
		$outlet_id				= $getProductSingle->outlet_id_fk;
		if(!empty($outlet_id))
		{
			$data['outlet_id']		= $outlet_id;
			$data['UserOutletName']	= $this->Pos_model->UserOutlet($outlet_id);	
		}
		
		$data['getPaymentType']	= $this->Constant_model->getOutletWisePaymentMethod($outlet_id);
		
		$this->load->view('create_purchase_return_batch_expiry',$data);
	}
	
	public function getOutletWiseTankWarehouse()
	{
		$default_store = $this->Pos_model->getDefaultCustomer();
		$default_store_id = $default_store->default_store_id;
		$html		= '';
		$outlet_id	= $this->input->post('outlet_id');
		$product_data = $this->Constant_model->getOutletProduct($outlet_id);
		$warehouse	= $this->Constant_model->getOutletWareHouse($outlet_id);
		$html.= '<option value="">Select Warehouse / Tank</option>';
		foreach ($warehouse as $ware)
		{
			$selected = '';
			if($default_store_id == $ware->w_id)
			{
				$selected = 'selected'; 
			}
		
			$html.= '<option '.$selected.' data-val="0" value='.$ware->ow_id.'>'.$ware->s_name.'</option>';
		}
		
		$p = '';
		$p.= '<option value="">Select Product</option>';
		foreach ($product_data as $pro)
		{
			$p.= '<option  value='.$pro->code.'>'.$pro->name.'</option>';
		}
		
		$getOutletWisePaymentMethod = $this->Constant_model->getOutletWisePaymentMethod($outlet_id);
		
		
		$payment = '';
		
		
		foreach ($getOutletWisePaymentMethod as $payment_outlet) {
			if($payment_outlet->name == 'Credit Note' || $payment_outlet->name == 'Cash' || $payment_outlet->name == 'Credit cards' || $payment_outlet->name == 'Cheque' || $payment_outlet->name == 'Vouchers' || $payment_outlet->name == 'Gift Card')
			{
				$payment .= "<option value='".$payment_outlet->id."' >".$payment_outlet->name."</option>";
			}
		}
	
		$json['payment'] = $payment;
		$json['product'] = $p;
		$json['success'] = $html;
		echo json_encode($json);
	}
	
	public function getOutletWiseTankWarehouseProduct()
	{
		$outlet_id		 = $this->input->post('outlet_id');
		$warehouse_tank	 = $this->input->post('warehouse_tank');
		$product_data 	= $this->Constant_model->getOutletWiseTankWarehouseProduct($outlet_id,$warehouse_tank);
		$p = '';
		$p.= '<option value="">Search Product by Name OR Code</option>';
		foreach ($product_data as $pro)
		{
			$p.= '<option value='.$pro->product_code.'>'.$pro->product_code.'['.$pro->prdocuname.']</option>';
		}
		
		$json['product'] = $p;
		echo json_encode($json);
	}
	
	public function getOutletWiseAllProduct()
	{
		$outlet_id		 = $this->input->post('outlet_id');
		$warehouse_tank	 = $this->input->post('warehouse_tank');
		$type			 = $this->input->post('type');
		$product_data 	= $this->Purchaseorder_model->getOutletWiseAllProduct($outlet_id);
		$p = '';
		$p.= '<option value="">Search Product by Name OR Code</option>';
		foreach ($product_data as $pro)
		{
			$p.= '<option value="'.$pro->product_code.'">'.$pro->product_code.'['.$pro->prdocuname.']</option>';
		}
		
		$json['product'] = $p;
		echo json_encode($json);
	}

	public function Insert_Return_multiple()
	{
	
			$return		 = $this->input->post('return');
			foreach ($return as $value)
			{
				$user_outlet = $value['outlet_id'];
				$type        = $value['type'];
				$warehouse   = $value['warehouse_tank'];
				$qty		 = $value['returned_qty'];
				$pcode		 = $value['product_code'];
				
				$purchase_return = array(
					'outlet_id'		  => $value['outlet_id'],
					'warehouse_tank'  => $warehouse,
					'type'			  => $type,
					'returned_qty'	  => $qty,
					'ref_bill_no'	  => $value['ref_bill_no'],
					'supplier_id'	  => $value['supplier_id'],
					'product_code'	  => $value['product_code'],
					'refund_amount'	  => $value['refund_amount'],
					'payment_type'	  => $value['paid_by'],
					'cheque_number'   => $value['cheque'],
					'cheque_date'	  => date('Y-m-d',  strtotime($value['cheque_date'])),
					'bank'			  => $value['bank'],
					'card_number'	  => $value['addi_card_numb'],
					'Gift_Card'	      => $value['Gift_Card'],
					'voucher_number'  => $value['Voucher'],
					'refund_tax'	  => $value['refund_tax'],
					'reason'		  => $value['reason'],
					'created_by'	  => $this->session->userdata('user_id'),
					'created_date'	  => date('Y-m-d H:i:s')
					);
		
				$return_id = $this->Constant_model->insertDataReturnLastId('purchase_return', $purchase_return);
				$ckInvData = $this->Pos_model->getDataInventory($pcode,$user_outlet,$type,$warehouse);
				
				
				if($type == 0)
				{
					$getStore = $this->Constant_model->OutletWarehouseget($warehouse);
					$oldstore = $getStore->s_stock;
					$newstoreQty = $getStore->s_stock - $qty;

					$data_storeupdate = array(
						's_stock' => $newstoreQty,
						's_stock_upated' => $newstoreQty,
					);
					$this->Constant_model->UpdateStoreInventory($data_storeupdate, $getStore->store_id);
				}
				else
				{
					$outlet_id_array = $this->db->select('current_balance')->where('id',$warehouse)->get('fuel_tanks')->row_array();
					$newbalance = $outlet_id_array['current_balance'] - $qty;
					$update_inventory = array(
						'current_balance'   => $newbalance,
					);

					$this->Constant_model->UpdateTankBalance($update_inventory, $warehouse);
				}

				$ex_inv_id = $ckInvData[0]->id;
				$ex_qty = $ckInvData[0]->qty;

				$deduct_qty = 0;
				$deduct_qty = $ex_qty - $qty;

				$upd_inv_data = array(
					'qty' => $deduct_qty,
				);
				$this->Constant_model->updateData('inventory', $upd_inv_data, $ex_inv_id);

				
				$pay_query = $this->Constant_model->getPaymentIDName($value['paid_by']);
				$pay_balance = $pay_query->balance;
				$now_balance = $pay_balance - $value['refund_amount'];
				$pay_data = array(
						'balance' => $now_balance,
						'updated_user_id' => $this->session->userdata('user_id'),
						'updated_datetime' => date('Y-m-d H:i:s')
				);

				$this->db->update('payment_method', $pay_data, array('id' => $value['paid_by']));

				$transaction_data = array(
					'trans_type'	=> 'return',
					'account_number'=> $value['paid_by'],
					'outlet_id'		=> $value['outlet_id'],
					'amount'		=> $value['refund_amount'],
					'bring_forword' => $pay_balance,
					'cheque_number' => $value['cheque'],
					'cheque_date'	=> date('Y-m-d',  strtotime($value['cheque_date'])),
					'bank'			=> $value['bank'],
					'card_number'	=> $value['addi_card_numb'],
					'voucher_number'=> $value['Voucher'],
					'created_by'	=> $this->session->userdata('user_id'),
					'created'		=> date('Y-m-d H:i:s')
				);	
				$this->Constant_model->insertDataReturnLastId('transactions', $transaction_data);
			}
			
			$this->session->set_flashdata('SUCCESSMSG', "Purchase Return Successfully Save!!");
			$json['return_id'] = $return_id;
			echo json_encode($json);
	}
	
	
	
	public function Insert_Purchase_Return()
	{
		$pcode		 = $this->input->post('product_code');
		$user_outlet = $this->input->post('outlet');
		$type        = $this->input->post('type');
		$warehouse   = $this->input->post('warehouse_tank');
		$qty		 = $this->input->post('returned_qty');
		$purchase_return = array(
			'outlet_id'		  => $this->input->post('outlet'),
			'batch_expiry_id' => !empty($this->input->post('batch_expiry_id'))?$this->input->post('batch_expiry_id'):'',
			'warehouse_tank'  => $this->input->post('warehouse_tank'),
			'type'			  => $this->input->post('type'),
			'returned_qty'	  => $this->input->post('returned_qty'),
			'ref_bill_no'	  => $this->input->post('ref_bill_no'),
			'supplier_id'	  => $this->input->post('supplier_id'),
			'product_code'	  => $this->input->post('product_code'),
			'refund_amount'	  => $this->input->post('refund_amount'),
			'payment_type'	  => $this->input->post('payment_type'),
			'cheque_number'   => $this->input->post('cheque'),
			'cheque_date'	  => date('Y-m-d',  strtotime($this->input->post('cheque_date'))),
			'bank'			  => $this->input->post('bank'),
			'card_number'	  => $this->input->post('addi_card_numb'),
			'Gift_Card'	      => $this->input->post('Gift_Card'),
			'voucher_number'  => $this->input->post('Voucher'),
			'refund_tax'	  => $this->input->post('refund_tax'),
			'reason'		  => $this->input->post('reason'),
			'created_by'	  => $this->session->userdata('user_id'),
			'created_date'	  => date('Y-m-d H:i:s')
			);
		
			$return_id = $this->Constant_model->insertDataReturnLastId('purchase_return', $purchase_return);
			$ckInvData = $this->Pos_model->getDataInventory($pcode,$user_outlet,$type,$warehouse);
			
			if($type == 0)
			{
				$getStore = $this->Constant_model->OutletWarehouseget($warehouse);
				$oldstore = $getStore->s_stock;
				$newstoreQty = $getStore->s_stock - $qty;
					
				$data_storeupdate = array(
					's_stock' => $newstoreQty,
					's_stock_upated' => $newstoreQty,
				);
				$this->Constant_model->UpdateStoreInventory($data_storeupdate, $getStore->store_id);
			}
			else
			{
				$outlet_id_array = $this->db->select('current_balance')->where('id',$warehouse)->get('fuel_tanks')->row_array();
				$newbalance = $outlet_id_array['current_balance'] - $qty;
				$update_inventory = array(
					'current_balance'   => $newbalance,
				);

				$this->Constant_model->UpdateTankBalance($update_inventory, $warehouse);
			}

			$ex_inv_id = $ckInvData[0]->id;
			$ex_qty = $ckInvData[0]->qty;

			$deduct_qty = 0;
			$deduct_qty = $ex_qty - $qty;

			$upd_inv_data = array(
				'qty' => $deduct_qty,
			);
			$this->Constant_model->updateData('inventory', $upd_inv_data, $ex_inv_id);

		
			$pay_query = $this->Constant_model->getPaymentIDName($this->input->post('payment_type'));
			$pay_balance = $pay_query->balance;
			$now_balance = $pay_balance - $this->input->post('refund_amount');
			$pay_data = array(
					'balance' => $now_balance,
					'updated_user_id' => $this->session->userdata('user_id'),
					'updated_datetime' => date('Y-m-d H:i:s')
			);
				
			$this->db->update('payment_method', $pay_data, array('id' => $this->input->post('payment_type')));
			
			$transaction_data = array(
				'trans_type'	=> 'return',
				'account_number'=> $this->input->post('payment_type'),
				'outlet_id'		=> $this->input->post('outlet'),
				'amount'		=> $this->input->post('refund_amount'),
				'bring_forword' => $pay_balance,
				'cheque_number' => $this->input->post('cheque'),
				'cheque_date'	=> date('Y-m-d',  strtotime($this->input->post('cheque_date'))),
				'bank'			=> $this->input->post('bank'),
				'card_number'	=> $this->input->post('addi_card_numb'),
				'voucher_number'	=> $this->input->post('Voucher'),
				'created_by'	=> $this->session->userdata('user_id'),
				'created'		=> date('Y-m-d H:i:s')
			);	
			$this->Constant_model->insertDataReturnLastId('transactions', $transaction_data);
			$this->session->set_flashdata('SUCCESSMSG', "Purchase Return Successfully Save!!");
			$json['return_id'] = $return_id;
			echo json_encode($json);
	}
	// End Purchase Return Portion
	
	
	// View Pay Suppliers;viewpo
	public function pay_suppliers() 
	{
		$permisssion_url = 'pay_suppliers';
		$permission = $this->Constant_model->getPermissionPageWise($permisssion_url);
                
		if($permission->view_menu_right == 0)
		{
			redirect('dashboard');
		}
		$paginationData = $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');
		$setting_dateformat = $paginationData[0]->datetime_format;
		$data['results'] = $this->Purchaseorder_model->fetch_debit_data();
		$data['bank_account'] = $this->bdt_model->getBankAccountNumber();
		$data['dateformat'] = $setting_dateformat;
		$this->load->view('pay_suppliers', $data);
	}
	
	public function archivepo() {
		$id = $this->input->get('id');
		$update['status'] = 7;
		$this->db->where('id', $id);
		$save = $this->db->update('purchase_order', $update);
		if ($save) {
				redirect('purchase_order/po_archived?p_status=7');
		} else {
			redirect('purchase_order/po_received?p_status=7');
		}
	}
	
	//View Bills
	public function purchase_bills() {
            
                $permisssion_url = 'purchase_bills';
		$permission = $this->Constant_model->getPermissionPageWise($permisssion_url);
                
		if($permission->view_menu_right == 0)
		{
			redirect('dashboard');
		}
		$paginationData		= $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');
		$setting_dateformat = $paginationData[0]->datetime_format;
		$data['bill_data']	= $this->Purchaseorder_model->purchase_bill_data();
		$data['dateformat'] = $setting_dateformat;
		$data['user_role']	= $this->session->userdata('user_role');
		$this->load->view('purchase_bills', $data);
	}
	
	//Bonus Bills
	public function purchase_bonus() {
		$permisssion_url = 'purchase_bonus';
		$permission = $this->Constant_model->getPermissionPageWise($permisssion_url);
                
		if($permission->view_menu_right == 0)
		{
			redirect('dashboard');
		}
                $data['getSupplier']		= $this->Bill_Numbering_model->getSupplier();
		$data['getOutlets']			= $this->Constant_model->getOutlets();
		$data['getBonusPurchase']	= $this->Constant_model->getBonusPurchase();
		$this->load->view('view_purchase_bonus', $data);
	}
	
	//Exportpurchase Bonus
	public function exportpurchase_bonus() {
		$siteSettingData = $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');
		$site_dateformat = $siteSettingData[0]->datetime_format;
		$site_currency	 = $siteSettingData[0]->currency;

		$this->load->library('excel');

		require_once './application/third_party/PHPExcel.php';
		require_once './application/third_party/PHPExcel/IOFactory.php';

		// Create new PHPExcel object
		$objPHPExcel = new PHPExcel();

		$default_border = array(
			'style' => PHPExcel_Style_Border::BORDER_THIN,
			'color' => array('rgb' => '000000'),
		);

		$acc_default_border = array(
			'style' => PHPExcel_Style_Border::BORDER_THIN,
			'color' => array('rgb' => 'c7c7c7'),
		);
		$outlet_style_header = array(
			'font' => array(
				'color' => array('rgb' => '000000'),
				'size' => 10,
				'name' => 'Arial',
				'bold' => true,
			),
		);
		$top_header_style = array(
			'borders' => array(
				'bottom' => $default_border,
				'left' => $default_border,
				'top' => $default_border,
				'right' => $default_border,
			),
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb' => 'ffff03'),
			),
			'font' => array(
				'color' => array('rgb' => '000000'),
				'size' => 15,
				'name' => 'Arial',
				'bold' => true,
			),
			'alignment' => array(
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			),
		);
		$style_header = array(
			'borders' => array(
				'bottom' => $default_border,
				'left' => $default_border,
				'top' => $default_border,
				'right' => $default_border,
			),
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb' => 'ffff03'),
			),
			'font' => array(
				'color' => array('rgb' => '000000'),
				'size' => 12,
				'name' => 'Arial',
				'bold' => true,
			),
			'alignment' => array(
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
			),
		);
		$account_value_style_header = array(
			'borders' => array(
				'bottom' => $default_border,
				'left' => $default_border,
				'top' => $default_border,
				'right' => $default_border,
			),
			'font' => array(
				'color' => array('rgb' => '000000'),
				'size' => 12,
				'name' => 'Arial',
			),
			'alignment' => array(
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
			),
		);
		$text_align_style = array(
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			),
			'borders' => array(
				'bottom' => $default_border,
				'left' => $default_border,
				'top' => $default_border,
				'right' => $default_border,
			),
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb' => 'ffff03'),
			),
			'font' => array(
				'color' => array('rgb' => '000000'),
				'size' => 12,
				'name' => 'Arial',
				'bold' => true,
			),
		);

		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:H1');
		$objPHPExcel->getActiveSheet()->setCellValue('A1', 'Purchase Bonuses Report');

		$objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($top_header_style);
		$objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($top_header_style);
		$objPHPExcel->getActiveSheet()->getStyle('C1')->applyFromArray($top_header_style);
		$objPHPExcel->getActiveSheet()->getStyle('D1')->applyFromArray($top_header_style);
		$objPHPExcel->getActiveSheet()->getStyle('E1')->applyFromArray($top_header_style);
		$objPHPExcel->getActiveSheet()->getStyle('F1')->applyFromArray($top_header_style);
		$objPHPExcel->getActiveSheet()->getStyle('G1')->applyFromArray($top_header_style);
		$objPHPExcel->getActiveSheet()->getStyle('H1')->applyFromArray($top_header_style);

		$objPHPExcel->getActiveSheet()->setCellValue('A2', 'Date & Time');
		$objPHPExcel->getActiveSheet()->setCellValue('B2', 'Product Code');
		$objPHPExcel->getActiveSheet()->setCellValue('C2', 'Product Name');
		$objPHPExcel->getActiveSheet()->setCellValue('D2', 'Outlet');
		$objPHPExcel->getActiveSheet()->setCellValue('E2', 'Bill No');
		$objPHPExcel->getActiveSheet()->setCellValue('F2', 'Supplier');
		$objPHPExcel->getActiveSheet()->setCellValue('G2', 'Quantity');
		$objPHPExcel->getActiveSheet()->setCellValue('H2', 'Value');


		$objPHPExcel->getActiveSheet()->getStyle('A2')->applyFromArray($style_header);
		$objPHPExcel->getActiveSheet()->getStyle('B2')->applyFromArray($style_header);
		$objPHPExcel->getActiveSheet()->getStyle('C2')->applyFromArray($style_header);
		$objPHPExcel->getActiveSheet()->getStyle('D2')->applyFromArray($style_header);
		$objPHPExcel->getActiveSheet()->getStyle('E2')->applyFromArray($style_header);
		$objPHPExcel->getActiveSheet()->getStyle('F2')->applyFromArray($style_header);
		$objPHPExcel->getActiveSheet()->getStyle('G2')->applyFromArray($style_header);
		$objPHPExcel->getActiveSheet()->getStyle('H2')->applyFromArray($style_header);

		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(30);

		$row = 3;
		$custDtaData = $this->Constant_model->getBonusPurchase();
		foreach ($custDtaData as $value) {
			$totalvalue = $value->purchase_price * $value->bonusqty;
			$objPHPExcel->getActiveSheet()->setCellValue('A' . $row, $value->created_datetime);
			$objPHPExcel->getActiveSheet()->setCellValue('B' . $row, $value->product_code);
			$objPHPExcel->getActiveSheet()->setCellValue('C' . $row, $value->productname);
			$objPHPExcel->getActiveSheet()->setCellValue('D' . $row, $value->outletsname);
			$objPHPExcel->getActiveSheet()->setCellValue('E' . $row, $value->bill_no);
			$objPHPExcel->getActiveSheet()->setCellValue('F' . $row, $value->suppliersname);
			$objPHPExcel->getActiveSheet()->setCellValue('G' . $row, $value->bonusqty);
			$objPHPExcel->getActiveSheet()->setCellValue('H' . $row, round($totalvalue, 2));
			$row++;
		}

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="purchase_bonus_report.xls"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
	}
	
	

    // ****************************** View Page -- START ****************************** //
	
    // View Purchase Order;
    public function po_view()
    {
        $permisssion_url = 'po_view';
		$permission = $this->Constant_model->getPermissionPageWise($permisssion_url);
		if($permission->view_menu_right == 0)
		{
			redirect('dashboard');
		}
		
        $paginationData = $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');
        $pagination_limit = $paginationData[0]->pagination;
        $setting_dateformat = $paginationData[0]->datetime_format;
		$data['type'] = "All";
		$data['getOutlets']		= $this->Constant_model->getOutlets();
		$data['getSupplier']	= $this->Constant_model->getSuppliers();
		$data['getPaymentType'] = $this->Constant_model->getPaymentType();
		$data['results']		= $this->Purchaseorder_model->fetch_po_data();
		
		$data['status'] = $this->db->select('id,name')->from('purchase_order_status')->where_not_in('id', array(1, 2, 3))->get()->result_array();
        $data['dateformat'] = $setting_dateformat;
        $this->load->view('purchase_order', $data);
    }
	
	public function po_raised() {
		$paginationData = $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');
        $setting_dateformat = $paginationData[0]->datetime_format;
		$data['type'] = "Raised";
		$data['getOutlets'] = $this->Constant_model->getOutlets();
		$data['getSupplier'] = $this->Constant_model->getSuppliers();
		$data['getPaymentType'] = $this->Constant_model->getPaymentType();
		$data['results'] = $this->Purchaseorder_model->fetch_po_data();
		$data['p_status'] = $this->input->get('p_status');
		$data['status'] = $this->db->select('id,name')->from('purchase_order_status')->where_not_in('id', array(1, 2, 3))->get()->result_array();
        $data['dateformat'] = $setting_dateformat;
        $this->load->view('purchase_order', $data);
	}
	
	public function po_partial() {
		$paginationData = $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');
        $setting_dateformat = $paginationData[0]->datetime_format;
		$data['type'] = "Partial";
		$data['getOutlets'] = $this->Constant_model->getOutlets();
		$data['getSupplier'] = $this->Constant_model->getSuppliers();
		$data['getPaymentType'] = $this->Constant_model->getPaymentType();
		$data['results'] = $this->Purchaseorder_model->fetch_po_data();
		$data['p_status'] = $this->input->get('p_status');
		$data['status'] = $this->db->select('id,name')->from('purchase_order_status')->where_not_in('id', array(1, 2, 3))->get()->result_array();
        $data['dateformat'] = $setting_dateformat;
		$this->load->view('purchase_order', $data);
	}
	
	public function po_pending() {
		$paginationData = $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');
        $setting_dateformat = $paginationData[0]->datetime_format;
		$data['type'] = "Pending";
		$data['getOutlets'] = $this->Constant_model->getOutlets();
		$data['getSupplier'] = $this->Constant_model->getSuppliers();
		$data['getPaymentType'] = $this->Constant_model->getPaymentType();
		$data['results'] = $this->Purchaseorder_model->fetch_po_data();
		$data['p_status'] = $this->input->get('p_status');
		$data['status'] = $this->db->select('id,name')->from('purchase_order_status')->where_not_in('id', array(1, 2, 3))->get()->result_array();
        $data['dateformat'] = $setting_dateformat;
        $this->load->view('purchase_order', $data);
	}
	
	public function po_archived() {
		$paginationData = $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');
        $setting_dateformat = $paginationData[0]->datetime_format;
		$data['type'] = "Archived";
		$data['getOutlets'] = $this->Constant_model->getOutlets();
		$data['getSupplier'] = $this->Constant_model->getSuppliers();
		$data['getPaymentType'] = $this->Constant_model->getPaymentType();
		$data['results'] = $this->Purchaseorder_model->fetch_po_data();
		$data['p_status'] = $this->input->get('p_status');
		$data['status'] = $this->db->select('id,name')->from('purchase_order_status')->where_not_in('id', array(1, 2, 3))->get()->result_array();
        $data['dateformat'] = $setting_dateformat;
        $this->load->view('purchase_order', $data);
	}
	public function po_received() {
		$paginationData = $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');
        $setting_dateformat = $paginationData[0]->datetime_format;
		$data['type'] = "Received";
		$data['getOutlets'] = $this->Constant_model->getOutlets();
		$data['getSupplier'] = $this->Constant_model->getSuppliers();
		$data['getPaymentType'] = $this->Constant_model->getPaymentType();
		$data['results'] = $this->Purchaseorder_model->fetch_po_data();
		$data['p_status'] = $this->input->get('p_status');
		$data['status'] = $this->db->select('id,name')->from('purchase_order_status')->where_not_in('id', array(1, 2, 3))->get()->result_array();
        $data['dateformat'] = $setting_dateformat;
        $this->load->view('purchase_order', $data);
	}
	
	public function receivedpo() 
	{
		$id = $this->input->get('id');
		$data['getPurchase'] = $this->Purchaseorder_model->getPurchaseDetail($id);
		$data['getPurchaseItem'] = $this->Purchaseorder_model->getPurchaseItem($id);
		
		$settingResult = $this->db->get_where('site_setting');
		$settingData = $settingResult->row();
		$setting_dateformat = $settingData->datetime_format;
		$data['dateformat'] = $setting_dateformat;
		$data["tax"] = $settingData->tax;
		$data["currency"] = $settingData->currency;
		$data['id'] = $id;
		$this->load->view('received_po', $data);
	}
	
	public function UpdatePurchaseInvoice() {
		$productid = $this->input->post('productid');
		$inventory_id = $this->input->post('inventory_id');
		$mainidpurchaseid = $this->input->post('mainidpurchaseid');
		
//		$data_inventory = array('batch_no' => $this->input->post('batchno'),
//		'expire_date' => $this->input->post('expire_date'));

		$mainidpurchaseid_update = array('grandTotal' => $this->input->post('total_net'),
			'tax' => $this->input->post('totaltax'),
			'discount_amount' => $this->input->post('discount_amount'),
			'discount_percentage' => $this->input->post('discount_percent')
			);

		$data_purchase = array('ordered_qty' => $this->input->post('qty'),
			'bonusqty' => $this->input->post('bonusqty'),
			'discount_amount' => $this->input->post('sub_discount_amount'),
			'discount_percentage' => $this->input->post('discount'),
			'tax' => $this->input->post('tax'),
			'subTotal' => $this->input->post('net_amount'),
		);

		$this->Purchaseorder_model->mainidpurchaseid_Update($mainidpurchaseid_update, $mainidpurchaseid);
		$this->Purchaseorder_model->data_purchaseUpdate($data_purchase, $productid);
//		$this->Purchaseorder_model->data_inventoryUpdate($data_inventory, $inventory_id);
		$json['success'] = true;
		echo json_encode($json);
	}
	

	


	
	public function WareHouseTank()
	{
		$inventory_id = $this->input->post('inventory_id');
		$getInventory = $this->Purchaseorder_model->WareHouseTank($inventory_id);
		$outletid = $getInventory->outlet_id;
		$product_code = $getInventory->product_code;
		$html_ware = '';
		$html_tank = '';
		if($getInventory->type == 0)
		{
			$getWarehouse = $this->Constant_model->getOutletWareHouse($outletid);
			$html_ware.='<form method="post" id="formWarehouse"><table class="table table-bordered table-responsive">
						<thead>
							<tr>
								<th width="50%">Warehouse</th>
								<th width="50%">Quantity</th>
							</tr>
						</thead>
					<tbody>';
			$i = 0;
			foreach ($getWarehouse as $ware)
			{
				$html_ware.='
				<tr>
					<td>'.$ware->s_name.'</td>
					<td>
						<input type="text" name="warehouse['.$i.'][qty]" class="form-control warehouse_quantity" min="0" max="5" value="0" style="width: 100%;">
						<input  name="warehouse['.$i.'][ow_id]" value='.$ware->ow_id.' type="hidden" class="form-control">
						<input  name="warehouse['.$i.'][outlet_id]" value='.$outletid.' type="hidden" class="form-control">
						<input  name="warehouse['.$i.'][type]" value="0" type="hidden" class="form-control">
						<input  name="warehouse['.$i.'][product_code]" value='.$product_code.' type="hidden" class="form-control">
						<input  name="warehouse['.$i.'][store_id]" value='.$ware->w_id.' type="hidden" class="form-control">
					</td>
				</tr>';
				$i++;
			}
			$html_ware.='<tr>
							<td><span><span style="color: red; font-weight: bold;">Warning:</span> Once you click the <span style="color: black; font-weight: bold;">Add To Warehouse</span> button you will not able to change the data.</span></td>
							<td><button type="button" class="btn btn-success" id="add_to_warehouse" style="background-color: green; ">Add To Warehouse</button></td>
						</tr>
					</tbody>
				</table></form>';
			$json['html'] = $html_ware;
		}
		else
		{
			$gettank = $this->Constant_model->getOutletTank($outletid);
			$html_tank.='<form method="post" id="formTank"><table class="table table-bordered table-responsive">
				<thead>
					<tr>
						<th width="50%">Fuel Tank</th>
						<th width="50%">Quantity</th>
					</tr>
				</thead>
			<tbody>';
			$i = 0;
			foreach ($gettank as $fueltank)
			{
				$html_tank.='<tr>
						<td>'.$fueltank->fuel_tank_number.'</td>
						<td>
						<input  name="tank['.$i.'][qty]" type="text" class="form-control warehouse_quantity" min="0" max="5" value="0" style="width: 100%;">
						<input  name="tank['.$i.'][ow_id]" value='.$fueltank->id.' type="hidden" class="form-control">
						<input  name="tank['.$i.'][outlet_id]" value='.$outletid.' type="hidden" class="form-control">
						<input  name="tank['.$i.'][type]" value="1" type="hidden" class="form-control">
						<input  name="tank['.$i.'][product_code]" value='.$product_code.' type="hidden" class="form-control">
					</td>
					</tr>';
				$i++;
			}
			
			$html_tank.='<tr>
						<td><span><span style="color: red; font-weight: bold;">Warning:</span> Once you click the <span style="color: black; font-weight: bold;">Add To Warehouse</span> button you will not able to change the data.</span></td>
						<td><button type="button" class="btn btn-success" id="add_to_warehouse_one" style="background-color: green; ">Add To Fuel Tank</button></td>
					</tr>
				</tbody>
			</table></form>';
			$json['html'] = $html_tank;
		}
		echo json_encode($json);
	}
	

	public function add_to_different_warehouse_partial()
	{
		if(!empty($this->input->post('warehouse')))
		{
			$warehouse = $this->input->post('warehouse');
			$purchaseid = $this->input->post('purchaseid');

			foreach ($warehouse as $ware)
			{
				if(!empty($ware['qty']) && $ware['qty']!="0")
				{
					$ow_id			= $ware['ow_id'];
					$outlet_id		= $ware['outlet_id'];
					$type			= $ware['type'];
					$product_code	= $ware['product_code'];
					$qty			= $ware['qty'];
					$storeid		= $ware['store_id'];
					$inventory = $this->Purchaseorder_model->CheckInventory($ow_id,$outlet_id,$type,$product_code);
					if($inventory->num_rows()>0)
					{
						$totalQty = $inventory->row()->qty + $qty; 
						$inventory_id = $inventory->row()->id; 
						$data_inventory = array('qty' => $totalQty);
						$this->Purchaseorder_model->data_inventoryUpdate($data_inventory,$inventory_id);
					}
					else
					{
						$inserinventory = array('product_code' => $product_code,
							'outlet_id' => $outlet_id,
							'qty' => $qty,
							'ow_id' => $ow_id,
							'type' => $type,
							'date' => date('Y-m-d H:i:s'),
						);
						$this->Constant_model->insertDataReturnLastId('inventory', $inserinventory);
					}
					$stockQty = $this->Purchaseorder_model->getStoreInventory($storeid);
					$newstoreQty = $stockQty + $qty;
					$data_storeupdate = array(
						's_stock' => $newstoreQty,
						's_stock_upated' => $newstoreQty,
					);
					$this->Constant_model->UpdateStoreInventory($data_storeupdate, $storeid);
					$this->Purchaseorder_model->UpdatePurchaseItemStatusPartial($purchaseid,$qty);
				}
			}
			$json['sucess'] = true;
		}
		else
		{
			$json['sucess'] = false;
		}
		echo json_encode($json);
	}
	
	public function add_to_different_tank_partial()
	{
		if(!empty($this->input->post('tank')))
		{
			$tankdata = $this->input->post('tank');
			$purchaseid = $this->input->post('purchaseid');
			foreach ($tankdata as $tank)
			{
				if(!empty($tank['qty']) && $tank['qty']!="0")
				{
					$ow_id			= $tank['ow_id'];
					$outlet_id		= $tank['outlet_id'];
					$type			= $tank['type'];
					$product_code	= $tank['product_code'];
					$qty			= $tank['qty'];
					$inventory = $this->Purchaseorder_model->CheckInventory($ow_id,$outlet_id,$type,$product_code);
					if($inventory->num_rows()>0)
					{
						$totalQty = $inventory->row()->qty + $qty; 
						$inventory_id = $inventory->row()->id; 
						$data_inventory = array('qty' => $totalQty);
						$this->Purchaseorder_model->data_inventoryUpdate($data_inventory,$inventory_id);
					}
					else
					{
						$inserinventory = array('product_code' => $product_code,
							'outlet_id' => $outlet_id,
							'qty' => $qty,
							'ow_id' => $ow_id,
							'type' => $type,
							'date' => date('Y-m-d H:i:s'),
						);
						$this->Constant_model->insertDataReturnLastId('inventory', $inserinventory);
					}
					$getlastbalancetankBalance  = $this->Constant_model->getlastbalancetankBalance($tank['ow_id']);
					$newbalance= $getlastbalancetankBalance + $qty;
					$update_inventory = array(
						'current_balance'   => $newbalance,
					);
					$this->Constant_model->UpdateTankBalance($update_inventory, $tank['ow_id']);
					$this->Purchaseorder_model->UpdatePurchaseItemStatusPartial($purchaseid,$qty);
				}
			}
			$json['sucess'] = true;
		}
		else
		{
			$json['sucess'] = false;
		}
		echo json_encode($json);
	}
	
	public function create_purchase_order()
    {
        $settingResult = $this->db->get_where('site_setting');
        $settingData = $settingResult->row();
        $setting_dateformat = $settingData->datetime_format;
		$format_array = ci_date_format();
		$data['dateformat_ters'] = $format_array['dateformat'];
		
		$data['purchaseOrderNumber'] = $this->Purchaseorder_model->getPurchaseOrderNumber();
		$data['getProduct']		= $this->Constant_model->getProduct();
		$data['getOutlets']		= $this->Constant_model->getOutlets();
		$data['getSupplier']	= $this->Constant_model->getSuppliers();
		$data['dateformat']		= $setting_dateformat;
		
        $this->load->view('create_purchase_order', $data);
    }
	
	public function getSupplierData()
	{
		$supplierid				= $this->input->post('supplierid');
		$json['supplier_name']	= $this->Purchaseorder_model->getSupplierData($supplierid);
		echo json_encode($json);
	}
	
	
	public function bulk_purchase()
    {
		$permisssion_url = 'bulk_purchase';
		$permission = $this->Constant_model->getPermissionPageWise($permisssion_url);
                
		if($permission->view_menu_right == 0)
		{
			redirect('dashboard');
		}
		
		$data['purchaseOrderNumber'] 	= $this->Purchaseorder_model->getPurchaseOrderNumber();
		$data['getoutlets'] = $this->Constant_model->getDataWhere('outlets');
		$data['getcategory'] = $this->Constant_model->getDataWhere('category');
		$data['getsuppliers'] = $this->Constant_model->getDataWhere('suppliers');
		$data['getallProduct'] = $this->Purchaseorder_model->getallProduct();
		$data['getGoldGradedata']  = $this->Constant_model->getGoldGrade();
		$this->load->view('includes/header');
        $this->load->view('bulk_purchase',$data);
		$this->load->view('includes/footer');
    }
	
	public function getPurchasePrice()
	{
		$product_id = $this->input->post('product_id');
		$purchaseOrderNumber = $this->Purchaseorder_model->getPurchasePrice($product_id);
		$json['purchase_price'] = $purchaseOrderNumber->purchase_price;
		echo json_encode($json);
	}

	// public function getWeightProduct()
	// {
	// 	$product_id = $this->input->post('product_id');
	// 	$purchaseOrderNumber = $this->Purchaseorder_model->getPurchasePrice($product_id);
	// 	$json['product_weight'] = $purchaseOrderNumber->weight;
	// 	// print_r($purchaseOrderNumber->weight); exit();
	// 	echo json_encode($json);
	// }
	
	
	public function SubmitBulkPurchase()
	{

		$us_id = $this->session->userdata('user_id');
        $tm = date('Y-m-d H:i:s', time());
		$supplierDtaData	= $this->Constant_model->getDataOneColumn('suppliers', 'id', $this->input->post('supplier'));
		$supplier_name		= !empty($supplierDtaData[0]->name)?$supplierDtaData[0]->name:'';
		$supplier_email		= !empty($supplierDtaData[0]->email)?$supplierDtaData[0]->email:'';
		
		$supplier_tel = !empty($supplierDtaData[0]->tel)?$supplierDtaData[0]->tel:'';
		$supplier_fax = !empty($supplierDtaData[0]->fax)?$supplierDtaData[0]->fax:'';
		
		$outletDtaData		= $this->Constant_model->getDataOneColumn('outlets', 'id', $this->input->post('outlet'));
		$outlet_name		= $outletDtaData[0]->name;
		$outlet_address		= $outletDtaData[0]->address;
		$outlet_contact		= $outletDtaData[0]->contact_number;
		
		$po_numb	= $this->input->post('po_number');
		
		$supplier_address = !empty($supplierDtaData[0]->address)?$supplierDtaData[0]->address:'';
		

		$purchasearray = array(
					'po_number'				=>	$this->input->post('purachase_no'),
					'purchase_bill_no'		=>	$this->input->post('purchase_bill_no'),
					'note'					=>	$this->input->post('note'),
					'total_items'			=>	$this->input->post('qty'),
					'total_weight'			=>	$this->input->post('total_weight'),
					'discount_amount'		=>	0,
					'discount_percentage'	=>	0,
					'tax'					=>	0,
					'grandTotal'			=>	$this->input->post('grand_total'),
					'supplier_id'			=>	$this->input->post('supplier'),
					'supplier_name'			=>	$supplier_name,
					'supplier_email'		=>	$supplier_email,
					'supplier_address'		=>	$supplier_address,
					'supplier_tel'			=>	$supplier_tel,
					'supplier_fax'			=>	$supplier_fax,
					'outlet_id'				=>	$this->input->post('outlet'),
					'outlet_name'			=>	$outlet_name,
					'outlet_address'		=>	$outlet_address,
					'outlet_contact'		=>	$outlet_contact,
					'po_date'				=>	date('Y-m-d'),
					'created_user_id'		=>	$us_id,
                    'created_datetime'		=>	$tm,
                    'status'				=>	'6',
                    'product_type'			=> 'bulk',
				);
		$po_id = $this->Constant_model->insertDataReturnLastId('purchase_order', $purchasearray);
		
				$ins_po_item_data = array(
					'po_id'					=> $po_id,
					'product_code'			=> $this->input->post('product_item'),
					// 'cost'					=> $this->input->post('total_price'),
					'ordered_qty'			=> $this->input->post('qty'),
					'discount_percentage'	=> 0,
					'discount_amount'		=> 0,
					'tax'					=> 0,
					'subTotal'				=> $this->input->post('grand_total'),
					
				);
			 
				// $this->Constant_model->UpdateProductPrice($this->input->post('product_item'),$this->input->post('total_price'));
				$purchase_item_id = $this->Constant_model->insertDataReturnLastId('purchase_order_items', $ins_po_item_data);
				
				
				$get_product_report = $this->db->select('*');
				$get_product_report = $this->db->from('product_report');
				$get_product_report = $this->db->where('product_code',$this->input->post('product_item'));
				$get_product_report = $this->db->order_by('id','desc');
				$get_product_report = $this->db->limit('1');
				$get_product_report = $this->db->get()->row();

				$opening_balance = $get_product_report->balance_qty;
				$opening_balance_wt = $get_product_report->balance_wt;
				$product_balance = $opening_balance + $this->input->post('qty');
				$product_balance_wt = $opening_balance_wt + $this->input->post('total_weight');
				
				$product_report = array(
					'product_code'	=> $this->input->post('product_item'),
					'opening_qty'	=> $opening_balance,
					'purchase_qty'	=> $this->input->post('qty'),
					'bonusqty'		=> 0,
					'sales_qty'		=> 0,
					'balance_qty'   => $product_balance,
					'opening_wt'	=> $opening_balance_wt,
					'purchase_wt'	=> $this->input->post('total_weight'),
					'bonus_wt'		=> 0,
					'sales_wt'		=> 0,
					'balance_wt'    => $product_balance_wt,
					'created_by'	=> $this->session->userdata('user_id'),
					'created_date'	=> date('Y-m-d H:i:s'),
				);
				$this->db->insert('product_report',$product_report);
				
						$ow_id			= $this->input->post('store');
						$outlet_id		= $this->input->post('outlet');
						$product_code	= $this->input->post('product_item');
						$qty	= $this->input->post('qty');
						$type			= 0;
						$inventory = $this->Purchaseorder_model->CheckInventory($ow_id,$outlet_id,$type,$product_code);
						// $pweight=$this->db->select('weight')->where('code',$product_code)->from('products')->where('outlet_id_fk',$outlet_id)->get()->row()->weight;
						// $pqty=$this->db->select('start_qty')->from('products')->where('code',$product_code)->where('outlet_id_fk',$outlet_id)->get()->row()->start_qty;
						// if ($pweight == 0 OR $pweight == null) {
							$addweight = $this->input->post('total_weight');
						
						// }else{
						// 	$productperweight = (!empty($pweight)?($pweight):0)/(!empty($pqty)?($pqty):0);
						// 	$addweight = $productperweight * $qty;
						// }
						
						if($inventory->num_rows()>0)
						{
							$totalQtynow_qty = $inventory->row()->qty + $qty; 
							$totalQty = $inventory->row()->qty + $qty; 
							$totalwt = (!empty($inventory->row()->gold_weight)?($inventory->row()->gold_weight):0) + $addweight; 
							$inventory_id = $inventory->row()->id; 
							$data_inventory = array( 'qty' => $totalQty,'gold_weight' => $totalwt );
							$this->Purchaseorder_model->data_inventoryUpdate($data_inventory,$inventory_id);
						}
						else
						{
							$totalQtynow_qty = $qty;
							$inserinventory = array('product_code' => $product_code,
								'outlet_id' => $outlet_id,
								'qty' => $qty,
								'gold_weight' => $this->input->post('total_weight'),
								'ow_id' => $ow_id,
								'type' => $type,
								'date' => date('Y-m-d H:i:s'),
							);
							$inventory_id = $this->Constant_model->insertDataReturnLastId('inventory', $inserinventory);
						}
						
						
							$getStore		= $this->Constant_model->OutletWarehouseget($ow_id);
							$oldstore		= $getStore->s_stock;
							$storeid		= $getStore->store_id;
							$newstoreQty = $oldstore + $qty;

							$data_storeupdate = array(
								's_stock' => $newstoreQty,
								's_stock_upated' => $newstoreQty,
							);
							$this->Constant_model->UpdateStoreInventory($data_storeupdate, $storeid);
						
						
						
					$inventory_changes = array(
						'product_code'		=>	$product_code,
						'outlet_id'			=>	$outlet_id,
						'qty'				=>	$qty,
						'available_qty'		=>	$totalQtynow_qty,
						'tank_warehouse_id'	=>	$ow_id,
						'type'				=>	$type,
						// 'price'				=>	$this->input->post('total_price'),
						'amount'			=>	$this->input->post('grand_total'),
						'created_by'		=>	$this->session->userdata('user_id'),
						'created_date'		=>	date('Y-m-d H:i:s'),
						'purchase_sale_type'		=>	1,
					);
					$this->Constant_model->insertDataReturnLastId('inventory_changes', $inventory_changes);
					
						
						$purchase_received = array(
							'purchase_item_id' => $purchase_item_id,
							'purchase_id'	=> $po_id,
							'outlet_id'		=> $outlet_id,
							'tank_qty'		=> $qty,
							'tank_id'		=> $ow_id,
							'type'			=> $type,
							'inventory_id'	=> $inventory_id,
							'created_at'	=> date('Y-m-d H:i:s'),
						);

						$this->Constant_model->insertDataReturnLastId('purchase_received', $purchase_received);
						
				
		
		
		$success = $this->Purchaseorder_model->DeletePurchaseItemTemporary();
		if($success)
		{
			$this->session->set_flashdata('alert_msg', array('success', 'Create Purchase Order', "Successfully Created Purchase Bulk Received : $po_numb"));
			$json['success'] = true;
		}
		else
		{
			$json['error'] = true;
		}
		echo json_encode($json);
		
		
		
		
		
		
		
		
		
		
		
		
		
		
	}			
			
			
	public function get_warehouse_outletwise_bulk()
	{
		$html = '';
		$outlet_id = $this->input->post('outlet_id');
		$warehouses = $this->Purchaseorder_model->get_warehouse_outletwise($outlet_id);
		foreach ($warehouses as $store)
		{
			$html.= '<option value="'.$store->ow_id.'">'.$store->s_name.'</option>';
		}
		$json['warehousedata'] = $html;
		echo json_encode($json);
	}
	public function get_Category_wise_Subcategory()
	{
		$html = '';
			$category_id = $this->input->post('cate_id');
			$getSubCategory = $this->Constant_model->getDataWhere('sub_category','category_id_fk='.$category_id);;
			$html.= '<option value="">Select Sub Category</option>';
			foreach ($getSubCategory as $subcateg)
			{
					$html.= '<option value='.$subcateg->id.'>'.$subcateg->sub_category.'</option>';	
			}
			
			$json['subcategory'] = $html;
			echo json_encode($json);
		
	}
	
	public function getsubcategorywiseProductItem()
	{
		$category		= $this->input->post('category');
		$sub_category	= $this->input->post('sub_category');
		$html = '';
		$html.= '<option value="">Select Item</option>';
		$getProduct = $this->Constant_model->getCategorySubcategoryProductTransfer($category,$sub_category);//multiple use not remove in model
		foreach ($getProduct->result() as $value)
		{
			$getInveCount = $this->Constant_model->CheckInventoryQty($value->id);//multiple use not remove in model
			// if($getInveCount > 0)
			// {
				$html.= '<option value="'.$value->id.'">'.$value->name.'</option>';
			// }
		}
		
		$json['products']=$html;
		$json['bulk_product_count'] = $getProduct->num_rows();
		echo json_encode($json);
		
		
	}
	
	
	
	
	public function outletwiseProduct()
	{
		$html = '';
		$warehouse = '';
		$outlet_id = $this->input->post('outlet_id');
		$item_row = $this->input->post('item_row');
		
		$OutletWarehouse = $this->Constant_model->getOutletWareHouse($outlet_id);
		if(!empty($OutletWarehouse))
		{
			$default_store = $this->Pos_model->getDefaultCustomer();
			$default_store_id = $default_store->default_store_id;
		
			$warehouse.= '<div class="col-md-4">
								<div class="form-group">
								<label>WareHouse <span style="color: #F00">*</span></label>
								<select required name="warehouse" class="form-control StoreWarehouse"><option value="">Select WareHouse</option>';	
			foreach ($OutletWarehouse as $ware) 
			{
				$selected = '';
				if($default_store_id == $ware->w_id)
				{
					$selected = 'selected'; 
				}

				$warehouse.= '<option '.$selected.' data-val="0"  value='.$ware->ow_id.'>'.$ware->s_name.'</option>';
			}
			
			$warehouse.= '</div>
					</div></select>';	
		}
		else
		{
			$warehouse = '';
		}
		
		
		$OutletProduct = $this->Purchaseorder_model->getOutletProduct($outlet_id);
		$html.= '<select id='.$item_row.' name="purchase['.$item_row.'][product_id]" class="form-control add_product_po FilterProduct checkFilter'.$item_row.'"><option value="">Search Product by Name OR Code</option>';	
		if(!empty($OutletProduct))
		{
			foreach ($OutletProduct as $product)
			{
				$html.= '<option value='.$product->code.'>'.$product->code.'['.$product->name.']</option>';
			}	
		}
		else
		{
			$getProduct = $this->Constant_model->getProduct();
			foreach ($getProduct as $product)
			{
				$html.= '<option value='.$product->code.'>'.$product->code.'['.$product->name.']</option>';
			}	
		}
		
		$json['product'] = $html;
		$json['warehouse'] = $warehouse;
		echo json_encode($json);
	}
	
	
	public function getoutletwiseWarehouseProduct()
	{
		$html = '';
		
		$outlet_id		= $this->input->post('outlet_id');
		$warehouse_tank = $this->input->post('warehouse_tank');
		$type			= $this->input->post('type');
		
		$product_data = $this->Constant_model->getOutletWiseTankWarehouseProduct($outlet_id,$warehouse_tank,$type);
		
		$item_row = $this->input->post('item_row');
		
		$html.= '<select id='.$item_row.' name="purchase['.$item_row.'][product_id]" class="form-control add_product_po FilterProduct checkFilter'.$item_row.'"><option value="">Search Product by Name OR Code</option>';	
		foreach ($product_data as $product)
		{
			$html.= '<option value='.$product->product_code.'>'.$product->product_code.'['.$product->prdocuname.']</option>';
		}	
		$json['product'] = $html;
		echo json_encode($json);
	}
	

	public function getOutletWiseAllProductAddRow()
	{
		$html = '';
		
		$outlet_id		= $this->input->post('outlet_id');
		$warehouse_tank = $this->input->post('warehouse_tank');
		$type			= $this->input->post('type');
		
		$product_data = $this->Purchaseorder_model->getOutletWiseAllProduct($outlet_id,$warehouse_tank,$type);
		
		$item_row = $this->input->post('item_row');
		
		$html.= '<select id='.$item_row.' name="purchase['.$item_row.'][product_id]" class="form-control add_product_po FilterProduct checkFilter'.$item_row.'"><option value="">Search Product by Name OR Code</option>';	
		foreach ($product_data as $product)
		{
			$html.= '<option value="'.$product->product_code.'">'.$product->product_code.'['.$product->prdocuname.']</option>';
		}	
		$json['product'] = $html;
		echo json_encode($json);
	}
	
	public function FilterProduct()
	{
		$outlet_id		= $this->input->post('outlet_id');
		$warehouse_id	= $this->input->post('warehouse_id');
		$warehouse_type = $this->input->post('warehouse_type');
		$product_code	= $this->input->post('product_code');
		
		$FilterProduct = $this->Purchaseorder_model->FilterProductNew($outlet_id,$warehouse_id,$warehouse_type,$product_code);
		$Product = $FilterProduct->row();
		if($FilterProduct->num_rows() > 0)
		{
			$json['status']				= true;
			$json['in_stock']			= $Product->qty;
			$json['outlet_warehouse']	= $Product->ow_id;
			$json['purchase_price']		= $Product->purchase_price;
			$json['inventoryid']		= $Product->id;
		}
		else
		{
			$json['error']  = false;
		}
		echo json_encode($json);
	}
			
	public function raisepo() 
	{
		$id = $this->input->get('id');
		$this->Constant_model->UpdateRaisepo($id);
		redirect('purchase_order/po_raised?p_status=5');
	}
	
	
	public function partialpo() {
		$id = $this->input->get('id');
		$data['getPurchase'] = $this->Purchaseorder_model->getPurchaseDetail($id);
		$data['getPurchaseItem'] = $this->Purchaseorder_model->getPurchaseItem($id);
		$settingResult = $this->db->get_where('site_setting');
		$settingData = $settingResult->row();
		$setting_dateformat = $settingData->datetime_format;
		$data['dateformat'] = $setting_dateformat;
		$data["tax"] = $settingData->tax;
		$data["currency"] = $settingData->currency;
		$data['id'] = $id;
		$this->load->view('partial_po', $data);
	}
	

    // Edit Purchase Order;
    public function editpo()
    {
        $id = $this->input->get('id');
	    $settingResult = $this->db->get_where('site_setting');
        $settingData = $settingResult->row();
		$setting_dateformat = $settingData->datetime_format;
		$data['dateformat'] = $setting_dateformat;
        $data['id'] = $id;
		$this->load->view('edit_purchase_order', $data);
    }

    // Receive PO;
    public function receivepo()
    {
        $id = $this->input->get('id');

        $settingResult = $this->db->get_where('site_setting');
        $settingData = $settingResult->row();

        $setting_dateformat = $settingData->datetime_format;

        $data['dateformat'] = $setting_dateformat;
        $data["tax"]		= $settingData->tax;
        $data["currency"]	= $settingData->currency;
        $data['id'] = $id;

        $this->load->view('receive_purchase_order', $data);
    }

    // View PO;
    public function viewpo()
    {
        $id = $this->input->get('id');

        $settingResult = $this->db->get_where('site_setting');
        $settingData = $settingResult->row();

        $setting_dateformat = $settingData->datetime_format;
		
		$data['dateformat'] = $setting_dateformat;
        $data["tax"]		= $settingData->tax;
        $data["currency"]	= $settingData->currency;
		
		$data['id'] = $id;
		$data['DistributedPurchaseDetail']	= $this->Purchaseorder_model->DistributedPurchaseDetail($id);
		$data['PaymentPurchaseDetail']		= $this->Purchaseorder_model->PaymentPurchaseDetail($id);
        $this->load->view('view_purchase_order', $data);
    }

    // ****************************** View Page -- END ****************************** //

    // ****************************** Action To Database -- START ****************************** //

    // Delete Purchase Order;
    public function deletePO()
    {
        $id = $this->input->get('id');
        $po_numb = $this->input->get('po_numb');

        $ckExistResult = $this->db->query("SELECT * FROM purchase_order WHERE id = '$id' ");
        $ckExistRows = $ckExistResult->num_rows();

        if ($ckExistRows == 1) {
            if ($this->Constant_model->deleteData('purchase_order', $id)) {
                $this->Constant_model->deleteByColumn('purchase_order_items', 'po_id', $id);

                $this->session->set_flashdata('alert_msg', array('success', 'Delete Purchase Order', "Successfully Deleted Purchase Order : $po_numb"));
                redirect(base_url().'purchase_order/po_view');
            }
        }
        unset($ckExistResult);
        unset($ckExistRows);
    }

    // Receive Items From Supplier;
    public function ReceiveItemsPO()
    {
        $id = $this->input->post('id');
        $outlet_id = $this->input->post('outlet_id');

		$discount 		= $this->input->post("discount");
		$subTotal 		= $this->input->post("subTotal");
		$tax 			= $this->input->post("tax");
		$grandTotal 	= $this->input->post("grandTotal");

        $us_id = $this->session->userdata('user_id');
        $tm = date('Y-m-d H:i:s', time());

        $existItemResult = $this->db->query("SELECT * FROM purchase_order_items WHERE po_id = '$id' ORDER BY id ASC ");
        $existItemData = $existItemResult->result();
        for ($ex = 0; $ex < count($existItemData); ++$ex) {
            $ex_item_id = $existItemData[$ex]->id;
            $ex_pcode = $existItemData[$ex]->product_code;

            if (isset($_POST["receiveQty_$ex_item_id"]) && isset($_POST["receiveCost_$ex_item_id"])) {
                $rec_qty = $this->input->post("receiveQty_$ex_item_id");
                $rec_cost = $this->input->post("receiveCost_$ex_item_id");

                if ($rec_qty > 0) {
                    $upd_po_item_data = array(
                            'received_qty' => $rec_qty,
                            'cost' => $rec_cost,
                    );

                    $this->Constant_model->updateData('purchase_order_items', $upd_po_item_data, $ex_item_id);

                    // Update Product Cost;
                    $pcodeIdResult = $this->db->query("SELECT * FROM products WHERE code = '$ex_pcode' ");
                    $pcodeIdData = $pcodeIdResult->result();
                    $pcode_id = $pcodeIdData[0]->id;

                    $upd_product_cost_data = array(
                                'purchase_price' => $rec_cost,
                    );
                    $this->Constant_model->updateData('products', $upd_product_cost_data, $pcode_id);

                    // Update Product Inventory;
                    $ckInvResult = $this->db->query("SELECT * FROM inventory WHERE product_code = '$ex_pcode' AND outlet_id = '$outlet_id' ");
                    $ckInvRows = $ckInvResult->num_rows();
                    if ($ckInvRows == 1) {
                        $ckInvData = $ckInvResult->result();
                        $ckInv_id = $ckInvData[0]->id;
                        $ckInv_qty = $ckInvData[0]->qty;

                        $combine_qty = $ckInv_qty + $rec_qty;

                        $upd_inv_data = array(
                                'qty' => $combine_qty,
                        );
                        $this->Constant_model->updateData('inventory', $upd_inv_data, $ckInv_id);
                    } else {
                        $ins_inv_data = array(
                                'product_code' => $ex_pcode,
                                'outlet_id' => $outlet_id,
                                'qty' => $rec_qty,
                        );
                        $this->Constant_model->insertData('inventory', $ins_inv_data);
                    }
                    unset($ckInvResult);
                    unset($ckInvRows);
                }
            }
        }
        unset($existItemResult);
        unset($existItemData);

        // Check Item Received or Not;
        $ckAllItemResult = $this->db->query("SELECT * FROM purchase_order_items WHERE po_id = '$id' AND received_qty = '0' ");
        $ckAllItemRows = $ckAllItemResult->num_rows();

        if ($ckAllItemRows == 0) {
            $upd_data = array(
                    'status' => '3',
                    'received_user_id' => $us_id,
                    'received_datetime' => $tm,
                    "discount_amount"			=>	$discount,
                    "subTotal"					=>	$subTotal,
                    "tax"						=>	$tax,
                    "grandTotal"				=>	$grandTotal
            );
            $this->Constant_model->updateData('purchase_order', $upd_data, $id);
        }

        $this->session->set_flashdata('alert_msg', array('success', 'Update Purchase Order', 'Successfully Received Item(s) from Supplier.'));
        redirect(base_url().'purchase_order/receivepo?id='.$id);
    }

    // Update Purchase Order;
    public function updatePO()
    {
        $id = $this->input->post('id');
        $status = $this->input->post('po_status');

        $po_numb = strip_tags($this->input->post('po_number'));
        $outlet = strip_tags($this->input->post('outlet'));
        $supplier = strip_tags($this->input->post('supplier'));
        $po_date = strip_tags($this->input->post('po_date'));
        $note = strip_tags($this->input->post('note'));

        $row_count = $this->input->post('row_count');

        $us_id = $this->session->userdata('user_id');
        $tm = date('Y-m-d H:i:s', time());

        if (empty($po_numb)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Update Purchase Order', 'Please enter Purchase Order Number!'));
            redirect(base_url().'purchase_order/editpo?id='.$id);
        } elseif (empty($outlet)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Update Purchase Order', 'Please select Outlet for Purchase Order!'));
            redirect(base_url().'purchase_order/editpo?id='.$id);
        } elseif (empty($supplier)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Update Purchase Order', 'Please select Supplier for Purchase Order!'));
            redirect(base_url().'purchase_order/editpo?id='.$id);
        } else {

            // Check PO Number;
            $ckPOResult = $this->db->query("SELECT * FROM purchase_order WHERE po_number = '$po_numb' AND id != '$id' ");
            $ckPORows = $ckPOResult->num_rows();
            if ($ckPORows > 0) {
                $this->session->set_flashdata('alert_msg', array('failure', 'Create Purchase Order', "Purchase Order Number : $po_numb is already existing in the system! Please try another one!"));
                redirect(base_url().'purchase_order/editpo?id='.$id);
            } else {
                $supplierDtaData = $this->Constant_model->getDataOneColumn('suppliers', 'id', $supplier);

                $supplier_name = $supplierDtaData[0]->name;
                $supplier_email = $supplierDtaData[0]->email;
                $supplier_address = $supplierDtaData[0]->address;
                $supplier_tel = $supplierDtaData[0]->tel;
                $supplier_fax = $supplierDtaData[0]->fax;

                $outletDtaData = $this->Constant_model->getDataOneColumn('outlets', 'id', $outlet);
                $outlet_name = $outletDtaData[0]->name;
                $outlet_address = $outletDtaData[0]->address;
                $outlet_contact = $outletDtaData[0]->contact_number;

                $upd_po_data = array(
                        'po_number' => $po_numb,
                        'supplier_id' => $supplier,
                        'supplier_name' => $supplier_name,
                        'supplier_email' => $supplier_email,
                        'supplier_address' => $supplier_address,
                        'supplier_tel' => $supplier_tel,
                        'supplier_fax' => $supplier_fax,
                        'outlet_id' => $outlet,
                        'outlet_name' => $outlet_name,
                        'outlet_address' => $outlet_address,
                        'outlet_contact' => $outlet_contact,
                        'note' => $note,
                        'updated_user_id' => $us_id,
                        'updated_datetime' => $tm,
                        'status' => $status,
                );
                $this->Constant_model->updateData('purchase_order', $upd_po_data, $id);

                // Update Existing Item -- START;
                $existItemResult = $this->db->query("SELECT * FROM purchase_order_items WHERE po_id = '$id' ORDER BY id ASC ");
                $existItemData = $existItemResult->result();
                for ($ex = 0; $ex < count($existItemData); ++$ex) {
                    $ex_item_id = $existItemData[$ex]->id;

                    $ex_upd_qty = $this->input->post("existQty_$ex_item_id");

                    $upd_po_item_data = array(
                            'ordered_qty' => $ex_upd_qty,
                    );
                    $this->Constant_model->updateData('purchase_order_items', $upd_po_item_data, $ex_item_id);
                }
                unset($existItemResult);
                unset($existItemData);
                // Update Existing Item -- END;

                // New Item -- START;
                // PO Items;
                for ($i = 1; $i < $row_count; ++$i) {
                    $pcode = $this->input->post("pcode_$i");
                    $qty = $this->input->post("qty_$i");

                    if ($qty > 0) {
                        $ins_po_item_data = array(
                                'po_id' => $id,
                                'product_code' => $pcode,
                                'ordered_qty' => $qty,
                        );
                        $this->Constant_model->insertData('purchase_order_items', $ins_po_item_data);
                    }
                }
                // New Item -- END;

                $this->session->set_flashdata('alert_msg', array('success', 'Update Purchase Order', 'Successfully Updated Purchase Order'));
                redirect(base_url().'purchase_order/editpo?id='.$id);
            }
        }
    }

    // Insert New Purchase Order;
    public function insertNewPO()
    {
		$us_id = $this->session->userdata('user_id');
        $tm = date('Y-m-d H:i:s', time());
        $warehouseid = $this->input->post('warehouse');
		$supplierDtaData	= $this->Constant_model->getDataOneColumn('suppliers', 'id', $this->input->post('supplier'));
		$supplier_name		= $supplierDtaData[0]->name;
		$supplier_email		= $supplierDtaData[0]->email;
		
		$supplier_tel = $supplierDtaData[0]->tel;
		$supplier_fax = $supplierDtaData[0]->fax;
		
		$outletDtaData		= $this->Constant_model->getDataOneColumn('outlets', 'id', $this->input->post('outlet'));
		$outlet_name		= $outletDtaData[0]->name;
		$outlet_address		= $outletDtaData[0]->address;
		$outlet_contact		= $outletDtaData[0]->contact_number;
		$purchase	= $this->input->post('purchase');
		$po_numb	= $this->input->post('po_number');
		$transcation_date= $this->input->post('transation_date');
		
		if(!empty($this->input->post('supplieraddress')))
		{
			$supplier_address = $this->input->post('supplieraddress');
		}
		else
		{
			$supplier_address = $supplierDtaData[0]->address;
		}

			$purchasearray = array('po_number'	=>$this->input->post('po_number'),
					'total_items'			=>$this->input->post('total_items'),
					'discount_amount'		=>$this->input->post('discount_amount'),
					'discount_percentage'	=>$this->input->post('discount_percentage'),
					'tax'					=>$this->input->post('tax_amount'),
					'grandTotal'			=>$this->input->post('total_amount'),
					'supplier_id'			=>$this->input->post('supplier'),
					'transation_date'		=>date( 'Y-m-d', strtotime($transcation_date)),
					'supplier_name'			=>$supplier_name,
					'supplier_email'		=>$supplier_email,
					'supplier_address'		=>$supplier_address,
					'supplier_tel'			=>$supplier_tel,
					'supplier_fax'			=>$supplier_fax,
					'outlet_id'				=>$this->input->post('outlet'),
					'outlet_name'			=>$outlet_name,
					'outlet_address'		=> $outlet_address,
					'outlet_contact'		=> $outlet_contact,
					'po_date'				=> date('Y-m-d'),
					'created_user_id'		=> $us_id,
                    'created_datetime'		=> $tm,
                    'status'				=> '4',
					'note'					=> $this->input->post('note'),
				);
		
		$po_id = $this->Constant_model->insertDataReturnLastId('purchase_order', $purchasearray);
		
		foreach ($purchase as $pur_item)
		{
			if(!empty($pur_item['product_id']) && !empty($pur_item['qty']))
			{
			 $ins_po_item_data = array(
					'po_id'					=> $po_id,
					'product_code'			=> $pur_item['product_id'],
					'inventory_id'			=> $pur_item['inventoryid'],
					'cost'					=> $pur_item['new_price'],
					'ordered_qty'			=> $pur_item['qty'],
					'discount_percentage'	=> $pur_item['discount'],
					'discount_amount'		=> $pur_item['sub_discount_amount'],
					'tax'					=> $pur_item['sub_tax'],
					'subTotal'				=> $pur_item['subtotal'],
				);
			 
				$this->Constant_model->UpdateProductPrice($pur_item['product_id'],$pur_item['new_price']);
				$this->Constant_model->insertData('purchase_order_items', $ins_po_item_data);

				$inserinventory = array('product_code' => $pur_item['product_id'],
								'outlet_id' => $this->input->post('outlet'),
								'qty' => $pur_item['qty'],
								'ow_id' => $warehouseid,
								'type' => "0",
								'date' => date('Y-m-d H:i:s'),
							);
							$inventory_id = $this->Constant_model->insertDataReturnLastId('inventory', $inserinventory);
				$purchase_received = array(
							'purchase_item_id' => $po_id,
							'purchase_id'	=> $po_id,
							'outlet_id'		=> $this->input->post('outlet'),
							'tank_qty'		=> $pur_item['qty'],
							'tank_id'		=> $warehouseid,
							'type'			=> "0",
							'inventory_id'	=> $inventory_id,
							'created_at'	=> date('Y-m-d H:i:s'),
						);

						$this->Constant_model->insertDataReturnLastId('purchase_received', $purchase_received);
			}
		}
		$this->session->set_flashdata('alert_msg', array('success', 'Create Purchase Order', "Successfully Created Purchase Order : $po_numb"));
		$json['success'] = true;
		echo json_encode($json);
    }

    // ****************************** Action To Database -- END ****************************** //

    public function searchProduct()
    {
        $q = $this->input->get('q');

        $array = array();

        $searchResult = $this->db->query("SELECT * FROM products WHERE code LIKE '$q%' OR name LIKE '%$q%' ");
        $searchData = $searchResult->result();

        for ($s = 0; $s < count($searchData); ++$s) {
            $search_pcode = $searchData[$s]->code;
            $search_pname = $searchData[$s]->name;

            //$search_combile 	= $search_pcode." ($search_pname)";

            $search_combile = $search_pcode;

            $array[] = $search_combile;
        }
        unset($searchResult);
        unset($searchData);

        echo json_encode($array);
    }

    public function checkPcode()
    {
        $pcode = $this->input->get('pcode');

        $ckPcodeResult = $this->db->query("SELECT * FROM products WHERE code = '$pcode' ");
        $ckPcodeRows = $ckPcodeResult->num_rows();

        if ($ckPcodeRows == 0) {
            $response = array(
                'errorMsg' => 'failure',
                'name' => '',
            );
        } else {
            $ckPcodeData = $ckPcodeResult->result();
            $ckPcode_name = $ckPcodeData[0]->name;

            $response = array(
                'errorMsg' => 'success',
                'name' => $ckPcode_name,
            );
        }
        echo json_encode($response);
    }

    public function deletePOItem()
    {
        $po_item_id = $this->input->get('po_item_id');
        $po_id = $this->input->get('po_id');

        $ckFirstData = $this->Constant_model->getDataOneColumn('purchase_order_items', 'id', $po_item_id);
        if (count($ckFirstData) == 1) {
            if ($this->Constant_model->deleteData('purchase_order_items', $po_item_id)) {
                $this->session->set_flashdata('alert_msg', array('success', 'Update Purchase Order', 'Successfully Deleted Purchase Order Item.'));
                redirect(base_url().'purchase_order/editpo?id='.$po_id);
            }
        } else {
            $this->session->set_flashdata('alert_msg', array('failure', 'Update Purchase Order', 'Error on deleting Purchase Order Item!'));
            redirect(base_url().'purchase_order/editpo?id='.$po_id);
        }
    }

    // Export Purchase Order to PDF;
    public function exportPurchaseOrder()
    {
        $id = $this->input->get('id');
		$data['id'] = $id;
		$data['DistributedPurchaseDetail']	= $this->Purchaseorder_model->DistributedPurchaseDetail($id);
		$data['PaymentPurchaseDetail']		= $this->Purchaseorder_model->PaymentPurchaseDetail($id);
        $this->load->view('print_purchase_order', $data);
    }
	
	
	
	
	public function get_payment_name() {
		extract($_POST);

		$paymenttypedetails = $this->db->select('*')->where('id', $id)->get('payment_method')->row_array();
		$payMethod_name = $paymenttypedetails['name'];
		if ($paid > $paymenttypedetails['balance'] && $payMethod_name != 'Cheque') {
			$arr = array('status' => 2,
				'data' => $payMethod_name,
				'paidAmount' => $paid,
			);
		} else {
			$arr = array('status' => 1,
				'data' => $payMethod_name,
				'paidAmount' => $paid,
			);
		}

		echo json_encode($arr);
	}
	
	
	public function save_bill_payment() {
		$us_id			= $this->session->userdata('user_id');
		$tm				= date('Y-m-d H:i:s', time());
		$orderid		= $this->input->post('orderid');
		$supplier		= $this->input->post('supplier');
		$supplierid		= $this->input->post('supplierid');
		$totalamount	= $this->input->post('totalamount1');
		$outletid		= $this->input->post('outletid');
		$outletname		= $this->input->post('outletname');
		
		
			
			
		if(!empty($this->input->post('payment')))
		{
			$totalpaudamount = 0;
			$payment = $this->input->post('payment');
			foreach ($payment as $value)
			{
				$totalpaudamount = $totalpaudamount + $value['paid'];
				$payMethod_name = '';
				$payment_method_id = $value['paid_by'];
				$getPayMethodData = $this->Constant_model->getDataOneColumn('payment_method', 'id', $payment_method_id);
				if (count($getPayMethodData) == 1) {
					$payMethod_name = $getPayMethodData[0]->name;
					$payMethod_balance = $getPayMethodData[0]->balance;
				}
				
				
				
				
				$paid_amt = $value['paid'];
				
				$cheque			= $value['cheque'];
				$addi_card_numb = $value['addi_card_numb'];
				$giftcard_numb	= $value['card_numb'];
				$cheque_value   =$value['cheque_bank'];	

				$ins_order_data = array(
					'purchase_id'		=> $orderid,
					'grandtotal'		=> $totalamount,
					'supplier_id'		=> $supplierid,
					'supplier_name'		=> $supplier,
					'gift_card'			=> $giftcard_numb,
					'payment_method'	=> $payment_method_id,
					'payment_name'		=> $payMethod_name,
					'cheque_number'		=> $cheque,
					'cheque_date'		=> date('Y-m-d',strtotime($value['cheque_date'])),
					'cheque_bank'		=> $value['cheque_bank'],
					'paid_amt'			=> $paid_amt,
					'paid_date'			=> $tm,
					'outlet_id'			=> $outletid,
					'outlet_name'		=> $outletname,
					'created_by'		=> $us_id,
					"card_number"		=> $addi_card_numb,
				);
				
				
				
					
			
				
				if (!empty($giftcard_numb)) 
				{
					$ckGiftResult = $this->db->query("SELECT * FROM gift_card WHERE card_number = '$giftcard_numb' ");
					$ckGiftRows = $ckGiftResult->num_rows();
					if ($ckGiftRows == 1) {
						$ckGiftData = $ckGiftResult->result();
						$ckGift_id = $ckGiftData[0]->id;
						$upd_gift_data = array(
							'status' => '1',
							'updated_user_id' => $us_id,
							'updated_datetime' => $tm,
						);
						$this->Constant_model->updateData('gift_card', $upd_gift_data, $ckGift_id);
					}
				}
				
				$this->db->insert('purchase_bills', $ins_order_data);
				$pay_query	 = $this->db->get_where('payment_method', array('id' => $payment_method_id))->row();
				$pay_balance = $pay_query->balance;
				$now_balance = $pay_balance - $paid_amt;
				$pay_data	 = array(
					'balance' => $now_balance,
					'updated_user_id' => $us_id,
					'updated_datetime' => $tm,
				);
				$this->db->update('payment_method', $pay_data, array('id' => $payment_method_id));
				
				if(!empty($cheque))
				{
					$bank_bal=$this->Constant_model->getDataOneColumn('bank_accounts', 'id', $cheque_value);
					$bank_val=$bank_bal[0]->current_balance;
					$totalamt= $bank_val - $value['paid'];
					$paybal=array('current_balance' => $totalamt);
					$this->Constant_model->updateData('bank_accounts', $paybal, $cheque_value);
					
					$trans_ins=array(
						'account_number'  =>$cheque_value,
						'bring_forword '  =>$bank_val,
						'outlet_id'		  =>$outletid,
						'trans_type'	  =>'payment_s',
						'amount'		  =>$value['paid'],
						'created_by'	  =>$us_id,
						'created'		  =>date('Y-m-d H:i:s'),
						'transfer_status' =>1,
					);
					$this->db->insert('transactions', $trans_ins);
				
				}
				
				$trans_ins=array(
					'account_number'  =>$payment_method_id,
					'bring_forword '  => $pay_balance,
					'outlet_id'		  =>$outletid,
					'trans_type'	  =>'payment_s',
					'amount'		  =>$value['paid'],
					'cheque_number'	  =>$cheque,
					'card_number'	  =>$addi_card_numb,
					'cheque_date'	  =>date('Y-m-d',strtotime($value['cheque_date'])),
					'created_by'	  =>$us_id,
					'created'		  =>date('Y-m-d H:i:s'),
				);
				$this->db->insert('transactions', $trans_ins);
				
				
			}
			
			
			$purchaseorderdetails = $this->db->select('paid_amt')->where('id', $orderid)->get('purchase_order')->row_array();
			$ins_order_data = array(
				'paid_amt' => $purchaseorderdetails['paid_amt'] + $totalpaudamount,
				'updated_user_id' => $this->session->userdata('user_id'),
				'updated_datetime' => $tm,
			);
			
			$this->Constant_model->updateData('purchase_order', $ins_order_data, $orderid);
			
			$response = array(
				'status' => 1,
				'message' => 'Your Payment Successfully Saved!!',
			);
		}
		else
		{
			$response = array(
				'status' => 0,
				'message' => 'Due to some error please try again!'
			);
		}
		echo json_encode($response);
	}
}
