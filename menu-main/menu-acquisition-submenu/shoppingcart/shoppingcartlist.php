<link rel="stylesheet" type="text/css" href="css/orderstyle.css">

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
		$query = "SELECT id, name, note, date FROM shopping_cart WHERE id=".$_GET['id']." ORDER BY name ASC;";
		$result = mysql_query($query) or die(mysql_error());

		while ($row = mysql_fetch_assoc($result)) {
			$date = $row['date'];
			$listnote = $row['note'];
		}
	 ?>
	<p style="font: normal 22px 'Arial'; color: #89a583; padding: 20px 20px 5px 20px;"> <?php echo $listnote ?> </p>
	</div>
	
	<div>
		<div id="exit" class="exit" onclick="$('#newShopping_list').toggle();" style="display: block;">X</div>
		<form method="POST" action="menu-main/menu-acquisition-submenu/shoppingcart/mod_shoppinglist.php">
			<table style="margin: 30px 15px 15px 15px;">
			<tr>
				<td>Beszerzés időpontja:</td>
				<td><input type="text" class="borderedStyle" style="width: 400px" name="listdate" value="<?php echo $date; ?>"></td>
			</tr>
			<tr>
				<td>Lista megjegyzése:</td>
				<td><input type="text" class="borderedStyle" style="width: 400px" name="listnote" value="<?php echo $listnote; ?>"></td>
			</tr>
			<tr>
				<td>
					<input type="button" class="plus" value="Új sor hozzáadása" onclick="newShoppingListRow();">
				</td>
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
				<th>
				</th>
			</tr>
			<?php 
				$query = "SELECT id, shopping_cart_id, product, required_number, buying_number, price, sale_price, note
						FROM shopping_cart_item 
						WHERE shopping_cart_id = ".$_GET['id']." AND archive = 0 
						ORDER BY product ASC";
				$result = mysql_query($query) or die(mysql_error());

				echo "<input type='hidden' name='list_id' value='".$_GET['id']."'> ";
				echo "<input type='hidden' name='shopping_cart_id' value='".$_GET['id']."'> ";
				$item_num = mysql_num_rows($result);
				echo "<input type='hidden' name='item_num' id='item_num' value='".$item_num."'>";

				$index = 1;
				while ($row = mysql_fetch_assoc($result)) {
					echo "<tr id='shopping_list_".$index."'>";
						$index_str = (($index<10)?"0":"") . $index;
						echo "<td>";
						echo "#".$index_str;
						echo "</td>";
	
						echo "<td>";
						echo "<input type='input' class='borderedStyle' style='width:240px;' name='product[]' value='".$product = $row['product']."' >";
						echo "</td>";

						echo "<td>";
						echo "<input type='input' class='borderedStyle' style='width:65px;' name='required_number[]' value='".$required_number = $row['required_number']."' >";
						echo "</td>";

						echo "<td>";
						echo "<input type='input' class='borderedStyle' style='width:65px;' name='buying_number[]' value='".$buying_number = $row['buying_number']."' >";
						echo "</td>";

						echo "<td>";
						echo "<input type='input' class='borderedStyle' style='width:80px;' name='price[]' value='".$price = $row['price']."' >";
						echo "</td>";

						echo "<td>";
						echo "<input type='input' class='borderedStyle' style='width:80px; font-weight: bold;' name='sale_price[]' value='".$sale_price = $row['sale_price']."' >";
						echo "</td>";
						
						echo "<td>";
						echo "<input type='button' style='padding-left: 5px;padding-right: 5px;' name='addRow' class='plus' value='+' onclick='newShoppingListRow();'>";
						echo "</td>";

						echo "<td>";
						echo "<input type='button' style='padding-left: 6px;padding-right: 6px;' name='delRow' class='minus' value='-' onclick='delActualShoppingListRow($index);'>";
						echo "</td>";
					echo "</tr>";
					$index++;
				}
			 ?>
			</table>
			<table style="margin: 30px 15px 15px 15px;">
			 <tr>
			 	<td>
					<input type="submit" class="forward" value="Módosít">
			 	</td>
			 </tr>
			</table>
		</form>
	</div>
</body>