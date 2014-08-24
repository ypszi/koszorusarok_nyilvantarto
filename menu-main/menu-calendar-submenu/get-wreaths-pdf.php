<?php
	include '../../pdf-generator/fpdf.php';

	$con = new mysqli('localhost', 'koszor01_user', 'Petrik2012', 'koszor01_protea');
	$con->set_charset('utf8_hungarian_ci');
	$con->query('SET CHARACTER SET latin2;');

	function create_time($t){
		if ($t % 2 == 0){
			return (6+$t/2) . ':00';
		}else{
			return (5.5+$t/2) . ':30';
		}
	}
	
	function myday($d){
		switch ($d){
			case 1: 
				return "Hétfõ";
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

	class PdfWithHeaderAndFooter extends FPDF
	{
		function Header() 	// Page header
		{
		}

		function Footer() 	// Page footer
		{
			$this->SetY(-15); 		// Position at 1.5 cm from bottom
			$this->SetFont('Arial','I',8); 		// Arial italic 8
			$this->SetTextColor(137,165,146);     // Text color in gray

			$this->Cell(0,0,'oldal '.$this->PageNo().'/{nb}',0,0,'C'); 		// Page number
			
			$this->Cell(-41,0,'Nyomtatás:',0,0,'R');
			$this->Cell(-47,0,date("Y. F. d. H:i:s"),0,0,'L');
		}
	}

	$pdf = new PdfWithHeaderAndFooter('P','mm','A4');  //Fekvõ A4 mm mért PDF fájl
	$pdf->SetTitle('rendeles.pdf',0);
	$pdf->SetAuthor('Protea Csoport',0);
	$pdf->AliasNbPages();	//Lapokszámának beállítása
	$pdf->AddPage();		//Új oldal hozzáadása
	$pdf->Ln(3);
	
	$pdf->SetFont('Arial','',14); 		// Arial bold 15
	$pdf->SetTextColor(216,60,118);     // Text color in gray
	
	$mydate = date("Y",strtotime($_GET["day"])) . " " . mymonth(date("n",strtotime($_GET["day"]))) . " " . date("d",strtotime($_GET["day"])) . ", " . myday(date("N",strtotime($_GET["day"])));

	$query = "SELECT * 
	FROM shops 
	WHERE enable = 1;";

	$result = $con->query($query);
	while ($row = mysqli_fetch_array($result)) {
		$shop[$row["id"]] = $row["name"];
	}
	
	$pdf->Cell(0,0,'~ '.$mydate.' ~',0,1,'C'); 		// Title	
	$pdf->Ln(6);
	$pdf->SetTextColor(98,127,107);
	$pdf->Cell(0,0,$shop[$_GET["shop"]],0,1,'C'); 		// Title	

	$pdf->Ln(3);

	$pdf->SetFont('Arial','',9);
	$pdf->SetTextColor(98,127,107);
	$pdf->Cell(14,6,'Készítés',0,0,'R');
	$pdf->Cell(14,6,'Temetés',0,1,'R');			


	
			
	if (isset($_GET["day"]) && isset($_GET['shop'])){
		$query = "SELECT *
		FROM ribbon_type;";

		$result = $con->query($query);

		while ($row = mysqli_fetch_array($result)) {
			$ribbon_type[$row["type"]]= $row["price"];
		}

		$query = "SELECT *
		FROM ribbon_color;";

		$result = $con->query($query);

		while ($row = mysqli_fetch_array($result)) {
			$ribbon_color[$row["color"]]= $row["price"];
		}

		
		$query_dead = "SELECT *
		FROM orders  
		WHERE DATE(orders.ritual_time)='".date("Y-m-d",strtotime($_GET["day"]))."' AND orders.maker_shop=".$_GET["shop"]." AND archive=0 
		GROUP BY deadname 
		ORDER BY orders.ritual_time ASC;";
		
		$result_dead = $con->query($query_dead);						

		while ($row_dead = mysqli_fetch_array($result_dead)) {
			$ind = 1;
			
			if (isset($row_dead["deadname"]) && $row_dead["deadname"]!= ""){
				$pdf->SetX(38);
				$pdf->SetFont('Arial','B',11);
				$pdf->SetTextColor(0,0,0);
				$pdf->Cell(40,6,'† '.$row_dead["deadname"],0,0,'L');
				$pdf->ln(6);
			}else{
				$pdf->SetX(38);
				$pdf->SetFont('Arial','B',11);
				$pdf->SetTextColor(0,0,0);
				$pdf->Cell(40,6,$row_dead["customer_name"],0,0,'L');
				$pdf->ln(6);			
			}

			$query = "SELECT *
			FROM orders  
			WHERE DATE(orders.ritual_time)='".date("Y-m-d",strtotime($_GET["day"]))."' AND orders.maker_shop=".$_GET["shop"]." AND deadname='".$row_dead['deadname']."' AND archive=0 
			ORDER BY orders.ritual_time ASC;";
			
			$result = $con->query($query);						

			while ($row = mysqli_fetch_array($result)) {	
				$pdf->SetFont('Arial','',10);
				$pdf->SetTextColor(0,0,0);

				if (isset($row["shipment"]) && $row["shipment"] == "Erzsébeti temetõ"){
					$pdf->Cell(14,6,date("H:i",strtotime($row["ritual_time"])-(45*60)),0,0,'C');
				}elseif (isset($row["shipment"]) && $row["shipment"] == "Nem kér kiszállítást"){
					$pdf->Cell(14,6,date("H:i",strtotime($row["ritual_time"])-(15*60)),0,0,'C');
				}elseif (isset($row["shipment"]) && $row["shipment"] == "Egyedi helyszín"){
					$pdf->Cell(14,6,date("H:i",strtotime($row["ritual_time"])-(2*60*60)),0,0,'C');
				}

				$pdf->Cell(14,6,date("H:i",strtotime($row["ritual_time"])),0,0,'C');
				
				$pdf->SetX(38);
				$pdf->SetFont('Arial','',9);
				$pdf->SetTextColor(216,60,118);
				$pdf->Cell(20,6,'Megrendelõ:',0,0,'L');
				$pdf->SetFont('Arial','',10);
				$pdf->SetTextColor(0,0,0);
				$pdf->Cell(40,6,$row["customer_name"],0,0,'L');

				$pdf->SetFont('Arial','',9);
				$pdf->SetTextColor(216,60,118);
				$pdf->Cell(20,6,'Helyszín:',0,0,'R');
				$pdf->SetFont('Arial','',10);
				$pdf->SetTextColor(0,0,0);
				$pdf->Cell(30,6,$row["shipment"],0,0,'L');
				
				if (isset($row["shipment"]) && $row["shipment"] == "Egyedi helyszín"){
					$pdf->ln();
					$pdf->SetFont('Arial','B',11);
					$pdf->SetTextColor(216,60,118);
					$pdf->Cell(28,4,'Kiszállítás',0,0,'C');
					
					if (isset($row['clocation']) && $row['clocation'] != "") {
						$pdf->SetX(38);
						$pdf->SetFont('Arial','',9);
						$pdf->SetTextColor(216,60,118);
						$pdf->Cell(20,4,'Cím:',0,0,'R');
						$pdf->SetFont('Arial','',10);
						$pdf->SetTextColor(0,0,0);
						$pdf->Cell(100,4,$row["clocation"].', '.$row["caddress"],0,0,'L');
					}
					if (isset($row['cfuneral']) && $row['cfuneral'] != "") {
						$pdf->SetFont('Arial','',9);
						$pdf->SetTextColor(216,60,118);
						$pdf->Cell(20,4,'Terem:',0,0,'R');
						$pdf->SetFont('Arial','',10);
						$pdf->SetTextColor(0,0,0);
						$pdf->Cell(40,4,$row["cfuneral"],0,0,'L');
					}
				}

				if (isset($row['downprice']) && !isset($row["paid"])){
					$pdf->ln();
					$pdf->SetFont('Arial','B',10);
					$pdf->SetTextColor(216,60,118);
					$pdf->Cell(28,4,'Hátralék',0,1,'C');
					$pdf->SetFont('Arial','BI',12);
					$pdf->Cell(28,4,number_format(($row["price"]-$row['downprice']), 0, '', ' ').' Ft',0,0,'C');
					$pdf->ln(-10);					
				}
				
				if (isset($row['note']) && $row['note'] != "") {
					$pdf->Ln(6);
					$pdf->SetX(38);
					$pdf->SetFont('Arial','',9);
					$pdf->SetTextColor(216,60,118);
					$pdf->Cell(20,4,'Megjegyzés:',0,0,'R');
					$pdf->SetFont('Arial','',10);
					$pdf->SetTextColor(0,0,0);
					$pdf->MultiCell(140,4,$row["note"],0,'L');
					$pdf->Ln(-6.5);
				}

				$query_wreaths = "SELECT COUNT(id) AS cid
							FROM order_items
							WHERE order_id='".$row["id"]."' AND is_offer=0";						

				$result_wreaths = $con->query($query_wreaths);
				$row_wreaths = $result_wreaths->fetch_assoc();
				$wreath_special_db =  $row_wreaths["cid"];

				if ($wreath_special_db  > 0){
					$pdf->Ln(8);
				}

				$query_wreaths = "SELECT *
							FROM order_items
							WHERE order_id='".$row["id"]."' AND is_offer=0";						

				$result_wreaths = $con->query($query_wreaths);

				while ($row_wreaths = mysqli_fetch_array($result_wreaths)) {
					$query_wreath = "SELECT special_wreath.picture, special_wreath.id,special_wreath.fancy, special_wreath.name, special_wreath.note, special_wreath.calculate_price, special_wreath.sale_price, base_wreath.price, base_wreath.size, base_wreath.note AS base_wreath_note
					FROM special_wreath,base_wreath
					WHERE special_wreath.base_wreath_id=base_wreath.id AND special_wreath.name='".$row_wreaths["wreath_name"]."'";
											
					$result_wreath = $con->query($query_wreath);

					while ($row_wreath = mysqli_fetch_array($result_wreath)) {
				
						$pdf->SetFont('Arial','',9);
						$pdf->SetTextColor(98,127,107);
						$pdf->SetX(38);
						$pdf->Cell(20,6,''.$ind.'. Koszorú:',0,0,'R');
						$pdf->SetFont('Arial','',10);
						$pdf->SetTextColor(0,0,0);
						$pdf->Cell(14,6,'#'.$row_wreaths["azonosito"],0,0,'L');

						$pdf->Cell(50,6,'- '.$row_wreath["name"] . " " . $row_wreath["fancy"],0,0,'L');

						$pdf->SetFont('Arial','',9); 		
						$pdf->SetTextColor(98,127,107);
						$pdf->Cell(24,4,'Alap:',0,0,'R');
						$pdf->SetFont('Arial','',10); 		
						$pdf->SetTextColor(0,0,0);
						$pdf->MultiCell(54,4,$row_wreath["size"].','.$row_wreath["base_wreath_note"],0,'L');
						$pdf->ln(1);

						$size = getimagesize('../../img/wreath/'.trim($row_wreath["picture"],"|"));
						if (($size[0]/$size[1]) < 1){
							$pdf->Image('../../img/wreath/'.trim($row_wreath["picture"],"|"),168,$pdf->GetY()+2,0,28); 		// Kep
						}else{
							$pdf->Image('../../img/wreath/'.trim($row_wreath["picture"],"|"),168,$pdf->GetY()+2,28,0); 		// Kep					
						}
						if (isset($row_wreath["note"]) && $row_wreath["note"]!=""){
							$pdf->ln(1.5);
							$pdf->Cell(24,0,'',0,0,'L');
							$pdf->SetTextColor(50,50,50);
							$pdf->SetFont('Arial','I',10);
							$pdf->SetX(58);
							$pdf->MultiCell(108,4,$row_wreath["note"],0,'L');
							$pdf->ln(1.5);
						}
																	
						$query_wreath = "SELECT special_wreath.picture, special_wreath.id,special_wreath.fancy, special_wreath.name, special_wreath.note, special_wreath.calculate_price, special_wreath.sale_price, base_wreath.price, base_wreath.size, base_wreath.note AS base_wreath_note
									FROM special_wreath,base_wreath
									WHERE special_wreath.base_wreath_id=base_wreath.id AND special_wreath.name='".$row_wreaths["wreath_name"]."'";
						
						$result_wreath = $con->query($query_wreath);

						while ($row_wreath = mysqli_fetch_array($result_wreath)) {
							$pdf->SetTextColor(98,127,107);
							$pdf->SetFont('Arial','',9); 		
							$pdf->SetX(38);
							$pdf->Cell(20,6,'Összetevõk:',0,1,'R');
							$pdf->SetTextColor(0,0,0);

							$query_flowers = "	SELECT flower.type, flower.color, flower.price ,conect_flower_special_wreath.priece 
												FROM `conect_flower_special_wreath`,`flower` 
												WHERE conect_flower_special_wreath.special_wreath_id = '".$row_wreath['id']."' AND conect_flower_special_wreath.id_flower = flower.id
												ORDER BY flower.leaf ASC, conect_flower_special_wreath.priece DESC;";
						
							$result_flowers = $con->query($query_flowers);					
							$pdf->ln(-6.0);

							$pdf->SetFont('Arial','',10);		
							while ($row_flower = mysqli_fetch_array($result_flowers)) {
								$pdf->SetX(38);
								$pdf->Cell(20,6,'',0,0,'R');
								$pdf->Cell(25,6,substr($row_flower["type"],0,12),0,0,'L');
								$pdf->Cell(32,6,$row_flower["color"],0,0,'L');
//								$pdf->Cell(15,6,$row_flower["priece"]. ' db',0,0,'L');
								$pdf->Cell(15,6, round($row_flower["priece"],0) . ' db',0,0,'L');

								$pdf->ln(4.0);
							}
							$pdf->ln(3.5);
							
							$price=$row_wreath["sale_price"];						
						}					

						if ($row_wreaths['ribbon_id'] != "") {
							$query_ribbid = "SELECT * FROM  `ribbons` WHERE id='".$row_wreaths['ribbon_id']."';";
							$result_ribbid = $con->query($query_ribbid);
							while ($row_ribbid = mysqli_fetch_assoc($result_ribbid)) {
								$offer_ribbon_tpye = $row_ribbid['ribbon'];
								$offer_ribbon_color = $row_ribbid['ribboncolor'];

								$pdf->SetTextColor(98,127,107);
								$pdf->SetFont('Arial','',9);
								$pdf->Cell(24,4,'Szalag:',0,0,'R');
								$pdf->SetTextColor(0,0,0);
								$pdf->SetFont('Arial','',10);
								$pdf->Cell(38,4,$row_ribbid["ribbon"],0,0,'L');
								if ($row_ribbid["farewelltext"] != "SZ0 - Egyedi búcsúszöveg"){
									$pdf->SetTextColor(98,127,107);
									$pdf->SetFont('Arial','',9);
									$pdf->Cell(34,4,'Egyik oldal:',0,0,'R');
									$pdf->SetTextColor(0,0,0);
									$pdf->SetFont('Arial','',10);
									$pdf->MultiCell(61,4,substr($row_ribbid["farewelltext"], strpos($row_ribbid["farewelltext"],"-")+2),0,'L');
									$pdf->SetTextColor(98,127,107);
									$pdf->SetFont('Arial','',9);
									$pdf->Cell(24,4,'Szín:',0,0,'R');
									$pdf->SetTextColor(0,0,0);
									$pdf->SetFont('Arial','',10);
									$pdf->Cell(38,4,$row_ribbid["ribboncolor"],0,0,'L');
									$pdf->SetTextColor(98,127,107);
									$pdf->SetFont('Arial','',9);
									$pdf->Cell(34,4,'Másik oldal:',0,0,'R');
									$pdf->SetTextColor(0,0,0);
									$pdf->SetFont('Arial','',10);
									$pdf->MultiCell(61,4,$row_ribbid["givers"],0,'L');
								}else{
									$pdf->SetTextColor(98,127,107);
									$pdf->SetFont('Arial','',9);
									$pdf->Cell(34,4,'Egyik oldal:',0,0,'R');
									$pdf->SetTextColor(0,0,0);
									$pdf->SetFont('Arial','',10);
									$pdf->MultiCell(61,4,substr($row_ribbid["givers"], 0, strpos($row_ribbid["givers"],"/")),0,'L');
									$pdf->SetTextColor(98,127,107);
									$pdf->SetFont('Arial','',9);
									$pdf->Cell(24,4,'Szín:',0,0,'R');
									$pdf->SetTextColor(0,0,0);
									$pdf->SetFont('Arial','',10);
									$pdf->Cell(38,4,$row_ribbid["ribboncolor"],0,0,'L');
									$pdf->SetTextColor(98,127,107);
									$pdf->SetFont('Arial','',9);
									$pdf->Cell(34,4,'Másik oldal:',0,0,'R');
									$pdf->SetTextColor(0,0,0);
									$pdf->SetFont('Arial','',10);
									$pdf->MultiCell(61,4,substr($row_ribbid["givers"], strpos($row_ribbid["givers"],"/")+1),0,'L');							
								}
							}
						}else{
							$pdf->SetX(38);
							$pdf->SetTextColor(98,127,107);
							$pdf->SetFont('Arial','',9);
							$pdf->Cell(20,4,'Szalag:',0,0,'R');
							$pdf->SetTextColor(0,0,0);
							$pdf->SetFont('Arial','',10);
							$pdf->Cell(34,4,'Szalag nélkül kérték!',0,1,'L');
						}					
						
						
						$pdf->SetDrawColor(107,107,107);
						$pdf->Rect(11,$pdf->GetY(),188,0.1);
						$pdf->SetDrawColor(0,0,0);
						$pdf->ln(2);
					}
					$ind++;
				}

				$query_wreaths = "SELECT COUNT(id) AS cid
							FROM order_items
							WHERE order_id='".$row["id"]."' AND is_offer=1";						

				$result_wreaths = $con->query($query_wreaths);
				$row_wreaths = $result_wreaths->fetch_assoc();
				$wreath_offer_db =  $row_wreaths["cid"];

				if ($wreath_offer_db  > 0){
					$pdf->Ln(8);
				}

				$query_wreaths = "SELECT *
				FROM order_items
				WHERE order_id='".$row["id"]."' AND is_offer=1";
							
				$result_wreaths = $con->query($query_wreaths);

				while ($row_wreaths = mysqli_fetch_array($result_wreaths)) {

					$query_wreath = "SELECT offer_wreath.left_for_us, offer_wreath.id, offer_wreath.name, offer_wreath.note, offer_wreath.calculate_price, offer_wreath.sale_price, base_wreath.price, base_wreath.size, base_wreath.note AS base_wreath_note
					FROM offer_wreath,base_wreath
					WHERE offer_wreath.base_wreath_id=base_wreath.id AND offer_wreath.name='".$row_wreaths["wreath_name"]."'";
		
					$result_wreath = $con->query($query_wreath);

					while ($row_wreath = mysqli_fetch_array($result_wreath)) {
						$pdf->SetX(38);
						$pdf->SetFont('Arial','',9);
						$pdf->SetTextColor(98,127,107);
						$pdf->Cell(20,4,''.$ind.'. Koszorú:',0,0,'R');
						$pdf->SetFont('Arial','',10);
						$pdf->SetTextColor(0,0,0);
						$pdf->Cell(20,4,'#'.$row_wreaths["azonosito"],0,0,'L');

						$pdf->Cell(40,4,'- '.$row_wreath["name"],0,0,'L');

						$pdf->SetFont('Arial','',9); 		
						$pdf->SetTextColor(98,127,107);
						$pdf->Cell(20,4,'Alap:',0,0,'R');
						$pdf->SetFont('Arial','',10); 		
						$pdf->SetTextColor(0,0,0);
						$pdf->MultiCell(66,4,$row_wreath["size"].','.$row_wreath["base_wreath_note"],0,'L');	

						if (isset($row_wreath["note"]) && $row_wreath["note"]!=""){
							$pdf->ln(1.5);
							$pdf->SetX(38);
							$pdf->Cell(20,0,'',0,0,'L');
							$pdf->SetTextColor(50,50,50);
							$pdf->SetFont('Arial','I',10);
							$pdf->MultiCell(140,4,$row_wreath["note"],0,'L');
							$pdf->ln(1.5);
						}

						$pdf->SetX(38);
						$pdf->SetTextColor(98,127,107);
						$pdf->SetFont('Arial','',9); 		
						$pdf->Cell(20,6,'Összetevõk:',0,1,'R');
						$pdf->SetTextColor(0,0,0);




					$offer_ribbon_tpye = "";
					$offer_ribbon_color = "";

					if ($row_wreaths['ribbon_id'] != "") {
						$query_ribbid = "SELECT * FROM  `ribbons` WHERE id='".$row_wreaths['ribbon_id']."';";
						$result_ribbid = $con->query($query_ribbid);
						while ($row_ribbid = mysqli_fetch_assoc($result_ribbid)) {
							$offer_ribbon_tpye = $row_ribbid['ribbon'];
							$offer_ribbon_color = $row_ribbid['ribboncolor'];
						}
					}
				
					$ribbonprice = 0;
					if ($offer_ribbon_tpye != "") {						
						$ribbonprice = $ribbon_type[$offer_ribbon_tpye]+$ribbon_color[$offer_ribbon_color];
					}


					if (isset($row_wreath["left_for_us"]) &&  $row_wreath["left_for_us"] == 1){
						$pdf->ln(-6.0);
						$pdf->SetX(38);

						$pdf->SetFont('Arial','B',10); 		
						$pdf->Cell(20,6,'',0,0,'R');
						$pdf->Cell(25,6,"Koszorú kötõre bízva az összeállítás, " . ($row_wreath[sale_price] - $row_wreath[price] - $ribbonprice) . " ft értékben tartalmazhat virágot.",0,1,'L');
					}else{
						$query_flowers = "	SELECT flower.type, flower.color, flower.price ,conect_flower_offer_wreath.priece 
											FROM `conect_flower_offer_wreath`,`flower` 
											WHERE conect_flower_offer_wreath.offer_wreath_id = '".$row_wreath['id']."' AND conect_flower_offer_wreath.id_flower = flower.id
											ORDER BY flower.leaf ASC, flower.type ASC;";

						$result_flowers = $con->query($query_flowers);

						$pdf->ln(-6.0);
						$pdf->SetX(38);
						$pdf->SetFont('Arial','',10);		
						while ($row_flower = mysqli_fetch_array($result_flowers)) {
							$pdf->SetX(38);
							$pdf->Cell(20,6,'',0,0,'R');
							$pdf->Cell(25,6,substr($row_flower["type"],0,12),0,0,'L');
							$pdf->Cell(32,6,$row_flower["color"],0,0,'L');

							if (($row_flower["priece"] * 100) % 100  == 0 ){
								$pdf->Cell(15,6, round($row_flower["priece"],0) . ' db',0,0,'R');
							}else{
								$pdf->Cell(15,6, $row_flower["priece"] . ' db',0,0,'R');
							}

							$pdf->ln(4.0);
						}
						$pdf->ln(3.5);
					}




/*
						$query_flowers = "	SELECT flower.type, flower.color, flower.price ,conect_flower_offer_wreath.priece 
											FROM `conect_flower_offer_wreath`,`flower` 
											WHERE conect_flower_offer_wreath.offer_wreath_id = '".$row_wreath['id']."' AND conect_flower_offer_wreath.id_flower = flower.id
											ORDER BY flower.leaf ASC, conect_flower_offer_wreath.price DESC;";

						$result_flowers = $con->query($query_flowers);

						$pdf->ln(-6.0);
						$pdf->SetX(38);
						$pdf->SetFont('Arial','',10);	
						
						while ($row_flower = mysqli_fetch_array($result_flowers)) {
							$pdf->SetX(38);
							$pdf->Cell(20,6,'',0,0,'R');
							$pdf->Cell(25,6,substr($row_flower["type"],0,12),0,0,'L');
							$pdf->Cell(32,6,$row_flower["color"],0,0,'L');
//							$pdf->Cell(15,6,$row_flower["priece"]. ' db',0,0,'L');
							$pdf->Cell(15,6, round($row_flower["priece"],0) . ' db',0,0,'L');
							$pdf->ln(4.0);
						}
						$pdf->ln(3.5);
						*/
				
						$pdf->SetFont('Arial','',10);
						$pdf->SetTextColor(0,0,0);
						
						if ($row_wreaths['ribbon_id'] != "") {
							$query_ribbid = "SELECT * FROM  `ribbons` WHERE id='".$row_wreaths['ribbon_id']."';";
							$result_ribbid = $con->query($query_ribbid);
							while ($row_ribbid = mysqli_fetch_assoc($result_ribbid)) {
								$offer_ribbon_tpye = $row_ribbid['ribbon'];
								$offer_ribbon_color = $row_ribbid['ribboncolor'];

								$pdf->SetTextColor(98,127,107);
								$pdf->SetFont('Arial','',9);
								$pdf->SetX(38);
								$pdf->Cell(20,4,'Szalag:',0,0,'R');
								$pdf->SetTextColor(0,0,0);
								$pdf->SetFont('Arial','',10);
								$pdf->Cell(38,4,$row_ribbid["ribbon"],0,0,'L');
								if ($row_ribbid["farewelltext"] != "SZ0 - Egyedi búcsúszöveg"){
									$pdf->SetTextColor(98,127,107);
									$pdf->SetFont('Arial','',9);
									$pdf->Cell(34,4,'Egyik oldal:',0,0,'R');
									$pdf->SetTextColor(0,0,0);
									$pdf->SetFont('Arial','',10);
									$pdf->MultiCell(68,4,substr($row_ribbid["farewelltext"], strpos($row_ribbid["farewelltext"],"-")+2),0,'L');
									$pdf->SetTextColor(98,127,107);
									$pdf->SetFont('Arial','',9);
									$pdf->SetX(38);
									$pdf->Cell(20,4,'Szín:',0,0,'R');
									$pdf->SetTextColor(0,0,0);
									$pdf->SetFont('Arial','',10);
									$pdf->Cell(38,4,$row_ribbid["ribboncolor"],0,0,'L');
									$pdf->SetTextColor(98,127,107);
									$pdf->SetFont('Arial','',9);
									$pdf->Cell(34,4,'Másik oldal:',0,0,'R');
									$pdf->SetTextColor(0,0,0);
									$pdf->SetFont('Arial','',10);
									$pdf->MultiCell(68,4,$row_ribbid["givers"],0,'L');
								}else{
									$pdf->SetTextColor(98,127,107);
									$pdf->SetFont('Arial','',9);
									$pdf->Cell(34,4,'Egyik oldal:',0,0,'R');
									$pdf->SetTextColor(0,0,0);
									$pdf->SetFont('Arial','',10);
									$pdf->MultiCell(68,4,substr($row_ribbid["givers"], 0, strpos($row_ribbid["givers"],"/")),0,'L');
									$pdf->SetTextColor(98,127,107);
									$pdf->SetFont('Arial','',9);
									$pdf->SetX(38);
									$pdf->Cell(20,4,'Szín:',0,0,'R');
									$pdf->SetTextColor(0,0,0);
									$pdf->SetFont('Arial','',10);
									$pdf->Cell(38,4,$row_ribbid["ribboncolor"],0,0,'L');
									$pdf->SetTextColor(98,127,107);
									$pdf->SetFont('Arial','',9);
									$pdf->Cell(34,4,'Másik oldal:',0,0,'R');
									$pdf->SetTextColor(0,0,0);
									$pdf->SetFont('Arial','',10);
									$pdf->MultiCell(68,4,substr($row_ribbid["givers"], strpos($row_ribbid["givers"],"/")+1),0,'L');							
								}
							}
						}else{
							$pdf->SetX(38);
							$pdf->SetTextColor(98,127,107);
							$pdf->SetFont('Arial','',9);
							$pdf->Cell(20,4,'Szalag:',0,0,'R');
							$pdf->SetTextColor(0,0,0);
							$pdf->SetFont('Arial','',10);
							$pdf->Cell(34,4,'Szalag nélkül kérték!',0,1,'L');
						}					
					
		
						$pdf->SetDrawColor(107,107,107);
						$pdf->Rect(38,$pdf->GetY(),160,0.1);
						$pdf->SetDrawColor(0,0,0);
						$pdf->ln(2);
					}
					$ind++;

				}
			}
		}		
		$con->close();
	}			
	$pdf->Output();		//PDF fájl generálása			
?>