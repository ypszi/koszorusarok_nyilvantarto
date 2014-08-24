<script type="text/javascript" src="js/protea_functions.js"></script>

<style type="text/css">
	
	.order_title {
		font: normal 22px/24px "Arial";
		color: #89a583;
		text-transform: none;
		margin-bottom: 10px;
		text-align: center;
	}
	.order_data {
		width: 100%;
		border: 1px solid #e2f1cb;
	}

	.order_header td {
		padding: 5px;
		width: 33%;
	}

	.order_header th {
		padding: 5px;
		text-align: center;
	}

	.order_data td {
		padding: 5px;
		width: 50%;
	}
	.order_data input[type=text], td {
		vertical-align: middle;
	}

	.order_data input[type=text], textarea {
		width: 97%;
		border: 1px solid #ddd;
		padding: 4px;
	}

	.order_data tr:nth-child(2n) {
		background-color: #e2f1cb;
	}

	#ord_wreath, #ord_offer {
		width: 100%;
	}

	#ord_wreathrow, #ord_offerrow {
		width: 100%;
		border: 1px solid #e2f1cb;
	}

	#ord_offer {
		margin-top: 15px;
	}

	#ord_wreathrow td, #ord_offerrow td {
		padding: 5px;
		width: 50%;
	}

	#ord_wreathrow tr:nth-child(2n), #ord_offerrow tr:nth-child(2n) {
		background-color: #e2f1cb;
	}

	.order_data select {
		width: 100%;
	}

	.huf {
		width: 94% !important;
	}

	.plus {
		margin-top: -3px;
		background: url(img/btn-bg1.png) repeat-x 0 0px;
		background-color: #ddd;
		padding: 0px 3px 0px 3px;
		cursor: pointer;
		border: 2px outset #fff;
		height: 24px;
		color: #fff;
	}
	.minus {
		margin-top: -3px;
		background: url(img/btn-bg2.png) repeat-x 0 0px;
		background-color: #ddd;
		padding: 0px 3px 0px 3px;
		cursor: pointer;
		border: 2px outset #fff;
		height: 24px;
		color: #fff;
	}

	.border_top {
		border-top: 3px solid #bed2a0;
	}

	#new_offer {
		display: none;
		padding: 5px 5px 5px 15px;
		border-radius: 5px;
		width: 850px;
		height: 570px;
		position: fixed;
		margin: 0px auto;
		left: 8%;
		top: 2%;
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

	#new_offer > h1 {
		color: #fff;
		font-size: 21px;
	}
</style>
<link href="css/alertwindow.css" rel="stylesheet" type="text/css" media="all">
<div id='alertwindow'></div>

<div class="title">
	<span class="firstWord">Rendelés</span> módosítása
</div>
<?php

	$query = "SELECT * FROM  `orders` WHERE id=".$_GET['order_id'].";";
	$result = mysql_query($query) or die (mysql_error());
	while ($row = mysql_fetch_assoc($result)) {
		$id = $row['id'];
		$deadname = $row['deadname'];
		$ritual_time = $row['ritual_time'];
		$shipment = $row['shipment'];
		$clocation = $row['clocation'];
		$caddress = $row['caddress'];
		$cfuneral = $row['cfuneral'];
		$customer_name = $row['customer_name'];
		$phone_number = $row['phone_number'];
		$email = $row['email'];
		$create_time = $row['create_time'];
		$worker_id = $row['worker_id'];
		$note = $row['note'];
		$price = $row['price'];
		$downprice = $row['downprice'];
		$ship_price = $row['ship_price'];
		$paid = $row['paid'];
		$shop = $row['shop'];
		$maker_shop = $row['maker_shop'];
		$archive = $row['archive'];
	}

?>

	<div id="new_offer" style="z-index: 6; overflow-x: hidden; overflow-y: scroll;">
	</div>

