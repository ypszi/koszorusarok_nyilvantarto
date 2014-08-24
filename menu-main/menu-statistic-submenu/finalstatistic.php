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
        <span class="firstWord">Végső </span> Összesítés
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
                            <input type="hidden" name="subpage" value="vegsoosszesites">
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
                            <input type="hidden" name="subpage" value="vegsoosszesites">
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
/*        $query = "SELECT id,create_time, price, downprice, paid, shop
		FROM orders
		WHERE ((create_time>='" . $beginDate . " 00-00-00' AND create_time<='" . $endDate . " 23-59-59') OR  
				(paid>='" . $beginDate . " 00-00-00' AND paid<='" . $endDate . " 23-59-59'))
			" . $shopsql . " AND archive = 0;";*/

        $query = "SELECT price,shop
		FROM other_incoming
		WHERE  date>='" . $beginDate . " 00-00-00' 
				AND date<='" . $endDate . " 23-59-59'" . $shopsql . " ;";
			
		$result = mysql_query($query) or die(mysql_error());

        while ($row = mysql_fetch_assoc($result)) {
            $sum[$row["shop"]] += $row["price"]; 
		}
		


        $query = "SELECT price
		FROM acquisition
		WHERE date>='" . $beginDate . " 00-00-00' 
				AND date<='" . $endDate . " 23-59-59'
			 	AND archive = 0;";

		$result = mysql_query($query) or die(mysql_error());

		$acquisition_sum =0;
        while ($row = mysql_fetch_assoc($result)) {
            $acquisition_sum += $row["price"]; 
		}

        $query = "SELECT price
		FROM outlay
		WHERE date>='" . $beginDate . " 00-00-00' 
				AND date<='" . $endDate . " 23-59-59'
			 	AND archive = 0;";

		$result = mysql_query($query) or die(mysql_error());

		$outlay_sum =0;
        while ($row = mysql_fetch_assoc($result)) {
            $outlay_sum += $row["price"]; 
		}


        echo '<div style="width: 730px;">
				<table id="statistic_table" style="width:730px;">
					<tr>
						<th>#</th>
						<th>Bevétel</th>
						<th>Beszerzés</th>
						<th>Kötlség</th>
					</tr>
				';


        $query_shops = "SELECT *
						FROM shops";
        $result_shops = mysql_query($query_shops) or die(mysql_error());

		$wreath_sum =0;
        while ($row_shops = mysql_fetch_array($result_shops)) {
            if ($row_shops["id"] % 2 != 1) {
                $color = "#ffffff";
            } else {
                $color = "#e2f1cb";
            }

			$wreath_sum += $sum[$row_shops["id"]];

			echo '<tr style="background-color:' . $color . ';">
					<td>' . $row_shops["name"] . '</td>
					<td>' . number_format($sum[$row_shops["id"]], 0, ',', ' ') . ' ft</td>
					<td></td>
					<td></td>
				</tr>';
        }
			echo '<tr>
					<td></td>
					<td style="color:#d93c76;">' . number_format($wreath_sum, 0, ',', ' ') . ' ft</td>
					<td style="color:#d93c76;">' . number_format($acquisition_sum, 0, ',', ' ') . ' ft</td>
					<td style="color:#d93c76;">' . number_format($outlay_sum, 0, ',', ' ') . ' ft</td>
				</tr>
				<tr>
					<td colspan="4"><center style="color: #fb664b; font-weight: bold; font-size:18px;">' . number_format($wreath_sum-$acquisition_sum-$outlay_sum, 0, ',', ' ') . ' ft</center></td>					
				</tr>';

        echo '</table>
			</div>';			
?>
    </div>
    <div id="newAcquisition" style="z-index: 6; overflow-x: hidden;">
    </div>
</body>