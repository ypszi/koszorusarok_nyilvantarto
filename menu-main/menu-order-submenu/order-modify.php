<style type="text/css">

	.order_data {
		width: 100%;
		border: 1px solid #e2f1cb;
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

	.order_data select {
		width: 100%;
	}

	.huf {
		width: 94% !important;
	}
</style>

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
<h1 class='title'>Rendelési adatok</h1>
<form action="menu-main/menu-order-submenu/order-mod.php" method="POST">
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
	<input type="hidden" name="old_worker_id" value="<?php echo $worker_id; ?>">
	<input type="hidden" name="old_note" value="<?php echo $note; ?>">
	<input type="hidden" name="old_price" value="<?php echo $price; ?>">
	<input type="hidden" name="old_downprice" value="<?php echo $downprice; ?>">
	<input type="hidden" name="old_ship_price" value="<?php echo $ship_price; ?>">
	<input type="hidden" name="old_paid" value="<?php echo $paid; ?>">
	<input type="hidden" name="old_shop" value="<?php echo $shop; ?>">
	<input type="hidden" name="old_maker_shop" value="<?php echo $maker_shop; ?>">
	<input type="hidden" name="old_archive" value="<?php echo $archive; ?>">
<table class="order_data">
	<tr>
		<td>* Elhunyt neve: </td>
		<td> <input type="text" name="deadname" value="<?php echo $deadname;?>"> </td>
	</tr>
	<tr>
		<td>* Szertartás ideje: </td>
		<td> <input type="text" name="ritual_time" value="<?php echo $ritual_time;?>"> </td>
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
					<input type="text" name="c_location" value="<?php echo "$clocation";?>" id="c_location" style="width: 330px">  (pl: Újköztemető)
				</td>
			</tr>
			<tr>
				<td>
					* Címe:
				</td>
				<td>
					<input type="text" name="c_address" value="<?php echo "$caddress";?>" id="c_address" style="width: 330px"> (pl: 1108 Budapest, Kozma utca 8-10)
				</td>
			</tr>
			<tr>
				<td>
					* Ravatalozó / terem:
				</td>
				<td>
					<input type="text" name="c_funeral" value="<?php echo "$cfuneral";?>" id="c_funeral" style="width: 330px">
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
	<tr>
		<td>* Megrendelő neve: </td>
		<td> <input type="text" name="customer_name" value="<?php echo "$customer_name";?>"> </td>
	</tr>
	<tr>
		<td>* Telefonszáma: </td>
		<td> <input type="text" name="phone_number" value="<?php echo "$phone_number";?>"> </td>
	</tr>
	<tr>
		<td>Email címe: </td>
		<td> <input type="text" name="email" value="<?php echo "$email";?>"> </td>
	</tr>
	<tr>
		<td>Megjegyzés: </td>
		<td> <input type="text" name="note" value="<?php echo "$note";?>"> </td>
	</tr>
	<?php if ($paid != NULL) { ?>
	<tr>
		<td>Fizetve</td>
		<td> <input type="checkbox" name="paid" checked>  </td>
	</tr><?php } else { ?>
	<tr>
		<td>Fizetve </td>
		<td> <input type="checkbox" name="paid" >  </td>
	</tr> <?php } ?>
	<tr>
		<td>* Végösszeg: </td>
		<td> <input type="text" name="price" id="sum_price" class="huf" value="<?php echo number_format($price, 0, ',', ' ');?>">Ft </td>
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
		<td> <input type="text" name="remainder" id="remainder" value="<?php echo number_format($price-$downprice, 0, ',', ' ');?> Ft"></td>
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
	<?php if ($archive == 0) { ?>
	<tr>
		<td>Archiválás</td>
		<td> <input type="checkbox" name="archive" > </td>
	</tr>
	<?php } else { ?>
	<tr>
		<td>Archiválás</td>
		<td> <input type="checkbox" name="archive" checked > </td>
	</tr>
	<?php } ?>
</table>
<br>

<h1 class='title'>Koszorúk</h1>

<?php 
	$query_orderitems = "SELECT * FROM order_items WHERE order_id=".$_GET['order_id'].";";
	$result_orderitems = mysql_query($query_orderitems) or die(mysql_error());
	$ind = 0;
	while ($row = mysql_fetch_assoc($result_orderitems)) {

		// ORDER_ITEMS //
		$order_id = $row['order_id'];
		$is_offer = $row['is_offer'];
		$wreath_name = $row['wreath_name'];

		$azonosito = $row['azonosito'];
		$ribbon = $row['ribbon'];
		$ribboncolor = $row['ribboncolor'];
		$farewelltext = $row['farewelltext'];
		$givers = $row['givers'];
?>
<table class="order_data">
<?php
		if ($is_offer == 0) {
?>
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
					
					$query2 = "SELECT base_wreath_type.type AS type
								FROM special_wreath, base_wreath_type, base_wreath 
								WHERE (special_wreath.base_wreath_id = base_wreath.id) 
								AND (base_wreath.type = base_wreath_type.id) 
								AND (special_wreath.name = '".$wreath_name."')
								GROUP BY base_wreath_type.type";
					$result2 = mysql_query($query2) or die (mysql_error());
					while ($row = mysql_fetch_assoc($result)) {
						$wreath_type = $row['type'];
						while ($row2 = mysql_fetch_assoc($result2)) {
							$name = $row2['type'];
						}
						if ($name == $wreath_type) {
							$_SESSION['curr_wreath_type'] = $wreath_type;
							echo "<option selected>$wreath_type</option>";
						} else {
							echo "<option >$wreath_type</option>";
						}
					}
					?>
			</select>
		</td>
	</tr>
	<tr>
		<td>
			Koszorú: 
		</td>
		<td>
			<select id="wreath<?php echo $ind; ?>" name="wreath<?php echo $ind; ?>">
				<option disabled selected>Válasszon koszorút!</option>
				<?php
				$query = "SELECT special_wreath.id, special_wreath.name	
									FROM `special_wreath`, `base_wreath` 
									WHERE special_wreath.base_wreath_id = base_wreath.id
									AND base_wreath.type = (SELECT `id` FROM `base_wreath_type` WHERE `type`='".$_SESSION['curr_wreath_type']."')
									ORDER BY special_wreath.name ASC";
				$result = mysql_query($query) or die (mysql_error());

				while ($row = mysql_fetch_assoc($result)) {
					$each_wreath_name = $row['name'];
					if ($wreath_name == $each_wreath_name) {
						echo "<option selected>$wreath_name</option>";
					} else {
						echo "<option >$wreath_name</option>";
					}
				}
				?>
			 </select>
		</td>
	</tr>
<?php 
		} else { ?>
	<tr>
		<td>
			Ajánlat: 
		</td>
		<td>
			<select id="offer<?php echo $ind; ?>" name="offer<?php echo $ind; ?>">
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
							$border_time->sub(new DateInterval('P14D')); // Mai dátum - 14 nap
							$border_time = date_format($border_time, 'Y-m-d');

							if ($up_time > $border_time) {
								if ($wreath == $wreath_name) {
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
	</tr>
<?php } ?>
	<tr>
		<td>
			Azonosító: 
		</td>
		<td> 
			<input type="text" id="azonosito<?php echo $ind; ?>" name="azonosito<?php echo $ind; ?>" value="<?php echo $azonosito; ?>" placeholder="Azonosító">
		</td>
	</tr>
	<tr>
		<td> 
			Kér szalagot
		</td>
		<td>
			<?php if ($ribbon != "") { ?>
			<input type="checkbox" name="isRibbon<?php echo $ind; ?>" id="isRibbon<?php echo $ind; ?>" onChange="ribbonEnable(this.id);" checked>
			<?php } else { ?>
			<input type="checkbox" name="isRibbon<?php echo $ind; ?>" id="isRibbon<?php echo $ind; ?>" onChange="ribbonEnable(this.id);">
			<?php } ?>
		</td>
	</tr>
	<tr>
		<td></td>
		<td>
			<?php if ($ribbon != "") { ?>
			<select id="ribbon<?php echo $ind; ?>" name="ribbon<?php echo $ind; ?>" >
				<option disabled>Válassza ki a szalag típusát</option>";
				<?php 
				$query = "SELECT * FROM  `ribbon_type`";
				$result = mysql_query($query) or die(mysql_error());

				while ($row = mysql_fetch_assoc($result)) {
					$type = $row['type'];
					$note = $row['note'];
					if ($ribbon == $type) {
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
					$note = $row['note'];
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
			<?php if ($ribbon != "") { ?>
			<select id="ribboncolor<?php echo $ind; ?>" name="ribboncolor<?php echo $ind; ?>" >
				<option disabled >Válassza ki a szalag színét</option>";
				<?php 
					$query = "SELECT color FROM  `ribbon_color`";
					$result = mysql_query($query) or die(mysql_error());

					while ($row = mysql_fetch_assoc($result)) {
						$color = $row['color'];
						if ($ribboncolor == $color) {
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
			<?php if ($ribbon != "") { ?>
			<select id="farewelltext<?php echo $ind; ?>" name="farewelltext<?php echo $ind; ?>" >
				<option disabled >Válassza ki a búcsúszöveget</option>
				<?php
					$query2 = "SELECT * FROM `tape_title` ORDER BY id";
					$result2 = mysql_query($query2) or die (mysql_error());
					while ($row = mysql_fetch_assoc($result2)) {
						$id = $row['id'];
						$tapetext = "SZ$id - ".$row['text'];
						if ($farewelltext == $tapetext) {
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
						if ($farewelltext == $cittext) {
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
			<textarea style="resize: vertical;" cols="50" rows="5" id="givers<?php echo $ind; ?>" name="givers<?php echo $ind; ?>" placeholder="Akik adják"><?php echo $givers; ?></textarea>
		</td>
	</tr>
</table>
<?php
		$ind++;
	} ?>

	<br>
	<input type="submit" value="Módosítom!" class="button">
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