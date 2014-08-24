<head>
    <!-- ---------------------------- Datepicker ---------------------------- -->
    <link rel="stylesheet" href="css/calendar/default.css" type="text/css">
	<link rel="stylesheet" type="text/css" href="js/colortips/colortip-1.0/colortip-1.0-jquery.css"/>
	
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <script type="text/javascript" src="js/timepicker/include/jquery-1.9.0.min.js"></script>
    <script type="text/javascript" src="js/zebra_datepicker.js"></script>
    <script type="text/javascript" src="js/zebra_datepicker.src.js"></script>
	<script type="text/javascript" src="js/colortips/colortip-1.0/colortip-1.0-jquery.js"></script>


    <script type="text/javascript">
        $(document).ready(function() {
            $('input.datepicker').Zebra_DatePicker();
        });

		function delOutlay(id) {
			if(confirm('Biztosan törli a költséget?')) {
				$.ajax({ 
					type: "POST",
					url: "menu-main/menu-statistic-submenu/outlay/delOutlay.php?id="+id,
					data: {id:id},
					success: function(data){
						$('#newOutlay').html(data);
        		location.reload();
					}
				}); 
			}
		}

		function newOutlay(date) {
			$.ajax({
				type: "GET",
				url: "menu-main/menu-statistic-submenu/outlay/addOutlay2.php?datum="+date,
				success: function(data){
					$('#newOutlay').html(data);
					$('#newOutlay').toggle();
				}
			}); 
		}
		
				
		$(document).ready(function() {
			$('[title]').colorTip({color:'black'});
		});
    </script>

</head>
<body>
    <div class="title">
        <span class="firstWord">Napi Költség </span> Adatok
		
    
        <?php
		
		if (isset($_GET["datum"])){
			$today = $_GET["datum"];
		}else{
			$today = date("Ymd");
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

		$show_day = array("1" => "Hétfő",
						"2"  => "Kedd",
						"3"  => "Szerda",
						"4"  => "Csütörtök",
						"5"  => "Péntek",
						"6"  => "Szombat",
						"7"  => "Vasárnap");

	
		echo '<div>
				<center>'.  date("Y. ", strtotime($today)) . $show_month[date("m", strtotime($today))] . date(" d, ", strtotime($today)) . $show_day[date("N", strtotime($today))] . '</center>
                <a href="?&page=statisztika&subpage=napijarulek&datum='.date("Ymd", strtotime($today) - 1 * 24 * 3600).'"><button type="button" class = "button" id = "newButton" >Elöző Nap</button></a>
                <a href="?&page=statisztika&subpage=napijarulek&datum='.date("Ymd", strtotime($today) + 1 * 24 * 3600).'"><button type="button" class = "button" id = "newButton" >Következő Nap</button></a>
				
                <button style="float:right;" type="button" class = "button" id = "newButton" onClick="newOutlay('.$today.');">Új Költség</button>

			</div>';

		$query = "SELECT *
						FROM outlay_type";
		$result = mysql_query($query) or die(mysql_error());

		while ($row = mysql_fetch_array($result)) {
			$names[$row["id"]] = $row["type"];
		}

		
		//EGYÉB BEVÉTEL LEKÉRDEZÉSE
        $other_incoming_query = "SELECT id,type, price, date, note
								FROM outlay
								WHERE date='" . $today . "' AND archive=0;";

//		echo $other_incoming_query;
								
		$other_incoming_result = mysql_query($other_incoming_query) or die(mysql_error());

		echo '<div style="width: 850px;">
				<table id="statistic_table">
					<tr>
						<th>Költség típus</th>
						<th>Kiadás</th>
						<th>Megjegyzés</th>
						<th></th>
						<th></th>
					</tr>
				';

        while ($row = mysql_fetch_array($other_incoming_result)) {
			echo '<tr>';
				echo '<td>' . $names[$row["type"]] . '</td>';
				echo '<td>' . number_format($row["price"], 0, ',', ' ') . ' ft</td>';
				echo '<td>' . $row["note"] . '</td>';
				
				echo '<td >
						<a onClick="delOutlay('.$row["id"].')" href="#" style="background-image:url(http://www.nyilvantarto.koszorusarok.hu/img/icons/Delete-icon.png); background-repeat:no-repeat; width:32px; height: 32px;" class="button" ></a>					
					</td>';
				
				
				
			echo '</tr>';
		}
		
			echo '</table>
			</div>';
		
        ?>
    </div>

    <div id="newOutlay" style="z-index: 6; overflow-x: hidden;"></div>
</body>