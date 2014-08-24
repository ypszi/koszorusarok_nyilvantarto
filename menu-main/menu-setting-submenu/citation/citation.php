<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
	<script type="text/javascript" src="js/protea_functions.js"></script>
<style type="text/css">
#citation tr:nth-child(2n) {
	background: #e2f1cb;
}
#citation td input[type="text"] {
	width: 158px;
}

#citation_popup {
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
	<span class="firstWord">Koszorú</span> Idézetek
</div>

	<div id="citation_popup">
	</div>

<?php
	echo "<input type='button' style='margin-bottom: 5px;' onClick='addcitTR();' value='Új idézet!' class='button' >";

	$_SESSION['newcit'] = 0;
	$max_id = mysql_query("SELECT id FROM  `citation` ORDER BY id DESC LIMIT 0, 1");
		while ($row = mysql_fetch_assoc($max_id)) {
			$_SESSION['newcit'] = $row['id'];
		}

	$query = "SELECT * FROM `citation` ORDER BY text ASC;";
	$result = mysql_query($query) or die (mysql_error());
	echo '<table id="citation">
			<tr>
				<td>#</td>
				<td>Idézet</td>
				<td>Módosítás</td>
				<td>Törlés</td>
			</tr>';

	$id = 0;
	while ($row = mysql_fetch_assoc($result)) {		
		echo "<tr id='citation$id'>";
		echo "<form id='citationform$id' method='POST' >";
		echo "<td> <input type='text' class='inputStyle' value='".$row['id']."' name='citid' readonly style='width: 25px;'></td>";
		echo "<td> <input type='text' class='inputStyle' value='".$row['text']."' name='cittext' readonly style='width: 560px;'></td>";
		echo "<td id='modbutton$id'> <input type='button' onClick='editCit($id);' value='Szerkeszt' class='button' ></td>";
		echo "<td id='delbutton$id'> <input type='button' onClick='delCit($id);' value='Töröl' class='button' ></td>";
		echo "</form>";
		echo "</tr>";
		$id++;
	}
	echo "</table>";

?>