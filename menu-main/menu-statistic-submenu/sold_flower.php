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
<body>
    <div class="title">
        <span class="firstWord">Eladott </span> Koszorú Alapok, Virágok

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
                        ?> 				<td>
                            <input type="hidden" name="page" value="statisztika">
                            <input type="hidden" name="subpage" value="eladas">
                        </td>
                        <td><input type="hidden" name="allchecked" value="1"></td>
                        <td><input type="checkbox" name="shop1" class = "shopCheck" <?php echo $shop1; ?> ><?php echo $names["name1"]; ?> bolt</td>
                        <td><input type="checkbox" name="shop2" class = "shopCheck" <?php echo $shop2; ?> ><?php echo $names["name2"]; ?> bolt</td>
                        <td><input type="checkbox" name="shop3" class = "shopCheck" <?php echo $shop3; ?> ><?php echo $names["name3"]; ?> bolt</td>

                        <td><button type="submit" class = "button" id = "filter">Szűrés</button></td>
                    </tr>
                </table>
            </form>
        </div>	


        <?php
        $query = "SELECT *
		FROM orders
		WHERE ritual_time>='" . $beginDate . " 00-00-00' AND ritual_time<='" . $endDate . " 23-59-59' AND archive=0;";

        $result = mysql_query($query) or die(mysql_error());

        while ($row = mysql_fetch_assoc($result)) {
            $query_wreaths = "SELECT *
						FROM order_items
						WHERE order_id='" . $row["id"] . "' AND is_offer=0";

            $result_wreaths = mysql_query($query_wreaths) or die(mysql_error());

            while ($row_wreaths = mysql_fetch_array($result_wreaths)) {
                $query_wreath = "SELECT special_wreath.picture, special_wreath.id,special_wreath.fancy, special_wreath.name, special_wreath.note, special_wreath.calculate_price, special_wreath.sale_price, base_wreath.price, base_wreath.size, base_wreath.note AS base_wreath_note, base_wreath.id AS base_wreath_id
							FROM special_wreath,base_wreath
							WHERE special_wreath.base_wreath_id=base_wreath.id AND special_wreath.name='" . $row_wreaths["wreath_name"] . "'";

                $result_wreath = mysql_query($query_wreath) or die(mysql_error());

                while ($row_wreath = mysql_fetch_array($result_wreath)) {
					$wreath_price[$row_wreath["base_wreath_id"]] += $row_wreath["sale_price"];
                    $wreaths[$row_wreath["base_wreath_id"]] ++;

                    $query_flowers = "	SELECT conect_flower_special_wreath.id_flower, conect_flower_special_wreath.priece 
										FROM `conect_flower_special_wreath`
										WHERE conect_flower_special_wreath.special_wreath_id = '" . $row_wreath['id'] . "';";

                    $result_flowers = mysql_query($query_flowers) or die(mysql_error());

                    while ($row_flower = mysql_fetch_array($result_flowers)) {
                        $flowers[$row_flower["id_flower"]] += $row_flower["priece"];
                    }
                }
            }

            $query_wreaths = "SELECT *
						FROM order_items
						WHERE order_id='" . $row["id"] . "' AND is_offer=1";

            $result_wreaths = mysql_query($query_wreaths) or die(mysql_error());

            while ($row_wreaths = mysql_fetch_array($result_wreaths)) {
                $query_wreath = "SELECT offer_wreath.id, offer_wreath.name, offer_wreath.note, offer_wreath.calculate_price, offer_wreath.sale_price, base_wreath.price, base_wreath.size, base_wreath.note AS base_wreath_note, base_wreath.id AS base_wreath_id
		FROM offer_wreath,base_wreath
		WHERE offer_wreath.base_wreath_id=base_wreath.id AND offer_wreath.name='" . $row_wreaths["wreath_name"] . "'";

                $result_wreath = mysql_query($query_wreath) or die(mysql_error());

                while ($row_wreath = mysql_fetch_array($result_wreath)) {
					$wreath_price[$row_wreath["base_wreath_id"]] += $row_wreath["sale_price"];
                    $wreaths[$row_wreath["base_wreath_id"]] ++;

                    $query_flowers = "	SELECT conect_flower_offer_wreath.id_flower, conect_flower_offer_wreath.priece
						FROM `conect_flower_offer_wreath`
						WHERE conect_flower_offer_wreath.offer_wreath_id = '" . $row_wreath['id'] . "';";

                    $result_flowers = mysql_query($query_flowers) or die(mysql_error());

                    while ($row_flower = mysql_fetch_array($result_flowers)) {
                        $flowers[$row_flower["id_flower"]] += $row_flower["priece"];
                    }
                }
            }
        }

        $query = "SELECT base_wreath_type.type, base_wreath.id, base_wreath.size
				FROM base_wreath, base_wreath_type
				WHERE base_wreath_type.id=base_wreath.type
                ORDER BY base_wreath_type.type ASC;";

        $result = mysql_query($query) or die(mysql_error());

        echo '<span style="font: normal 14px/16px Arial; color: #d93c76;">Koszorú alapok</span>
			<div style="width: 720px; padding: 15px; border-bottom: dotted 1px #cb361b;">
				<table>';

		$sum = 0;
        $d = 0;
        while ($row = mysql_fetch_assoc($result)) {
            if (isset($wreaths[$row["id"]])) {
                if ($d % 2 != 0) {
                    $color = "#ffffff";
                } else {
                    $color = "#e2f1cb";
                }

                echo '<tr style="background-color:' . $color . ';">
					<td style="padding: 5px;" width="250px">' . $row["type"] . '</td>
					<td style="padding: 5px;" width="200px">' . $row["size"] . '</td>
					<td style="padding: 5px; text-align: right;" width="100px">' . $wreaths[$row["id"]] . ' db</td> 
					<td style="padding: 5px; text-align: right;" width="200px">' . number_format($wreath_price[$row["id"]], 0, ',', ' ') . ' ft</td>					
				</tr>';
				$sum += $wreath_price[$row["id"]];
                $d++;
            }
        }
		
                echo '<tr>
					<td width="250px"></td>
					<td width="200px"></td>
					<td width="100px" style="color:#d93c76; padding:10px 0 10px 0; text-align: right;">Végösszeg:</td> 
					<td width="200px" style="color:#d93c76; padding:10px 0 10px 0; text-align: right;">' . number_format($sum, 0, ',', ' ') . ' ft</td>					
				</tr>';
		
        echo '</table>
			</div>';

        $query = "SELECT *
				FROM flower;";

        $result = mysql_query($query) or die(mysql_error());

        echo '<span style="font: normal 14px/16px Arial; color: #d93c76;">Virágok</span>
		<div style="width: 720px; padding: 15px;">
				<table>';

        $d = 0;
        while ($row = mysql_fetch_assoc($result)) {
            if (isset($flowers[$row["id"]])) {
                if ($d % 2 != 0) {
                    $color = "#ffffff";
                } else {
                    $color = "#e2f1cb";
                }

                echo '<tr style="background-color:' . $color . ';">
						<td style="padding: 5px;" width="250px">' . $row["type"] . '</td>
						<td style="padding: 5px;" width="200px">' . $row["color"] . '</td>
						<td style="padding: 5px; text-align: right;" width="350px">' . $flowers[$row["id"]] . ' db</td>
					</tr>';
                $d++;
            }
        }
        echo '</table>
			</div>';
        ?>
    </div>
</body>