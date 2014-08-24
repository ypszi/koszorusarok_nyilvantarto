<?php //én írtam! ?>
<!-- ---------------------------- Datepicker ---------------------------- -->
	<link rel="stylesheet" href="css/calendar/default.css" type="text/css">
	<script type="text/javascript" src="js/zebra_datepicker.js"></script>
	<script type="text/javascript" src="js/zebra_datepicker.src.js"></script>

	<link href="js/file_upload/uploadfile.css" rel="stylesheet">
	<script src="js/file_upload/jquery.uploadfile.min.js"></script>

	<script type="text/javascript">
		$(document).ready(function() {
			$('input.datepicker').Zebra_DatePicker();
			$("#fileuploader").uploadFile({
				url: "menu-main/menu-acquisition-submenu/shoppingcart/import_excel.php",
				allowedTypes: "xls,XLS",
				autoSubmit: true,
				dragDrop: false,
				multiple: false,
				showStatusAfterSuccess: false,
				fileName: "xls_upload",
				onSuccess:function(files,data,xhr)
				{
					document.getElementById('alertwindow').innerHTML += '<h1>Bevásárló lista sikeresen frissítve!</h1>';
					document.getElementById('alertwindow').style.display = 'block';
					setTimeout('window.location.href="../../../index.php?page=beszerzes&subpage=bevasarlolista"', 1500);
				}
			});
		});
	</script>
	<link href="css/style.css" rel="stylesheet" type="text/css" media="all"/>
	<link href="css/alertwindow.css" rel="stylesheet" type="text/css" media="all">
		
<style type="text/css">
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

	#newShopping_list {
		overflow-y: auto;
		height: 87%;
		position: absolute;
		width: 720px;
		left: 23%;
		top: 5%;
	}

	#shopping_list th {
		padding: 5px;
	}

	.exit {
		right: 0px;
		top: 0px;
	}
	
</style>

	<div id="alertwindow"></div>

	<div id="newShopping_list"></div>

	<div class="title">
	<span class="firstWord">Bevásárló </span> Lista
	
<div>
	<form id = "selectForm" method="GET">
		<table id = "selectFormTable">
			<tr>
<?php
				$bd = date("Y-m-d");
					
				$beginDate = isset($_GET['min_date']) ? $_GET['min_date'] : date("Y-m-01",strtotime($bd)-(30*24*3600));
				$endDate = isset($_GET['max_date']) ? $_GET['max_date'] : date("Y-m-d",strtotime($bd)+(14*24*3600));
		
		echo   '<td><CENTER><input type="text" name="min_date" id="min_date" class="datepicker borderedStyle" value="' . $beginDate . '"></CENTER></td>
				<td><CENTER> - </CENTER></td>
				<td><CENTER><input type="text" name="max_date" id="max_date" class="datepicker borderedStyle" value="' . $endDate . '"></CENTER></td>';
?>
				<td><input type="hidden" name="page" value="beszerzes"><input type="hidden" name="subpage" value="bevasarlolista"></td>
				<td><button type="submit" class = "button" id = "filter">Szűrés</button></td>
				<td><button class = "button" type="button" id = "newButton" onClick="newShoppingCart();">Új Bevásárló lista</button></td>
				<td><div id="fileuploader">Feltöltés</div></td>
			</tr>
		</table>
	</form>
</div>

