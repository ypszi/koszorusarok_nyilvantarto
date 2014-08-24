<?php 
	$_SESSION['newwreathtype'] = 0;
	$max_id = mysql_query("SELECT id FROM  `base_wreath` ORDER BY id DESC LIMIT 0, 1");
		while ($row = mysql_fetch_assoc($max_id)) {
			$_SESSION['newwreathtype'] = $row['id'];
		}
?>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
	<script type="text/javascript" src="js/protea_functions.js"></script>
<style type="text/css">

#wbedit tr:nth-child(2n) {
	background: #e2f1cb;
}
#wbedit td input[type="text"] {
	width: 87px;
}

#wreathtype_popup {
	display: none;
	padding: 5px 5px 5px 15px;
	border-radius: 5px;
	width: 380px;
	height: 350px;
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
	<span class="firstWord">Koszorú </span>alapok
</div>

	<div id="wreathtype_popup">
	</div>

<?php
	echo "<input type='button' onClick='addWreathType();' value='Új Koszorú alap!' class='button' style='margin-bottom: 5px;'>";

	$query = "SELECT * FROM `base_wreath`";
	$result = mysql_query($query) or die (mysql_error());
	echo "<table id='wbedit'>";
	echo "<tr><td> ID </td> <td> Koszorú alap </td> <td> Méret </td> <td> Virág minimum </td> <td> Virág maximum </td> <td> Ár </td> <td> Módosítás </td> <td> Törlés </td> </tr>";

	while ($row = mysql_fetch_assoc($result)) {
		$wreathb_id = $row['id'];
		$resultbwt = mysql_query("SELECT type FROM `base_wreath_type` WHERE id=".$row['type']);
		while ($rowb_type = mysql_fetch_assoc($resultbwt)) {
			$wreathb_type = $rowb_type['type'];
		}
		$wreathb_size = $row['size'];
		$wreathb_f_min = $row['flower_min'];
		$wreathb_f_max = $row['flower_max'];
		$wreathb_price = $row['price'];

		$buttonid = $wreathb_id;
		
		echo "<tr id='wb$wreathb_id'>";
		echo "<form id='wbeditform$wreathb_id' method='POST' >";
		echo "<td> <input type='text' class='inputStyle' value='$wreathb_id' name='wreathbid' readonly></td>";
		echo "<td> <input type='text' class='inputStyle' value='$wreathb_type' name='wreathbtype' readonly></td>";
		echo "<td> <input type='text' class='inputStyle' value='$wreathb_size' name='wreathbsize' readonly></td>";
		echo "<td> <input type='text' class='inputStyle' value='$wreathb_f_min' name='wreathbfmin' readonly></td>";
		echo "<td> <input type='text' class='inputStyle' value='$wreathb_f_max' name='wreathbfmax' readonly></td>";
		echo "<td> <input type='text' class='inputStyle' value='$wreathb_price' name='wreathbprice' readonly></td>";
		echo "<td id='modbutton$buttonid'> <input type='button' onClick='editWreathType($wreathb_id);' value='Szerkeszt' class='button' ></td>";
		echo "<td id='delbutton$buttonid'> <input type='button' onClick='delWreathType($wreathb_id);' value='Töröl' class='button' ></td>";
		echo "</form>";
		echo "</tr>";
		$buttonid++;
	}
	echo "</table>";
?>