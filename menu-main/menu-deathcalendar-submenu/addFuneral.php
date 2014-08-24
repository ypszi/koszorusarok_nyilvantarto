<!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script> -->
<script type="text/javascript" src="js/jquery-1.8.3.min.js"></script>

<!-- <script type="text/javascript" src="js/input/jquery.mask.min.js"></script>
 -->
<link rel="stylesheet" href="js/timepicker3/include/ui-1.10.0/ui-lightness/jquery-ui-1.10.0.custom.min.css" type="text/css" />
<link rel="stylesheet" href="js/timepicker3/jquery.ui.timepicker.css?v=0.3.2" type="text/css" />
<link rel="stylesheet" href="js/timepicker3/jquery.ui.timepickerCustom.css?v=0.3.2" type="text/css" />
<script type="text/javascript" src="js/timepicker3/include/ui-1.10.0/jquery.ui.core.min.js"></script>
<script type="text/javascript" src="js/timepicker3/jquery.ui.timepicker.js?v=0.3.2"></script>

<link rel="stylesheet" href="css/calendar/default.css" type="text/css">
<script type="text/javascript" src="js/zebra_datepicker.js"></script>
<script type="text/javascript" src="js/zebra_datepicker.src.js"></script>

<script>

	$(document).ready(function(){
/*
	$("#setFuneralDate").mask("9999-99-99 99:99");
*/


		$("#setFuneralDate").Zebra_DatePicker();
		$('#setFuneralTime').timepicker( {
	        /*showAnim: 'blind'*/
	    });

		$("#add").on("click", function(){
			var setName = $("#setName").val();
			var setFuneralDate =$("#setFuneralDate").val();
			var setFuneralTime =$("#setFuneralTime").val();
			var setNote =$("#setNote").val();

			$.ajax({ 
				type: "POST",
				url: "menu-main/menu-deathcalendar-submenu/newFuneral.php",
				data: {
					modify: 1,
					setName: setName,
					setFuneralTime: setFuneralTime,
					setFuneralDate: setFuneralDate,
					setNote: setNote
				},
				success: function(data){
					/*$("#funeral").html(data);*/
					location.reload();
				}
			}); 
		});





	});

</script>



<div id="exit" class="exit" onclick="$('#newFuneral').toggle();" style="display: block;">

X

</div>



<p style="font: normal 22px 'Arial'; color: #89a583; padding: 20px 20px 5px 20px;">Új temetés rögzítése</p>

<table id = 'addOutlayTable'>

	<tr><td>Név:</td><td>         		 	<input id = 'setName' class = 'borderedStyle' type='text' value='' placeholder='Név' name='name'></td></tr>

	<tr><td>Temetés dátuma:</td><td>        <input id = 'setFuneralDate' class = 'borderedStyle' type='text' value='' placeholder='yyyy-mm-dd' name='funeral_date'></td></tr>

	<tr><td>Temetés ideje:</td><td>        <input id = 'setFuneralTime' class = 'borderedStyle' type='text' value='' placeholder='hh:mm' name='funeral_time'></td></tr>

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





