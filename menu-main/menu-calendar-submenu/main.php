<style type="text/css">
	#calendar{
		margin:10px 0px 50px 0px;
	}	
	#calendar tr{
		border-bottom: 1px solid #5f7f71;
	}
	#calendar tr.now{
		border-bottom: 1px solid #5f7f71;
		background-color:#cae3a1;
	}
	#calendar th{
		width: 70px;
		margin: 0px;
		padding: 2px;
		text-align: center;
		text-transform: none;
	}

	#calendar th a{
		font: normal 12px/18px "Arial";
		color: #5f7f71;
		text-decoration:none;
	}	
	
	#calendar td{
		padding: 2px;
		width: 70px;
		text-align: left;
		text-transform: none;
	}

	#calendar td a{
		font: normal 8px/12px "Arial";
		color: #5f7f71;
		text-decoration:none;	
	}
	
	#calendar td .entry{
		font: normal 8px/12px "Arial";
		color: #5f7f71;
		text-decoration:none;	
	}
	
	#calendar td .entry_full{
		margin: 1px 0px 0px 15px;
		text-align: left;
		text-transform: none;
	}

	#calendar td.hour{
		margin: 0;
		padding: 2px 0px 10px 0px;
		font: normal 12px/18px "Arial";
		color: #5f7f71;
		text-align: left;
		text-transform: none;
		width: 20px;
		vertical-align: center;
		border-right: 10px solid #ffffff;
	}
	
	.next_week a{
		background: url(../img/btn-bg1.png) repeat-x 0 0px;
		padding: 5px;
		color: #fff;
		border: 0px;
		width: 85px;
		right: 12px;
		margin-top: 5px;
		height: 20px;
		border-style: outset;
		cursor: pointer;
		text-decoration: none;
		text-transform: none;
	}
	.next_week a:hover{
		background: url(../img/btn-bg2.png) repeat-x 0 0px;
		padding: 5px;
		color: #fff;
		border: 0px;
		width: 85px;
		right: 12px;
		margin-top: 5px;
		height: 22px;
		border-style: outset;
		cursor: pointer;
		text-decoration: none;
		text-transform: none;
	}
	.next_week .deliver{
		padding: 0px 5px 0px 5px;
		border-left: 15px solid #FFBD00;
	}
	.next_week .other{
		padding: 0px 5px 0px 5px;
		border-left: 15px solid #5f7f71;
	}
	.next_week .first{
		padding: 0px 5px 0px 5px;
		border-left: 15px solid #fb664b;
	}
	.next_week .second{
		padding: 0px 5px 0px 5px;
		border-left: 15px solid #5c96ff;
	}
	.next_week .third{
		padding: 0px 5px 0px 5px;
		border-left: 15px solid #6A1A4A;
	}
	.next_week .office{
		padding: 0px 5px 0px 5px;
		border-left: 15px solid #000;
	}
	.selected_day{
		background-color:#cae3a1;
	}
	
	
	.separate{
		width: 10px;
		border-left: 10px solid #ffffff;
	}
	
</style>

<?php

	$query = "SELECT * 
		FROM shops 
		WHERE enable = 1;";

	$result = mysql_query($query) or die (mysql_error());
	while ($row = mysql_fetch_assoc($result)) {
		$shop[$row["id"]] = $row["name"];
	}
	
	mysql_query('SET CHARACTER SET utf8_hungarian_ci;');

?>

<div  id="content" style="padding: 10px; margin-top:0px; background-color: #fff; float:left; height: 1550px; width:1040px;">

<div class="title">
	<span class="firstWord">Egyedi Bolt</span> Naptár
	<span class="next_week" style="float:right;">
		<span class='deliver'>Szállítás<span> | 
		<span class='first'><?php echo $shop[1]; ?></span> | 
		<span class='second'><?php echo $shop[2]; ?></span> |
	<?php  if (isset($shop[3])){ ?>
		<span class='third'><?php echo $shop[3]; ?></span> |
	<?php } ?>
		<span class='other'>Internet</span> |
		<span class='office'>Irodák</span>
	</span>
