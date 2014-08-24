<script type="text/javascript" src="js/input/jquery.mask.min.js"></script>
<script>

	$(document).ready(function(){
		$("#add").on("click", function(){
			var setOutlayid = $("#outlayid").val();
			var setType = $("#setType").val();
			$.ajax({ 
				type: "POST",
				url: "menu-main/menu-setting-submenu/outlay/modOutlayDb.php",
				data: {
					setOutlayid: setOutlayid,
					setType: setType
				},
				success: function(data){
					location.reload();
				}
			}); 
		});
	});

</script>



<div id="exit" class="exit" onclick="$('#newOutlaySetting').toggle();" style="display: block;">

X

</div>



<p style="font: normal 22px 'Arial'; color: #89a583; padding: 20px 20px 5px 20px;">Kiadás kategória módosítása</p>
<input id = 'outlayid' type='hidden' value='<?php echo $_POST["outlayid"]; ?>' name='outlayid'>

<table id = 'addOutlayTable'>
<tr><td>Név:</td><td><input class = 'borderedStyle' id = 'setType' type='text' value='<?php echo $_POST["type"]; ?>' placeholder='Név' name='type'></td></tr></td></tr>
<tr><td colspan = "2"><button id = "add">Hozzáadom!</button></td></tr>
</table>



<?php

	include '../../../config.php';



	

	

	/*echo "<tr><td>Típus:</td><td><select id = 'setType' name='type'>

		<option disabled selected>Válasszon típust!</option>";

		$query_type = "SELECT type FROM acquisition_type ORDER BY acquisition_type.id";

		$res_type = mysql_query($query_type) or die(mysql_error());

		while ($row = mysql_fetch_assoc($res_type)) {

			echo '<option>' . $row["type"] . '</option>';

		}

	echo "</select></td></tr>";*/

?>





