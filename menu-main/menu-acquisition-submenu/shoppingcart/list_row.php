<?php
	$next_item_num = $_GET['item_num']+1;
	echo "<td >";
	echo "#".(($next_item_num<10)?"0":"").$next_item_num;
	echo "</td>";

	echo "<td>";
	echo "<input type='input' class='borderedStyle' style='width:240px;' name='product[]' value='' >";
	echo "</td>";

	echo "<td>";
	echo "<input type='input' class='borderedStyle' style='width:65px;' name='required_number[]' value='' >";
	echo "</td>";

	echo "<td>";
	echo "<input type='input' class='borderedStyle' style='width:65px;' name='buying_number[]' value='' >";
	echo "</td>";

	echo "<td>";
	echo "<input type='input' class='borderedStyle' style='width:80px;' name='price[]' value='' >";
	echo "</td>";

	echo "<td>";
	echo "<input type='input' class='borderedStyle' style='width:80px; font-weight: bold;' name='sale_price[]' value='' >";
	echo "</td>";

	echo "<td>";
	echo "<input type='button' name='addRow' style='padding-left: 5px;padding-right: 5px;' class='plus' value='+' onclick='newShoppingListRow();'>";
	echo "</td>";

	echo "<td>";
	echo "<input type='button' name='delRow' style='padding-left: 6px;padding-right: 6px;' class='minus' value='-' onclick='delActualShoppingListRow(".$next_item_num.");'>";
	echo "</td>";
?>