</div>

<div class="title">
	<?php 
		
		if (isset($_GET['year'])){
			$y = $_GET['year'];
		}else{
			$y = date("Y");
		}

		if (isset($_GET['week'])){
			$week += $_GET['week'];
		}else{
			$week = date("W")+1-1;
		}				
		if ($week==0){
			$y--;
			$week=52;
		}elseif ($week==53){
			$week=1;
			$y++;
		}
		
		$time = strtotime("1 January ".$y, time());
		$time += ((7*($week-1))+1-date('w', $time))*24*3600;

		$first_day_in_week = date('Y-m-d', $time);
		$last_day_in_week = date('Y-m-d',($time + 6*24*3600));
		$year = date('Y', $time);

		echo $y . '. év - ' . $week .'. hét - <span class="firstWord">'.$first_day_in_week.' - '. $last_day_in_week .'</span>';	
		echo '
			<span class="next_week" style="float:right;">
				<a href="?page=naptar&subpage=osszesitett&week='.($week-1).'&year='.($y).'">elöző</a> | 
				<a href="?page=naptar&subpage=osszesitett">aktualis hét</a> | 
				<a href="?page=naptar&subpage=osszesitett&week='.($week+1).'&year='.($y).'">következő</a>
			</span>';
/*			
		$time = strtotime("1 January ".date("Y"), time());
		$time += ((7*(date("W")-1+$week))+1-date('w', $time))*24*3600;

		$first_day_in_week = date('Y-m-d', $time);
		$last_day_in_week = date('Y-m-d',($time + 6*24*3600));

		echo (date("W")+$week) .'. hét - <span class="firstWord">'.$first_day_in_week.' - '. $last_day_in_week .'</span>';	
		echo '<span class="next_week" style="float:right;">
			<a href="?page=naptar&subpage=osszesitett&week='.($week-1).'">elöző</a> | 
			<a href="?page=naptar&subpage=osszesitett&week=0">aktualis hét</a> | 
			<a href="?page=naptar&subpage=osszesitett&week='.($week+1).'">következő</a>
		</span>';
*/
	?>
</div>

<div style="overflow:auto;">
	
	<?php  if (isset($shop[3])){ ?>
	<div style="width: 1600px;">
		<a href="?page=naptar&subpage=bolt&shop=3&week=<?php echo $week; ?>"><span style="float:right; padding-right: 260px; font-weight:bold; color: #6A1A4A;"><?php echo $shop[3]; ?></span></a>
		<a href="?page=naptar&subpage=bolt&shop=2&week=<?php echo $week; ?>"><span style="float:right; padding-right: 390px; font-weight:bold; color: #5c96ff;"><?php echo $shop[2]; ?></span></a>
		<a href="?page=naptar&subpage=bolt&shop=1&week=<?php echo $week; ?>"><span style="float:left; padding-left: 260px;font-weight:bold; color: #fb664b;"><?php echo $shop[1]; ?></span></a>
	<?php }else{ ?>
	<div style="width: 1040px;">
		<a href="?page=naptar&subpage=bolt&shop=2&week=<?php echo $week; ?>"><span style="float:right; padding-right: 190px; font-weight:bold; color: #5c96ff;"><?php echo $shop[2]; ?></span></a>
		<a href="?page=naptar&subpage=bolt&shop=1&week=<?php echo $week; ?>"><span style="float:left; padding-left: 260px;font-weight:bold; color: #fb664b;"><?php echo $shop[1]; ?></span></a>
	<?php }?>
	</div>

	<?php  if (isset($shop[3])){ ?>
	<table id='calendar' style="width: 1598px;">
	<?php }else{ ?>
	<table id='calendar' style="width: 1034px;">
	<?php }?>
		<tr>