<form action="menu-main/menu-order-submenu/mod-order/order-mod.php" method="POST" onSubmit="return modifycheck();">
	<input type="hidden" name="old_id" value="<?php echo $id; ?>">
	<input type="hidden" name="old_deadname" value="<?php echo $deadname; ?>">
	<input type="hidden" name="old_ritual_time" value="<?php echo $ritual_time; ?>">
	<input type="hidden" name="old_shipment" value="<?php echo $shipment; ?>">
	<input type="hidden" name="old_clocation" value="<?php echo $clocation; ?>">
	<input type="hidden" name="old_caddress" value="<?php echo $caddress; ?>">
	<input type="hidden" name="old_cfuneral" value="<?php echo $cfuneral; ?>">
	<input type="hidden" name="old_customer_name" value="<?php echo $customer_name; ?>">
	<input type="hidden" name="old_phone_number" value="<?php echo $phone_number; ?>">
	<input type="hidden" name="old_email" value="<?php echo $email; ?>">
	<input type="hidden" name="old_create_time" value="<?php echo $create_time; ?>">
	<input type="hidden" name="old_worker_id" value="<?php echo $worker_id; ?>">
	<input type="hidden" name="old_note" value="<?php echo $note; ?>">
	<input type="hidden" name="old_price" value="<?php echo $price; ?>">
	<input type="hidden" name="old_downprice" value="<?php echo $downprice; ?>">
	<input type="hidden" name="old_ship_price" value="<?php echo $ship_price; ?>">
	<input type="hidden" name="old_paid" value="<?php echo $paid; ?>">
	<input type="hidden" name="old_shop" value="<?php echo $shop; ?>">
	<input type="hidden" name="old_maker_shop" value="<?php echo $maker_shop; ?>">
	<input type="hidden" name="old_archive" value="<?php echo $archive; ?>">

<?php 
	$query_orderitems = "SELECT * FROM order_items WHERE order_id=".$_GET['order_id']." AND is_offer=0;";
	$result_orderitems = mysql_query($query_orderitems) or die(mysql_error());
	$ind = 1;
	$wreathnum = 0;
	while ($row = mysql_fetch_assoc($result_orderitems)) {
		$order_id = $row['order_id'];
		$wreaths['wreath_name'][$ind] = $row['wreath_name'];
		$wreaths['azonosito'][$ind] = $row['azonosito'];
		$ribbon_id = is_null($row['ribbon_id']) ? 'NULL' : $row['ribbon_id'];

		if ($ribbon_id != 'NULL') {
			$query_ribbons = "SELECT * FROM ribbons WHERE id=".$ribbon_id.";";
			$result_ribbons = mysql_query($query_ribbons) or die(mysql_error());
			while ($row = mysql_fetch_assoc($result_ribbons)) {
				$wreaths['ribbon'][$ind] = $row['ribbon'];
				$wreaths['ribboncolor'][$ind] = $row['ribboncolor'];
				$wreaths['farewelltext'][$ind] = $row['farewelltext'];
				$wreaths['givers'][$ind] = $row['givers'];
			}
		} else {
			$wreaths['ribbon'][$ind] = "";
			$wreaths['ribboncolor'][$ind] = "";
			$wreaths['farewelltext'][$ind] = "";
			$wreaths['givers'][$ind] = "";
		}
		$wreathnum++; 
		$ind++;
	}

	$query_orderitems = "SELECT * FROM order_items WHERE order_id=".$_GET['order_id']." AND is_offer=1;";
	$result_orderitems = mysql_query($query_orderitems) or die(mysql_error());
	$ind = 1;
	$offernum = 0;
	while ($row = mysql_fetch_assoc($result_orderitems)) {
		$order_id = $row['order_id'];
		$offers['offer_name'][$ind] = $row['wreath_name'];
		$offers['offer_azonosito'][$ind] = $row['azonosito'];
		$offernum++;
		$ind++;
	}
?>

	<!-- ------------------------------------------------------------------------------ -->
	<!-- ---------------------------------- Koszorúk ---------------------------------- -->
	<!-- ------------------------------------------------------------------------------ -->

<table id="ord_wreath">
	<tr>
		<th class="order_title">Koszorúk</th>
		<td>
			<input type="button" value="Új sor hozzáadása" class="plus" onClick="addWreath_modder();" >
		</td>
		<!-- <td>
			<input type="button" value="Utolsó sor törlése" class="minus" onClick="remWreathRow_modder();" >
		</td> -->
	</tr>
