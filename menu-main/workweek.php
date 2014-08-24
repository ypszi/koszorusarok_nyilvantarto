<?php
	include 'config.php';

	$admin = false;
	if (isset($_SESSION['logged_in'])) {
		$result = mysql_query(sprintf("SELECT access_level FROM users WHERE id='%s'", $_SESSION['logged_in']));
		$row = mysql_fetch_assoc($result);
		$admin = $row["access_level"] == 1100;
	}

	$actualWeek = date('W');
	$dayOfWeek = date('N');
	$year = strftime("%Y");
	$last_selected = -1;
	$last_begin = "7:00";
	$last_end = "20:00";

	if ($admin && isset($_POST["delete"])) {
		$user_id = intval($_POST["user_id"]);
		$store_id = intval($_POST["store_id"]) + 1;
		$week = intval($_POST["week"]);
		$day = intval($_POST["day"]);
		mysql_query(sprintf("DELETE FROM workweek%d WHERE user='%d' AND day=%d AND week=%d AND year=%d", $store_id, $user_id, $day, $week, $year)) or die(mysql_error());
		if ($_POST["delete"] == 0) {
			$two = explode(":", $_POST["begin_time"], 2);
			$begin_time = ((intval($two[0]) - 6) * 2 + (intval($two[1]) == 30 ? 1 : 0));
			$two = explode(":", $_POST["end_time"], 2);
			$end_time = ((intval($two[0]) - 6) * 2 + (intval($two[1]) == 30 ? 1 : 0));
			mysql_query(sprintf("INSERT INTO workweek%d (year, week, day, user, begin, end) VALUES (%d, %d, %d, '%d', '%d', '%d')", $store_id, $year, $week, $day, $user_id, $begin_time, $end_time)) or die(mysql_error());
		}
		$last_selected = $user_id;
		$last_canvas = $_POST["last_canvas"];
		$last_day = $day;
		$last_begin = $_POST["begin_time"];
		$last_end = $_POST["end_time"];
		$scroll_top = $_POST["scroll_top"];
	}
	
	if (isset($_POST["week_num"]) && $_POST["week_num"] > 0 && $_POST["week_num"] < 54) {
		$initWeek = $_POST["week_num"];
	} else {
		$initWeek = $actualWeek;
	}

	$i = 0;
	$shops = null;
	$result = mysql_query("SELECT * FROM shops");
	$jsShops = "new Array(";
	while ($row = mysql_fetch_assoc($result)) {
		$shops[$i++] = array("id"=>$row["id"], "name"=>$row["name"], "enable"=>intval($row["enable"]));
		$jsShops .= "'{$row['name']}', ";
	}
	$jsShops = substr($jsShops, 0, strlen($jsShops) - 2) . ")";

	$jsWeek1 = "new Array(";
	$jsWeek2 = "new Array(";
	for ($day = 1; $day <= 7; $day++) {
		$jsWeek1 .= "'" . date('m.d.', strtotime("{$year}W" . str_pad($initWeek, 2, '0' , STR_PAD_LEFT) . "$day")) . "', ";
		$jsWeek2 .= "'" . date('m.d.', strtotime("{$year}W" . str_pad($initWeek + 1, 2, '0' , STR_PAD_LEFT) . "$day")) . "', ";
	}
	$jsWeek1 = substr($jsWeek1, 0, strlen($jsWeek1) - 2) . ")";
	$jsWeek2 = substr($jsWeek2, 0, strlen($jsWeek2) - 2) . ")";

	$jsUsers = "new Array(";
	$result = mysql_query("SELECT name, color FROM `users` where title!='Fejlesztő' AND title!='Tulajdonos' AND enable=1 ORDER BY name");
	while ($row = mysql_fetch_assoc($result)) {
		$jsUsers .= "new construct_User('{$row['name']}', '{$row['color']}'), ";
	}
	$jsUsers = substr($jsUsers, 0, strlen($jsUsers) - 2) . ")";
	$cid = 0;
	$count = 0;
	$jsIntervals = "new Array(";
	for ($shop = 0; $shop < 3; $shop++) {
		for ($week = $initWeek; $week <= $initWeek + 1; $week++) {
			if ($shops[$shop]["enable"] == 1) {
				$workweek = 'workweek' . ($shop + 1);
				$result = mysql_query("SELECT day, begin, end, color FROM `$workweek`, `users` WHERE year=$year AND week=$week AND `users`.id=`$workweek`.user ORDER BY day");
				$count += mysql_num_rows($result);
				while ($row = mysql_fetch_assoc($result)) {
					$jsIntervals .= "new construct_Interval(" . $cid  . ", {$row['day']}, '#{$row['color']}', {$row['begin']}, {$row['end']}), ";
				}
			}
			$cid++;
		}
	}
	$jsIntervals = ($count == 0 ? $jsIntervals : substr($jsIntervals, 0, strlen($jsIntervals) - 2)) . ")";
	
	$workers = "";
	$result = mysql_query("SELECT id, name FROM users WHERE title!='Fejlesztő' AND title!='Tulajdonos' AND enable=1 ORDER BY name");
	while ($row = mysql_fetch_assoc($result)) {
		$selected = $last_selected == $row["id"] ? " selected" : "";
		$workers .= "<option value='{$row['id']}'$selected>{$row['name']}</option>";
	}

