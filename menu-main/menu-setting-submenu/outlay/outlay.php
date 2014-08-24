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

	function modOutlay(id) {
		var outlayid = $("#outlay"+ id + " .settingId").text();
		var type = $("#outlay"+ id + " .settingType").text();
		$.ajax({ 
			type: "POST",
			url: "menu-main/menu-setting-submenu/outlay/modOutlay.php",
			data: {
				outlayid: outlayid,
				type: type
			},
			success: function(data){
				$('#newOutlaySetting').html(data);
				$('#newOutlaySetting').toggle();
			}
		}); 
	}
	function delOutlay(id, outlayid) {
		if(confirm('Biztosan törli?')) {
			$.ajax({ 
				type: "POST",
				url: "menu-main/menu-setting-submenu/outlay/outlaydel.php",
				data: { outlayid: outlayid},
				success: function(data){
				$("#outlay"+id).html(data);
				}
			}); 
		}
	}
	function newOutlay() {
		$.ajax({
			type: "GET",
			url: "menu-main/menu-setting-submenu/outlay/addOutlay.php",
			success: function(data){
				$('#newOutlaySetting').html(data);
				$('#newOutlaySetting').toggle();
			}
		}); 
	}
</script>

</head>
<body>
<div class="title">
	<span class="firstWord">Beállítások </span> Költségek
</div>

<form id = "selectForm" method="GET">
	<table id = "selectForm_Table">
		<tr>
			<td><button class = "button" type="button" id = "newButton" onClick="newOutlay();">Új költség kateg.</button></td>
			<input type="hidden" name="page" value="beallitas">
			<input type="hidden" name="subpage" value="koltseg">
		</tr>
	</table>
</form>


<?php

	$_SESSION['newoutlay'] = 0;
	$max_id = mysql_query("SELECT id FROM `outlay_type` WHERE archive = 0 ORDER BY id DESC LIMIT 0, 1");
		while ($row = mysql_fetch_assoc($max_id)) {
			$_SESSION['newoutlay'] = $row['id'];
		}

	$query="SELECT * FROM outlay_type WHERE archive = 0 ORDER BY type ASC";
	$result = mysql_query($query) or die (mysql_error());
	echo '<table id="outlay">
			<tr>
				<th>#</th>
				<th>Típus</th>
				<th>Szerkesztés</th>
				<th>Törlés</th>
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
				echo "<td class = 'settingId contactDel'> " . $row["id"] . "</td>";
				echo "<td class = 'settingType'> " . $row["type"] . "</td>";
				echo "<td class = 'contactMod' id='modbutton$id'> <input type='button' onClick='modOutlay($id, " . $row["id"] . ");' value='Szerkesztés' class='button' ></td>";
				echo "<td class = 'contactDel' id='delbutton$id'> <input type='button' onClick='delOutlay($id, " . $row["id"] . ");' value='Töröl' class='button' ></td>";
			echo "</form>";
			echo "</tr>";
			$id++;
		}	
	echo '</table>';
?>
<div id="newOutlaySetting" style="z-index: 6; overflow-x: hidden;">
	
</div>
</body>