<style type="text/css">

	#calendar table{
		width: 1010px;
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
	
	.print a{
		background: url(../img/btn-bg1.png) repeat-x 0 0px;
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

	.print a:hover{
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
	
</style>

<div id="content" style="padding: 10px; background-color: #fff;">


<?php
	$query =  mysql_query("
		SELECT name 
		FROM  users 
		WHERE id=".$_SESSION['logged_in'].";");
	$username = mysql_result($query,0);

	echo '<div class="title">
			<span class="firstWord">Üdvözöllek, </span>'.$username.' 
		</div>';

/*	echo '<div class="title" style="text-align:center; padding-top:20px;">
			Itt az új év, új jót hozzon, régi jóktól meg ne fosszon,<br/> de ha az új jót nem is hozhat, vigye el a régi rosszat!<br/><br/>Boldog Új Évet Kívánok! 
		</div>';
*/		
?>

<?php if ($_SESSION['logged_in'] != 1 && $_SESSION['logged_in'] != 2 && $_SESSION['logged_in'] != 3) { ?>
	<div class="title">
		<span class="firstWord">Munka </span> naptár 
		<span class="print" style="float:right;">
			<span><a href="/menu-main/menu-main-submenu/get-calendar-pdf.php?user_id=<?php echo $_SESSION['logged_in']; ?>" target="_blank">Nyomtatás</a><span>
		</span>
	</div>

	<div style="padding: 0px 0px 20px 30px;">
		<div id="calendar">
		<?php
				function create_time($t){
					if ($t % 2 == 0){
						return '<span>' . (6+$t/2) . '<sup>00</sup></span>';
					}else{
						return '<span>' . (6+$t/2) . '<sup>30</sup></span>';
					}
				}
				
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
				
			for ($shop=1; $shop<4; $shop++){
				$query = "SELECT week,day,user,begin,end 
				   FROM workweek".$shop." 
				   WHERE user=".$_SESSION['logged_in']." AND (week between ". date(W) ." AND ".(date(W)+4).") AND year=" . date('Y'). "
				   ORDER BY week,day ASC;";
				
				$result = mysql_query($query) or die (mysql_error());

//				echo $query;
				
				while ($row = mysql_fetch_assoc($result)) {
					$workhour[$row["week"]][$row["day"]] = create_time($row["begin"]) . ' - ' . create_time($row["end"]);
//					echo $row["week"] ." - ". $row["day"] . " - " . $workhour[$row["week"]][$row["day"]] . "<br />";
				}
			}
			
				echo '<table>';
				echo' <tr>
					<th>#</th>
					<th>Hétfő</th>
					<th>Kedd</th>
					<th>Szerda</th>
					<th>Csütörtök</th>
					<th>Péntek</th>
					<th>Szombat</th>
					<th>Vasárnap</th>
						</tr>';
			for ($week=(date(W)-0); $week<(date(W)+4); $week++){
				echo'<tr>';
					$time = strtotime("1 January ".date("Y"), time());		
					$time += ((7*($week-1))+1-date('w', $time))*24*3600;

					echo '<td>'. $show_month[date('m', $time)] . '<br />' . $week . '. hét</td>'; 

					
					for ($day=0; $day<7; $day++){
						$today = date('d', $time + $day*24*3600);
						
//						echo $week . " - " .$day;
						
						if ($day!=(date(N)-1) || $week!=date(W)){
							if (isset($workhour[$week][$day])){
								echo '<td><span class="today">'. $today .'</span><br />'. $workhour[$week][$day] .'</td>';
							}else{
								echo '<td><span class="today">'. $today .'</span><br /> - </td>';							
							}
						}else{
							if (isset($workhour[$week][$day])){
								echo '<td class="now"><span class="today">'. $today .'</span><br />'. $workhour[$week][$day] .'</td>';
							}else{
								echo '<td class="now"><span class="today">'. $today .'</span><br /> - </td>';							
							}
						}
					}
				echo'</tr>';
			}
			echo '</table>';
		?>
		</div>
	</div>
	<?php } ?>

	<?php
	$queryRecieved = "SELECT id, sender, recipient, message, readed, rec_del, sen_del, created, reply_id, archiveRecipient
		FROM message
		WHERE recipient = '" . $_SESSION['logged_in'] . "' AND archiveRecipient = 0 AND rec_del = 0 AND readed = 0 ORDER BY created DESC;";
	$resultRecieved = mysql_query($queryRecieved) or die (mysql_error());
	?>

	<div class="title">
		<span class="firstWord">Bejövő </span> üzenetek 
	</div>

	<div style="padding: 10px 0px 20px 30px;">
		<div id = "messages">
			<br />
			<table id = "recievedMessages">
				<tr>
					<th class = "msgHeader msgSender"><p>Küldő</p></th>
					<th class = "msgHeader msgTimeOfSending"><p>Küldés ideje</p></th>
					<th class = "msgHeader msgMessage"><p>Üzenet</p></th>
				</tr>
	<?php
				while ($row = mysql_fetch_assoc($resultRecieved)) {
					$query_user = "SELECT name FROM users WHERE id = '" . $row["sender"] . "'";
					$res_user = mysql_query($query_user) or die(mysql_error());
					$row_user = mysql_fetch_assoc($res_user);
				echo "
					<tr>
						<td>" . $row_user["name"] . "</td>
						<td>" . $row["created"] . "</td>
						<td>" . $row["message"] . "</td>
					</tr>
				";
				}
				echo "
					</table>
					";
	?>
		</div>
	</div>
	
<?php /* if ($_SESSION['logged_in'] == 1 || $_SESSION['logged_in'] == 2 || $_SESSION['logged_in'] == 3) { ?>
	<div class="title">
		<span class="firstWord">Rendszer</span> üzenetek - Csak egy minta adat lesz most itt!
	</div>
	<div style="padding: 10px 0px 20px 30px;">
		<div id = "messages">
			<table id = "recievedMessages">
				<tr>
					<th class = "msgHeader msgSender"><p>Mikor</p></th>
					<th class = "msgHeader msgTimeOfSending"><p>Ki</p></th>
					<th class = "msgHeader msgMessage"><p>Mit</p></th>
				</tr>
				<tr>
					<td>2013.11.19 13:15</td>
					<td>Nichtáné Garay Szilvia</td>
					<td><a href="#">† Németh Vilmos</a> megrendelést törölte.</td>
				</tr>
				<tr>
					<td>2013.11.19 10:10</td>
					<td>Anna</td>
					<td><a href="#">† Németh Vilmos</a> megrendelést modositotta a <a href="#">† Németh Vilmos</a> megrendelésre.</td>
				</tr>
				<tr>
					<td>2013.11.19 09:05</td>
					<td>Nichtáné Garay Szilvia</td>
					<td><a href="#">† Németh Vilmos</a> megrendelést modositotta a <a href="#">† Németh Vilmos</a> megrendelésre.</td>
				</tr>
			</table>
		</div>
	</div>
<?php } */ ?>