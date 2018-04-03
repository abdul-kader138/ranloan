<style type="text/css">
   .table-responsive {
   max-width: 1300px;
   overflow-x: scroll;
   }
</style>
<?php
   error_reporting(0);
       require_once 'includes/header.php';
   ?>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
   <div class="row">
      <div class="col-lg-12">
         <h1 class="page-header">Inventory</h1>
      </div>
   </div>
   <div class="row">
      <div class="col-md-12">
         <div class="panel panel-default">
            <div class="panel-body">
               <form action="" method="get">
                  <div class="row" style="margin-top: 10px;">
                     <div class="col-md-7">
                     </div>
                     <div class="col-md-3">
                        <div class="form-group">
                           <label>Select Sub Category</label>
                           <select class="form-control" name="subcategory" >
                              <option value="">Select Sub Category</option>
                              <?php 
                                 $subcategorylist = $this->Constant_model->getSubCategory();
                                 foreach ($subcategorylist as $subcategory) {?>
                              <option value="<?php echo $subcategory->id?>"><?php echo $subcategory->sub_category ?></option>
                              <?php } ?>
                           </select>
                        </div>
                     </div>
                     <!--                    <div class="col-md-2">
                        <div class="form-group">
                           <label>Start Date</label>
                           <input type="text" name="start_date" class="form-control" id="startDate"   value="<?=!empty($this->input->get('start_date'))?$this->input->get('start_date'):''?>" />
                        </div>
                        </div>
                        <div class="col-md-2">
                        <div class="form-group">
                           <label>End Date</label>
                           <input type="text" name="end_date" class="form-control" id="endDate"   value="<?=!empty($this->input->get('start_date'))?$this->input->get('end_date'):''?>" />
                        </div>
                        </div>-->
                     <div class="col-md-2">
                        <div class="form-group">
                           <label>&nbsp;</label><br />
                           <button class="btn btn-primary" type="submit" style="width: 50%;">Search</button>
                        </div>
                     </div>
                  </div>
               </form>
               <div class="row" style="margin-top: 0px;">
                  <div class="col-md-12">
                     <div class="table-responsive" style="max-width: 100%;">
                        <table style="font-size: 13px" class="table" id="datatable_inven">
                           <thead>
                              <tr>
                                 <th width="5%">Code</th>
                                 <th width="5%">Name</th>
                                 <th width="5%">Outlet</th>
                                 <th width="5%">Store</th>
                                 <th width="5%">Gold Grade</th>
                                 <th width="5%">Sub Category</th>
                                 <th width="5%">Qty</th>
                                 <th width="5%">Weight</th>
                                 <!-- <th width="5%">Transfer Quantity</th>
                                    <th width="5%">Transfer Weight</th> -->
                                 <th width="5%">Purchase/ transfer Cost</th>
                                 <th width="5%">Today Cost</th>
                                 <th width="10%">Type</th>
                                 <th width="10%">Action</th>
                              </tr>
                           </thead>
                           <tbody>
                              <?php
                                 #**************************************************
                                 # added by a3frt 14-11-2017 start
                                 #**************************************************
                                 
                                 $CI =& get_instance();
                                 $CI->load->model('Gold_module');
                                 
                                 $data_name = array();
                                 
                                 $productweight = 0;
                                 
                                 
                                 #**************************************************
                                 # added by a3frt 14-11-2017 end
                                 #**************************************************
                                 
                                    $totalqty = 0;
                                    $total_cost_amt = 0;
                                    // $result = array_values(array_column($results, 'product_qty'));
                                    // print_r($result[0]); exit();
                                     $prd1 = $this->db->select('name')->from('products')->get()->row()->name;

                                     $prd = !empty($prd1->name)?$prd1->name:'';
                                     if (!empty($prd)) {
                                       $prdtr = $this->db->select('code')->where('name',$prd)->from('products')->where('product_add_from','Transfer bulk')->get()->row()->code;
                                       // print_r($prdtr);
                                       $prdinv = $this->db->select('sum(gold_weight)as gtwt')->where('product_code',$prdtr)->from('inventory')->get()->row()->gtwt; 
                                     }else{
                                       $prdinv = 0;
                                     }

                                     $get_grade = $this->Constant_model->getLastGoldGradePrice();
                                       $CurrentPrice = !empty($get_grade->gp_price)?$get_grade->gp_price:0;
                                       $gp_purity    = !empty($get_grade->gp_purity)?$get_grade->gp_purity:0;
                                       $cal = 0;
                                     
                                       // $prdinv = 0;
                                    foreach ($results as $data) 
                                    {

                                       $totalqty = $totalqty + $data->qty;
                                    ?>
                              <tr>
                                 <td>
                                    <?php
                                       echo $data->code;
                                       
                                       ?>
                                 </td>
                                 <td><?=$data->name?></td>
                                 <td><?=$data->outletname?></td>
                                 <!-- 1 -->
                                 <td><?php echo $this->Inventory_model->getConcateStore($data->outlet_id_fk, $data->code, $data->ow_id); ?> </td>
                                 <td><?=$data->grade_name?></td>
                                 <td><?=$data->sub_category?></td>
                                 <!-- add by a3frt date 14-11-17 start -->
                                 <td>
                                    <?=(!empty($data->qty)?number_format($data->qty,2):0.00)?>
                                 </td>
                                 <td>
                                    <?php
                                       if($data->product_type == 'bulk')
                                          { echo (!empty($data->gold_weight)?number_format($data->gold_weight,2):0.00); }
                                       else{
                                       echo (!empty($data->qty)?number_format($data->qty,2):0.00) * (!empty($data->gold_weight)?number_format($data->gold_weight,2):0.00);}
                                       
                                          
                                       ?>
                                 </td>
                                 <!-- Purchase cost -->
                                 <td>
                                    <?php
                                       if($data->category_name == 'Gold' OR $data->category_name == 'Silver') { 
                                       echo !empty($data->TransferredCost)?number_format($data->TransferredCost,2):'';  
                                          ?>
                                    <?php
                                    $grade_id_product = $data->grade_id;         
                                       $category = $data->category;
                                       $sub_category = $data->sub_category;
                                       $gold_purity = $data->gold_purity;
                                       $grade_name = $data->grade_name;
                                       if($grade_name == 24)
                                       {
                                          $cal = $CurrentPrice;
                                       }
                                       else
                                       {
                                          $cal = ($CurrentPrice / $gp_purity) * $gold_purity;
                                       }
                                       if($data->product_type == 'bulk')
                                       {
                                       $stwt = !empty($data->weight)?($data->weight):0;
                                       $tgtwt = (!empty($data->gold_weight)?$data->gold_weight:0);
                                       $wtBalk =  (!empty($data->gold_weight)?$data->gold_weight:0)-($stwt);
                                                                            
                                       
                                       
                                       $totaltodaycost = abs($wtBalk) * $cal;
                                       $stwt = !empty($data->purchase_price)?$data->purchase_price:0;
                                       $bulkpurchasetotal = $totaltodaycost + $stwt;
                                       $bulkpurchaset = $totaltodaycost + $stwt;
                                       $ttoal = $tgtwt+$prdinv;
                                       if ($ttoal == 0) {
                                          $bulkpurchaset1 = ($totaltodaycost + $stwt + ($prdinv*$cal));
                                       }else{
                                          $bulkpurchaset1 = ($totaltodaycost + $stwt + ($prdinv*$cal))/($ttoal);
                                       }
                                       
                                       // echo $bulkpurchaset1;
                                       $bulkpurchasetotal = ($bulkpurchaset1)*$tgtwt;
                                       echo number_format($bulkpurchasetotal,2);
                                        }
                                       
                                       }
                                       
                                        
                                       if ($data->product_type != 'bulk')
                                       {
                                       $price = (!empty($data->purchase_price)?number_format($data->purchase_price,2):0.00);
                                       $qty = (!empty($data->qty)?number_format($data->qty,2):0.00);                          
                                       }
                                       
                                       ?>
                                 </td>
                                 <!-- Today cost -->
                                 <td>
                                    <?php
                                       if($data->product_type == 'bulk' )
                                       { 
                                          $wtBalk =  $data->gold_weight;
                                          $totaltodaycost = $wtBalk * $cal;
                                          
                                          echo number_format($totaltodaycost,2);
                                              }
                                       
                                          if ($data->product_add_from == 'Transfer bulk') {
                                             echo number_format($data->TransferredCost,2);
                                          }
                                             
                                                ?>
                                 </td>
                                 <td>
                                    <?php
                                       // $type_add = $data->product_add_from;
                                       $type_add = !empty($data->product_add_from)?($data->product_add_from):"";
                                          if($data->product_type == 'bulk')
                                          {
                                             echo $type_add;
                                          }
                                          else
                                          {
                                             echo $type_add;
                                          }
                                       ?>
                                 </td>
                                 <td>
                                    <a href="<?=base_url()?>inventory/view_detail?pcode=<?=$data->id?>" style="text-decoration: none;">
                                    <button class="btn btn-primary" style="padding: 5px 12px;">View</button>
                                    </a>
                                 </td>
                              </tr>
                              <?php
                                 }
                                 ?>
                           </tbody>
                           <tfoot>
                              <th></th>
                              <th></th>
                              <th></th>
                              <th></th>
                              <th></th>
                              <th></th>
                              <th></th>
                              <th></th>
                              <th></th>
                              <th></th>
                              <th></th>
                              <th></th>
                              <!-- <th></th>
                                 <th></th> -->
                           </tfoot>
                        </table>
                     </div>
                  </div>
               </div>
               <?php
                  $totalqtyinve = 0; 
                  $totalcost = 0;
                  $totalweight = 0;
                  $totalweightS = 0; 
                  // $getAllInvResult = $this->db->query("SELECT * FROM inventory ")->result();
                  $getAllInvResult = $this->db->select('inventory.qty,inventory.product_code,products.category,products.code')->from('inventory')->join('products','products.code = inventory.product_code','left')->get()->result();
                  foreach ($getAllInvResult as $inventroy)
                  {
                     $in_qty = !empty($inventroy->qty)?$inventroy->qty:0;
                     $totalqtyinve     = $totalqtyinve + $in_qty;
                     if ($inventroy->category == 1) {
                        $fgetGWeightResultin    = $this->db->query("SELECT gold_weight FROM inventory WHERE product_code = '".$inventroy->code."'")->row();
                        $each_costin_Gweight = !empty($fgetGWeightResultin->gold_weight)?$fgetGWeightResultin->gold_weight:0;
                        $each_row_costin_Gw  += $each_costin_Gweight;
                        $totalweight  =$each_row_costin_Gw;
                     }
                     if ($inventroy->category == 22) {
                        $fgetSWeightResultin    = $this->db->query("SELECT gold_weight FROM inventory WHERE product_code = '".$inventroy->code."'")->row();
                        
                        $each_costin_Sweight = !empty($fgetSWeightResultin->gold_weight)?$fgetSWeightResultin->gold_weight:0;
                        $each_row_costin_Sw  = +$each_costin_Sweight;
                        $totalweightS  =$totalweightS + $each_row_costin_Sw;
                     }
                  }
                  ?>
               <div class="row" style="padding-top: 10px; padding-bottom: 10px; margin-top: 50px; font-size: 18px; letter-spacing: 0.5px;  ">
                  <div class="col-md-3" style="font-weight: bold;">Total Gold Weight (g)</div>
                  <div class="col-md-9" style="font-weight: bold;">: 
                     <?=!empty($totalweight)?number_format($totalweight,2):0; ?>
                  </div>
               </div>
               <div class="row" style="padding-top: 10px; padding-bottom: 10px; font-size: 18px; letter-spacing: 0.5px; ">
                  <div class="col-md-3" style="font-weight: bold;">Total Silver Weight (g)</div>
                  <div class="col-md-9" style="font-weight: bold;">: 
                     <?=!empty($totalweightS)?number_format($totalweightS,2):0; ?>
                  </div>
               </div>
               <div class="row" style="padding-top: 10px; padding-bottom: 10px;  font-size: 18px; letter-spacing: 0.5px; ">
                  <div class="col-md-3" style="font-weight: bold;">Total Stock Qty.</div>
                  <div class="col-md-9" style="font-weight: bold;">: 
                     <?=!empty($totalqtyinve)?number_format($totalqtyinve,2):0?>
                  </div>
               </div>
               <?php 
                  
                     $CurrentPrice = !empty($CurrentPrice)?$CurrentPrice:0;
                     $code = $this->db->select('code,product_type,product_add_from,(SELECT sum(gold_weight) FROM `inventory` WHERE `product_code` = products.code) as gold_weight,(SELECT sum(qty) FROM `inventory` WHERE `product_code` = products.code) as qty,purchase_price')->from('products')->get()->result();
                     // print_r($code);
                     $sumbulk = 0;
                     $sumtranfer = 0;
                     $sumItm = 0;
                        foreach ($code as $key => $value) {
                           
                           if (!empty($value->product_type)) {
                              
                           
                              if ($value->product_type == 'bulk') {                   
                                 $bwt = $value->gold_weight;
                                 $sumbulk +=$bwt;

                              }
                           }
                           if (!empty($value->product_add_from)) {

                              if ($value->product_add_from == 'Transfer bulk') {       
                                 $twt = $value->gold_weight;
                                 $sumtranfer +=$twt;
                                 // echo $sumtranfer;
                              }
                              if ($value->product_add_from != 'Transfer bulk' && $value->product_type != 'bulk') {       
                                 $prItm = $value->qty;
                                 $prPrc = $value->purchase_price;
                                 $wtItm = $prItm*$prPrc;
                                 $sumItm +=$wtItm;
                              }
                           }
                           

                        }
                           $sumbulkprice = (!empty($sumbulk)?$sumbulk:0)*$CurrentPrice;
                           $sumTrprice = (!empty($sumtranfer)?$sumtranfer:0)*$CurrentPrice;
                           $sumIymprice = (!empty($sumItm)?$sumItm:0);
                                                
                           $totalstockvalue = $sumIymprice + $sumTrprice + $sumbulkprice;
                                
                        
                           ?>
               <div class="row" style="padding-top: 10px; padding-bottom: 10px; font-size: 18px; letter-spacing: 0.5px; ">
                  <div class="col-md-3" style="font-weight: bold;">Total Stock Value (<?php echo $site_currency; ?>)</div>
                  <div class="col-md-9" style="font-weight: bold;">: 
                     <?=!empty($totalstockvalue)?number_format($totalstockvalue, 2):0?>
                  </div>
               </div>
               <?php
                  foreach ($getOutlets as $value)
                  { ?>
               <div class="row" style="color: #0000cc;padding-top: 10px; padding-bottom: 10px; margin-top: 0px; font-size: 18px; letter-spacing: 0.5px; border-top: 1px solid #ddd;">
                  <div class="col-md-12" style="font-weight: bold;"><?=$value->name?></div>
               </div>
               <?php
                  $each_costin_Gweight = 0;
                  $each_costin_Sweight = 0;
                  $each_row_costin_Gw = 0;
                  $each_row_costin_Sw = 0;
                  $totalqtyinve = 0; 
                  $totalcost = 0;
                  $totalweight = 0;
                  $totalweightS = 0;
                  $getAllInvResult = $this->db->select('inventory.qty,inventory.product_code,products.category,products.code,products.outlet_id_fk')->from('inventory')->join('products','products.code = inventory.product_code','left')->get()->result();
                  foreach ($getAllInvResult as $inventroy)
                  {
                     $in_qty = !empty($inventroy->qty)?$inventroy->qty:0;
                     $totalqtyinve     = $totalqtyinve + $in_qty;                     
                     if ($inventroy->category == 1 && $inventroy->outlet_id_fk == $value->id) {
                        $fgetGWeightResultin    = $this->db->query("SELECT gold_weight FROM inventory WHERE product_code = '".$inventroy->code."'")->row();
                        $each_costin_Gweight = !empty($fgetGWeightResultin->gold_weight)?$fgetGWeightResultin->gold_weight:0;

                        $each_row_costin_Gw  += $each_costin_Gweight;
                        $totalweight  =$each_row_costin_Gw;
                     }
                     if ($inventroy->category == 22 && $inventroy->outlet_id_fk == $value->id) {
                        $fgetSWeightResultin    = $this->db->query("SELECT gold_weight FROM inventory WHERE product_code = '".$inventroy->code."'")->row();
                        $each_costin_Sweight = !empty($fgetSWeightResultin->gold_weight)?$fgetSWeightResultin->gold_weight:0;
                        $each_row_costin_Sw  = +$each_costin_Sweight;
                        $totalweightS  = $each_row_costin_Sw;
                     }
                     
                  }
                  ?>
               <div class="row" style="padding-top: 10px; padding-bottom: 10px; margin-top: 0px; font-size: 18px; letter-spacing: 0.5px;  ">
                  <div class="col-md-3" style="font-weight: bold;">Total Gold Weight (g)</div>
                  <div class="col-md-9" style="font-weight: bold;">: 
                     <?=!empty($totalweight)?number_format($totalweight,2):0; ?>
                  </div>
               </div>
               <div class="row" style="padding-top: 10px; padding-bottom: 10px; font-size: 18px; letter-spacing: 0.5px; ">
                  <div class="col-md-3" style="font-weight: bold;">Total Silver Weight (g)</div>
                  <div class="col-md-9" style="font-weight: bold;">: 
                     <?=!empty($totalweightS)?number_format($totalweightS,2):0; ?>
                  </div>
               </div>
               <div class="row" style="padding-top: 10px; padding-bottom: 10px; margin-top: 0px; font-size: 18px; letter-spacing: 0.5px;  ">
                  <div class="col-md-3" style="font-weight: bold;">Stock Qty.</div>
                  <div class="col-md-9" style="font-weight: bold;">: 
                     <?=!empty($totalqtyinve)?number_format($totalqtyinve,2):0; ?>
                  </div>
               </div>
               <?php
               // print_r($getOutlets);
                  foreach ($getOutlets as $data)
                  {
                     $code = $this->db->select('code,product_type,product_add_from,(SELECT sum(gold_weight) FROM `inventory` WHERE `product_code` = products.code) as gold_weight,(SELECT sum(qty) FROM `inventory` WHERE `product_code` = products.code) as qty,purchase_price,outlet_id_fk')->from('products')->get()->result();
                     // print_r($code);
                     $sumbulk = 0;
                     $sumtranfer = 0;
                     $sumItm = 0;
                        foreach ($code as $key => $value) {
                           
                           if (!empty($value->product_type)) {
                              
                           
                              if ($value->product_type == 'bulk' && $value->outlet_id_fk == $data->id) {                   
                                 $bwt = $value->gold_weight;
                                 $sumbulk +=$bwt;

                              }
                           }
                           if (!empty($value->product_add_from)) {

                              if ($value->product_add_from == 'Transfer bulk' && $value->outlet_id_fk == $data->id) {       
                                 $twt = $value->gold_weight;
                                 $sumtranfer +=$twt;
                                 // echo $sumtranfer;
                              }
                              if ($value->product_add_from != 'Transfer bulk' && $value->product_type != 'bulk' && $value->outlet_id_fk == $data->id) {       
                                 $prItm = $value->qty;
                                 $prPrc = $value->purchase_price;
                                 $wtItm = $prItm*$prPrc;
                                 $sumItm +=$wtItm;
                              }
                           }
                        }
                           $sumbulkprice = (!empty($sumbulk)?$sumbulk:0)*$CurrentPrice;
                           $sumTrprice = (!empty($sumtranfer)?$sumtranfer:0)*$CurrentPrice;
                           $sumIymprice = (!empty($sumItm)?$sumItm:0);
                                                
                           $totalstockvalue = $sumIymprice + $sumTrprice + $sumbulkprice; 
                     }
                  ?>
               <div class="row" style="padding-top: 10px; padding-bottom: 10px; font-size: 18px; letter-spacing: 0.5px; ">
                  <div class="col-md-3" style="font-weight: bold;">Stock Value (<?php echo $site_currency; ?>)</div>
                  <div class="col-md-9" style="font-weight: bold;">: 
                     <?=!empty($totalstockvalue)?number_format($totalstockvalue,2):0; ?>
                  </div>
               </div>
               <?php } ?>
            </div>
         </div>
         <br /><br /><br />
      </div>
      <?php require_once 'includes/header_notification.php'; ?>
   </div>
