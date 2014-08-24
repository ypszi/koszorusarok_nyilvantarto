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
		width: 125px;
		text-align: left;
		text-transform: none;
	}

	#calendar td a{
		font: normal 10px/12px "Arial";
		color: #5f7f71;
		text-decoration:none;	
	}
	
	#calendar td .entry{
		font: normal 10px/12px "Arial";
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
		width: 20px !important;
		vertical-align: middle;
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

<div  id="content" style="padding: 10px; margin-top:0px; background-color: #fff; height: 1200px;">

<div class="title">
	<span class="firstWord">Szállítási</span> Naptár
	<span class="next_week" style="float:right;">
		<span class='first'>Koszorú Sarok</span> | 
		<span class='second'>Protea Virágbolt</span> |
		<span class='third'>Harmadik VirágBolt</span>
		<span class='other'>Internet</span>
		<span class='office'>Irodák</span>
	</span>
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
				
		echo $y . '. év - ' . $week .'. hét - <span class="firstWord">'.$first_day_in_week.' - '. $last_day_in_week .'</span>';	
		echo '<span class="next_week" style="float:right;">
			<a href="?page=szallitas&week='.($week-1).'&year='.($y).'">elöző</a> | 
			<a href="?page=szallitas">aktualis hét</a> | 
			<a href="?page=szallitas&week='.($week+1).'&year='.($y).'">következő</a>
		</span>';
	?>
</div>

<div>

	<table id='calendar'>
		<tr>
<?php
		echo '<th></th>';
		echo '<th><a href="?page=szallitas">' .date('m.d',($time + 0*24*3600)). '<br/>Hétfő</a></th>';
		echo '<th><a href="?page=szallitas">' .date('m.d',($time + 1*24*3600)). '<br/>Kedd</a></th>';
		echo '<th><a href="?page=szallitas">' .date('m.d',($time + 2*24*3600)). '<br/>Szerda</a></th>';
		echo '<th><a href="?page=szallitas">' .date('m.d',($time + 3*24*3600)). '<br/>Csütörtök</a></th>';
		echo '<th><a href="?page=szallitas">' .date('m.d',($time + 4*24*3600)). '<br/>Péntek</a></th>';
		echo '<th><a href="?page=szallitas">' .date('m.d',($time + 5*24*3600)). '<br/>Szombat</a></th>';
		echo '<th><a href="?page=szallitas">' .date('m.d',($time + 6*24*3600)). '<br/>Vasárnap</a></th>';
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

			
	
			$query = "SELECT id,shop, shipment, paid, downprice,ritual_time, clocation,caddress,cfuneral,deadname
			   FROM orders 
			   WHERE WEEK(ritual_time)=". ($week-1) ." AND shipment='Egyedi helyszín' AND archive=0
			   ORDER BY ritual_time ASC;";
			
			$result = mysql_query($query) or die (mysql_error());

			while ($row = mysql_fetch_assoc($result)) {	
				$color = "#5f7f71";
				
				if ($row["shop"] == "1"){
					$color = "#fb664b";
				}elseif ($row["shop"] == "2"){
					$color = "#5c96ff";
				}elseif ($row["shop"] == "3"){
					$color = "#6A1A4A";
				}
				
				if (isset($row["paid"])){ //ki van fizetve!!! Tele kocka

						$order[date("N",strtotime($row["ritual_time"]))][date("H",strtotime($row["ritual_time"]))] .=
							'<a style="padding: 1px 0px 1px 0px;" href="?page=rendeles&subpage=megrendeles&id='.$row["id"].'">
								<div style="padding:1px;">
									<div style="height:45px; width:5px; border:3px solid '.$color.'; background-color: '.$color.';" >
										<div style="margin-left:15px; font: 3px arial,sans-serif;">
											<p style="font-size:10px; color: #000; font-size: 9px; width:140px; text-weight: bold;">'.$row["deadname"].'</p>
											<p style="font-size: 10px; width:125px;">#'.$row["clocation"].', '.$row["caddress"].', '.$row["cfuneral"].'</p>
										</div>
									</div>
								</div>
							</a>';
					
				}else{

					if (isset($row["downprice"]) && $row["downprice"]!=0){					
						$order[date("N",strtotime($row["ritual_time"]))][date("H",strtotime($row["ritual_time"]))] .=
						'<a style="padding: 1px 0px 1px 0px;" href="?page=rendeles&subpage=megrendeles&id='.$row["id"].'">
							<div style="padding-top:1px; margin-top:1px; height:17px; width:5px; border:3px solid '.$color.';" >													
								<div style="margin-left:15px; font: 3px arial,sans-serif;">
											<p style="font-size:10px; color: #000; font-size: 9px; width:140px; text-weight: bold;">&#8224; '.$row["deadname"].'</p>
											<p style="font-size: 10px; width:125px;">#'.$row["clocation"].', '.$row["caddress"].', '.$row["cfuneral"].'</p>
								</div>
							</div>
							<div style="padding-bottom:1px; margin-bottom:1px; height:11px; width:5px; border:3px solid '.$color.'; background-color: '.$color.';" ></div>
						</a>';
					}else{ //Nem adott semmit
							$order[date("N",strtotime($row["ritual_time"]))][date("H",strtotime($row["ritual_time"]))] .=
							'<a style="padding: 1px 0px 1px 0px;" href="?page=rendeles&subpage=megrendeles&id='.$row["id"].'">
								<div style="padding:1px;">
									<div style="height:45px; width:5px; border:3px solid '.$color.';" >
									<div style="margin-left:15px;">
											<p style="font-size:10px; color: #000; font-size: 9px; width:140px; text-weight: bold;">&#8224; '.$row["deadname"].'</p>
											<p style="font-size: 10px; width:140px;">#'.$row["clocation"].', '.$row["caddress"].', '.$row["cfuneral"].'</p>
										</div>
									</div>
								</div>
							</a>';						
					}
				}
			}
	

		for ($hour = 7; $hour <= 20; $hour++) {
			echo '<tr>';

			echo '<td class="hour">'. ($hour) .'<sup>00</sup></td>';				

			for ($day = 1; $day <= 7; $day++){
				if ($day != date("N") || $week != date("W")){
					echo '<td>';
					if (isset($order[$day][$hour])){
						echo $order[$day][$hour];
					}
					//ide kerül a megfelelő megrendelés	

					echo '</td>';				
				}else{
					echo '<td class="selected_day">';

					if (isset($order[$day][$hour])){
						echo $order[$day][$hour];
					}
					//ide kerül a megfelelő megrendelés	
						
					echo '</td>';
				}
			}
					
			echo '</tr>';
		}
		//}		
?>
	</table>
</div>

</div>