<?php
		echo '<th style="width:20px;"></th>';
		echo '<th><a href="?page=naptar&subpage=naptarinap&day=' .date('Ymd',($time + 0*24*3600)). '">' .date('m.d',($time + 0*24*3600)). '<br/>Hétfő</a></th>';
		echo '<th><a href="?page=naptar&subpage=naptarinap&day=' .date('Ymd',($time + 1*24*3600)). '">' .date('m.d',($time + 1*24*3600)). '<br/>Kedd</a></th>';
		echo '<th><a href="?page=naptar&subpage=naptarinap&day=' .date('Ymd',($time + 2*24*3600)). '">' .date('m.d',($time + 2*24*3600)). '<br/>Szerda</a></th>';
		echo '<th><a href="?page=naptar&subpage=naptarinap&day=' .date('Ymd',($time + 3*24*3600)). '">' .date('m.d',($time + 3*24*3600)). '<br/>Csütörtök</a></th>';
		echo '<th><a href="?page=naptar&subpage=naptarinap&day=' .date('Ymd',($time + 4*24*3600)). '">' .date('m.d',($time + 4*24*3600)). '<br/>Péntek</a></th>';
		echo '<th><a href="?page=naptar&subpage=naptarinap&day=' .date('Ymd',($time + 5*24*3600)). '">' .date('m.d',($time + 5*24*3600)). '<br/>Szombat</a></th>';
		echo '<th><a href="?page=naptar&subpage=naptarinap&day=' .date('Ymd',($time + 6*24*3600)). '">' .date('m.d',($time + 6*24*3600)). '<br/>Vasárnap</a></th>';
		
		echo '<th class="separate"><a href="?page=naptar&subpage=naptarinap&day=' .date('Ymd',($time + 0*24*3600)). '">' .date('m.d',($time + 0*24*3600)). '<br/>Hétfő</a></th>';
		echo '<th><a href="?page=naptar&subpage=naptarinap&day=' .date('Ymd',($time + 1*24*3600)). '">' .date('m.d',($time + 1*24*3600)). '<br/>Kedd</a></th>';
		echo '<th><a href="?page=naptar&subpage=naptarinap&day=' .date('Ymd',($time + 2*24*3600)). '">' .date('m.d',($time + 2*24*3600)). '<br/>Szerda</a></th>';
		echo '<th><a href="?page=naptar&subpage=naptarinap&day=' .date('Ymd',($time + 3*24*3600)). '">' .date('m.d',($time + 3*24*3600)). '<br/>Csütörtök</a></th>';
		echo '<th><a href="?page=naptar&subpage=naptarinap&day=' .date('Ymd',($time + 4*24*3600)). '">' .date('m.d',($time + 4*24*3600)). '<br/>Péntek</a></th>';
		echo '<th><a href="?page=naptar&subpage=naptarinap&day=' .date('Ymd',($time + 5*24*3600)). '">' .date('m.d',($time + 5*24*3600)). '<br/>Szombat</a></th>';
		echo '<th><a href="?page=naptar&subpage=naptarinap&day=' .date('Ymd',($time + 6*24*3600)). '">' .date('m.d',($time + 6*24*3600)). '<br/>Vasárnap</a></th>';

		if (isset($shop[3])){
			echo '<th class="separate"><a href="?page=naptar&subpage=naptarinap&day=' .date('Ymd',($time + 0*24*3600)). '">' .date('m.d',($time + 0*24*3600)). '<br/>Hétfő</a></th>';
			echo '<th><a href="?page=naptar&subpage=naptarinap&day=' .date('Ymd',($time + 1*24*3600)). '">' .date('m.d',($time + 1*24*3600)). '<br/>Kedd</a></th>';
			echo '<th><a href="?page=naptar&subpage=naptarinap&day=' .date('Ymd',($time + 2*24*3600)). '">' .date('m.d',($time + 2*24*3600)). '<br/>Szerda</a></th>';
			echo '<th><a href="?page=naptar&subpage=naptarinap&day=' .date('Ymd',($time + 3*24*3600)). '">' .date('m.d',($time + 3*24*3600)). '<br/>Csütörtök</a></th>';
			echo '<th><a href="?page=naptar&subpage=naptarinap&day=' .date('Ymd',($time + 4*24*3600)). '">' .date('m.d',($time + 4*24*3600)). '<br/>Péntek</a></th>';
			echo '<th><a href="?page=naptar&subpage=naptarinap&day=' .date('Ymd',($time + 5*24*3600)). '">' .date('m.d',($time + 5*24*3600)). '<br/>Szombat</a></th>';
			echo '<th><a href="?page=naptar&subpage=naptarinap&day=' .date('Ymd',($time + 6*24*3600)). '">' .date('m.d',($time + 6*24*3600)). '<br/>Vasárnap</a></th>';		
		}

		echo '<th style="width:20px;" class="separate"></th>';

