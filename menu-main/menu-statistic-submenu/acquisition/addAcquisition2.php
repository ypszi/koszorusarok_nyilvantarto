<script>
	$(document).ready(function(){

		$(".datepicker").Zebra_DatePicker();

		$("#add").on("click", function(){
			var date = $("#setDate").val();
			var type = $("#setType").val();
			var price =$("#setPrice").val();
			var piece =$("#setPiece").val();
			var note = $("#setNote").val();

/*			alert(date + " " + type + " " + price + " " + note);
*/
			$.ajax({ 
				type: "POST",
				url: "menu-main/menu-statistic-submenu/acquisition/newAcquisition.php",
				data: {
					date: date,
					type: type,
					price: price,
					piece: piece,
					note: note
				},
				success: function(data){
					$("#acquisition").html(data);
					location.reload();
				}
			}); 
		});


	});
</script>

<div id="exit" class="exit" onclick="document.getElementById('newAcquisition').style.display= 'none';" style="display: block;">
X
</div>

<p style="font: normal 22px 'Arial'; color: #89a583; padding: 20px 20px 5px 20px;">Új Beszerzés rögzítése</p>

<?php
	include '../../../config.php';

	echo "<table id = 'addOutlayTable'>";
	echo "<tr><td>Dátum:</td><td><input class = 'datepicker borderedStyle' id = 'setDate' type='text' value='".date("Y-m-d", strtotime($_GET["datum"]))."' placeholder='Dátum' name='date'></td></tr>";
	echo "<tr><td>Típus:</td><td><select id = 'setType' name='type'>
		<option disabled selected>Válasszon típust!</option>";
		$query_type = "SELECT id, type FROM acquisition_type WHERE archive=0 ORDER BY acquisition_type.type";
		$res_type = mysql_query($query_type) or die(mysql_error());
		while ($row = mysql_fetch_assoc($res_type)) {
			echo '<option>' . $row["id"] . " - ". $row["type"] . '</option>';
		}
	echo "</select></td></tr>";
?>
<tr><td>Ár:</td><td><input id = 'setPrice' type='text' value='' placeholder='Ár' name='price'></td></tr>
<tr><td>Mennyiség:</td><td><input id = 'setPiece' type='text' value='' placeholder='Mennyiség' name='piece'></td></tr>
<tr><td>Megjegyzés:</td><td><textarea id = "setNote" name = "note" rows="3" cols="30"></textarea><!-- <input type='text' value='' placeholder='Megjegyzés' name='note'> --></td></tr>

<tr><td colspan = "2"><button id = "add">Hozzáadom!</button></td></tr>


</table>