<?php 
	$ind = 1;
	if ($wreathnum > 0) {
	foreach ($wreaths['wreath_name'] as $wreath) { ?>
	<tr>
		<td colspan="3" class="border_top">
			<table class="order_data" id="wreathtable<?php echo $ind-1; ?>">
				<tr>
					<td>
						Koszorú típus: 
					</td>
					<td>
						<select id="wreath_type<?php echo $ind; ?>" name="wreath_type<?php echo $ind; ?>" onChange="loadCatalogWreathNames(this.id, 'wreath1');">
							<option disabled selected>Válasszon koszorút típust!</option>
								<?php
								$query = "SELECT type FROM  `base_wreath_type` ORDER BY type";
								$result = mysql_query($query) or die (mysql_error());
								
								echo $query2 = "SELECT base_wreath_type.type AS type
											FROM special_wreath, base_wreath_type, base_wreath 
											WHERE (special_wreath.base_wreath_id = base_wreath.id) 
											AND (base_wreath.type = base_wreath_type.id) 
											AND (special_wreath.name = '".$wreath."')
											GROUP BY base_wreath_type.type";
								$result2 = mysql_query($query2) or die (mysql_error());
								while ($row = mysql_fetch_assoc($result)) {
									$wreath_type = $row['type'];
									while ($row2 = mysql_fetch_assoc($result2)) {
										$curr_wreath_type = $row2['type'];
									}
									if ($curr_wreath_type == $wreath_type) {
										echo "<option selected>$wreath_type</option>";
									} else {
										echo "<option >$wreath_type</option>";
									}
								}
								?>
						</select>
					</td>
					<td rowspan="7">
						<?php 
							$query = "SELECT picture FROM `special_wreath` WHERE name='$wreath'";
							$result = mysql_query($query) or die(mysql_error());
							while ($row = mysql_fetch_assoc($result)) {
								$pic = explode("|", $row["picture"]);
								$preview = $conf_path_abs."img/wreath/".$pic[0];
							}
						 ?>
						<img id="wreath_preview<?php echo $ind; ?>" name="wreath_preview<?php echo $ind; ?>" style="width: 165px;" src="<?php echo $preview; ?>">
						<input type='hidden' id='wreath_preview_src<?php echo $ind; ?>' name='wreath_preview_src<?php echo $ind; ?>' value='<?php echo $preview; ?>'>
					</td>
				</tr>
				<tr>
					<td>
						Koszorú: 
					</td>
					<td>
						<select id="wreath<?php echo $ind; ?>" name="wreath<?php echo $ind; ?>" onchange="loadWreathimg(this, <?php echo $ind; ?>);">
							<option disabled selected>Válasszon koszorút!</option>
							<?php
							$query = "SELECT special_wreath.id, special_wreath.name	
												FROM `special_wreath`, `base_wreath` 
												WHERE special_wreath.base_wreath_id = base_wreath.id
												AND base_wreath.type = (SELECT `id` FROM `base_wreath_type` WHERE `type`='".$curr_wreath_type."')
												ORDER BY special_wreath.name ASC";
							$result = mysql_query($query) or die (mysql_error());

							while ($row = mysql_fetch_assoc($result)) {
								$each_wreath_name = $row['name'];
								if ($wreath == $each_wreath_name) {
									echo "<option selected>$each_wreath_name</option>";
								} else {
									echo "<option >$each_wreath_name</option>";
								}
							}
							?>
						 </select>
					</td>
				</tr>
				<tr>
					<td>
						Azonosító: 
					</td>
					<td> 
						<input type="text" id="azonosito<?php echo $ind; ?>" name="azonosito<?php echo $ind; ?>" value="<?php echo $wreaths['azonosito'][$ind]; ?>" placeholder="Azonosító">
					</td>
				</tr>
				<tr>
					<td> 
						Kér szalagot
					</td>
					<td>
						<?php if ($wreaths['ribbon'][$ind] != "") { ?>
						<input type="checkbox" name="isRibbon<?php echo $ind; ?>" id="isRibbon<?php echo $ind; ?>" onChange="ribbonEnable(this.id);" checked>
						<?php } else { ?>
						<input type="checkbox" name="isRibbon<?php echo $ind; ?>" id="isRibbon<?php echo $ind; ?>" onChange="ribbonEnable(this.id);">
						<?php } ?>
					</td>
				</tr>
				<tr>
					<td></td>
					<td>
						<?php if ($wreaths['ribbon'][$ind] != "") { ?>
						<select id="ribbon<?php echo $ind; ?>" name="ribbon<?php echo $ind; ?>" >
							<option disabled>Válassza ki a szalag típusát</option>";
							<?php 
							$query = "SELECT * FROM  `ribbon_type`";
							$result = mysql_query($query) or die(mysql_error());

							while ($row = mysql_fetch_assoc($result)) {
								$type = $row['type'];
								if ($wreaths['ribbon'][$ind] == $type) {
									echo "<option selected>$type</option>";
								} else {
									echo "<option>$type</option>";
								}
							}
							?>
						</select>
						<?php } else { ?>
						<select id="ribbon<?php echo $ind; ?>" name="ribbon<?php echo $ind; ?>" disabled>
							<option disabled selected>Válassza ki a szalag típusát</option>";
							<?php 
							$query = "SELECT * FROM  `ribbon_type`";
							$result = mysql_query($query) or die(mysql_error());

							while ($row = mysql_fetch_assoc($result)) {
								$type = $row['type'];
								echo "<option>$type</option>";
							}
							?>
						</select>
						<?php } ?>
					</td>
				</tr>
				<tr>
					<td></td>
					<td>
						<?php if ($wreaths['ribbon'][$ind] != "") { ?>
						<select id="ribboncolor<?php echo $ind; ?>" name="ribboncolor<?php echo $ind; ?>" >
							<option disabled >Válassza ki a szalag színét</option>";
							<?php 
								$query = "SELECT color FROM  `ribbon_color`";
								$result = mysql_query($query) or die(mysql_error());

								while ($row = mysql_fetch_assoc($result)) {
									$color = $row['color'];
									if ($wreaths['ribboncolor'][$ind] == $color) {
										echo "<option selected>$color</option>";
									} else {
										echo "<option>$color</option>";
									}
								}
							?>
						</select>
						<?php } else { ?>
						<select id="ribboncolor<?php echo $ind; ?>" name="ribboncolor<?php echo $ind; ?>" disabled>
							<option disabled selected>Válassza ki a szalag színét</option>";
							<?php 
								$query = "SELECT color FROM  `ribbon_color`";
								$result = mysql_query($query) or die(mysql_error());

								while ($row = mysql_fetch_assoc($result)) {
									$color = $row['color'];
									echo "<option>$color</option>";
								}
							?>
						</select>
						<?php } ?>
					</td>	
				</tr>
				<tr>
					<td></td>
					<td>
						<?php if ($wreaths['ribbon'][$ind] != "") { ?>
						<select id="farewelltext<?php echo $ind; ?>" name="farewelltext<?php echo $ind; ?>" >
							<option disabled >Válassza ki a búcsúszöveget</option>
							<?php
								$query2 = "SELECT * FROM `tape_title` ORDER BY id";
								$result2 = mysql_query($query2) or die (mysql_error());
								while ($row = mysql_fetch_assoc($result2)) {
									$id = $row['id'];
									$tapetext = "SZ$id - ".$row['text'];
									if ($wreaths['farewelltext'][$ind] == $tapetext) {
										echo "<option selected > $tapetext </option>";
									} else {
										echo "<option>$tapetext</option>";
									}
								}
								
								$query = "SELECT * FROM  `citation`";
								$result = mysql_query($query) or die (mysql_error());
								while ($row = mysql_fetch_assoc($result)) {
									$id = $row['id'];
									$cittext = "ID$id - ".$row['text'];
									if ($wreaths['farewelltext'][$ind] == $cittext) {
										echo "<option selected > $cittext </option>";
									} else {
										echo "<option>$cittext</option>";
									}
								}
							?>
						</select>
						<?php } else { ?>
						<select id="farewelltext<?php echo $ind; ?>" name="farewelltext<?php echo $ind; ?>" disabled>
							<option disabled selected>Válassza ki a búcsúszöveget</option>
							<?php
								$query2 = "SELECT * FROM `tape_title` ORDER BY id";
								$result2 = mysql_query($query2) or die (mysql_error());
								while ($row = mysql_fetch_assoc($result2)) {
									$id = $row['id'];
									$tapetext = "SZ$id - ".$row['text'];
									echo "<option>$tapetext</option>";
								}
								
								$query = "SELECT * FROM  `citation`";
								$result = mysql_query($query) or die (mysql_error());
								while ($row = mysql_fetch_assoc($result)) {
									$id = $row['id'];
									$cittext = "ID$id - ".$row['text'];
									echo "<option>$cittext</option>";
								}
							?>
						</select>
						<?php } ?>
					</td>
				</tr>
				<tr>
					<td>Akik Adják: </td>
					<td>
						<textarea style="resize: vertical;" cols="50" rows="5" id="givers<?php echo $ind; ?>" name="givers<?php echo $ind; ?>" placeholder="Akik adják"><?php echo $wreaths['givers'][$ind]; ?></textarea>
					</td>
					<td>
						<input type="button" value="Sor törlése" class="minus" onClick="remWreathRow_modder(<?php echo $ind; ?>);" style="margin-top: 30px; width: 165px;">
						<input type="button" value="Új sor hozzáadása" class="plus" onClick="addWreath_modder();" style="margin-top: 10px; width: 165px;">
					</td>
				</tr>
			</table>
		</td>
	</tr>
<?php $ind++; }} else { ?>
<tr>
		<td colspan="3" class="border_top">
			<table class="order_data" id="wreathtable0">
				<tr>
					<td>
						Koszorú típus: 
					</td>
					<td>
						<select id="wreath_type<?php echo $ind; ?>" name="wreath_type<?php echo $ind; ?>" onChange="loadCatalogWreathNames(this.id, 'wreath1');">
							<option disabled selected>Válasszon koszorút típust!</option>";
								<?php
								$query = "SELECT type FROM  `base_wreath_type` ORDER BY type";
								$result = mysql_query($query) or die (mysql_error());
							
								while ($row = mysql_fetch_assoc($result)) {
									$wreath_type = $row['type'];
									echo "<option >$wreath_type</option>";
								}
								?>
						</select>
					</td>
					<td rowspan="7">
						<img id="wreath_preview1" name="wreath_preview1" style="width: 165px;" src="">
						<input type='hidden' id='wreath_preview_src1' name='wreath_preview_src1' value=''>
					</td>
				</tr>
				<tr>
					<td>
						Koszorú: 
					</td>
					<td>
						<select id="wreath1" name="wreath1" onChange="document.getElementById('wreathnum').value = 1; loadWreathimg(this, 1);" disabled>
							<option disabled selected>Válasszon koszorút!</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						Azonosító: 
					</td>
					<td> 
						<input type="text" id="azonosito1" name="azonosito1" placeholder="Azonosító">
					</td>
				</tr>
				<tr>
					<td> 
						Kér szalagot
					</td>
					<td>
						<input type="checkbox" name="isRibbon1" id="isRibbon1" onChange="ribbonEnable(this.id);">
					</td>
				</tr>
				<tr>
					<td></td>
					<td>
						<select id="ribbon1" name="ribbon1" disabled>
							<option disabled selected>Válassza ki a szalag típusát</option>";
							<?php 
							$query = "SELECT type, note FROM  `ribbon_type`";
							$result = mysql_query($query) or die(mysql_error());

							while ($row = mysql_fetch_assoc($result)) {
								$type = $row['type'];
								echo "<option>$type</option>";
							}
							?>
						</select>
					</td>
				</tr>
				<tr>
					<td></td>
					<td>
						<select id="ribboncolor1" name="ribboncolor1" disabled>
							<option disabled selected>Válassza ki a szalag színét</option>";
							<?php 
							$query = "SELECT color FROM  `ribbon_color`";
							$result = mysql_query($query) or die(mysql_error());

							while ($row = mysql_fetch_assoc($result)) {
								$color = $row['color'];
								echo "<option>$color</option>";
							}
							?>
						</select>
					</td>	
				</tr>
				<tr>
					<td></td>
					<td>
						<select id="farewelltext1" name="farewelltext1" disabled>
							<option disabled selected>Válassza ki a búcsúszöveget</option>
							<?php
								include 'farewelltext.php';
							?>
						</select>
					</td>
				</tr>
				<tr>
					<td>Akik Adják: </td>
					<td>
						<textarea style="resize: vertical;" cols="50" rows="5" id="givers1" name="givers1" placeholder="Akik adják"></textarea>
					</td>
					<td>
						<input type="button" value="Sor törlése" class="minus" onClick="remWreathRow_modder(0);" style="margin-top: 30px; width: 165px;">
						<input type="button" value="Új sor hozzáadása" class="plus" onClick="addWreath_modder();" style="margin-top: 10px; width: 165px;">
					</td>
				</tr>
			</table>
		</td>
	</tr>
<?php } ?>
</table>

	<!-- ------------------------------------------------------------------------------ -->
	<!-- ---------------------------------- Ajánlatok --------------------------------- -->
	<!-- ------------------------------------------------------------------------------ -->

