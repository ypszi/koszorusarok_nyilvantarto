<?php
	include '../../../config.php';

	$id = $_POST['id'];
	$group = $_POST['group'];
    $ingredient = $_POST['ingredient'];
	$price = $_POST['price'];
	$sell_price = $_POST['sell_price'];
	$note = $_POST['note'];
	
	echo $query="UPDATE ingredient
			SET type_id='$group', ingredient='$ingredient', income_price='$price', sale_price='$sell_price', note='$note'
			WHERE id=$id;";
	mysql_query($query) or die (mysql_error());
?>