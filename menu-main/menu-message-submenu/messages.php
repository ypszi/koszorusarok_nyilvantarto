<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.0/jquery-ui.min.js"></script>

<script>
	$(document).ready(function(){

		$("#delete_messages").on("click", function(){
			var recipient_messages = new Array();
			var sender_messages = new Array();

			if (confirm("Biztos törlöd?")) {
				recipient_messages = $("input[name='recieved_messages_to_delete[]']:checked:enabled").map(function(){
					return this.value;
				}).get();

				sender_messages = $("input[name='sent_messages_to_delete[]']:checked:enabled").map(function(){
					return this.value;
				}).get();
				
				$.ajax({
					type: "GET",
					url: "menu-main/menu-message-submenu/delete_messages.php",
					data: {
						recipient_messages : recipient_messages,
						sender_messages: sender_messages
					},
					success: function(data){
						location.reload();
					}
				});
			}
		});

		$("#newMessageButton").on("click", function(){

			$.ajax({

				type: "GET",

				url: "menu-main/menu-message-submenu/addMessage.php",

				success: function(data){

					$('#newMessage').html(data);

					$('#newMessage').toggle();

				}

			}); 

		});



		$(".msgDelButton").on("click", function(){

			msgID = $(this).attr("messageID");

			msgSide = $(this).attr("messageSide");

			if(confirm('Biztosan törli?')) {

				$.ajax({

					type: "POST",

					url: "menu-main/menu-message-submenu/delMessage.php",

					data: {

						msgID: msgID,

						msgSide: msgSide

					},

					success: function(data){

						location.reload();

					}

				});

		 	}

		});



		$(".unread").on("click", function(){

			if($(this).attr("clickDisabled") != 1) {

				msgID = $(this).attr("messageID");

				$.ajax({

					type: "POST",

					url: "menu-main/menu-message-submenu/markAsRead.php",

					data: {

						msgID: msgID

					},

					success: function(data){

					}

				});

				$(this).removeClass("unread");

				$(this).addClass("read");

			}

		});

	});



</script>



<?php

	include 'config.php';



	$queryRecieved = "SELECT id, sender, recipient, message, readed, rec_del, sen_del, created, reply_id, archiveRecipient

		FROM message

		WHERE recipient = '" . $_SESSION['logged_in'] . "' AND archiveRecipient = 0 AND rec_del = 0 ORDER BY created DESC;";

	$resultRecieved = mysql_query($queryRecieved) or die (mysql_error());



	$querySent = "SELECT id, sender, recipient, message, readed, rec_del, sen_del, created, reply_id, archiveSender

		FROM message

		WHERE sender = '" . $_SESSION['logged_in'] . "' AND archiveSender = 0 AND sen_del = 0 ORDER BY created DESC;";

	$resultSent = mysql_query($querySent) or die (mysql_error());





?>

<div id = "messages">

	<div class = "biggerTitle"><span class = "green">Beérkező</span> <span class = "red">üzenetek</span></div>

		<br>

		<table id = "recievedMessages">

			<tr>
				<th></th>

				<th class = "msgHeader msgSender"><p>Küldő</p></th>

				<th class = "msgHeader msgTimeOfSending"><p>Küldés ideje</p></th>

				<th class = "msgHeader msgMessage"><p>Üzenet</p></th>

				<th class = "msgHeader msgRead"><p>Olvasva</p></th>

				<th class = "msgHeader msgDelete"><p>Törlés</p></th>

			</tr>

<?php
	$i = 1;

	while ($row = mysql_fetch_assoc($resultRecieved)) {

		$query_user = "SELECT name FROM users WHERE id = '" . $row["sender"] . "'";

		$res_user = mysql_query($query_user) or die(mysql_error());

		$row_user = mysql_fetch_assoc($res_user);

	echo "

			<tr>
				<td>".$i.". <input type='checkbox' style='margin: 3px 0px 3px 0px;' class='print_offer' name='recieved_messages_to_delete[]' value='".$row['id']."'></td>

				<td>" . $row_user["name"] . "</td>

				<td>" . $row["created"] . "</td>

				<td>" . $row["message"] . "</td>

				<td>" . (($row["readed"] == 1)?'<div messageID = "'.$row["id"].'" class = "read"></div>':'<div messageID = "'.$row["id"].'" class = "unread"></div>') . "</td>

				<td><button messageSide = 'recipient' messageID = '".$row["id"]."' class = 'msgDelButton'>X</button></td>

			</tr>

	";

	$i++;

	}

	echo "

		</table>

		<br><br><br>";

?>

	<div class = "biggerTitle"><span class = "green">Küldött</span> <span class = "red">üzenetek</span></div>

		<br>

		<table id = "sentMessages">

			<tr>
				<th></th>

				<th class = "msgHeader msgSender"><p>Fogadó</p></th>

				<th class = "msgHeader msgTimeOfSending"><p>Küldés ideje</p></th>

				<th class = "msgHeader msgMessage"><p>Üzenet</p></th>

				<th class = "msgHeader msgRead"><p>Olvasva</p></th>

				<th class = "msgHeader msgDelete"><p>Törlés</p></th>

			</tr>



<?php
	$i = 1;
	while ($row = mysql_fetch_assoc($resultSent)) {

		$query_user = "SELECT name FROM users WHERE id = '" . $row["recipient"] . "'";

		$res_user = mysql_query($query_user) or die(mysql_error());

		$row_user = mysql_fetch_assoc($res_user);

	echo "

			<tr>
				<td>".$i.". <input type='checkbox' style='margin: 3px 0px 3px 0px;' class='print_offer' name='sent_messages_to_delete[]' value='".$row['id']."'></td>

				<td>" . $row_user["name"] . "</td>

				<td>" . $row["created"] . "</td>

				<td>" . $row["message"] . "</td>

				<td>" . (($row["readed"] == 1)?'<div clickDisabled = "1" messageID = "'.$row["id"].'" class = "read"></div>':'<div clickDisabled = "1" messageID = "'.$row["id"].'" class = "unread"></div>') . "</td>

				<td><button messageSide = 'sender' messageID = '".$row["id"]."' class = 'msgDelButton'>X</button></td>

			</tr>

	";
	$i++;
	}

?>

</table>

</div>

<div id="newMessage" style="z-index: 6; overflow-x: hidden;">

</div>

<?php 
echo '<div style="position: fixed; top: 200px; right: 0%; width: 66px; background-color: #c0d4a1; color: #fff; padding: 5px; box-shadow: #999 0px 0px 10px 3px;">
	<div sytle="padding-top:5px;">
		<button messageSide = "recipient" name="delete_messages" value="" style="border: none; border-radius: 4px; background-image: url(../img/icons/BigDelete-icon.png); background-repeat: no-repeat; width: 64px; height: 64px; vertical-align: middle; padding: 0px !important; margin: 0px !important;" id="delete_messages" title="törlés"></button>
		<div style="font-weight:bold; color: #304a63; text-align: center;">Törlés</div>
	</div>
</div>'; ?>