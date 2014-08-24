<?php
	include '../../config.php';

	$name = $_POST['setName'];
    $phone = $_POST['setPhone'];
	$activity = $_POST['setActivity'];
	$note = $_POST['setNote'];
	
	$query="UPDATE phonebook
			SET name='$name', phone_number='$phone', activity='$activity', note='$note'
			WHERE id=" . $_POST["contactid"] . ";";
			mysql_query($query) or die (mysql_error());
?>