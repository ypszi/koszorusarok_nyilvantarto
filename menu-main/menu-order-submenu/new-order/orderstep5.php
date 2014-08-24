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
	
		if (isset($_GET['sum_price'])) $_SESSION['price'] = $_GET['sum_price'];
		if (isset($_GET['ship_price'])) $_SESSION['ship_price'] = $_GET['ship_price'];

		if (isset($_GET['paid'])) {
			$_SESSION['paid'] = "Fizetve";
		} else {
			$_SESSION['paid'] = "";
			if (isset($_GET['downprice'])) $_SESSION['downprice'] = $_GET['downprice'];
			if (isset($_GET['remainder'])) $_SESSION['remainder'] = $_GET['remainder'];
		}
?>
	<table>
		 <tr>
			<td style="padding: 5px;">
				<input type="button" class="backward" value="Vissza" onClick="toStep4(true);">
			</td>
			<td style="padding: 5px;">
				<input type="button" class="forward" value="Rendelés" onClick="if(check5())order();">
			</td>
		</tr>
	</table>
<form id="step5">

	<div style="margin: 10px 0px 10px 0px; padding: 5px;">
			<div style="float: left; margin: 0px 5px 0px 0px;">
				Megjegyzés
				<textarea style="height: 32px;width: 450px;resize: vertical;" cols="50" rows="5" id="order_note" name="order_note" placeholder="Megjegyzés"></textarea>
			</div>
			<div>	
				Bolt választó:
				<select id="shopname" name="shopname" style="position: relative; margin: 0px 0px 0px 20px;">
					<option disabled value="" selected>Válasszon Boltot!</option>
					<?php 
						$query = "SELECT name FROM `shops` WHERE enable = 1";
						$result = mysql_query($query) or die(mysql_error());

						while ($row = mysql_fetch_assoc($result)) {
							$shopname = $row['name'];
							echo "<option value='$shopname' >$shopname</option>";
						}
					?>
				</select>
			</div>
		</div>
	</div>
