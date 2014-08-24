<?php

	$query2 = "SELECT * FROM  `tape_title` ORDER BY id ASC";
	$result2 = mysql_query($query2) or die (mysql_error());
	while ($row = mysql_fetch_assoc($result2)) {
		$id = $row['id'];
		$tapetext = "SZ$id - ".$row['text'];
		echo "<option> $tapetext </option>";
	}
	
	$query = "SELECT * FROM  `citation`";
	$result = mysql_query($query) or die (mysql_error());
	while ($row = mysql_fetch_assoc($result)) {
		$id = $row['id'];
		$cittext = "ID$id - ".$row['text'];
		echo "<option> $cittext </option>";
	}
?>