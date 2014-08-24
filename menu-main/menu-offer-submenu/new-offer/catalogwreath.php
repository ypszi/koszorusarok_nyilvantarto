<?php include '../../../config.php'; ?>
<tr>
	<td>
		<select id="wreath_type" onChange="loadCatalogWreathNames(this.id, 'wreath_size');" style="margin-right: 5px;">
			<option>Válasszon koszorú típust</option>
			<?php 
				$query = "SELECT type FROM  `base_wreath_type` ORDER BY type ASC;";
				$result = mysql_query($query) or die (mysql_error());
			
				while ($row = mysql_fetch_assoc($result)) {
					$base_wreath_type = $row['type'];
					echo "<option value=\"$base_wreath_type\" >$base_wreath_type</option>";
				}
			?>
		</select>
	</td>
	<td>
	<?php 
		echo '<select id="wreath_size" onChange="loadWreathfromCatalog(\''.$_GET['offer_div'].'\', '.$_GET['ajanlat_id'].'); loadWreathimg(this);" disabled>';
	?>
			<option disabled value="" selected>Először válasszon koszorú típust!</option>
		</select>
	</td>
</tr>