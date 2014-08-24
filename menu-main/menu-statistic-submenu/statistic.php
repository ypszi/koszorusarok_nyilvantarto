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

        function newIncome() {
            $.ajax({
                type: "GET",
                url: "menu-main/menu-statistic-submenu/statistic/addIncome.php",
                success: function(data) {
                    $('#newAcquisition').html(data);
                    $('#newAcquisition').toggle();
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
        <span class="firstWord">Bevételi </span> Adatok
        <div>
            <form id = "selectForm" style="width:730px;" method="GET">
                <table id = "selectFormTable" style="width:730px;">
                    <tr>
                        <?php
                        $beginDate = isset($_GET['min_date']) ? $_GET['min_date'] : date("Y-m") . "-01";
                        $endDate = isset($_GET['max_date']) ? $_GET['max_date'] : date("Y-m-d");

                        echo '<td><CENTER><input type="text" name="min_date" id="min_date" class="datepicker borderedStyle" value="' . $beginDate . '"></CENTER></td>
				<td><CENTER> - </CENTER></td>
				<td><CENTER><input type="text" name="max_date" id="max_date" class="datepicker borderedStyle" value="' . $endDate . '"></CENTER></td>';
                        ?>
                        <td>
                            <input type="hidden" name="page" value="statisztika">
                            <input type="hidden" name="subpage" value="bevetel">
                        </td>
                        <?php
                        $bd = date("Y-m-d");
                        //date("j",strtotime($beginDate) + $d*24*3600)	
                        //echo	date("Y-m-d",strtotime($bd)+((8-date("N"))*24*3600));

                        $shop1 = 0;
                        $shop2 = 0;
                        $shop3 = 0;

                        if (isset($_GET['shop1'])) {
                            $shop1 = "checked";
                        } else
                            $shop1 = "";

                        if (isset($_GET['shop2'])) {
                            $shop2 = "checked";
                        } else
                            $shop2 = "";

                        if (isset($_GET['shop3'])) {
                            $shop3 = "checked";
                        } else
                            $shop3 = "";


                        if ($shop1 == "checked" || $shop2 == "checked" || $shop3 == "checked") {
                            $shopsql = " AND (";
                        } else {
                            $shopsql = "";
                        }

                        if ($shop1 == "checked") {
                            $shopsql .= " shop = 1";
                        }
                        if ($shop2 == "checked") {
                            if ($shop1 == "checked")
                                $shopsql .= " OR ";
                            $shopsql .= " shop = 2";
                        }
                        if ($shop3 == "checked") {
                            if ($shop1 == "checked" || $shop2 == "checked")
                                $shopsql .= " OR ";
                            $shopsql .= " shop = 3";
                        }
                        if ($shopsql != "")
                            $shopsql .= ")";

                        if (!isset($_GET['allchecked'])) {
                            $shop1 = "checked";
                            $shop2 = "checked";
                            $shop3 = "checked";
                        }

                        $query_shops = "SELECT *
				FROM shops";
                        $result_shops = mysql_query($query_shops) or die(mysql_error());

                        $tmp = 1;
                        while ($row_shops = mysql_fetch_array($result_shops)) {
                            $names["name" . $tmp] = $row_shops["name"];
                            $tmp++;
                        }
                        ?> 
                        <td>
                            <input type="hidden" name="page" value="statisztika">
                            <input type="hidden" name="subpage" value="bevetel">
                            <input type="hidden" name="allchecked" value="1">
                            <input type="checkbox" name="shop1" class = "shopCheck" <?php echo $shop1; ?> ><?php echo $names["name1"]; ?> bolt<br/>
							<input type="checkbox" name="shop2" class = "shopCheck" <?php echo $shop2; ?> ><?php echo $names["name2"]; ?> bolt<br/>
							<input type="checkbox" name="shop3" class = "shopCheck" <?php echo $shop3; ?> ><?php echo $names["name3"]; ?> bolt</td>
                        <td><button type="submit" class = "button" id = "filter">Szűrés</button></td>
                        <td><button type="button" class = "button" id = "newButton" onClick="newIncome();">Napi kasszazárás</button></td>
                    </tr>
                </table>
            </form>
        </div>	


        <?php
        $query = "SELECT id,create_time, price, downprice, paid, shop
		FROM orders
		WHERE ((create_time>='" . $beginDate . " 00-00-00' AND create_time<='" . $endDate . " 23-59-59') OR  
				(paid>='" . $beginDate . " 00-00-00' AND paid<='" . $endDate . " 23-59-59'))
			" . $shopsql . " AND archive = 0;";
			
			
//		echo $query;
		
		$result = mysql_query($query) or die(mysql_error());

        while ($row = mysql_fetch_assoc($result)) {
//			echo date("Y-m-d",strtotime($row["paid"])). "<br/>";
//			echo date("Y-m-d",strtotime($row["create_time"])). "<br/>";
//			echo $row["downprice"]. "<br/>";

            if ($row["downprice"] == 0 && date("Y-m-d", strtotime($row["create_time"])) == date("Y-m-d", strtotime($row["paid"]))) { //az nap is fizette a koszoru teljes osszeget, nincs előleg
                $wreaths_full[date("n", strtotime($row["create_time"]))][date("j", strtotime($row["create_time"]))] += $row["price"];

                $query_wreaths = "SELECT *
							FROM order_items
							WHERE order_id='" . $row["id"] . "' AND is_offer=0";

                $result_wreaths = mysql_query($query_wreaths) or die(mysql_error());

                while ($row_wreaths = mysql_fetch_array($result_wreaths)) {
                    $query_wreath = "SELECT special_wreath.id, special_wreath.sale_price
								FROM special_wreath
								WHERE special_wreath.name='" . $row_wreaths["wreath_name"] . "'";

                    $result_wreath = mysql_query($query_wreath) or die(mysql_error());

                    while ($row_wreath = mysql_fetch_array($result_wreath)) {
                        $wreaths_full_count[date("n", strtotime($row["create_time"]))][date("j", strtotime($row["create_time"]))] ++;
						$wreaths_full_hint[date("n", strtotime($row["create_time"]))][date("j", strtotime($row["create_time"]))] .= '#' . $row_wreaths["azonosito"] . '<br />';
                    }
                }

                $query_wreaths = "SELECT *
							FROM order_items
							WHERE order_id='" . $row["id"] . "' AND is_offer=1";

                $result_wreaths = mysql_query($query_wreaths) or die(mysql_error());

                while ($row_wreaths = mysql_fetch_array($result_wreaths)) {
                    $query_wreath = "SELECT offer_wreath.id, offer_wreath.sale_price
								FROM offer_wreath
								WHERE offer_wreath.name='" . $row_wreaths["wreath_name"] . "'";

                    $result_wreath = mysql_query($query_wreath) or die(mysql_error());

                    while ($row_wreath = mysql_fetch_array($result_wreath)) {
                        $wreaths_full_count[date("n", strtotime($row["create_time"]))][date("j", strtotime($row["create_time"]))] ++;
						$wreaths_full_hint[date("n", strtotime($row["create_time"]))][date("j", strtotime($row["create_time"]))] .= '#' . $row_wreaths["azonosito"] . '<br />';
                    }
                }
            }

//			echo date("Y-m-d",strtotime($row["paid"])). "<br/>";
//			echo $row["paid"] . " - ";
//			echo date("Y-m-d",strtotime($row["paid"])) . "<br />";
//			echo date("Y-m-d",strtotime($row["create_time"])) . "<br />";
//			echo $row["downprice"] . "<br/><br/>";
//			
            if ($row["downprice"] != 0 && ( $row["paid"] == null || (date("Y-m-d", strtotime($row["paid"])) >= date("Y-m-d", strtotime($row["create_time"])) ) )) { //csak eloleget adott, nem nulla az előleg, és már ki is van kifizetve, akkor aznap volt hátralék bevétel
                $wreaths_downprice[date("n", strtotime($row["create_time"]))][date("j", strtotime($row["create_time"]))] += $row["downprice"];

//				echo $wreaths_downprice[date("n",strtotime($row["create_time"]))][date("j",strtotime($row["create_time"]))];

                $query_wreaths = "SELECT *
							FROM order_items
							WHERE order_id='" . $row["id"] . "' AND is_offer=0";

                $result_wreaths = mysql_query($query_wreaths) or die(mysql_error());

                while ($row_wreaths = mysql_fetch_array($result_wreaths)) {
                    $query_wreath = "SELECT special_wreath.id, special_wreath.sale_price
								FROM special_wreath
								WHERE special_wreath.name='" . $row_wreaths["wreath_name"] . "'";

                    $result_wreath = mysql_query($query_wreath) or die(mysql_error());

                    while ($row_wreath = mysql_fetch_array($result_wreath)) {
                        $wreaths_downprice_count[date("n", strtotime($row["create_time"]))][date("j", strtotime($row["create_time"]))] ++;
						$wreaths_downprice_hint[date("n", strtotime($row["create_time"]))][date("j", strtotime($row["create_time"]))] .= '#' . $row_wreaths["azonosito"] . '<br />';
                    }
                }

                $query_wreaths = "SELECT *
                    FROM order_items
                    WHERE order_id='" . $row["id"] . "' AND is_offer=1";

                $result_wreaths = mysql_query($query_wreaths) or die(mysql_error());

                while ($row_wreaths = mysql_fetch_array($result_wreaths)) {
                    $query_wreath = "SELECT offer_wreath.id, offer_wreath.sale_price
                        FROM offer_wreath
                        WHERE offer_wreath.name='" . $row_wreaths["wreath_name"] . "'";

                    $result_wreath = mysql_query($query_wreath) or die(mysql_error());

                    while ($row_wreath = mysql_fetch_array($result_wreath)) {
                        $wreaths_downprice_count[date("n", strtotime($row["create_time"]))][date("j", strtotime($row["create_time"]))] ++;
						$wreaths_downprice_hint[date("n", strtotime($row["create_time"]))][date("j", strtotime($row["create_time"]))] .= '#' . $row_wreaths["azonosito"] . '<br />';
                    }
                }
            }


            if (( $row["paid"] != null && (date("Y-m-d", strtotime($row["paid"])) > date("Y-m-d", strtotime($row["create_time"])) ))) { //csak eloleget adott, nem nulla az előleg, és még nincs kifizetve, akkor aznap volt előlegi bevétel
                $wreaths_remainder[date("n", strtotime($row["paid"]))][date("j", strtotime($row["paid"]))] += $row["price"] - $row["downprice"];

//				echo $wreaths_downprice[date("n",strtotime($row["create_time"]))][date("j",strtotime($row["create_time"]))];

                $query_wreaths = "SELECT *
                    FROM order_items
                    WHERE order_id='" . $row["id"] . "' AND is_offer=0";

                $result_wreaths = mysql_query($query_wreaths) or die(mysql_error());

                while ($row_wreaths = mysql_fetch_array($result_wreaths)) {
                    $query_wreath = "SELECT special_wreath.id, special_wreath.sale_price
                        FROM special_wreath
                        WHERE special_wreath.name='" . $row_wreaths["wreath_name"] . "'";

                    $result_wreath = mysql_query($query_wreath) or die(mysql_error());

                    while ($row_wreath = mysql_fetch_array($result_wreath)) {
                        $wreaths_remainder_count[date("n", strtotime($row["paid"]))][date("j", strtotime($row["paid"]))] ++;
						$wreaths_remainder_hint[date("n", strtotime($row["create_time"]))][date("j", strtotime($row["create_time"]))] .= '#' . $row_wreaths["azonosito"] . '<br />';
                    }
                }

                $query_wreaths = "SELECT *
                    FROM order_items
                    WHERE order_id='" . $row["id"] . "' AND is_offer=1";

                $result_wreaths = mysql_query($query_wreaths) or die(mysql_error());

                while ($row_wreaths = mysql_fetch_array($result_wreaths)) {
                    $query_wreath = "SELECT offer_wreath.id, offer_wreath.sale_price
                        FROM offer_wreath
                        WHERE offer_wreath.name='" . $row_wreaths["wreath_name"] . "'";

                    $result_wreath = mysql_query($query_wreath) or die(mysql_error());

                    while ($row_wreath = mysql_fetch_array($result_wreath)) {
                        $wreaths_remainder_count[date("n", strtotime($row["paid"]))][date("j", strtotime($row["paid"]))] ++;						
						$wreaths_remainder_hint[date("n", strtotime($row["paid"]))][date("j", strtotime($row["paid"]))] .= '#' . $row_wreaths["azonosito"] . '<br />';
                    }
                }
            }
        }

		
		//EGYÉB BEVÉTEL LEKÉRDEZÉSE
        $other_incoming_query = "SELECT id, price, wreath_price, date, shop, note
								FROM other_incoming
								WHERE (date>='" . $beginDate . "' AND date<='" . $endDate . "')
										" . $shopsql . ";";

		$other_incoming_result = mysql_query($other_incoming_query) or die(mysql_error());

        while ($row = mysql_fetch_array($other_incoming_result)) {
			$other_incoming[date("n", strtotime($row["date"]))][date("j", strtotime($row["date"]))] += $row["price"];
//			$other_incoming_id[date("n", strtotime($row["date"]))][date("j", strtotime($row["date"]))] += $row["id"];
//href="#" onClick="modyIncome('.$other_incoming_id[date("n", strtotime($beginDate) + $d * 24 * 3600)][date("j", strtotime($beginDate) + $d * 24 * 3600)].');"
			$other_incoming_hint[date("n", strtotime($row["date"]))][date("j", strtotime($row["date"]))] .= $names["name" .$row["shop"]] . ' - ' . number_format($row["price"], 0, ',', ' ') . ' ft - ' . $row["note"]. '<br/>';

			if (isset($row["wreath_price"])){
				$wreath_price[date("n", strtotime($row["date"]))][date("j", strtotime($row["date"]))] += $row["wreath_price"];
				$wreath_price_hint[date("n", strtotime($row["date"]))][date("j", strtotime($row["date"]))] .= $names["name" .$row["shop"]] . ' - ' . number_format($row["wreath_price"], 0, ',', ' ') . ' ft<br/>';
			}

			
			if (isset($row["shop"]) && $row["shop"]==1){
				$full_price_shop1 += $row["price"];
			}elseif (isset($row["shop"]) && $row["shop"]==2){
				$full_price_shop2 += $row["price"];			
			}elseif (isset($row["shop"]) && $row["shop"]==3){
				$full_price_shop3 += $row["price"];
			}
		}
		
        echo '<div style="width: 730px;">
				<table id="statistic_table" style="width:730px;">
					<tr>
						<th>Nap</th>
						<th>Egyösszegű</th>
						<th>Előleg</th>
						<th>Hátralék</th>
						<th>Koszorúkból befolyt</th>
						<th>Egyéb befolyt</th>
						<th>Összes Bevétel</th>
					</tr>
				';

        $sum_full = 0;
        $sum_remainder = 0;
        $sum_downprice = 0;

        $day = date("ynj", strtotime($beginDate));
        $d = 0;
        $sum = 0;
//		echo date("md", strtotime($endDate));

        while ($day <= date("ymd", strtotime($endDate))) {
            if ($d % 2 != 0) {
                $color = "#ffffff";
            } else {
                $color = "#e2f1cb";
            }
			$day_sum = $wreaths_full[date("n",strtotime($beginDate) + $d*24*3600)][date("j",strtotime($beginDate) + $d*24*3600)] +
						$wreaths_downprice[date("n",strtotime($beginDate) + $d*24*3600)][date("j",strtotime($beginDate) + $d*24*3600)]+
						$wreaths_remainder[date("n",strtotime($beginDate) + $d*24*3600)][date("j",strtotime($beginDate) + $d*24*3600)];
//						+$other_incoming[date("n", strtotime($beginDate) + $d *24*3600)][date("j", strtotime($beginDate) + $d*24*3600)];

            echo '<tr style="background-color:' . $color . ';">
						<td><a style="text-decoration: none; color: #627F6B;" href="http://nyilvantarto.koszorusarok.hu/?&page=statisztika&subpage=napiosszesites&datum='. date("Ymd", strtotime($beginDate) + $d * 24 * 3600) .'">' . date("M. d", strtotime($beginDate) + $d * 24 * 3600) . '</a></td>
						<td>';
            if (isset($wreaths_full_count[date("n", strtotime($beginDate) + $d * 24 * 3600)][date("j", strtotime($beginDate) + $d * 24 * 3600)])) {
                echo '<span title="'.$wreaths_full_hint[date("n", strtotime($beginDate) + $d * 24 * 3600)][date("j", strtotime($beginDate) + $d * 24 * 3600)] .'">' . $wreaths_full_count[date("n", strtotime($beginDate) + $d * 24 * 3600)][date("j", strtotime($beginDate) + $d * 24 * 3600)] . ' db - ' . number_format($wreaths_full[date("n", strtotime($beginDate) + $d * 24 * 3600)][date("j", strtotime($beginDate) + $d * 24 * 3600)], 0, ',', ' ') . ' ft </span>';
                $sum_full += $wreaths_full[date("n", strtotime($beginDate) + $d * 24 * 3600)][date("j", strtotime($beginDate) + $d * 24 * 3600)];
            }
            echo'						
						</td>
						<td>';
            if (isset($wreaths_downprice_count[date("n", strtotime($beginDate) + $d * 24 * 3600)][date("j", strtotime($beginDate) + $d * 24 * 3600)])) {
                echo '<span title="'.$wreaths_downprice_hint[date("n", strtotime($beginDate) + $d * 24 * 3600)][date("j", strtotime($beginDate) + $d * 24 * 3600)] .'">' . $wreaths_downprice_count[date("n", strtotime($beginDate) + $d * 24 * 3600)][date("j", strtotime($beginDate) + $d * 24 * 3600)] . ' db - ' . number_format($wreaths_downprice[date("n", strtotime($beginDate) + $d * 24 * 3600)][date("j", strtotime($beginDate) + $d * 24 * 3600)], 0, ',', ' ') . ' ft </span>';
                $sum_downprice += $wreaths_downprice[date("n", strtotime($beginDate) + $d * 24 * 3600)][date("j", strtotime($beginDate) + $d * 24 * 3600)];
            }
            echo' </td>
						<td>';
            if (isset($wreaths_remainder_count[date("n", strtotime($beginDate) + $d * 24 * 3600)][date("j", strtotime($beginDate) + $d * 24 * 3600)])) {
                echo '<span title="'.$wreaths_remainder_hint[date("n", strtotime($beginDate) + $d * 24 * 3600)][date("j", strtotime($beginDate) + $d * 24 * 3600)] .'">' . $wreaths_remainder_count[date("n", strtotime($beginDate) + $d * 24 * 3600)][date("j", strtotime($beginDate) + $d * 24 * 3600)] . ' db - ' . number_format($wreaths_remainder[date("n", strtotime($beginDate) + $d * 24 * 3600)][date("j", strtotime($beginDate) + $d * 24 * 3600)], 0, ',', ' ') . ' ft </span>';
                $sum_remainder += $wreaths_remainder[date("n", strtotime($beginDate) + $d * 24 * 3600)][date("j", strtotime($beginDate) + $d * 24 * 3600)];
            }
            echo '</td>';

            /*Koszorukból befolyt összeg*/
			echo '<td>';
             if (isset($wreath_price[date("n", strtotime($beginDate) + $d * 24 * 3600)][date("j", strtotime($beginDate) + $d * 24 * 3600)])) {
                echo '<span title="'. $wreath_price_hint[date("n", strtotime($beginDate) + $d * 24 * 3600)][date("j", strtotime($beginDate) + $d * 24 * 3600)] .'">' .  number_format($wreath_price[date("n", strtotime($beginDate) + $d * 24 * 3600)][date("j", strtotime($beginDate) + $d * 24 * 3600)], 0, ',', ' ') . ' ft' . '</span>';
				$wreath_sum += $wreath_price[date("n", strtotime($beginDate) + $d * 24 * 3600)][date("j", strtotime($beginDate) + $d * 24 * 3600)];
			}else if (isset($day_sum) && $day_sum != 0) {
                echo number_format($day_sum, 0, ',', ' ') . ' ft';
				$wreath_sum += $day_sum;
            }
            echo '</td>';			


            /*Egyéb befolyt összeg*/
			echo '<td>';
			if (isset($wreath_price[date("n", strtotime($beginDate) + $d * 24 * 3600)][date("j", strtotime($beginDate) + $d * 24 * 3600)])) {    
				if (isset($other_incoming[date("n", strtotime($beginDate) + $d * 24 * 3600)][date("j", strtotime($beginDate) + $d * 24 * 3600)])) {		
					echo number_format($other_incoming[date("n", strtotime($beginDate) + $d * 24 * 3600)][date("j", strtotime($beginDate) + $d * 24 * 3600)] - ($wreath_price[date("n", strtotime($beginDate) + $d * 24 * 3600)][date("j", strtotime($beginDate) + $d * 24 * 3600)]), 0, ',', ' ') . ' ft';
				}
			}else if (isset($day_sum) && $day_sum != 0) {
				if (isset($other_incoming[date("n", strtotime($beginDate) + $d * 24 * 3600)][date("j", strtotime($beginDate) + $d * 24 * 3600)])) {		
					echo number_format($other_incoming[date("n", strtotime($beginDate) + $d * 24 * 3600)][date("j", strtotime($beginDate) + $d * 24 * 3600)] - $day_sum, 0, ',', ' ') . ' ft';
				}
			}

            echo '</td>';			

			/* Összes KIADÁS */
            echo '<td>'; 
            if (isset($other_incoming[date("n", strtotime($beginDate) + $d * 24 * 3600)][date("j", strtotime($beginDate) + $d * 24 * 3600)])) {
                echo '<a href="?&page=statisztika&subpage=napibevetel&datum='.date("Ymd", strtotime($beginDate) + $d * 24 * 3600).'" title="'. $other_incoming_hint[date("n", strtotime($beginDate) + $d * 24 * 3600)][date("j", strtotime($beginDate) + $d * 24 * 3600)] .'">' .  number_format($other_incoming[date("n", strtotime($beginDate) + $d * 24 * 3600)][date("j", strtotime($beginDate) + $d * 24 * 3600)], 0, ',', ' ') . ' ft' . '</a>';
				
                $sum += $other_incoming[date("n", strtotime($beginDate) + $d * 24 * 3600)][date("j", strtotime($beginDate) + $d * 24 * 3600)]; //$day_sum;

            }else{
				if (isset($day_sum) && $day_sum != 0) {
					echo number_format($day_sum, 0, ',', ' ') . ' ft';
					
					$sum += $day_sum;
				}
			}
            echo '</td>';
			
            echo '</tr>';

/*            if (isset($day_sum)) {
                $sum += $other_incoming[date("n", strtotime($beginDate) + $d * 24 * 3600)][date("j", strtotime($beginDate) + $d * 24 * 3600)]; //$day_sum;
            }*/

            $d++;
            $day = date("ymd", strtotime($beginDate) + $d * 24 * 3600);
        }
        echo '</table>
			</div>';			

        echo '<div class = "smallerTitle">
					<span class = "green">Összes Koszorú eladás: </span>
					<span class = "red" style="font-weight:bold;"> ' . number_format($wreath_sum, 0, ',', ' ') . ' ft</span>


					<span class = "green">Összes bevétel: </span>
						<span title="'.$names["name1"] . " - " . number_format($full_price_shop1, 0, ',', ' ') . ' ft <br />
									'. $names["name2"] . " - " .number_format($full_price_shop2, 0, ',', ' ') . ' ft <br />
									'. $names["name3"] . " - " .number_format($full_price_shop3, 0, ',', ' ') . ' ft" 
									class = "red" style="font-weight:bold;"> ' . number_format($sum, 0, ',', ' ') . ' ft</span>
				</div>';
        ?>
    </div>
    <div id="newAcquisition" style="z-index: 6; overflow-x: hidden;">
    </div>
</body>