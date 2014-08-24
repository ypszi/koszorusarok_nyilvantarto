<?php 
	include '/config.php';
?>
<link href="css/style.css" rel="stylesheet" type="text/css" media="all"/>
<div class="title">
	<span class="firstWord">Rögzített </span> Ajánlatok
</div>
<?php
	$query = "SELECT * FROM  `offer_wreath` ORDER BY up_time DESC";
	$result = mysql_query($query) or die (mysql_error());
	echo "<table class='employees'>";
	echo "<tr>	
			<th>#</th>
			<th>Név</th>
			<th>Kalkulált ár</th>
			<th>Értékesítési ár</th>
			<th>Megjegyzés</th>
			<th>Feltöltő</th>
			<th>Feltöltve</th>
		</tr>";
	$i=0;
	while ($row = mysql_fetch_assoc($result)) {
		$i++;
		$up_date =  substr($row["up_time"], 0, -9); ;
		if ($i % 2 != 0){
			$color="#e2f1cb";
		}else{
			$color="#ffffff";		
		}
		echo '<tr style="background-color:'.$color.';">
				<td>'.$i.'. </td>
				<td> <a href="'.$conf_path_abs.'?page=rendeles&subpage=ajanlat_szerkesztes&ajanlat_type='.$row["name"].' - '.$up_date.'">'.$row["name"].'</a></td>
				<td>'.number_format($row["calculate_price"], 0, ',', ' ').' Ft</td>
				<td>'.number_format($row["sale_price"], 0, ',', ' ').' Ft</td>
				<td>'.$row["note"].'</td>
				<td>'.$row["uploader"].'</td>
				<td>'.$row["up_time"].'</td>
			</tr>';
	}
	echo "</table>";
?>