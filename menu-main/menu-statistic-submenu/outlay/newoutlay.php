<?php
	include '../../../config.php';

	$date = $_POST['date'];
	$type = $_POST['type'];
	$price = $_POST['price'];
	$note = $_POST['note'];


	$query_types = "SELECT * FROM outlay_type";
	$result_types = mysql_query($query_types) or die(mysql_error());
	while ($row_types = mysql_fetch_assoc($result_types)) {
		if ($row_types["type"] == $type) {
			$type = $row_types["id"];
		}
	}

	$query_ins = "INSERT INTO `outlay` (`date`, `type`, `price`, `note`, `archive`) VALUES ('$date','$type','$price','$note', 0)";
	mysql_query($query_ins) or die(mysql_error());
/*
	$query = "SELECT * FROM `outlay`";
	$result = mysql_query($query) or die(mysql_error());
	
	echo '<table id="outlay">
			<tr>
				<th>Dátum</th>
				<th>Típus</th>
				<th>Végösszeg</th>
				<th>Megjegyzés</th>
			</tr>';
		$id = 0;
		while ($row = mysql_fetch_assoc($result)) {

		echo '<tr id="outlay'.$id.'">
			<form id="outlayform'.$id.'" method="POST" action="">'; 
				echo "<td class = 'acquisitionDate'> " . $row["date"] . "</td>";
				echo "<td class = 'acquisitionType'> " . $row["type"] . "</td>";
				echo "<td class = 'acquisitionPrice'> " . number_format($row["price"], 0, ',', ' ') . " ft</td>";
				echo "<td class = 'acquisitionNote'> " . $row["note"] . "</td>";
				echo "<td class = 'acquisitionDel' id='delbutton$id'> <input type='button' onClick='delOutlay($id, " . $row["id"] . ");' value='Töröl' class='button' ></td>";
			echo "</form>";
			echo "</tr>";
			$id++;
		}	
	echo '</table>';*/
?>