<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>

<script>
	// $(document).ready(function(){

		function delFuneral(id, funeralid) {
			if(confirm('Biztosan törli?')) {
				$.ajax({
					type: "POST",
					url: "menu-main/menu-deathcalendar-submenu/delFuneral.php",
					data: { funeralid: funeralid},
					success: function(data){
					$("#funeral"+id).html(data);
					}
				});
			}
		}
		function newFuneral() {
			$.ajax({
				type: "GET",
				url: "menu-main/menu-deathcalendar-submenu/addFuneral.php",
				success: function(data){
					$('#newFuneral').html(data);
					$('#newFuneral').toggle();
				}
			});
		}
		function modFuneral(id, funeralid) {
			funeralName = $("#funeral"+ id + " .funeralName").text();
			funeralDate = $("#funeral"+ id + " .funeralDate").text();
			funeralNote = $("#funeral"+ id + " .funeralNote").text();

			$.ajax({
				type: "GET",
				url: "menu-main/menu-deathcalendar-submenu/modFuneral.php",
				data: {
					funeralid: funeralid,
					funeralName: funeralName,
					funeralDate: funeralDate,
					funeralNote: funeralNote,
					id: funeralid
				},
				success: function(data){
					$('#newFuneral').html(data);
					$('#newFuneral').toggle();
				}
			});
		}
		function searchFuneral() {
			$.ajax({
				type: "GET",
				url: "menu-main/menu-deathcalendar-submenu/addFuneral.php",
				success: function(data){
					$('#newFuneral').html(data);
					$('#newFuneral').toggle();
				}
			});
		}
	// });
</script>

<div  id="content" style="padding: 10px; background-color: #fff;">

<div class="title">
	<span class="firstWord">Rögzített Temetések</span> - Két hétnél nem régebbi temetések
</div>


<button class = "button newFuneralButton" type="button" id = "newButton" onClick="newFuneral();">Temetés rögzítése</button>


<table id = "funeral">
	<tr>
		<th>Név</th>
		<th>Temetés dátuma</th>
		<th>Megjegyzés</th>
	</tr>

<?php
/*if(isset($_GET['searchFuneralByName'])) {
	if($_GET['searchFuneralByName'] != "") {
		$searchFuneralByName = " AND name LIKE '%" .$_GET['searchFuneralByName']. "%'";
	}
	else $searchFuneralByName = "";
}
else {
	$searchFuneralByName = "";
}
if(isset($_GET['searchFuneralByJob'])) {
	if($_GET['searchFuneralByJob'] != "") {
		$searchFuneralByJob = " AND funeral_date LIKE '%" .$_GET['searchFuneralByJob']. "%'";
	}
	else $searchFuneralByJob = "";
}
else {
	$searchFuneralByJob = "";
}*/

// $searchFuneralByName = isset($_GET['searchFuneralByName']) ? $_GET['searchFuneralByName'] : "";
// $searchFuneralByJob = isset($_GET['searchFuneralByJob']) ? $_GET['searchFuneralByJob'] : "";

$query="SELECT id, name, funeral_date, note, archive
		FROM death_calendar
		WHERE archive = 0 AND ( DATEDIFF( funeral_date, CURDATE() ) > -14)
		ORDER BY funeral_date DESC;";
	

// echo $query;

$result = mysql_query($query) or die (mysql_error());

$id = 0;

while ($row = mysql_fetch_assoc($result)) {
	echo "
	<tr id='funeral".$id."'>
		<td class = 'funeralName'>" . $row["name"] . "</td>
		<td class = 'funeralDate'>" . $row["funeral_date"] . "</td>
		<td class = 'funeralNote'>" . $row["note"] . "</td>
		<td class = 'funeralMod' id='modbutton" . $id . "'><input type='button' onClick='modFuneral(" . $id . "," . $row["id"] . ");' value='Módosítás' class='button' ></td>
		<td class = 'funeralDel' id='delbutton" . $id . "'><input type='button' onClick='delFuneral(" . $id . "," . $row["id"] . ");' value='Töröl' class='button' ></td>
	</tr>
	";
	$id++;
}	
?>
<div id="newFuneral" style="z-index: 6; overflow-x: hidden;">
</div>
</table>
</div>


