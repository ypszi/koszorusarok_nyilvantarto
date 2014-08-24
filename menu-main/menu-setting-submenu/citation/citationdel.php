<?php
	include '../../../config.php';

	$citid = $_POST['citid'];

	$query_del = "DELETE FROM `citation` WHERE `id`=$citid";
	$result_del = mysql_query($query_del) or die (mysql_error());

?>