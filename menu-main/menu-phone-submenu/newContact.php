<?php
	include '../../config.php';

	$name = $_POST['setName'];
    $phone = $_POST['setPhone'];
	$activity = $_POST['setActivity'];
	$note = $_POST['setNote'];

/*	$query_types = "SELECT * FROM acquisition_type";
	$result_types = mysql_query($query_types) or die(mysql_error());
	while ($row_types = mysql_fetch_assoc($result_types)) {
		if ($row_types["type"] == $type) {
			$type = $row_types["id"];
		}
	}*/
	

	$query_ins = "INSERT INTO `phonebook` (`name`, `phone_number`, `activity`, `note`, `archive`) VALUES ('$name','$phone','$activity','$note', 0)";
	mysql_query($query_ins) or die(mysql_error());


/*	$query = "SELECT * FROM `acquisition`";
	$result = mysql_query($query) or die(mysql_error());
*/
?>
	<table id = "contact">
		<tr>
			<th>Név</th>
			<th>Telefonszám</th>
			<th>Foglalkozási kör</th>
			<th>Megjegyzés</th>
		</tr>
<?php


	
$query="SELECT id, name, phone_number, activity, note, archive
		FROM phonebook
		WHERE archive = 0" /*. $type */. " ORDER BY name ASC;";

$result = mysql_query($query) or die (mysql_error());

$id = 0;

while ($row = mysql_fetch_assoc($result)) {
	echo "
	<tr id='contact".$id."'>
		<td class = 'contactName'>" . $row["name"] . "</td>
		<td class = 'contactNumber'>" . $row["phone_number"] . "</td>
		<td class = 'contactActivity'>" . $row["activity"] . "</td>
		<td class = 'contactNote'>" . $row["note"] . "</td>
		<td class = 'contactDel' id='delbutton" . $id . "'><input type='button' onClick='delContact(" . $id . "," . $row["id"] . ");' value='Töröl' class='button' ></td>
	</tr>
	";
	$id++;
}	
?>
<div id="newContact" style="z-index: 6; overflow-x: hidden;">
</div>
</table>