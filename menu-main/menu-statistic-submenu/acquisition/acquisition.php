<head>
	<!-- ---------------------------- Datepicker ---------------------------- -->
	<link rel="stylesheet" href="css/calendar/default.css" type="text/css">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
	<script type="text/javascript" src="js/timepicker/include/jquery-1.9.0.min.js"></script>
	<script type="text/javascript" src="js/zebra_datepicker.js"></script>
	<script type="text/javascript" src="js/zebra_datepicker.src.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$('input.datepicker').Zebra_DatePicker();
		});
	</script>

<script type="text/javascript">
	
	$(document).ready(function(){
	});

	var acquisitionid = document.getElementsByName("acquisitionid");
	var date = document.getElementsByName("date");
	var type = document.getElementsByName("type");
	var price = document.getElementsByName("price");
	var note = document.getElementsByName("note");

	function editAcquisition(id) {
		date[id].readOnly=false;
		document.getElementById("acquisitionTypeSelect" + id).disabled = false;
		price[id].readOnly=false;
		note[id].readOnly=false;

		var modbutton = document.getElementById('modbutton'+id);
		modbutton.innerHTML = "<input type=\"button\" onClick=\"modAcquisition("+id+");\" value=\"Módosít\" class=\"button\" >";
		var delbutton = document.getElementById('delbutton'+id);
		delbutton.innerHTML = "<input type=\"button\" onClick=\"cancelAcquisition("+id+");\" value=\"Mégse\" class=\"button\" >";

		modbutton.innerHTML += "<input type=\"hidden\" id=\"outdate\" value = \""+date[id].value+"\"> ";
		modbutton.innerHTML += "<input type=\"hidden\" id=\"outtype\" value = \""+type[id].value+"\"> ";
		modbutton.innerHTML += "<input type=\"hidden\" id=\"outprice\" value = \""+price[id].value+"\"> ";
		modbutton.innerHTML += "<input type=\"hidden\" id=\"outnote\" value = \""+note[id].value+"\"> ";
	}
	function modAcquisition(id) {
		var acquisitionid = $("input[name='acquisitionid']").val();
		var date = $("input[name='date']").val();
		var type = $("#acquisitionTypeSelect" + id).val();
		var price = $("input[name='price']").val();
		var note = $("input[name='note']").val();

		$.ajax({ 
			type: "POST",
			url: "menu-main/menu-statistic-submenu/acquisition/acquisitionmod.php",
			data: {
				acquisitionid: acquisitionid,
				date: date,
				type: type,
				price: price,
				note: note
			},
			success: function(data){
			$("#acquisition"+id).html(data);
			}
		}); 
	}
	function cancelAcquisition(id) {
		var outdate = document.getElementById('outdate').value;
		var outtype = document.getElementById('outtype').value;
		var outprice = document.getElementById('outprice').value;
		var outnote = document.getElementById('outnote').value;

		date[id].value = outdate;
		type[id].selected = outtype;
		price[id].value = outprice;
		note[id].value = outnote;

		date[id].readOnly=true;
		document.getElementById("acquisitionTypeSelect" + id).disabled = true;
		price[id].readOnly=true;
		note[id].readOnly=true;

		var modbutton = document.getElementById('modbutton'+id);
		modbutton.innerHTML = "<input type=\"button\" onClick=\"editAcquisition("+id+");\" value=\"Szerkeszt\" class=\"button\" >";
		var delbutton = document.getElementById('delbutton'+id);
		delbutton.innerHTML = "<input type=\"button\" onClick=\"delAcquisition("+id+");\" value=\"Töröl\" class=\"button\" >";

		return false;
	}
		function delAcquisition(id) {
			if(confirm('Biztosan törli?')) {
				$.ajax({ 
					type: "POST",
					url: "menu-main/menu-statistic-submenu/acquisition/acquisitiondel.php?id="+id,
					data: {id:id},
					success: function(data){
						$('#newAcquisition').html(data);
        		location.reload();
					}
				}); 
			}
		}
	
	function addAcquisitionTR() {
		var xmlhttp;
		var acquisitiontableRef = document.getElementById('acquisition');

		if (window.XMLHttpRequest) {	// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp = new XMLHttpRequest();
		} else {	// code for IE6, IE5
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		
		xmlhttp.onreadystatechange = function() {
			if (xmlhttp.readyState==4 && xmlhttp.status==200) {
				var newRow = acquisitiontableRef.insertRow(-1);
				var lastRowIndex = acquisitiontableRef.rows.length-1;
				var newID = lastRowIndex;
				newRow.id = "acquisition"+newID;
				newRow.innerHTML=xmlhttp.responseText;
			}
		}

		xmlhttp.open("POST","menu-main/menu-statistic-submenu/acquisition/newacquisitionTR.php",true);
		xmlhttp.send();
	}
	function newAcquisition() {
		$.ajax({
			type: "GET",
			url: "menu-main/menu-statistic-submenu/acquisition/addAcquisition.php",
			success: function(data){
				$('#newAcquisition').html(data);
				$('#newAcquisition').toggle();
			}
		}); 
	}
</script>

</head>
<body>
<div class="title">
	<span class="firstWord">Beszerzés</span> Adatok
</div>
<?php 

	$beginDate = isset($_GET['min_date']) ? $_GET['min_date'] : date("Y-m") . "-01";
	$endDate = isset($_GET['max_date']) ? $_GET['max_date'] : date("Y-m-d");
	$type = "";
	if(isset($_GET['type'])) {
		if(is_array($_GET['type'])) {
			foreach ($_GET['type'] as $types) {
				if($type == "") {
					$type .= " AND (acquisition.type = (SELECT id FROM acquisition_type WHERE type = '" . $types . "') ";
				}
				else {
					$type .= " OR acquisition.type = (SELECT id FROM acquisition_type WHERE type = '" . $types . "') ";
				}
			}
			if($type != "") {
				$type .= ")";
			}
		}
	}

?>

<div>
	<form id = "selectForm" style="width:730px;" method="GET">
		<table id = "selectFormTable" style="width:730px;">
			<tr>
				<td rowspan = '3'>
					<select id = 'selectFormTableSelect' name='type[]' multiple>
						<option disabled>Válasszon típust!</option>
<?php
						$query="SELECT id,type
								FROM acquisition_type 
								WHERE archive=0
								ORDER BY type ASC;";
						$result = mysql_query($query) or die (mysql_error());

						while ($row = mysql_fetch_assoc($result)) {
							echo '<option>' . $row["type"] . '</option>';
						}
?>
					</select>
				</td>
<?php		
		echo '		
				<td><input type="text" name="min_date" id="min_date" class="datepicker borderedStyle" value="' . $beginDate . '"></td>
				<td> - </td>
				<td>
					<input type="text" name="max_date" id="max_date" class="datepicker borderedStyle" value="' . $endDate . '">';
?>						
					<input type="hidden" name="page" value="statisztika">
					<input type="hidden" name="subpage" value="beszerzes">
				</td>

				<td><button type="submit" class = "button" id = "newButton">Szűrés</button><br/><br/>
				<button type="button" class = "button" id = "newButton" onClick="newAcquisition();">Új beszerzés</button></td>
			</tr>
		</table>
	</form>
</div>
<?php

	$_SESSION['newAcquisition'] = 0;
	$max_id = mysql_query("SELECT id FROM `acquisition` WHERE archive=0 ORDER BY type DESC LIMIT 0, 1");
		while ($row = mysql_fetch_assoc($max_id)) {
			$_SESSION['newAcquisition'] = $row['id'];
		}

	$query="SELECT acquisition_type.type, acquisition.id, acquisition.date, acquisition.price, acquisition.note, acquisition.piece , acquisition.archive 
			FROM acquisition, acquisition_type 
			WHERE acquisition.type = acquisition_type.id AND acquisition.date >= '" . $beginDate . "' AND acquisition.archive = 0 AND acquisition.date <= '" . $endDate . "'
			" . $type . " ORDER BY date DESC;";

	$result = mysql_query($query) or die (mysql_error());

	echo '<table id="acquisition">
			<tr>
				<th>Dátum</th>
				<th>Típus</th>
				<th>Végösszeg</th>
				<th>Mennyiség</th>
				<th>Megjegyzés</th>
			</tr>';

		$id = 0;
		while ($row = mysql_fetch_assoc($result)) {
			echo '<tr id="acquisition'.$id.'">
				<form id="acquisitionform'.$id.'" method="POST" action="">'; //number_format($row["price"], 0, ',', ' ') .' ft
					echo "<td class = 'acquisitionDate'> " . $row["date"] . "</td>";
					echo "<td class = 'acquisitionType'> " . $row["type"] . "</td>";
					echo "<td class = 'acquisitionPrice'> " . number_format($row["price"], 0, ',', ' ') . " ft</td>";
					echo "<td class = 'acquisitionPiece'> " . $row["piece"] . "</td>";
					echo "<td class = 'acquisitionNote shorterNote'> " . $row["note"] . "</td>";
					echo "<td class = 'acquisitionDel' id='delbutton$id'> <input type='button' onClick='delAcquisition(" . $row["id"] . ");' value='Töröl' class='button' ></td>";
			echo "</form>";
			echo "</tr>";
			$id++;
		}	
	echo '</table>';

	$query="SELECT SUM(acquisition.price) AS osszeg
			FROM acquisition, acquisition_type 
			WHERE acquisition.type = acquisition_type.id AND acquisition.archive = 0 AND acquisition.date >= '" . $beginDate . "' AND acquisition.date <= '" . $endDate . "'
			" . $type . ";";

	$result = mysql_query($query) or die(mysql_error());
	while ($row = mysql_fetch_assoc($result)) {
		echo '<div class = "smallerTitle">
				<span class = "green">Összes költség: </span><span class = "red" style="font-weight:bold;"> ' . number_format($row["osszeg"], 0, ',', ' ') .' ft</span>
				</div>';
	}
?>
<div id="newAcquisition" style="z-index: 6; overflow-x: hidden;">
</div>
</body>