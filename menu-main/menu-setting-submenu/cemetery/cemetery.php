<style>#cemetery_popup {	display: none;	padding: 5px 5px 5px 15px;	border-radius: 5px;	width: 380px;	height: 200px;	position: fixed;	margin: 0px auto;	left: 25%;	top: 14%;	box-shadow: 5px 5px 5px #555;	background: #c9dba6;	background: -moz-linear-gradient(top, #c9dba6 0%, #7a9d74 100%);	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#c9dba6), color-stop(100%,#7a9d74));	background: -webkit-linear-gradient(top, #c9dba6 0%,#7a9d74 100%);	background: -o-linear-gradient(top, #c9dba6 0%,#7a9d74 100%);	background: -ms-linear-gradient(top, #c9dba6 0%,#7a9d74 100%);	background: linear-gradient(to bottom, #FBFFF2 0%,#C3D5C0 100%);	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#c9dba6', endColorstr='#7a9d74',GradientType=0 );	z-index: 5;}#cemeteryedit tr:nth-child(2n) {	background: #e2f1cb;}#cemeteryedit td input[type="text"] {	width: 158px;}#cemetery_th, #cemeteryedit, #cemeteryedit table {	width: 100%;}#cemeteryedit_th td {	width: 6%;}.big_padd {	padding-left: 42px;}.small_padd {	padding-left: 10px;}</style><div class="title">
	<span class="firstWord">Temetők</span> Listája
</div>

	<div id="cemetery_popup">
	</div>

	<input type='button' onClick='addcemeteryTR()' value='Új Temető!' class='button' style="margin-bottom: 5px;" >

<?php
	
	echo'<div id="alertwindow"></div>';

	$_SESSION['newcemetery'] = 0;
	$max_id = mysql_query("SELECT id FROM  `cemetery` ORDER BY id DESC LIMIT 0, 1");
		while ($row = mysql_fetch_assoc($max_id)) {
			$_SESSION['newcemetery'] = $row['id'];
		}

	$query = "SELECT * FROM `cemetery` ORDER BY name;";
	$result = mysql_query($query) or die (mysql_error());
	echo "<table id='cemetery_th'>";
	echo "<tr>
			<td>#</td> 
			<td>Temető Neve</td> 
			<td>Temetető Címe</td> 
			<td></td>
			<td></td>
		</tr>
		</table>

		<table id='cemeteryedit'>";

	while ($row = mysql_fetch_assoc($result)) {
		$cemeteryid = $row["id"];
		$cemeteryname = $row["name"];
		$cemeteryaddress = $row["address"];

		$buttonid = $cemeteryid;	

		echo "<tr id='cemetery$cemeteryid'>";
			echo "<td><form id='cemeteryeditform$cemeteryid' method='POST' ><table><tr><td> ";
				echo "<td> <input type='text' class='inputStyle' value='$cemeteryid' name='id' style='width: 15px;' readonly ></td>
					<td> <input type='text' class='inputStyle' value='$cemeteryname' name='name' style='width: 180px;' readonly ></td>
					<td> <input type='text' class='inputStyle' value='$cemeteryaddress' name='address' style='width: 220px;' readonly ></td>";
				echo "<td id='modbutton$buttonid'> <input style='background-image:url(".$conf_path_abs."img/icons/Edit-icon.png); background-repeat:no-repeat; width:32px; height: 32px;' type='button' onClick='editcemetery($cemeteryid);' class='button' title='Módosítás' /></td>";
			echo "</td></tr></table></form></td>";

		echo "</tr>";
		$buttonid++;
	}
	echo "</table>";
?>