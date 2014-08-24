<script type="text/javascript" src="js/input/jquery.mask.min.js"></script>
<script>

	$(document).ready(function(){
		$("#add").on("click", function(){
			var setIngredientid = $("#ingredientid").val();
			var setType = $("#setType").val();
			$.ajax({ 
				type: "POST",
				url: "menu-main/menu-setting-submenu/ingredient/modIngredientDb.php",
				data: {
					setIngredientid: setIngredientid,
					setType: setType
				},
				success: function(data){
					location.reload();
				}
			}); 
		});
	});

</script>



<div id="exit" class="exit" onclick="$('#newIngredientSetting').toggle();" style="display: block;">
X
</div>

<p style="font: normal 22px 'Arial'; color: #89a583; padding: 20px 20px 5px 20px;">Kellék kategória módosítása</p>
<input id = 'ingredientid' type='hidden' value='<?php echo $_POST["ingredientid"]; ?>' name='ingredientid'>

<table id = 'addIngredientTable'>
<tr><td>Név:</td><td><input class = 'borderedStyle' id = 'setType' type='text' value='<?php echo $_POST["type"]; ?>' placeholder='Név' name='type'></td></tr></td></tr>
<tr><td colspan = "2"><button id = "add">Hozzáadom!</button></td></tr>
</table>

<?php
	include '../../../config.php';
?>





