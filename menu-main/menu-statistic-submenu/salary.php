<head>
    <!-- ---------------------------- Datepicker ---------------------------- -->
    <link rel="stylesheet" href="css/calendar/default.css" type="text/css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <script type="text/javascript" src="js/timepicker/include/jquery-1.9.0.min.js"></script>
    <script type="text/javascript" src="js/zebra_datepicker.js"></script>
    <script type="text/javascript" src="js/zebra_datepicker.src.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('input.datepicker').Zebra_DatePicker();
        });
    </script>

</head>
<style type="text/css">

	#calendar table{
		width: 730px;
		margin-bottom: 20px;
	}

	#calendar tr{
		border-bottom: 1px solid #5f7f71;
	}

	#calendar th{
		margin: 0;
		padding: 2px 0px 10px 0px;
		font: normal 14px/16px "Arial";
		color: #5f7f71;
		text-align: center;
		text-transform: none;
	}

	#calendar td{
		margin: 0;
		padding: 3px 2px 0px 2px;
		font: normal 14px/20px "Arial";
		color: #d93c76;
		text-align: center;
		text-transform: none;
		border: 1px dotted #5f7f71;
	}

	#calendar td.now{
		margin: 0;
		padding: 2px 0px 0px 0px;
		font: normal 14px/20px "Arial";
		color: #d93c76;
		text-align: center;
		text-transform: none;
		border: 1px solid #5f7f71;
		background-color: #e0ebdd;
	}
	
	.today{
		color: #5f7f71; 
		font: normal 10px/14px "Arial";
	}
	
	a{
		color: #d93c76;
	}
	
</style>
<?php

function create_time($t) {
    if ($t % 2 == 0) {
        return '<span>' . (6 + $t / 2) . '<sup><u>00</u></sup></span>';
    } else {
        return '<span>' . (5.5 + $t / 2) . '<sup><u>30</u></sup></span>';
    }
}
?>

<div class="title">
    <span class="firstWord">Egyéni Fizetési </span> Adatok
    <div>	

        <div class="title">
            <?php
			
            $time = strtotime("1 January " . date("Y"), time());
            $time += ((7 * (date("W") - 1)) + 1 - date('w', $time)) * 24 * 3600;


            if (!(isset($_GET['min_date']) && isset($_GET['max_date']))) {
                $first_day_in_week = date('Y-m-d', $time - 2 * 24 * 3600);
                $last_day_in_week = date('Y-m-d', ($time + 4 * 24 * 3600));
            } else {
                $first_day_in_week = $_GET['min_date'];
                $last_day_in_week = $_GET['max_date'];
            }

            ?>
        </div>		


        <div>
            <form id = "selectForm" style="width:730px;" method="GET">
                <table id = "selectFormTable" style="width:730px;">
                    <tr>
                        <td >
                            <select id='width:300px; height:32px; border-radius: 5px;	border: solid thin #CBDBB7;' name='userid' >
                                <?php
                                $query = "SELECT id,name
								FROM users
								WHERE enable=1 AND NOT (id=1 OR id=2 OR id=3) 
								ORDER BY name ASC;";
                                $result = mysql_query($query) or die(mysql_error());

								echo '<option value="0">Minden Alkalmazott</option>';
                                while ($row = mysql_fetch_assoc($result)) {
                                    echo '<option value="' . $row["id"] . '">' . $row["name"] . '</option>';
                                }
                                ?>
                            </select>
                        </td>
<?php                   echo '
							<td>
								<input type="text" name="min_date" id="min_date" class="datepicker borderedStyle" value="' . $first_day_in_week . '"/>
							</td>
							<td> - </td>
							<td>
								<input type="text" name="max_date" id="max_date" class="datepicker borderedStyle" value="' . $last_day_in_week . '"/>
								<input type="hidden" name="page" value="statisztika" />
								<input type="hidden" name="subpage" value="fizetesek" />
							</td>
							<td>
								<button type="submit" class = "button" id = "filter">Szűrés</button>
							</td>'; 