</div>
<?php require_once 'includes/footer.php'; ?>
<script>
   $(document).ready(function() {
      $("#datatable_inven").DataTable({
         dom: "Bfrtip",
         "bPaginate": true,ordering: true,"pageLength":15,
         buttons: [
            {
               extend: "copy",
               className: "change btn-primary "
            },
            {
               extend: "csv",
               className: " change btn-primary"
            },
            {
               extend: "excel",
               className: "change btn-primary"
            },
            {
               extend: "print",
               className: "change btn-primary",
               exportOptions:{columns:[0,1,2,3,4,5,6,7,8,9,10,11]},
            },
            {
               extend: "pageLength",
            },
         ],
         responsive: true,
         "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
            var pagetotal = addCommas(api.column( 10, {page:'current'} ).data().sum().toFixed(2));
            // $( api.table().column(9).footer() ).html("<strong>"+pagetotal+" LKR </strong>");
            $( api.table().column(9).footer() ).html("<strong>"+addCommas(api.column( 9, {page:'current'} ).data().sum().toFixed(2))+" </strong>");
            $( api.table().column(8).footer() ).html("<strong>"+addCommas(api.column( 8, {page:'current'} ).data().sum().toFixed(2))+" </strong>");
            $( api.table().column(7).footer() ).html("<strong>"+addCommas(api.column( 7, {page:'current'} ).data().sum().toFixed(3))+" (g) </strong>");
            $( api.table().column(6).footer() ).html("<strong>"+addCommas(api.column( 6, {page:'current'} ).data().sum().toFixed(3))+"</strong>");
         }
      });
   
   
   });
</script>