<table id="ord_offer">
	<tr>
		<th class="order_title">Ajánlatok</th>
		<td>
			<input type="button" value="Új sor hozzáadása" class="plus" onClick="addOffer_modder();" >
		</td>
	</tr>
<?php 
	$ind = 1;
	if ($offernum > 0) {
	foreach ($offers['offer_name'] as $offer) { ?>
	<tr>
		<td colspan="3" class="border_top">
			<table class="order_data" id="offertable<?php echo $ind-1; ?>">
			<tr>
				<td>
					Ajánlat: 
				</td>
				<td>
					<select id="offer<?php echo $ind; ?>" name="offer<?php echo $ind; ?>" onChange="var a = $(this).parent().next().children().first(); a.css('opacity', '0.3'); a.removeAttr('onclick');">
						<option disabled selected id="first_option<?php echo $ind; ?>">Válasszon ajánlatot!</option>
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
									$border_time->sub(new DateInterval('P6M')); // Mai dátum - 6 hónap
									$border_time = date_format($border_time, 'Y-m-d');

									if ($up_time > $border_time) {
										if ($wreath == $offers['offer_name'][$ind]) {
											echo "<option value='$wreath' selected>$wreath - $up_time</option>";
										} else {
											echo "<option value='$wreath'>$wreath - $up_time</option>";
										}
									}
								}
							}
							?>
						</select>
				</td>
				<td rowspan="3">
					<input type='button' value='Új ajánlat' class='button' onClick='new_offer(<?php echo $ind; ?>);' style="margin-bottom: 5px; width: 165px;" >
					<input type='button' value='Ajánlatot módosít' class='button' onClick='mod_offer(<?php echo $ind; ?>);' style="margin-bottom: 5px; width: 165px;" >
				</td>
			</tr>
			<tr>
				<td>
					Azonosító: 
				</td>
				<td> 
					<input type="text" id="offerazonosito<?php echo $ind; ?>" name="offerazonosito<?php echo $ind; ?>" value="<?php echo $offers['offer_azonosito'][$ind]; ?>" placeholder="Azonosító">
				</td>
			</tr>
			<tr>
				<td>
					<input type='button' value='Sor törlése' class='minus' onClick='del_offer(<?php echo $ind-1; ?>);' style="width: 165px;" >
				</td>
				<td>
					<input type="button" value="Új sor hozzáadása" class="plus" onClick="addOffer_modder();" style="width: 165px;">
				</td>
			</tr>
		</table>
		</td>
	</tr>
