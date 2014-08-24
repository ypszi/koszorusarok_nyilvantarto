<?php session_start(); ?>
<?php
	include '../../../config.php';

	if (!isset($_GET['back'])) {
		$_SESSION['customer_name'] = $_GET['customer_name'];
		$_SESSION['phone_num'] = $_GET['phone_num'];
		$_SESSION['email'] = $_GET['email'];
	}

	$endprice = 0;
	$ind = 1;
	for ($i=0; $i < $_SESSION['wreathNum']; $i++) { 

		$query = "SELECT `sale_price` FROM `special_wreath` WHERE name='".$_SESSION['wreath'][$ind]."'";
		$result = mysql_query($query) or die(mysql_error());

		while ($row = mysql_fetch_assoc($result)) {
			$endprice += $row['sale_price'];
		}
		
		if ($_SESSION['ribbon'][$ind] != "") {
			$query_ribbon = "SELECT price FROM  `ribbon_type` WHERE type='".$_SESSION['ribbon'][$ind]."'";
			$result_ribbon = mysql_query($query_ribbon) or die(mysql_error());

			while ($row = mysql_fetch_assoc($result_ribbon)) {
				$endprice += $row['price'];
			}
		}

		if ($_SESSION['ribboncolor'][$ind] != "") {
			$query_rcolor = "SELECT `price` FROM `ribbon_color` WHERE color='".$_SESSION['ribboncolor'][$ind]."'";
			$result_rcolor = mysql_query($query_rcolor) or die(mysql_error());

			while ($row = mysql_fetch_assoc($result_rcolor)) {
				$endprice += $row['price'];
			}
		}
		
		$ind++;
	}

	$ind = 1;
	for ($i=0; $i < $_SESSION['offerNum']; $i++) { 
		
		$query = "SELECT `sale_price` FROM `offer_wreath` WHERE name='".$_SESSION['offer'][$ind]."'";
		$result = mysql_query($query) or die(mysql_error());

		while ($row = mysql_fetch_assoc($result)) {
			$endprice += $row['sale_price'];
		}
		
		$query_ribbon = "SELECT price FROM  `ribbon_type` WHERE type='".$_SESSION['offerribbon'][$ind]."'";
		$result_ribbon = mysql_query($query_ribbon) or die(mysql_error());

		while ($row = mysql_fetch_assoc($result_ribbon)) {
			$endprice += $row['price'];
		}

		$query_rcolor = "SELECT `price` FROM `ribbon_color` WHERE color='".$_SESSION['offerribboncolor'][$ind]."'";
		$result_rcolor = mysql_query($query_rcolor) or die(mysql_error());

		while ($row = mysql_fetch_assoc($result_rcolor)) {
			$endprice += $row['price'];
		}
		
		$ind++;
	}

	$_SESSION['endprice'] = $endprice;
?>
	<table>
		<tr>
			<td style="padding: 5px;">
				<input type="button" class="backward" value="Vissza" onClick="toStep3(true);"> 
			<td style="padding: 5px;">
				<input type="button" class="forward" value="Tovább" onClick="if(check4())toStep5();"> <!-- if(check4()) -->
			</td>
		</tr>
	</table>
<form id="step4">
	<table style="width: 393px;">
		<tr>
			<td> Végösszeg </td>
	<?php echo '<td> <input type="text" name="sum_price" id="sum_price" value="'.number_format($endprice, 0, '', ' ').' Ft" readonly/> </td>'; ?>
		</tr>
		<tr>
			<td> Szállítási költség</td> 
	<?php 	
		if ($_SESSION['ship_price'] == "") {
			if ($_SESSION['shipment'] == "Nem kér kiszállítást" || $_SESSION['shipment'] == "Erzsébeti temető" || $endprice > 20000) {
				if (($endprice > 20000)&&($_SESSION['shipment'] == "Egyedi helyszín")) {
					echo'<td> <input type="text" id="ship_price" name="ship_price" value="0 Ft" onChange="calcSumm(); calcRemainder();"> </td>';
				} else {
					echo'<td> <input type="text" id="ship_price" name="ship_price" value="0 Ft" readonly> </td>';
				}
			} else {
					echo'<td> <input type="text" id="ship_price" name="ship_price" value="2 000 Ft" onChange="calcSumm(); calcRemainder();"> (Pl. 2 000 Ft) </td>';
			}
		} else {
			echo '<td> <input type="text" id="ship_price" name="ship_price" value="'.$_SESSION['ship_price'].'" onChange="calcSumm(); calcRemainder();"> </td>';
		}

		 ?> <!-- ha 20.000 ft fölött a megrendelés akk díjtalan, alatta 2.000 ft  -->
		</tr>
		<tr>
			<td>Összesen</td>
			<td><input type="text" id="price_sum" name="sum_price" value="" readonly></td>
		</tr>
		<tr>
		<?php 
			if ($_SESSION['paid'] == "Fizetve") {
				echo '
					<td> <input type="checkbox" name="paid" id="paid" onChange="isPaid();" checked> Kifizetve </td>
				</tr>
				<tr>
					<td colspan="4"> 
						<table id="pay_prices"></table>
					</td>
				</tr>';
			} else {
				echo '
					<td> <input type="checkbox" name="paid" id="paid" onChange="isPaid();" > Kifizetve </td>
				</tr>
				<tr>
					<td colspan="4"> 
						<table id="pay_prices">
							<tr>
								<td> Előleg (Pl: 5000)</td>';
							if ($_SESSION['downprice'] == 0) {
						echo '	<td> <input type="text" name="downprice" id="downprice" onChange="calcRemainder();" /> </td>';
							} else {
								echo '	<td> <input type="text" name="downprice" id="downprice" onChange="calcRemainder();" value="'.$_SESSION['downprice'].'" /> </td>';
							}
						echo'	<td> Hátralék </td>';
							if ($_SESSION['remainder'] == 0) {
						echo '	<td> <input type="text" name="remainder" id="remainder" /> </td>';
							} else {
						echo '	<td> <input type="text" name="remainder" id="remainder" value="'.$_SESSION['remainder'].'" /> </td>';
							}
					echo'
							</tr>
						</table>
					</td>
				</tr>';
			}
		?>
	</table>
</form>