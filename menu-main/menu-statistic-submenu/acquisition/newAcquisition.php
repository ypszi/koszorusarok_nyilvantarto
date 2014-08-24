<?php
	include '../../../config.php';

	$date = $_POST['date'];
	$type = $_POST['type'];
	$price = $_POST['price'];
	$piece = $_POST['piece'];
	$note = $_POST['note'];

	$query_types = "SELECT * FROM acquisition_type WHERE archive = 0 ORDER BY type ASC;";
	$result_types = mysql_query($query_types) or die(mysql_error());
	while ($row_types = mysql_fetch_assoc($result_types)) {
		if ($row_types["type"] == $type) {
			$type = $row_types["id"];
		}
	}

	$query_ins = "INSERT INTO `acquisition` (`date`, `type`, `price`, `piece`, `note`, `archive`) VALUES ('$date','$type','$price','$piece','$note', 0)";
	mysql_query($query_ins) or die(mysql_error());

/*	$query = "SELECT * FROM `acquisition`";
	$result = mysql_query($query) or die(mysql_error());
	
	echo '<table id="acquisition">
			<tr>
				<th>Dátum</th>
				<th>Típus</th>
				<th>Végösszeg</th>
				<th>Megjegyzés</th>
			</tr>';

	while ($row = mysql_fetch_assoc($result)) {
		echo '<tr id="acquisition' . $row["id"] . '">';
		echo "<form id='acquisitionform" . $row["id"] . "' method='POST' action=''>";
		echo "<td class = 'acquisitionDate'> <input class = 'inputStyle' type='text' value='" . $row["date"] . "' name='date' readonly></td>";
		echo "<td class = 'acquisitionType'><select name='type' disabled>
			<option disabled selected>Válasszon típust!</option>";

		$query_types = "SELECT * FROM acquisition_type ORDER BY id";
		$result_types = mysql_query($query_types) or die(mysql_error());
		while ($row_types = mysql_fetch_assoc($result_types)) {
			if ($row_types["id"] == $row["type"]) {
				echo '<option selected>' . $row_types["type"] . '</option>';
			}
			else {
				echo '<option>' . $row_types["type"] . '</option>';
			}
		}
		echo "</select></td>";

		echo "<td class = 'acquisitionPrice'> <input class = 'inputStyle' type='text' value='" . $row["price"] . "' name='price' readonly></td>";
		echo "<td class = 'acquisitionPiece'> <input class = 'inputStyle' type='text' value='" . $row["piece"] . "' name='piece' readonly></td>";
		echo "<td class = 'acquisitionNote shorterNote'> <input class = 'inputStyle shortNote' type='text' value='" . $row["note"] . "' name='note' readonly style='width: 325px;'></td>";
		echo "<td class = 'acquisitionDel' id='delbutton" . $row["id"] . "'> <input type='button' onClick='delAcquisition(" . $row["id"] . ");' value='Töröl' class='button' ></td>";

		echo "</form>";
		echo "</tr>";
	}*/
?>
<script>
</script>