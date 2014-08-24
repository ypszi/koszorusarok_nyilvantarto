<?php
function create_time($t){
	if ($t % 2 == 0){
		return '<span>' . (6+$t/2) . '<sup><u>00</u></sup></span>';
	}else{
		return '<span>' . (5.5+$t/2) . '<sup><u>30</u></sup></span>';
	}
}
?>

<?php
	if (isset($_GET['week'])){
		$week += $_GET['week'];
	}else{
		$week = 0;
	}
?>

<div class="title">
	<span class="firstWord">Fizetési </span> Adatok
	<span style="float:right;">
		<a href="/menu-main/menu-statistic-submenu/get-salary-pdf.php?week=<?php echo $week; ?>" target="blank">nyomtatás</a>
	</span>
		<div>	

<div class="title">
	<?php 
		
		$time = strtotime("1 January ".date("Y"), time());
		$time += ((7*(date("W")-1+$week))+1-date('w', $time))*24*3600;

		$first_day_in_week = date('Y-m-d', $time - 2*24*3600);
		$last_day_in_week = date('Y-m-d',($time + 4*24*3600));
		
		$selectedweek = date("W")+$week;

		echo $selectedweek .'. hét - <span class="firstWord">'.$first_day_in_week.' Szombat 6<sup>00</sup> - '. $last_day_in_week .' Péntek 20<sup>00</sup></span>';	
		echo '<span class="next_week" style="float:right;">
		<a href="?page=statisztika&subpage=fizetes&week='. ($week-1) .'">elöző</a> | 
				<a href="?page=statisztika&subpage=fizetes&week=0">aktualis hét</a> | 
				<a href="?page=statisztika&subpage=fizetes&week='. ($week+1) .'">következő</a>
			</span>';
	?>
</div>		
		
