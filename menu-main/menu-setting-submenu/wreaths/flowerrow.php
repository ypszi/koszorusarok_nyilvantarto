<?php
	if (!isset($_SESSION['flowers'])) {
		session_start();
		include '../../../config.php';
	}
	
	if (isset($_GET['flowernum'])) $_SESSION['flowers'] = $_GET['flowernum']; else $_SESSION['flowers'] = 1;
	$flowernum = $_SESSION['flowers'];
?>

<td>
<select id="<?php echo "flower".$flowernum; ?>" name="<?php echo "flower".$flowernum; ?>" onChange="loadFlowerColors(this, document.getElementById('<?php echo "color".$flowernum;?>')); eraseFSubtotal();">
	<option disabled value="" selected>Válasszon virág típust!</option>
	<?php 
		$query = "SELECT type FROM  `flower` WHERE type NOT LIKE 'levél' AND type NOT LIKE 'rezgő' GROUP BY type ORDER BY type ASC;";
		$result = mysql_query($query) or die (mysql_error());

		while ($row = mysql_fetch_assoc($result)) {
			$flowertype = $row['type'];
			echo "<option value=\"$flowertype\">$flowertype</option>";
		}
	?>
 </select>
</td>

<td>
 <select id="<?php echo "color".$flowernum; ?>" name="<?php echo "color".$flowernum; ?>" onChange="calculatePrice_wEdit(); writeFPrice();" disabled>
	<option disabled value="" selected>Először válasszon virág típust!</option>
 </select>
</td>

<td style="position: relative; left: -5px;"> 
	<input type="text" class="db" id="<?php echo "qty".$flowernum; ?>" name="<?php echo "qty".$flowernum; ?>" max="99" min="1" value="1" onChange="calculatePrice_wEdit(); writeFPrice();" > db
</td>
<td style="position: relative; left: -45px;">
	<input type='button' class="inc_button" name='add_flower' onclick='javascript: document.getElementById("<?php echo "qty".$flowernum; ?>").value++; calculatePrice_wEdit(); writeFPrice();' value='+'/>
	<input type='button' class="dec_button" name='subtract_flower' onclick='javascript: document.getElementById("<?php echo "qty".$flowernum; ?>").value--; calculatePrice_wEdit(); writeFPrice();' value='-' />
</td>