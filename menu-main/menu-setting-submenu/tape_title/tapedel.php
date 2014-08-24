<?php
	include '../../../config.php';

	$tapeid = $_POST['tapeid'];

	$query_del = "DELETE FROM `tape_title` WHERE `id`=$tapeid";
	$result_del = mysql_query($query_del) or die (mysql_error());

?>