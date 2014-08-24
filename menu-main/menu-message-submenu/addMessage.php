<script>

	$(document).ready(function(){



		$("#add").on("click", function(){

			var recipient = $("#setRecipient").val();

			var message = $("#setMessage").val();



			$.ajax({ 

				type: "POST",

				url: "menu-main/menu-message-submenu/newMessage.php",

				data: {

					recipient: recipient,

					message: message

				},

				success: function(data){

					$("#messages").html(data);

					location.reload();

				}

			}); 

		});





	});

</script>



<div id="exit" class="exit" onclick="document.getElementById('newMessage').style.display= 'none';" style="display: block;">

X

</div>



<p style="font: normal 22px 'Arial'; color: #89a583; padding: 20px 20px 5px 20px;">Új üzenet küldése</p>



<?php

	include '../../config.php';

	session_start();

	echo "<table id = 'addOutlayTable'>";

	// echo "<tr><td>Kinek:</td><td><input class = 'borderedStyle' id = 'setName' type='text' value='' placeholder='Fogadó neve' name='recipientName'></td></tr>";

	echo "<tr><td>Név:</td><td><select id = 'setRecipient' name='recipient' class = 'borderedStyle' multiple>";

		$query_users = "SELECT id, name FROM users WHERE id != " . $_SESSION['logged_in'] . " AND enable=1 ORDER BY name";

		$res_users = mysql_query($query_users) or die(mysql_error());

		while ($row = mysql_fetch_assoc($res_users)) {

			echo '<option>' . $row["name"] . '</option>';

		}

	echo "</select></td></tr>";

?>

<tr><td>Üzenet:</td><td><textarea class = 'borderedStyle' id = "setMessage" name = "message" rows="8" cols="30"></textarea><!-- <input type='text' value='' placeholder='Megjegyzés' name='note'> --></td></tr>



<tr><td colspan = "2"><button id = "add">Küldés!</button></td></tr>





</table>