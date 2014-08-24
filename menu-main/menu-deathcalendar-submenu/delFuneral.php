<?php
	include '../../config.php';

	$funeralid = $_POST['funeralid'];

	$query_del = "
		UPDATE `death_calendar`
		SET archive = 1
		WHERE `id`=$funeralid";
	$result_del = mysql_query($query_del) or die (mysql_error());

?>