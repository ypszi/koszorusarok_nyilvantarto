<?php
	include '../../../config.php';

	$outlayid = $_POST['setOutlayid'];
    $type = $_POST['setType'];
	
	$query="UPDATE outlay_type
			SET type='$type'
			WHERE id=" . $outlayid . ";";
	mysql_query($query) or die (mysql_error());
?>