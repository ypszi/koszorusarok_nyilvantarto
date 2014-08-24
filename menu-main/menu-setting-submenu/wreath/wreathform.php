<html>
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
	<link href="css/wformstyle.css" rel="stylesheet" type="text/css" media="all">
	<link href="css/alertwindow.css" rel="stylesheet" type="text/css" media="all">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.0/jquery-ui.min.js"></script>
	<script type="text/javascript" src="js/protea_functions.js"></script>
	
</head>
<body onload="initTableRef();">
	<?php
		$_SESSION['flowers'] = 0;
		$_SESSION['leafs'] = 0;
		$_SESSION['wprice'] = 0;
		$_SESSION['fprice'] = 0;
		$_SESSION['lprice'] = 0;
	?>

	<div id="alertwindow"></div>

	<form id="wreathform" method="POST" action="menu-main/menu-setting-submenu/wreath/newreath.php" enctype="multipart/form-data" onsubmit="return dataCheck()">
		<table id="wreath" style="border-style:solid; border-left-width:15px; border-color:#c8dba6; margin-top: 5px; width: 730px;">
			<tr>
				<td colspan="2" style="font: normal 16px/18px 'Arial'; color: #89a583;"> Adja meg a koszorú kódját/nevét! </td>
			</tr> 
			<tr>
				<td style="font: normal 16px/18px 'Arial'; color: #89a583;">
					<input type="text" name="wreath_name" id="wreath_name" placeholder="Típus + sorszám" > 
					<input type="text" name="wreath_fancy" id="wreath_fancy" placeholder="Fantázia név" style="margin-top: 7px;"> 
				</td>
				<td style="font: normal 16px/18px 'Arial'; color: #89a583; position: relative; right: -28px;">
					<textarea style="resize: none; width: 450px;" name="note" id="note" rows="3" cols="80" maxlength="500" placeholder="Írja ide a megjegyzést!"></textarea> 
				</td>
			</tr>
			<tr class="topborder"> 
				<td colspan="2" style="font: normal 16px/18px 'Arial'; color: #89a583;"> Adja meg a koszorú alapját! </td>
			</tr>
			<tr>
				<td> <select id="base_wreath_type" name="base_wreath_type" onChange="loadBaseWreathSizes(); eraseWSubtotal(); ">
						<option disabled value="" selected>Válasszon koszorú alapot!</option>
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
				<td style="position: relative; left: 18px;"> <select id="base_wreath_size" name="base_wreath_size" onChange="calculatePrice_wForm(); writeWPrice();" disabled >
						<option disabled value="" selected>Először válasszon koszorú alapot!</option>
					 </select>
				</td>
				<table class="subtotal">
					<tr>
						<td id="wprice"> Részösszeg: </td> <td id="wsubtotal" style="position: relative;left: 5px; margin-top: 5px;">0 Ft</td>
					</tr>
				</table>
			</tr>
		</table>

		<table id="flower" style="border-style:solid; border-left-width:15px; border-color:#c8dba6; margin-top: 5px; width: 730px;">
			<tr class="topborder"> 
				<td colspan="4" style="font: normal 16px/18px 'Arial'; color: #89a583;"> Adja meg a koszorú virágait!
					<input type="button" value="Új összetevő" class="plus" onClick="addFlowerRow();" >
					<input type="button" value="Utolsó összetevő eltávolítása" class="minus" onClick="remFlowerRow(); calculatePrice_wForm(); writeFPrice();" ></td>
				<td><input type="hidden" id="flowernum" name="flowernum" value="1"></td>
			</tr>
			<tr>
				<?php include 'flowerrow.php'; ?>
			</tr>
				<table class="subtotal">
					<tr>
						<td id="fprice"> Részösszeg: </td> <td id="fsubtotal" style="position: relative;left: 5px; margin-top: 5px;">0 Ft</td>
					</tr>
				</table>
		</table>

		<table id="leaf" style="border-style:solid; border-left-width:15px; border-color:#9db88a; margin-top: 5px; width: 730px;"> 
			<tr class="topborder"> 
				<td colspan="4" style="font: normal 16px/18px 'Arial'; color: #89a583;"> Adja meg a koszorú leveleit! 
					<input type="button" value="Új összetevő" class="plus" onClick="addLeafRow();" >
					<input type="button" value="Utolsó összetevő eltávolítása" class="minus" onClick="remLeafRow(); calculatePrice_wForm(); writeLPrice();" ></td>
				<td><input type="hidden" id="leafnum" name="leafnum" value="1"></td>
			</tr>
			<tr>
				<?php include "leafrow.php"; ?>
			</tr>
		</table>

		<table id="rezgotable" style="border-style:solid; border-left-width:15px; border-color:#7c9e75; width: 730px;">
			<tr>
				<td style="position: relative; left: 235px;">
					<input type="checkbox" id="rezgo" name="rezgo" value="rezgo" onChange="rezgoqtyEnable(); calculatePrice_wForm(); writeLPrice();" >
					<label for="rezgo">Rezgő</label> 
				</td>
				<td style="position: relative; left: 205px;">
					<input type="text" class="db" id="rezgoqty" name="rezgoqty" max="99" min="1" value="1" onChange="calculatePrice_wForm(); writeLPrice();" disabled> db
				</td>
				<td style="position: relative; left: 10px;">
					<input type='button' class="inc_button" name='add_leaf' onclick='javascript: document.getElementById("rezgoqty").value++; calculatePrice_wForm(); writeLPrice();' value='+'/>
					<input type='button' class="dec_button" name='subtract_leaf' onclick='javascript: document.getElementById("rezgoqty").value--; calculatePrice_wForm(); writeLPrice();' value='-' />
				</td>
			</tr>
				<table class="subtotal">
					<tr>
						<td> Részösszeg: </td> <td id="lsubtotal" style="position: relative;left: 5px;">0 Ft</td>
					</tr>
				</table>
		</table>

		<table id="note" style="border-style:solid; border-left-width:15px; border-color:#5f7f71; margin-top: 5px; width: 730px;">
			<tr class="topborder">
				<td style="font: normal 16px/18px 'Arial'; color: #89a583;"> Kép feltöltése: 
					<input type="file" name="swreath_img[]" id="swreath_img" onChange="thumbnail(this);" multiple>
				</td>
				<td style="font: normal 16px/18px 'Arial'; color: #89a583;"> Galéria: 
				</td>
			</tr>
			<tr>
				<td>
					<img id="img_prev" src="#" alt="Feltöltendő kép" style="visibility: hidden;">
				</td>
			</tr>
		</table>

		<table id="price" style="border-style:solid; border-left-width:15px; border-color:#5f7fff; margin-top: 5px; width: 730px;">
			<tr class="topborder">
				<td> Kalkulált ár: </td>
				<td> <input type="text" name="wreathprice" id="wreath_price" readonly> </td>
				<td> Értékesítési ár: </td>
				<td> <input type="text" name="endprice" id="fullprice" > </td>
				<td rowspan="2"> <input type="button" id="kiertekeles" value="Kiértékelés" onClick="calcFullPrice();" > </td>
				<td rowspan="2"> <input type="submit" id="submit" value="Hozzáadom!"> </td>
			</tr>
			<tr>
				<td colspan="2"> (Alkotók, összetevők) </td>
				<td colspan="2"> (Nyereség + Viszonteladói kedvezmény) </td>
			</tr>
		</table>
	</form>
</body>
</html>