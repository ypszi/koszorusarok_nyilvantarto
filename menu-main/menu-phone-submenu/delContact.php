<?php
	include '../../config.php';

	$contactid = $_POST['contactid'];

	$query_del = "
		UPDATE `phonebook`
		SET archive = 1
		WHERE `id`=$contactid";
	$result_del = mysql_query($query_del) or die (mysql_error());

?>