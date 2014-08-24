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

		$(document).ready(function() {
			$('[title]').colorTip({color:'black'});
		});
    </script>

</head>
<body>
    <div class="title">
        <span class="firstWord">Napi </span> Összesítés
		
    
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

		$query_user = "SELECT id,name
				FROM users";

		$result_user = mysql_query($query_user) or die(mysql_error());

		while ($row_user = mysql_fetch_array($result_user)) {
			$user[$row_user["id"]]= $row_user["name"];
		}		


		echo '<div>
				<center>'.  date("Y. ", strtotime($today)) . $show_month[date("m", strtotime($today))] . date(" d, ", strtotime($today)) . $show_day[date("N", strtotime($today))] . '</center>
                <a href="?&page=statisztika&subpage=napiosszesites&datum='.date("Ymd", strtotime($today) - 1 * 24 * 3600).'"><button type="button" class = "button" id = "newButton" >Elöző Nap</button></a>
                <a href="?&page=statisztika&subpage=napiosszesites&datum='.date("Ymd", strtotime($today) + 1 * 24 * 3600).'"><button type="button" class = "button" id = "newButton" >Következő Nap</button></a>
				
			</div>';
?>


     <?php

        $query_shops = "SELECT * FROM shops";
        $result_shops = mysql_query($query_shops) or die(mysql_error());

        $tmp = 1;
        $sum = 0; 			
        $sum_other = 0;
        while ($row_shops = mysql_fetch_array($result_shops)) {
            $names[$tmp] = $row_shops["name"];


			$other_incoming_query = "SELECT id, price, shop
									FROM other_incoming
									WHERE (DATE(date)='". date("Y-m-d", strtotime($today)) ."') AND
											shop='". $tmp ."';";

			$other_incoming_result = mysql_query($other_incoming_query) or die(mysql_error());
			$other = 0;
	        while ($row_other_incoming = mysql_fetch_array($other_incoming_result)) {
	        	$other = $row_other_incoming["price"];
	        	$sum_other +=  $other;
			}

        echo '<div style="width: 730px; padding: 10px 0 10px 0;">
        		<h2 style="float:right;">Kasszazárás: ' .number_format( $other, 0, ',', ' ') . ' ft</h2>
        		<h1 style="font-size:15px; color: #627F6B;">' .$names[$tmp] . '</h1>
				<table id="statistic_table" style="width:730px;">
					<tr>
						<th>#</th>
						<th>Egyösszegű</th>
						<th>Előleg</th>
						<th>Hátralék</th>
						<th>Átvette</th>
						<th>Mikor</th>
					<tr>';


	        $query = "SELECT id,create_time, price, downprice, worker_id, paid, paid_check, shop 
						FROM orders 
						WHERE shop='". $tmp ."' AND (DATE(create_time)='". date("Y-m-d", strtotime($today)) ."' OR DATE(paid)='". date("Y-m-d", strtotime($today)) ."') AND archive = 0;";			
				
	//		echo $query;
			
			$result = mysql_query($query) or die(mysql_error());

	        $incoming_1 = 0; //bolthoz tartozo osszes egyosszegu
	        $incoming_2 = 0; //bolthoz tartozo osszes eloleg
	        $incoming_3 = 0; //bolthoz tartozo osszes hatralek
	        while ($row = mysql_fetch_assoc($result)) {

	        	//EGYOSSZEGU
	            if ($row["downprice"] == 0 && date("Y-m-d", strtotime($row["create_time"])) == date("Y-m-d", strtotime($row["paid"]))) { //az nap is fizette a koszoru teljes osszeget, nincs előleg -> Egyosszegu

					$query_wreaths = "SELECT *
					    FROM order_items
					    WHERE order_id='" . $row["id"] . "' AND is_offer=1 LIMIT 1";

					$result_wreaths = mysql_query($query_wreaths) or die(mysql_error());

					while ($row_wreaths = mysql_fetch_array($result_wreaths)) {
					    $query_wreath = "SELECT offer_wreath.id, offer_wreath.sale_price
					        FROM offer_wreath
					        WHERE offer_wreath.name='" . $row_wreaths["wreath_name"] . "'";

					    $result_wreath = mysql_query($query_wreath) or die(mysql_error());

					    while ($row_wreath = mysql_fetch_array($result_wreath)) {
							echo '
							<tr>
								<td><a style="text-decoration: none; color: #627F6B;" href="?page=rendeles&subpage=megrendeles&id='.$row["id"].'">#' . substr($row_wreaths["azonosito"],0,6) . '</a></td>
								<td style="text-align: right; padding-right:100px;">'.number_format($row[price], 0, ',', ' ') . ' ft</td>
								<td style="text-align: right; padding-right:100px;">-</td>
								<td style="text-align: right; padding-right:100px;">-</td>
								<td>'. $user[$row["worker_id"]].'</td>
								<td>'. date('H:i',strtotime($row["create_time"])).'</td>
							</tr>';

					    	$incoming_1 += $row["price"];
					    }
					}

                }

                //ELOLEG
	            if ($row["downprice"] != 0 && date("Ymd", strtotime($row["create_time"])) == date("Ymd", strtotime($today)) && ( $row["paid"] == null || (date("Y-m-d", strtotime($row["paid"])) >= date("Y-m-d", strtotime($row["create_time"])) ) )) { //csak eloleget adott, nem nulla az előleg, és már ki is van kifizetve, akkor aznap volt hátralék bevétel

					$query_wreaths = "SELECT *
					    FROM order_items
					    WHERE order_id='" . $row["id"] . "' AND is_offer=1 LIMIT 1";

					$result_wreaths = mysql_query($query_wreaths) or die(mysql_error());

					while ($row_wreaths = mysql_fetch_array($result_wreaths)) {
					    $query_wreath = "SELECT offer_wreath.id, offer_wreath.sale_price
					        FROM offer_wreath
					        WHERE offer_wreath.name='" . $row_wreaths["wreath_name"] . "'";

					    $result_wreath = mysql_query($query_wreath) or die(mysql_error());

					    while ($row_wreath = mysql_fetch_array($result_wreath)) {
				    echo '<tr>
							<td><a style="text-decoration: none; color: #627F6B;" href="?page=rendeles&subpage=megrendeles&id='.$row["id"].'">#' . substr($row_wreaths["azonosito"],0,6) . '</a></td>
							<td style="text-align: right; padding-right:100px;">-</td>
							<td style="text-align: right; padding-right:100px;">'.number_format($row["downprice"], 0, ',', ' ') . ' ft</td>
							<td style="text-align: right; padding-right:100px;">-</td>
							<td>'. $user[$row["worker_id"]].'</td>
							<td>'. date('H:i',strtotime($row["create_time"])).'</td>
						</tr>';
					    }
					}
			    	$incoming_2 += $row["downprice"];
	            }

	            //HATRALEK
	            if (( $row["paid"] != null && date("Ymd", strtotime($row["paid"])) == date("Ymd", strtotime($today)) && (date("Y-m-d", strtotime($row["paid"])) > date("Y-m-d", strtotime($row["create_time"])) ))) { //csak eloleget adott, nem nulla az előleg, és még nincs kifizetve, akkor aznap volt előlegi bevétel

					$query_wreaths = "SELECT *
					    FROM order_items
					    WHERE order_id='" . $row["id"] . "' AND is_offer=1 LIMIT 1";

					$result_wreaths = mysql_query($query_wreaths) or die(mysql_error());

					while ($row_wreaths = mysql_fetch_array($result_wreaths)) {
					    $query_wreath = "SELECT offer_wreath.id, offer_wreath.sale_price
					        FROM offer_wreath
					        WHERE offer_wreath.name='" . $row_wreaths["wreath_name"] . "'";

					    $result_wreath = mysql_query($query_wreath) or die(mysql_error());

					    while ($row_wreath = mysql_fetch_array($result_wreath)) {
						    echo '<tr>
									<td><a style="text-decoration: none; color: #627F6B;" href="?page=rendeles&subpage=megrendeles&id='.$row["id"].'">#' . substr($row_wreaths["azonosito"],0,6) . '</a></td>
									<td style="text-align: right; padding-right:100px;">-</td>
									<td style="text-align: right; padding-right:100px;">-</td>
									<td style="text-align: right; padding-right:100px;">'.number_format( $row["price"] - $row["downprice"], 0, ',', ' ') . ' ft</td>
									<td>'. $user[$row["paid_check"]].'</td>
									<td></td>
								</tr>';					    }
					}

			    	$incoming_3 += ($row["price"] - $row["downprice"]);
	            }


	        }

	        $sum += $incoming_1+$incoming_2+$incoming_3;

				    echo '<tr style="border-top:1pt solid #DDDDDD;">
					    	<td>Összesen:</td>
				    		<td style="color:#666666; text-align: right; padding-right:100px;">'.number_format( $incoming_1, 0, ',', ' ') . ' ft</td>
				    		<td style="color:#666666; text-align: right; padding-right:100px;">'.number_format( $incoming_2, 0, ',', ' ') . ' ft</td>
				    		<td style="color:#666666; text-align: right; padding-right:100px;">'.number_format( $incoming_3, 0, ',', ' ') . ' ft</td>
							<td></td>
				    		<td style="color:#d93c76;">'.number_format( $incoming_1+$incoming_2+$incoming_3, 0, ',', ' ') . ' ft</td>
						</tr>';


	echo'				</table>
				</div>';

        $tmp++;
   }

echo '
	<table id="statistic_table" style="width:730px; margin-top: 35px;">
		<tr style="border-top:2pt dotted #AAAAAA;">
	    	<td style="text-align: right;">Koszorúkból befolyt:</td>
			<td style="text-align: right; font-size: 15px; color:#000000;">'.number_format( $sum, 0, ',', ' ') . ' ft</td>
	    	<td style="text-align: right;">Összesített Kasszazárás:</td>
			<td style="text-align: right; font-size: 15px; color:#000000;">'.number_format( $sum_other, 0, ',', ' ') . ' ft</td>
		</tr>
	</table>';



?>
	</div>
</body>




