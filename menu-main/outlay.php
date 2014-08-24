<head>
	<!-- ---------------------------- Datepicker ---------------------------- -->
	<link rel="stylesheet" href="css/calendar/default.css" type="text/css">
	<script type="text/javascript" src="js/timepicker/include/jquery-1.9.0.min.js"></script>
	<script type="text/javascript" src="js/zebra_datepicker.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
		  $('input.datepicker').Zebra_DatePicker();
			$('#min_date').Zebra_DatePicker();
			$('#max_date').Zebra_DatePicker();
		});
	</script>
</head>
<body>
<div class="title">
	<span class="firstWord">Költség </span> Adatok
	
<?php 
	echo '<div>';
	
		$query="SELECT id,type
				FROM outlay_type 
				ORDER BY type ASC;";
		$result = mysql_query($query) or die (mysql_error());
		
		echo '<form action="">';

		while ($row = mysql_fetch_assoc($result)) {
			echo '<span style="margin: 5px;"><input type="checkbox" name="vehicle" value="' . $row["id"] . '"/>' . $row["type"] . '</span>';
		}
		echo '<input type="text" name="min_date" id="min_date" value="2012-08-10">
				<input type="text" name="max_date" id="max_date" value="2012-08-11">
				<button type="button">Szűrés</button>
				<button type="button">Új költség rögzítése</button>
			</form>
		</div>';

?>	
	
	
<?php 
	$query="SELECT outlay_type.type, outlay.date, outlay.price, outlay.note 
			FROM outlay, outlay_type 
			WHERE outlay.type = outlay_type.id 
			ORDER BY date ASC;";
	$result = mysql_query($query) or die (mysql_error());
	echo '<table id="salary">
			<tr>
				<th>Dátum</th>
				<th>Típus</th>
				<th>Végösszeg</th>
				<th>Megjegyzés</th>
			</tr>';

		while ($row = mysql_fetch_assoc($result)) {
			echo '<tr>
					<td>' . $row["date"] . '</td>
					<td>' . $row["type"] . '</td>
					<td>' . number_format($row["price"], 0, ',', ' ') .' ft </td>
					<td>' . $row["note"] . '</td>
				</tr>';
		}	
	echo '</table>';
?>

</div>
</body>