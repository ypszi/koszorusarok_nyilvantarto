<head>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
	<script type="text/javascript" src="js/protea_functions.js"></script>
<style type="text/css">

#shops th{
	padding:10px 0px;
}

#shops td{
	padding:2px 5px;
}

#wreathtype_popup {
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

</head>
<body>
<div class="title">
	<input type="button" style="margin-bottom: 5px; float:right;" value="Új Koszorú típus" onclick="new_wreath_type();" class="button">
	<span class="firstWord">Frissítés </span> - Koszorú árak újraszámítása
</div>

	<div id="wreathtype_popup">
	</div>
	
<?php 
	$query = "	SELECT id,type 
				FROM `base_wreath_type`
				ORDER BY type ASC;";
	$result = mysql_query($query) or die (mysql_error());
	echo '<table id="shops">
			<tr>
				<th>Koszorú típus</th>
				<th>Darabszám</th>
				<th>Módosítás</th>
			</tr>';

		$id = 0;
		$wreath_count = 0;
		while ($row = mysql_fetch_assoc($result)) {
			echo "<tr id='shops".$id."'>
					<form id='shopsform".$id."' method='POST' >";
			echo "<td> <input type='text' class='inputStyle' value='" . $row["type"] . "' name='shopname' readonly></td>";

			$query_wreath = "SELECT COUNT(special_wreath.id) AS db 
						FROM special_wreath, base_wreath
						WHERE special_wreath.base_wreath_id = base_wreath.id AND base_wreath.type = '".$row['id']."'";
									
			$result_wreath = mysql_query($query_wreath) or die (mysql_error());
			while ($row_wreath = mysql_fetch_assoc($result_wreath)) {
				echo "<td> <input type='text' class='inputStyle' value='" . $row_wreath["db"] . " db' name='shopname' readonly></td>";
				$wreath_count += $row_wreath["db"];

			}
			echo "<td><a href='http://nyilvantarto.koszorusarok.hu/menu-main/menu-setting-submenu/refresh/check-pdf.php?id=".$row["id"]."' class='button' target='_blank'>Frissít</a></td>";
			echo "</form>";
			echo "</tr>";
			$id++;
		}	
	echo '</table>';
?>
</body>