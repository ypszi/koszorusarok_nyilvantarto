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

			var setPhone = $("#setPhone").val();

			var setActivity =$("#setActivity").val();

			var setNote =$("#setNote").val();



			/*alert(date + " " + type + " " + price + " " + note);*/



			$.ajax({ 

				type: "POST",

				url: "menu-main/menu-phone-submenu/newContact.php",

				data: {

					setName: setName,

					setPhone: setPhone,

					setActivity: setActivity,

					setNote: setNote

				},

				success: function(data){/*

					$("#acquisition").append("<tr></tr>");*/

					/*$("#acquisition"+id).html(data);*/

					$("#contact").html(data);

				}

			}); 

		});





	});

</script>



<div id="exit" class="exit" onclick="$('#newContact').toggle();" style="display: block;">

X

</div>



<p style="font: normal 22px 'Arial'; color: #89a583; padding: 20px 20px 5px 20px;">Új kontakt rögzítése</p>

<table id = 'addOutlayTable'>

	<tr><td>Név:</td><td>         		 	<input id = 'setName' class = 'borderedStyle' type='text' value='' placeholder='Név' name='name'></td></tr>

	<tr><td>Telefon:</td><td>      			<input id = 'setPhone' class = 'borderedStyle' type='text' value='+36 ' placeholder='Telefon' name='phone'></td></tr>

	<tr><td>Foglalkozási kör:</td><td>      <input id = 'setActivity' class = 'borderedStyle' type='text' value='' placeholder='Tag-ek' name='activity'></td></tr>

	<tr><td>Megjegyzés:</td><td>			<textarea id = "setNote" class = 'borderedStyle' name = "note" rows="3" cols="30"></textarea></td></tr>

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





