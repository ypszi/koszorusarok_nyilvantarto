<?php
	include "../../../config.php";
?>
<option disabled value="" selected>Válasszon virág színt!</option>
<?php
	$query = "SELECT color FROM `flower` WHERE type = \"".$_GET['flowertype']."\";";
	$result = mysql_query($query) or die (mysql_error());

	while ($row = mysql_fetch_assoc($result)) {
		$flowercolor = ($row['color']=="-")?"Ennek a virágnak nem választható szín":$row['color'];
		echo "<option value=\"$flowercolor\">$flowercolor</option>";
	}
?>