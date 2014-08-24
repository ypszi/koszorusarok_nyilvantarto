<script type="text/javascript" src="js/input/jquery.mask.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
	  $('#setPhone').mask('+36 00 000 0000', {'translation': {3: '3', 6: '6'}});
	});
</script>
<script>

	$(document).ready(function(){
		$("#add").on("click", function(){
			var setName = $("#setName").val();
			var setFuneralDate =$("#setFuneralDate").val();
			var setNote =$("#setNote").val();
			var funeralid =$("#funeralid").val();
			/*alert(date + " " + type + " " + price + " " + note);*/
			$.ajax({ 
				type: "POST",
				url: "menu-main/menu-deathcalendar-submenu/modFuneralDb.php",
				data: {
					setName: setName,
					setFuneralDate: setFuneralDate,
					setNote: setNote,
					funeralid: funeralid
				},
				success: function(data){location.reload();
				}
			}); 
		});
	});

</script>



<div id="exit" class="exit" onclick="$('#newFuneral').toggle();" style="display: block;">

X

</div>



<p style="font: normal 22px 'Arial'; color: #89a583; padding: 20px 20px 5px 20px;">Temetés módosítása</p>
<input id = 'funeralid' type='hidden' value='<?php echo $_GET["id"]; ?>' name='funeralid'>
<table id = 'addOutlayTable'>

	<tr><td>Név:</td><td>         		 	<input id = 'setName' class = 'borderedStyle' type='text' value='<?php echo $_GET["funeralName"]; ?>' placeholder='Név' name='name'></td></tr>

	<tr><td>Temetés dátuma:</td><td>      <input id = 'setFuneralDate' class = 'borderedStyle' type='text' value='<?php echo $_GET["funeralDate"]; ?>' placeholder='Dátum' name='funeral_date'></td></tr>

	<tr><td>Megjegyzés:</td><td>			<textarea id = "setNote" class = 'borderedStyle' name = "note" rows="3" cols="30"><?php echo $_GET["funeralNote"]; ?></textarea></td></tr>

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





