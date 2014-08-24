<?php
	include '../../../config.php';

	$flowerid = $_POST['flowerid'];

	$query_del = "DELETE FROM `flower` WHERE `id`=$flowerid";
	$result_del = mysql_query($query_del) or die (mysql_error());

?>