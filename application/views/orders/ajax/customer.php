<?php foreach($customer as $cus): ?>
<option value="<?php echo $cus->id; ?>" ><?php echo $cus->fullname; ?></option>
<?php endforeach;  
?>