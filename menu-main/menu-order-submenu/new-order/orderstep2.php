<?php session_start(); ?>
<link rel="stylesheet" href="css/calendar/default.css" type="text/css">
<script type="text/javascript" src="js/zebra_datepicker.js"></script>
<!-- ---------------------------- Timepicker ---------------------------- -->
<link rel="stylesheet" href="js/timepicker/include/ui-1.10.0/ui-lightness/jquery-ui-1.10.0.custom.min.css" type="text/css" />
<link rel="stylesheet" href="js/timepicker/jquery.ui.timepicker.css?v=0.3.2" type="text/css" />
<script type="text/javascript" src="js/timepicker/include/ui-1.10.0/jquery.ui.core.min.js"></script>
<script type="text/javascript" src="js/timepicker/jquery.ui.timepicker.js?v=0.3.2"></script>
<script type="text/javascript">
	$('#ritual_date').Zebra_DatePicker({
  	//direction: true    // made the date picker future only
	});
</script>
<!-- ---------------------------- Masked Input ---------------------------- -->
<script type="text/javascript" src="js/input/jquery.mask.min.js"></script>

	<?php
		include '../../../config.php';

		if (!isset($_GET['back'])) {
			$_SESSION['wreath'] = "";
			$_SESSION['wreath_preview_src'] = "";
			$_SESSION['azonosito'] = "";
			$_SESSION['givers'] = "";

			$_SESSION["isRibbon"] = "";
			$_SESSION["ribbon"] = "";
			$_SESSION["ribboncolor"] = "";
			$_SESSION["farewelltext"] = "";

			$_SESSION['wreathNum'] = $_GET['wreathnum'];
			$ind = 1;

			for ($i=0; $i < $_SESSION['wreathNum']; $i++) { 
				$_SESSION['wreath'][$ind] = $_GET["wreath$ind"];
				$_SESSION['wreath_preview_src'][$ind] = $_GET["wreath_preview_src$ind"];

				if (isset($_GET["isRibbon$ind"])) {
					$_SESSION["isRibbon"][$ind] = $_GET["isRibbon$ind"]; // on / off
					$_SESSION["ribbon"][$ind] = $_GET["ribbon$ind"];
					$_SESSION["ribboncolor"][$ind] = $_GET["ribboncolor$ind"];
					$_SESSION["farewelltext"][$ind] = $_GET["farewelltext$ind"];
					$_SESSION['givers'][$ind] = $_GET["givers$ind"];
				} else {
					$_SESSION["isRibbon"][$ind] = "";
					$_SESSION["ribbon"][$ind] = "";
					$_SESSION["ribboncolor"][$ind] = "";
					$_SESSION["farewelltext"][$ind] = "";
					$_SESSION['givers'][$ind] = "";
				}
				$ind++;
			}


			$_SESSION['offer'] = "";
			$_SESSION['offerazonosito'] = "";
			$_SESSION['offergivers'] = "";

			$_SESSION["isOfferribbon"] = "";
			$_SESSION["offerribbon"] = "";
			$_SESSION["offerribboncolor"] = "";
			$_SESSION["offerfarewell"] = "";
			
			$_SESSION['offerNum'] = $_GET['offernum'];
			$ind = 1;

			for ($i=0; $i < $_SESSION['offerNum']; $i++) { 
				$_SESSION['offer'][$ind] = $_GET["offer$ind"]; //levágja a dátumot
				$ind++;
			}
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
			$ind++;
		}

		$_SESSION['endprice'] = $endprice;

		// echo "<pre>";
		// print_r($_SESSION['offer']);
		// echo "</pre>";
		// echo $_SESSION['offerNum'];
	?>
	<table>
		<tr>
			<td style="padding: 5px;">
				<input type="button" class="backward" value="Vissza" onClick="toStep1(true);"> 
			<td style="padding: 5px;">
				<input type="button" class="forward" value="Tovább" onClick="if(check2())toStep3();"> <!-- if(check2()) -->
			</td>
		</tr>
	</table>
