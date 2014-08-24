<script>
    $(document).ready(function() {

        var date = new Date();
        var month = date.getMonth() + 1;
        var day = date.getDate();
        var output = date.getFullYear() + '-' +
                (month < 10 ? '0' : '') + month + '-' +
                (day < 10 ? '0' : '') + day;

        $("#setDate").val(output);
        $(".datepicker").Zebra_DatePicker();

        $("#add").on("click", function() {
            var date = $("#setDate").val();
            var shop = $("#setShop").val().charAt(0);
            var price = $("#setPrice").val();
            var wreath_price = $("#setWreathPrice").val();
            var note = $("#setNote").val();
//            alert(date + " " + shop + " " + price + " " + note);

            $.ajax({
                type: "POST",
                url: "menu-main/menu-statistic-submenu/statistic/newIncome.php",
                data: {
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

<p style="font: normal 22px 'Arial'; color: #89a583; padding: 20px 20px 5px 20px;">Napi kasszazárás rögzítése</p>

<?php
include '../../../config.php';

echo "<table id = 'addOutlayTable'>";
echo "<tr><td>Dátum:</td><td><input class = 'datepicker borderedStyle' id = 'setDate' type='text' value='' placeholder='Dátum' name='date'></td></tr>";
echo "<tr><td>Bolt:</td><td><select id = 'setShop' name='shop'>
		<option disabled selected>Válasszon boltot!</option>";
$query_shops = "SELECT *
                            FROM shops ORDER BY id ASC";
$result_shops = mysql_query($query_shops) or die(mysql_error());
while ($row_shops = mysql_fetch_array($result_shops)) {
    echo '<option>' . $row_shops["id"] . " - " . $row_shops["name"] . '</option>';
}
echo "</select></td></tr>";
?>
<tr><td>Napi Bevétel:</td><td><input id = 'setPrice' type='text' value='' placeholder='Ár' name='price'></td></tr>
<tr><td>Koszorú bevétel:</td><td><input id = 'setWreathPrice' type='text' value='' placeholder='Ár' name='price'></td></tr>
<tr><td>Megjegyzés:</td><td><textarea id = "setNote" name = "note" rows="3" cols="30"></textarea><!-- <input type='text' value='' placeholder='Megjegyzés' name='note'> --></td></tr>

<tr><td colspan = "2"><button id = "add">Hozzáadás</button></td></tr>


</table>