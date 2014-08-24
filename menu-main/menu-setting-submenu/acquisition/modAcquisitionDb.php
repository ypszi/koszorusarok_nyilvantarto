<?php
	include '../../../config.php';

	$acquisitionid = $_POST['setAcquisitionid'];
    $type = $_POST['setType'];
	
	$query="UPDATE acquisition_type
			SET type='$type'
			WHERE id=" . $acquisitionid . ";";
	mysql_query($query) or die (mysql_error());
?>