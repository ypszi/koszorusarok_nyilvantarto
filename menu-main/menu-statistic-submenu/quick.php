<?php if ($_SESSION['logged_in'] == 1 || $_SESSION['logged_in'] == 2 || $_SESSION['logged_in'] == 3) { ?>
	<div class="title">
		<span class="firstWord">Tulajdonosi</span> információk 
	</div>
<?php
	$query = "SELECT COUNT(id) FROM `users`;";
	$result = mysql_query($query) or die (mysql_error());
	$user_db = mysql_result($result,0);

	$query = "SELECT COUNT(id) FROM `flower`;";
	$result = mysql_query($query) or die (mysql_error());
	$flower_db = mysql_result($result,0);

	$query = "SELECT COUNT(id) FROM `special_wreath`;";
	$result = mysql_query($query) or die (mysql_error());
	$wreath_db = mysql_result($result,0);

	$query = "SELECT SUM(price) FROM orders WHERE ARCHIVE =0 AND YEAR(paid) = YEAR(CURRENT_TIMESTAMP())";
	$result = mysql_query($query) or die (mysql_error());
	$price_year_db = mysql_result($result,0);
	
	$query = "SELECT count( orders.id ) FROM orders WHERE ARCHIVE =0 AND YEAR(paid) = YEAR(CURRENT_TIMESTAMP())";
	$result = mysql_query($query) or die (mysql_error());
	$soldwreat_year_db = mysql_result($result,0);	

	$query = "SELECT count(order_items.id) FROM orders,order_items WHERE archive=0 AND order_items.order_id=orders.id AND YEAR(paid) = YEAR(CURRENT_TIMESTAMP());";
	$result = mysql_query($query) or die (mysql_error());
	$soldwreatitem_year_db = mysql_result($result,0);	

	$query = "SELECT SUM( price ) FROM orders WHERE ARCHIVE =0 AND MONTH(paid) = MONTH(CURRENT_TIMESTAMP())";
	$result = mysql_query($query) or die (mysql_error());
	$sub_price_db = mysql_result($result,0);	

	$query = "SELECT count( orders.id ) FROM orders WHERE ARCHIVE =0 AND MONTH(paid) = MONTH(CURRENT_TIMESTAMP())";
	$result = mysql_query($query) or die (mysql_error());
	$soldwreat_month_db = mysql_result($result,0);	

	$query = "SELECT count(order_items.id) FROM orders,order_items WHERE archive=0 AND order_items.order_id=orders.id AND MONTH(paid) = MONTH(CURRENT_TIMESTAMP());";
	$result = mysql_query($query) or die (mysql_error());
	$soldwreatitem_month_db = mysql_result($result,0);	
	
?>


	<div style="padding: 20px 0px 20px 30px;">
		<table class='main_stat' style="width:690px;">
			<tr>
				<th>Adat</th>
				<th>Egység</th>
			</tr>
			<tr>
				<td>Alkalmazottak száma:</td>
				<td><?php echo $user_db; ?> db</td>
			</tr>
			<tr>
				<td>Virágok, levelek, rezgők száma:</td>
				<td><?php echo $flower_db; ?> db</td>
			</tr>
			<tr>
				<td>Eladásra szánt a rendszerben rögzített koszorúk száma:</td>
				<td><?php echo $wreath_db; ?> db</td>
			</tr>
			<tr>	
				<td style="background-color: #c9e2a0; height: 1px;" colspan="2">Éves</td>
			</tr>
			<tr>
				<td>Éves összes eladás (teljesítve):</td>
				<td><?php echo number_format($price_year_db, 0, ',', ' ').' ft'; ?></td>
			</tr>
			<tr>
				<td>Éves összes rendelés:</td>
				<td><?php echo $soldwreat_year_db; ?> db</td>
			</tr>
			<tr>
				<td>Éves összes megrendelt koszorú:</td>
				<td><?php echo $soldwreatitem_year_db; ?> db</td>
			</tr>
			<tr>	
				<td style="background-color: #c9e2a0; height: 1px;" colspan="2">Havi</td>
			</tr>
			<tr>
				<td>Havi összes eladás (Jelenlegi hónap):</td>
				<td><?php echo number_format($sub_price_db, 0, ',', ' ').' Ft'; ?></td>
			</tr>
			<tr>
				<td>Havi összes rendelés:</td>
				<td><?php echo $soldwreat_month_db; ?> db</td>
			</tr>
			<tr>
				<td>Havi összes megrendelt koszorú:</td>
				<td><?php echo $soldwreatitem_month_db; ?> db</td>
			</tr>
		</table>
	</div>
<?php } ?>
