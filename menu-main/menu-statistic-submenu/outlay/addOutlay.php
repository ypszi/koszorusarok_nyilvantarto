<script>
	$(document).ready(function(){

		var date = new Date();
		var month = date.getMonth()+1;
		var day = date.getDate();
		var output = date.getFullYear() + '-' +
	    (month < 10 ? '0' : '') + month + '-' +
	    (day < 10 ? '0' : '') + day;

		$("#setDate").val(output);
		$(".datepicker").Zebra_DatePicker();

		$("#add").on("click", function(){
			var date = $("#setDate").val();
			var type = $("#setType").val();
			var price =$("#setPrice").val();
			var note = $("#setNote").val();

			/*alert(date + " " + type + " " + price + " " + note);*/

			$.ajax({ 
				type: "POST",
				url: "menu-main/menu-statistic-submenu/outlay/newoutlay.php",
				data: {
					date: date,
					type: type,
					price: price,
					note: note
				},
				success: function(data){
					$("#outlay").html(data);
					location.reload();
				}
			}); 
		});


	});
</script>

<div id="exit" class="exit" onclick="document.getElementById('newOutlay').style.display= 'none';" style="display: block;">
X
</div>

<p style="font: normal 22px 'Arial'; color: #89a583; padding: 20px 20px 5px 20px;">Új költség rögzítése</p>

<?php
	include '../../../config.php';

	echo "<table id = 'addOutlayTable'>";
	echo "<tr><td>Dátum:</td><td><input class = 'datepicker borderedStyle' id = 'setDate' type='text' value='' placeholder='Dátum' name='date'></td></tr>";
	echo "<tr><td>Típus:</td><td><select id = 'setType' name='type'>
		<option disabled selected>Válasszon típust!</option>";
		$query_type = "SELECT type FROM outlay_type WHERE archive=0 ORDER BY outlay_type.type";
		$res_type = mysql_query($query_type) or die(mysql_error());
		while ($row = mysql_fetch_assoc($res_type)) {
			echo '<option>' . $row["type"] . '</option>';
		}
	echo "</select></td></tr>";
?>
<tr><td>Ár:</td><td><input id = 'setPrice' type='text' value='' placeholder='Ár' name='price'></td></tr>
<tr><td>Megjegyzés:</td><td><textarea id = "setNote" name = "note" rows="3" cols="30"></textarea><!-- <input type='text' value='' placeholder='Megjegyzés' name='note'> --></td></tr>

<tr><td colspan = "2"><button id = "add">Hozzáadom!</button></td></tr>


</table>