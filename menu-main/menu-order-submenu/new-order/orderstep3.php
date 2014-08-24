<?php session_start(); ?>
<?php
	include '../../../config.php';

		function myday($d){
			switch ($d){
				case 1: 
					return "Hétfő";
					break;
				case 2: 
					return "Kedd";
					break;
				case 3: 
					return "Szerda";
					break;
				case 4: 
					return "Csütörtök";
					break;
				case 5: 
					return "Péntek";
					break;
				case 6: 
					return "Szombat";
					break;
				case 7: 
					return "Vasárnap";
					break;
			}			
		}
	
		if (isset($_GET['shipment'])) $_SESSION['shipment'] = $_GET['shipment'];
		if (isset($_GET["c_location"])) {
			$_SESSION['clocation'] = $_GET['c_location'];
		}
		if (isset($_GET["c_address"])) {
			$_SESSION['caddress'] = $_GET['c_address'];
		}
		if (isset($_GET["c_funeral"])) {
			$_SESSION['cfuneral'] = $_GET['c_funeral'];
		}

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
			$_SESSION['paid'] = "";
			if (isset($_GET['downprice'])) $_SESSION['downprice'] = $_GET['downprice'];
			if (isset($_GET['remainder'])) $_SESSION['remainder'] = $_GET['remainder'];
		}

		if (isset($_GET['order_note'])) $_SESSION['order_note'] = $_GET['order_note'];
		if (isset($_GET['shopname'])) $_SESSION['shopname'] = $_GET['shopname'];

		// echo "<pre>";
		// print_r($_SESSION['offer']);
		// echo "</pre>";
		// echo $_SESSION['offerNum'];
?>
	<table>
		 <tr>
			<td style="padding: 5px;">
				<input type="button" class="backward" value="Vissza" onClick="toStep2(true);">
			</td>
			<td style="padding: 5px;">
				<input type="button" class="forward" value="Rendelés" onClick="order();">
			</td>
		</tr>
	</table>
