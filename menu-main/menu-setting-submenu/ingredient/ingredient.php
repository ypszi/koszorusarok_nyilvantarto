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

	function modIngredient(id) {
		var ingredientid = $("#ingredient"+ id + " .settingId").text();
		var type = $("#ingredient"+ id + " .settingType").text();
		$.ajax({ 
			type: "POST",
			url: "menu-main/menu-setting-submenu/ingredient/modIngredient.php",
			data: {
				ingredientid: ingredientid,
				type: type
			},
			success: function(data){
				$('#newIngredientSetting').html(data);
				$('#newIngredientSetting').toggle();
			}
		}); 
	}
	function delIngredient(id, ingredientid) {
		if(confirm('Biztosan törli?')) {
			$.ajax({ 
				type: "POST",
				url: "menu-main/menu-setting-submenu/ingredient/ingredientdel.php",
				data: { ingredientid: ingredientid},
				success: function(data){
				$("#ingredient"+id).html(data);
				}
			}); 
		}
	}
	function newIngredient() {
		$.ajax({
			type: "GET",
			url: "menu-main/menu-setting-submenu/ingredient/addIngredient.php",
			success: function(data){
				$('#newIngredientSetting').html(data);
				$('#newIngredientSetting').toggle();
			}
		}); 
	}
</script>

</head>
<body>
<div class="title">
	<span class="firstWord">Beállítások </span> Kellékek
</div>

<form id = "selectForm" method="GET">
	<table id = "selectForm_Table">
		<tr>
			<td><button class = "button" type="button" id = "newButton" onClick="newIngredient();">Új kellék kateg.</button></td>
			<input type="hidden" name="page" value="beallitas">
			<input type="hidden" name="subpage" value="koltseg">
		</tr>
	</table>
</form>


<?php

	$_SESSION['newingredient'] = 0;
	$max_id = mysql_query("SELECT id FROM `ingredient_type` WHERE archive = 0 ORDER BY id DESC LIMIT 0, 1");
		while ($row = mysql_fetch_assoc($max_id)) {
			$_SESSION['newingredient'] = $row['id'];
		}

	$query="SELECT * FROM ingredient_type WHERE archive = 0 ORDER BY type ASC";
	$result = mysql_query($query) or die (mysql_error());
	echo '<table id="ingredient">
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
		echo '<tr id="ingredient'.$id.'">
			<form id="ingredientform'.$id.'" method="POST" action="">'; 
				echo "<td class = 'settingId contactDel'> " . $row["id"] . "</td>";
				echo "<td class = 'settingType'> " . $row["type"] . "</td>";
				echo "<td class = 'contactMod' id='modbutton$id'> <input type='button' onClick='modIngredient($id, " . $row["id"] . ");' value='Szerkesztés' class='button' ></td>";
				echo "<td class = 'contactDel' id='delbutton$id'> <input type='button' onClick='delIngredient($id, " . $row["id"] . ");' value='Töröl' class='button' ></td>";
			echo "</form>";
			echo "</tr>";
			$id++;
		}	
	echo '</table>';
?>
<div id="newIngredientSetting" style="z-index: 6; overflow-x: hidden;">
	
</div>
</body>