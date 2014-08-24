<?php
	include '../../config.php';

	session_start();
	$sender = $_SESSION['logged_in'];
	$recipient = $_POST['recipient'];
	$message = $_POST['message'];

	if(isset($_POST['recipient'])) {
		if(is_array($_POST['recipient'])) {
			foreach ($_POST['recipient'] as $recipient) {
					$query = "SELECT id FROM users WHERE name = '" . $recipient . "'";
					$res = mysql_query($query) or die(mysql_error());
					$row = mysql_fetch_assoc($res);
					$recipient = $row["id"];

				$query_ins = "INSERT INTO `message` (`sender`, `recipient`, `message`, `created`, `archiveRecipient`, `archiveSender`) VALUES ('$sender','$recipient','$message',NOW(), 0, 0)";
				mysql_query($query_ins) or die(mysql_error());
			}
		}
	}
?>