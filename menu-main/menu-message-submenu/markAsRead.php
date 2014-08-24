<?php
	include '../../config.php';

	$msgID = $_POST['msgID'];

	$query_ins = "UPDATE `message` SET readed = 1 WHERE id = $msgID";
	mysql_query($query_ins) or die(mysql_error());
?>