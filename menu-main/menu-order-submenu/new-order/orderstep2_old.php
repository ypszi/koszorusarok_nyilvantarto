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
	<?php
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
				$_SESSION['azonosito'][$ind] = $_GET["azonosito$ind"];
				$_SESSION['givers'][$ind] = $_GET["givers$ind"];

				if (isset($_GET["isRibbon$ind"])) {
					$_SESSION["isRibbon"][$ind] = $_GET["isRibbon$ind"]; // on / off
					$_SESSION["ribbon"][$ind] = $_GET["ribbon$ind"];
					$_SESSION["ribboncolor"][$ind] = $_GET["ribboncolor$ind"];
					$_SESSION["farewelltext"][$ind] = $_GET["farewelltext$ind"];
				} else {
					$_SESSION["isRibbon"][$ind] = "";
					$_SESSION["ribbon"][$ind] = "";
					$_SESSION["ribboncolor"][$ind] = "";
					$_SESSION["farewelltext"][$ind] = "";
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
				$_SESSION['offerazonosito'][$ind] = $_GET["offerazonosito$ind"];
				$_SESSION['offergivers'][$ind] = $_GET["offergivers$ind"];

				if (isset($_GET["isOfferribbon$ind"])) {
					$_SESSION["isOfferribbon"][$ind] = $_GET["isOfferribbon$ind"]; // on / off
					$_SESSION["offerribbon"][$ind] = $_GET["offerribbon$ind"];
					$_SESSION["offerribboncolor"][$ind] = $_GET["offerribboncolor$ind"];
					$_SESSION["offerfarewell"][$ind] = $_GET["offerfarewell$ind"];
				} else {
					$_SESSION["isOfferribbon"][$ind] = "";
					$_SESSION["offerribbon"][$ind] = "";
					$_SESSION["offerribboncolor"][$ind] = "";
					$_SESSION["offerfarewell"][$ind] = "";
				}
				$ind++;
			}
		}
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
<table>
		<tr>
			<td style="font: normal 16px/18px 'Arial'; color: #89a583;"> 
				* Elhunyt neve
			</td> 
		</tr>
		<tr>
		<?php
			if ($_SESSION['deadname'] == "") {
				echo '<td colspan="2"> <input type="text" name="dead_name" id="dead_name" placeholder="Vezetéknév+Keresztnév" style="width: 285px;" /> </td>';
			} else {
				echo '<td colspan="2"> <input type="text" name="dead_name" id="dead_name" value="'.$_SESSION['deadname'].'" style="width: 285px;" /> </td>';
			}
		?>
		</tr>
		<tr>
			<td style="font: normal 16px/18px 'Arial'; color: #89a583;">
				* Szertartás időpontja
			</td>
		</tr>
		<tr>
			<td> Dátum </td>
		<?php
			if ($_SESSION['ritualdate'] == "") {
				echo '<td> <input id="ritual_date" placeholder="Dátum" type="text" name="ritual_date" id="ritual_date" readonly> </td>';
			} else {
				echo '<td> <input id="ritual_date" placeholder="Dátum" type="text" name="ritual_date" id="ritual_date" value="'.$_SESSION['ritualdate'].'" readonly> </td>';
			}
		?>
			<td> Idő </td>
		<?php
			if ($_SESSION['ritualtime'] == "") {
				echo '<td> <input type="text" name="ritual_time" id="ritual_time" value="" placeholder="Idő" readonly /> </td>
				    <script type="text/javascript">
				        $(document).ready(function() {
				            $(\'#ritual_time\').timepicker( {
				                showAnim: \'blind\'
				            } );
				        });
				    </script>';
			} else {
				echo '<td> <input type="text" name="ritual_time" id="ritual_time" value="'.$_SESSION['ritualtime'].'" placeholder="Idő" readonly /> </td>
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
		<tr>
			<td style="font: normal 16px/18px 'Arial'; color: #89a583;">
				* Szállítás módja
			</td>
		</tr>
		<tr>
		<?php
			if ($_SESSION['shipment'] == "Nem kér kiszállítást") {
				echo '<td> <input type="radio" name="shipment" value="Nem kér kiszállítást" onChange="customShipment();" checked> Nem kér kiszállítást </td>';
			} else {
				echo '<td> <input type="radio" name="shipment" value="Nem kér kiszállítást" onChange="customShipment();" > Nem kér kiszállítást </td>';
			}
		?>
		</tr>
		<tr>
		<?php
			if ($_SESSION['shipment'] == "Erzsébeti temető") {
				echo '<td> <input type="radio" name="shipment" value="Erzsébeti temető" onChange="customShipment();" checked> Erzsébeti temető </td>';
			} else {
				if ($_SESSION['shipment'] == "") {
					echo '<td> <input type="radio" name="shipment" value="Erzsébeti temető" onChange="customShipment();" checked> Erzsébeti temető </td>';
				}
				else {
					echo '<td> <input type="radio" name="shipment" value="Erzsébeti temető" onChange="customShipment();" > Erzsébeti temető </td>';
				}
				
			}
		?>
		</tr>
		<tr>
		<?php
			if ($_SESSION['shipment'] == "Egyedi helyszín") {
				echo '<td> <input type="radio" name="shipment" value="Egyedi helyszín" onChange="customShipment();" checked> Egyedi helyszín </td>';
			} else {
				echo '<td> <input type="radio" name="shipment" value="Egyedi helyszín" onChange="customShipment();" > Egyedi helyszín </td>';
			}
		?>
		</tr>
	</table>
		<?php
			if ($_SESSION['shipment'] == "Egyedi helyszín") {
				echo '<table id="custom_ship_place" style="display: block;">
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
				echo '<table id="custom_ship_place" style="display: none;">	</table>';
			}
		?>
	<table>
		<tr>
			<td>A csillaggal jelölt mezők kitöltése kötelező!</td>
		</tr>
	</table>
</form>