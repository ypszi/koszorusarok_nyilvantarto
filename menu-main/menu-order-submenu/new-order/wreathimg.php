<?php 
	include '../../../config.php';
	$wreath_name = $_GET['wreath_name'];
	$query = "SELECT picture FROM `special_wreath` WHERE name='$wreath_name'";
	$result = mysql_query($query) or die(mysql_error());
	while ($row = mysql_fetch_assoc($result)) {
		$pic = explode("|", $row["picture"]);
		echo $conf_path_abs."img/wreath/".$pic[0];
	}
?>