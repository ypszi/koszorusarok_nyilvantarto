<?php
	include '../../../config.php';

	$acquisitionid = $_POST['id'];

	$query_del = "
		UPDATE `acquisition`
		SET archive = 1
		WHERE `id`=$acquisitionid";
	$result_del = mysql_query($query_del) or die (mysql_error());
?>