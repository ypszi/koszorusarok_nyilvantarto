<?php
	include '../../../config.php';

	$ingredientid = $_POST['setIngredientid'];
    $type = $_POST['setType'];
	
	$query="UPDATE ingredient_type
			SET type='$type'
			WHERE id=" . $ingredientid . ";";
	mysql_query($query) or die (mysql_error());
?>