<form id="step2">
<table class="order_table" style="border-bottom: solid 1px #5f7f71; margin-bottom: 10px; width: 100%;">
	<tr>
		<td style="font: normal 16px/18px 'Arial'; color: #89a583;"> 
			Megrendelői adatok
		</td>
	</tr>
	<tr>
		<td>* Megrendelő neve </td>
	<?php
		if ($_SESSION['customer_name'] == "") {
			echo '<td> <input type="text" id="customer_name" style="width: 285px;" name="customer_name"> </td>';
		} else {
			echo '<td> <input type="text" id="customer_name" style="width: 285px;" name="customer_name" value="'.$_SESSION['customer_name'].'"> </td>';
		}
	?>
	</tr>
	<tr>
		<td>* Telefonszáma </td>
	<?php
		if ($_SESSION['phone_num'] == "") {
			echo '<td> <input type="text" id="phone_num" name="phone_num" value="+36"> (Pl. +36 10 222 3344) </td>';
		} else {
			echo '<td> <input type="text" id="phone_num" name="phone_num" value="'.$_SESSION['phone_num'].'"> (Pl. +36 10 222 3344) </td>';
		}
	?>
	</tr>
	<tr>
		<td> Email cím </td>
	<?php
		if ($_SESSION['email'] == "") {
			echo '<td> <input type="text" id="email" name="email"> (Pl. pelda@gmail.com) </td>';
		} else {
			echo '<td> <input type="text" id="email" name="email" value="'.$_SESSION['email'].'"> (Pl. pelda@gmail.com) </td>';
		}
	?>
	</tr>
</table>
<table class="order_table_shipment" style="width: 100%;">
	<tr>
		<td style="font: normal 16px/18px 'Arial'; color: #89a583;">
			* Szállítás módja
		</td>
	</tr>
	<tr>
	<?php
		if ($_SESSION['shipment'] == "Nem kér kiszállítást") {
			echo '<td> <input type="radio" name="shipment" value="Nem kér kiszállítást" onClick="calcSumm(); pending_on_shipment();" onChange="customShipment();" checked> Nem kér kiszállítást </td>';
		} else {
			echo '<td> <input type="radio" name="shipment" value="Nem kér kiszállítást" onClick="calcSumm(); pending_on_shipment();" onChange="customShipment();" > Nem kér kiszállítást </td>';
		}
	?>
	<?php
		if ($_SESSION['shipment'] == "Erzsébeti temető") {
			echo '<td> <input type="radio" name="shipment" value="Erzsébeti temető" onClick="calcSumm(); pending_on_shipment();" onChange="customShipment();" checked> Erzsébeti temető </td>';
		} else {
			if ($_SESSION['shipment'] == "") {
				echo '<td> <input type="radio" name="shipment" value="Erzsébeti temető" onClick="calcSumm(); pending_on_shipment();" onChange="customShipment();" checked> Erzsébeti temető </td>';
			}
			else {
				echo '<td> <input type="radio" name="shipment" value="Erzsébeti temető" onClick="calcSumm(); pending_on_shipment();" onChange="customShipment();" > Erzsébeti temető </td>';
			}
			
		}
	?>
	<?php
		if ($_SESSION['shipment'] == "Egyedi helyszín") {
			echo '<td> <input type="radio" name="shipment" value="Egyedi helyszín" onClick="calcSumm(); pending_on_shipment();" onChange="customShipment();" checked> Egyedi helyszín </td>';
		} else {
			echo '<td> <input type="radio" name="shipment" value="Egyedi helyszín" onClick="calcSumm(); pending_on_shipment();" onChange="customShipment();" > Egyedi helyszín </td>';
		}
	?>
	</tr>
	<tr><td colspan="4">
	<?php
		if ($_SESSION['shipment'] == "Egyedi helyszín") {
			echo '<table id="custom_ship_place" style="display: block; width: 100%;">
				<tr>
					<td>
						* Temetés helyszíne: 
					</td>
					<td>
						<input type="text" name="c_location" id="c_location" value="'.$_SESSION['clocation'].'">
					</td>
				</tr>
				<tr>
					<td>
						* Címe:
					</td>
					<td>
						<input type="text" name="c_address" id="c_address" value="'.$_SESSION['caddress'].'">
					</td>
				</tr>
				<tr>
					<td>
						* Ravatalozó / terem:
					</td>
					<td>
						<input type="text" name="c_funeral" id="c_funeral" value="'.$_SESSION['cfuneral'].'">
					</td>
				</tr>
			</table>';
		} else {
			echo '<table id="custom_ship_place" style="display: none; width: 100%;">	</table>';
		}
	?>
	</td>
	</tr>
