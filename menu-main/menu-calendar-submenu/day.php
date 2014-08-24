<style type="text/css">
	#calendar{
	}	
	#calendar tr{
		border-bottom: 1px solid #5f7f71;
	}
	#calendar tr.now{
		border-bottom: 1px solid #5f7f71;
		background-color:#cae3a1;
	}
	#calendar th{
		width: 480px;
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
		width: 480px;
		text-align: left;
		text-transform: none;
	}
	
	#calendar td .entry_full{
		margin: 1px 0px 0px 15px;
		text-align: left;
		text-transform: none;
	}

	#calendar td.hour{
		margin: 0;
		padding: 2px 0px 10px 0px;
		border-right: 10px solid #ffffff;
		font: normal 12px/18px "Arial";
		color: #5f7f71;
		text-align: left;
		text-transform: none;
		width: 20px;
		vertical-align: center;
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
		background-color:#e0ebdd;
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
?>

<div  id="content" style="padding: 10px; margin-top:0px; background-color: #fff; float:left; height: 1250px; width:1040px;">

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

	if (isset($_GET['day'])){
		$selected_date = $_GET['day'];
	}else{
		$selected_date = 0;
	}
		
	
	echo '<span class="next_week" style="float:right;"><a href="?page=naptar&subpage=naptarinap&day='.date('Ymd',strtotime($selected_date) - 24*3600).'">elöző nap</a> | <a href="?page=naptar&subpage=naptarinap&day='.date('Ymd',strtotime($selected_date) + 24*3600).'">következő nap</a></span>';

	echo '<span class="next_week"><a href="?page=naptar">Vissza a heti naptárba</a></span>';

	?>
</div>

<div style="overflow:auto;">
	<?php  if (isset($shop[3])){ ?>
	<table id='calendar' style="width: 1598px;">
	<?php }else{ ?>
	<table id='calendar' style="width: 1034px;">
	<?php }?>
		<tr>
<?php
		echo '<th style="width:20px;"></th>';
		echo '<th>
					<a style="color: #fb664b; font-weight:bold;" href="?page=naptar&subpage=bolt&shop=1&week='.date('W',strtotime($selected_date)).'">'.$shop[1].'</a>
					<br/><a href="#">';

		echo date('M. d',strtotime($selected_date)) .' - ';

		switch (date('N',strtotime($selected_date))) {
		case 1:
			echo "Hétfő";
			break;
		case 2:
			echo "Kedd";
			break;
		case 3:
			echo "Szerda";
			break;
		case 4:
			echo "Csütörtök";
			break;
		case 5:
			echo "Péntek";
			break;
		case 6:
			echo "Szombat";
			break;
		case 7:
			echo "Vasárnap";
			break;
		}

		echo '</a><br/>
			<a style="padding-left:10px; color: #000000; font-weight:bold;" href="'.$conf_path_abs.'menu-main/menu-calendar-submenu/get-wreaths-pdf.php?shop=1&day=' .date('Ymd',strtotime($selected_date)). '" target="_blank" class="button">Koszorú Nyomtatás</a>
		</th>';
		
		echo '<th class="separate">
					<a style="color: #5c96ff; font-weight:bold;" href="?page=naptar&subpage=bolt&shop=2&week='.date('W',strtotime($selected_date)).'">'.$shop[2].'</a>
					<br/><a href="#">';
		
		echo date('M. d',strtotime($selected_date)) .' - ';

		switch (date('N',strtotime($selected_date))) {
		case 1:
			echo "Hétfő";
			break;
		case 2:
			echo "Kedd";
			break;
		case 3:
			echo "Szerda";
			break;
		case 4:
			echo "Csütörtök";
			break;
		case 5:
			echo "Péntek";
			break;
		case 6:
			echo "Szombat";
			break;
		case 7:
			echo "Vasárnap";
			break;
		}
		
		echo '</a></br>
			<a style="padding-left:10px; color: #000000; font-weight:bold;" href="'.$conf_path_abs.'menu-main/menu-calendar-submenu/get-wreaths-pdf.php?shop=2&day=' .date('Ymd',strtotime($selected_date)). '" target="_blank" class="button">Koszorú Nyomtatás</a>
			</th>';

		if (isset($shop[3])){
			echo '<th class="separate"><a style="color: #6A1A4A; font-weight:bold;" href="?page=naptar&subpage=bolt&shop=3&week='.date('W',strtotime($selected_date)).'">'.$shop[3].'</a>
					 <br/><a href="#">';
			
			echo date('M. d',strtotime($selected_date)) . ' - ';
			switch (date('N',strtotime($selected_date))) {
			case 1:
				echo "Hétfő";
				break;
			case 2:
				echo "Kedd";
				break;
			case 3:
				echo "Szerda";
				break;
			case 4:
				echo "Csütörtök";
				break;
			case 5:
				echo "Péntek";
				break;
			case 6:
				echo "Szombat";
				break;
			case 7:
				echo "Vasárnap";
				break;
			}
			
			echo '</a><br />
				<a style="padding-left:10px; color: #000000; font-weight:bold;" href="'.$conf_path_abs.'menu-main/menu-calendar-submenu/get-wreaths-pdf.php?shop=3&day=' .date('Ymd',strtotime($selected_date)). '" target="_blank" class="button">Koszorú Nyomtatás</a>
			</th>';
		}
		echo'<th style="width:20px;"></th>';

