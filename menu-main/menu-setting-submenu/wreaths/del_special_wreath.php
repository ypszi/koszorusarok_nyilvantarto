<?php
	include '../../../config.php';

	$id = $_POST['id'];

	$query_del = "DELETE FROM `special_wreath` WHERE `id`=$id";
	mysql_query($query_del) or die (mysql_error());

	$query_del = "DELETE FROM `conect_flower_special_wreath` WHERE `special_wreath_id`=$id";
	mysql_query($query_del) or die (mysql_error());

	$query_del = "DELETE FROM `special_wreath_img` WHERE `special_wreath_id`=$id";
	mysql_query($query_del) or die (mysql_error());