?>
<link href="css/workweek.css" rel="stylesheet" type="text/css" media="all"/>
<link rel="stylesheet" href="js/timepicker2/include/ui-1.10.0/ui-lightness/jquery-ui-1.10.0.custom.min.css" type="text/css" />
<link rel="stylesheet" href="js/timepicker2/jquery.ui.timepicker.css?v=0.3.2" type="text/css" />
<link rel="stylesheet" href="js/timepicker2/jquery.ui.timepickerCustom.css?v=0.3.2" type="text/css" />
<script src="js/workweek_canvas.js"></script>
<script type="text/javascript" src="js/timepicker2/include/jquery-1.9.0.min.js"></script>
<script type="text/javascript" src="js/timepicker2/include/ui-1.10.0/jquery.ui.core.min.js"></script>
<script type="text/javascript" src="js/timepicker2/jquery.ui.timepicker.js?v=0.3.2"></script>
<div id="content" style="padding: 10px; background-color: #fff;">
	<div class="block-formatting-context">
		<form method="post">
			<div class="column-left right-align">
				<div class="title workweek-title"> 
					<span class="firstWord">Munka</span>hét - <?php echo $actualWeek; ?>. hét
				</div>
				<div class="button-margin">
					<input type="submit" class="button" value="Előző hét" onclick="changeWeek(-1);" />
					<input type="button" class="button week-number" value="<?php echo $initWeek; ?>. hét" />
				</div>
			</div>
			<div class="column-right">
				<div class="button-margin">
					<input type="button" class="button week-number" value="<?php echo $initWeek + 1; ?>. hét" />
					<input type="submit" class="button" value="Következő hét" onclick="changeWeek(1);" />
				</div>
			</div>
			<input id="week_num" type="hidden" value="<?php echo $initWeek;?>" name="week_num" />
		</form>
	</div>
	<div class="calendar-box">
		<?php if ($admin): ?>
		<div class="block-formatting-context interval-form">
			<div class="quarter">
				<div>
					Alkalmazottak: <select id="user_id_top" onchange="syncWorker('user_id_bot', this)"><?php echo $workers; ?></select>
				</div>
			</div>
			<div class="quarter">
				<div>
					Munkaidő: 
					<input type="text" class="timeInput" id="begin_time_top" value="<?php echo $last_begin; ?>" onchange="syncTime('begin_time_bot', this);" /> - 
					<input type="text" class="timeInput" id="end_time_top" value="<?php echo $last_end; ?>" onchange="syncTime('end_time_bot', this);"/>
					<button type="button" class="workTime" title="Rövid műszak" onclick="setShort();">R</button>
					<button type="button" class="workTime" title="Hosszú műszak" onclick="setLong();">H</button>
				</div>
			</div>
			<div class="quarter">
				<div>
					<span class="highlight" id="store_top">-</span>,
					<span class="highlight" id="week_top">-</span> hét, 
					<span class="highlight" id="day_top">-</span>
				</div>
			</div>
			<div class="quarter">
				<div>
					<button class="set-work-time" type="button" onclick="sendChange(false)">Küldés</button>
					<button class="delete-work-time" type="button" onclick="sendChange(true)">Törlés</button>
				</div>
			</div>
		</div>
		<?php endif;
		 echo makeCanvases();
		 if ($admin): ?>
		<div class="block-formatting-context interval-form">
			<div class="quarter">
				<div>
					Alkalmazottak: <select id="user_id_bot" onchange="syncWorker('user_id_top', this)"><?php echo $workers; ?></select>
				</div>
			</div>
			<div class="quarter">
				<div>
					Munkaidő: 
					<input type="text" class="timeInput" id="begin_time_bot" value="<?php echo $last_begin; ?>" onchange="syncTime('begin_time_top', this);" /> - 
					<input type="text" class="timeInput" id="end_time_bot" value="<?php echo $last_end; ?>" onchange="syncTime('end_time_top', this);" />
					<button type="button" class="workTime" title="Rövid műszak" onclick="setShort();">R</button>
					<button type="button" class="workTime" title="Hosszú műszak" onclick="setLong();">H</button>
				</div>
			</div>
			<div class="quarter">
				<div>
					<span class="highlight" id="store_bot">-</span>,
					<span class="highlight" id="week_bot">-</span> hét, 
					<span class="highlight" id="day_bot">-</span>
				</div>
			</div>
			<div class="quarter">
				<div>
					<button class="set-work-time" type="button" onclick="sendChange(false)">Küldés</button>
					<button class="delete-work-time" type="button" onclick="sendChange(true)">Törlés</button>
				</div>
			</div>
		</div>
		<?php endif; ?>
	</div>
	<div id="legend_div">
		<canvas id="legend" width="1000" height="30"></canvas>
	</div>
	<form id="interval_form" name="interval_form" method="post">
		<input id="user_id" type="hidden" name="user_id" />
		<input id="begin_time" type="hidden" name="begin_time" />
		<input id="end_time" type="hidden" name="end_time" />
		<input id="store_id" type="hidden" name="store_id" />
		<input id="day" type="hidden" name="day" />
		<input id="week" type="hidden" name="week" />
		<input id="delete" type="hidden" name="delete" />
		<input id="last_canvas" type="hidden" name="last_canvas" />
		<input id="scroll_top" type="hidden" name="scroll_top" />
		<input id="week_num2" type="hidden" value="<?php echo $initWeek;?>" name="week_num" />
	</form>