<?php
		function myday($d){
			switch ($d){
				case 1: 
					return "Hétfő";
					break;
				case 2: 
					return "Kedd";
					break;
				case 3: 
					return "Szerda";
					break;
				case 4: 
					return "Csütörtök";
					break;
				case 5: 
					return "Péntek";
					break;
				case 6: 
					return "Szombat";
					break;
				case 7: 
					return "Vasárnap";
					break;
			}			
		}
		
		function mymonth($m){
			switch ($m){
				case 1: 
					return "Január";
					break;
				case 2: 
					return "Február";
					break;
				case 3: 
					return "Március";
					break;
				case 4: 
					return "Április";
					break;
				case 5: 
					return "Május";
					break;
				case 6: 
					return "Június";
					break;
				case 7: 
					return "Július";
					break;
				case 8: 
					return "Augusztus";
					break;
				case 9: 
					return "Szeptember";
					break;
				case 10: 
					return "Október";
					break;
				case 11: 
					return "November";
					break;
				case 12: 
					return "December";
					break;
			}			
		}	
	
		$query_items="SELECT shopping_cart_id, count(id) AS db
				FROM shopping_cart_item
				WHERE archive=0
				GROUP BY shopping_cart_id;";

		$result_items = mysql_query($query_items) or die (mysql_error());
		while ($row_items = mysql_fetch_assoc($result_items)) {
			$scl_db[$row_items["shopping_cart_id"]] = $row_items["db"];
		}
		

		$query="SELECT *
				FROM shopping_cart
				WHERE date BETWEEN '".$beginDate."' AND '".$endDate."'
				ORDER BY name DESC;";
		$result = mysql_query($query) or die (mysql_error());

		echo '
			<div style="width: 840px; padding: 15px;">
				<table id="statistic_table">';
				echo '<tr>
						<th width="200px">Bevásárló lista</th>
						<th width="340px">Megjegyzés</th>
						<th width="80px">Tételek</th>
						<th width="80px"></th>
						<th width="80px"></th>
					</tr>';

					$d=0;
					while ($row = mysql_fetch_assoc($result)) {
						if ($d % 2 != 0) {
							$color = "#ffffff";
						} else {
							$color = "#e2f1cb";
						}
						echo '<tr style="background-color:' . $color . ';">
								<td style="vertical-align:middle;"><a href="#" onClick="ShoppingCartList(' . $row["id"] . ');">' . date("Y. ",strtotime($row["name"])) .  mymonth(date("m",strtotime($row["name"]))) . date(" d, ",strtotime($row["name"])) . myday(date("N",strtotime($row["name"]))) .'</a></td>
								<td style="vertical-align:middle;">' . $row["note"] . '</td>
								<td style="vertical-align:middle;">'; 
									if (isset($scl_db[$row["id"]])){
										echo $scl_db[$row["id"]] . ' db';
									}else{
										echo '0 db';
									}
						echo '</td>
								<td><a href="/menu-main/menu-acquisition-submenu/shoppingcart/printshoppingcart.php?id='. $row["id"] .'" target="blank">
								<input type="submit" name="excel_shopping_list" value="" style="background-image:url('.$conf_path_abs.'img/icons/BigPrint-icon.png); background-repeat:no-repeat; width:64px; height:64px; vertical-align: middle; padding-bottom:10px;"  id="print_offer" title="Nyomtatás"/>								
								</a></td>
								<td>
								<input type="submit" onClick="downloadShoppingCart_xls('.$row["id"].');" name="excel_shopping_list" value="" style="background-image:url('.$conf_path_abs.'img/icons/Excel-icon.png); background-repeat:no-repeat; width:64px; height:64px; vertical-align: middle; padding-bottom:10px;"  id="print_offer" title="Excel"/>								
								</td>
								<td>
								<input type="submit" onClick="deleteShoppingList('.$row["id"].');" value="" style="background-image:url('.$conf_path_abs.'/img/icons/BigDelete-icon.png); background-repeat:no-repeat; width:64px; height:64px; vertical-align: middle; padding-bottom:10px;"  id="print_offer" title="Törlés"/>								
								</td>
							</tr>';
						$d++;
					}
		echo '</table>
			</div>';
		

?>
</div>

<!-- 
<input type="submit" onClick="uploadShoppingCart_xls(this);" style="background-image:url('.$conf_path_abs.'img/icons/ExcelUpload-icon.png); background-repeat:no-repeat; width:64px; height:64px; vertical-align: middle; padding-bottom:10px;"  id="print_offer" title="Excel Upload"/>
<input type="file" onChange="" name="excel_shopping_list" value="" style="display: none;"  id="print_offer" title="Excel Upload"/>								
 -->