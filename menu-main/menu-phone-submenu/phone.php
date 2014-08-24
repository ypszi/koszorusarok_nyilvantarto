<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>

<script>
	// $(document).ready(function(){

		function delContact(id, contactid) {
			if(confirm('Biztosan törli?')) {
				$.ajax({
					type: "POST",
					url: "menu-main/menu-phone-submenu/delContact.php",
					data: { contactid: contactid},
					success: function(data){
					$("#contact"+id).html(data);
					}
				});
			}
		}
		function newContact() {
			$.ajax({
				type: "GET",
				url: "menu-main/menu-phone-submenu/addContact.php",
				success: function(data){
					$('#newContact').html(data);
					$('#newContact').toggle();
				}
			});
		}
		function modContact(id, contactid) {
			contactName = $("#contact"+ id + " .contactName").text();
			contactNumber = $("#contact"+ id + " .contactNumber").text();
			contactActivity = $("#contact"+ id + " .contactActivity").text();
			contactNote = $("#contact"+ id + " .contactNote").text();

			$.ajax({
				type: "GET",
				url: "menu-main/menu-phone-submenu/modContact.php",
				data: {
					contactid: contactid,
					contactName: contactName,
					contactNumber: contactNumber,
					contactActivity: contactActivity,
					contactNote: contactNote,
					id: contactid
				},
				success: function(data){
					$('#newContact').html(data);
					$('#newContact').toggle();
				}
			});
		}
		function searchContact() {
			$.ajax({
				type: "GET",
				url: "menu-main/menu-phone-submenu/addContact.php",
				success: function(data){
					$('#newContact').html(data);
					$('#newContact').toggle();
				}
			});
		}
	// });
</script>

<div  id="content" style="padding: 10px; background-color: #fff;">

<div class="title">
	<span class="firstWord">Rögzített</span> Telefonszámok
</div>

<form id = "selectForm" method="GET">
	<table id = "selectForm_Table">
		<tr>
			<td><input type="text" name="searchContactByName" id="searchContactByName" class="searchContact borderedStyle" value="" placeholder = "Név szerinti keresés"></td>
			<td><input type="text" name="searchContactByJob" id="searchContactByJob" class="searchContact borderedStyle" value="" placeholder = "Munkakör szerinti keresés"></td>
			<td><button type="submit" class = "button" id = "filter">Keresés</button></td>
			<td><button class = "button" type="button" id = "newButton" onClick="newContact();">Új kontakt</button></td>
			<input type="hidden" name="page" value="telefon">
			<input type="hidden" name="subpage" value="telefon">
		</tr>
	</table>
</form>

<table id = "contact">
	<tr>
		<th>Név</th>
		<th>Telefonszám</th>
		<th>Foglalkozási kör</th>
		<th>Megjegyzés</th>
	</tr>

<?php
if(isset($_GET['searchContactByName'])) {
	if($_GET['searchContactByName'] != "") {
		$searchContactByName = " AND name LIKE '%" .$_GET['searchContactByName']. "%'";
	}
	else $searchContactByName = "";
}
else {
	$searchContactByName = "";
}
if(isset($_GET['searchContactByJob'])) {
	if($_GET['searchContactByJob'] != "") {
		$searchContactByJob = " AND activity LIKE '%" .$_GET['searchContactByJob']. "%'";
	}
	else $searchContactByJob = "";
}
else {
	$searchContactByJob = "";
}

// $searchContactByName = isset($_GET['searchContactByName']) ? $_GET['searchContactByName'] : "";
// $searchContactByJob = isset($_GET['searchContactByJob']) ? $_GET['searchContactByJob'] : "";

$query="SELECT id, name, phone_number, activity, note, archive
		FROM phonebook
		WHERE archive = 0" . $searchContactByName . $searchContactByJob . " ORDER BY name ASC;";

// echo $query;

$result = mysql_query($query) or die (mysql_error());

$id = 0;

while ($row = mysql_fetch_assoc($result)) {
	echo "
	<tr id='contact".$id."'>
		<td class = 'contactName'>" . $row["name"] . "</td>
		<td class = 'contactNumber'>" . $row["phone_number"] . "</td>
		<td class = 'contactActivity'>" . $row["activity"] . "</td>
		<td class = 'contactNote'>" . $row["note"] . "</td>
		<td class = 'contactMod' id='modbutton" . $id . "'><input type='button' onClick='modContact(" . $id . "," . $row["id"] . ");' value='Módosítás' class='button' ></td>
		<td class = 'contactDel' id='delbutton" . $id . "'><input type='button' onClick='delContact(" . $id . "," . $row["id"] . ");' value='Töröl' class='button' ></td>
	</tr>
	";
	$id++;
}	
?>
<div id="newContact" style="z-index: 6; overflow-x: hidden;">
</div>
</table>
</div>


