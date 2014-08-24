<?php 
	include '../../../config.php';
	if (isset($_GET['offernum'])) $offernum = $_GET['offernum']; else $offernum = 1;
?>
<td colspan="3" class="border_top">
<table class="order_data" id="offertable<?php echo $offernum; ?>">
	<tr>
		<td>Ajánlat: </td>
		<td>
			<select id="offer<?php echo $offernum; ?>" name="offer<?php echo $offernum; ?>" onChange="var a = $(this).parent().next().children().first(); a.css('opacity', '0.3'); a.removeAttr('onclick');">
				<option disabled selected id="first_option<?php echo $offernum; ?>">Válasszon ajánlatot!</option>
					<?php 
						$query = "SELECT id, name FROM  `offer_wreath` WHERE archive = 0 ORDER BY up_time DESC";
						$result = mysql_query($query) or die (mysql_error());
					
						while ($row = mysql_fetch_assoc($result)) {
							$wreath = $row['name'];
							$wid = $row['id'];

							$query_up_time = "SELECT up_time FROM  `offer_wreath` WHERE id=$wid";
							$result_up_time = mysql_query($query_up_time) or die (mysql_error());
							while ($row_up_time = mysql_fetch_assoc($result_up_time)) {
								$up_datetime = $row_up_time['up_time'];
								$up_time = substr($up_datetime, 0, -9); // Levágja a time részét
								$up_time = date_create($up_time);
								$up_time = date_format($up_time, 'Y-m-d');

								$border_time = date_create(date("Y-m-d")); // Mai dátum
								$border_time->sub(new DateInterval('P14D')); // Mai dátum - 14 nap
								$border_time = date_format($border_time, 'Y-m-d');

								if ($up_time > $border_time) {
									echo "<option value='$wreath'>$wreath - $up_time</option>";
								}
							}
						}
					?>
			</select>
		</td>
		<td rowspan="3">
			<input type='button' value='Új ajánlat' class='button' onClick='new_offer(<?php echo $offernum; ?>);' style="margin-bottom: 5px; width: 165px;" >
			<input type='button' value='Ajánlatot módosít' class='button' onClick='mod_offer(<?php echo $offernum; ?>);' style="margin-bottom: 5px; width: 165px;" >
		</td>
	</tr>
	<tr>
		<td>Azonosító: </td>
		<td> 
			<input type="text" id="offerazonosito<?php echo $offernum; ?>" name="offerazonosito<?php echo $offernum; ?>" placeholder="Ajánlat azonosító">
		</td>
	</tr>
	<tr>
		<td>
			<input type='button' value='Sor törlése' class='minus' onClick='del_offer(<?php echo $offernum; ?>);' style="width: 165px;" >
		</td>
		<td>
			<input type="button" value="Új sor hozzáadása" class="plus" onClick="addOffer_modder();" style="width: 165px;">
		</td>
	</tr>
</table>
</td>