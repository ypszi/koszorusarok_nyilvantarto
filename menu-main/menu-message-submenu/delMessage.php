<?php
	include '../../config.php';

	$messageid = $_POST['msgID'];

	if ($_POST['msgSide'] == "recipient") {
		$query_del = "
					UPDATE `message`
					SET archiveRecipient = 1
					WHERE `id`=$messageid";
	}
	else {
		$query_del = "
					UPDATE `message`
					SET archiveSender = 1
					WHERE `id`=$messageid";
	}

	$result_del = mysql_query($query_del) or die (mysql_error());
?>