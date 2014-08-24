<style type="text/css">
	#shifter, #calendar {
		font-size: 14px;
	}
	#shifter {
		background-color: rgba(190,210,160,0.7);
	}
	#month {
		background-color: rgba(190,210,160,0.7);
	}
	#calendar td {
		width: 40px;
		text-align: center;
	}
	#calendar .day_name {
		background-color: rgba(190,210,160,0.7);
	}
	#calendar .prev, #calendar .next {
		background-color: rgba(190,210,160,0.7);
	}
	#calendar a {
	 	color: #fff;
 	}
</style>

<?php
	//http://www.phpjabbers.com/how-to-make-a-php-calendar-php26.html
	$monthNames = Array("Január", "Február", "Március", "Április", "Május", "Június", "Július", 
	"Augusztus", "Szeptember", "Október", "November", "December");
?>
<?php
	if (!isset($_REQUEST["month"])) $_REQUEST["month"] = date("n");
	if (!isset($_REQUEST["year"])) $_REQUEST["year"] = date("Y");
?>
<?php
	$cMonth = $_REQUEST["month"];
	$cYear = $_REQUEST["year"];

	$prev_year = $cYear;
	$next_year = $cYear;
	$prev_month = $cMonth-1;
	$next_month = $cMonth+1;
	 
	if ($prev_month == 0 ) {
		$prev_month = 12;
		$prev_year = $cYear - 1;
	}
	if ($next_month == 13 ) {
		$next_month = 1;
		$next_year = $cYear + 1;
	}
?>
<table>
	<tr>
		<td align="center">
			<table id="calendar" width="100%" border="0" cellpadding="2" cellspacing="2">
				<tr align="center">
					<td colspan="2" class="prev">
						<a href="<?php echo $_SERVER["PHP_SELF"] . "?month=". $prev_month . "&year=" . $prev_year; ?>"> előző </a>
					</td>

					<td colspan="3" id="month"><strong><?php echo $monthNames[$cMonth-1].' '.$cYear; ?></strong></td>

					<td colspan="2" class="next">
						<a href="<?php echo $_SERVER["PHP_SELF"] . "?month=". $next_month . "&year=" . $next_year; ?>"> következő </a>
					</td>
				</tr>
				<tr>
					<td align="center" class="day_name"><strong>H</strong></td>
					<td align="center" class="day_name"><strong>K</strong></td>
					<td align="center" class="day_name"><strong>Sz</strong></td>
					<td align="center" class="day_name"><strong>Cs</strong></td>
					<td align="center" class="day_name"><strong>P</strong></td>
					<td align="center" class="day_name"><strong>Sz</strong></td>
					<td align="center" class="day_name"><strong>V</strong></td>
				</tr>
<?php 
	$timestamp = mktime(0,0,0,$cMonth,1,$cYear); // mktime(hour,minute,second,month,day,year,is_dst);
	$maxday = date("t",$timestamp);	//maxday = hány napos a hónap
	$thismonth = getdate($timestamp);
	$startday = $thismonth['wday']-1;
	function round_up_to_nearest_n($int, $n) {
		return ceil($int / $n) * $n;
	}
	$complete_cells = round_up_to_nearest_n($maxday+$startday,7);
	for ($i=0; $i<($complete_cells); $i++) {
		if(($i % 7) == 0 ) echo "<tr>";
		if($i < $startday || $i >= $maxday+$startday) echo "<td class='day'></td>";
		else echo "<td class='day'>". ($i - $startday + 1) . "<br>(6)  (5)" . "</td>";
		if(($i % 7) == 6 ) {
			echo "</tr>";
		}
	}
?>
			</table>
		</td>
	</tr>
</table>