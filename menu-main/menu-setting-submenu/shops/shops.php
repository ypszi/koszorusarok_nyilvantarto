<head>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
	<script type="text/javascript" src="js/protea_functions.js"></script>

</head>
<body>
<div class="title">
	<span class="firstWord">Beállítások</span> Boltok
</div>
	
<?php 

	$query="SELECT * FROM  `shops`";
	$result = mysql_query($query) or die (mysql_error());
	echo '<table id="shops">
			<tr>
				<td>#</td>
				<td>Név</td>
				<td>Engedélyezett</td>
				<td>Módosítás</td>
				<td>Mégse</td>
			</tr>';

		$id = 0;
		while ($row = mysql_fetch_assoc($result)) {
			echo "<tr id='shops".$id."'>
					<form id='shopsform".$id."' method='POST' >";
			echo "<td> <input type='text' class='inputStyle' value='" . $row["id"] . "' name='shopsid' readonly style='width: 25px;'></td>";
			echo "<td> <input type='text' class='inputStyle' value='" . $row["name"] . "' name='shopname' readonly></td>";
			echo "<td> <input type='text' class='inputStyle' value='" . $row["enable"] . "' name='enable' readonly></td>";
			echo "<td id='modbutton$id'> <input type='button' onClick='editShops($id);' value='Szerkeszt' class='button' ></td>";
			echo "<td id='cancelbutton$id'> </td>";
			echo "</form>";
			echo "</tr>";
			$id++;
		}	
	echo '</table>';
?>
	1 - igen <br>
	0 - nem
</body>