</table>
<table class="order_table" style="border-bottom: solid 1px #5f7f71; margin-bottom: 10px; width: 100%;">
	<tr>
		<td id="pending_on_shipment" style="font: normal 16px/18px 'Arial'; color: #89a583;">
		<?php if ($_SESSION['shipment'] == "Nem kér kiszállítást") { ?>
			* Átvétel időpontja
		<?php } else { ?>
			* Szertartás időpontja
		<?php } ?>
		</td>
	</tr>
	<tr>
		<td> Dátum </td>
	<?php
		if ($_SESSION['ritual_date'] == "") {
			echo '<td> <input id="ritual_date" placeholder="Dátum" type="text" name="ritual_date" id="ritual_date" readonly> </td>';
		} else {
			echo '<td> <input id="ritual_date" placeholder="Dátum" type="text" name="ritual_date" id="ritual_date" value="'.$_SESSION['ritual_date'].'" readonly> </td>';
		}
	?>
	</tr>
	<tr>
		<td> Idő </td>
	<?php
		if ($_SESSION['ritual_time'] == "") {
			$current_hour = intval(date("H"));
			$current_hour += (intval(date("i")) < 30) ? 0 : 1;
			echo '<td> <input type="text" name="ritual_time" id="ritual_time" value="' . $current_hour . ':00" placeholder="Idő" readonly /> </td>
			    <script type="text/javascript">
			        $(document).ready(function() {
			            $(\'#ritual_time\').timepicker( {
			                showAnim: \'blind\'
			            } );
			        });
			    </script>';
		} else {
			echo '<td> <input type="text" name="ritual_time" id="ritual_time" value="'.$_SESSION['ritual_time'].'" placeholder="Idő" readonly /> </td>
			    <script type="text/javascript">
			        $(document).ready(function() {
			            $(\'#ritual_time\').timepicker( {
			                showAnim: \'blind\'
			            } );
			        });
			    </script>';
		}
	?>
	</tr>
