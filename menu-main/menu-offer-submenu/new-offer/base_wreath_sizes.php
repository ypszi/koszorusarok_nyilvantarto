<?php 
	include "../../../config.php";
?>
<option disabled value="" selected>Válasszon koszorú méretet!</option>
<?php
	$query = "SELECT size FROM `base_wreath` WHERE TYPE = ( SELECT id FROM `base_wreath_type` WHERE TYPE = \"".$_GET['base_wreath_type']."\" );";
	$result = mysql_query($query) or die (mysql_error());

	while ($row = mysql_fetch_assoc($result)) {
		$base_wreath_size=$row['size'];

		echo "<option value=\"$base_wreath_size\" >";
		echo $base_wreath_size;
		$query = "SELECT flower_min FROM  `base_wreath` WHERE size=\"".$row['size']."\"";
		$resultmin = mysql_query($query) or die (mysql_error());

		while ($rowmin = mysql_fetch_assoc($resultmin)) {
			$size = $rowmin['flower_min'];
			echo " ($size";
		}
		
		echo " - ";

		$query = "SELECT flower_max FROM  `base_wreath` WHERE size=\"".$row['size']."\"";
		$resultmax = mysql_query($query) or die (mysql_error());

		while ($rowmax = mysql_fetch_assoc($resultmax)) {
			$size = $rowmax['flower_max'];
			echo "$size)";
		}

		echo "</option>";
	}
?>