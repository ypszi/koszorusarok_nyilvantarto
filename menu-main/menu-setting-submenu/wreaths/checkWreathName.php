<?php
	include '../../../config.php';

	$is_wreath = "SELECT base_wreath_id, name FROM special_wreath WHERE name = '".$_POST['wreath_name']."' LIMIT 0,1";
	$result_iswreath = mysql_query($is_wreath) or die(mysql_error());

	if (mysql_num_rows($result_iswreath) != 0) {
		while ($row = mysql_fetch_assoc($result_iswreath)) {
			$base_wreath_id = $row['base_wreath_id'];
		}
		$query = "SELECT type FROM base_wreath_type WHERE id = ( SELECT type FROM base_wreath WHERE id = $base_wreath_id )";
		$result = mysql_query($query) or die(mysql_error());
		while ($row = mysql_fetch_assoc($result)) {
			$base_wreath_type = $row['type'];
		}

		echo "Ilyen nevű koszorú már létezik.<br>Kategória: $base_wreath_type";
	}