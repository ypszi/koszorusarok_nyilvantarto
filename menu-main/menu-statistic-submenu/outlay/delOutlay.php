<?php
	include '../../../config.php';

	$outlayid = $_POST['id'];

	$query_del = "
		UPDATE `outlay`
		SET archive = 1
		WHERE `id`=$outlayid";
	$result_del = mysql_query($query_del) or die (mysql_error());

?>