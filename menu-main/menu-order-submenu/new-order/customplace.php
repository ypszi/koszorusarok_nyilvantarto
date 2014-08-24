<?php
	include '../../../config.php';
	$query = "SELECT * FROM cemetery ORDER BY name";
	$result = mysql_query($query) or die (mysql_error());
	$_view['custom_cemetery_options'] = "<option value='0' selected>Egyedi helyszín</option>";
	$_view['custom_cemetery_hidden_data'] = "<input type='hidden' id='cemetery0_name' value=''><input type='hidden' id='cemetery0_address' value=''>";
	while ($row = mysql_fetch_assoc($result)) {
		$_view['custom_cemetery_options'] .= "<option value='{$row['id']}'>{$row['name']}</option>";
		$_view['custom_cemetery_hidden_data'] .= "<input type='hidden' id='cemetery{$row['id']}_name' value='{$row['name']}'>";
		$_view['custom_cemetery_hidden_data'] .= "<input type='hidden' id='cemetery{$row['id']}_address' value='{$row['address']}'>";
	}
?>
<?php echo $_view['custom_cemetery_hidden_data']; ?>
<tr>
	<td class="custom_shipment">
		* Válasszon helyszínt: 
	</td>
	<td>
		<select style="width: 330px" onchange="loadCemetery($(this).val())">
			<?php echo $_view['custom_cemetery_options']; ?>
		</select>
	</td>
</tr>
<tr>
	<td class="custom_shipment">
		* Temetés helyszíne: 
	</td>
	<td>
		<input type="text" name="c_location" id="c_location" style="width: 330px" placeholder="(pl: Újköztemető)">  
	</td>
</tr>
<tr>
	<td class="custom_shipment">
		* Címe:
	</td>
	<td>
		<input type="text" name="c_address" id="c_address" style="width: 330px" placeholder="(pl: 1108 Budapest, Kozma utca 8-10)">
	</td>
</tr>
<tr>
	<td class="custom_shipment">
		* Ravatalozó / terem:
	</td>
	<td>
		<input type="text" name="c_funeral" id="c_funeral" style="width: 330px">
	</td>
</tr>