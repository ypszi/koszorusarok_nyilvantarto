<script>
    $(document).ready(function() {

        $(".datepicker").Zebra_DatePicker();

        $("#mod").on("click", function() {
            var id = $("#mod").val();
            var date = $("#setDate").val();
            var shop = $("#setShop").val().charAt(0);
            var price = $("#setPrice").val();
            var wreath_price = $("#setWreathPrice").val();
            var note = $("#setNote").val();
//            alert(date + " " + shop + " " + price + " " + note);

            $.ajax({
                type: "POST",
                url: "menu-main/menu-statistic-submenu/statistic/modIncome.php",
                data: {
                    id: id,
                    date: date,
                    shop: shop,
                    price: price,
					wreath_price: wreath_price,
                    note: note
                },
                success: function(data) {
//                    $("#acquisition").html(data);
                    location.reload();
                }
            });
        });
    });
</script>

<div id="exit" class="exit" onclick="document.getElementById('newAcquisition').style.display = 'none';" style="display: block;">
    X
</div>

<p style="font: normal 22px 'Arial'; color: #89a583; padding: 20px 20px 5px 20px;">Napi kasszazárás módosítása</p>

<?php
include '../../../config.php';

$query = "SELECT * FROM other_incoming WHERE id=".$_GET['id'].";";
$result = mysql_query($query) or die(mysql_error());
while ($row = mysql_fetch_array($result)) {

	echo "<table id = 'addOutlayTable'>";
	echo "<tr><td>Dátum:</td><td><input class = 'datepicker borderedStyle' id = 'setDate' type='text' value='".$row["date"]."' placeholder='Dátum' name='date'></td></tr>";
	echo "<tr><td>Típus:</td><td><select id = 'setShop' name='shop'>
			<option disabled >Válasszon boltot!</option>";

			
			$query_shops = "SELECT *
								FROM shops ORDER BY id ASC";
	$result_shops = mysql_query($query_shops) or die(mysql_error());
	while ($row_shops = mysql_fetch_array($result_shops)) {
		if ($row["shop"] != $row_shops["id"]){
			echo '<option >' . $row_shops["id"] . " - " . $row_shops["name"] . '</option>';
		}else{
			echo '<option selected>' . $row_shops["id"] . " - " . $row_shops["name"] . '</option>';
		}
	}
	echo "</select></td></tr>";
	?>
	<tr><td>Ár:</td><td><input id = 'setPrice' type='text' value='<?php echo $row["price"];?> ' placeholder='Ár' name='price'></td></tr>
	<tr><td>Koszorú bevétel:</td><td><input id = 'setWreathPrice' type='text' value='<?php echo $row["wreath_price"]; ?>' placeholder='Ár' name='price'></td></tr>
	<tr><td>Megjegyzés:</td><td><textarea id = "setNote" name = "note" rows="3" cols="30"><?php echo $row["note"]; ?></textarea><!-- <input type='text' value='' placeholder='Megjegyzés' name='note'> --></td></tr>

	<tr>
		<td colspan="2"><button id ="mod" value='<?php echo $row["id"];?> '>Módosít</button></td>
	</tr>
<?php } ?>

</table>