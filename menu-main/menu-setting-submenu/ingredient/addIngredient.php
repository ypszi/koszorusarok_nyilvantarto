<script>
	$(document).ready(function(){

		$("#add").on("click", function(){
			var type = $("#setType").val();

			/*alert(date + " " + type + " " + price + " " + note);*/

			$.ajax({ 
				type: "POST",
				url: "menu-main/menu-setting-submenu/ingredient/newIngredient.php",
				data: {
					type: type
				},
				success: function(data){
					$("#ingredient").html(data);
					location.reload();
				}
			}); 
		});


	});
</script>

<div id="exit" class="exit" onclick="document.getElementById('newIngredientSetting').style.display= 'none';" style="display: block;">
X
</div>

<p style="font: normal 22px 'Arial'; color: #89a583; padding: 20px 20px 5px 20px;">Új kellék kategória rögzítése</p>

<?php
	include '../../../config.php';
?>

<table id = 'addIngredientTable'>
<tr>
	<td>Név:</td>
	<td><input class = 'borderedStyle' id = 'setType' type='text' value='' placeholder='Név' name='type'></td>
</tr>
<tr>
	<td colspan = "2"><button id = "add">Hozzáadom!</button></td>
	</tr>
</table>