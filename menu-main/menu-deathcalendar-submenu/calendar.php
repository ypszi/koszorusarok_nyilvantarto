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
		width: 125px;
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
		border-left: 15px solid #ffd800;
	}
	.next_week .first{
		padding: 0px 5px 0px 5px;
		border-left: 15px solid #fb664b;
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
	<span class="firstWord">Temetési</span> Naptár
</div>

<div class="title">
	<?php 
		if (isset($_GET['year'])){
			$y = $_GET['year'];
		}else{
			$y = date("Y");
		}

		if (isset($_GET['week'])){
			$w += $_GET['week'];
		}else{
			$w = date("W")+1-1;
		}
				
		if ($w==0){
			$y--;
			$w=52;
		}elseif ($w==53){
			$w=01;
			$y++;
		}
		
		$time = strtotime("1 January ".$y, time());
		$time += ((7*($w-1))+1-date('w', $time))*24*3600;

		$first_day_in_week = date('Y-m-d', $time);
		$last_day_in_week = date('Y-m-d',($time + 13*24*3600));
				
		echo $y . '. év - ' . $w .'. hét - <span class="firstWord">'.$first_day_in_week.' - '. $last_day_in_week .'</span>';	
		echo '
			<span class="next_week" style="float:right;">
				<a href="?page=temetes&week='.($w-1).'&year='.($y).'">elöző</a> | 
				<a href="?page=temetes">aktualis hét</a> | 
				<a href="?page=temetes&week='.($w+1).'&year='.($y).'">következő</a>
			</span>';
	?>
</div>

<div>

	<table id='calendar'>
		<tr>
<?php
		echo '<th></th>';
		echo '<th><a href="?page=temetes&subpage=naptarinap&day=' .date('Ymd',($time + 0*24*3600)). '">' .date('m.d',($time + 0*24*3600)). '<br/>Hétfő</a></th>';
		echo '<th><a href="?page=temetes&subpage=naptarinap&day=' .date('Ymd',($time + 1*24*3600)). '">' .date('m.d',($time + 1*24*3600)). '<br/>Kedd</a></th>';
		echo '<th><a href="?page=temetes&subpage=naptarinap&day=' .date('Ymd',($time + 2*24*3600)). '">' .date('m.d',($time + 2*24*3600)). '<br/>Szerda</a></th>';
		echo '<th><a href="?page=temetes&subpage=naptarinap&day=' .date('Ymd',($time + 3*24*3600)). '">' .date('m.d',($time + 3*24*3600)). '<br/>Csütörtök</a></th>';
		echo '<th><a href="?page=temetes&subpage=naptarinap&day=' .date('Ymd',($time + 4*24*3600)). '">' .date('m.d',($time + 4*24*3600)). '<br/>Péntek</a></th>';
		echo '<th><a href="?page=temetes&subpage=naptarinap&day=' .date('Ymd',($time + 5*24*3600)). '">' .date('m.d',($time + 5*24*3600)). '<br/>Szombat</a></th>';
		echo '<th><a href="?page=temetes&subpage=naptarinap&day=' .date('Ymd',($time + 6*24*3600)). '">' .date('m.d',($time + 6*24*3600)). '<br/>Vasárnap</a></th>';
		
		echo '<th class="separate"><a href="?page=temetes&subpage=naptarinap&day=' .date('Ymd',($time + 7*24*3600)). '">' .date('m.d',($time + 7*24*3600)). '<br/>Hétfő</a></th>';
		echo '<th><a href="?page=temetes&subpage=naptarinap&day=' .date('Ymd',($time + 8*24*3600)). '">' .date('m.d',($time + 8*24*3600)). '<br/>Kedd</a></th>';
		echo '<th><a href="?page=temetes&subpage=naptarinap&day=' .date('Ymd',($time + 9*24*3600)). '">' .date('m.d',($time + 9*24*3600)). '<br/>Szerda</a></th>';
		echo '<th><a href="?page=temetes&subpage=naptarinap&day=' .date('Ymd',($time + 10*24*3600)). '">' .date('m.d',($time + 10*24*3600)). '<br/>Csütörtök</a></th>';
		echo '<th><a href="?page=temetes&subpage=naptarinap&day=' .date('Ymd',($time + 11*24*3600)). '">' .date('m.d',($time + 11*24*3600)). '<br/>Péntek</a></th>';
		echo '<th><a href="?page=temetes&subpage=naptarinap&day=' .date('Ymd',($time + 12*24*3600)). '">' .date('m.d',($time + 12*24*3600)). '<br/>Szombat</a></th>';
		echo '<th><a href="?page=temetes&subpage=naptarinap&day=' .date('Ymd',($time + 13*24*3600)). '">' .date('m.d',($time + 13*24*3600)). '<br/>Vasárnap</a></th>';
?>
		</tr>
<?php
//		WHERE (WEEK(funeral_date) = ".($w-1)." OR WEEK(funeral_date) = ".($w).") AND archive = 0
//					WHERE (WEEK(funeral_date) = ".date('W',($time - 1*24*3600))." OR WEEK(funeral_date) = ".(date('W', $time)).") AND archive = 0
		
		$query = "SELECT name, funeral_date,note 
					FROM  death_calendar
					WHERE (funeral_date BETWEEN '".date('Y-m-d',$time)." 00:00:00' AND '".(date('Y-m-d', ($time+ + 13*24*3600)))." 23:59:59') AND archive = 0
					ORDER BY funeral_date ASC;";
//		echo $query;
		
		$result = mysql_query($query) or die (mysql_error());

		while ($row = mysql_fetch_assoc($result)) {	

//			echo date("W",strtotime($row["funeral_date"]))+1-1;
		
			$death[date("W",strtotime($row["funeral_date"]))+1-1][date("N",strtotime($row["funeral_date"]))][date("H",strtotime($row["funeral_date"]))] .=
				'<div style="padding:1px; width: 65px;">
					<div style="margin-left:15px; font: 3px arial,sans-serif;">
						<p style="color: #000; font-size: 10px; width:65px; font-weight: bold;">'.date("H:i",strtotime($row["funeral_date"])).'<br/>&#8224; '.$row["name"].'</p>
						<p style="color: #666; font-size: 9px; width:65px; font-style:italic;">'.$row["note"].'</p>
					</div>
				</div>';
				
//			echo '<br />'. date("N",strtotime($row["funeral_date"])) . '-' . date("H",strtotime($row["funeral_date"]));
//			echo $death[date("N",strtotime($row["funeral_date"]))][date("H",strtotime($row["funeral_date"]))] . '<br />';
				
		}

		$hours = array(7 => '07', 
				8 => '08', 
				9 => '09', 
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


			
		for ($hour = 7; $hour <= 20; $hour++) {
			echo '<tr>';

			echo '<td class="hour">'. ($hour) .'<sup>00</sup></td>';				
			
			//1 hét
			for ($day = 1; $day <= 7; $day++){
				if ($day != date("N") || $w != date("W")){
					echo '<td>';
					if (isset($death[($w)][$day][$hours[$hour]])){
						echo $death[($w)][$day][$hours[$hour]];
					}
					//ide kerül a megfelelő megrendelés	

					echo '</td>';				
				}else{
					echo '<td class="selected_day">';

					if (isset($death[($w)][$day][$hours[$hour]])){
						echo $death[($w)][$day][$hours[$hour]];
					}
					//ide kerül a megfelelő megrendelés	
						
					echo '</td>';
				}
			}

			//2 hét
			for ($day = 1; $day <= 7; $day++){

				if ($day != date("N") || $w != date("W")){
				if ($day != 1){
					echo '<td>';
				}else{
					echo '<td class="separate">';
				}
					if (isset($death[($w+1)][$day][$hours[$hour]])){
						echo $death[($w+1)][$day][$hours[$hour]];
					}
					//ide kerül a megfelelő megrendelés	
					echo '</td>';				
				}else{
				if ($day != 1){
					echo '<td>';
				}else{
					echo '<td class="separate">';
				}

					if (isset($death[($w+1)][$day][$hours[$hour]])){
						echo $death[($w+1)][$day][$hours[$hour]];
					}
					//ide kerül a megfelelő megrendelés	
						
					echo '</td>';
				}
			}

			echo '</tr>';
		}

	
?>
	</table>
</div>

</div>
