	<!-- ---------------------------- Datepicker ---------------------------- -->
	<link rel="stylesheet" href="css/calendar/default.css" type="text/css">
	<script type="text/javascript" src="js/zebra_datepicker.js"></script>
	<script type="text/javascript" src="js/zebra_datepicker.src.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$('input.datepicker').Zebra_DatePicker();
		});
	</script>

	<link href="css/style.css" rel="stylesheet" type="text/css" media="all"/>
	<link href="css/alertwindow.css" rel="stylesheet" type="text/css" media="all">
		
<style type="text/css">
	.print a{
		background: url(../img/btn-bg1.png) repeat-x 0 0px;
		padding: 5px;
		color: #fff;
		border: 0px;
		width: 85px;
		right: 12px;
		margin-top: 5px;
		height: 22px;
		border-style: outset;
		cursor: pointer;
		text-decoration: none;
		text-transform: none;
	}

	.print a:hover{
		background: url(../img/btn-bg2.png) repeat-x 0 0px;
		padding: 5px;
		color: #fff;
		border: 0px;
		width: 85px;
		right: 12px;
		margin-top: 5px;
		height: 22px;
		border-style: outset;
		cursor: pointer;
		text-decoration: none;
		text-transform: none;
	}

	#newShopping_list {
		overflow-y: auto;
		height: 87%;
		position: absolute;
		width: 720px;
		left: 23%;
		top: 5%;
	}

	#shopping_list th {
		padding: 5px;
	}

	.exit {
		right: 0px;
		top: 0px;
	}
	
</style>

<body>
	<div class="title">
		<span class="firstWord">Rendelés </span> Keresése	
		<div>
			<form id = "selectForm" method="GET" action="http://nyilvantarto.koszorusarok.hu/?page=rendeles&subpage=keres">
				<table id = "selectFormTable">
					<tr>
		<?php
						$bd = date("Y-m-d");
							
						$beginDate = isset($_GET['min_date']) ? $_GET['min_date'] : date("Y-m-01",strtotime($bd)-(14*24*3600));
						$endDate = isset($_GET['max_date']) ? $_GET['max_date'] : date("Y-m-d",strtotime($bd)+(0*24*3600));
				
				echo   '<td><input type="text" name="searchOrderId" id="searchOrderId" class="searchContact borderedStyle" value="" placeholder="Rendelés Azonosító"></td>
						<td><input type="text" name="searchDeadName" id="searchDeadName" class="searchContact borderedStyle" value="" placeholder="Elhunyt neve"></td>
						<td><input type="text" name="searchOrderName" id="searchOrderName" class="searchContact borderedStyle" value="" placeholder="Rendelő neve"></td>
						<td><CENTER><input type="text" name="min_date" id="min_date" class="datepicker borderedStyle" value="' . $beginDate . '"></CENTER></td>
						<td><CENTER> - </CENTER></td>
						<td><CENTER><input type="text" name="max_date" id="max_date" class="datepicker borderedStyle" value="' . $endDate . '"></CENTER></td>';
		?>
						<td>
							<input type="hidden" name="page" value="rendeles">
							<input type="hidden" name="subpage" value="keres">
							<button type="submit" class="button" id="filter">Keres</button>
						</td>
					</tr>
				</table>
			</form>
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
			WHERE ARCHIVE = 0 
				AND orders.ritual_time>='".$beginDate."' AND orders.ritual_time<='".$endDate."' 
				AND orders.deadname LIKE '%".$_GET["searchDeadName"]."%'
				AND orders.customer_name LIKE '%".$_GET["searchOrderName"]."%'
				AND orders.id IN (SELECT order_id FROM `order_items` WHERE `azonosito` LIKE '%".$_GET["searchOrderId"]."%')
			ORDER BY create_time DESC";
		
//	echo $query;

	$result = mysql_query($query) or die (mysql_error());

	echo "<h3>Szertatár időpontja illetve töredék információk alapján keres a rendszer!</h3><br />";

	echo "<table class='employees'>";
		echo '<tr>
				<th style="width:20px;">#</th>
				<th style="width:60px;">Sorszám</th>
				<th style="width:120px;">&#8224; Elhunyt</th>
				<th style="width:90px;">Szertartás ideje</th>
				<th style="width:120px;">Megrendelő</th>
				<th style="width:70px;">Ár</th>
				<th style="width:70px;">Előleg</th>
				<th style="width:70px;">Felvétel ideje</th>
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


	</div>