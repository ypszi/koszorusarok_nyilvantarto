<?php 
	session_start();
	include '../../../config.php';
?>
	<table>
		<tr>
			<td style="padding: 5px;">
				<input type="button" class="backward" value="" disabled> 
			<td style="padding: 5px;">
				<input type="button" class="forward" value="Tovább" onClick="if(check())toStep2();">
			</td>
		</tr>
	</table>
<!--
<table>
	<tr>
		<td>
			<input style="margin-left: 98px;" type="button" class="forward" value="Tovább" onClick="if(check())toStep2();">
		</td>
	</tr>
</table>
-->
<?php 
	if (isset($_GET['shipment'])) $_SESSION['shipment'] = $_GET['shipment'];
	if (isset($_GET["c_location"])) $_SESSION['clocation'] = $_GET['c_location'];
	if (isset($_GET["c_address"])) $_SESSION['caddress'] = $_GET['c_address'];
	if (isset($_GET["c_funeral"])) $_SESSION['cfuneral'] = $_GET['c_funeral'];

	if (isset($_GET['ritual_date'])) $_SESSION['ritual_date'] = $_GET['ritual_date'];
	if (isset($_GET['ritual_time'])) $_SESSION['ritual_time'] = $_GET['ritual_time'];
	if (isset($_GET['dead_name'])) $_SESSION['dead_name'] = $_GET['dead_name'];

	if (isset($_GET['customer_name'])) $_SESSION['customer_name'] = $_GET['customer_name'];
	if (isset($_GET['phone_num'])) $_SESSION['phone_num'] = $_GET['phone_num'];
	if (isset($_GET['email'])) $_SESSION['email'] = $_GET['email'];

	if (isset($_GET['end_price'])) $_SESSION['end_price'] = $_GET['end_price'];
	if (isset($_GET['sum_price'])) $_SESSION['price'] = $_GET['sum_price'];
	if (isset($_GET['ship_price'])) $_SESSION['ship_price'] = $_GET['ship_price'];

	if (isset($_GET['paid'])) {
		$_SESSION['paid'] = "Fizetve";
	} else {
		if ($_SESSION['paid'] != "Fizetve"){
			$_SESSION['paid'] = "";
			if (isset($_GET['downprice'])) $_SESSION['downprice'] = $_GET['downprice'];
			if (isset($_GET['remainder'])) $_SESSION['remainder'] = $_GET['remainder'];
		}
	}

	if (isset($_GET['order_note'])) $_SESSION['order_note'] = $_GET['order_note'];
	if (isset($_GET['shopname'])) $_SESSION['shopname'] = $_GET['shopname'];

	
		// echo "<pre>";
		// print_r($_SESSION['offer']);
		// echo "</pre>";
		// echo $_SESSION['offerNum'];

?>
<form id="step1">
	<table id="ord_wreath" style="float: left; width: 435px;">
		<tr>
			<td style="font: normal 16px/18px 'Arial'; color: #89a583;">
				Koszorú katalógus alapján
			</td>
			<td>
				<input type="button" value="Új sor hozzáadása" class="plus" onClick="addWreath();" >
			</td>
			<td>
				<input type="button" value="Utolsó sor törlése" class="minus" onClick="remWreathRow();" >
			</td>
			<td>
		<?php 
			echo '<input type="hidden" id="wreathnum" name="wreathnum" value="'.$_SESSION['wreathNum'].'">';
		?>
			</td>
		</tr>