<?php $ind++; }} else { ?>
<tr>
		<td colspan="3" class="border_top">
			<table class="order_data" id="offertable0">
			<tr>
				<td>
					Ajánlat: 
				</td>
				<td>
					<select id="offer1" name="offer1" onChange="document.getElementById('offernum').value = 1; var a = $(this).parent().next().children().first(); a.css('opacity', '0.3'); a.removeAttr('onclick');">
						<option disabled selected id="first_option<?php echo $ind; ?>">Válasszon ajánlatot!</option>
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
									$border_time->sub(new DateInterval('P6M')); // Mai dátum - 6 hónap
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
					<input type='button' value='Új ajánlat' class='button' onClick='new_offer(1);' style="margin-bottom: 5px; width: 165px;" >
					<input type='button' value='Ajánlatot módosít' class='button' onClick='mod_offer(1);' style="margin-bottom: 5px; width: 165px;" >
				</td>
			</tr>
			<tr>
				<td>
					Azonosító: 
				</td>
				<td> 
					<input type="text" id="offerazonosito1" name="offerazonosito1" placeholder="Ajánlat azonosító">
				</td>
			</tr>
			<tr>
				<td>
					<input type='button' value='Sor törlése' class='minus' onClick='del_offer(0);' style="width: 165px;" >
				</td>
				<td>
					<input type="button" value="Új sor hozzáadása" class="plus" onClick="addOffer_modder();" style="width: 165px;">
				</td>
			</tr>
		</table>
		</td>
	</tr>
<?php } ?>
</table>
<br>

	<!-- ------------------------------------------------------------------------------ -->
	<!-- ---------------------------------- Szertartás -------------------------------- -->
	<!-- ------------------------------------------------------------------------------ -->

