<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
	<script type="text/javascript" src="js/protea_functions.js"></script>
<style type="text/css">
#floweredit tr:nth-child(2n) {
	background: #e2f1cb;
}
#floweredit td input[type="text"] {
	width: 158px;
}

#floweredit_popup {
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
	<span class="firstWord">Beállítások</span> Virágok
</div>

	<div id="floweredit_popup">
	</div>
<?php
	echo "<input type='button' style='margin-bottom: 5px;' onClick='addFlowerTR();' value='Új virág!' class='button' >";
	
	$_SESSION['newflower'] = 0;
	$max_id = mysql_query("SELECT id FROM  `flower` ORDER BY id DESC LIMIT 0, 1");
		while ($row = mysql_fetch_assoc($max_id)) {
			$_SESSION['newflower'] = $row['id'];
		}

	$query = "SELECT * FROM `flower` ORDER BY type ASC;";
	$result = mysql_query($query) or die (mysql_error());
	echo "<table id='floweredit'>";
	echo "<tr><td> ID </td> <td> Virág </td> <td> Szín </td> <td> Ár </td> <td> Módosítás </td> <td> Törlés </td> </tr>";

	$id = 0;
	while ($row = mysql_fetch_assoc($result)) {
		$flower_id = $row['id'];
		$flower_type = $row['type'];
		$flower_color = $row['color'];
		$flower_price = $row['price'];

		echo "<tr id='flower$id'>";
		echo "<form id='flowereditform$id' method='POST' >";
		echo "<td> <input type='text' class='inputStyle' value='$flower_id' name='flowerid' readonly style='width: 75px;'></td>";
		echo "<td> <input type='text' class='inputStyle' value='$flower_type' name='flowertype' readonly></td>";
		echo "<td> <input type='text' class='inputStyle' value='$flower_color' name='flowercolor' readonly></td>";
		echo "<td> <input type='text' class='inputStyle' value='$flower_price' name='flowerprice' readonly></td>";
		echo "<td id='modbutton$id'> <input type='button' onClick='editFlower($id);' value='Szerkeszt' class='button' ></td>";
		echo "<td id='delbutton$id'> <input type='button' onClick='delFlower($id);' value='Töröl' class='button' ></td>";
		echo "</form>";
		echo "</tr>";
		$id++;
	}
	echo "</table>";
?>