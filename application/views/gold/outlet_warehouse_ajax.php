<?php
foreach ($outlets as $out):
	?>
	<tr>
		<td><?php echo $out->created_datetime; ?></td>
		<td><?php echo $out->name; ?></td>
		<td>
			<?php foreach ($store_ as $store): ?>
				<?php
				if ($out->id == $store->out_id) {
					echo $store->s_name . "<br>";
					?>
					<?php
				}
			endforeach;
			?>
		</td>
	</tr>
	<?php
endforeach;
?>
 


