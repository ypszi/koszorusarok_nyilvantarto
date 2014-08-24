	<link rel="stylesheet" type="text/css" href="css/orderstyle.css">
	<link rel="stylesheet" href="css/calendar/default.css" type="text/css">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
	<script type="text/javascript" src="js/timepicker/include/jquery-1.9.0.min.js"></script>
	<script type="text/javascript" src="js/zebra_datepicker.js"></script>
	<script type="text/javascript" src="js/zebra_datepicker.src.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$('input.datepicker').Zebra_DatePicker();
		});
	</script>

	<style type="text/css">
	#shopping_list tr {
	}
	#shopping_list tr:nth-child(2n) {
		background-color: #fff;
		border-style:solid;
		border-width:2px;
		border-color: #e2f1cb;
	}
	</style>

<body>
	<div class="title">
	<?php 
	include '../../../config.php';
	 ?>
	<p style="font: normal 22px 'Arial'; color: #89a583; padding: 5px 20px 3px 20px;"> Új bevásárló lista </p>
	</div>
	
	<div>
		<div id="exit" class="exit" onclick="$('#newShopping_list').toggle();" style="display: block;">X</div>
		<form method="POST" action="menu-main/menu-acquisition-submenu/shoppingcart/new_shoppinglist.php" onsubmit="return checkShoppingList();">
			<table style="margin: 5px 15px 5px 15px;">
				<tr>
					<td>Beszerzés időpontja:</td>
					<td><input type="text" name="date" id="max_date" class="datepicker borderedStyle" value=""></td>
				</tr>
				<tr>
					<td>Lista megjegyzése:</td>
					<td><input type="text" rows="4" cols="50" class="borderedStyle" style="width: 400px; heigh:20px;"  name="listnote" value=""></td>
				</tr>
			</table>
			<table id="shopping_list">
			<tr>
				<th>
				</th>
				<th>
					Termék neve
				</th>
				<th>
					Igényelt db
				</th>
				<th>
					Megvett db
				</th>
				<th>
					Beszerzési ár
				</th>
				<th style="font-weight: bold;">
					Eladási ár
				</th>
				<th>
				</th>
				</th>
				</th>
			</tr>
			<?php 

				echo "<input type='hidden' name='item_num' id='item_num' value='1'>";

					echo "<tr id='shopping_list_1'>";
						echo "<td >";
						echo "#01";
						echo "</td>";
						
						echo "<td >";
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
						echo "<input type='button' style='padding-left: 5px;padding-right: 5px;' name='addRow' class='plus' value='+' onclick='newShoppingListRow();'>";
						echo "</td>";

						echo "<td>";
						echo "<input type='button' style='padding-left: 6px;padding-right: 6px;' name='delRow' class='minus' value='-' onclick='delActualShoppingListRow(1);'>";
						echo "</td>";
						
					echo "</tr>";
			 ?>
			</table>
			<table style="margin: 30px 15px 15px 15px;">
			 <tr>
			 	<td>
					<input type="submit" class="forward" value="Hozzáad">
			 	</td>
			 </tr>
			</table>
		</form>
	</div>
</body>