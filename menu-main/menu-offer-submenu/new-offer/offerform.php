<?php 
	// session_start();
	include '/config.php';
?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
	<link href="css/wformstyle.css" rel="stylesheet" type="text/css" media="all">
	<link href="css/alertwindow.css" rel="stylesheet" type="text/css" media="all">
	<style type="text/css">
		#from_copy {
			border-color: #F6F7CD;
			border-left: 15px solid #F6F7CD;
			border-style: solid;
			margin-top: 5px;
		}
		#from_catalogtable {
			border-style: solid;
			border-left-width: 15px;
			border-color: #D9EEB5;
			margin-top: 5px;
		}
		#from_catalogtable td {
			padding: 10px;
		}

		#shop_select_table {
			float: right;
			width: 230px;
			margin-top: 20px;
			margin-left: 5px;
		}
		#shop_select_table td {
			padding: 10px;
		}
	</style>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.0/jquery-ui.min.js"></script>
	<script type="text/javascript" src="js/protea_functions.js"></script>
</head>
<body onload="initTableRef();">

	<?php 

		$_SESSION['flowers'] = 0;
		$_SESSION['leafs'] = 0;
		$_SESSION['wprice'] = 0;
		$_SESSION['fprice'] = 0;
		$_SESSION['lprice'] = 0;

		if (!isset($conn)) {
			include '../../../config.php';
		}
	?>

	<?php if (isset($_GET['popup']) && ($_GET['popup'] == true)) { ?> <!-- Ha Megrendelésnél előugró ablak van /új v módosít/ -->
			<div class="exit" class="button" id="exit" style="display: block;" onClick="$('#new_offer').toggle();"> X </div>
	<?php } else { ?>
			<div id="alertwindow"></div>
	<?php } ?>

		<?php 
			if (isset($_GET['r_ajanlat'])) {
				echo '<form id="wreathform" method="POST" action="menu-main/menu-offer-submenu/new-offer/newoffer.php" enctype="multipart/form-data" >';
				echo '<input type="hidden" name="r_ajanlat" id="r_ajanlat" value="'.$_GET['r_ajanlat'].'" >';
			}

			if (!isset($_GET['ajanlat_type'])) { // HA NINCS ajanlat_type, AKKOR ÚJAT CSINÁLNAK, NEM MÓDOSÍTANAK

				##########################################################
				#
				# <-- Ajánlat adatainak betöltése meglévő ajánlat alapján
				#
				# $_view[]   = megejelenítendő adatok
				# $isPopup   = felugró ablakban jelenik-e meg a form
				# $load_copy = másolatot kell-e betölteni
				# $_c_...    = másolandó ajánlathoz tartozó adatok
				# 

				# másolandó ajánlat adatainak betöltése

					$load_copy = false;

					if (isset($_GET['copy_id'])) {
						$_c_id = intval($_GET['copy_id']);
						$query = "SELECT * FROM offer_wreath WHERE id=$_c_id";
						$result = mysql_query($query) or die (mysql_error());
						if ($row = mysql_fetch_assoc($result)) {
							$load_copy = true;
							$_c_name = $row['name'];
							$_c_base_wreath_id = $row['base_wreath_id'];
							$_c_calculate_price = $row['calculate_price'];
							$_c_sale_price = $row['sale_price'];
							$_c_ribbon_id = $row['ribbon_id'];
							$_c_note = $row['note'];
							$_c_shop = $row['shop'];
							$_c_is_order = $row['is_order'];
							$_c_left_for_us = $row['left_for_us'];

							$_view['copied_wreath_name'] = "$_c_name másolata";
							$_view['copied_note'] = "$_c_note";
							$_view['copied_left_for_us'] = ($_c_left_for_us) ? " checked" : "";

							# koszorú típusa

								$query = "SELECT type FROM base_wreath WHERE id=$_c_base_wreath_id";
								$result = mysql_query($query) or die (mysql_error());
								if ($row = mysql_fetch_assoc($result)) {
									$_c_wreath_type = $row['type'];
								}

							# koszorú alap <select> <option>-jei

								$query = "SELECT type, IF(id=$_c_wreath_type, ' selected', '') AS selected FROM base_wreath_type ORDER BY type ASC";
								$result = mysql_query($query) or die (mysql_error());
								$_view['copied_base_wreath_options'] = "";
								while ($row = mysql_fetch_assoc($result)) {
									$_view['copied_base_wreath_options'] .= "<option value='{$row['type']}'{$row['selected']}>{$row['type']}</option>";
								}

							# koszorú alaphoz tartozó méret <select> <option>-jei
							
								$_view['copied_base_wreath_size_options'] = "";
								$query = "SELECT size, flower_min, flower_max, IF(id=$_c_base_wreath_id, ' selected', '') AS selected FROM base_wreath WHERE type=$_c_wreath_type ORDER BY id";
								$result = mysql_query($query) or die (mysql_error());
								while ($row = mysql_fetch_assoc($result)) {
									$_view['copied_base_wreath_size_options'] .= "<option value='{$row['size']}'{$row['selected']}>{$row['size']} ({$row['flower_min']} - {$row['flower_max']})</option>";
								}

							# koszorú virágok <table>

								# koszorú virágainak száma
								$query = "SELECT type, color, priece, conect_flower_offer_wreath.price FROM conect_flower_offer_wreath
											 JOIN flower ON flower.id=conect_flower_offer_wreath.id_flower
											 AND conect_flower_offer_wreath.offer_wreath_id=$_c_id
											 AND flower.type NOT LIKE 'rezgő'
											 AND flower.type NOT LIKE 'levél'";
								$result = mysql_query($query) or die(mysql_error());
								$_SESSION['flowers'] = mysql_num_rows($result);
								$_view['copied_flowers_table_inner'] = "</td><td><input type='hidden' id='flowernum' name='flowernum' value='{$_SESSION['flowers']}'></td></tr>";
								$f_no = 1;
								while ($row = mysql_fetch_assoc($result)) {
									# virág típus
									$_view['copied_flowers_table_inner'] .= "<tr><td><select";
									$_view['copied_flowers_table_inner'] .= " id='flower$f_no'";
									$_view['copied_flowers_table_inner'] .= " name='flower$f_no'";
									$_view['copied_flowers_table_inner'] .= " onChange=\"loadFlowerColors(this, document.getElementById('color$f_no')); eraseFSubtotal();\">";
									$_view['copied_flowers_table_inner'] .= "<option disabled value=''>Válasszon virág típust!</option>";
									$sub_query = "SELECT type, IF(type='{$row['type']}', ' selected', '') AS selected FROM flower
													WHERE type NOT LIKE 'levél'
													AND type NOT LIKE 'rezgő'
													GROUP BY type
													ORDER BY type ASC";
									$sub_result = mysql_query($sub_query) or die(mysql_error());
									while ($sub_row = mysql_fetch_assoc($sub_result)) {
										$_view['copied_flowers_table_inner'] .= "<option value='{$sub_row['type']}'{$sub_row['selected']}>{$sub_row['type']}</option>";
									}
									$_view['copied_flowers_table_inner'] .= "</select></td>";
									# virág szín
									$_view['copied_flowers_table_inner'] .= "<td><select";
									$_view['copied_flowers_table_inner'] .= " id='color$f_no'";
									$_view['copied_flowers_table_inner'] .= " name='color$f_no'";
									$_view['copied_flowers_table_inner'] .= " onChange=\"calculatePrice_oForm(); writeFPrice_oForm(); ItemPrice($f_no);\">";
									$_view['copied_flowers_table_inner'] .= "<option disabled value=''>Válasszon virág színt!</option>";
									$sub_query = "SELECT color, IF(color='{$row['color']}', ' selected', '') AS selected FROM flower WHERE type='{$row['type']}' ORDER BY color";
									$sub_result = mysql_query($sub_query) or die(mysql_error());
									while ($sub_row = mysql_fetch_assoc($sub_result)) {
										$_view['copied_flowers_table_inner'] .= "<option value='{$sub_row['color']}'{$sub_row['selected']}>{$sub_row['color']}</option>";
									}
									$_view['copied_flowers_table_inner'] .= "</select></td>";
									# darabszám
									$_view['copied_flowers_table_inner'] .= "<td style=\'position: relative; left: -5px;\'>";
									$_view['copied_flowers_table_inner'] .= "<input type='text' class='db' id='qty$f_no' name='qty$f_no' max='99' min='1' value='{$row['priece']}' onChange='calculatePrice_oForm(); writeFPrice_oForm();' > db";
									$_view['copied_flowers_table_inner'] .= "</td>";
									# növelő gombok
									$_view['copied_flowers_table_inner'] .= "<td style=\'position: relative; left: -25px;\'>";
									$_view['copied_flowers_table_inner'] .= "<input type='button' class='inc_button' name='add_flower' onClick='document.getElementById(\"qty$f_no\").value++; calculatePrice_oForm(); writeFPrice_oForm();' value='+'/>";
									$_view['copied_flowers_table_inner'] .= " <input type='button' class='dec_button' name='subtract_flower' onClick='document.getElementById(\"qty$f_no\").value--; calculatePrice_oForm(); writeFPrice_oForm();' value='-' />";
									$_view['copied_flowers_table_inner'] .= "</td>";
									# egységár
									$_view['copied_flowers_table_inner'] .= "<td style='position: relative; left: -30px;'>";
									$_view['copied_flowers_table_inner'] .= "<input type='text' value='{$row['price']}' id='itemprice$f_no' name='itemprice$f_no' onChange='calculatePrice_oForm(); writeFPrice_oForm();' style'width: 40px;'> Ft / db";
									$_view['copied_flowers_table_inner'] .= "</td>";

									$_view['copied_flowers_table_inner'] .= "</tr>";
									$f_no++;
								}

							# koszorú levelek <table>

								$query = "SELECT type, color, priece, conect_flower_offer_wreath.price FROM conect_flower_offer_wreath
											 JOIN flower ON flower.id=conect_flower_offer_wreath.id_flower
											 AND conect_flower_offer_wreath.offer_wreath_id=$_c_id
											 AND flower.type LIKE 'levél'";
								$result = mysql_query($query) or die(mysql_error());
								$_SESSION['leafs'] = mysql_num_rows($result);
								$_view['copied_leafs_table_inner'] = "</td><td><input type='hidden' id='leafnum' name='leafnum' value='{$_SESSION['leafs']}'></td></tr>";
								$l_no = 1;
								while ($row = mysql_fetch_assoc($result)) {
									# levél típus
									$_view['copied_leafs_table_inner'] .= "<tr><td style='position: relative; left: 235px;'><select";
									$_view['copied_leafs_table_inner'] .= " id='leaf$l_no'";
									$_view['copied_leafs_table_inner'] .= " name='leaf$l_no'";
									$_view['copied_leafs_table_inner'] .= " onChange=\"calculatePrice_oForm(); writeLPrice_oForm(); LeafItemPrice($l_no);\">";
									$_view['copied_leafs_table_inner'] .= "<option disabled value=''>Válasszon Levelet!</option>";
									$sub_query = "SELECT color, IF(color='{$row['color']}', ' selected', '') AS selected FROM flower
													WHERE type LIKE 'levél'
													ORDER BY color ASC";
									$sub_result = mysql_query($sub_query) or die(mysql_error());
									while ($sub_row = mysql_fetch_assoc($sub_result)) {
										$_view['copied_leafs_table_inner'] .= "<option value='{$sub_row['color']}'{$sub_row['selected']}>{$sub_row['color']}</option>";
									}
									$_view['copied_leafs_table_inner'] .= "</select></td>";
									# darabszám
									$_view['copied_leafs_table_inner'] .= "<td style=\'position: relative; left: 245px;\'>";
									$_view['copied_leafs_table_inner'] .= "<input type='text' class='db' id='leafqty$l_no' name='leafqty$l_no' max='99' min='1' value='{$row['priece']}' onChange='calculatePrice_oForm(); writeFPrice_oForm();' > db";
									$_view['copied_leafs_table_inner'] .= "</td>";
									# növelő gombok
									$_view['copied_leafs_table_inner'] .= "<td style=\'position: relative; left: 182px;\'>";
									$_view['copied_leafs_table_inner'] .= "<input type='button' class='inc_button' name='add_leaf' onClick='document.getElementById(\"qty$l_no\").value++; calculatePrice_oForm(); writeFPrice_oForm();' value='+'/>";
									$_view['copied_leafs_table_inner'] .= " <input type='button' class='dec_button' name='subtract_leaf' onClick='document.getElementById(\"qty$l_no\").value--; calculatePrice_oForm(); writeFPrice_oForm();' value='-' />";
									$_view['copied_leafs_table_inner'] .= "</td>";
									# egységár
									$_view['copied_leafs_table_inner'] .= "<td style='position: relative; left: 137px;'>";
									$_view['copied_leafs_table_inner'] .= "<input type='text' value='{$row['price']}' id='leafitemprice$l_no' name='leafitemprice$f_no' onChange='calculatePrice_oForm(); writeFPrice_oForm();' style'width: 40px;'> Ft / db";
									$_view['copied_leafs_table_inner'] .= "</td>";

									$_view['copied_leafs_table_inner'] .= "</tr>";
									$l_no++;
								}

							# rezgő 

								$query = "SELECT priece, conect_flower_offer_wreath.price FROM conect_flower_offer_wreath
											 JOIN flower ON flower.id=conect_flower_offer_wreath.id_flower
											 AND conect_flower_offer_wreath.offer_wreath_id=$_c_id
											 AND flower.type LIKE 'rezgő'";
							 	$result = mysql_query($query) or die(mysql_error());
								$_view['copied_vibr_checkbox'] = "<input type='checkbox' id='rezgo' name='rezgo' value='rezgo' onChange='rezgoqtyEnable_oForm(); calculatePrice_oForm(); writeLPrice_oForm();'" . (mysql_num_rows($result) ? " checked" : "") . ">'";
								$_c_vibr_num = 0;
								if ($row = mysql_fetch_assoc($result)) {
									$_c_vibr_num = $row['priece'];
								}
								$_view['copied_vibr_num'] = "<input type='text' class='db' id='rezgoqty' name='rezgoqty' max='99' min='0' value='$_c_vibr_num' onChange='calculatePrice_oForm(); writeLPrice_oForm();'> db";

							# szalag

								$query = "SELECT * FROM offer_wreath JOIN ribbons ON ribbons.id=offer_wreath.ribbon_id AND offer_wreath.id=$_c_id";
								$result = mysql_query($query) or die(mysql_error());
								$_view['copied_ribbon_checked'] = "";
								$_view['copied_ribbon_disabled'] = " disabled";
								$_view['copied_ribbon_type_options'] = "";
								$_view['copied_ribbon_color_options'] = "";
								$_view['copied_ribbon_farewell_options'] = "";
								$_view['copied_ribbon_price'] = "";
								$_view['copied_ribbon_givers'] = "";
								if ($row = mysql_fetch_assoc($result)) {
									$_view['copied_ribbon_checked'] = " checked";
									$_view['copied_ribbon_disabled'] = "";
									$sub_query = "SELECT type, IF(type='{$row['ribbon']}', ' selected', '') AS selected FROM ribbon_type";
									$sub_result = mysql_query($sub_query) or die(mysql_error());
									while ($sub_row = mysql_fetch_assoc($sub_result)) {
										$_view['copied_ribbon_type_options'] .= "<option{$sub_row['selected']}>{$sub_row['type']}</option>";
									}
									$sub_query = "SELECT color, IF(color='{$row['ribboncolor']}', ' selected', '') AS selected FROM ribbon_color";
									$sub_result = mysql_query($sub_query) or die(mysql_error());
									while ($sub_row = mysql_fetch_assoc($sub_result)) {
										$_view['copied_ribbon_color_options'] .= "<option{$sub_row['selected']}>{$sub_row['color']}</option>";
									}
									$sub_query = "SELECT
									 id,
									 CONCAT('SZ', id, ' - ', text) AS full_text,
									 IF(CONCAT('SZ', id, ' - ', text)='{$row['farewelltext']}', ' selected', '') AS selected
									 FROM tape_title
									 UNION
									 SELECT
									  id + 10000 AS id,
									  CONCAT('ID', id, ' - ', text) AS full_text,
									  IF(CONCAT('ID', id, ' - ', text)='{$row['farewelltext']}', ' selected', '') AS selected
									  FROM citation ORDER BY id";
									$sub_result = mysql_query($sub_query) or die(mysql_error());
									while ($sub_row = mysql_fetch_assoc($sub_result)) {
										$_view['copied_ribbon_farewell_options'] .= "<option{$sub_row['selected']}>{$sub_row['full_text']}</option>";
									}
									$_view['copied_ribbon_price'] = $row['price'];
									$_view['copied_ribbon_givers'] = $row['givers'];
								}
						}
					}

				# felugró ablakkal dolgozunk-e?

					$isPopup = isset($_GET['popup']) && $_GET['popup'] == true;

				# elmúlt egy heti ajánlatok <option> tagjeinek generálása

					$query = "SELECT id, name, up_time FROM offer_wreath WHERE archive = 0 AND up_time BETWEEN DATE_SUB(NOW(), INTERVAL 1 WEEK) AND NOW() ORDER BY up_time DESC";
					$result = mysql_query($query) or die (mysql_error());
					$_view['latest_offers'] = "";
					while ($row = mysql_fetch_assoc($result)) {
						$copy_selected = ($load_copy && $row['id'] == $_c_id) ? " selected" : "";
						$_view['latest_offers'] .= "<option value='{$row['id']}'$copy_selected>{$row['name']} - {$row['up_time']}</option>";
					}

				# korábbi ajánlatot betöltő javascript függvény paraméterei (ablakos vagy sima ajánlat készítés)

					$_view['js']['load_previous_offer__onclick'] = "loadWreathfromOffer('" . ($isPopup ? "new_offer" : "right-content") . "'" . ($isPopup ? ", {$_GET['ajanlat_id']}" : "") . ")";

				# 
				# Ajánlat adatainak betöltése meglévő ajánlat alapján -->
				#
				##########################################################
		?>
		<form id="wreathform" method="POST" action="" enctype="multipart/form-data">
		<table id="from_copy">
			<tr>
				<td colspan="2" style="font: normal 16px/18px 'Arial'; color: #89a583; padding: 8px;">Adatok betöltése korábbi ajánlat alapján</td>
			</tr>
			<tr>
				<td style="padding: 8px;">
					<select id="copy_id" style="width: 350px;">
						<optgroup label="Az elmúlt egy hét ajánlatai"><?php echo $_view['latest_offers']; ?></optgroup>
					</select>
				</td>
				<td style="padding: 8px;">
					<input id="load_previous_offer" class="plus" type="button" value="Ajánlat adatainak betöltése" onclick="<?php echo $_view['js']['load_previous_offer__onclick']; ?>">
				</td>
			</tr>
		</table>
		<table id="from_catalogtable">
			<tr>
				<td style="font: normal 16px/18px 'Arial'; color: #89a583;">
					<?php
					if (isset($_GET["ajanlat_id"])) {
						$ajanlat_id = $_GET["ajanlat_id"];
					} else {
						$ajanlat_id = "";
					}
					
					if (isset($_GET['wreath_type'])) {
						echo '<input type="checkbox" id="from_catalog" onChange="wreathfromcatalog('.$ajanlat_id.');" style="vertical-align: baseline;" checked> <label style="font: normal 16px/18px \'Arial\'; color: #89a583;">Koszorú katalógus alapján történő ajánlatkészítés</label>';
					} else {
						echo '<input type="checkbox" id="from_catalog" onChange="wreathfromcatalog('.$ajanlat_id.');" style="vertical-align: baseline;" > <label style="font: normal 16px/18px \'Arial\'; color: #89a583;">Koszorú katalógus alapján történő ajánlatkészítés</label>';
					} ?>
				</td>
				<td rowspan="2" style="padding: 0px;">
					<?php if (isset($_GET['wreath_type'])) { 
						$wreath_name = $_GET['wreath_size'];
						$query = "SELECT picture FROM `special_wreath` WHERE name='$wreath_name'";
						$result = mysql_query($query) or die(mysql_error());
						while ($row = mysql_fetch_assoc($result)) {
							$pic = explode("|", $row["picture"]);
							$pic_src = $conf_path_abs."img/wreath/".$pic[0];
						}
					?>
						<table><tr><td style="padding: 0px;">
							<input type="hidden" id="hidd_prev_img_catwreath" >
							<a href="<?php echo $pic_src; ?>" target="_blank">
							<img src="<?php echo $pic_src; ?>" id="prev_img_catwreath" style="width: 95px; visibility: visible;">
							</a>
						</td></tr></table>
					<?php } else { ?>
						<table>
						<tr>
							<td style="padding: 0px;">
								<input type="hidden" id="hidd_prev_img_catwreath" >
								<img src="" id="prev_img_catwreath" style="width: 95px; visibility: hidden;">
							</td>
						</tr>
						</table>
					<?php } ?>
				</td>
			</tr>
			<tr>
				<td>
					<?php
						if (isset($_GET['wreath_type'])) { ?> <!-- HA VÁLASZOTT KATALOGUS ALAPJÁN -->
							<table id="wreath_from_catalog"> 
								<tr><td>
										<select id="wreath_type" onChange="loadCatalogWreathNames(this.id, 'wreath_size');" style="margin-right: 5px;">
											<option>Válasszon koszorú típust</option>
											<?php 
												$query = "SELECT type FROM  `base_wreath_type` ORDER BY type ASC;";
												$result = mysql_query($query) or die (mysql_error());
											
												while ($row = mysql_fetch_assoc($result)) {
													$base_wreath_type = $row['type'];
													if ($_GET['wreath_type'] == $base_wreath_type) {
														echo "<option value=\"$base_wreath_type\" selected>$base_wreath_type</option>";
													} else {
														echo "<option value=\"$base_wreath_type\" >$base_wreath_type</option>";
													}
													
												}
											?>
										</select>
								</td><td>
									<?php  // isset($_GET['popup']) && $_GET['popup'] == true)
									if (isset($_GET['wreath_type']) ) {
										if (isset($_GET['popup']) && $_GET['popup'] == true) {
											echo '<select id="wreath_size" onChange="loadWreathfromCatalog(\'new_offer\', '.$_GET['ajanlat_id'].'); loadWreathimg(this);" >';
										} else {
											echo '<select id="wreath_size" onChange="loadWreathfromCatalog(\'right-content\'); loadWreathimg(this);" >';
										}
									} else {
										echo '<select id="wreath_size" onChange="loadWreathfromCatalog(\''.$_GET['offer_div'].'\', '.$_GET['ajanlat_id'].'); loadWreathimg(this);" >';
									}
									?>
									<option disabled value="" >Válasszon koszorút!</option>
									<?php 
										$catalogwreathnames=$_GET['wreath_type'];
										$query = "SELECT special_wreath.id, special_wreath.name
													FROM `special_wreath`, `base_wreath` 
													WHERE special_wreath.base_wreath_id = base_wreath.id
													AND base_wreath.type = (SELECT `id` FROM `base_wreath_type` WHERE `type`='$catalogwreathnames')
													ORDER BY special_wreath.name ASC";
										$result = mysql_query($query) or die (mysql_error());

										while ($row = mysql_fetch_assoc($result)) {
											$base_wreath_name = $row['name'];
											if ($_GET['wreath_size'] == $base_wreath_name) {
												echo "<option value=\"$base_wreath_name\" selected>$base_wreath_name</option>";
											} else {
												echo "<option value=\"$base_wreath_name\" >$base_wreath_name</option>";
											}
										}
									?>
										</select>
								</td></tr>
			<?php	}	else { ?>
					<table id="wreath_from_catalog" style="display: none;">
						<?php } ?>
					</table>
				</td>
			</tr>
		</table>

		<table id="wreath" style="border-style:solid; border-left-width:15px; border-color:#c8dba6; margin-top: 5px;">
			<tr>
				<td colspan="2" style="font: normal 16px/18px 'Arial'; color: #89a583;"> Adja meg a koszorú kódját/nevét! </td>
			</tr> 
			<tr>
				<td style="font: normal 16px/18px 'Arial'; color: #89a583;">
					<?php 
					if ($load_copy) {
						?>
						<input type="text" name="wreath_name" id="wreath_name" style="width: 206px;" placeholder="Fantázia név" value="<?php echo $_view['copied_wreath_name']; ?>">
						<?php
					} else if (isset($_GET['wreath_size'])) {
						$query = "SELECT fancy FROM special_wreath WHERE name = '".$_GET['wreath_size']."'";
						$result = mysql_query($query) or die (mysql_error());
						while ($row = mysql_fetch_assoc($result)) {
							$fancy = $row['fancy'];
						}
						echo '<input type="text" name="wreath_name" id="wreath_name" style="width: 206px;" placeholder="Fantázia név" value="'.$fancy.'" >';
					} else {
						echo '<input type="text" name="wreath_name" id="wreath_name" style="width: 206px;" placeholder="Fantázia név" >';
					} ?>
					
				</td>
				<td style="font: normal 16px/18px 'Arial'; color: #89a583; position: relative; right: -28px;">
					<?php
					if ($load_copy) {
						?>
						<textarea style="resize: none; width: 510px;" name="note" id="note" rows="3" cols="100" maxlength="500" placeholder="Termék leírása"><?php echo $_view['copied_note'] ?></textarea>
						<?php
					} else if (isset($_GET['wreath_size'])) {
						$query = "SELECT note FROM special_wreath WHERE name = '".$_GET['wreath_size']."'";
						$result = mysql_query($query) or die (mysql_error());
						while ($row = mysql_fetch_assoc($result)) {
							$note = $row['note'];
						}
						echo '<textarea style="resize: none; width: 510px;" name="note" id="note" rows="3" cols="100" maxlength="500" placeholder="Termék leírása">'.$note.'</textarea>';
					} else {
						echo '<textarea style="resize: none; width: 510px;" name="note" id="note" rows="3" cols="100" maxlength="500" placeholder="Termék leírása"></textarea>';
					} ?>
				</td>
			</tr>
			<tr class="topborder"> 
				<td colspan="2" style="font: normal 16px/18px 'Arial'; color: #89a583;"> Adja meg a koszorú alapját! </td>
			</tr>
			<tr>
				<td> <select id="base_wreath_type" name="base_wreath_type" onChange="loadBaseWreathSizes_oForm(this.id, 'base_wreath_size'); eraseWSubtotal(); ">
						<?php
						if ($load_copy) {
							echo $_view['copied_base_wreath_options'];
						} else {
							if (isset($_GET['wreath_type'])) {
								echo "<option disabled value='' >Válasszon koszorú alapot!</option>";
							} else {
								echo "<option disabled value='' selected>Válasszon koszorú alapot!</option>";
							}
							$query = "SELECT type FROM  `base_wreath_type` ORDER BY type ASC;";
							$result = mysql_query($query) or die (mysql_error());
						
							while ($row = mysql_fetch_assoc($result)) {
								$base_wreath_type = $row['type'];
								if (isset($_GET['wreath_type'])) {
									if ($_GET['wreath_type'] == $base_wreath_type) {
										echo "<option value='$base_wreath_type' selected>$base_wreath_type</option>";
									} else {
										echo "<option value='$base_wreath_type' >$base_wreath_type</option>";
									}
								} else {
									echo "<option value='$base_wreath_type' >$base_wreath_type</option>";
								}
							}
						}
						?>
					 </select>
				</td>
				<td style="position: relative; left: 18px;"> 
					<?php if (!isset($_GET['wreath_size']) && !$load_copy) {
						echo '<select id="base_wreath_size" name="base_wreath_size" onChange="calculatePrice_oForm(); writeWPrice_oForm();" disabled >';
					} else {
						echo '<select id="base_wreath_size" name="base_wreath_size" onChange="calculatePrice_oForm(); writeWPrice_oForm();" >';
					} ?>
					<?php if (!isset($_GET['wreath_size']) && !$load_copy) {
						echo '<option disabled value="" selected>Először válasszon koszorú alapot!</option>';
					} else if ($load_copy) {
						?><option disabled value="">Válasszon koszorút!</option><?php
						echo $_view['copied_base_wreath_size_options'];
					} else {
						echo '<option disabled value="" >Válasszon koszorút!</option>';
						$query = "SELECT base_wreath.size FROM special_wreath, base_wreath WHERE name = '".$_GET['wreath_size']."' AND special_wreath.base_wreath_id = base_wreath.id";
						$result = mysql_query($query) or die (mysql_error());
						while ($row = mysql_fetch_assoc($result)) {
							$curr_size = $row['size'];
						}

						$query = "SELECT size FROM `base_wreath` WHERE TYPE = ( SELECT id FROM `base_wreath_type` WHERE TYPE = '".$_GET['wreath_type']."' );";
						$result = mysql_query($query) or die (mysql_error());

						while ($row = mysql_fetch_assoc($result)) {
							$base_wreath_size=$row['size'];

							if ($curr_size == $base_wreath_size) {
								echo "<option value='$base_wreath_size' selected> $base_wreath_size";
							} else {
								echo "<option value='$base_wreath_size' > $base_wreath_size";
							}
							
							$query = "SELECT flower_min FROM  `base_wreath` WHERE size='".$row['size']."'";
							$resultmin = mysql_query($query) or die (mysql_error());

							while ($rowmin = mysql_fetch_assoc($resultmin)) {
								$size = $rowmin['flower_min'];
								echo " ($size";
							}
							
							echo " - ";

							$query = "SELECT flower_max FROM  `base_wreath` WHERE size='".$row['size']."'";
							$resultmax = mysql_query($query) or die (mysql_error());

							while ($rowmax = mysql_fetch_assoc($resultmax)) {
								$size = $rowmax['flower_max'];
								echo "$size)";
							}

							echo "</option>";
						}
					} ?>
						
					</select>
				</td>
				<table class="subtotal">
					<tr>
						<td id="wprice"> Részösszeg: </td> <td id="wsubtotal" style="position: relative;left: 5px; margin-top: 5px;">0 Ft</td>
					</tr>
				</table>
			</tr>
		</table>

		<table style="border-style: solid; border-left-width: 15px; border-color: #7c9e75; margin-top: 5px;">
			<tr>
				<td style="padding: 10px;">
					<input type="checkbox" name="left_for_us" id="left_for_us" onchange="leftForUs();" style="vertical-align: baseline;"<?php echo ($load_copy ? $_view['copied_left_for_us'] : ""); ?>>
					<label for="left_for_us" style="font: normal 16px/18px 'Arial'; color: #89a583; vertical-align: baseline;">Koszorúkötőre bízva az összeállítás és a virágszín</label>
				</td>
			</tr>
		</table>
		<?php if ($load_copy && $_c_left_for_us) : ?>
			<script>
				leftForUs();
			</script>
		<?php endif; ?>

		<table id="flower" style="border-style:solid; border-left-width:15px; border-color:#c8dba6; margin-top: 5px;">
			<tr class="topborder"> 
				<td colspan="4" style="font: normal 16px/18px 'Arial'; color: #89a583;"> Adja meg a koszorú virágait!
					<input type="button" value="Új összetevő" class="plus" style="width: 80px;" onClick="addFlowerRow_oForm();" >
					<input type="button" value="Utolsó összetevő eltávolítása" class="minus" style="width: 180px;" onClick="remFlowerRow_oForm(); calculatePrice_oForm(); writeFPrice_oForm();" ></td>
			<?php
			if (isset($_GET['wreath_type'])) {
				$query = "SELECT id FROM `special_wreath` WHERE name = '".$_GET['wreath_size']."' ";
				$result = mysql_query($query) or die(mysql_error());
				while ($row = mysql_fetch_assoc($result)) {
					$special_wreath_id = $row['id'];
				}

				$query2 = "SELECT id_flower FROM `conect_flower_special_wreath` WHERE conect_flower_special_wreath.special_wreath_id = $special_wreath_id ";
				$result2 = mysql_query($query2) or die(mysql_error());
				$flowernum = mysql_num_rows($result2);

				$fnum = 0;
				for ($i=0; $i < $flowernum; $i++) { 
					$limit = "$i, 1";
					$query_swreath_id = "SELECT id_flower FROM `conect_flower_special_wreath` WHERE special_wreath_id = $special_wreath_id LIMIT $limit";
					$result_swreath_id = mysql_query($query_swreath_id) or die(mysql_error());
					while ($row_id = mysql_fetch_assoc($result_swreath_id)) {
						$swreath_id_flower = $row_id['id_flower'];
					}
					$query3 = "SELECT type FROM `flower` WHERE id=$swreath_id_flower";
					$result3 = mysql_query($query3) or die(mysql_error());
					while ($row = mysql_fetch_assoc($result3)) {
						if ($row['type'] != "levél" && $row['type'] != "rezgő") {
							$fnum++;
						}
					}
				}

				$_SESSION['flowers'] = $fnum;
				echo 	'<td><input type="hidden" id="flowernum" name="flowernum" value="'.$fnum.'"></td>';
				?>
				</tr>
				<script type="text/javascript">
					function loadFlowerColors(ftype,fcolor) {
						$.ajax({
							type: "GET",
							url: "menu-main/menu-setting-submenu/wreath/flowercolors.php?flowertype=" + ftype.value,
							success: function(data){
								fcolor.disabled = "";
								$(fcolor).html(data);
							}
						}); 
					}

					function ItemPrice(id) {
						var ftype = document.getElementById('flower'+id).value;
						var fcolor = document.getElementById('color'+id).value;

						$.ajax({
							type: "GET",
							url: "menu-main/menu-offer-submenu/new-offer/itemprice.php?ftype="+ftype+"&fcolor="+fcolor,
							success: function(data){
								$("#itemprice"+id).val(data);
							}
						}); 
					}
				</script>
				<?php 
				$flowernum = 1;
				for ($i=0; $i < $fnum; $i++) { ?>
				<tr>
					<td>
						<select id="<?php echo "flower".$flowernum; ?>" name="<?php echo "flower".$flowernum; ?>" onChange="loadFlowerColors(this, document.getElementById('<?php echo "color".$flowernum;?>')); eraseFSubtotal();">
							<option disabled value="" selected>Válasszon virág típust!</option>
							<?php 
							$limit = "$i, 1";
							$query = "SELECT type FROM  `flower` WHERE type NOT LIKE 'levél' AND type NOT LIKE 'rezgő' GROUP BY type ORDER BY type ASC;";
							$result = mysql_query($query) or die (mysql_error());

							$query2 = "SELECT flower.type FROM  `conect_flower_special_wreath`, `flower` WHERE conect_flower_special_wreath.special_wreath_id = $special_wreath_id AND flower.id = id_flower AND flower.type NOT LIKE 'rezgő' AND flower.type NOT LIKE 'levél' LIMIT $limit";
							$result2 = mysql_query($query2) or die(mysql_error());
							while ($row = mysql_fetch_assoc($result2)) {
								$curr_flowertype = $row['type'];
							}

							while ($row = mysql_fetch_assoc($result)) {
								$flowertype = $row['type'];
								if ($curr_flowertype == $flowertype) {
									echo "<option value='$flowertype' selected>$flowertype</option>";
								} else {
									echo "<option value='$flowertype' >$flowertype</option>";
								}
							}
							?>
						</select>
					</td>

					<td>
						<select id="<?php echo "color".$flowernum; ?>" name="<?php echo "color".$flowernum; ?>" onChange="calculatePrice_oForm(); writeFPrice_oForm(); ItemPrice(<?php echo $flowernum; ?>);" >
							<option disabled value="" selected>Válasszon virág színt!</option>
							<?php 
							$query = "SELECT color FROM  `flower` WHERE type='$curr_flowertype' ORDER BY color ASC";
							$result = mysql_query($query) or die (mysql_error());

							$query2 = "SELECT flower.color FROM  `conect_flower_special_wreath`, `flower` WHERE conect_flower_special_wreath.special_wreath_id = $special_wreath_id AND flower.id = id_flower AND flower.type NOT LIKE 'levél' AND flower.type NOT LIKE 'rezgő' LIMIT $limit";
							$result2 = mysql_query($query2) or die(mysql_error());
							while ($row = mysql_fetch_assoc($result2)) {
								$curr_flowercolor = $row['color'];
							}

							while ($row = mysql_fetch_assoc($result)) {
								$flowercolor = $row['color'];
								if ($curr_flowercolor == $flowercolor) {
									echo "<option value='$flowercolor' selected>$flowercolor</option>";
								} else {
									echo "<option value='$flowercolor' >$flowercolor</option>";
								}
							}
							?>
						</select>
					</td>
					<?php echo '<script type="text/javascript"> ItemPrice("'.$flowernum.'");</script>'; ?>

					<td style="position: relative; left: -5px;"> 
						<?php 
						$query = "SELECT conect_flower_special_wreath.priece FROM  `conect_flower_special_wreath`, `flower` WHERE conect_flower_special_wreath.special_wreath_id = $special_wreath_id AND flower.id = id_flower AND flower.type NOT LIKE 'levél' AND flower.type NOT LIKE 'rezgő' LIMIT $limit";
						$result = mysql_query($query) or die(mysql_error());
						while ($row = mysql_fetch_assoc($result)) {
							$curr_flowerqty = $row['priece'];
							echo '<input type="text" class="db" id="qty'.$flowernum.'" name="qty'.$flowernum.'" max="99" min="1" value="'.$curr_flowerqty.'" onChange="calculatePrice_oForm(); writeFPrice_oForm();" > db';
						}
						?>
					</td>
					<td style="position: relative; left: -25px;">
						<input type='button' class="inc_button" name='add_flower' onClick='document.getElementById("<?php echo "qty".$flowernum; ?>").value++; calculatePrice_oForm(); writeFPrice_oForm();' value='+'/>
						<input type='button' class="dec_button" name='subtract_flower' onClick='document.getElementById("<?php echo "qty".$flowernum; ?>").value--; calculatePrice_oForm(); writeFPrice_oForm();' value='-' />
					</td>
					<td style="position: relative; left: -30px;">
						<input type="text" value="" id="<?php echo "itemprice".$flowernum; ?>" name="<?php echo "itemprice".$flowernum; ?>" onChange="calculatePrice_oForm(); writeFPrice_oForm();" style="width: 40px;"> Ft / db
					</td>
					</tr>
					<?php $flowernum++;
				}
			} else if ($load_copy && !$_c_left_for_us) {
				echo $_view['copied_flowers_table_inner'];
			} else {
				echo '<td><input type="hidden" id="flowernum" name="flowernum" value="1"></td>
				</tr>
				<tr>';
				include 'flowerrow.php';
				echo '</tr>';
			}?>
				<table class="subtotal toHide">
					<tr>
						<td id="fprice"> Részösszeg: </td> <td id="fsubtotal" style="position: relative;left: 5px; margin-top: 5px;">0 Ft</td>
					</tr>
				</table>
		</table>

		<table id="leaf" style="border-style:solid; border-left-width:15px; border-color:#9db88a; margin-top: 5px;"> 
			<tr class="topborder"> 
				<td colspan="4" style="font: normal 16px/18px 'Arial'; color: #89a583;"> Adja meg a koszorú leveleit! 
					<input type="button" value="Új összetevő" class="plus" style="width: 80px;" onClick="addLeafRow_oForm();" >
					<input type="button" value="Utolsó összetevő eltávolítása" class="minus" style="width: 180px;" onClick="remLeafRow_oForm(); calculatePrice_oForm(); writeLPrice_oForm();" ></td>
				<?php
					if (isset($_GET['wreath_type'])) {
						$query = "SELECT id FROM `special_wreath` WHERE name = '".$_GET['wreath_size']."' ";
						$result = mysql_query($query) or die(mysql_error());
						while ($row = mysql_fetch_assoc($result)) {
							$special_wreath_id = $row['id'];
						}

						$query = "SELECT conect_flower_special_wreath.id_flower FROM `conect_flower_special_wreath`, `flower` WHERE conect_flower_special_wreath.special_wreath_id = $special_wreath_id AND conect_flower_special_wreath.id_flower = flower.id";
						$result = mysql_query($query) or die(mysql_error());
						$leafnum = mysql_num_rows($result);

						$lnum = 0;
						for ($i=0; $i < $leafnum; $i++) { 
							$limit = "$i, 1";
							$query_swreath_id = "SELECT id_flower FROM `conect_flower_special_wreath` WHERE special_wreath_id=$special_wreath_id LIMIT $limit";
							$result_swreath_id = mysql_query($query_swreath_id) or die(mysql_error());
							while ($row = mysql_fetch_assoc($result_swreath_id)) {
								$swreath_id_flower = $row['id_flower'];
							}

							$query2 = "SELECT type FROM `flower` WHERE id=$swreath_id_flower";
							$result2 = mysql_query($query2) or die(mysql_error());
							while ($row = mysql_fetch_assoc($result2)) {
								if ($row['type'] == "levél") {
									$lnum++;
								}
							}
						}

						$_SESSION['leafs'] = $lnum;
						echo 	'<td><input type="hidden" id="leafnum" name="leafnum" value="'.$lnum.'"></td>';
						?>
						</tr>
						<script type="text/javascript">
							function LeafItemPrice(id) {
								var leaf = document.getElementById('leaf'+id).value;
								var leafqty = document.getElementById('leafqty'+id).value;

								$.ajax({
									type: "GET",
									url: "menu-main/menu-offer-submenu/new-offer/leafitemprice.php?leaf="+leaf,
									success: function(data){
									$("#leafitemprice"+id).val(data);
									}
								}); 
							}
						</script>
						<?php
						$leafnum = 1;
						for ($i=0; $i < $lnum; $i++) { ?>
							<tr>
								<td style="position: relative; left: 235px;">
									<select id="<?php echo "leaf".$leafnum; ?>" name="<?php echo "leaf".$leafnum; ?>" onChange="calculatePrice_oForm(); writeLPrice_oForm(); LeafItemPrice(<?php echo $leafnum; ?>);" >
										<option disabled value="" selected>Válasszon Levelet!</option>
										<?php 
											$limit = "$i, 1";
											$query = "SELECT color FROM  `flower` WHERE type='levél' ORDER BY color ASC;";
											$result = mysql_query($query) or die (mysql_error());

											$query2 = "SELECT flower.color FROM  `conect_flower_special_wreath` ,  `flower` WHERE conect_flower_special_wreath.special_wreath_id = $special_wreath_id AND flower.id = id_flower AND flower.type = 'levél' LIMIT $limit";
											$result2 = mysql_query($query2) or die(mysql_error());
											while ($row = mysql_fetch_assoc($result2)) {
												$curr_leaf = $row['color'];
											}

											while ($row = mysql_fetch_assoc($result)) {
												$leaf = $row['color'];
												if ($curr_leaf == $leaf) {
													echo "<option value='$leaf' selected>$leaf</option>";
												} else {
													echo "<option value='$leaf' >$leaf</option>";
												}
											}
										?>
									 </select>
								</td>
								<?php echo '<script type="text/javascript"> LeafItemPrice("'.$leafnum.'");</script>'; ?>

								<td style="position: relative; left: 245px;"> 
									<?php
										$query = "SELECT conect_flower_special_wreath.priece FROM  `conect_flower_special_wreath`, `flower` WHERE conect_flower_special_wreath.special_wreath_id = $special_wreath_id AND flower.id = id_flower AND flower.type = 'levél' LIMIT $limit";
										$result = mysql_query($query) or die(mysql_error());
										while ($row = mysql_fetch_assoc($result)) {
											$curr_leafqty = $row['priece'];
											echo '<input type="text" class="db" id="leafqty'.$leafnum.'" name="leafqty'.$leafnum.'" max="99" min="0" value="'.$curr_leafqty.'" onChange="calculatePrice_oForm(); writeLPrice_oForm();" > db';
										}
									?>
								</td>
								<td style="position: relative; left: 182px;">
									<input type='button' class="inc_button" name='add_leaf' onclick='document.getElementById("<?php echo "leafqty".$leafnum; ?>").value++; calculatePrice_oForm(); writeLPrice_oForm();' value='+'/>
									<input type='button' class="dec_button" name='subtract_leaf' onclick='document.getElementById("<?php echo "leafqty".$leafnum; ?>").value--; calculatePrice_oForm(); writeLPrice_oForm();' value='-' />
								</td>
								<td style="position: relative; left: 137px;">
									<input type="text" value="" id="<?php echo "leafitemprice".$leafnum; ?>" name="<?php echo "leafitemprice".$leafnum; ?>" onChange="calculatePrice_oForm(); writeLPrice_oForm();" style="width: 40px;"> Ft / db
								</td>
							</tr>
							<?php $leafnum++;
						}
						?></table><?php
					} else if ($load_copy && !$_c_left_for_us) {
						echo $_view['copied_leafs_table_inner'];
					} else {
						echo '<td><input type="hidden" id="leafnum" name="leafnum" value="1"></td>
						</tr>
						<tr>';
							include 'leafrow.php';
						echo '</tr>';
					}		
		?>
		<table id="rezgotable" style="border-style:solid; border-left-width:15px; border-color:#7c9e75;">
			<tr>
				<td style="position: relative; left: 235px;">
					<?php 
						if (isset($_GET['wreath_type'])) {
							$query = "SELECT id FROM `special_wreath` WHERE name = '".$_GET['wreath_size']."' ";
							$result = mysql_query($query) or die(mysql_error());
							while ($row = mysql_fetch_assoc($result)) {
								$special_wreath_id = $row['id'];
							}

							$query = "SELECT conect_flower_special_wreath.id_flower FROM `conect_flower_special_wreath`, `flower` WHERE conect_flower_special_wreath.special_wreath_id = $special_wreath_id AND conect_flower_special_wreath.id_flower = flower.id";
							$result = mysql_query($query) or die(mysql_error());
							$rezgonum = mysql_num_rows($result);

							$isRezgo = 0;
							for ($i=0; $i < $rezgonum; $i++) { 
								$limit = "$i, 1";
								$query_swreath_id = "SELECT id_flower FROM `conect_flower_special_wreath` WHERE special_wreath_id=$special_wreath_id LIMIT $limit";
								$result_swreath_id = mysql_query($query_swreath_id) or die(mysql_error());
								while ($row = mysql_fetch_assoc($result_swreath_id)) {
									$swreath_id_flower = $row['id_flower'];
								}

								$query2 = "SELECT type FROM `flower` WHERE id=$swreath_id_flower";
								$result2 = mysql_query($query2) or die(mysql_error());
								while ($row = mysql_fetch_assoc($result2)) {
									if ($row['type'] == "rezgő") {
										$isRezgo++;
									}
								}
							}

							if ($isRezgo > 0) {
								echo '<input type="checkbox" id="rezgo" name="rezgo" value="rezgo" onChange="rezgoqtyEnable_oForm(); calculatePrice_oForm(); writeLPrice_oForm();" checked>';
							} else {
								echo '<input type="checkbox" id="rezgo" name="rezgo" value="rezgo" onChange="rezgoqtyEnable_oForm(); calculatePrice_oForm(); writeLPrice_oForm();" >';
							}
						} else if ($load_copy && !$_c_left_for_us) {
							echo $_view['copied_vibr_checkbox'];
						} else {
							echo '<input type="checkbox" id="rezgo" name="rezgo" value="rezgo" onChange="rezgoqtyEnable_oForm(); calculatePrice_oForm(); writeLPrice_oForm();" >';
						}
					?>
					
					<label for="rezgo">Rezgő</label> 
				</td>
				<td style="position: relative; left: 205px;">
					<?php
							if (isset($_GET['wreath_type'])) {
								$query = "SELECT conect_flower_special_wreath.priece FROM  `conect_flower_special_wreath`, `flower` WHERE conect_flower_special_wreath.special_wreath_id = $special_wreath_id AND flower.id = id_flower AND flower.type = 'rezgő' LIMIT 0, 1";
								$result = mysql_query($query) or die(mysql_error());
								while ($row = mysql_fetch_assoc($result)) {
									$curr_rezgoqty = $row['priece'];
								}
								if ($isRezgo > 0) {
									echo '<input type="text" class="db" id="rezgoqty" name="rezgoqty" max="99" min="0" value="'.$curr_rezgoqty.'" onChange="calculatePrice_oForm(); writeLPrice_oForm();" > db';
								} else {
									echo '<input type="text" class="db" id="rezgoqty" name="rezgoqty" max="99" min="1" value="1" onChange="calculatePrice_oForm(); writeLPrice_oForm();" disabled> db';
								}
							} else if ($load_copy && !$_c_left_for_us) {
								echo $_view['copied_vibr_num'];
							} else {
								echo '<input type="text" class="db" id="rezgoqty" name="rezgoqty" max="99" min="1" value="1" onChange="calculatePrice_oForm(); writeLPrice_oForm();" disabled> db';
							}
						?>
				</td>
				<td style="position: relative; left: 10px;">
					<input type='button' class="inc_button" name='add_leaf' onclick='javascript: document.getElementById("rezgoqty").value++; calculatePrice_oForm(); writeLPrice_oForm();' value='+'/>
					<input type='button' class="dec_button" name='subtract_leaf' onclick='javascript: document.getElementById("rezgoqty").value--; calculatePrice_oForm(); writeLPrice_oForm();' value='-' />
				</td>
			</tr>
				<table class="subtotal toHide">
					<tr>
						<td> Részösszeg: </td> <td id="lsubtotal" style="position: relative;left: 5px;">0 Ft</td>
					</tr>
				</table>
		</table>

		<table id="ribbon" style="border-style: solid; border-left-width: 15px; border-color: #62B8A3; margin-top: 5px; margin-bottom: 10px;">
			<tr class="topborder">
				<td colspan="4" style="font: normal 16px/18px 'Arial'; color: #89a583;"> Adja meg a koszorú szalagját! </td>
			</tr>
			<tr>
				<td> 
					<input type="checkbox" name="isOfferribbon" id="isOfferribbon" onChange="offerribbonEnable();"<?php echo ($load_copy) ? $_view['copied_ribbon_checked'] : ""; ?>>
					<label>Kér szalagot</label>
				</td>
			</tr>
			<tr style="float: left;">
				<td>
					<select id="offerribbon" name="offerribbon" onchange="calculatePrice_oForm(); writeRPrice_oForm();"<?php echo ($load_copy && !$_c_left_for_us ? $_view['copied_ribbon_disabled'] : " disabled"); ?>>
						<option disabled selected>Válassza ki a szalag típusát</option>";
						<?php
						if ($load_copy && !$_c_left_for_us) {
							echo $_view['copied_ribbon_type_options'];
						} else {
							$query = "SELECT * FROM  `ribbon_type`";
							$result = mysql_query($query) or die(mysql_error());

							while ($row = mysql_fetch_assoc($result)) {
								$type = $row['type'];
								$note = $row['note'];
								echo "<option>$type</option>";
							}
						}
						?>
					</select>
				</td>
				<td>
					<select id="offerribboncolor" name="offerribboncolor" onchange="RibbonPrice();"<?php echo ($load_copy && !$_c_left_for_us ? $_view['copied_ribbon_disabled'] : " disabled"); ?>>
						<option disabled selected>Válassza ki a szalag színét</option>";
						<?php
						if ($load_copy && !$_c_left_for_us) {
							echo $_view['copied_ribbon_color_options'];
						} else {
							$query = "SELECT color FROM  `ribbon_color`";
							$result = mysql_query($query) or die(mysql_error());

							while ($row = mysql_fetch_assoc($result)) {
								$color = $row['color'];
								echo "<option>$color</option>";
							}
						}
						?>
	 			</td>
				<td>
					<select id="offerfarewell" name="offerfarewell"<?php echo ($load_copy && !$_c_left_for_us ? $_view['copied_ribbon_disabled'] : " disabled"); ?>>
						<option disabled selected>Válassza ki a búcsúszöveget</option>
							<?php 
							if ($load_copy && !$_c_left_for_us) {
								echo $_view['copied_ribbon_farewell_options'];
							} else {
								include 'farewelltext.php';
							}
							?>
					</select>
				</td>
				<td>
					<input type="text" value="<?php echo ($load_copy && !$_c_left_for_us) ? $_view['copied_ribbon_price'] : "" ?>" id="ribbonprice" name="ribbonprice" onchange="calculatePrice_oForm(); writeRPrice_oForm();" style="width: 40px;"> Ft / db
				</td>
			</tr>
			<tr>
				<td>
					<textarea maxlength="200" style="height: 32px;width: 765px;resize: none;" id="offergivers" name="offergivers" placeholder="Akik adják"<?php echo ($load_copy && !$_c_left_for_us ? $_view['copied_ribbon_disabled'] . ">" . $_view['copied_ribbon_givers'] : " disabled>"); ?></textarea>
				</td>
			</tr>
		</table>
		<table class="subtotal">
			<tr>
				<td id="rprice"> Részösszeg: </td> <td id="rsubtotal" style="position: relative;left: 5px; margin-top: 5px;">0 Ft</td>
			</tr>
		</table>

		<table id="price" style="border-style:solid; border-left-width:15px; border-color:#5f7fff; margin-top: 5px;">
			<tr class="topborder">
				<td id="calced_price"> Kalkulált ár: </td>
				<td> 
					<input type="text" name="wreathprice" id="wreath_price" class="toLoad_wreathPrice" readonly>
					<input type="hidden" name="orig_wreathprice" id="orig_wreathprice" class="toLoad_wreathPrice" readonly>
				</td>
				<td> Értékesítési ár: </td>
				<td> <input type="text" name="endprice" id="fullprice" > </td>
				<td>
					<input type="button" value="Másol" id="copy_price" class="button" onClick="copyprice();">
				</td>
				<td> <input type="button" id="kiertekeles" value="Kiértékelés" onClick="calcFullPrice_oForm();" > </td>
			</tr>
			<tr>
				<td> 
					Bolt választó:
				</td>
				<td colspan="4">
					<select id="shop_select" name="shop_select" >
					<?php if (isset($_GET['popup']) && ($_GET['popup'] == true) || isset($_GET['r_ajanlat'])) { ?>
							<option value="0" selected>Rendelésből készítve!</option>
					<?php } else { ?>
							<option disabled value="" selected>Válasszon Boltot!</option>
							<?php 
								$query = "SELECT id, name FROM `shops` WHERE enable = 1";
								$result = mysql_query($query) or die(mysql_error());

								while ($row = mysql_fetch_assoc($result)) {
									$shopid = $row['id'];
									$shopname = $row['name'];
									echo "<option value='$shopid' >$shopname</option>";
								}
							?>
					<?php } ?>
					</select>
				</td>
				<?php echo '<td> <input type="button" id="submit" value="Hozzáadom!" onClick="make_new_offer('.$ajanlat_id.');"> </td>'; ?> 
			</tr>
		</table>
		</form>
		<?php } else { ?>		
		<!-- -------------------------- Rendelésnél Módosításkor -------------------------- -->
		<form id="wreathform" method="POST" action="menu-main/menu-offer-submenu/new-offer/offermod.php" enctype="multipart/form-data" >
			<input type="hidden" name="r_ajanlat" id="r_ajanlat" value="r_ajanlat" >

			<?php 
				if (isset($_GET['subpage']) && $_GET['subpage']=="ajanlat_szerkesztes") {
					$ajanlat_type = substr($_GET['ajanlat_type'], 0, -13); //Levágja a dátumot
				} else {
					$ajanlat_type = $_GET['ajanlat_type'];
				}
				
				$query = "SELECT id FROM offer_wreath WHERE name='$ajanlat_type'";
				$result = mysql_query($query) or die(mysql_error());
				while ($row = mysql_fetch_assoc($result)) {
					$offer_id = $row['id'];
				}
				echo '<input type="hidden" name="offer_id" id="offer_id" value="'.$offer_id.'" >';
			?>
		<!-- <table id="from_catalogtable">
			<tr>
				<td style="font: normal 16px/18px 'Arial'; color: #89a583;">
					<input type="checkbox" id="from_catalog" onChange="wreathfromcatalog();" style="vertical-align: baseline;"> <label style="font: normal 16px/18px 'Arial'; color: #89a583;">Koszorú katalógus alapján történő ajánlatkészítés</label>
				</td>
			</tr>
			<tr>
				<td>
					<table id="wreath_from_catalog" style="display: none;">
					</table>
				</td>
			</tr>
		</table> -->

		<table id="wreath" style="border-style:solid; border-left-width:15px; border-color:#c8dba6; margin-top: 5px;">
			<tr>
				<td colspan="2" style="font: normal 16px/18px 'Arial'; color: #89a583;"> Adja meg a koszorú kódját/nevét! </td>
			</tr> 
			<tr>
				<td style="font: normal 16px/18px 'Arial'; color: #89a583;">
					<?php
					 $query = "SELECT name FROM  `offer_wreath` WHERE name = '".$ajanlat_type."';";
					 $result = mysql_query($query) or die(mysql_error());
					 while ($row = mysql_fetch_assoc($result)) {
					 	echo '<input type="text" name="wreath_name" id="wreath_name" value="'.$row['name'].'" readonly> ';
					 }
					?>
				</td>
				<td style="font: normal 16px/18px 'Arial'; color: #89a583; position: relative; right: -28px;">
					<?php
					 $query = "SELECT note FROM  `offer_wreath` WHERE name = '".$ajanlat_type."';";
					 $result = mysql_query($query) or die(mysql_error());
					 while ($row = mysql_fetch_assoc($result)) {
					 	echo '<textarea style="resize: none; width: 510px;" name="note" id="note" rows="3" cols="100" maxlength="500" placeholder="Írja ide a megjegyzést!">'.$row['note'].'</textarea> ';
 					 }
					?>
				</td>
			</tr>
			<tr class="topborder"> 
				<td colspan="2" style="font: normal 16px/18px 'Arial'; color: #89a583;"> Adja meg a koszorú alapját! </td>
			</tr>
			<tr>
				<td> <select id="base_wreath_type" name="base_wreath_type" onChange="loadBaseWreathSizes_oForm(this.id, 'base_wreath_size'); eraseWSubtotal(); ">
						<option disabled value="" selected>Válasszon koszorú alapot!</option>
						<?php 
							$query = "SELECT type FROM  `base_wreath_type` ORDER BY type ASC;";
							$result = mysql_query($query) or die(mysql_error());

							$query2 = "SELECT base_wreath_type.type FROM  `offer_wreath`, `base_wreath`, `base_wreath_type` WHERE name = '".$ajanlat_type."' AND offer_wreath.base_wreath_id = base_wreath.id AND base_wreath.type = base_wreath_type.id;";
							$result2 = mysql_query($query2) or die(mysql_error());
						
							while ($row = mysql_fetch_assoc($result)) {
								$base_wreath_type = $row['type'];
								while ($row2 = mysql_fetch_assoc($result2)) {
									$ajanlat_bw = $row2['type'];
								}
								if ($base_wreath_type == $ajanlat_bw) {
									echo "<option value='$base_wreath_type' selected>$base_wreath_type</option>";
								} else {
									echo "<option value='$base_wreath_type' >$base_wreath_type</option>";
								}
							}
						?>
					 </select>
				</td>
				<td style="position: relative; left: 18px;"> <select id="base_wreath_size" name="base_wreath_size" onChange="calculatePrice_oForm(); writeWPrice_oForm();" >
						<option disabled value="" selected>Válasszon koszorú méretet!</option>
						<?php 
							$query3 = "SELECT base_wreath_type.type FROM  `offer_wreath`, `base_wreath`, `base_wreath_type` WHERE name = '".$ajanlat_type."' AND offer_wreath.base_wreath_id = base_wreath.id AND base_wreath.type = base_wreath_type.id;";
							$result3 = mysql_query($query3) or die(mysql_error());
						
							while ($row3 = mysql_fetch_assoc($result3)) {
								$base_wreath_type = $row3['type'];
							}

							$query = "SELECT size FROM `base_wreath` WHERE TYPE = ( SELECT id FROM `base_wreath_type` WHERE TYPE = '".$base_wreath_type."' );";
							$result = mysql_query($query) or die(mysql_error());

							$query2 = "SELECT base_wreath.size FROM `offer_wreath`, `base_wreath` WHERE name = '".$ajanlat_type."' AND offer_wreath.base_wreath_id = base_wreath.id";
							$result2 = mysql_query($query2) or die(mysql_error());

							while ($row = mysql_fetch_assoc($result)) {
								$base_wreath_size = $row['size'];
								while ($row2 = mysql_fetch_assoc($result2)) {
									$ajanlat_bws = $row2['size'];
								}
								if ($base_wreath_size == $ajanlat_bws) {
									echo "<option value='$base_wreath_size' selected>$base_wreath_size";
								} else {
									echo "<option value='$base_wreath_size' >$base_wreath_size";
								}
								$query = "SELECT flower_min FROM  `base_wreath` WHERE size='".$row['size']."'";
								$resultmin = mysql_query($query) or die (mysql_error());

								while ($rowmin = mysql_fetch_assoc($resultmin)) {
									$size = $rowmin['flower_min'];
									echo " ($size";
								}
								
								echo " - ";

								$query = "SELECT flower_max FROM  `base_wreath` WHERE size='".$row['size']."'";
								$resultmax = mysql_query($query) or die (mysql_error());

								while ($rowmax = mysql_fetch_assoc($resultmax)) {
									$size = $rowmax['flower_max'];
									echo "$size)";
								}
								echo "</option>";
							}
						?>
					 </select>
				</td>
				<table class="subtotal">
					<tr>
						<td id="wprice"> Részösszeg: </td> <td id="wsubtotal" style="position: relative;left: 5px; margin-top: 5px;">0 Ft</td>
					</tr>
				</table>
			</tr>
		</table>

		<table style="border-style: solid; border-left-width: 15px; border-color: #7c9e75; margin-top: 5px;">
			<tr>
				<td style="padding: 10px;">
				<?php 
					$query = "SELECT `left_for_us` FROM `offer_wreath` WHERE `name` = '$ajanlat_type'";
					$result = mysql_query($query) or die(mysql_error());

					while ($row = mysql_fetch_assoc($result)) {
						$left_for_us = $row['left_for_us'];
						if ($left_for_us == 1) { ?>
							<input type="checkbox" name="left_for_us" id="left_for_us" onchange="leftForUs();" style="vertical-align: baseline;" checked="checked">
							<input type="hidden" name="left_for_us_before" value="1"> <?php // előzőleg checked volt-e a ránk bízva
						} else { ?>
							<input type="checkbox" name="left_for_us" id="left_for_us" onchange="leftForUs();" style="vertical-align: baseline;" >
							<input type="hidden" name="left_for_us_before" value="0"> <?php
						}
					}
				?>
					<label for="left_for_us" style="font: normal 16px/18px 'Arial'; color: #89a583; vertical-align: baseline;">Koszorúkötőre bízva az összeállítás és a virágszín</label>
				</td>
			</tr>
		</table>

	<?php if ($left_for_us != 1) { ?> <!-- Ha $left_for_us == 1, akkor "ránk bízva" -->
			<table id="flower" style="border-style:solid; border-left-width:15px; border-color:#c8dba6; margin-top: 5px;">
				<tr class="topborder"> 
					<td colspan="4" style="font: normal 16px/18px 'Arial'; color: #89a583;"> Adja meg a koszorú virágait!
						<input type="button" value="Új összetevő" class="plus" style="width: 80px;" onClick="addFlowerRow_oForm();" >
						<input type="button" value="Utolsó összetevő eltávolítása" class="minus" style="width: 180px;" onClick="remFlowerRow_oForm(); calculatePrice_oForm(); writeFPrice_oForm();" ></td>
					<?php 
						$query = "SELECT id FROM `offer_wreath` WHERE name = '".$ajanlat_type."' ";
						$result = mysql_query($query) or die(mysql_error());
						while ($row = mysql_fetch_assoc($result)) {
							$offer_wreath_id = $row['id'];
						}

						$query2 = "SELECT id_flower FROM `conect_flower_offer_wreath` WHERE conect_flower_offer_wreath.offer_wreath_id = $offer_wreath_id";
						$result2 = mysql_query($query2) or die(mysql_error());
						$flowernum = mysql_num_rows($result2);

						$fnum = 0;
						for ($i=0; $i < $flowernum; $i++) { 
							$limit = "$i, 1";
							$query_owreath_id = "SELECT id_flower FROM `conect_flower_offer_wreath` WHERE offer_wreath_id = $offer_wreath_id LIMIT $limit";
							$result_owreath_id = mysql_query($query_owreath_id) or die(mysql_error());
							while ($row = mysql_fetch_assoc($result_owreath_id)) {
								$owreath_id_flower = $row['id_flower'];
							}
							$query3 = "SELECT type FROM `flower` WHERE id=$owreath_id_flower";
							$result3 = mysql_query($query3) or die(mysql_error());
							while ($row = mysql_fetch_assoc($result3)) {
								if ($row['type'] != "levél" && $row['type'] != "rezgő") {
									$fnum++;
								}
							}
						}

						$_SESSION['flowers'] = $fnum;
					echo 	'<td><input type="hidden" id="flowernum" name="flowernum" value="'.$fnum.'"></td>';
					?>
				</tr>
				<?php 
				$flowernum = 1;
				for ($i=0; $i < $fnum; $i++) { ?>
				<tr>
					<td>
					<select id="<?php echo "flower".$flowernum; ?>" name="<?php echo "flower".$flowernum; ?>" onChange="loadFlowerColors(this, document.getElementById('<?php echo "color".$flowernum;?>')); eraseFSubtotal();">
						<option disabled value="" selected>Válasszon virág típust!</option>
						<?php 
							$limit = "$i, 1";
							$query = "SELECT type FROM  `flower` WHERE type NOT LIKE 'levél' AND type NOT LIKE 'rezgő' GROUP BY type ORDER BY type ASC;";
							$result = mysql_query($query) or die (mysql_error());

							$query2 = "SELECT flower.type FROM  `conect_flower_offer_wreath`, `flower` WHERE conect_flower_offer_wreath.offer_wreath_id = $offer_wreath_id AND flower.id = id_flower AND flower.type NOT LIKE 'rezgő' AND flower.type NOT LIKE 'levél' LIMIT $limit";
							$result2 = mysql_query($query2) or die(mysql_error());
							while ($row = mysql_fetch_assoc($result2)) {
								$curr_flowertype = $row['type'];
							}

							while ($row = mysql_fetch_assoc($result)) {
								$flowertype = $row['type'];
								if ($curr_flowertype == $flowertype) {
									echo "<option value='$flowertype' selected>$flowertype</option>";
								} else {
									echo "<option value='$flowertype' >$flowertype</option>";
								}
							}
						?>
					 </select>
					</td>

					<td>
					 <select id="<?php echo "color".$flowernum; ?>" name="<?php echo "color".$flowernum; ?>" onChange="calculatePrice_oForm(); writeFPrice_oForm(); ItemPrice(<?php echo $flowernum; ?>);" >
						<option disabled value="" selected>Válasszon virág színt!</option>
						<?php 
							$query = "SELECT color FROM  `flower` WHERE type='$curr_flowertype' ORDER BY color ASC";
							$result = mysql_query($query) or die (mysql_error());

							$query2 = "SELECT flower.color FROM  `conect_flower_offer_wreath`, `flower` WHERE conect_flower_offer_wreath.offer_wreath_id = $offer_wreath_id AND flower.id = id_flower AND flower.type NOT LIKE 'levél' AND flower.type NOT LIKE 'rezgő' LIMIT $limit";
							$result2 = mysql_query($query2) or die(mysql_error());
							while ($row = mysql_fetch_assoc($result2)) {
								$curr_flowercolor = $row['color'];
							}

							while ($row = mysql_fetch_assoc($result)) {
								$flowercolor = $row['color'];
								if ($curr_flowercolor == $flowercolor) {
									echo "<option value='$flowercolor' selected>$flowercolor</option>";
								} else {
									echo "<option value='$flowercolor' >$flowercolor</option>";
								}
							}
						?>
					 </select>
					</td>

					<td style="position: relative; left: -5px;"> 
						<?php 
							$query = "SELECT conect_flower_offer_wreath.priece FROM  `conect_flower_offer_wreath`, `flower` WHERE conect_flower_offer_wreath.offer_wreath_id = $offer_wreath_id AND flower.id = id_flower AND flower.type NOT LIKE 'levél' AND flower.type NOT LIKE 'rezgő' LIMIT $limit";
							$result = mysql_query($query) or die(mysql_error());
							while ($row = mysql_fetch_assoc($result)) {
								$curr_flowerqty = $row['priece'];
								echo '<input type="text" class="db" id="qty'.$flowernum.'" name="qty'.$flowernum.'" max="99" min="1" value="'.$curr_flowerqty.'" onChange="calculatePrice_oForm(); writeFPrice_oForm();" > db';
							}
						?>
					</td>
					<td style="position: relative; left: -25px;">
						<input type='button' class="inc_button" name='add_flower' onClick='document.getElementById("<?php echo "qty".$flowernum; ?>").value++; calculatePrice_oForm(); writeFPrice_oForm();' value='+'/>
						<input type='button' class="dec_button" name='subtract_flower' onClick='document.getElementById("<?php echo "qty".$flowernum; ?>").value--; calculatePrice_oForm(); writeFPrice_oForm();' value='-' />
					</td>
					<td style="position: relative; left: -30px;">
						<?php 
							$query = "SELECT conect_flower_offer_wreath.price FROM  `conect_flower_offer_wreath`, `flower` WHERE conect_flower_offer_wreath.offer_wreath_id = $offer_wreath_id AND flower.id = id_flower AND flower.type NOT LIKE 'levél' AND flower.type NOT LIKE 'rezgő' LIMIT $limit";
							$result = mysql_query($query) or die(mysql_error());
							while ($row = mysql_fetch_assoc($result)) {
								$curr_flowerqty_price = $row['price'];
							}
						?>
						<input type="text" value="<?php echo "$curr_flowerqty_price"; ?>" id="<?php echo "itemprice".$flowernum; ?>" name="<?php echo "itemprice".$flowernum; ?>" onChange="calculatePrice_oForm(); writeFPrice_oForm();" style="width: 40px;"> Ft / db
					</td>
				</tr>
				<?php $flowernum++; } ?>
	<?php } else { ?>
			<table id="flower" style="border-style:solid; border-left-width:15px; border-color:#c8dba6; margin-top: 5px; display: none;">
				<tr class="topborder"> 
					<td colspan="4" style="font: normal 16px/18px 'Arial'; color: #89a583;"> Adja meg a koszorú virágait!
						<input type="button" value="Új összetevő" class="plus" style="width: 80px;" onClick="addFlowerRow_oForm();" >
						<input type="button" value="Utolsó összetevő eltávolítása" class="minus" style="width: 180px;" onClick="remFlowerRow_oForm(); calculatePrice_oForm(); writeFPrice_oForm();" ></td>
					<td><input type="hidden" id="flowernum" name="flowernum" value="1"></td>
					</tr>
					<tr>
						<?php include 'flowerrow.php'; ?>
				</tr>
	<?php } ?>
	<?php if ($left_for_us != 1) { ?> <!-- Ha $left_for_us == 1, akkor "ránk bízva" -->
					<table class="subtotal toHide">
	<?php } else { ?>
					<table class="subtotal toHide" style="display: none;">
	<?php } ?>
						<tr>
							<td id="fprice"> Részösszeg: </td> <td id="fsubtotal" style="position: relative;left: 5px; margin-top: 5px;">0 Ft</td>
						</tr>
					</table>
			</table>

	<?php if ($left_for_us != 1) { ?> <!-- Ha $left_for_us == 1, akkor "ránk bízva" -->
		<table id="leaf" style="border-style:solid; border-left-width:15px; border-color:#9db88a; margin-top: 5px;"> 
			<tr class="topborder"> 
				<td colspan="4" style="font: normal 16px/18px 'Arial'; color: #89a583;"> Adja meg a koszorú leveleit! 
					<input type="button" value="Új összetevő" class="plus" style="width: 80px;" onClick="addLeafRow_oForm();" >
					<input type="button" value="Utolsó összetevő eltávolítása" class="minus" style="width: 180px;" onClick="remLeafRow_oForm(); calculatePrice_oForm(); writeLPrice_oForm();" ></td>
				<?php 
					$query = "SELECT id FROM `offer_wreath` WHERE name = '".$ajanlat_type."' ";
					$result = mysql_query($query) or die(mysql_error());
					while ($row = mysql_fetch_assoc($result)) {
						$offer_wreath_id = $row['id'];
					}

					$query = "SELECT conect_flower_offer_wreath.id_flower FROM `conect_flower_offer_wreath`, `flower` WHERE conect_flower_offer_wreath.offer_wreath_id = $offer_wreath_id AND conect_flower_offer_wreath.id_flower = flower.id";
					$result = mysql_query($query) or die(mysql_error());
					$leafnum = mysql_num_rows($result);

					$lnum = 0;
					for ($i=0; $i < $leafnum; $i++) {
						$limit = "$i, 1";
						$query_owreath_id = "SELECT id_flower FROM `conect_flower_offer_wreath` WHERE offer_wreath_id=$offer_wreath_id LIMIT $limit";
						$result_owreath_id = mysql_query($query_owreath_id) or die(mysql_error());
						while ($row = mysql_fetch_assoc($result_owreath_id)) {
							$owreath_id_flower = $row['id_flower'];
						}

						$query2 = "SELECT type FROM `flower` WHERE id=$owreath_id_flower";
						$result2 = mysql_query($query2) or die(mysql_error());
						while ($row = mysql_fetch_assoc($result2)) {
							if ($row['type'] == "levél") {
								$lnum++;
							}
						}
					}

				$_SESSION['leafs'] = $lnum;
				echo 	'<td><input type="hidden" id="leafnum" name="leafnum" value="'.$lnum.'"></td>';
				?>
			</tr>
				<?php
				$leafnum = 1;
				for ($i=0; $i < $lnum; $i++) { ?>
			<tr>
				<td style="position: relative; left: 235px;">
					<select id="<?php echo "leaf".$leafnum; ?>" name="<?php echo "leaf".$leafnum; ?>" onChange="calculatePrice_oForm(); writeLPrice_oForm(); LeafItemPrice(<?php echo $leafnum; ?>);" >
						<option disabled value="" selected>Válasszon Levelet!</option>
						<?php 
							$limit = "$i, 1";
							$query = "SELECT color FROM  `flower` WHERE type='levél' ORDER BY color ASC;";
							$result = mysql_query($query) or die (mysql_error());

							$query2 = "SELECT flower.color FROM  `conect_flower_offer_wreath` ,  `flower` WHERE conect_flower_offer_wreath.offer_wreath_id = $offer_wreath_id AND flower.id = id_flower AND flower.type = 'levél' LIMIT $limit";
							$result2 = mysql_query($query2) or die(mysql_error());
							while ($row = mysql_fetch_assoc($result2)) {
								$curr_leaf = $row['color'];
							}

							while ($row = mysql_fetch_assoc($result)) {
								$leaf = $row['color'];
								if ($curr_leaf == $leaf) {
									echo "<option value='$leaf' selected>$leaf</option>";
								} else {
									echo "<option value='$leaf' >$leaf</option>";
								}
							}
						?>
					 </select>
				</td>

				<td style="position: relative; left: 245px;"> 
					<?php
						$query = "SELECT conect_flower_offer_wreath.priece FROM  `conect_flower_offer_wreath`, `flower` WHERE conect_flower_offer_wreath.offer_wreath_id = $offer_wreath_id AND flower.id = id_flower AND flower.type = 'levél' LIMIT $limit";
						$result = mysql_query($query) or die(mysql_error());
						while ($row = mysql_fetch_assoc($result)) {
							$curr_leafqty = $row['priece'];
							echo '<input type="text" class="db" id="leafqty'.$leafnum.'" name="leafqty'.$leafnum.'" max="99" min="0" value="'.$curr_leafqty.'" onChange="calculatePrice_oForm(); writeLPrice_oForm();" > db';
						}
					?>
				</td>
				<td style="position: relative; left: 182px;">
					<input type='button' class="inc_button" name='add_leaf' onclick='document.getElementById("<?php echo "leafqty".$leafnum; ?>").value++; calculatePrice_oForm(); writeLPrice_oForm();' value='+'/>
					<input type='button' class="dec_button" name='subtract_leaf' onclick='document.getElementById("<?php echo "leafqty".$leafnum; ?>").value--; calculatePrice_oForm(); writeLPrice_oForm();' value='-' />
				</td>
				<td style="position: relative; left: 137px;">
					<?php
						$query = "SELECT conect_flower_offer_wreath.price FROM  `conect_flower_offer_wreath`, `flower` WHERE conect_flower_offer_wreath.offer_wreath_id = $offer_wreath_id AND flower.id = id_flower AND flower.type = 'levél' LIMIT $limit";
						$result = mysql_query($query) or die(mysql_error());
						while ($row = mysql_fetch_assoc($result)) {
							$curr_leafqty_price = $row['price'];
						}
					?>
					<input type="text" value="<?php echo "$curr_leafqty_price"; ?>" id="<?php echo "leafitemprice".$leafnum; ?>" name="<?php echo "leafitemprice".$leafnum; ?>" onChange="calculatePrice_oForm(); writeLPrice_oForm();" style="width: 40px;"> Ft / db
				</td>
			</tr>
				<?php $leafnum++; } ?>

	<?php } else { ?>
		<table id="leaf" style="border-style:solid; border-left-width:15px; border-color:#9db88a; margin-top: 5px; display: none;"> 
			<tr class="topborder"> 
				<td colspan="4" style="font: normal 16px/18px 'Arial'; color: #89a583;"> Adja meg a koszorú leveleit! 
					<input type="button" value="Új összetevő" class="plus" style="width: 80px;" onClick="addLeafRow_oForm();" >
					<input type="button" value="Utolsó összetevő eltávolítása" class="minus" style="width: 180px;" onClick="remLeafRow_oForm(); calculatePrice_oForm(); writeLPrice_oForm();" ></td>
				<td><input type="hidden" id="leafnum" name="leafnum" value="1"></td>
			</tr>
			<tr>
				<?php include 'leafrow.php'; ?>
			</tr>
	<?php } ?>
		</table>

	<?php if ($left_for_us != 1) { ?> <!-- Ha == 1, akkor "ránk bízva" -->
		<table id="rezgotable" style="border-style:solid; border-left-width:15px; border-color:#7c9e75;">
	<?php } else { ?>
		<table id="rezgotable" style="border-style:solid; border-left-width:15px; border-color:#7c9e75; display: none;">
	<?php } ?>
			<tr>
				<td style="position: relative; left: 235px;">
					<?php 
						$query = "SELECT id FROM `offer_wreath` WHERE name = '".$ajanlat_type."' ";
						$result = mysql_query($query) or die(mysql_error());
						while ($row = mysql_fetch_assoc($result)) {
							$offer_wreath_id = $row['id'];
						}

						$query = "SELECT conect_flower_offer_wreath.id_flower FROM `conect_flower_offer_wreath`, `flower` WHERE conect_flower_offer_wreath.offer_wreath_id = $offer_wreath_id AND conect_flower_offer_wreath.id_flower = flower.id";
						$result = mysql_query($query) or die(mysql_error());
						$rezgonum = mysql_num_rows($result);

						$isRezgo = 0;
						for ($i=0; $i < $rezgonum; $i++) { 
							$limit = "$i, 1";
							$query_swreath_id = "SELECT id_flower FROM `conect_flower_offer_wreath` WHERE offer_wreath_id=$offer_wreath_id LIMIT $limit";
							$result_swreath_id = mysql_query($query_swreath_id) or die(mysql_error());
							while ($row = mysql_fetch_assoc($result_swreath_id)) {
								$owreath_id_flower = $row['id_flower'];
							}

							$query2 = "SELECT type FROM `flower` WHERE id=$owreath_id_flower";
							$result2 = mysql_query($query2) or die(mysql_error());
							while ($row = mysql_fetch_assoc($result2)) {
								if ($row['type'] == "rezgő") {
									$isRezgo++;
								}
							}
						}

						if ($isRezgo > 0) {
							echo '<input type="checkbox" id="rezgo" name="rezgo" value="rezgo" onChange="rezgoqtyEnable_oForm(); calculatePrice_oForm(); writeLPrice_oForm();" checked>';
						} else {
							echo '<input type="checkbox" id="rezgo" name="rezgo" value="rezgo" onChange="rezgoqtyEnable_oForm(); calculatePrice_oForm(); writeLPrice_oForm();" >';
						}
				?>
					<label for="rezgo">Rezgő</label> 
				</td>
				<td style="position: relative; left: 205px;">
					<?php
						$query = "SELECT conect_flower_offer_wreath.priece FROM  `conect_flower_offer_wreath`, `flower` WHERE conect_flower_offer_wreath.offer_wreath_id = $offer_wreath_id AND flower.id = id_flower AND flower.type = 'rezgő' LIMIT 0, 1";
						$result = mysql_query($query) or die(mysql_error());
						while ($row = mysql_fetch_assoc($result)) {
							$curr_rezgoqty = $row['priece'];
						}
						if ($isRezgo > 0) {
							echo '<input type="text" class="db" id="rezgoqty" name="rezgoqty" max="99" min="0" value="'.$curr_rezgoqty.'" onChange="calculatePrice_oForm(); writeLPrice_oForm();" > db';
						} else {
							echo '<input type="text" class="db" id="rezgoqty" name="rezgoqty" max="99" min="1" value="1" onChange="calculatePrice_oForm(); writeLPrice_oForm();" disabled> db';
						}
					?>
				</td>
				<td style="position: relative; left: 10px;">
					<input type='button' class="inc_button" name='add_leaf' onclick='javascript: document.getElementById("rezgoqty").value++; calculatePrice_oForm(); writeLPrice_oForm();' value='+'/>
					<input type='button' class="dec_button" name='subtract_leaf' onclick='javascript: document.getElementById("rezgoqty").value--; calculatePrice_oForm(); writeLPrice_oForm();' value='-' />
				</td>
			</tr>

	<?php if ($left_for_us != 1) { ?> <!-- Ha == 1, akkor "ránk bízva" -->
				<table class="subtotal toHide">
	<?php } else { ?>
				<table class="subtotal toHide" style="display: none;">
	<?php } ?>
					<tr>
						<td> Részösszeg: </td> <td id="lsubtotal" style="position: relative;left: 5px;">0 Ft</td>
					</tr>
				</table>
		</table>

		<table id="ribbon" style="border-style: solid; border-left-width: 15px; border-color: #62B8A3; margin-top: 5px; margin-bottom: 10px;">
			<tr class="topborder">
				<td colspan="4" style="font: normal 16px/18px 'Arial'; color: #89a583;"> Adja meg a koszorú szalagját! </td>
			</tr>
			<tr>
				<td> 
				<?php
					$query_ribbid = "SELECT `ribbon_id` FROM `offer_wreath` WHERE id=$offer_id";
					$result_ribbid = mysql_query($query_ribbid) or die(mysql_error());
					while ($row = mysql_fetch_assoc($result_ribbid)) {
						$ribbon_id = ($row['ribbon_id'] === NULL) ? 'NULL' : $row['ribbon_id'];
					}
				?>
				<?php if ($ribbon_id == 'NULL') { ?>
						<input type="checkbox" name="isOfferribbon" id="isOfferribbon" onChange="offerribbonEnable();">
				<?php } else { ?>
						<input type="checkbox" name="isOfferribbon" id="isOfferribbon" onChange="offerribbonEnable();" checked>
				<?php } ?>
					<input type="hidden" name="ribbon_id" value="<?php echo $ribbon_id; ?>">
					<label>Kér szalagot</label>
				</td>
			</tr>
			<tr style="float: left;">
				<td>
				<?php if ($ribbon_id == 'NULL') { ?>
					<select id="offerribbon" name="offerribbon" onchange="calculatePrice_oForm(); writeRPrice_oForm();" disabled>
				<?php } else { ?>
					<select id="offerribbon" name="offerribbon" onchange="calculatePrice_oForm(); writeRPrice_oForm();" >
				<?php } ?>

						<option disabled selected>Válassza ki a szalag típusát</option>
						<?php
						$query = "SELECT * FROM  `ribbon_type`";
						$result = mysql_query($query) or die(mysql_error());

						$query_ribbon = "SELECT `ribbon`, `ribboncolor`, `farewelltext`, `givers` FROM `ribbons` WHERE id=$ribbon_id";
						$result_ribbon = mysql_query($query_ribbon) or die(mysql_error());
						while ($row = mysql_fetch_assoc($result_ribbon)) {
							$curr_ribb = $row['ribbon'];
							$curr_ribbcolor = $row['ribboncolor'];
							$curr_fwtext = $row['farewelltext'];
							$curr_givers = $row['givers'];
						}

						while ($row = mysql_fetch_assoc($result)) {
								$type = $row['type'];
								$note = $row['note'];
								if ($curr_ribb == $type) {
									echo "<option selected>$type</option>";
								} else {
									echo "<option >$type</option>";
								}
						}
						?>
					</select>
				</td>
				<td>
				<?php if ($ribbon_id == 'NULL') { ?>
					<select id="offerribboncolor" name="offerribboncolor" onchange="RibbonPrice();" disabled>
				<?php } else { ?>
					<select id="offerribboncolor" name="offerribboncolor" onchange="RibbonPrice();">
				<?php } ?>
						<option disabled selected>Válassza ki a szalag színét</option>
						<?php
						$query = "SELECT color FROM  `ribbon_color`";
						$result = mysql_query($query) or die(mysql_error());

						while ($row = mysql_fetch_assoc($result)) {
							$color = $row['color'];
							if ($curr_ribbcolor == $color) {
								echo "<option selected>$color</option>";
							} else {
								echo "<option>$color</option>";
							}
						}
						?>
	 			</td>
				<td>
				<?php if ($ribbon_id == 'NULL') { ?>
					<select id="offerfarewell" name="offerfarewell" disabled>
				<?php } else { ?>
					<select id="offerfarewell" name="offerfarewell" >
				<?php } ?>
						<option disabled selected>Válassza ki a búcsúszöveget</option>
							<?php
								$query2 = "SELECT * FROM  `tape_title` ORDER BY id ASC";
								$result2 = mysql_query($query2) or die (mysql_error());
								while ($row = mysql_fetch_assoc($result2)) {
									$id = $row['id'];
									$tapetext = "SZ$id - ".$row['text'];
									if ($curr_fwtext == $tapetext) {
										echo "<option selected> $tapetext </option>";
									} else {
										echo "<option> $tapetext </option>";
									}
								}
								
								$query = "SELECT * FROM  `citation`";
								$result = mysql_query($query) or die (mysql_error());
								while ($row = mysql_fetch_assoc($result)) {
									$id = $row['id'];
									$cittext = "ID$id - ".$row['text'];
									if ($curr_fwtext == $cittext) {
										echo "<option selected> $cittext </option>";
									} else {
										echo "<option> $cittext </option>";
									}
								}
							?>
					</select>
				</td>
				<td>
					<?php 
						if ($ribbon_id != 'NULL') {
							$query = "SELECT price FROM ribbons WHERE id = $ribbon_id";
							$result_ribbonprice = mysql_query($query) or die(mysql_error());
							while ($row = mysql_fetch_assoc($result_ribbonprice)) {
								$ribbon_price = $row['price'];
							}
						} else {
							$ribbon_price = 0;
						}
					?>
					<input type="text" value="<?php echo $ribbon_price; ?>" id="ribbonprice" name="ribbonprice" onchange="calculatePrice_oForm(); writeRPrice_oForm();" style="width: 40px;"> Ft / db
				</td>
			</tr>
			<tr>
				<td>
				<?php if ($ribbon_id == 'NULL') { ?>
					<textarea maxlength="200" style="height: 32px;width: 765px;resize: none;" id="offergivers" name="offergivers" placeholder="Akik adják" disabled></textarea>
				<?php } else { ?>
					<textarea maxlength="200" style="height: 32px;width: 765px;resize: none;" id="offergivers" name="offergivers" placeholder="Akik adják" ><?php echo $curr_givers; ?></textarea>
				<?php } ?>
				</td>
			</tr>
		</table>
		<table class="subtotal">
			<tr>
				<td id="rprice"> Részösszeg: </td> <td id="rsubtotal" style="position: relative;left: 5px; margin-top: 5px;">0 Ft</td>
			</tr>
		</table>

		<table id="price" style="border-style:solid; border-left-width:15px; border-color:#5f7fff; margin-top: 5px;">
			<tr class="topborder">
				<td></td>
				<td></td>
				<td> Eredeti értékesítési ár: </td>
				<td> <?php 
					$query = "SELECT sale_price FROM  `offer_wreath` WHERE name='$ajanlat_type'";
					$result = mysql_query($query) or die(mysql_error());
					while ($row = mysql_fetch_assoc($result)) {
						$sale_price = $row['sale_price'];
						echo number_format($sale_price, 0, "", " ")." Ft";
					}
				 ?> </td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td id="calced_price"> <?php if ($left_for_us != 1) { ?> Kalkulált ár: <?php } else { ?> Összetevőkre szánt összeg: <?php } ?> </td>
				<td> 
					<input type="text" name="wreathprice" id="wreath_price" class="toLoad_wreathPrice" readonly>
					<input type="hidden" name="orig_wreathprice" id="orig_wreathprice" class="toLoad_wreathPrice" readonly>
				</td>
				<td> Értékesítési ár: </td>
				<td> 
				<?php if ($left_for_us != 1) { ?> 
					<input type="text" name="endprice" id="fullprice" onchange=""> </td>
				<?php } else { ?> 
					<input type="text" name="endprice" id="fullprice" onchange="componentPrice();"> </td>
				<?php } ?>
				<td>
				<?php if ($left_for_us != 1) { ?> 
					<input type="button" value="Másol" id="copy_price" class="button" onClick="copyprice();">
				<?php } else { ?> 
					<input type="button" style="display:none;" value="Másol" id="copy_price" class="button" onClick="copyprice();">
				<?php } ?>
					
				</td>
				<td>
				<?php if ($left_for_us != 1) { ?> 
					<input type="button" id="kiertekeles" value="Kiértékelés" onClick="calcFullPrice_oForm();" >
				<?php } else { ?> 
					<input type="button" id="kiertekeles" value="Kiértékelés" onClick="componentPrice();" >
				<?php } ?>
				</td>
			</tr>
			<tr>
				<td>
					Bolt választó:
				</td>
				<td colspan="4">
					<select id="shop_select" name="shop_select" >
					<?php if (isset($_GET['popup']) && ($_GET['popup'] == true) || isset($_GET['r_ajanlat'])) { ?>
							<option value="0" selected>Rendelésből készítve!</option>
					<?php } else { ?>
							<option disabled value="" selected>Válasszon Boltot!</option>
							<?php 
								$query = "SELECT id, name FROM `shops` WHERE enable = 1";
								$result = mysql_query($query) or die(mysql_error());

								while ($row = mysql_fetch_assoc($result)) {
									$shopid = $row['id'];
									$shopname = $row['name'];
									echo "<option value='$shopid' >$shopname</option>";
								}
							?>
					<?php } ?>
					</select>
				</td>
					<?php if (isset($_GET['subpage']) && $_GET['subpage'] == "ajanlat_szerkesztes") { ?>
						<td> <input type="button" id="submit" value="Módosítom!" onClick="update_offer('ajanlat_szerkesztes');"> </td>
					<?php } else { ?>
						<td> <input type="button" id="submit" value="Módosítom!" onClick="update_offer('uj_megrendeles');"> </td>
					<?php } ?>
				</td>
			</tr>
		</table>
		<script type="text/javascript"> 
			setTimeout(calculatePrice_oForm(), 50);
			setTimeout(writeWPrice_oForm(), 100);
			setTimeout(writeFPrice_oForm(), 150);
			setTimeout(writeLPrice_oForm(), 200);
			setTimeout(writeRPrice_oForm(), 250);
		</script>
		</form>
		<?php } ?>
</body>
</html>