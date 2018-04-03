<?php
if (count($stores) > 0) {
	foreach ($stores as $s) {
		?>
		<option  value="<?php echo $s->s_id; ?>" > <?php echo $s->s_name; ?> </option>
		<?php
		}
} 
else
{
	?>
	<?php
}
?>