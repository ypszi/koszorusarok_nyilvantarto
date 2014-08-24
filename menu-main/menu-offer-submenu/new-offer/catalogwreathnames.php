<?php include '../../../config.php'; ?>
	<option disabled value="" selected>Válasszon koszorút!</option>
	<?php 

		$catalogwreathnames=$_GET['catalogwreathnames'];
		$query = "SELECT special_wreath.id, special_wreath.name
					FROM `special_wreath`, `base_wreath` 
					WHERE special_wreath.base_wreath_id = base_wreath.id
					AND base_wreath.type = (SELECT `id` FROM `base_wreath_type` WHERE `type`='$catalogwreathnames')
					ORDER BY special_wreath.name ASC";
		$result = mysql_query($query) or die (mysql_error());

		while ($row = mysql_fetch_assoc($result)) {
			$base_wreath_name = $row['name'];
			echo "<option value=\"$base_wreath_name\" >$base_wreath_name</option>";
		}
	?>