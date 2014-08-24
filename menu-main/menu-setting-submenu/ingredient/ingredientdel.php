<?php
	include '../../../config.php';

	$ingredientid = $_POST['ingredientid'];

	$query_del = "
		UPDATE `ingredient_type`
		SET archive = 1
		WHERE `id`=$ingredientid";
	$result_del = mysql_query($query_del) or die (mysql_error());

?>