?>
		</tr>
<?php

			$query_name = "SELECT id,type 
				FROM base_wreath_type;";

			$result_name = mysql_query($query_name) or die (mysql_error());
			while ($row_name = mysql_fetch_assoc($result_name)) {
				$wreath_type_name[$row_name["id"]] = $row_name["type"];
			}

			$query = "	SELECT id,type 
			FROM `base_wreath`;";
			
			$result = mysql_query($query) or die (mysql_error());
			while ($row = mysql_fetch_assoc($result)) {
				$wreath_type[$row["id"]] = $wreath_type_name[$row["type"]];
			}
	
			$query = "SELECT id, shop, shipment, paid, downprice,ritual_time, maker_shop
			   FROM orders 
			   WHERE WEEK(ritual_time,1)=". ($week) ." AND archive = 0 AND YEAR(ritual_time) = 2014 
			   ORDER BY ritual_time ASC;";
			
			$result = mysql_query($query) or die (mysql_error());

			while ($row = mysql_fetch_assoc($result)) {	
			
				//echo "<br />" . $row["id"] . " - " . $row["shop"] . ". bolt - ".$row["paid"]."<br />";
			
				$color = "#5f7f71";

				if ($row["shop"] == "1"){
					$color = "#fb664b";
				}elseif ($row["shop"] == "2"){
					$color = "#5c96ff";
				}elseif ($row["shop"] == "3"){
					$color = "#6A1A4A"; //#AE5BFF";
				}
				
				if ($row["shipment"] == "Egyedi helyszín"){
					$create_hour  = 2;
					$color_ship = "border-left: 5px solid #FFBD00;";
				}else if($row["shipment"] == "Erzsébeti temető"){
					$create_hour  = 1;
					$color_ship = "";
				} else{
					$create_hour  = 0;
					$color_ship = "";				
				}
				
				if (isset($row["paid"])){ //ki van fizetve!!! Tele kocka

					//echo "kifizteve:". $row["id"] . "<br />";
				
					$query_items = "SELECT azonosito,wreath_name,is_offer
					   FROM order_items 
					   WHERE order_id = ".$row['id']."
					   ORDER BY azonosito ASC;";
					
					$result_items = mysql_query($query_items) or die (mysql_error());

					while ($row_items = mysql_fetch_assoc($result_items)) {
					
						if ($row_items['is_offer'] == "1"){
							$table_name= "offer_wreath";
						}else{
							$table_name= "special_wreath";						
						}
						
						$query_base_wreath ="SELECT base_wreath_type.type, base_wreath.size
						FROM base_wreath, ".$table_name.", base_wreath_type
						WHERE ".$table_name.".name =  '".$row_items['wreath_name']."' AND base_wreath.id = base_wreath_id AND base_wreath.type = base_wreath_type.id;";
												
						$result_base_wreath  = mysql_query($query_base_wreath) or die (mysql_error());
						while ($row_base_wreath = mysql_fetch_assoc($result_base_wreath)) { //kifizetett mindent!
//							echo date("d - H:i",strtotime($row["ritual_time"])).'<br/> '.substr($row_items["wreath_name"],0,12).'<br/>';

							$order[$row["maker_shop"]][date("N",strtotime($row["ritual_time"]))][date("H",strtotime($row["ritual_time"]))-$create_hour] .=
								'<a style=" padding: 1px 0px 1px 0px;" href="?page=rendeles&subpage=megrendeles&id='.$row["id"].'">
									<div style="padding:1px; margin:3px 0px 3px 0px; '.$color_ship.'">
										<div style="height:35px; width:5px; border:3px solid '.$color.'; background-color: '.$color.';" >
											<div style="margin-left:11px;">
												<p style="font-size: 10px;">#'.$row_items["azonosito"].'</p>
												<p style="font-size: 10px; width:50px;">'.substr($row_base_wreath["size"],0,18).'</p>
											</div>
										</div>
									</div>
								</a>';
							//echo $order[$row["maker_shop"]][date("N",strtotime($row["ritual_time"]))][date("H",strtotime($row["ritual_time"]))-$create_hour];
						}
					}
				}else{

					$query_items = "SELECT azonosito,wreath_name,is_offer
					   FROM order_items 
					   WHERE order_id = ".$row['id']."
					   ORDER BY azonosito ASC;";
					
					$result_items = mysql_query($query_items) or die (mysql_error());

					while ($row_items = mysql_fetch_assoc($result_items)) { //Adott előleget!! fél kocka

						//echo "előleg, fél:". $row["id"] . "<br />";

						if (isset($row["downprice"]) && $row["downprice"]!=0){					
	
						if ($row_items['is_offer'] == 1){
							$table_name= "offer_wreath";
						}else{
							$table_name= "special_wreath";						
						}
						
						$query_base_wreath ="SELECT base_wreath_type.type, base_wreath.size
						FROM base_wreath, ".$table_name.", base_wreath_type
						WHERE ".$table_name.".name =  '".$row_items['wreath_name']."' AND base_wreath.id = base_wreath_id AND base_wreath.type = base_wreath_type.id;";
						
						$result_base_wreath  = mysql_query($query_base_wreath) or die (mysql_error());
						while ($row_base_wreath = mysql_fetch_assoc($result_base_wreath)) {
							
							//echo date("d - H:i",strtotime($row["ritual_time"])).'<br/> '.substr($row_items["wreath_name"],0,12).'<br/>';
						
							$order[$row["maker_shop"]][date("N",strtotime($row["ritual_time"]))][date("H",strtotime($row["ritual_time"]))-$create_hour] .=
							'<a style="padding: 1px 0px 1px 0px;" href="?page=rendeles&subpage=megrendeles&id='.$row["id"].'">
								<div style="margin-top:3px; '.$color_ship.'">
									<div style="padding-top:1px; margin-top:1px; height:17px; width:5px; border:3px solid '.$color.';" >													
										<div style="margin-left:11px;">
											<p style="font-size: 10px">#'.$row_items["azonosito"].'</p>
											<p style="font-size: 10px; width:50px;">'.substr($row_base_wreath["size"],0,18).'</p>
										</div>
									</div>
									<div style="padding-bottom:1px; margin-bottom:3px; height:11px; width:5px; border:3px solid '.$color.'; background-color: '.$color.';" ></div>
								</div>
							</a>';
							
							//echo $order[$row["maker_shop"]][date("N",strtotime($row["ritual_time"]))][date("H",strtotime($row["ritual_time"]))-$create_hour];
						}
						}else{ //Nem adott semmit
							//echo date("d - H:i",strtotime($row["ritual_time"])).'<br/> '.substr($row_items["wreath_name"],0,12).'<br/>';
							//echo "semmi üres:". $row["id"] . "<br />";

							if ($row_items['is_offer'] == 1){
								$table_name= "offer_wreath";
							}else{
								$table_name= "special_wreath";						
							}
							$query_base_wreath ="SELECT base_wreath_type.type, base_wreath.size
							FROM base_wreath, ".$table_name.", base_wreath_type
							WHERE ".$table_name.".name =  '".$row_items['wreath_name']."' AND base_wreath.id = base_wreath_id AND base_wreath.type = base_wreath_type.id;";
							
							$result_base_wreath  = mysql_query($query_base_wreath) or die (mysql_error());
							while ($row_base_wreath = mysql_fetch_assoc($result_base_wreath)) {

								$order[$row["maker_shop"]][date("N",strtotime($row["ritual_time"]))][date("H",strtotime($row["ritual_time"]))-$create_hour] .=
								'<a style="padding: 1px 0px 1px 0px;" href="?page=rendeles&subpage=megrendeles&id='.$row["id"].'">
									<div style="margin: 3px 0px 3px 0px; padding:1px; '.$color_ship.'">
										<div style="height:35px; width:5px; border:3px solid '.$color.';" >
										<div style="margin-left:11px;">
											<p style="font-size: 10px;">#'.$row_items["azonosito"].'</p>
											<p class="entry" style="font-size: 10px; width:55px;">'.substr($row_base_wreath["size"],0,18).'</p>
											</div>
										</div>
									</div>
								</a>';
								
								//echo $order[$row["maker_shop"]][date("N",strtotime($row["ritual_time"]))][date("H",strtotime($row["ritual_time"]))-$create_hour];
							}
						}
					}
				}
			}

		$hours = array(	6 =>'6',
						7 => '7', 
						8 => '8', 
						9 => '9', 
						10 => '10', 
						11 => '11', 
						12 => '12', 
						13 => '13', 
						14 => '14', 
						15 => '15', 
						16 => '16', 
						17 => '17', 
						18 => '18', 
						19 => '19', 
						20 => '20');
					

		for ($hour = 6; $hour <= 20; $hour++) {
			echo '<tr>';

			echo '<td class="hour">'. ($hour) .'<sup>00</sup></td>';				

			//Első Bolt
			for ($day = 1; $day <= 7; $day++){
				if ($day != date("N")|| $week != date("W")){
					echo '<td>';
					if (isset($order[1][$day][$hours[$hour]])){
						echo $order[1][$day][$hours[$hour]];
				}
					//ide kerül a megfelelő megrendelés						
					echo '</td>';				
				}else{  //ha nem az aktualis nap
					echo '<td class="selected_day">';

					if (isset($order[1][$day][$hours[$hour]])){
						echo $order[1][$day][$hours[$hour]];
					}
					//ide kerül a megfelelő megrendelés	
						
					echo '</td>';
				}
			}
					
			//Második Bolt
			for ($day = 1; $day <= 7; $day++){
				if ($day != date("N") || $week != date("W")){
					if ($day != 1){
						echo '<td>';
					}else{
						echo '<td class="separate">';
					}

					if (isset($order[2][$day][$hours[$hour]])){
						echo $order[2][$day][$hours[$hour]];
					}
					//ide kerül a megfelelő megrendelés	

					echo '</td>';
				}else{
					echo '<td class="selected_day">';

					if (isset($order[2][$day][$hours[$hour]])){
							echo $order[2][$day][$hours[$hour]];
						}
					//ide kerül a megfelelő megrendelés	

					echo '</td>';
				}
			}
			
			//Harmadik Bolt
			if (isset($shop[3])){
				for ($day = 1; $day <= 7; $day++){
					if ($day != date("N") || $week != date("W")){
						if ($day != 1){
							echo '<td>';
						}else{
							echo '<td class="separate">';
						}

						if (isset($order[3][$day][$hours[$hour]])){
							echo $order[3][$day][$hours[$hour]];
						}
						//ide kerül a megfelelő megrendelés	

						echo '</td>';
					}else{
						echo '<td class="selected_day">';

						if (isset($order[3][$day][$hours[$hour]])){
								echo $order[3][$day][$hours[$hour]];
							}
						//ide kerül a megfelelő megrendelés	

						echo '</td>';
					}
				}
			}
			
			echo '<td class="hour" style="width: 10px; border-left: 10px solid #ffffff;">'. ($hour) .'<sup>00</sup></td>';				

			echo '</tr>';
		}
		//}		
?>
	</table>
</div>

</div>
