<link href="css/style.css" rel="stylesheet" type="text/css" media="all"/>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.0/jquery-ui.min.js"></script>

<script>
$(document).ready(function(){
	$("#delete_offer").on("click", function(){
		if (confirm("Biztos törlöd?")) {
			/*alert("ASD");*/
			offers_to_print = $('input:checkbox:checked').map(function(){
				return this.value;
			}).get();
			$.ajax({
				type: "POST",
				url: "menu-main/menu-offer-submenu/delete_offers.php",
				data: {offers_to_print: offers_to_print},
				success: function(data){
					location.reload();
				}
			});
		}
	});
});
</script>

<?php 
	include '/config.php';
?>

<div class="title">
	<span class="firstWord">Rendelésből származó</span> Ajánlatok
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

	$query = "SELECT * 
				FROM  offer_wreath 
				WHERE archive = 0 AND is_order = 1 AND ( DATEDIFF( up_time, CURDATE() ) > -31)
				ORDER BY up_time DESC;";
	$result = mysql_query($query) or die (mysql_error());
	echo "<form method='POST' action='".$conf_path_abs."menu-main/menu-offer-submenu/get-offers.php' target='_blank'> ";
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
				<td>'.$i.'. <input type="checkbox" style="margin: 3px 0px 3px 0px;" class="print_offer" name="offers_to_print[]" value="'.$row["id"].'"></td>
				<td> <a href="'.$conf_path_abs.'?page=ajanlatok&subpage=ajanlat_szerkesztes&ajanlat_type='.$row["name"].' - '.$up_date.'">'.$row["name"].'</a></td>
				<td>'.number_format($row["calculate_price"], 0, ',', ' ').' Ft</td>
				<td>'.number_format($row["sale_price"], 0, ',', ' ').' Ft</td>
				<td>'.$row["note"].'</td>
				<td>'.$user[$row["uploader"]].'</td>
				<td>'.$row["up_time"].'</td>				
			</tr>';
	}
	echo "</table>";

	echo '<div style="position: fixed; top: 200px; right: 0%; width: 66px; background-color: #c0d4a1; color: #fff; padding: 5px; box-shadow: #999 0px 0px 10px 3px;">
				<div class="button">
					<input type="submit" name="print_offer" value="" style="background-image:url('.$conf_path_abs.'img/icons/BigPrint-icon.png); background-repeat:no-repeat; width:64px; height:64px; vertical-align: middle; padding-bottom:10px;"  id="print_offer" title="nyomtatás">
					<div style="font-weight:bold; color: #304a63; text-align: center;">Nyomtatás</div>
				</div>
				<div sytle="padding-top:5px;">
					<input type="button" name="delete_offer" value="" style="background-image:url('.$conf_path_abs.'img/icons/BigDelete-icon.png); background-repeat:no-repeat; width:64px; height:64px; vertical-align: middle;" id="delete_offer" title="törlés">
					<div style="font-weight:bold; color: #304a63; text-align: center;">Törlés</div>
				</div>
		</div>';

	echo "</form>";
?>