</div>
<script>
	var users = <?php echo $jsUsers; ?>;
	var intervals = <?php echo $jsIntervals; ?>;
	var initweek = <?php echo $initWeek; ?>;
	var week1 = <?php echo $jsWeek1; ?>;
	var week2 = <?php echo $jsWeek2; ?>;
	var actualWeek = <?php echo ($actualWeek == $initWeek ? 0 : ($actualWeek == $initWeek + 1 ? 1 : 2)); ?>;
	var dayOfWeek = <?php echo $dayOfWeek; ?> - 1;
	var shops = <?php echo $jsShops; ?>;
	var setShop = -1;
	var setWeek = -1;
	var setDay = -1;
	var lastCanvas;
	$(document).ready(function() {
		initialize();
		<?php
		 if ($last_selected != -1) {
		 	echo "fake('$last_canvas', $last_day);";
		 	echo "document.body.scrollTop = $scroll_top;";
		 	echo "document.documentElement.scrollTop = $scroll_top;";
		 }
		?>
		$('#begin_time_top').timepicker();
		$('#end_time_top').timepicker();
		$('#begin_time_bot').timepicker();
		$('#end_time_bot').timepicker();
	});
</script>
<?php
	function makeCanvases() {
		$HTML = "";
		$ind = 0;
		for ($i = 0; $i < 3; $i++) {
			global $shops;
			$style = $shops[$i]["enable"] == 1 ? "" : " style='display: none'";
			$HTML .= "<div class='block-formatting-context'$style><div class='double-box-wrapper'>";
			for ($j = 0; $j < 2; $j++) {
				$class = $j % 2 == 0 ? 'column-left' : 'column-right';
				$canvas = "canvas" . $ind++;
				$HTML .= "<div class='$class'><canvas id='$canvas' class='canvas' width='490' height='320'></canvas></div>";
			}
			$HTML .= '</div></div>';
		}
		return $HTML;
	}
?>