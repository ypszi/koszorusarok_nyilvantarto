<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
	<script type="text/javascript" src="js/protea_functions.js"></script>
<style type="text/css">
#tapetitle tr:nth-child(2n) {
	background: #e2f1cb;
}
#tapetitle td input[type="text"] {
	width: 158px;
}

#tapetitle_popup {
	display: none;
	padding: 5px 5px 5px 15px;
	border-radius: 5px;
	width: 380px;
	height: 250px;
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
</style>

<div class="title">
	<span class="firstWord">Szalag</span> Feliratok
</div>

	<div id="tapetitle_popup">
	</div>

	<input type='button' onClick='addtapeTR();' value='Új szalag felirat!' class='button' style="margin-bottom: 5px;" >

<?php
	$_SESSION['newtape'] = 0;
	$max_id = mysql_query("SELECT id FROM  `tape_title` ORDER BY id DESC LIMIT 0, 1");
		while ($row = mysql_fetch_assoc($max_id)) {
			$_SESSION['newtape'] = $row['id'];
		}

	$query = "SELECT * FROM `tape_title` ORDER BY text ASC";
	$result = mysql_query($query) or die (mysql_error());
	echo '<table id="tapetitle">
			<tr>
				<td>#</td>
				<td>Idézet</td>
				<td>Módosítás</td>
				<td>Törlés</td>
			</tr>';

	$id = 0;
	while ($row = mysql_fetch_assoc($result)) {
		echo "<tr id='tape$id'>";
		echo "<form id='tapeform$id' method='POST' >";
		echo "<td> <input type='text' class='inputStyle' value='".$row['id']."' name='tapeid' style='width: 25px;' readonly></td>";
		echo "<td> <input type='text' class='inputStyle' value='".$row['text']."' name='tapetext' style='width: 555px;' readonly></td>";
		echo "<td id='modbutton$id'> <input type='button' onClick='editTape($id);' value='Szerkeszt' class='button' ></td>";
		echo "<td id='delbutton$id'> <input type='button' onClick='delTape($id);' value='Töröl' class='button' ></td>";
		echo "</form>";
		echo "</tr>";
		$id++;
	}
	echo "</table>";

?>