?>
                    </tr>
                </table>
            </form>
        </div>
		<div id="calendar">

        <?php
		$show_month = array("01" => "Január",
						"02"  => "Február",
						"03"  => "Március",
						"04"  => "Április",
						"05"  => "Május",
						"06"  => "Június",
						"07"  => "Július",
						"08"  => "Agusztus",
						"09"  => "Szeptember",
						"10"  => "Október",
						"11"  => "November",
						"12"  => "December");
								
		if (isset($_GET["userid"]) && $_GET["userid"]!=0){ //minden alkalmazott
			$mindate = date("W", strtotime($_GET['min_date']));
			$maxdate = date("W", strtotime($_GET['max_date']));
			$year = date("Y", strtotime($_GET['max_date']));

			$users = "SELECT id,name,color,salary 
						FROM users 
						WHERE id!=1 AND id!=2 AND id !=3 AND enable=1 AND id=".$_GET["userid"]." 
						ORDER BY name ASC;";

			$result = mysql_query($users) or die(mysql_error());
			$sum=0;
			while ($row = mysql_fetch_assoc($result)) {

				for ($shop = 1; $shop < 4; $shop++) {
					$query_workdays = "SELECT week,day,user,begin,end 
						   FROM workweek" . $shop . " 
						   WHERE user=" . $_GET["userid"] . " AND (week BETWEEN ".$mindate." AND ".$maxdate.") AND year = ". $year."
						   ORDER BY week ASC;";

					$result_workdays = mysql_query($query_workdays) or die(mysql_error());

					while ($row_wd = mysql_fetch_assoc($result_workdays)) {
						$workhour[$row_wd["week"]][$row_wd["day"]] = create_time($row_wd["begin"]) . ' - ' . create_time($row_wd["end"]);
						$wh[$row_wd["week"]][$row_wd["day"]] = (($row_wd["end"] - $row_wd["begin"]) / 2) * $row["salary"];
//						echo $row_wd["week"] . " - " . ($row_wd["day"]+1) . " - " .$row_wd["begin"] . " - " . $row_wd["end"] . "<br/>";
					}				
				}

				echo '<table>';
					echo' <tr>
							<th style="font-weight: bolder;">'. $row["name"].'</th>
							<th>Hétfő</th>
							<th>Kedd</th>
							<th>Szerda</th>
							<th>Csütörtök</th>
							<th>Péntek</th>
							<th>Szombat</th>
							<th>Vasárnap</th>
							<th>Fizetés</th>
						</tr>';
				for ($week= $mindate+0; $week<=$maxdate; $week++){
				
					echo'<tr>';
						$time = strtotime("1 January ".date("Y"), time());	
						$time += ((7*($week-1))+1-date('w', $time))*24*3600;

						echo '<td>'. $show_month[date('m', $time)] . '<br />' . $week . '. hét</td>'; 

						$weeksummery = 0;
						for ($day=0; $day<7; $day++){
							$today = date('d', $time + $day*24*3600);
							
//							echo $day . "<br/>";
//							echo 	date("N", strtotime($_GET['min_date'])) . "<br/>";
							
							if ($week != $mindate && $week != $maxdate){
								echo '<td><span class="today">'. $today .'</span><br />'. $workhour[$week][$day] .'</td>';
								$weeksummery += $wh[$week][$day];
							}else{
								if ($week == $mindate){
									if (($day+1) >=  date("N", strtotime($_GET['min_date']))){
										echo '<td><span class="today">'. $today .'</span><br />'. $workhour[$week][$day] .'</td>';
										$weeksummery += $wh[$week][$day];
									}else{
										echo '<td><span class="today">'. $today .'</span><br /></td>';								
									}
								}
								if ($week == $maxdate){
									if (($day+1) <=  date("N", strtotime($_GET['max_date']))){
										echo '<td><span class="today">'. $today .'</span><br />'. $workhour[$week][$day] .'</td>';
										$weeksummery += $wh[$week][$day];
									}else{
										echo '<td><span class="today">'. $today .'</span><br /></td>';								
									}
								}
							}
						}
						echo '<td>'. number_format($weeksummery, 0, ',', ' ') . ' ft </td>';
						$sum += $weeksummery;
					echo'</tr>';
				}
				echo '</table>';
					
				echo '<div><span style="color:#d93c76;">' . $row["name"] . '</span> ' . $_GET['min_date'] .' kezdődően, ' . $_GET['max_date'] . '-ig összesen keresett: <span style="font-weight:bolder; color:#d93c76;">' .  number_format($sum, 0, ',', ' ') . ' ft</span></div>';
			}
		}else{
			if (isset($_GET['min_date']) && isset($_GET['max_date'])){
				$mindate = date("W", strtotime($_GET['min_date']));
				$maxdate = date("W", strtotime($_GET['max_date']));
				$year = date("Y", strtotime($_GET['max_date']));
			}else{
				$mindate = date("W", strtotime($first_day_in_week));
				$maxdate = date("W", strtotime($last_day_in_week));
				$year = date("Y", strtotime($last_day_in_week));
			}
			
			$users = "SELECT id,name,color,salary 
						FROM users 
						WHERE id!=1 AND id!=2 AND id !=3 AND enable=1 
						ORDER BY name ASC;";

			$result = mysql_query($users) or die(mysql_error());
			$sum=0;
			while ($row = mysql_fetch_assoc($result)) {

				for ($shop = 1; $shop < 4; $shop++) {
					$query_workdays = "SELECT week,day,user,begin,end 
						   FROM workweek" . $shop . " 
						   WHERE user='". $row['id'] . "' AND (week BETWEEN ".$mindate." AND ".$maxdate.") AND year = ".$year."
						   ORDER BY week ASC;";

					$result_workdays = mysql_query($query_workdays) or die(mysql_error());

					while ($row_wd = mysql_fetch_assoc($result_workdays)) {
						$wh[$row_wd["week"]][$row_wd["day"]] += (($row_wd["end"] - $row_wd["begin"]) / 2) * $row["salary"];
						
//						echo $row["name"] . ' - ' . $wh[$row_wd["week"]][$row_wd["day"]] . '<br/>';
					}				
				}
			}

			echo '<table>';
				echo' <tr>
						<th style="font-weight: bolder;">Minden alkalmazott</th>
						<th>Hétfő</th>
						<th>Kedd</th>
						<th>Szerda</th>
						<th>Csütörtök</th>
						<th>Péntek</th>
						<th>Szombat</th>
						<th>Vasárnap</th>
						<th>Fizetés</th>
					</tr>';
			for ($week= $mindate+0; $week<=$maxdate; $week++){
				echo'<tr>';
					$time = strtotime("1 January ".date("Y"), time());	
					$time += ((7*($week-1))+1-date('w', $time))*24*3600;

					echo '<td>'. $show_month[date('m', $time)] . '<br />' . $week . '. hét</td>'; 

					$weeksummery = 0;
					for ($day=0; $day<7; $day++){
						$today = date('d', $time + $day*24*3600);
						
//							echo $day . "<br/>";
//							echo 	date("N", strtotime($_GET['min_date'])) . "<br/>";
						
						if ($week != $mindate && $week != $maxdate){
							echo '<td><span class="today">'. $today .'</span><br />'. number_format($wh[$week][$day], 0, ',', ' ') . ' ft</td>';
							$weeksummery += $wh[$week][$day];
						}else{
							if ($week == $mindate){
								if (($day+1) >=  date("N", strtotime($first_day_in_week))){
									echo '<td><span class="today">'. $today .'</span><br />'. number_format($wh[$week][$day], 0, ',', ' ') . ' ft</td>';
									$weeksummery += $wh[$week][$day];
								}else{
									echo '<td><span class="today">'. $today .'</span><br /></td>';								
								}
							}
							if ($week == $maxdate){
								if (($day+1) <=  date("N", strtotime($last_day_in_week))){
									echo '<td><span class="today">'. $today .'</span><br />'. number_format($wh[$week][$day], 0, ',', ' ') . ' ft</td>';
									$weeksummery += $wh[$week][$day];
								}else{
									echo '<td><span class="today">'. $today .'</span><br /></td>';								
								}
							}
						}
					}
					echo '<td>'. number_format($weeksummery, 0, ',', ' ') . ' ft </td>';
					$sum += $weeksummery;
				echo'</tr>';
			}
			echo '</table>';
			if (isset($_GET['min_date']) && isset($_GET['max_date'])){
				echo '<div><span style="color:#d93c76;">Az alkalmazottak </span> ' . $_GET['min_date'] .' kezdődően, ' . $_GET['max_date'] . '-ig összesen <span style="font-weight:bolder; color:#d93c76;">' .  number_format($sum, 0, ',', ' ') . ' ft</span> kerestek.</div>';
			}else{
				echo '<div><span style="color:#d93c76;">Az alkalmazottak </span> ' . $first_day_in_week .' kezdődően, ' . $last_day_in_week. '-ig összesen <span style="font-weight:bolder; color:#d93c76;">' .  number_format($sum, 0, ',', ' ') . ' ft</span> kerestek.</div>';			
			}
		}		     
        ?>
		</div>
    </div>
</div>