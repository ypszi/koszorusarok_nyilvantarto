<div class="title">
	<span class="firstWord">Rögzített Rendelések</span> - Két hétnél nem régebbi rendelések 
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
	
	$OB = "create_time DESC";	
	if (isset($_GET["elhunyt"])){
//		$OB = "(deadname IS NULL) ASC, deadname ASC";
		$OB = "if(deadname = '' or deadname is null,1,0),deadname";
	}elseif (isset($_GET["megrendelo"])){
		$OB = "customer_name ASC";
	}elseif (isset($_GET["szertartas"])){
		$OB = "ritual_time DESC";
	}else{
		$OB = "create_time DESC";	
	}
	
	$query = "SELECT orders.id, orders.ritual_time, orders.deadname, orders.phone_number, orders.customer_name, orders.note, orders.price, orders.downprice, orders.create_time, orders.worker_id, orders.maker_shop
			FROM orders
			WHERE ARCHIVE = 0 AND ( DATEDIFF( orders.ritual_time, CURDATE() ) > -14 OR orders.ritual_time >= CURDATE() )
			ORDER BY " . $OB ;
		
	$result = mysql_query($query) or die (mysql_error());

	echo "<table class='employees'>";
		echo '<tr>
				<th style="width:20px;">#</th>
				<th style="width:60px;">Sorszám</th>
				<th style="width:120px;"><a href="?page=rendeles&elhunyt=asc">&#8224; Elhunyt</a></th>
				<th style="width:90px;"><a href="?page=rendeles&szertartas=desc">Szertartás ideje</a></th>
				<th style="width:120px;"><a href="?page=rendeles&megrendelo=asc">Megrendelő</a></th>
				<th style="width:70px;">Ár</th>
				<th style="width:70px;">Előleg</th>
				<th style="width:70px;"><a href="?page=rendeles&felvetel=desc">Felvétel ideje</a></th>
				<th style="width:100px;">Felvette</th>
				<th style="width:70px;">Készítő Bolt</th>
				<th style="width:36px;"></th>
				<th style="width:36px;"></th>';
				if ($_SESSION['logged_in'] == 1 || $_SESSION['logged_in'] == 2 || $_SESSION['logged_in'] == 3) {
					echo '<th style="width:36px;"></th>';
				}
		echo '</tr>';
	$i=1;
	while ($row = mysql_fetch_assoc($result)) {
		if ($i % 2 != 0){
			$color="#e2f1cb";
		}else{
			$color="#ffffff";		
		}

		echo '<tr style="background-color:'.$color.';">
				<td>'.$i.'. </td>';


				$query_id = 'SELECT azonosito
						FROM order_items
						WHERE order_id = '. $row["id"] .' LIMIT 1';

				$result_id = mysql_query($query_id) or die (mysql_error());

				while ($row_id = mysql_fetch_assoc($result_id)) {
					echo'<td><a href="'.$conf_path_abs.'?page=rendeles&subpage=megrendeles&id='.$row["id"].'">#' . substr($row_id["azonosito"],0,6) . '</a></td>';
				}

				if (isset($row["deadname"]) && $row["deadname"]!=""){
					echo'<td>&#8224; '.$row["deadname"].'</td>';
				}else{
					echo '<td>&#8224; ...</td>';
				}
		echo'		<td>'.date("M. d. - H:i",strtotime($row["ritual_time"])).'</td>
				<td>'.$row["customer_name"].'</td>
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
				</td>';
				if ($_SESSION['logged_in'] == 1 || $_SESSION['logged_in'] == 2 || $_SESSION['logged_in'] == 3){
					echo '<td >
						<a href="'.$conf_path_abs.'?page=rendeles&subpage=archivalas&order_id='.$row["id"].'" style="background-image:url(http://www.nyilvantarto.koszorusarok.hu/img/icons/Delete-icon.png); background-repeat:no-repeat; width:32px; height: 32px;" class="button" onclick="return confirm(\'Biztos archiválja a rendelést?\')" ></a>					
					</td>';
				}

			echo '</tr>';
			$i++;
	}
	echo "</table>";
?>