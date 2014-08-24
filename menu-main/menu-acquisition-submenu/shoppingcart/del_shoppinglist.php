<?php

	include '../../../config.php';

	$id = $_POST['id'];
	$query_del = "DELETE FROM `shopping_cart` WHERE `id`=$id";
	mysql_query($query_del) or die (mysql_error());

	$query_del = "DELETE FROM `shopping_cart_item` WHERE `shopping_cart_id`=$id";
	mysql_query($query_del) or die (mysql_error());
?>