<?php
	include '../../../config.php';

	$userid = $_POST['userid'];

	$query_del = "DELETE FROM `users` WHERE `id`=$userid";
	$result_del = mysql_query($query_del) or die (mysql_error());

?>