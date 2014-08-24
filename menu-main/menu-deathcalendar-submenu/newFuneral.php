<?php
	include '../../config.php';

	$name = $_POST['setName'];
	$funeral_date = $_POST['setFuneralDate'];
	$funeral_time = $_POST['setFuneralTime'];
	$note = $_POST['setNote'];

	$query_ins = "INSERT INTO `death_calendar` (`name`, `funeral_date`, `note`, `archive`) VALUES ('$name','$funeral_date " . $funeral_time . "','$note', 0)";
	mysql_query($query_ins) or die(mysql_error());

?>