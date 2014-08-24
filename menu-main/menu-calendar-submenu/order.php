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
		border-left: 15px solid #ffd800;
	}
	.next_week .other{
		padding: 0px 5px 0px 5px;
		border-left: 15px solid #5f7f71;
	}
	.next_week .first{
		padding: 0px 5px 0px 5px;
		border-left: 15px solid #ff0036;
	}
	.next_week .second{
		padding: 0px 5px 0px 5px;
		border-left: 15px solid #0012ff;
	}
	
	.selected_day{
		background-color:#e0ebdd;
	}
	
	.separate{
		width: 1px;
		border-left: 1px solid #5f7f71;
	}
	
</style>

<div  id="content" style="padding: 10px; background-color: #fff;">

<div class="title">
	<span class="firstWord">Egy bejegyzés</span> Naptár
	<span class="next_week" style="float:right;">
		<span class='deliver'>Szállítás<span> | 
		<span class='other'>Kulso megrendelo</span> | 
		<span class='first'>Koszorú Sarok</span> | 
		<span class='second'>Protea Virágbolt</span>
	</span>
</div>

<div class="title">
	<?php 
		
		if (isset($_GET['week'])){
			$week += $_GET['week'];
		}else{
			$week = 0;
		}
		
		$time = strtotime("1 January ".date("Y"), time());
		$time += ((7*(date("W")-1+$week))+1-date('w', $time))*24*3600;

		$first_day_in_week = date('Y-m-d', $time);
		$last_day_in_week = date('Y-m-d',($time + 6*24*3600));

		echo (date("W")+$week) .'. hét - <span class="firstWord">'.$first_day_in_week.' - '. $last_day_in_week .'</span>';	
	?>
	<span class="next_week" style="float:right;"><a href="?page=naptar&subpage=osszesitett&week=-1">elöző</a> | <a href="?page=naptar&subpage=osszesitett&week=0">aktualis hét</a> | <a href="?page=naptar&subpage=osszesitett&week=1">következő</a></span>
</div>

<div>
	<table id='calendar'>
		<tr>
<?php
		echo '<th></th>';
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

?>
		</tr>
<?php
		for ($hour = 7; $hour <= 20; $hour++) {
			for ($minute = 0; $minute < 2; $minute++){
				if (date("G") != ($hour)){
					echo '<tr>';
				}else{
					echo '<tr class="now">';
				}
					echo '<td class="hour">'. ($hour) .'<sup>'.($minute*3).'0</sup></td>';				
					for ($day = 1; $day <= 7; $day++){
						if ($day != date("N") || $week != 0){
							echo '<td>';
								if (rand(0, 10) % 4 == 0){
									echo '	<a href="#">
											<div>
												<div style="height:20px; width:10px; border:3px solid #5f7f71;" >
												<div style="margin-left:15px; font: 3px arial,sans-serif;">
													<span>#000321</span><br/>
													<span class="entry">'.substr("Állo koszorú", 0, 6).'</span>
												</div>
												</div>
											</div>
											</a>';
								}						
							echo '</td>';				
						}else{
							echo '<td class="selected_day">';
									if (rand(0, 10) % 4 == 0){
										echo '<div style="height:12px; width:10px; border:3px solid #5f7f71;" >													
												<div style="margin-left:15px; font: 3px arial,sans-serif;">
													<span><a href="#">#000321</a></span><br/>
													<span>'.substr("Állo koszorú", 0, 5).'</span>
												</div>

												</div>
											<div style="height:8px; width:10px; border:3px solid #5f7f71; background-color: #5f7f71;" ></div>';
									}
							echo '</td>';
						}
					}
					
					for ($day = 1; $day <= 7; $day++){
						if ($day != date("N") || $week != 0){
							if ($day != 1){
								echo '<td>';
							}else{
								echo '<td class="separate">';
							}

							if (rand(0, 10) % 4 == 0){
										echo '	<div>
												<div style="height:20px; width:10px; border:3px solid #5f7f71;" >
												<div style="margin-left:15px; font: 3px arial,sans-serif;">
													<span><a href="#">#000321</a></span><br/>
													<span>'.substr("Állo koszorú", 0, 5).'</span>
												</div>
												</div>
											</div>';		
								}						
							echo '</td>';				
						}else{
								echo '<td class="selected_day">';
									if (rand(0, 10) % 4 == 0){
										echo '<div style="height:20px; width:10px; border:3px solid #5f7f71; background-color: #5f7f71;" >
												<div style="margin-left:15px; font: 3px arial,sans-serif;">
													<span><a href="#">#000321</a></span><br/>
													<span>'.substr("Állo koszorú", 0, 5).'</span>
												</div>
											</div>';
									}							
								echo '</td>';
						}
					}
				echo '</tr>';
			}
		}		
?>
	</table>
</div>

</div>
