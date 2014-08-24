<?php 
	session_start();
	include '../../../config.php';
?>
<td colspan="3">
<table id="ord_offer">
	<tr>
		<td>
			<?php 
			if (isset($_GET['offernum'])) $_SESSION['offerid'] = $_GET['offernum']; else $_SESSION['offerid'] = 1;
			$offernum = $_SESSION['offerid'];
			?>
		</td>
	</tr>
	<tr>
		<td>
			<?php
			echo "<select id=\"offer$offernum\" name=\"offer$offernum\" onChange=\"var a = $(this).parent().next().children().first(); a.css('opacity', '0.3'); a.removeAttr('onclick');\">";
			?>
			<?php
			echo "<option disabled selected id=\"first_option$offernum\">Válasszon ajánlatot!</option>";
			?>
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
			<?php
			echo "<input type='button' value='Új ajánlat' class='button' onClick='new_offer($offernum);' style=\"margin-bottom: 5px;\" >";
			?>
			<?php
			echo "<input type='button' value='Ajánlatot módosít' class='button' onClick='mod_offer($offernum);' >";
			?>
		</td>
	</tr>
</table>
</td>