<?php
	include '../../../config.php';

	$shopsid = $_POST['shopsid'];
	$shopsenable = $_POST['enable'];

	$query_up = "UPDATE `shops` SET `id`=$shopsid,`enable`='$shopsenable' WHERE `id`=$shopsid";
	$result_up = mysql_query($query_up) or die (mysql_error());

	$query = "SELECT * FROM `shops` WHERE id='$shopsid';";
	$result = mysql_query($query) or die (mysql_error());
	
	while ($row = mysql_fetch_assoc($result)) {
		$shops_id = $row['id'];
		$shopsname = $row["name"];
		$shopsenabled = $row['enable'];
		echo "<form id='shopsform$shops_id' method='POST'>";
		echo "<td> <input type='text' class='inputStyle' value='$shops_id' name='shopsid' readonly style='width: 25px;'></td>";
		echo "<td> <input type='text' class='inputStyle' value='$shopsname' name='shopname' readonly></td>";
		echo "<td> <input type='text' class='inputStyle' value='$shopsenabled' name='enable' readonly></td>";
		echo "<td colspan='2'> Sikeresen módosítva! </td>";
		echo "</form>";
	}
?>