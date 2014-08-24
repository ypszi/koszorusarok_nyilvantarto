<?php

	if (!isset($_SESSION['leafs'])) {
		session_start();
		include '../../../config.php';
	}

	if (isset($_GET['leafnum'])) $_SESSION['leafs'] = $_GET['leafnum']; else $_SESSION['leafs'] = 1;
	$leafnum = $_SESSION['leafs'];
?>
	<td style="position: relative; left: 235px;">
		<select id="<?php echo "leaf".$leafnum; ?>" name="<?php echo "leaf".$leafnum; ?>" onChange="calculatePrice_wForm(); writeLPrice();" >
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
		<input type="text" class="db" id="<?php echo "leafqty".$leafnum; ?>" name="<?php echo "leafqty".$leafnum; ?>" max="99" min="0" value="0" onChange="calculatePrice_wForm(); writeLPrice();" > db
	</td>
	<td style="position: relative; left: 125px;">
		<input type='button' class="inc_button" name='add_leaf' onclick='javascript: document.getElementById("<?php echo "leafqty".$leafnum; ?>").value++; calculatePrice_wForm(); writeLPrice();' value='+'/>
		<input type='button' class="dec_button" name='subtract_leaf' onclick='javascript: document.getElementById("<?php echo "leafqty".$leafnum; ?>").value--; calculatePrice_wForm(); writeLPrice();' value='-' />
	</td>
