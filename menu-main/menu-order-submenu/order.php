<style type="text/css">
#shop_changer {
	display: none;
	padding: 5px 5px 5px 15px;
	border-radius: 5px;
	width: 275px;
	height: 140px;
	position: fixed;
	margin: 0px auto;
	left: 41%;
	top: 31%;
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

	#shop_changer > h1 {
		color: #fff;
		font-size: 21px;
		/*margin-top: 30px;
		margin-bottom: 40px;
		margin-left: 65px;
		margin-right: 70px;*/
	}
</style>
<script type="text/javascript" src="js/jquery-1.10.2.js"></script>
	<script type="text/javascript" src="js/protea_functions.js"></script>

<div class="title">
	<span class="firstWord">Rögzített</span> Rendelés
</div>

<div id="shop_changer" style="z-index: 6;">
</div>

<?php
	if (isset($_GET["id"])){
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
		
		function mymonth($m){
			switch ($m){
				case 1: 
					return "Január";
					break;
				case 2: 
					return "Február";
					break;
				case 3: 
					return "Március";
					break;
				case 4: 
					return "Április";
					break;
				case 5: 
					return "Május";
					break;
				case 6: 
					return "Június";
					break;
				case 7: 
					return "Július";
					break;
				case 8: 
					return "Augusztus";
					break;
				case 9: 
					return "Szeptember";
					break;
				case 10: 
					return "Október";
					break;
				case 11: 
					return "November";
					break;
				case 12: 
					return "December";
					break;
			}			
		}

		$query = "SELECT id,name FROM  `users`;";
		$result = mysql_query($query) or die (mysql_error());
		while ($row = mysql_fetch_assoc($result)) {
			$user[$row["id"]]= $row["name"];
		}
		
		$query = "SELECT id,name FROM  `shops`;";
		$result = mysql_query($query) or die (mysql_error());
		while ($row = mysql_fetch_assoc($result)) {
			$shops[$row["id"]]= $row["name"];
		}

		$query = "SELECT *
		FROM ribbon_type;";

		$result = mysql_query($query) or die (mysql_error());

		while ($row = mysql_fetch_assoc($result)) {
			$ribbon_type[$row["type"]]= $row["price"];
		}

		$query = "SELECT *
		FROM ribbon_color;";

		$result = mysql_query($query) or die (mysql_error());

		while ($row = mysql_fetch_assoc($result)) {
			$ribbon_color[$row["color"]]= $row["price"];
		}

		
		echo'<span class="next_week" style="float:right; margin-top:-38px;">';
	
		if ($_SESSION['logged_in'] == 1 || $_SESSION['logged_in'] == 2 || $_SESSION['logged_in'] == 3) {
			echo '<a class="button" href="#" onClick="shop_change('.$_GET["id"].');">áthelyezés</a>';
		}
		echo '
			| <a class="button" href="/menu-main/menu-order-submenu/get-order-pdf.php?id='.$_GET["id"].'" target="blank">nyomtatás</a>';
		echo '
			| <a class="button" href="menu-main/menu-order-submenu/mark_it.php?id='.$_GET["id"].'" id="mark_as_paid" onClick="return mark_it();">rendezettnek jelölöm</a>';

		echo '</span>';

		$query = "SELECT *
		FROM orders  
		WHERE orders.id=".$_GET['id'].";";

		$result = mysql_query($query) or die (mysql_error());

		while ($row = mysql_fetch_assoc($result)) {
			echo'	<div style="padding: 5px;">
						<span style="padding: 4px; font:bold 16px/20px Georgia, serif; color:#627f6b;">Megrendelői információk</span>
						<div style="margin: 22px 10px 0px 0px; float:right;">
							<p>
								Megrendelő: <span class="data">'.$row["customer_name"].'</span><br/>
								Telefonszám: <span class="data">'.$row["phone_number"].'</span><br/>';
								if (isset($row['email']) && $row['email'] != "") {
									echo 'E-mail: <a class="data" href="mailto:'.$row["email"].'">'.$row["email"].'</a>';
								}
			echo '			</p>
						</div>
						<div style="border-bottom: solid 1px #5f7f71; margin: 10px 0px 10px 10px;">
							<p style="margin-bottom: 10px;">';
							if (isset($row["deadname"]) && $row["deadname"]!=""){
								echo' Elhunyt: <span class="data" style="color:#000;"> &#8224; '.$row["deadname"].'</span><br/>';
							}
						$mydate = date("Y",strtotime($row["ritual_time"])) . " " . mymonth(date("n",strtotime($row["ritual_time"]))) . " " . date("d",strtotime($row["ritual_time"])) . ", " . myday(date("N",strtotime($row["ritual_time"]))) . " - ". date("H:i",strtotime($row["ritual_time"]));

						if (isset($row["shipment"]) && $row["shipment"]!="Nem kér kiszállítást"){
						echo'
								Szertartás: <span class="data" style="color: #f98570">'.$mydate.'</span>';
						}else{
						echo'
								Átvétel időpontja: <span class="data" style="color: #f98570">'.$mydate.'</span>';						
						}
						echo '</p>
							<p style="margin: 10px 0px 10px 0px;">';
							
							echo 'Helyszín: <span class="data">'.$row["shipment"].'</span>';
								if ((isset($row['clocation']) && $row['clocation'] != "") || (isset($row['caddress']) && $row['caddress'] != "")) {
									echo 'Cím: <span class="data">'.$row["clocation"].' '.$row["caddress"].'</span>';
								}
								if (isset($row['cfuneral']) && $row['cfuneral'] != "") {
									echo 'Terem: <span class="data">'.$row["cfuneral"].'</span>';
								}
						echo'</p>
							<p style="margin: 10px 0px 10px 0px;">';							
								if (isset($row['note']) && $row['note'] != "") {
									echo 'Megjegyzés: <span class="data">'.$row["note"].'</span>';
								}
				echo '		</p>
						</div>';

						$query = "SELECT COUNT(id)
									FROM order_items
									WHERE order_id='".$row["id"]."' AND is_offer=0";
						
						$result = mysql_query($query) or die (mysql_error());
						$wreath_special_db = mysql_result($result,0);

				echo '	<div>';
					if ($wreath_special_db  > 0){
					echo'	<span style="padding: 4px; margin-top: 5px; font:bold 16px/20px Georgia, serif; color:#627f6b;">Katalógusból kiválaszott koszorúk</span>';
					}
				echo'		<p>';
				echo '			<div style="margin: 10px 0px 10px 10px;">';
						
								$query_wreaths = "SELECT *
											FROM order_items
											WHERE order_id='".$row["id"]."' AND is_offer=0";
											
								$result_wreaths = mysql_query($query_wreaths) or die (mysql_error());

								$ind = 1;
								while ($row_wreaths = mysql_fetch_array($result_wreaths)) {

									echo '<div style="margin-bottom: 10px;">';
						
										$query_wreath = "SELECT special_wreath.picture, special_wreath.id,special_wreath.fancy, special_wreath.name, special_wreath.note, special_wreath.calculate_price, special_wreath.sale_price, base_wreath.price, base_wreath.size, base_wreath.note AS base_wreath_note
													FROM special_wreath,base_wreath
													WHERE special_wreath.base_wreath_id=base_wreath.id AND special_wreath.name='".$row_wreaths["wreath_name"]."'";
										
										$result_wreath = mysql_query($query_wreath) or die (mysql_error());

										while ($row_wreath = mysql_fetch_array($result_wreath)) {
											echo'<div style="width:120px; padding:5px; float: right;">
													<a href="'.$conf_path_abs.'/img/wreath/'.trim($row_wreath["picture"],"|").'" target="_blank"><img style="width: 112px;" src="'.$conf_path_abs.'/img/wreath/'.trim($row_wreath["picture"],"|").'"/></a>
												</div>';

											echo '<div>
												<p>
													<div style="vertical-align: baseline;">
														#'.$ind.' Koszorú: <span style="font:bold 14px/30px Georgia, serif; color:#f98570;">#'.$row_wreaths['azonosito'].'</span>
														<span style="font:bold 14px/30px Georgia, serif; color:#89a583;">'.$row_wreath["name"].'</span>
														<span style="font:bold 11px/20px Georgia, serif; color:#627f6b;"> - '.$row_wreath["fancy"].'</span>
													</div>
													<div style="margin-top:8px; font-style:italic;">'.$row_wreath["note"].'</div>';

												echo '<div style="float:right; width: 450px;">
													<span style="font:bold 14px/30px Georgia, serif; color:#89a583;">Szalag</span>
													<p>';


													if ($row_wreaths['ribbon_id'] != "" && $row_wreaths['ribbon_id'] != null) {
															$query_ribbid = "SELECT * FROM  `ribbons` WHERE id='".$row_wreaths['ribbon_id']."';";
															$result_ribbid = mysql_query($query_ribbid, $conn) or die(mysql_error());
															while ($row_ribbid = mysql_fetch_assoc($result_ribbid)) {
															
																$spec_offer_ribbon_tpye = $row_ribbid['ribbon'];
																$spec_offer_ribbon_color = $row_ribbid['ribboncolor'];
															
																echo 'Típus: <span style="font-weight: bold; margin-right: 30px;">'.$row_ribbid['ribbon'].'</span>';
																echo 'Szín: <span style="font-weight: bold; margin-right: 30px;">'.$row_ribbid['ribboncolor'].'</span>';
																echo '<p>Egyik oldal: <span style="font-weight: bold; margin-right: 30px;">'.substr($row_ribbid["farewelltext"], strpos($row_ribbid["farewelltext"],"-")+2).'</span></p>';
																echo '<p>Másik oldal: <span style="font-weight: bold; margin-right: 30px;">'.$row_ribbid['givers'].'</span></p>';
															}

													}else{
															echo '<span style="font-weight: bold; margin-right: 30px;">Szalag nélkül kérték!</span>';
														
													}

												echo'</p>
													</div>';
									
												echo '<div>
														<span style="font:bold 14px/30px Georgia, serif; color:#89a583;">Alap</span>
														<p style="padding: 10px; width: 380px;">'.$row_wreath["size"].', '.$row_wreath["base_wreath_note"].'</p>
													</div>';
													
													
													$query_flowers = "	SELECT flower.type, flower.color, flower.price ,conect_flower_special_wreath.priece 
																		FROM `conect_flower_special_wreath`,`flower` 
																		WHERE conect_flower_special_wreath.special_wreath_id = '".$row_wreath['id']."' AND conect_flower_special_wreath.id_flower = flower.id
																		ORDER BY flower.leaf ASC, conect_flower_special_wreath.priece DESC;";
													$result_flowers = mysql_query($query_flowers) or die (mysql_error());
													
												echo '<div>
														<span style="font:bold 14px/30px Georgia, serif; color:#89a583;">&Ouml;sszetev&#337;k</span>';

														while ($row_flower = mysql_fetch_array($result_flowers)) {
														echo '<div style="width: 300px;">
																<div style="float: right; width: 50px;">'. $row_flower["priece"] . ' db</div>
																<div style="float: right; width: 170px;">'. $row_flower["color"] . '</div>
																<div style="float: right; width: 80px;">'. $row_flower["type"] . '</div>
															</div>';
														}
												echo '</div>
												</p>
											</div>';
											echo '<div style="vertical-align: baseline; text-align: left; margin-bottom: 10px; border-bottom: dotted 1px #cb361b;" >';
											
											echo ' Koszorú ára: <span style="font:bold 14px/30px Georgia, serif; color:#627f6b;">'.number_format($row_wreath["sale_price"], 0, ',', ' ') .' Ft</span>';


											if ($spec_offer_ribbon_tpye != "") {
												$ribbon_price = $ribbon_type[$spec_offer_ribbon_tpye]+$ribbon_color[$spec_offer_ribbon_color];
												echo ' + Szalag ára: <span style="font:bold 14px/30px Georgia, serif; color:#627f6b;">'.number_format($ribbon_price, 0, ',', ' ') .' Ft </span>';
											}
											
											
											echo '<span style="float:right;">Összeg: <span style="font:bold 14px/30px Georgia, serif; color:#ef5f44;">'.number_format($ribbon_price+$row_wreath["sale_price"], 0, ',', ' ') .' Ft</span></span></div>';


											// if ($row_wreaths['ribbon'] != "") {
											// 	echo ' + Szalag ára: <span style="font:bold 14px/30px Georgia, serif; color:#627f6b;">'.number_format($ribbon_type[$row_wreaths['ribbon']]+$ribbon_color[$row_wreaths['ribboncolor']], 0, ',', ' ') .' Ft </span>';
											// }
											
											
											// echo '<span style="float:right;">Összeg: <span style="font:bold 14px/30px Georgia, serif; color:#ef5f44;">'.number_format($ribbon_type[$row_wreaths['ribbon']]+$ribbon_color[$row_wreaths['ribboncolor']]+$row_wreath["sale_price"], 0, ',', ' ') .' Ft</span></span></div>';
										}
									$ind++;
							echo '</div>';
								}
						
						echo '</div>
							</p>
						</div>';

						$query = "SELECT COUNT(id)
									FROM order_items
									WHERE order_id='".$row["id"]."' AND is_offer=1;";
											
						$result = mysql_query($query) or die (mysql_error());
						$wreath_offer_db = mysql_result($result,0);

				echo '	<div>';
						if ($wreath_offer_db > 0){
							echo'<span style="padding: 4px; margin-top: 5px; font:bold 16px/20px Georgia, serif; color:#627f6b;">Ajánlatokból kiválaszott koszorúk</span>';
						}
						echo' <p>';
				echo '			<div style="margin: 10px 0px 10px 10px;">';
						
								$query_wreaths = "SELECT *
											FROM order_items
											WHERE order_id='".$row["id"]."' AND is_offer=1";
											
								$result_wreaths = mysql_query($query_wreaths) or die (mysql_error());

								while ($row_wreaths = mysql_fetch_array($result_wreaths)) {
									echo '<div style="margin-bottom: 10px;">';
						
										$query_wreath = "SELECT offer_wreath.left_for_us, offer_wreath.id, offer_wreath.name, offer_wreath.note, offer_wreath.calculate_price, offer_wreath.sale_price, offer_wreath.ribbon_id , base_wreath.price, base_wreath.size, base_wreath.note AS base_wreath_note
								FROM offer_wreath,base_wreath
								WHERE offer_wreath.base_wreath_id=base_wreath.id AND offer_wreath.name='".$row_wreaths["wreath_name"]."'";
										
										$result_wreath = mysql_query($query_wreath) or die (mysql_error());

										while ($row_wreath = mysql_fetch_array($result_wreath)) {
											echo '<div>
												<p>
													<div style="vertical-align: baseline;">
														#'.$ind.' Ajánlat: <span style="font:bold 14px/30px Georgia, serif; color:#f98570;">#'.$row_wreaths['azonosito'].'</span>
														<span style="font:bold 14px/30px Georgia, serif; color:#89a583;">'.$row_wreath['name'].'</span>
													</div>
													<div style="margin-top:8px; font-style:italic;">'.$row_wreath["note"].'</div>';
											echo'</p>
												</div>';

											echo '<div style="float:right; width: 605px;">
												<span style="font:bold 14px/30px Georgia, serif; color:#89a583;">Szalag</span>
												<p>';

												$offer_ribbon_tpye = "";
												$offer_ribbon_color = "";
												if ($row_wreath['ribbon_id'] != "" && $row_wreath['ribbon_id'] != null) {
//												if ($row_wreath['ribbon_id'] != "") {
														$query_ribbid = "SELECT * FROM  `ribbons` WHERE id='".$row_wreath['ribbon_id']."';";
														$result_ribbid = mysql_query($query_ribbid, $conn) or die(mysql_error());

														while ($row_ribbid = mysql_fetch_assoc($result_ribbid)) {
														
															$offer_ribbon_tpye = $row_ribbid['ribbon'];
															$offer_ribbon_color = $row_ribbid['ribboncolor'];
														
															echo 'Típus: <span style="font-weight: bold; margin-right: 30px;">'.$row_ribbid['ribbon'].'</span>';
															echo 'Szín: <span style="font-weight: bold; margin-right: 30px;">'.$row_ribbid['ribboncolor'].'</span>';
															echo '<p>Egyik oldal: <span style="font-weight: bold; margin-right: 30px;">'.substr($row_ribbid["farewelltext"], strpos($row_ribbid["farewelltext"],"-")+2).'</span></p>';
															echo '<p>Másik oldal: <span style="font-weight: bold; margin-right: 30px;">'.$row_ribbid['givers'].'</span></p>';
														}

												}else{
														echo '<span style="font-weight: bold; margin-right: 30px;">Szalag nélkül kérték!</span>';
												}
											echo'</p>
												</div>';
												
											echo '
												<div>
													<span style="font:bold 14px/30px Georgia, serif; color:#89a583;">Alap</span>
													<p style="padding: 10px; width: 380px;">'.$row_wreath["size"].', '.$row_wreath["base_wreath_note"].'</p>
												</div>';

										
											$query_flowers = "	SELECT flower.type, flower.color, flower.price ,conect_flower_offer_wreath.priece 
												FROM `conect_flower_offer_wreath`,`flower` 
												WHERE conect_flower_offer_wreath.offer_wreath_id = '".$row_wreath['id']."' AND conect_flower_offer_wreath.id_flower = flower.id;";

											$result_flowers = mysql_query($query_flowers) or die (mysql_error());
											echo '<div>
													<span style="font:bold 14px/30px Georgia, serif; color:#89a583;">&Ouml;sszetev&#337;k</span>';




					$offer_ribbon_tpye = "";
					$offer_ribbon_color = "";

					if ($row_wreaths['ribbon_id'] != "") {

						$query_ribbid = "SELECT * FROM  ribbons WHERE id='".$row_wreaths['ribbon_id']. "';";
						$result_ribbid = mysql_query($query_ribbid, $conn) or die(mysql_error());

						while ($row_ribbid = mysql_fetch_assoc($result_ribbid)) {
							$offer_ribbon_tpye = $row_ribbid['ribbon'];
							$offer_ribbon_color = $row_ribbid['ribboncolor'];
						}

					}
				
					$ribbonprice = 0;
					if ($offer_ribbon_tpye != "") {						
						$ribbonprice = $ribbon_type[$offer_ribbon_tpye]+$ribbon_color[$offer_ribbon_color];
					}


					if (isset($row_wreath["left_for_us"]) &&  $row_wreath["left_for_us"] == 1){
						echo "<div style='font-weight: bold; padding: 10px 0px;'>Koszorú kötõre bízva az összeállítás, " . ($row_wreath[sale_price] - $row_wreath[price] - $ribbonprice) . " ft értékben tartalmazhat virágot.</div>";
					}else{
						$query_flowers = "	SELECT flower.type, flower.color, flower.price ,conect_flower_offer_wreath.priece 
											FROM `conect_flower_offer_wreath`,`flower` 
											WHERE conect_flower_offer_wreath.offer_wreath_id = '".$row_wreath['id']."' AND conect_flower_offer_wreath.id_flower = flower.id
											ORDER BY flower.leaf ASC, flower.type ASC;";

						$result_flowers = mysql_query($query_flowers, $conn) or die(mysql_error());

						while ($row_flower = mysql_fetch_assoc($result_flowers)) {
							echo '<div style="width: 300px;">';
								if (($row_flower["priece"] * 100) % 100  == 0 ){
									echo '<div style="float: right; width: 50px;">'. round($row_flower["priece"],0) . ' db</div>';
								}else{
									echo '<div style="float: right; width: 50px;">'. $row_flower["priece"] . ' db</div>';
								}
							echo'
								<div style="float: right; width: 170px;">'. $row_flower["color"] . '</div>
								<div style="float: right; width: 80px;">'. substr($row_flower["type"],0,12) . '</div>
							</div>';

							}
					}





											echo '<div style="vertical-align: baseline; text-align: left; margin-bottom: 10px; border-bottom: dotted 1px #cb361b;" >';

											$ribbon_price = 0;
											if ($offer_ribbon_tpye != "") {
												$ribbon_price = $ribbon_type[$offer_ribbon_tpye]+$ribbon_color[$offer_ribbon_color];
											}
											
											echo ' Koszorú ára: <span style="font:bold 14px/30px Georgia, serif; color:#627f6b;">'.number_format($row_wreath["sale_price"]-$ribbon_price, 0, ',', ' ') .' Ft</span>';

											if ($offer_ribbon_tpye != "") {

												$ribbon_price = $ribbon_type[$offer_ribbon_tpye]+$ribbon_color[$offer_ribbon_color];
												echo ' + Szalag ára: <span style="font:bold 14px/30px Georgia, serif; color:#627f6b;">'.number_format($ribbon_price, 0, ',', ' ') .' Ft </span>';
											}
																						
											echo '<span style="float:right;">Összeg: <span style="font:bold 14px/30px Georgia, serif; color:#ef5f44;">'.number_format($ribbon_type[$row_wreaths['ribbon']]+$ribbon_color[$row_wreaths['ribboncolor']]+$row_wreath["sale_price"], 0, ',', ' ') .' Ft</span></span></div>';

										}
									echo '</div>';
								$ind++;
								}

						echo '	</div>
							</p>
						</div>';		

				echo'
					<div style="border-top: solid 1px #5f7f71; margin: 10px 0 10px 0; min-height:50px;">
						<span style="padding: 4px; font:bold 16px/20px Georgia, serif; color:#627f6b;">Fizetési információk</span>
						<div style="margin: 10px 0px 10px 10px;">';
						if ($row['paid'] != Null) {
							echo'<p>
								<span style="float:right;">Végösszeg: <span class="data" style="margin-right: 0px; color:#000;">'.number_format($row["price"], 0, '', ' ').' Ft</span> 
								<span class="data" style="color:#f98570;"> (FIZETVE) </span></span>
								</p>';
						}
						else {
							echo'<p>
									Szállítási költség <span class="data">'.number_format($row['ship_price'], 0, '', ' ').' Ft</span>';

							echo
									'Előleg: <span class="data">'.number_format($row['downprice'], 0, '', ' ').' Ft</span>
									Hátralék: <span class="data">'.number_format(($row["price"]-$row['downprice']), 0, '', ' ').' Ft</span>';

							echo'
									<span style="float:right;"> Végösszeg: <span class="data" style="color:#ef5f44;">'.number_format($row["price"], 0, '', ' ').' Ft</span></span>
								</p>';
						}
				echo '
						</div>
					</div>';

				echo'
					<div style="border-top: solid 1px #5f7f71; margin-top: 10px;">
						<span style="padding: 4px; font:bold 16px/20px Georgia, serif; color:#627f6b;">Egyéb információk</span>
						<div style="margin: 10px 0px 10px 10px;">
						<p style="padding-top:10px;">
							Megrendelést felvették: <span class="data">'.$shops[$row['shop']].' </span>
							Készítő bolt: <span class="data">'.$shops[$row['maker_shop']].' </span>
						</p>
						<p style="padding-top:10px;">
							Felvevő: <span class="data">'.$user[$row['worker_id']].'</span>
							Felvétel ideje: <span class="data">'. date("Y",strtotime($row["create_time"])) . " " . mymonth(date("n",strtotime($row["create_time"]))) . " " . date("d",strtotime($row["create_time"])) . ", " . myday(date("N",strtotime($row["create_time"]))) . " - ". date("H:i",strtotime($row["create_time"])).'</span>
						</p>
						</div>
					</div>';

					
		echo'	</div>';
		}
	}
?>