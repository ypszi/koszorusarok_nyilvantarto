<?php
	include '../../../config.php';

	$cemeteryid = $_POST['cemeteryid'];

	$query_del = "DELETE FROM `cemetery` WHERE `id`=$cemeteryid";
	$result_del = mysql_query($query_del) or die (mysql_error());

?>