<h1 class="title">Szertartási adatok</h1>
<table class="order_data">
	<?php if ($shipment != "Nem kér kiszállítást") { ?>

	<tr>
		<td>* Elhunyt neve: </td>
		<td> <input type="text" name="deadname" id="dead_name" value="<?php echo $deadname;?>"> </td>
	</tr>
	<?php } ?>
	<tr>
		<td>* Szertartás ideje: </td>
		<td> <input type="text" name="ritual_time" id="ritual_time" value="<?php echo $ritual_time;?>"> </td>
	</tr>
	<tr rowspan="3">
		<td>* Szállítás módja: </td>
		<td>
			<?php if ($shipment == "Nem kér kiszállítást") { ?>
			<input type="radio" name="shipment" value="Nem kér kiszállítást" onChange="customShipment();" checked> Nem kér kiszállítást
			<?php } else { ?>
			<input type="radio" name="shipment" value="Nem kér kiszállítást" onChange="customShipment();"> Nem kér kiszállítást
			<?php } ?>
		</td>
	</tr>
	<tr>
		<td></td>
		<td> 
			<?php if ($shipment == "Erzsébeti temető") { ?>
			<input type="radio" name="shipment" value="Erzsébeti temető" onChange="customShipment();" checked> Erzsébeti temető
			<?php } else { ?>
			<input type="radio" name="shipment" value="Erzsébeti temető" onChange="customShipment();"> Erzsébeti temető
			<?php } ?>
		</td>
	</tr>
	<tr>
		<td></td>
		<td> 
			<?php if ($shipment == "Egyedi helyszín") { ?>
			<input type="radio" name="shipment" value="Egyedi helyszín" onChange="customShipment();" checked> Egyedi helyszín
			<?php } else { ?>
			<input type="radio" name="shipment" value="Egyedi helyszín" onChange="customShipment();"> Egyedi helyszín
			<?php } ?>
		</td>
	</tr>
	<?php if ($shipment == "Egyedi helyszín") { ?>
	<tr>
		<td colspan="2">
		<table id="custom_ship_place" class="order_data" style="display: block;">
			<tr>
				<td>
					* Temetés helyszíne: 
				</td>
				<td>
					<input type="text" name="c_location" value="<?php echo $clocation;?>" id="c_location" style="width: 330px">  (pl: Újköztemető)
				</td>
			</tr>
			<tr>
				<td>
					* Címe:
				</td>
				<td>
					<input type="text" name="c_address" value="<?php echo $caddress;?>" id="c_address" style="width: 330px"> (pl: 1108 Budapest, Kozma utca 8-10)
				</td>
			</tr>
			<tr>
				<td>
					* Ravatalozó / terem:
				</td>
				<td>
					<input type="text" name="c_funeral" value="<?php echo $cfuneral;?>" id="c_funeral" style="width: 330px">
				</td>
			</tr>
		</table>
		</td>
	</tr>
	<?php } else { ?>
	<tr>
		<td colspan="2">
		<table id="custom_ship_place" class="order_data" style="display: none;">
		</table>
		</td>
	</tr>
	<?php } ?>
