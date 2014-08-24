<?php
	include '../../config.php';

	$name = $_POST['setName'];
	$funeral_date = $_POST['setFuneralDate'];
	$note = $_POST['setNote'];
	
	$query="UPDATE death_calendar
			SET name='$name', funeral_date='$funeral_date', note='$note'
			WHERE id=" . $_POST["funeralid"] . ";";
			mysql_query($query) or die (mysql_error());
?>