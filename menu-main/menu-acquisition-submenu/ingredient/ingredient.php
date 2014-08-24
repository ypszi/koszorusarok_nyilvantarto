<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>

<script>
	// $(document).ready(function(){

		function delIngredient(id) {
			if(confirm('Biztosan törli?')) {
				$.ajax({
					type: "POST",
					url: "menu-main/menu-acquisition-submenu/ingredient/delIngredient.php",
					data: { id: id},
					success: function(data){
					$("#contact"+id).html(data);
					location.reload();
					}
				});
			}
		}
		function newIngredient() {
			$.ajax({
				type: "GET",
				url: "menu-main/menu-acquisition-submenu/ingredient/addIngredient.php",
				success: function(data){
					$('#newIngredient').html(data);
					$('#newIngredient').toggle();
				}
			});
		}
		function modIngredient(id, dbID) {
			group = $("#contact"+ id + " .group").text();
			ingredient = $("#contact"+ id + " .ingredient").text();
			price = $("#contact"+ id + " .price").text();
			sell_price = $("#contact"+ id + " .sell_price").text();
			note = $("#contact"+ id + " .note").text();

			$.ajax({
				type: "GET",
				url: "menu-main/menu-acquisition-submenu/ingredient/modIngredient.php",
				data: {
					id: dbID,
					group: group,
					ingredient: ingredient,
					price: price,
					sell_price: sell_price,
					note: note
				},
				success: function(data){
					$('#newIngredient').html(data);
					$('#newIngredient').toggle();
				}
			});
		}
		function searchIngredient() {
			$.ajax({
				type: "GET",
				url: "menu-main/menu-acquisition-submenu/ingredient/ingredient.php",
				success: function(data){
					location.reload();
				}
			});
		}
	// });
</script>

<div  id="content" style="padding: 10px; background-color: #fff;">

<div class="title">
	<span class="firstWord">Kellék</span> Jegyzék
</div>

<form id = "selectForm" method="GET">
	<table id = "selectForm_Table">
		<tr>
			<td>
				<select id = 'selectFormTableSelect' name='type[]' multiple>
					<option disabled>Válasszon típust!</option>
<?php
					$query="SELECT id,type
							FROM ingredient_type
							WHERE archive=0
							ORDER BY type ASC;";
					$result = mysql_query($query) or die (mysql_error());

					while ($row = mysql_fetch_assoc($result)) {
						$ingredient_type[$row["id"]] = $row["type"]; 
						echo '<option value="'.$row["id"].'">' . $row["type"] . '</option>';
					}
?>
				</select>
			</td>
			<td><input type="text" name="searchIngredient" id="searchIngredient" class="searchContact borderedStyle" value="" placeholder = "Kellék szerinti keresés"></td>
			<td><button type="submit" class = "button" id = "filter">Keresés</button></td>
			<td><button class = "button" type="button" id = "newButton" onClick="newIngredient();">Új Kellék</button></td>
			<input type="hidden" name="page" value="beszerzes">
			<input type="hidden" name="subpage" value="kellekjegyzek">
		</tr>
	</table>
</form>

<table id = "contact">
	<tr>
		<th>Csoport</th>
		<th>Kellék</th>
		<th>Beszerzési ár</th>
		<th>Eladási ár</th>
		<th>Megjegyzés</th>
	</tr>

<?php

$searchIngredientByType = "";
$i = 0;
if(isset($_GET['type'])) {
	foreach ($_GET['type'] as $key) {
		if (isset($key)) {
			if($key != "") {
				if ($i < count($_GET['type'])-1) { // pl 3 type esetén 2 OR kell
					$searchIngredientByType .= "(type_id = '" .$key."' OR ";
				} else {
					if (count($_GET['type']) == 1)
					$searchIngredientByType .= "(type_id = '" .$key."')";
					else 
					$searchIngredientByType .= "type_id = '" .$key."')";
				}
			}
			else 
				$searchIngredientByType .= "";
		}
		$i++;
	}
}
else {
	$searchIngredientByType = "";
}

if(isset($_GET['searchIngredient'])) {
	if($_GET['searchIngredient'] != "")
		if ($searchIngredientByType == "") {
			$searchIngredientByName = "ingredient LIKE '%" .$_GET['searchIngredient']. "%'";
		} else {
			$searchIngredientByName = " AND ingredient LIKE '%" .$_GET['searchIngredient']. "%'";
		}
	else 
		$searchIngredientByName = "";
}
else {
	$searchIngredientByName = "";
}

$query = "SELECT id, type_id, ingredient, income_price, sale_price, note
		FROM ingredient ";
if ($searchIngredientByType == "") {
	if ($searchIngredientByName != "") {
		$query .= "WHERE ".$searchIngredientByName;
	}
} else {
	if ($searchIngredientByName == "") {
		$query .= "WHERE ".$searchIngredientByType;
	} else {
		$query .= "WHERE ".$searchIngredientByType.$searchIngredientByName;
	}
}
$query .= " ORDER BY type_id ASC, ingredient ASC;";

$result = mysql_query($query) or die (mysql_error());

$id = 0;

if (mysql_num_rows($result) < 1) {
	echo "
		<tr>
			<td colspan='5'> Nincs a keresésnek megfelelő elem</td>
		</tr>
		";
}
while ($row = mysql_fetch_assoc($result)) {
	echo "
	<tr id='contact".$id."'>
		<td class = 'group'>" . $ingredient_type[$row["type_id"]] . "</td>
		<td class = 'ingredient'>" . $row["ingredient"] . "</td>
		<td class = 'price'>" . number_format($row["income_price"], 0, ',', ' ') . " ft </td>
		<td class = 'sell_price'>" . number_format($row["sale_price"], 0, ',', ' ') . " ft </td>
		<td class = 'note'>" . $row["note"] . "</td>
		<td class = 'contactMod' id='modbutton" . $id . "'><input type='button' onClick='modIngredient(" . $id . ", ". $row['id']. ");' value='Módosítás' class='button' ></td>
		<td class = 'contactDel' id='delbutton" . $id . "'><input type='button' onClick='delIngredient(" . $row['id'] . ");' value='Töröl' class='button' ></td>
	</tr>
	";
	$id++;
}	
?>
<div id="newIngredient" style="z-index: 6; overflow-x: hidden;">
</div>
</table>
</div>


