<?php
	include '../../../config.php';

	$type_id = $_POST['group'];
    $ingredient = $_POST['ingredient'];
	$income_price = $_POST['price'];
	$sell_price = $_POST['sell_price'];
	$note = $_POST['note'];
	$query_ins = "INSERT INTO `ingredient` (`type_id`, `ingredient`, `income_price`, `sale_price`, `note`) VALUES ('$type_id','$ingredient','$income_price','$sell_price', '$note')";
	mysql_query($query_ins) or die(mysql_error());

?>

	<table id = "contact">
		<tr>
			<th>Csoport</th>
			<th>Kellék</th>
			<th>Beszerzési ár</th>
			<th>Eladási ár</th>
			<th>Eladási ár</th>
			<th>Megjegyzés</th>
		</tr>
<?php


$query="SELECT id,type
		FROM ingredient_type
		WHERE archive=0
		ORDER BY type ASC;";
$result = mysql_query($query) or die (mysql_error());

while ($row = mysql_fetch_assoc($result)) {
	$ingredient_type[$row["id"]] = $row["type"]; 
}

$query="SELECT id, type_id, ingredient, income_price, sale_price, note
		FROM ingredient ORDER BY type_id ASC, ingredient ASC;";

$result = mysql_query($query) or die (mysql_error());

$id = 0;

while ($row = mysql_fetch_assoc($result)) {

	echo "
	<tr id='contact".$id."'>
		<td class = 'ingredient_type'>" . $ingredient_type[$row["type_id"]] . "</td>
		<td class = 'contactActivity'>" . $row["ingredient"] . "</td>
		<td class = 'contactActivity'>" . $row["income_price"] . "</td>
		<td class = 'contactActivity'>" . $row["sale_price"] . "</td>
		<td class = 'contactNote'>" . $row["note"] . "</td>
		<td class = 'contactDel' id='delbutton" . $id . "'><input type='button' onClick='delContact(" . $row["id"] . ");' value='Töröl' class='button' ></td>
	</tr>

	";

	$id++;

}	

?>

<div id="newContact" style="z-index: 6; overflow-x: hidden;">

</div>

</table>