<form id="step5">
<?php 
echo'	<div style="padding: 5px;">
			<div style="margin-top: 10px;">
				<span style="padding: 6px; font:bold 16px/20px Georgia, serif; color:#627f6b;">Megrendelői információk</span>
				<p style="padding-left:30px;">
					<span style="text-align:right; padding-right:5px;">Elhunyt: 
					<span class="data" style="top:-20px; color:#000;"> &#8224; '.$_SESSION["dead_name"].'</span></span>
					<span style="float:right; padding-right:5px;">Megrendelő: 
					<span class="data" >'.$_SESSION["customer_name"].'</span></span>
				</p>
				<p style="padding-left:30px;">
					<span>Szertartás: <span class="data" style="color: #f98570">'.$_SESSION["ritual_date"].', '. myday(date("N",strtotime($_SESSION["ritual_date"]))) .' '.$_SESSION["ritual_time"].'</span></span>
					<span style="float:right; padding-left:20px;">Telefonszám: <span class="data">'.$_SESSION["phone_num"].'</span></span>
				</p>';
				if (isset($_SESSION['email']) && $_SESSION['email'] != "") {
					echo '<p style="padding-left:30px;">
							<span style="float:right; padding-left:20px;">E-mail: 
							<span class="data"><a class="data" href="mailto:'.$_SESSION["email"].'">'.$_SESSION["email"].'</a></span>
							</span>
						</p>';
				}
			echo '		
			</div>
			<div style="border-bottom: solid 1px #5f7f71; margin-bottom: 10px;">
				<p style="padding-left:30px; margin-bottom: 10px;">';
				if (isset($_SESSION['shipment']) && $_SESSION['shipment'] == "Egyedi helyszín") {
					echo 'Helyszín: <span class="data">'.$_SESSION["shipment"].'</span>
						Cím: <span class="data">'.$_SESSION["clocation"].' '.$_SESSION["caddress"].'</span>
						Terem: <span class="data">'.$_SESSION["cfuneral"].'</span>';
				} else {
					echo 'Helyszín <span class="data" style="color: #f98570">'.$_SESSION['shipment'].'</span>';
				}
	echo '		</p>
			</div>';

			//$_SESSION["generated_id"] = null; return;
			//AZONOSÍTÓ GENERÁLÁS
			$full_id = "";
			$con = new mysqli($conf_db_host, $conf_db_user, $conf_db_pass, $conf_db_name);
			$con->set_charset("utf8");
			$con->query("UPDATE order_id SET type=0 WHERE type=1 AND (SELECT TIMEDIFF(NOW(), date))>='00:30:00'");
			$result = $con->query("SELECT id FROM `shops` WHERE name = '{$_SESSION['shopname']}'");
			if ($row = mysqli_fetch_assoc($result)) {
				$full_id .= $row['id'];
			}
			$full_id .= "1"; //FÜGGŐBEN LEVŐ PARAMÉTER
			if (!isset($_SESSION["generated_id"])) {
				$result = $con->query("SELECT * FROM order_id WHERE type=0 ORDER BY id LIMIT 1");
				if ($result->num_rows == 1) {
					$row = mysqli_fetch_assoc($result);
					$id = $row["id"];
					$con->query("UPDATE order_id SET type=1, date=NOW() WHERE id=$id");
				} else {
					$con->query("INSERT INTO order_id (type, date) VALUES (1, NOW())");
					$result = $con->query("SELECT LAST_INSERT_ID() as id");
					$row = mysqli_fetch_assoc($result);
					$id = $row["id"];
				}
				$_SESSION["generated_id"] = $id;
			}
			$full_id .= $_SESSION["generated_id"];
			$ind = 1;
			$sub_ind = 1;
			for ($i = 0; $i < $_SESSION["wreathNum"]; $i++) {
				$_SESSION["azonosito"][$ind++] = $full_id . '/' . str_pad($sub_ind++, 2, "0", STR_PAD_LEFT);
			}
			$ind = 1;
			for ($i = 0; $i < $_SESSION["offerNum"]; $i++) {
				$_SESSION["offerazonosito"][$ind++] = $full_id . '/' . str_pad($sub_ind++, 2, "0", STR_PAD_LEFT);
			}

			
			if ($_SESSION['wreath'] != "") {
				echo '<div>
					<span style="padding: 4px; margin-top: 5px; font:bold 16px/20px Georgia, serif; color:#627f6b;">Katalógusból kiválaszott koszorúk</span>
					<p>';
					
					$ind = 1;
				
					for ($i=0; $i < $_SESSION['wreathNum']; $i++) {
						echo '<div style="margin-bottom: 10px;">';
						if ($_SESSION['wreath'][$ind] != "") {
							//$con = new mysqli('localhost', 'koszor01_user', 'Petrik2012', 'koszor01_protea');
							$con = new mysqli($conf_db_host, $conf_db_user, $conf_db_pass, $conf_db_name);
							$con->set_charset("utf8");

							$query = "SELECT special_wreath.picture, special_wreath.id,special_wreath.fancy, special_wreath.name, special_wreath.note, special_wreath.calculate_price, special_wreath.sale_price, base_wreath.price, base_wreath.size, base_wreath.note AS base_wreath_note
										FROM special_wreath,base_wreath
										WHERE special_wreath.base_wreath_id=base_wreath.id AND special_wreath.name='".$_SESSION["wreath"][$ind]."'";
										
							$result = $con->query($query);					

							while ($row = mysqli_fetch_array($result)) {
							echo'<div style="width:155px; float: right;">
									<a href="'.$conf_path_abs.'/img/wreath/'.trim($row["picture"],"|").'" target="_blank"><img style="width: 150px;" src="'.$conf_path_abs.'/img/wreath/'.trim($row["picture"],"|").'"/></a>
								</div>';

							echo '<div>
								<p>
									<div style="vertical-align: baseline;">
										#'.$ind.' Koszorú: <span style="font:bold 14px/30px Georgia, serif; color:#f98570;">#'.$_SESSION['azonosito'][$ind].'</span>
										<span style="font:bold 14px/30px Georgia, serif; color:#89a583;">'.$row["name"].'</span>
										<span style="font:bold 11px/20px Georgia, serif; color:#627f6b;"> - '.$row["fancy"].'</span>
									</div>
									<div style="margin-top:8px; font-style:italic;">'.$row["note"].'</div>';

									echo '<div style="float:right; width: 450px;">
										<span style="font:bold 14px/30px Georgia, serif; color:#89a583;">Szalag</span>
										<p>';
										$current_ribbon_price = 0;
										if ($_SESSION['ribbon'][$ind] != "") {
											$query_ribbon = "SELECT price FROM  `ribbon_type` WHERE type='".$_SESSION['ribbon'][$ind]."'";
											$result_ribbon = $con->query($query_ribbon);

											while ($ribbon_row = mysqli_fetch_assoc($result_ribbon)) {
												$current_ribbon_price += $ribbon_row['price'];
											}

											$query_rcolor = "SELECT `price` FROM `ribbon_color` WHERE color='".$_SESSION['ribboncolor'][$ind]."'";
											$result_rcolor = $con->query($query_rcolor);

											while ($rcolor_row = mysqli_fetch_assoc($result_rcolor)) {
												$current_ribbon_price += $rcolor_row['price'];
											}


											echo 'Típus: <span style="font-weight: bold; margin-right: 30px;">'.$_SESSION['ribbon'][$ind].'</span>';
											echo 'Szín: <span style="font-weight: bold; margin-right: 30px;">'.$_SESSION['ribboncolor'][$ind].'</span>';
											echo '<p>Egyik oldal: <span style="font-weight: bold; margin-right: 30px;">'.$_SESSION['farewelltext'][$ind].'</span></p>';
											echo '<p>Másik oldal: <span style="font-weight: bold; margin-right: 30px;">'.$_SESSION['givers'][$ind].'</span></p>';
										}else{
											echo '<span style="font-weight: bold; margin-right: 30px;">Szalag nélkül kérték!</span>';
										}										
									echo'</p>
										</div>';

									
									echo '
									<div>
										<span style="font:bold 14px/30px Georgia, serif; color:#89a583;">Alap</span>
										<p style="padding: 10px; width: 380px;">'.$row["size"].', '.$row["base_wreath_note"].'</p>
									</div>';
									
									
									$query_flowers = "	SELECT flower.type, flower.color, flower.price ,conect_flower_special_wreath.priece 
														FROM `conect_flower_special_wreath`,`flower` 
														WHERE conect_flower_special_wreath.special_wreath_id = '".$row['id']."' AND conect_flower_special_wreath.id_flower = flower.id
														ORDER BY flower.leaf ASC, conect_flower_special_wreath.priece DESC;";

									$result_flowers = $con->query($query_flowers);
									echo '<div>
											<span style="font:bold 14px/30px Georgia, serif; color:#89a583;">&Ouml;sszetev&#337;k</span>';
									while ($row_flower = mysqli_fetch_array($result_flowers)) {
										echo '<div style="width: 300px;">
												<div style="float: right; width: 80px;">'. $row_flower["priece"] . ' db</div>
												<div style="float: right; width: 120px;">'. $row_flower["color"] . '</div>
												<div style="float: right; width: 80px;">'. $row_flower["type"] . '</div>
											</div>';
									}
									echo '</div>
								</p>
								</div>';
								
							echo '<div style="vertical-align: baseline; text-align: right; margin-bottom: 10px; border-bottom: dotted 1px #cb361b;" >';
									echo 'Szalag ára: <span style="font:bold 14px/30px Georgia, serif; color:#ef5f44;"> '.number_format($current_ribbon_price, 0, ',', ' ') .' Ft </span>';
									echo 'Koszorú ára: <span style="font:bold 14px/30px Georgia, serif; color:#ef5f44;"> '.number_format($row["sale_price"], 0, ',', ' ') .' Ft </span>
								</div>';

							}
							$con->close();
						}
						$ind++;
						echo '</div>';
					}
				
				echo '</p>
				</div>';
			}
		echo '</div>';

		echo "<table>";
		if ($_SESSION['offer'] != "") {
			echo '<div>
				<span style="padding: 4px; margin-top: 5px; font:bold 16px/20px Georgia, serif; color:#627f6b;">Ajánlatokból kiválaszott koszorúk</span>
				<p>';

				$ind = 1;
			for ($i=0; $i < $_SESSION['offerNum']; $i++) { 
				echo '<div style="margin-bottom: 10px;">';
					$con = new mysqli($conf_db_host, $conf_db_user, $conf_db_pass, $conf_db_name);
					//$con = new mysqli('localhost', 'root', '', 'koszor01_protea');
					$con->set_charset("utf8");
				
					$query = "SELECT offer_wreath.id, offer_wreath.name, offer_wreath.note, offer_wreath.calculate_price, offer_wreath.sale_price, base_wreath.price, base_wreath.size, base_wreath.note AS base_wreath_note
								FROM offer_wreath,base_wreath
								WHERE offer_wreath.base_wreath_id=base_wreath.id AND offer_wreath.name='".$_SESSION["offer"][$ind]."'";
								
					$result = $con->query($query);					

					while ($row = mysqli_fetch_array($result)) {

							echo '<div>
								<p>
									<div style="vertical-align: baseline;">
										#'.$ind.' Ajánlat: <span style="font:bold 14px/30px Georgia, serif; color:#f98570;">#'.$_SESSION['offerazonosito'][$ind].'</span>
										<span style="font:bold 14px/30px Georgia, serif; color:#89a583;">'.$_SESSION["offer"][$ind].'</span>
									</div>';
							echo'</p>
								</div>';

							echo'<div style="margin-top:8px; font-style:italic;">'.$row["note"].'</div>';

							echo '<div style="float:right; width: 450px;">
								<span style="font:bold 14px/30px Georgia, serif; color:#89a583;">Szalag</span>
								<p>';
								$current_ribbon_price = 0;

								$query_offer_ribbon = "SELECT ribbon_id FROM  `offer_wreath` WHERE name='".$_SESSION['offer'][$ind]."'";
								$result_offer_ribbon = $con->query($query_offer_ribbon);
								
//								echo $query_offer_ribbon;
								
								while ($ribbon_offer_row = mysqli_fetch_assoc($result_offer_ribbon)) {
									if (isset($ribbon_offer_row["ribbon_id"]) && $ribbon_offer_row["ribbon_id"]!=""){
										
										$query_offrib = "SELECT * FROM `ribbons` WHERE id='".$ribbon_offer_row["ribbon_id"]."'";
										$result_offrib = $con->query($query_offrib);

										while ($offrib_row = mysqli_fetch_assoc($result_offrib)) {
											echo 'Típus: <span style="font-weight: bold; margin-right: 30px;">'.$offrib_row['ribbon'].'</span>';
											echo 'Szín: <span style="font-weight: bold; margin-right: 30px;">'.$offrib_row['ribboncolor'].'</span>';
											echo '<p>Egyik oldal: <span style="font-weight: bold; margin-right: 30px;">'.$offrib_row['farewelltext'].'</span></p>';
											echo '<p>Másik oldal: <span style="font-weight: bold; margin-right: 30px;">'.$offrib_row['givers'].'</span></p>';

											$current_ribbon_price += $offrib_row["price"];
										}
									}else{
										echo '<span style="font-weight: bold; margin-right: 30px;">Szalag nélkül kérték!</span>';
									}
								}
							echo'</p>
								</div>';
								
							echo '
								<div>
									<span style="font:bold 14px/30px Georgia, serif; color:#89a583;">Alap</span>
									<p style="padding: 10px; width: 380px;">'.$row["size"].', '.$row["base_wreath_note"].'</p>
								</div>';

							$query_flowers = "	SELECT flower.type, flower.color, flower.price ,conect_flower_offer_wreath.priece 
								FROM `conect_flower_offer_wreath`,`flower` 
								WHERE conect_flower_offer_wreath.offer_wreath_id = '".$row['id']."' AND conect_flower_offer_wreath.id_flower = flower.id;";

							$result_flowers = $con->query($query_flowers);
							echo '<div>
									<span style="font:bold 14px/30px Georgia, serif; color:#89a583;">&Ouml;sszetev&#337;k</span>';

							while ($row_flower = mysqli_fetch_array($result_flowers)) {
								echo '<div style="width: 290px;">';

										if (($row_flower["priece"] * 100) % 100  == 0 ){
											echo '<div style="text-align:right; float:right; width: 50px;">'. round($row_flower["priece"],0) . ' db</div>';
										}else{
											echo '<div style="text-align:right; float:right; width: 50px;">'. $row_flower["priece"] . ' db</div>';
										}


								echo'	<div style="float: right; width: 120px;">'. $row_flower["color"] . '</div>
										<div style="float: right; width: 120px;">'. $row_flower["type"] . '</div>
									</div>';
							}
							echo '</div>';

							echo '<div style="vertical-align: baseline; text-align: right; margin-bottom: 10px; border-bottom: dotted 1px #cb361b;" >';
									echo 'Szalag ára: <span style="font:bold 14px/30px Georgia, serif; color:#ef5f44;"> '.number_format($current_ribbon_price, 0, ',', ' ') .' Ft </span>';
									echo 'Koszorú ára: <span style="font:bold 14px/30px Georgia, serif; color:#ef5f44;"> '.number_format($row["sale_price"], 0, ',', ' ') .' Ft </span>
								</div>';
					}
				$ind++;
				echo '</div>';
			}
			echo '</p>
				</div>';
		}

		echo'
			<div style="margin-top: 10px;">
				<span style="padding: 4px; font:bold 16px/20px Georgia, serif; color:#627f6b;">Fizetési információk</span>';
				if ($_SESSION['paid'] == "Fizetve") {
					echo'	<p>
						Végösszeg: <span class="data" style="margin-right: 0px; color:#000;">'.$_SESSION['price'].'</span> <span class="data" style="color:#f98570;">(FIZETVE)</span>';

					echo'
					</p>
				</div>';	
				}
				else {
				echo'	<p>
						Végösszeg: <span class="data" style="color:#000;">'.$_SESSION['price'].'</span>';

					echo' Szállítási költség <span class="data">'.$_SESSION['ship_price'].'</span>';

					echo'Előleg: <span class="data">'.number_format($_SESSION['downprice'], 0, '', ' ').' Ft</span>
						Hátralék: <span class="data">'.$_SESSION["remainder"].'</span>
					</p>
				</div>';	
				}	
		 ?>
</form>