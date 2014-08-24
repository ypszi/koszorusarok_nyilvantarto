<script>

$(document).ready(function(){

	$("#add").on("click", function(){
		var id = $("#ingredientid").val();
		var group = $("#group").val();
		var ingredient = $("#ingredient").val();
		var price = $("#price").val();
		var sell_price = $("#sell_price").val();
		var note = $("#note").val();

		$.ajax({ 
			type: "POST",
			url: "menu-main/menu-acquisition-submenu/ingredient/modIngredientDb.php",
			data: {
				id: id,
				group: group,
				ingredient: ingredient,
				price: price,
				sell_price: sell_price,
				note: note
			},
			success: function(data){
				location.reload();
			}
		}); 
	});
});
</script>



<div id="exit" class="exit" onclick="$('#newIngredient').toggle();" style="display: block;">

X

</div>



<p style="font: normal 22px 'Arial'; color: #89a583; padding: 20px 20px 5px 20px;">Kellék módosítása</p>
<input id = 'ingredientid' type='hidden' value='<?php echo $_GET["id"]; ?>' name='ingredientid'>
<table id = 'addOutlayTable'>

	<tr><td>Név:</td>
	<td>  
	<select id="group" name="group">
	<?php 
	include '../../../config.php';
	$query = "SELECT id, type FROM ingredient_type WHERE archive = 0;";
	$result = mysql_query($query) or die(mysql_error());
	while ($row = mysql_fetch_assoc($result)) {
		if ($row['type'] == $_GET['group']) {
			echo "<option value='".$row['id']."' selected>".$row['type']."</option>";
		} else {
			echo "<option value='".$row['id']."'>".$row['type']."</option>";
		}
	}
	 ?>
	</select>
	</td></tr>

	<tr><td>Kellék:</td>
	<td><input id="ingredient" class = 'borderedStyle' type='text' value='<?php echo $_GET["ingredient"]; ?>' placeholder='Kellék' name='ingredient'></td></tr>

	<tr><td>Beszerzési ár:</td>
	<td><input id="price" class = 'borderedStyle' type='text' value='<?php echo $_GET["price"]; ?>' placeholder='Beszerzési ár' name='price'></td></tr>
	
	<tr><td>Eladási ár:</td>
	<td><input id="sell_price" class = 'borderedStyle' type='text' value='<?php echo $_GET["sell_price"]; ?>' placeholder='Beszerzési ár' name='sell_price'></td></tr>

	<tr><td>Megjegyzés:</td>
	<td><textarea id="note" class = 'borderedStyle' name = "note" rows="3" cols="30"><?php echo $_GET['note']; ?></textarea></td></tr>

	<tr><td colspan = "2"><button id = "add">Hozzáadom!</button></td></tr>

</table>