</table>
<br>
<h1 class="title">Megrendelési adatok</h1>
<table class="order_data">
	<tr>
		<td>* Megrendelő neve: </td>
		<td> <input type="text" name="customer_name" id="customer_name" value="<?php echo $customer_name;?>"> </td>
	</tr>
	<tr>
		<td>* Telefonszáma: </td>
		<td> <input type="text" name="phone_number" id="phone_num" value="<?php echo $phone_number;?>"> </td>
	</tr>
	<tr>
		<td>Email címe: </td>
		<td> <input type="text" name="email" id="email" value="<?php echo $email;?>"> </td>
	</tr>
</table>
<br>
<h1 class="title">Fizetési információ</h1>
<table class="order_data">
	<?php if ($paid != NULL) { ?>
	<tr>
		<td>Fizetve</td>
		<td> <input type="checkbox" name="paid" id="paid" checked>  </td>
	</tr><?php } else { ?>
	<tr>
		<td>Fizetve </td>
		<td> <input type="checkbox" name="paid" id="paid" >  </td>
	</tr> <?php } ?>
	<tr>
		<td>* Végösszeg: </td>
		<td> <input type="text" name="price" id="end_price" class="huf" value="<?php echo number_format($price, 0, ',', ' ');?>">Ft </td>
	</tr>
	<tr>
		<td>Szállítási költség: </td>
		<td> <input type="text" name="ship_price" id="ship_price" class="huf" value="<?php echo number_format($ship_price, 0, ',', ' ');?>" onChange="calcRemainder();">Ft </td>
	</tr>
	<tr>
		<td>* Előleg: </td>
		<td> <input type="text" name="downprice" id="downprice" class="huf" value="<?php echo number_format($downprice, 0, ',', ' ');?>" onChange="calcRemainder();">Ft </td>
	</tr>
	<tr>
		<td>* Hátralék: </td>
	<?php if ($paid != NULL) { ?>
		<td> <input type="text" name="remainder" id="remainder" value="0 Ft"></td>
	<?php } else { ?>
		<td> <input type="text" name="remainder" id="remainder" value="<?php echo number_format($price-$downprice, 0, ',', ' ');?> Ft"></td>
	<?php } ?>
	</tr>
	<tr>
		<td>* Készítő Bolt: </td>
		<td> 
			<select name="maker_shop">
			<?php 
				$query = "SELECT id, name FROM `shops` WHERE enable = 1";
				$result = mysql_query($query) or die(mysql_error());

				while ($row = mysql_fetch_assoc($result)) {
					$shopid = $row['id'];
					$shopname = $row['name'];
					if ($shopid == $maker_shop) {
						echo "<option value='$shopid' selected>$shopname</option>";
					} else {
						echo "<option value='$shopid' >$shopname</option>";
					}
				}
			?>
			</select>
		</td>
	</tr>
	<tr>
		<td>Megjegyzés: </td>
		<td> <input type="text" name="note" value="<?php echo $note;?>"> </td>
	</tr>
</table>

	<input type="hidden" name="wreathnum" id="wreathnum" value="<?php echo $wreathnum; ?>">
	<input type="hidden" name="offernum" id="offernum" value="<?php echo $offernum; ?>">
	<br>
	<input type="button" onClick="calc_modify_sum();" class="minus" value="Újraszámol">
	<input type="hidden" id="is_evaluated" value="false">
	<input type="submit" value="Módosítom!" class="plus">
</form>

<?php
	/*print $deadname . 
	$ritual_time . 
	$shipment . 
	$clocation . 
	$caddress . 
	$cfuneral . 
	$customer_name . 
	$phone_number . 
	$email . 
	create_time
	$worker_id . 
	$note . 
	$price . 
	$downprice . 
	$ship_price . 
	$paid . 
	$shop . //aki felvette
	$maker_shop . //aki elkészíti
	$archive;*/
?>