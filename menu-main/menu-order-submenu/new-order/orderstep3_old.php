<?php session_start(); ?>

	<script type="text/javascript" src="js/protea_functions.js"></script>
<!-- ---------------------------- Masked Input ---------------------------- -->
<script type="text/javascript" src="js/input/jquery.mask.min.js"></script>

<?php
	if (!isset($_GET['back'])) {
		$_SESSION['deadname'] = $_GET['dead_name'];
		$_SESSION['ritualdate'] = $_GET['ritual_date'];
		$_SESSION['ritualtime'] = $_GET['ritual_time'];
		$_SESSION['shipment'] = $_GET['shipment'];
		if (isset($_GET["c_location"])) {
			$_SESSION['clocation'] = $_GET['c_location'];
		}
		if (isset($_GET["c_address"])) {
			$_SESSION['caddress'] = $_GET['c_address'];
		}
		if (isset($_GET["c_funeral"])) {
			$_SESSION['cfuneral'] = $_GET['c_funeral'];
		}
	}
?>

	<table>
		 <tr>
			<td style="padding: 5px;">
				<input type="button" class="backward" value="Vissza" onClick="toStep2(true);"> 
			</td>
			<td style="padding: 5px;">
				<input type="button" class="forward" value="Tovább" onClick="if(check3())toStep4();"> <!-- if(check3()) -->
			</td>
		</tr>
	</table>
	
<form id="step3">
	<table>
		<tr>
			<td>* Megrendelő neve </td>
		<?php
			if ($_SESSION['customer_name'] == "") {
				echo '<td> <input type="text" id="customer_name" name="customer_name"> </td>';
			} else {
				echo '<td> <input type="text" id="customer_name" name="customer_name" value="'.$_SESSION['customer_name'].'"> </td>';
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
		<tr>
			<td>A csillaggal jelölt mezők kitöltése kötelező!</td>
		</tr>
	</table>
</form>