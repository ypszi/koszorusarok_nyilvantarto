<html>
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
	<link href="css/wformstyle.css" rel="stylesheet" type="text/css" media="all">
	<link href="css/alertwindow.css" rel="stylesheet" type="text/css" media="all">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.0/jquery-ui.min.js"></script>
	<script type="text/javascript" src="js/protea_functions.js"></script>

</head>
<body onload="initTableRef(); calculatePrice_wEdit(); writeWPrice(); writeFPrice(); writeLPrice();">
	<?php
		$_SESSION['flowers'] = 0;
		$_SESSION['leafs'] = 0;
		$_SESSION['wprice'] = 0;
		$_SESSION['fprice'] = 0;
		$_SESSION['lprice'] = 0;
	?>

	<div id="alertwindow"></div>

	<form id="wreathform" method="POST" action="menu-main/menu-setting-submenu/wreaths/wreathmod.php" enctype="multipart/form-data" onsubmit="return dataCheck()">
		<input type="hidden" value="<?php echo $_GET['wreath']; ?>" name="origin_wname">
		<table id="wreath" style="width: 730px; border-style:solid; border-left-width:15px; border-color:#c8dba6; margin-top: 5px;">
			<tr>
				<td colspan="2" style="font: normal 16px/18px 'Arial'; color: #89a583;"> Adja meg a koszorú kódját/nevét! </td>
			</tr>
			<tr>
				<td style="font: normal 16px/18px 'Arial'; color: #89a583;">
		<?php echo '<input type="text" name="wreath_name" id="wreath_name" placeholder="Típus + sorszám" value="'.$_GET['wreath'].'" onChange="checkWreathName()" >';
					echo '<div id="wreath_name_error" for="wreath_name" style="color: #ff0000; margin: 5px 0 0 0;"></div>';
					echo '<input type="text" name="wreath_fancy" id="wreath_fancy" placeholder="Fantázia név" value="'.$_GET['fancy'].'" style="margin-top: 7px;">'; ?>
				</td>
				<td style="font: normal 16px/18px 'Arial'; color: #89a583; position: relative; right: -28px;">
		<?php echo '<textarea style="resize: none; width: 485px;" name="note" id="note" rows="3" cols="100" maxlength="500" placeholder="Írja ide a megjegyzést!">'.$_GET['note'].'</textarea>'; ?>
				</td>
			</tr>
			<tr class="topborder">
				<td colspan="2" style="font: normal 16px/18px 'Arial'; color: #89a583;"> Adja meg a koszorú alapját! </td>
			</tr>
			<tr>
		<?php 	$query=" SELECT `type` FROM `base_wreath_type` WHERE id=(
					SELECT type FROM `base_wreath` WHERE base_wreath.size='".$_GET['size']."')";
				$result = mysql_query($query) or die(mysql_error());
				$bwtype = "";
				while ($row = mysql_fetch_assoc($result)) {
					$bwtype = $row['type'];
				}
		?>
				<td>
					<select id="base_wreath_type" name="base_wreath_type" onChange="loadBaseWreathSizes(); eraseWSubtotal();" >
						<option disabled value="" selected>Válasszon koszorú alapot!</option>
						<?php
							$query = "SELECT type FROM  `base_wreath_type` ORDER BY type ASC;";
							$result = mysql_query($query) or die (mysql_error());

							while ($row = mysql_fetch_assoc($result)) {
								$base_wreath_type = $row['type'];
								if ($bwtype == $base_wreath_type) {
									echo "<option value=\"$base_wreath_type\" selected>$base_wreath_type</option>";
								}
								else {
									echo "<option value=\"$base_wreath_type\" >$base_wreath_type</option>";
								}
							}
						?>
					 </select>
				</td>
				<td style="position: relative; left: 18px;">
			<?php echo '<select id="base_wreath_size" name="base_wreath_size" onChange="calculatePrice_wEdit(); writeWPrice();" value="'.$_GET['size'].'" >'; ?>
					<?php
						$bw_size = $_GET['size'];

						$query = "SELECT `size` FROM `base_wreath` WHERE `base_wreath`.`type` = (SELECT `type` FROM `base_wreath` WHERE `base_wreath`.`id` = (SELECT `base_wreath_id` FROM `special_wreath` WHERE `special_wreath`.`name` = '".$_GET['wreath']."'))";
						$result = mysql_query($query) or die (mysql_error());

						while ($row = mysql_fetch_assoc($result)) {
							$base_wreath_size=$row['size'];

							if (strpos($base_wreath_size,$bw_size) !== false) {
								echo "<option value=\"$base_wreath_size\" selected>";
							} else {
								echo "<option value=\"$base_wreath_size\">";
							}
								echo $base_wreath_size;
								$query = "SELECT flower_min FROM  `base_wreath` WHERE size=\"".$base_wreath_size."\"";
								$resultmin = mysql_query($query) or die (mysql_error());

								while ($rowmin = mysql_fetch_assoc($resultmin)) {
									$size = $rowmin['flower_min'];
									echo " ($size";
								}

								echo " - ";

								$query = "SELECT flower_max FROM  `base_wreath` WHERE size=\"".$base_wreath_size."\"";
								$resultmax = mysql_query($query) or die (mysql_error());

								while ($rowmax = mysql_fetch_assoc($resultmax)) {
									$size = $rowmax['flower_max'];
									echo "$size)";
								}

								echo "</option>";

						}
					?>
					 </select>
				</td>
				<table class="subtotal">
					<tr>
						<td id="wprice"> Részösszeg: </td> <td id="wsubtotal" style="position: relative;left: 5px; margin-top: 5px;">0 Ft</td>
					</tr>
				</table>
			</tr>
		</table>

		<table id="flower" style="width: 730px; border-style:solid; border-left-width:15px; border-color:#c8dba6; margin-top: 5px;">
			<tr class="topborder">
				<td colspan="4" style="font: normal 16px/18px 'Arial'; color: #89a583;"> Adja meg a koszorú virágait!
					<input type="button" value="Új összetevő" class="plus" onClick="addFlowerRow();" >
					<input type="button" value="Utolsó összetevő eltávolítása" class="minus" onClick="remFlowerRow(); calculatePrice_wEdit(); writeFPrice();" ></td>
		<?php
			$fnum = $_GET['flowernum'];
		echo 	'<td><input type="hidden" id="flowernum" name="flowernum" value="'.$fnum.'"></td>';
		?>
			</tr>
			<?php

			$fid = 1;
			for ($i=0; $i < $fnum; $i++) {
				$f_type = $_GET['ftype'.$fid];
				$f_color = $_GET['fcolor'.$fid];
				$f_qty = $_GET['fqty'.$fid];
	echo '
			<tr>
				<td>
					<select id="flower'.$fid.'" name="flower'.$fid.'" onChange="loadFlowerColors(this, document.getElementById(\'color'.$fid.'\')); eraseFSubtotal();">
						<option disabled value="" selected>Válasszon virág típust!</option>';
							$query = "SELECT type FROM  `flower` WHERE type NOT LIKE 'levél' AND type NOT LIKE 'rezgő' GROUP BY type ORDER BY type ASC;";
							$result = mysql_query($query) or die (mysql_error());

							while ($row = mysql_fetch_assoc($result)) {
								$flowertype = $row['type'];
								if ($flowertype == $f_type) {
									echo "<option value=\"$flowertype\" selected>$flowertype</option>";
								} else {
									echo "<option value=\"$flowertype\">$flowertype</option>";
								}
							}
	echo '
					 </select>
				</td>
				<td>
					<select id="color'.$fid.'" name="color'.$fid.'" onChange="calculatePrice_wEdit(); writeFPrice();">
						<option disabled value="" selected>Válasszon virág színt!</option>';

							$query = "SELECT color FROM `flower` WHERE type = \"".$f_type."\";";
							$result = mysql_query($query) or die (mysql_error());

							while ($row = mysql_fetch_assoc($result)) {
								$flowercolor = ($row['color']=="-")?"Ennek a virágnak nem választható szín":$row['color'];
								if ($flowercolor == $f_color) {
									echo "<option value=\"$flowercolor\" selected>$flowercolor</option>";
								} else {
									echo "<option value=\"$flowercolor\">$flowercolor</option>";
								}
							}
	echo '
					</select>
				</td>

				<td style="position: relative; left: -5px;">
					<input type="text" class="db" id="qty'.$fid.'" name="qty'.$fid.'" max="99" min="1" value="'.$f_qty.'" onChange="calculatePrice_wEdit(); writeFPrice();" > db
				</td>
				<td style="position: relative; left: -45px;">
					<input type="button" class="inc_button" name="add_flower" onclick="document.getElementById(\'qty'.$fid.'\').value++; calculatePrice_wEdit(); writeFPrice();" value="+"/>
					<input type="button" class="dec_button" name="subtract_flower" onclick="document.getElementById(\'qty'.$fid.'\').value--; calculatePrice_wEdit(); writeFPrice();" value="-" />
				</td>
			</tr>';
					$fid++;
				}
				?>
				<table class="subtotal">
					<tr>
						<td id="fprice"> Részösszeg: </td> <td id="fsubtotal" style="position: relative;left: 5px; margin-top: 5px;">0 Ft</td>
					</tr>
				</table>
		</table>

		<table id="leaf" style="width: 730px; border-style:solid; border-left-width:15px; border-color:#9db88a; margin-top: 5px;">
			<tr class="topborder">
				<td colspan="4" style="font: normal 16px/18px 'Arial'; color: #89a583;"> Adja meg a koszorú leveleit!
					<input type="button" value="Új összetevő" class="plus" onClick="addLeafRow();" >
					<input type="button" value="Utolsó összetevő eltávolítása" class="minus" onClick="remLeafRow(); calculatePrice_wEdit(); writeLPrice();" ></td>
		<?php
				$leafnum = $_GET['leafnum'];
		echo 	'<td><input type="hidden" id="leafnum" name="leafnum" value="'.$leafnum.'"></td>';
		?>
			</tr>
			<?php
			$lid = 1;
			for ($i=0; $i < $leafnum; $i++) {
				$l_type = $_GET['ltype'.$lid];
				$l_color = $_GET['lcolor'.$lid];
				$l_qty = $_GET['lqty'.$lid];
		echo '
			<tr>
				<td style="position: relative; left: 235px;">
					<select id="leaf'.$lid.'" name="leaf'.$lid.'" onChange="calculatePrice_wEdit(); writeLPrice();" >
						<option disabled value="" selected>Válasszon Levelet!</option>';
							$query = "SELECT color FROM  `flower` WHERE type='levél' ORDER BY color ASC;";
							$result = mysql_query($query) or die (mysql_error());

							while ($row = mysql_fetch_assoc($result)) {
								$leaf = $row['color'];
								if ($leaf == $l_color) {
									echo "<option value=\"$leaf\" selected>$leaf</option>";
								} else {
									echo "<option value=\"$leaf\">$leaf</option>";
								}
							}
		echo '
					 </select>
				</td>
				<td style="position: relative; left: 245px;">
					<input type="text" class="db" id="leafqty'.$lid.'" name="leafqty'.$lid.'" max="99" min="0" value="'.$l_qty.'" onChange="calculatePrice_wEdit(); writeLPrice();" > db
				</td>
				<td style="position: relative; left: 125px;">
					<input type="button" class="inc_button" name="add_leaf" onclick="javascript: document.getElementById(\'leafqty'.$lid.'\').value++; calculatePrice_wEdit(); writeLPrice();" value="+"/>
					<input type="button" class="dec_button" name="subtract_leaf" onclick="javascript: document.getElementById(\'leafqty'.$lid.'\').value--; calculatePrice_wEdit(); writeLPrice();" value="-" />
				</td>';
				$lid++;
				}
				?>
			</tr>
		</table>
		<table id="rezgotable" style="width: 730px; border-style:solid; border-left-width:15px; border-color:#7c9e75;">
			<tr>
				<td style="position: relative; left: 235px;">
		<?php
			if ($_GET['rezgo'] == "true") {
				echo '<input type="checkbox" id="rezgo" name="rezgo" value="rezgo" onChange="rezgoqtyEnable(); calculatePrice_wEdit(); writeLPrice();" checked>';
			} else {
				echo '<input type="checkbox" id="rezgo" name="rezgo" value="rezgo" onChange="rezgoqtyEnable(); calculatePrice_wEdit(); writeLPrice();">';
			}
		?>
					<label for="rezgo">Rezgő</label>
				</td>
				<td style="position: relative; left: 205px;">
		<?php if ($_GET['rezgo'] == "true") {
			echo'	<input type="text" class="db" id="rezgoqty" name="rezgoqty" max="99" min="1" value="'.$_GET['rqty'].'" onChange="calculatePrice_wEdit(); writeLPrice();"> db';
			} else {
			echo'	<input type="text" class="db" id="rezgoqty" name="rezgoqty" max="99" min="1" value="'.$_GET['rqty'].'" onChange="calculatePrice_wEdit(); writeLPrice();" disabled> db';
			}	?>
				</td>
				<td style="position: relative; left: 25px;">
					<input type='button' class="inc_button" name='add_leaf' onclick='javascript: document.getElementById("rezgoqty").value++; calculatePrice_wEdit(); writeLPrice();' value='+'/>
					<input type='button' class="dec_button" name='subtract_leaf' onclick='javascript: document.getElementById("rezgoqty").value--; calculatePrice_wEdit(); writeLPrice();' value='-' />
				</td>
			</tr>
				<table class="subtotal">
					<tr>
						<td> Részösszeg: </td> <td id="lsubtotal" style="position: relative;left: 5px;">0 Ft</td>
					</tr>
				</table>
		</table>

		<table id="note" style="width: 730px; border-style:solid; border-left-width:15px; border-color:#5f7f71; margin-top: 5px;">
			<tr class="topborder">
				<td style="font: normal 16px/18px 'Arial'; color: #89a583;"> Kép feltöltése:
					<input type="file" name="file" id="file" onChange="thumbnail(this);"><br><br>
					<img id="img_prev" src="#" alt="Feltöltendő kép" style="visibility: hidden;">
				</td>
				<td style="font: normal 16px/18px 'Arial'; color: #89a583;"> Jelenlegi kép: <br><br>
					<?php
						$curr_img = $_GET['img'];
						$last_char = substr($curr_img, -1);
						if ($last_char == "|") {
							$curr_img = substr($curr_img, 0, -1);
						}
					?>
			<?php echo '<img src="img/wreath/'.$curr_img.'" style="width: 120px;">'; ?>
			<?php echo '<input type="hidden" value="'.$curr_img.'" name="current_img">'; ?>
				</td>
			</tr>
		</table>

		<table id="gallery" style="border-style:solid; border-left-width:15px; border-color: #509690; margin-top: 5px; width: 730px;">
			<tr class="topborder">
				<td style="font: normal 16px/18px 'Arial'; color: #89a583;"> Képek feltöltése:
					<input type="file" name="swreath_img_gallery[]" id="swreath_img_gallery" multiple>
				</td>
				<td style="font: normal 16px/18px 'Arial'; color: #89a583;"> Galéria:
				</td>
			</tr>
			<tr>
				<td>
				</td>
				<td>
					<?php
						$query = "SELECT id FROM special_wreath WHERE name LIKE '".$_GET['wreath']."' LIMIT 0,1";
						$result = mysql_query($query) or die (mysql_error());
						while ($row = mysql_fetch_assoc($result)) {
							$id = $row['id'];
						}

						$query = "SELECT url FROM `special_wreath_img` WHERE special_wreath_id = $id";
						$result = mysql_query($query) or die (mysql_error());
						while ($row = mysql_fetch_assoc($result)) {
							echo '<img src="'.$row['url'].'" style="width: 120px; margin: 0 5px 5px 0;">';
						}
					?>
				</td>
			</tr>
		</table>

		<?php
			$orig_sale_price_sql = "SELECT sale_price FROM special_wreath WHERE name = '" . $_GET['wreath'] . "' LIMIT 0,1";
			$result = mysql_query($orig_sale_price_sql) or die (mysql_error());

			while ($row = mysql_fetch_assoc($result)) {
				$orig_sale_price = $row['sale_price'];
			}
		?>
		<table id="price" style="width: 730px; border-style:solid; border-left-width:15px; border-color:#5f7fff; margin-top: 5px;">
			<tr class="topborder">
				<td></td>
				<td></td>
				<td> Eredeti értékesítési ár: </td>
				<td> <?php echo number_format($orig_sale_price, 0, ',', ' ').' Ft'; ?>  </td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td> Kalkulált ár: </td>
				<td> <input type="text" name="wreathprice" id="wreath_price" readonly> </td>
				<td> Értékesítési ár: </td>
				<td> <input type="text" name="endprice" id="fullprice" > </td>
				<td rowspan="2"> <input type="button" id="kiertekeles" value="Kiértékelés" onClick="calcFullPrice();" > </td>
				<td rowspan="2"> <input type="submit" id="submit" value="Módosít!" > </td>
			</tr>
			<tr>
				<td colspan="2"> (Alkotók, összetevők) </td>
				<td colspan="2"> (Nyereség + Viszonteladói kedvezmény) </td>
			</tr>
		</table>
	</form>
</body>
</html>