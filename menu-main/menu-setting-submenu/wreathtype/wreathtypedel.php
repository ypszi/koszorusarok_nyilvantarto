<?php
	include '../../../config.php';

	$wreathbid = $_POST['wreathbid'];

	$query_del = "DELETE FROM `base_wreath` WHERE `id`=$wreathbid";
	$result_del = mysql_query($query_del) or die (mysql_error());

?>