<?php
	include '../../../config.php';

	$type = $_POST['type'];

	$query_types = "SELECT * FROM ingredient_type";
	$result_types = mysql_query($query_types) or die(mysql_error());
	while ($row_types = mysql_fetch_assoc($result_types)) {
		if ($row_types["type"] == $type) {
			$type = $row_types["id"];
		}
	}

	$query_ins = "INSERT INTO `ingredient_type` (`type`, `archive`) VALUES ('$type', 0)";
	mysql_query($query_ins) or die(mysql_error());
?>