</table>
<table class="order_table" style="border-bottom: solid 1px #5f7f71; margin-bottom: 10px; width: 100%; ">
<?php if ($_SESSION['shipment'] == "Nem kér kiszállítást") { ?>
		<tr class="pending_on_shipment" style="display: none;">
			<td style="font: normal 16px/18px 'Arial'; color: #89a583;"> 
				* Elhunyt neve
			</td> 
		</tr>
		<tr class="pending_on_shipment" style="display: none;">
			<td> 
				Elhunyt neve: 
			</td>
			<td> 
				<input type="text" name="dead_name" id="dead_name" placeholder="Vezetéknév+Keresztnév" style="width: 285px;" /> 
			</td>
		</tr>
<?php } else { ?>
		<tr class="pending_on_shipment">
			<td style="font: normal 16px/18px 'Arial'; color: #89a583;"> 
				* Elhunyt neve
			</td> 
		</tr>
		<tr class="pending_on_shipment">
		<?php
			if ($_SESSION['dead_name'] == "") {
				echo '<td> Elhunyt neve: </td>';
				echo '<td colspan="2"> <input type="text" name="dead_name" id="dead_name" placeholder="Vezetéknév+Keresztnév" style="width: 285px;" /> </td>';
			} else {
				echo '<td> Elhunyt neve: </td>';
				echo '<td colspan="2"> <input type="text" name="dead_name" id="dead_name" value="'.$_SESSION['dead_name'].'" style="width: 285px;" /> </td>';
			}
		?>
		</tr>
<?php } ?>
</table>
<table class="order_table" style="border-bottom: solid 1px #5f7f71; margin-bottom: 10px; width: 100%;">
	<tr>
		<td style="font: normal 16px/18px 'Arial'; color: #89a583;"> 
			Fizetés
		</td>
	</tr>
	<tr>
		<td> Végösszeg </td>
	<?php 
		echo '<td> <input type="text" name="end_price" id="end_price" value="'.number_format($endprice, 0, '', ' ').' Ft" readonly/> </td>';
	?>
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
				echo'<td> <input type="text" id="ship_price" name="ship_price" value="0 Ft" onChange="calcSumm(); calcRemainder();"> (Pl. 2 000 Ft) </td>';
		}
	} else {
		echo '<td> <input type="text" id="ship_price" name="ship_price" value="'.$_SESSION['ship_price'].'" onChange="calcSumm(); calcRemainder();"> </td>';
	}

	 ?> <!-- ha 20.000 ft fölött a megrendelés akk díjtalan, alatta 2.000 ft  -->
	</tr>
	<tr>
		<td>Összesen</td>
		<td>
		<?php if ($_SESSION['price'] == "") { ?>
				<input type="text" id="sum_price" name="sum_price" value="" readonly>
		<?php } else { ?>
				<input type="text" id="sum_price" name="sum_price" value="<?php echo $_SESSION['price']; ?>" readonly>
		<?php } ?>
		</td>
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
					<table class="order_table" style="width: 100%;" id="pay_prices">
						<tr>
							<td> Előleg (Pl: 5000)</td>';
						if ($_SESSION['downprice'] == 0) {
					echo '	<td> <input type="text" name="downprice" id="downprice" onChange="calcRemainder();" /> </td>';
						} else {
					echo '	<td> <input type="text" name="downprice" id="downprice" onChange="calcRemainder();" value="'.$_SESSION['downprice'].'" /> </td>';
						}
					echo'</tr><tr>';
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
<table>
	<tr>
		<td style="font: normal 16px/18px 'Arial'; color: #89a583;"> 
			Egyéb információk
		</td>
	</tr>
	<tr>
		<td>
			Megjegyzés
		</td>
		<td>
		<?php if ($_SESSION['order_note'] == "") { ?>
			<textarea style="height: 32px;width: 450px;resize: vertical;" cols="50" rows="5" id="order_note" name="order_note" placeholder="Megjegyzés"></textarea>
		<?php } else { ?>
			<textarea style="height: 32px;width: 450px;resize: vertical;" cols="50" rows="5" id="order_note" name="order_note" placeholder="Megjegyzés"><?php echo $_SESSION['order_note']; ?></textarea>
		<?php } ?>
		</td>
	</tr>
	<tr>
		<td>	
			* Bolt választó:
		</td>
		<td>
			<select id="shopname" name="shopname">
				<option disabled value="" selected>Válasszon Boltot!</option>
				<?php 
					$query = "SELECT name FROM `shops` WHERE enable = 1";
					$result = mysql_query($query) or die(mysql_error());

					while ($row = mysql_fetch_assoc($result)) {
						$shopname = $row['name'];
						if ($_SESSION['shopname'] == $shopname) {
							echo "<option value='$shopname' selected>$shopname</option>";
						} else {
							echo "<option value='$shopname' >$shopname</option>";
						}
					}
				?>
			</select>
		</td>
	</tr>
</table>
<table>
	<tr>
		<td>* A csillaggal jelölt mezők kitöltése kötelező!</td>
	</tr>
</table>
</form>