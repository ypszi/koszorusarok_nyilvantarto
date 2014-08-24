<?php

	include '../../../config.php';

	$id = $_POST['id'];
	$query_del = "
		DELETE FROM `ingredient`
		WHERE `id`=$id";

	mysql_query($query_del) or die (mysql_error());
?>