<?php 
//	$query="SELECT user,(SUM(end-begin)/2) AS munkaora FROM workweek2 WHERE (week=". ($selectedweek-1)." AND (day between 5 AND 6)) OR (week=". $selectedweek ." AND (day between 0 AND 4)) GROUP BY user";

	for ($shop = 1; $shop<4; $shop++){
		if ($selectedweek != 1 && $selectedweek != 53){
			$query="SELECT user,(SUM(end-begin)/2) AS munkaora 
					FROM workweek".$shop." 
					WHERE ((week=". ($selectedweek-1)." AND (day between 5 AND 6)) OR (week=". $selectedweek ." AND (day between 0 AND 4))) AND year= ". date('Y') ."
					GROUP BY user";
		}else if($selectedweek == 53){
			$query="SELECT user,(SUM(end-begin)/2) AS munkaora 
					FROM workweek".$shop." 
					WHERE ((year= ". date('Y') ." AND week=53 AND (day between 5 AND 6)) OR (year= ". (date('Y')+1) ." AND week=1 AND (day between 0 AND 4)))
					GROUP BY user";
		}else if($selectedweek == 1){
			$query="SELECT user,(SUM(end-begin)/2) AS munkaora 
					FROM workweek".$shop." 
					WHERE ((year= ". (date('Y')-1) ." AND week=52 AND (day between 5 AND 6)) OR 
						(year= ". (date('Y')-1) ." AND week=53 AND (day between 0 AND 4)) OR
						(year= ". date('Y') ." AND week=1 AND (day between 0 AND 4)))
					GROUP BY user";
		}	
		
		$result = mysql_query($query) or die (mysql_error());
		while ($row = mysql_fetch_assoc($result)) {
			$salary[$row["user"]] += $row['munkaora'];
		}
	}

	$days = array(0 => 5, 1 => 6, 2 => 0, 3 => 1, 4 => 2, 5 => 3, 6 => 4, 7 =>5);
	
	$users="SELECT id,name,color,salary FROM users WHERE id!=1 AND id!=2 AND id !=3 AND enable=1 ORDER BY name ASC;";
	$result = mysql_query($users) or die (mysql_error());
	echo '<table id="salary" style="width:730px;">
			<tr>
				<th></th>
				<th>Név</th>
				<th>Szombat</th>
				<th>Vasárnap</th>
				<th>Hétfő</th>
				<th>Kedd</th>
				<th>Szerda</th>
				<th>Csütörtök</th>
				<th>Péntek</th>
			</tr>';

		while ($row = mysql_fetch_assoc($result)) {
		
				for ($shop = 1; $shop<4; $shop++){
/*					$query_workdays = "SELECT week,day,user,begin,end 
					   FROM workweek".$shop." 
					   WHERE user=".$row["id"]." AND ((week=".($selectedweek-1)." AND (day between 5 AND 6)) OR (week=".($selectedweek)." AND (day between 0 AND 4))) 
					   ORDER BY week,day ASC;";
*/					
					
					if ($selectedweek != 1 && $selectedweek != 53){
						$query_workdays = "SELECT week,day,user,begin,end 
									   FROM workweek".$shop." 
									   WHERE user=".$row["id"]." AND ((week=".($selectedweek-1)." AND (day between 5 AND 6)) OR (week=".($selectedweek)." AND (day between 0 AND 4))) AND year= ". date('Y') ." 
									   ORDER BY week,day ASC;";
					}else if($selectedweek == 53){
						$query_workdays="SELECT week,day,user,begin,end 
									FROM workweek".$shop." 
									WHERE user=".$row["id"]." AND
										((year= ". (date('Y')) ." AND (week=52 AND (day between 5 AND 6))) OR
										 (year= ". (date('Y')) ." AND (week=53 AND (day between 0 AND 4))) OR
										 (year= ". (date('Y')+1) ." AND week=1 AND (day between 0 AND 4)))
									ORDER BY year,week,day ASC;";
					}else if($selectedweek == 1){
						$query_workdays="SELECT week,day,user,begin,end 
									FROM workweek".$shop." 
									WHERE user=".$row["id"]." AND
										((year= ". (date('Y')-1) ." AND (week=52 AND (day between 5 AND 6))) OR
										 (year= ". (date('Y')-1) ." AND (week=53 AND (day between 0 AND 4))) OR
										 (year= ". date('Y') ." AND week=1 AND (day between 0 AND 4)))
									ORDER BY year,week,day ASC;";
					}
					
//					echo $query_workdays . "<br />";
					
					$result_workdays = mysql_query($query_workdays) or die (mysql_error());
	
					$i = 0;
					$start = 1;
					while ($row_wd = mysql_fetch_assoc($result_workdays)) {
						$j = 0;
						while ($days[$i] != ($row_wd["day"])){
							$i++;
							$j++;
						}
						for ($k=1; $k<$j; $k++){
							if ($start == 1){
								$start = 0;
							}
						}
						$start = 0;
														
						if ($days[$i] == $row_wd["day"]){
							
							$workers[$row["id"]][$row_wd["day"]] = '<div style="font:bold 12px/20px Arial;">' .	create_time($row_wd["begin"]).  ' - ' . create_time($row_wd["end"]) . '<br />' .
								(($row_wd["end"] - $row_wd["begin"])/2) . ' óra</div>';
						}						
					}				
				}
				
			echo '<tr style="border-top: 2px solid #5f7f71;">
				<td><div style="float:right; margin:2px 5px 0px 0px; height:10px; width:10px; background-color: #' . $row["color"] . ';">&nbsp;</div></td>
				<td>' . $row["name"] . '</td>';
				
				for ($i=0; $i<7; $i++){
							echo '<td>'; 
							if (isset($workers[$row["id"]][$days[$i]])){
								echo $workers[$row["id"]][$days[$i]];
							}
							echo '</td>';
				}
				
			echo '</tr>
					<tr style="height:50px;">
						<td colspan="9" style="text-align: right;">
							<p>Heti munkaóra, fizetés: ';
				if (isset($salary[$row["id"]])){
					echo  $salary[$row["id"]] . ' óra - <i>' . number_format($row["salary"], 0, ',', ' ') .' ft/óra </i> - <span style="font-weight:bold; color: #fb664b">' . number_format($salary[$row["id"]]*$row["salary"], 0, ',', ' ') .' ft</span>';
				}else{
					echo '0 óra, 0 ft';
				}
				
					echo '</p>
						</td>
					</tr>';
	}
		echo '</table>';	
?>
		</div>
</div>