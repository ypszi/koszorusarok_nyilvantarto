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

	var outlayid = document.getElementsByName("outlayid");
	var date = document.getElementsByName("date");
	var type = document.getElementsByName("type");
	var price = document.getElementsByName("price");
	var note = document.getElementsByName("note");

	function editOutlay(id) {
		date[id].readOnly=false;
		document.getElementById("acquisitionTypeSelect" + id).disabled = false;
		price[id].readOnly=false;
		note[id].readOnly=false;		

		var modbutton = document.getElementById('modbutton'+id);
		modbutton.innerHTML = "<input type=\"button\" onClick=\"modOutlay("+id+");\" value=\"Módosít\" class=\"button\" >";
		var delbutton = document.getElementById('delbutton'+id);
		delbutton.innerHTML = "<input type=\"button\" onClick=\"cancelOutlay("+id+");\" value=\"Mégse\" class=\"button\" >";

		modbutton.innerHTML += "<input type=\"hidden\" id=\"outdate\" value = \""+date[id].value+"\"> ";
		modbutton.innerHTML += "<input type=\"hidden\" id=\"outtype\" value = \""+type[id].value+"\"> ";
		modbutton.innerHTML += "<input type=\"hidden\" id=\"outprice\" value = \""+price[id].value+"\"> ";
		modbutton.innerHTML += "<input type=\"hidden\" id=\"outnote\" value = \""+note[id].value+"\"> ";
	}
	function modOutlay(id) {
		var outlayid = $("input[name='outlayid']").val();
		var date = $("input[name='date']").val();
		var type = $("#acquisitionTypeSelect" + id).val();
		var price = $("input[name='price']").val();
		var note = $("input[name='note']").val();

		$.ajax({ 
			type: "POST",
			url: "menu-main/menu-statistic-submenu/outlay/outlaymod.php",
			data: {
				outlayid: outlayid,
				date: date,
				type: type,
				price: price,
				note: note
			},
			success: function(data){
			$("#outlay"+id).html(data);
			}
		}); 
	}
	function cancelOutlay(id) {
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
		modbutton.innerHTML = "<input type=\"button\" onClick=\"editOutlay("+id+");\" value=\"Szerkeszt\" class=\"button\" >";
		var delbutton = document.getElementById('delbutton'+id);
		delbutton.innerHTML = "<input type=\"button\" onClick=\"delOutlay("+id+");\" value=\"Töröl\" class=\"button\" >";

		return false;
	}
		function delOutlay(id) {
			if(confirm('Biztosan törli a költséget?')) {
				$.ajax({ 
					type: "POST",
					url: "menu-main/menu-statistic-submenu/outlay/delOutlay.php?id="+id,
					data: {id:id},
					success: function(data){
						$('#newOutlay').html(data);
        		location.reload();
					}
				}); 
			}
		}
	function addOutlayTR() {
		var xmlhttp;
		var outlaytableRef = document.getElementById('outlay');

		if (window.XMLHttpRequest) {	// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp = new XMLHttpRequest();
		} else {	// code for IE6, IE5
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		
		xmlhttp.onreadystatechange = function() {
			if (xmlhttp.readyState==4 && xmlhttp.status==200) {
				var newRow = outlaytableRef.insertRow(-1);
				var lastRowIndex = outlaytableRef.rows.length-1;
				var newID = lastRowIndex;
				newRow.id = "outlay"+newID;
				newRow.innerHTML=xmlhttp.responseText;
			}
		}

		xmlhttp.open("POST","menu-main/menu-statistic-submenu/outlay/newoutlayTR.php",true);
		xmlhttp.send();
	}
	function newOutlay() {
		$.ajax({
			type: "GET",
			url: "menu-main/menu-statistic-submenu/outlay/addOutlay.php",
			success: function(data){
				$('#newOutlay').html(data);
				$('#newOutlay').toggle();
			}
		}); 
	}
</script>

</head>
<body>
<div class="title">
	<span class="firstWord">Költség</span> Adatok
</div>
<?php 

	$beginDate = isset($_GET['min_date']) ? $_GET['min_date'] : date("Y-m") . "-01";
	$endDate = isset($_GET['max_date']) ? $_GET['max_date'] : date("Y-m-d");
	$type = "";
	if(isset($_GET['type'])) {
		if(is_array($_GET['type'])) {
			foreach ($_GET['type'] as $types) {
				if($type == "") {
					$type .= " AND (outlay.type = (SELECT id FROM outlay_type WHERE type = '" . $types . "') ";
				}
				else {
					$type .= " OR outlay.type = (SELECT id FROM outlay_type WHERE type = '" . $types . "') ";
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
								FROM outlay_type
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
		echo   '<td><input type="text" name="min_date" id="min_date" class="datepicker borderedStyle" value="' . $beginDate . '"></td>
				<td> - </td>
				<td>
					<input type="text" name="max_date" id="max_date" class="datepicker borderedStyle" value="' . $endDate . '">';
?>
					<input type="hidden" name="page" value="statisztika">
					<input type="hidden" name="subpage" value="jarulek">
				</td>

				<td><button type="submit" class = "button" id = "newButton">Szűrés</button><br/><br/>
				<button class = "button" type="button" id = "newButton" onClick="newOutlay();">Új költség</button></td>
			</tr>
		</table>
	</form>
</div>
<?php

	$_SESSION['newoutlay'] = 0;
	$max_id = mysql_query("SELECT id FROM `outlay` ORDER BY id DESC LIMIT 0, 1");
		while ($row = mysql_fetch_assoc($max_id)) {
			$_SESSION['newoutlay'] = $row['id'];
		}

	$query="SELECT outlay_type.type, outlay.id, outlay.date, outlay.price, outlay.note, outlay.archive 
			FROM outlay, outlay_type 
			WHERE outlay.type = outlay_type.id AND outlay.date >= '" . $beginDate . "' AND outlay.archive = 0 AND outlay.date <= '" . $endDate . "'
			" . $type . " ORDER BY date DESC;";

			/*echo $query;*/
	$result = mysql_query($query) or die (mysql_error());
	echo '<table id="outlay">
			<tr>
				<th>Dátum</th>
				<th>Típus</th>
				<th>Végösszeg</th>
				<th>Megjegyzés</th>
			</tr>';

		$id = 0;
		while ($row = mysql_fetch_assoc($result)) {
	/*		if ($id % 2 == 0){
				$color="#e2f1cb";
			}else{
				$color="#ffffff";		
			}*/
		echo '<tr id="outlay'.$id.'">
			<form id="outlayform'.$id.'" method="POST" action="">'; 
				echo "<td class = 'acquisitionDate'> " . $row["date"] . "</td>";
				echo "<td class = 'acquisitionType'> " . $row["type"] . "</td>";
				echo "<td class = 'acquisitionPrice'> " . number_format($row["price"], 0, ',', ' ') . " ft</td>";
				echo "<td class = 'acquisitionNote'> " . $row["note"] . "</td>";
				echo "<td class = 'acquisitionDel' id='delbutton$id'> <input type='button' onClick='delOutlay(" . $row["id"] . ");' value='Töröl' class='button' ></td>";
			echo "</form>";
			echo "</tr>";
			$id++;
		}	
	echo '</table>';
	
	$query="SELECT SUM(outlay.price) AS osszeg
			FROM outlay, outlay_type 
			WHERE outlay.type = outlay_type.id AND outlay.archive = 0 AND outlay.date >= '" . $beginDate . "' AND outlay.date <= '" . $endDate . "'
			" . $type . ";";

	$result = mysql_query($query) or die(mysql_error());
	while ($row = mysql_fetch_assoc($result)) {
		echo '<div class = "smallerTitle">
				<span class = "green">Összes költség: </span><span class = "red" style="font-weight:bold;"> ' . number_format($row["osszeg"], 0, ',', ' ') .' ft</span>
				</div>';
	}
?>
<div id="newOutlay" style="z-index: 6; overflow-x: hidden;">
</div>
</body>