<?php
	if (!isset($_GET['back'])) {
echo"	<tr>
			<td colspan='3'>
				<table id=\"ord_wreaths\" style=\"float: left;\">
					<tr>
						<td>
							<select id=\"wreath_type1\" name=\"wreath_type1\" onChange=\"loadCatalogWreathNames(this.id, 'wreath1');\">
								<option disabled selected>Válasszon koszorút típust!</option>";
									$query = "SELECT type FROM  `base_wreath_type` WHERE id != 15 ORDER BY type";
									$result = mysql_query($query) or die (mysql_error());
								
									while ($row = mysql_fetch_assoc($result)) {
										$wreath_type = $row['type'];
										echo "<option >$wreath_type</option>";
									}
					echo"	</select>
						</td>
					</tr>
					<tr>
						<td>
							<select id=\"wreath1\" name=\"wreath1\" onChange=\"document.getElementById('wreathnum').value = 1; loadWreathimg(this, 1);\" disabled>
								<option disabled selected>Válasszon koszorút!</option>
							 </select>
						</td>
					</tr>
					<tr>
						<td> 
							<input type=\"checkbox\" name=\"isRibbon1\" id=\"isRibbon1\" onChange=\"ribbonEnable(this.id);\">
							<label>Kér szalagot</label>
						</td>
					</tr>
					<tr>
						<td>
							<select id=\"ribbon1\" name=\"ribbon1\" disabled>
								<option disabled selected>Válassza ki a szalag típusát</option>";
								$query = "SELECT type, note FROM  `ribbon_type`";
								$result = mysql_query($query) or die(mysql_error());

								while ($row = mysql_fetch_assoc($result)) {
									$type = $row['type'];
									$note = $row['note'];
									echo "<option>$type</option>";
								}
					echo"	</select>
						</td>
					</tr>
					<tr>
						<td>
							<select id=\"ribboncolor1\" name=\"ribboncolor1\" disabled>
								<option disabled selected>Válassza ki a szalag színét</option>";
								$query = "SELECT color FROM  `ribbon_color`";
								$result = mysql_query($query) or die(mysql_error());

								while ($row = mysql_fetch_assoc($result)) {
									$color = $row['color'];
									echo "<option>$color</option>";
								}
			echo"	</td>	
					</tr>
					<tr>
						<td>
							<select id=\"farewelltext1\" name=\"farewelltext1\" disabled>
								<option disabled selected>Válassza ki a búcsúszöveget</option>";
									include 'farewelltext.php';
					echo"	</select>
						</td>
					</tr>
					<tr>
						<td>
							<textarea style=\"height: 64px;width: 225px;resize: vertical;\" cols=\"50\" rows=\"5\" id=\"givers1\" name=\"givers1\" placeholder=\"Akik adják\"></textarea>
						</td>
					</tr>
				</table>
							<img id='wreath_preview1' name='wreath_preview1' style='width: 165px; margin-top: 5px; float:left;'>
							<input type='hidden' id='wreath_preview_src1' name='wreath_preview_src1' value=''>
			</td>
		</tr>";
	} else {
		$ind = 1;
		if ($_SESSION['wreath'] != "") {
			foreach ($_SESSION['wreath'] as $wreath) { 
		echo"	<tr>
					<td colspan='3'>
						<table id=\"ord_wreaths\" style=\"float: left;\">
							<tr>
								<td>
									<select id=\"wreath_type".$ind."\" name=\"wreath_type".$ind."\" onChange=\"loadCatalogWreathNames(this.id, 'wreath".$ind."');\">
										<option disabled selected>Válasszon koszorút típust!</option>";
											$query = "SELECT type FROM  `base_wreath_type` ORDER BY type";
											$result = mysql_query($query) or die (mysql_error());
											
											$query2 = "SELECT base_wreath_type.type AS type
														FROM special_wreath, base_wreath_type, base_wreath 
														WHERE (special_wreath.base_wreath_id = base_wreath.id) 
														AND (base_wreath.type = base_wreath_type.id) 
														AND (special_wreath.name = '".$_SESSION['wreath'][$ind]."')
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
							echo"	</select>
								</td>
							</tr>
							<tr>
								<td>
									<select id=\"wreath".$ind."\" name=\"wreath".$ind."\" onChange=\"document.getElementById('wreathnum').value = ".$ind."; loadWreathimg(this, $ind);\" >
										<option disabled selected>Válasszon koszorút!</option>";
											$query = "SELECT special_wreath.id, special_wreath.name	
											FROM `special_wreath`, `base_wreath` 
											WHERE special_wreath.base_wreath_id = base_wreath.id
											AND base_wreath.type = (SELECT `id` FROM `base_wreath_type` WHERE `type`='".$_SESSION['curr_wreath_type']."')
											ORDER BY special_wreath.name ASC";
											$result = mysql_query($query) or die (mysql_error());

											while ($row = mysql_fetch_assoc($result)) {
												$wreath_name = $row['name'];
												if ($wreath == $wreath_name) {
													echo "<option selected>$wreath_name</option>";
												} else {
													echo "<option >$wreath_name</option>";
												}
											}
							echo"	</select>
								</td>
							</tr>
							<tr>
								<td>";
								if ($_SESSION["isRibbon"][$ind] == "") {
									echo"<input type=\"checkbox\" name=\"isRibbon".$ind."\" id=\"isRibbon".$ind."\" onChange=\"ribbonEnable(this.id);\">";
								} else {
									echo"<input type=\"checkbox\" name=\"isRibbon".$ind."\" id=\"isRibbon".$ind."\" onChange=\"ribbonEnable(this.id);\" checked>";
								}
									
							echo"	<label>Kér szalagot</label>
								</td>
							</tr>
							<tr>
								<td>";
						if ($_SESSION["isRibbon"][$ind] == "") {
							echo"	<select id=\"ribbon".$ind."\" name=\"ribbon".$ind."\" disabled>
										<option disabled selected>Válassza ki a szalag típusát</option>";
										$query = "SELECT * FROM  `ribbon_type`";
										$result = mysql_query($query) or die(mysql_error());

										while ($row = mysql_fetch_assoc($result)) {
											$type = $row['type'];
											$note = $row['note'];
											echo "<option>$type</option>";
										}
							echo"	</select>";
						} else {
							echo"	<select id=\"ribbon".$ind."\" name=\"ribbon".$ind."\" >
										<option disabled selected>Válassza ki a szalag típusát</option>";
										$query = "SELECT * FROM  `ribbon_type`";
										$result = mysql_query($query) or die(mysql_error());

										while ($row = mysql_fetch_assoc($result)) {
											$type = $row['type'];
											$note = $row['note'];
											if ($_SESSION['ribbon'][$ind] == $type) {
												echo "<option selected>$type</option>";
											} else {
												echo "<option>$type</option>";
											}
										}
							echo"	</select>";
						}
						echo"	</td>
							</tr>
							<tr>
								<td>";
								if ($_SESSION["isRibbon"][$ind] == "") {
									echo "<select id=\"ribboncolor".$ind."\" name=\"ribboncolor".$ind."\" disabled>
									<option disabled selected>Válassza ki a szalag színét</option>";
									$query = "SELECT color FROM `ribbon_color`";
									$result = mysql_query($query) or die(mysql_error());

									while ($row = mysql_fetch_assoc($result)) {
										$color = $row['color'];
										echo "<option>$color</option>";
									}
								} else {
									echo "<select id=\"ribboncolor".$ind."\" name=\"ribboncolor".$ind."\" >
										<option disabled selected>Válassza ki a szalag színét</option>";
										$query = "SELECT color FROM `ribbon_color`";
										$result = mysql_query($query) or die(mysql_error());

										while ($row = mysql_fetch_assoc($result)) {
											$color = $row['color'];
											if ($_SESSION['ribboncolor'][$ind] == $color) {
												echo "<option selected>$color</option>";
											} else {
												echo "<option>$color</option>";
											}
										}
									}
					echo"	</td>
							</tr>
							<tr>
								<td>";
								if ($_SESSION["isRibbon"][$ind] == "") {
							echo"	<select id=\"farewelltext".$ind."\" name=\"farewelltext".$ind."\" disabled>
										<option disabled selected>Válassza ki a búcsúszöveget</option>";
											include 'farewelltext.php';
							echo"	</select>";
						} else {
							echo"	<select id=\"farewelltext".$ind."\" name=\"farewelltext".$ind."\" >
										<option disabled selected>Válassza ki a búcsúszöveget</option>";
											$query2 = "SELECT * FROM `tape_title` ORDER BY id";
											$result2 = mysql_query($query2) or die (mysql_error());
											while ($row = mysql_fetch_assoc($result2)) {
												$id = $row['id'];
												$tapetext = "SZ$id - ".$row['text'];
												if ($_SESSION['farewelltext'][$ind] == $tapetext) {
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
												if ($_SESSION['farewelltext'][$ind] == $cittext) {
													echo "<option selected > $cittext </option>";
												} else {
													echo "<option>$cittext</option>";
												}
											}
							echo"	</select>";
						}
						echo"	</td>
							</tr>
							<tr>
								<td>";
								if ($_SESSION['givers'][$ind] == "") {
									echo "<textarea style=\"height: 64px;width: 225px;resize: vertical;\" id=\"givers".$ind."\" name=\"givers".$ind."\" placeholder=\"Akik adják\"></textarea>";
								} else {
									echo "<textarea style=\"height: 64px;width: 225px;resize: vertical;\" rows=\"5\" id=\"givers".$ind."\" name=\"givers".$ind."\">".$_SESSION['givers'][$ind]."</textarea>";
								}
						echo"	</td>
							</tr>
						</table>
						<img id='wreath_preview".$ind."' name='wreath_preview".$ind."' src='".$_SESSION['wreath_preview_src'][$ind]."' style='width: 165px; margin-top: 5px; float: left;'>
						<input type='hidden' id='wreath_preview_src".$ind."' name='wreath_preview_src".$ind."' value='".$_SESSION['wreath_preview_src'][$ind]."'>";
			echo"	</td>
				</tr>";
				$ind++;
			}
		} else {
			
echo"	<tr>
			<td colspan='3'>
				<table id=\"ord_wreaths\" style=\"float: left;\">
					<tr>
						<td>
							<select id=\"wreath_type1\" name=\"wreath_type1\" onChange=\"loadCatalogWreathNames(this.id, 'wreath1');\">
								<option disabled selected>Válasszon koszorút típust!</option>";
									$query = "SELECT type FROM  `base_wreath_type` ORDER BY type";
									$result = mysql_query($query) or die (mysql_error());
								
									while ($row = mysql_fetch_assoc($result)) {
										$wreath_type = $row['type'];
										echo "<option >$wreath_type</option>";
									}
					echo"	</select>
						</td>
					</tr>
					<tr>
						<td>
							<select id=\"wreath1\" name=\"wreath1\" onChange=\"document.getElementById('wreathnum').value = 1; loadWreathimg(this, 1);\" disabled>
								<option disabled selected>Válasszon koszorút!</option>
							 </select>
						</td>
					</tr>
					<tr>
						<td> 
							<input type=\"checkbox\" name=\"isRibbon1\" id=\"isRibbon1\" onChange=\"ribbonEnable(this.id);\">
							<label>Kér szalagot</label>
						</td>
					</tr>
					<tr>
						<td>
							<select id=\"ribbon1\" name=\"ribbon1\" disabled>
								<option disabled selected>Válassza ki a szalag típusát</option>";
								$query = "SELECT type, note FROM  `ribbon_type`";
								$result = mysql_query($query) or die(mysql_error());

								while ($row = mysql_fetch_assoc($result)) {
									$type = $row['type'];
									$note = $row['note'];
									echo "<option>$type</option>";
								}
					echo"	</select>
						</td>
					</tr>
					<tr>
						<td>
							<select id=\"ribboncolor1\" name=\"ribboncolor1\" disabled>
								<option disabled selected>Válassza ki a szalag színét</option>";
								$query = "SELECT color FROM  `ribbon_color`";
								$result = mysql_query($query) or die(mysql_error());

								while ($row = mysql_fetch_assoc($result)) {
									$color = $row['color'];
									echo "<option>$color</option>";
								}
			echo"	</td>	
					</tr>
					<tr>
						<td>
							<select id=\"farewelltext1\" name=\"farewelltext1\" disabled>
								<option disabled selected>Válassza ki a búcsúszöveget</option>";
									include 'farewelltext.php';
					echo"	</select>
						</td>
					</tr>
					<tr>
						<td>
							<textarea style=\"height: 64px;width: 225px;resize: vertical;\" cols=\"50\" rows=\"5\" id=\"givers1\" name=\"givers1\" placeholder=\"Akik adják\"></textarea>
						</td>
					</tr>
				</table>
							<img id='wreath_preview1' name='wreath_preview1' style='width: 165px; margin-top: 5px; float:left;'>
							<input type='hidden' id='wreath_preview_src1' name='wreath_preview_src1' value=''>
			</td>
		</tr>";
	
		}
	}
?>
	</table>

	<!-- AJÁNLATKÉRÉS ALAPJÁN -->

	<table id="ord_offer" style="float: left; width: 435px;">

		<tr>
			<td style="font: normal 16px/18px 'Arial'; color: #89a583;">
				Ajánlatkérés alapján
			</td>
			<td>
				<input type="button" value="Új sor hozzáadása" class="plus" onClick="addOffer();" >
			</td>
			<td>
				<input type="button" value="Utolsó sor törlése" class="minus" onClick="remOfferRow();" >
			</td>
			<td>
		<?php
			echo '<input type="hidden" id="offernum" name="offernum" value="'.$_SESSION['offerNum'].'">';
		?>
			</td>
		</tr>
<?php
	if (!isset($_GET['back'])) {
echo"	<tr>
			<td colspan='3'> 
				<table id=\"ord_offers\" style=\"float: left;\">
					<tr><td></td></tr>
					<tr>
						<td>
							<select id=\"offer1\" name=\"offer1\" onChange=\"document.getElementById('offernum').value = 1; var a = $(this).parent().next().children().first(); a.css('opacity', '0.3'); a.removeAttr('onclick');\" >
								<option disabled selected id=\"first_option1\">Válasszon ajánlatot!</option>";
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
											$border_time->sub(new DateInterval('P14D')); // Mai dátum - 6 hónap
											$border_time = date_format($border_time, 'Y-m-d');

											if ($up_time > $border_time) {
												echo "<option value='$wreath'>$wreath - $up_time</option>";
											}
										}
									}
					echo"	</select>
						</td>
						<td rowspan=\"3\">
							<input type=\"button\" value=\"Új ajánlat\" class=\"button\" onClick=\"new_offer(1);\" style=\"margin-bottom: 5px;\" >
							<input type=\"button\" value=\"Ajánlatot módosít\" class=\"button\" onClick=\"mod_offer(1);\" >
						</td>
					</tr>
				</table>
			</td>
		</tr>";
	} else {
		$ind = 1;
		if ($_SESSION['offer'] != "") {
			foreach ($_SESSION['offer'] as $offer) { 
		echo"	<tr>
					<td colspan='3'> 
						<table id=\"ord_offers\" style=\"float: left;\">
							<tr><td></td></tr>
							<tr>
								<td>
									<select id=\"offer".$ind."\" name=\"offer".$ind."\" onChange=\"var a = $(this).parent().next().children().first(); a.css('opacity', '0.3'); a.removeAttr('onclick');\">
										<option disabled id=\"first_option\">Válasszon ajánlatot!</option>";
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
														if ($wreath == $offer) {
															echo "<option value='$wreath' selected>$wreath - $up_time</option>";
														} else {
															echo "<option value='$wreath'>$wreath - $up_time</option>";
														}
													}
												}
											}
							echo"	</select>
								</td>
								<td rowspan=\"3\">
									<input type=\"button\" value=\"Új ajánlat\" class=\"button\" onClick=\"new_offer($ind);\" style=\"margin-bottom: 5px;\" >
									<input type=\"button\" value=\"Ajánlatot módosít\" class=\"button\" onClick=\"mod_offer($ind);\" >
								</td>
							</tr>
						</table>
					</td>
				</tr>";
				$ind++;
			}
		} else {
echo"	<tr>
			<td colspan='3'> 
				<table id=\"ord_offers\" style=\"float: left;\">
					<tr>
						<td>
							<select id=\"offer1\" name=\"offer1\" onChange=\"document.getElementById('offernum').value = 1; var a = $(this).parent().next().children().first(); a.css('opacity', '0.3'); a.removeAttr('onclick');\" >
								<option disabled selected id=\"first_option\">Válasszon ajánlatot!</option>";
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
					echo"	</select>
						</td>
						<td rowspan=\"3\">
							<input type=\"button\" value=\"Új ajánlat\" class=\"button\" onClick=\"new_offer(1);\" style=\"margin-bottom: 5px;\" >
							<input type=\"button\" value=\"Ajánlatot módosít\" class=\"button\" onClick=\"mod_offer(1);\" >
						</td>
					</tr>
				</table>
			</td>
		</tr>";
	
		}
	}
?>
	</table>
</form>