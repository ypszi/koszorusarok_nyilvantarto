<?php
	include '../../config.php';

	$name = $_POST['setName'];
	$funeral_date = $_POST['setFuneralDate'];
	$note = $_POST['setNote'];

	$query_ins = "INSERT INTO `death_calendar` (`name`, `funeral_date`, `note`, `archive`) VALUES ('$name','$funeral_date','$note', 0)";
	mysql_query($query_ins) or die(mysql_error());

?>
	<table id = "funeral">
		<tr>
			<th>Név</th>
			<th>Temetés dátuma</th>
			<th>Megjegyzés</th>
		</tr>
<?php
	
/*$query="SELECT id, name, funeral_date, note, archive
		FROM death_calendar
		WHERE archive = 0 ORDER BY funeral_date ASC;";

$result = mysql_query($query) or die (mysql_error());

$id = 0;

while ($row = mysql_fetch_assoc($result)) {
	echo "
	<tr id='funeral".$id."'>
		<td class = 'funeralName'>" . $row["name"] . "</td>
		<td class = 'funeralActivity'>" . $row["funeral_date"] . "</td>
		<td class = 'funeralNote'>" . $row["note"] . "</td>
		<td class = 'funeralDel' id='delbutton" . $id . "'><input type='button' onClick='delFuneral(" . $id . "," . $row["id"] . ");' value='Töröl' class='button' ></td>
	</tr>
	";
	$id++;
}*/
	
?>
<div id="newFuneral" style="z-index: 6; overflow-x: hidden;">
</div>
</table>