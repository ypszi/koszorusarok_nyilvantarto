<link href="css/alertwindow.css" rel="stylesheet" type="text/css" media="all">
<div class="exit" class="button" id="exit" style="display: none;" onClick="$('#shop_changer').toggle();"> X </div>
<div id='alertwindow'></div>

<?php
	include '../../config.php';
	echo '<h1 style="color: #54BE98;">Rendelés áthelyezése</h1>';
	echo '<select id="change_shop" name="change_shop" style="margin-top: 15px;">
					<option disabled value="" selected>Válasszon boltot a rendelés áthelyezéséhez!</option>';
					$query = "SELECT shops.id, name FROM `shops`, `orders` WHERE shops.enable = 1 AND orders.id = ".$_GET["id"]."";
					$result = mysql_query($query) or die(mysql_error());

					while ($row = mysql_fetch_assoc($result)) {
						$shopname = $row['name'];
						$shopid = $row['id'];
						echo "<option value='$shopid - $shopname' >$shopname</option>";
					}
	echo '</select>';
	echo '<input type="button" class="button" style="margin: 15px 95px;" value="Áthelyezés" onClick="return changeshop('.$_GET["id"].');">';

	$query = "SELECT shop FROM `orders` WHERE id = ".$_GET['id']."";
	$result = mysql_query($query) or die(mysql_error());
	while ($row = mysql_fetch_assoc($result)) {
		$curr_shop_id = $row['shop'];
		echo "<h2> Jelenlegi üzlet: ";
	}
	$query = "SELECT name FROM `shops` WHERE shops.enable = 1 AND shops.id = $curr_shop_id";
	$result = mysql_query($query) or die(mysql_error());
	while ($row = mysql_fetch_assoc($result)) {
		$curr_shop_name = $row['name'];
		echo "$curr_shop_name </h2>";
	}
?>