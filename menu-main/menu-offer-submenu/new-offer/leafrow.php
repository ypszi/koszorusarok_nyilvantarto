<?php

	if (!isset($_SESSION['leafs'])) {
		session_start();
		include '../../../config.php';
	}
?>
	<script type="text/javascript" src="js/protea_functions.js"></script>
<?php
	if (isset($_GET['leafnum'])) $_SESSION['leafs'] = $_GET['leafnum']; else $_SESSION['leafs'] = 1;
	$leafnum = $_SESSION['leafs'];

?>
<td style="position: relative; left: 235px;">
	<select id="<?php echo "leaf".$leafnum; ?>" name="<?php echo "leaf".$leafnum; ?>" onChange="calculatePrice_oForm(); writeLPrice_oForm(); LeafItemPrice(<?php echo $leafnum; ?>);" >
		<option disabled value="" selected>Válasszon Levelet!</option>
		<?php 
			$query = "SELECT color FROM  `flower` WHERE type='levél' ORDER BY color ASC;";
			$result = mysql_query($query) or die (mysql_error());

			while ($row = mysql_fetch_assoc($result)) {
				$leaf = $row['color'];
				echo "<option value=\"$leaf\" >$leaf</option>";
			}
		?>
	 </select>
</td>
<td style="position: relative; left: 245px;"> 
	<input type="text" class="db" id="<?php echo "leafqty".$leafnum; ?>" name="<?php echo "leafqty".$leafnum; ?>" max="99" min="0" value="0" onChange="calculatePrice_oForm(); writeLPrice_oForm();" > db
</td>
<td style="position: relative; left: 182px;">
	<input type='button' class="inc_button" name='add_leaf' onclick='document.getElementById("<?php echo "leafqty".$leafnum; ?>").value++; calculatePrice_oForm(); writeLPrice_oForm();' value='+'/>
	<input type='button' class="dec_button" name='subtract_leaf' onclick='document.getElementById("<?php echo "leafqty".$leafnum; ?>").value--; calculatePrice_oForm(); writeLPrice_oForm();' value='-' />
</td>
<td style="position: relative; left: 137px;">
	<input type="text" value="" id="<?php echo "leafitemprice".$leafnum; ?>" name="<?php echo "leafitemprice".$leafnum; ?>" onChange="calculatePrice_oForm(); writeLPrice_oForm();" style="width: 40px;"> Ft / db
</td>
