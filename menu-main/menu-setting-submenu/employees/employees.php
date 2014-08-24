<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
	<script type="text/javascript" src="js/protea_functions.js"></script>
<link href="css/alertwindow.css" rel="stylesheet" type="text/css" media="all" />
<style type="text/css">
#useredit tr:nth-child(2n) {
	background: #e2f1cb;
}
#useredit td input[type="text"] {
	width: 158px;
}

#user_popup {
	display: none;
	padding: 5px 5px 5px 15px;
	border-radius: 5px;
	width: 380px;
	height: 300px;
	position: fixed;
	margin: 0px auto;
	left: 25%;
	top: 14%;
	box-shadow: 5px 5px 5px #555;
	background: #c9dba6;
	background: -moz-linear-gradient(top, #c9dba6 0%, #7a9d74 100%);
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#c9dba6), color-stop(100%,#7a9d74));
	background: -webkit-linear-gradient(top, #c9dba6 0%,#7a9d74 100%);
	background: -o-linear-gradient(top, #c9dba6 0%,#7a9d74 100%);
	background: -ms-linear-gradient(top, #c9dba6 0%,#7a9d74 100%);
	background: linear-gradient(to bottom, #FBFFF2 0%,#C3D5C0 100%);
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#c9dba6', endColorstr='#7a9d74',GradientType=0 );
	z-index: 5;
	}

#user_th {
	width: 97%;
}

#user_th td {
	width: 6%;
}

.big_padd {
	padding-left: 42px;
}

.small_padd {
	padding-left: 10px;
}
</style>

<div class="title">
	<span class="firstWord">Beállítások</span> Alkalmazottak
</div>

	<div id="user_popup">
	</div>

	<input type='button' onClick='addUserTR()' value='Új alkalmazott!' class='button' style="margin-bottom: 5px;" >

<?php
	
	echo'<div id="alertwindow"></div>';

	$_SESSION['newuser'] = 0;
	$max_id = mysql_query("SELECT id FROM  `users` ORDER BY id DESC LIMIT 0, 1");
		while ($row = mysql_fetch_assoc($max_id)) {
			$_SESSION['newuser'] = $row['id'];
		}

	$query = "SELECT * FROM `users` ORDER BY id;";
	$result = mysql_query($query) or die (mysql_error());
	echo "<table id='user_th'>";
	echo "<tr>
			<td>#</td> 
			<td >Név</td> 
			<td >Nyomtatási Név</td> 
			<td class='big_padd'>Beosztás</td> 
			<td class='big_padd'>Órabér</td> 
			<td >Bolt</td> 
			<td >Kép</td> 
			<td class='big_padd'>Szín</td> 
			<td >Engedélyezett</td> 
			<td >Jogosultság</td> 
		</tr></table><table id='useredit'>";

	while ($row = mysql_fetch_assoc($result)) {
		$userid = $row["id"];
		$name = $row["name"];
		$print_name = $row["print_name"];
		$title = $row["title"];
		$salary = $row["salary"];
		$shop = $row["shop"];
		$picture = $row["picture"];
		$color = $row["color"];
		$enable = $row["enable"];
		$access_level = $row["access_level"];

		$buttonid = $userid;	

		echo "<tr id='user$userid'>";
			echo "<td><form id='usereditform$userid' method='POST' ><table><tr><td> ";
				echo "<td> <input type='text' class='inputStyle' value='$userid' name='userid' style='width: 15px;' readonly ></td>
					<td> <input type='text' class='inputStyle' value='$name' name='username' style='width: 80px;' readonly ></td>
					<td> <input type='text' class='inputStyle' value='$print_name' name='print_name' style='width: 120px;' readonly ></td>
					<td> <input type='text' class='inputStyle' value='$title' name='title' style='width: 110px;' readonly ></td>
					<td> <input type='text' class='inputStyle' value='$salary' name='salary' style='width: 40px;' readonly ></td>
					<td> <input type='text' class='inputStyle' value='$shop' name='shop' style='width: 20px;' readonly ></td>
					<td> <input type='text' class='inputStyle' value='$picture' name='picture' style='width: 110px;' readonly ></td>
					<td> <input type='text' class='inputStyle' value='$color' name='color' id='color$userid' style='width: 45px;' readonly ></td>
					<td> <input type='text' class='inputStyle' value='$enable' name='enable' style='width: 15px;' readonly ></td>
					<td> <input type='text' class='inputStyle' value='$access_level' name='access_level' style='width: 45px;' readonly ></td>";
				echo "<td id='modbutton$buttonid'> <input style='background-image:url(".$conf_path_abs."img/icons/Edit-icon.png); background-repeat:no-repeat; width:32px; height: 32px;' type='button' onClick='editUser($userid);' class='button' title='Módosítás' /></td>";
				//echo "<td id='delbutton$buttonid'> <input style='background-image:url(".$conf_path_abs."img/icons/Delete-icon.png); background-repeat:no-repeat; width:32px; height: 32px;' type='button' onClick='delUser($userid);' class='button' title='Törlés'/></td>";
				echo "<td id='forgot_pw$buttonid'> <input style='background-size:28px 28px; background-image:url(".$conf_path_abs."img/icons/Password-icon.png); background-repeat:no-repeat; width:32px; height: 32px;' type='button' onClick='pw_reset($userid);' class='button' title='Jelszó visszaállítás'> </td>";
			echo "</td></tr></table></form></td>";

		echo "</tr>";
		$buttonid++;
	}
	echo "</table>";
?>