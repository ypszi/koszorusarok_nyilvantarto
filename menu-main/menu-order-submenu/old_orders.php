<div class="title">
	<span class="firstWord">Két hétnél régebbi </span> Rendelések - (90 napra visszamenőleg)
</div>
<?php

	$query = "SELECT id,name FROM  `users`;";
	$result = mysql_query($query) or die (mysql_error());
	while ($row = mysql_fetch_assoc($result)) {
		$user[$row["id"]]= $row["name"];
	}
	
	$query = "SELECT id,name FROM  `shops`;";
	$result = mysql_query($query) or die (mysql_error());
	while ($row = mysql_fetch_assoc($result)) {
		$shops[$row["id"]]= $row["name"];
	}

	$query = "SELECT orders.id, orders.ritual_time, orders.deadname, orders.phone_number, orders.customer_name, orders.note, orders.price, orders.downprice, orders.create_time, orders.worker_id, orders.maker_shop
			FROM orders
			WHERE ARCHIVE = 0 AND ( DATEDIFF( orders.ritual_time, CURDATE() ) < -14) AND ( DATEDIFF( orders.ritual_time, CURDATE() ) > -90)
			ORDER BY create_time DESC ";
		
	$result = mysql_query($query) or die (mysql_error());

	echo "<table class='employees'>";
		echo '<tr>
				<th style="width:20px;">#</th>
				<th style="width:120px;">&#8224; Elhunyt</th>
				<th style="width:90px;">Szertartás ideje</th>
				<th style="width:120px;">Megrendelő</th>
				<th style="width:100px;">Telefonszám</th>
				<th style="width:70px;">Ár</th>
				<th style="width:70px;">Előleg</th>
				<th style="width:70px;">Felvétel ideje</th>
				<th style="width:100px;">Felvette</th>
				<th style="width:70px;">Készítő Bolt</th>
				<th style="width:36px;"></th>
				<th style="width:36px;"></th>
			</tr>';
	$i=1;
	while ($row = mysql_fetch_assoc($result)) {
		if ($i % 2 != 0){
			$color="#e2f1cb";
		}else{
			$color="#ffffff";		
		}
		echo '<tr style="background-color:'.$color.';">
				<td>'.$i.'. </td>
				<td><a href="'.$conf_path_abs.'?page=rendeles&subpage=megrendeles&id='.$row["id"].'">&#8224; '.$row["deadname"].'</a></td>
				<td>'.date("M. d. - H:i",strtotime($row["ritual_time"])).'</td>
				<td>'.$row["customer_name"].'</td>
				<td>'.$row["phone_number"].'</td>
				<td>'.number_format($row["price"], 0, ',', ' ').' Ft</td>
				<td>'.number_format($row["downprice"], 0, ',', ' ').' Ft</td>
				<td>'.date("M. d. - H:i",strtotime($row["create_time"])).'</td>
				<td>'.$user[$row["worker_id"]].'</td>
				<td>'.$shops[$row["maker_shop"]].'</td>
				<td>
					<a href="'.$conf_path_abs.'menu-main/menu-order-submenu/get-order-pdf.php?id='.$row["id"].'"  target="_blank" style="background-image:url(http://www.nyilvantarto.koszorusarok.hu/img/icons/Print-icon.png); background-repeat:no-repeat; width:32px; height: 32px;" class="button" ></a>
				</td>
				<td>
					<a href="'.$conf_path_abs.'?page=rendeles&subpage=modositas&order_id='.$row["id"].'" style="background-image:url(http://www.nyilvantarto.koszorusarok.hu/img/icons/Edit-icon.png); background-repeat:no-repeat; width:32px; height: 32px;" class="button" ></a>
				</td>
			</tr>';
			$i++;
	}
	echo "</table>";
?>