<?php 
echo'	<div style="padding: 5px;">
			<div style="margin-top: 10px;">
				<span style="padding: 4px; font:bold 16px/20px Georgia, serif; color:#627f6b;">Megrendelői információk</span>
				<p>
					Elhunyt: <span class="data" style="color:#000;"> &#8224; '.$_SESSION["deadname"].'</span>
					Megrendelő: <span class="data">'.$_SESSION["customer_name"].'</span>
					Telefonszám: <span class="data">'.$_SESSION["phone_num"].'</span>';
					if (isset($_SESSION['email']) && $_SESSION['email'] != "") {
						echo 'E-mail: <span class="data"><a class="data" href="mailto:'.$_SESSION["email"].'">'.$_SESSION["email"].'</a></span>';
					}
	echo '		</p>
			</div>
			<div style="border-bottom: solid 1px #5f7f71; margin-bottom: 10px;">
				<p style="margin-bottom: 10px;">
					Szertartás: <span class="data" style="color: #f98570">'.$_SESSION["ritualdate"].', '. myday(date("N",strtotime($_SESSION["ritualdate"]))) .' '.$_SESSION["ritualtime"].'</span>';
				if (isset($_SESSION['shipment']) && $_SESSION['shipment'] == "Egyedi helyszín") {
					echo 'Helyszín: <span class="data">'.$_SESSION["shipment"].'</span>
						Cím: <span class="data">'.$_SESSION["clocation"].' '.$_SESSION["caddress"].'</span>
						Terem: <span class="data">'.$_SESSION["cfuneral"].'</span>';
				} else {
					echo 'Helyszín <span class="data" style="color: #f98570">'.$_SESSION['shipment'].'</span>';
				}
	echo '		</p>
			</div>';
			
			if ($_SESSION['wreath'] != "") {
				echo '<div>
					<span style="padding: 4px; margin-top: 5px; font:bold 16px/20px Georgia, serif; color:#627f6b;">Katalógusból kiválaszott koszorúk</span>
					<p>';
					
					$ind = 1;
				
					for ($i=0; $i < $_SESSION['wreathNum']; $i++) {
						echo '<div style="margin-bottom: 10px;">';
						if ($_SESSION['wreath'][$ind] != "") {				
							$con = new mysqli('localhost', 'koszor01_user', 'Petrik2012', 'koszor01_protea');
							//$con = new mysqli('localhost', 'root', '', 'koszor01_protea');
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
										echo '<div style="width: 250px;">
												<div style="float: right; width: 40px;">'. $row_flower["priece"] . ' db</div>
												<div style="float: right; width: 120px;">'. $row_flower["color"] . '</div>
												<div style="float: right; width: 80px;">'. $row_flower["type"] . '</div>
											</div>';
									}
									echo '</div>
								</p>
								</div>';
								
							echo '<div style="vertical-align: baseline; text-align: right; margin-bottom: 10px; border-bottom: dotted 1px #cb361b;" >';
									echo 'Szalag ára: <span style="font:bold 14px/30px Georgia, serif; color:#ef5f44;">'.number_format($current_ribbon_price, 0, ',', ' ') .' Ft</span>';
									echo 'Koszorú ára: <span style="font:bold 14px/30px Georgia, serif; color:#ef5f44;">'.number_format($row["sale_price"], 0, ',', ' ') .' Ft</span>
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
					$con = new mysqli('localhost', 'koszor01_user', 'Petrik2012', 'koszor01_protea');
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
								if ($_SESSION['offerribbon'][$ind] != "") {
									$query_ribbon = "SELECT price FROM  `ribbon_type` WHERE type='".$_SESSION['offerribbon'][$ind]."'";
									$result_ribbon = $con->query($query_ribbon);

									while ($ribbon_row = mysqli_fetch_assoc($result_ribbon)) {
										$current_ribbon_price += $ribbon_row['price'];
									}

									$query_rcolor = "SELECT `price` FROM `ribbon_color` WHERE color='".$_SESSION['offerribboncolor'][$ind]."'";
									$result_rcolor = $con->query($query_rcolor);

									while ($rcolor_row = mysqli_fetch_assoc($result_rcolor)) {
										$current_ribbon_price += $rcolor_row['price'];
									}

									echo 'Típus: <span style="font-weight: bold; margin-right: 30px;">'.$_SESSION['offerribbon'][$ind].'</span>';
									echo 'Szín: <span style="font-weight: bold; margin-right: 30px;">'.$_SESSION['offerribboncolor'][$ind].'</span>';
									echo '<p>Egyik oldal: <span style="font-weight: bold; margin-right: 30px;">'.$_SESSION['offerfarewell'][$ind].'</span></p>';
									echo '<p>Másik oldal: <span style="font-weight: bold; margin-right: 30px;">'.$_SESSION['offergivers'][$ind].'</span></p>';
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

							$query_flowers = "	SELECT flower.type, flower.color, flower.price ,conect_flower_offer_wreath.priece 
								FROM `conect_flower_offer_wreath`,`flower` 
								WHERE conect_flower_offer_wreath.offer_wreath_id = '".$row['id']."' AND conect_flower_offer_wreath.id_flower = flower.id;";

							$result_flowers = $con->query($query_flowers);
							echo '<div>
									<span style="font:bold 14px/30px Georgia, serif; color:#89a583;">&Ouml;sszetev&#337;k</span>';

							while ($row_flower = mysqli_fetch_array($result_flowers)) {
								echo '<div style="width: 250px;">
										<div style="float: right; width: 40px;">'. $row_flower["priece"] . ' db</div>
										<div style="float: right; width: 120px;">'. $row_flower["color"] . '</div>
										<div style="float: right; width: 80px;">'. $row_flower["type"] . '</div>
									</div>';
							}
							echo '</div>';

							echo '<div style="vertical-align: baseline; text-align: right; margin-bottom: 10px; border-bottom: dotted 1px #cb361b;" >';
									echo 'Szalag ára: <span style="font:bold 14px/30px Georgia, serif; color:#ef5f44;">'.number_format($current_ribbon_price, 0, ',', ' ') .' Ft</span>';
									echo 'Koszorú ára: <span style="font:bold 14px/30px Georgia, serif; color:#ef5f44;">'.number_format($row["sale_price"], 0, ',', ' ') .' Ft</span>
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
						Végösszeg: <span class="data" style="margin-right: 0px; color:#000;">'.$_SESSION["price"].'</span> <span class="data" style="color:#f98570;">(FIZETVE)</span>';

					echo'
					</p>
				</div>';	
				}
				else {
				echo'	<p>
						Végösszeg: <span class="data" style="color:#000;">'.$_SESSION["price"].'</span>';

					echo' Szállítási költség <span class="data">'.$_SESSION['ship_price'].'</span>';

					echo'Előleg: <span class="data">'.number_format($_SESSION['downprice'], 0, '', ' ').' Ft</span>
						Hátralék: <span class="data">'.$_SESSION["remainder"].'</span>
					</p>
				</div>';	
				}	
		 ?>
</form>