?>
		</tr>
<?php

$query = "SELECT id,deadname, shop, shipment, paid, downprice,ritual_time, maker_shop
			   FROM orders 
			   WHERE WEEK(ritual_time,1)=". (date('W',strtotime($selected_date))) ." AND DAY(ritual_time)=". (date('d',strtotime($selected_date)+1)) . " AND archive = 0 
			   ORDER BY ritual_time ASC;";
						
			$result = mysql_query($query) or die (mysql_error());
			
//			echo $query;
			
			while ($row = mysql_fetch_assoc($result)) {	
				$color = "#5f7f71";

				if ($row["shop"] == "1"){
					$color = "#fb664b";
				}elseif ($row["shop"] == "2"){
					$color = "#5c96ff";
				}elseif ($row["shop"] == "3"){
					$color = "#6A1A4A";
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
				
//				echo $row["id"] . " ";

				
				if (isset($row["paid"])){ //ki van fizetve!!! Tele kocka

					$query_items = "SELECT azonosito,wreath_name
					   FROM order_items 
					   WHERE order_id = ".$row['id']."
					   ORDER BY azonosito ASC;";
					
					$result_items = mysql_query($query_items) or die (mysql_error());

					while ($row_items = mysql_fetch_assoc($result_items)) {
/*						if (isset($row_items["ribbon"]) && $row_items["ribbon"] != ""){
							$ribbon = $row_items["ribboncolor"].
							' - '.$row_items["ribbon"].
							' - '.substr($row_items["farewelltext"], strpos($row_items["farewelltext"],"-")+2,40) .
							' - '.substr($row_items["givers"],0,40);
						}else{
							$ribbon = "Nem kért szalagot";
						}*/
					
						$order[$row["maker_shop"]][date("d",strtotime($row["ritual_time"]))][date("H",strtotime($row["ritual_time"]))-$create_hour] .=
							'<a style="padding: 1px 0px 1px 0px;" href="?page=rendeles&subpage=megrendeles&id='.$row["id"].'">
								<div style="padding:1px; '.$color_ship.'">
									<div style="height:20px; width:5px; border:3px solid '.$color.'; background-color: '.$color.';" >
										<div style="margin-left:15px; font: 3px arial,sans-serif;">
											<p style="color: #333333; width:470px;">
												'.date("H:i",strtotime($row["ritual_time"])).
												' - #'.$row_items["azonosito"].
												' - <span style="color:#111111; font-weight:bold;">&#8224; '.$row["deadname"]. '</span>
												- '. $row_items["wreath_name"]. '
											</p>
										</div>
									</div>
								</div>
							</a>';
					}
				}else{
					$query_items = "SELECT azonosito,wreath_name
					   FROM order_items 
					   WHERE order_id = ".$row['id']."
					   ORDER BY azonosito ASC;";
										
					$result_items = mysql_query($query_items) or die (mysql_error());

					while ($row_items = mysql_fetch_assoc($result_items)) { 
/*						if (isset($row_items["ribbon"]) && $row_items["ribbon"] != ""){
							$ribbon = $row_items["ribboncolor"].
							' - '.$row_items["ribbon"].
							' - '.substr($row_items["farewelltext"], strpos($row_items["farewelltext"],"-")+2,40) .
							' - '.substr($row_items["givers"],0,40);
						}else{
							$ribbon = "Nem kért szalagot";
						}
*/										
						if (isset($row["downprice"]) && $row["downprice"]!=0){ //Adott előleget!! fél kocka
							
//							echo $row["maker_shop"];
						
							$order[$row["maker_shop"]][date("d",strtotime($row["ritual_time"]))][date("H",strtotime($row["ritual_time"]))-$create_hour] .=
							'<div style="'.$color_ship.'">
								<a style="padding: 1px 0px 1px 0px;" href="?page=rendeles&subpage=megrendeles&id='.$row["id"].'">
									<div style="padding-top:1px; margin-top:1px; height:12px; width:5px; border:3px solid '.$color.';" >													
										<div style="margin-left:15px; font: 3px arial,sans-serif;">
											<p style="color: #333333; width:470px;">
												'.date("H:i",strtotime($row["ritual_time"])).
												' - #'.$row_items["azonosito"].
												' - <span style="color:#111111; font-weight:bold;">&#8224; '.$row["deadname"]. '</span>
												- '. $row_items["wreath_name"]. '
											</p>
										</div>
									</div>
									<div style="padding-bottom:1px; margin-bottom:1px; height:8px; width:5px; border:3px solid '.$color.'; background-color: '.$color.';" ></div>
								</a>
							</div>';
						}else{ //Nem adott semmit
							$order[$row["maker_shop"]][date("d",strtotime($row["ritual_time"]))][date("H",strtotime($row["ritual_time"]))-$create_hour] .=
							'<a style="padding: 1px 0px 1px 0px;" href="?page=rendeles&subpage=megrendeles&id='.$row["id"].'">
								<div style="padding:1px; '.$color_ship.'">
									<div style="height:20px; width:5px; border:3px solid '.$color.';" >
									<div style="margin-left:15px; font: 3px arial,sans-serif;">
											<p style="color: #333333; width:470px;">
												'.date("H:i",strtotime($row["ritual_time"])).
												' - #'.$row_items["azonosito"].
												' - <span style="color:#111111; font-weight:bold;">&#8224; '.$row["deadname"]. '</span>
												- '. $row_items["wreath_name"]. '
											</p>
										</div>
									</div>
								</div>
							</a>';						
						}
					}
				}
			}

		$hours = array(
				6 => '6',
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
			if (date("G") != ($hour)){
				echo '<tr>';
			}else{
				echo '<tr class="now">';
			}
				echo '<td class="hour">'. ($hour) .'<sup>00</sup></td>';				

				echo '<td>
					'. $order[1][(date('d',strtotime($selected_date)+1))][$hours[$hour]] .'
					</td>';

				echo '<td class="separate">
					'. $order[2][(date('d',strtotime($selected_date)+1))][$hours[$hour]] .'
				</td>';

				if (isset($shop[3])){
					echo '<td class="separate">
						'. $order[3][(date('d',strtotime($selected_date)+1))][$hours[$hour]] .'
					</td>';
				}
					
				echo '<td class="hour" style="width: 10px; border-left: 10px solid #ffffff;">'. ($hour) .'<sup>00</sup></td>';				
			echo '</tr>';
		}		
?>
	</table>
</div>

</div>
