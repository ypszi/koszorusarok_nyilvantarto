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
			$this->Image('../../img/logo.png',10,6,15); 		// Logo
			
			switch ($_GET["shop"]){
				case 1:
					$shp = "Koszorúsarok";
					$shpadd ="1237 Budapest, Temetõ sor 13-al szemben";
					$addrss1= "Pesterzsébeti Temetõnél a kapuval szemben állva, balra az elsõ üzlet";
					$addrss2= "";
					$phone = "mobil +36 20 332 9993";
					$business ="Protea family Kft.";
					$bank= "Bankszámla szám: OTP 11720025-20001072";
					$mail= "email: uzlet@koszorusarok.hu";
					$web = "honlap: www.koszorusarok.hu";
					break;
				case 2:
					$shp = "Protea Virágbolt";
					$shpadd ="1237 Budapest, Temetõ sor 13-al szemben";
					$addrss1= "Pesterzsébeti Temetõnél a kapuval szemben állva, balra a második üzlet";
					$addrss2= "";
					$phone = "mobil +36 20 457 7143";
					$business ="Protea Bt.";
					$bank= "Bankszámla szám: Axa Bank 17000019-11439826";
					$mail= "email: uzlet@proteaviragbolt.hu";
					$web = "honlap: www.proteaviragbolt.hu";
					break;
				case 3:
					$shp ="Mindszenti õrület";
					break;
			}

			$this->SetFont('Arial','',8); 		// Arial bold 15
			$this->SetTextColor(216,60,118);     // Text color in gray
			$this->Cell(16,0,'',0,0,'L'); 		// Title			
			$this->Cell(0,0,$shp,0,0,'L'); 		// Title			

			$this->SetFont('Arial','',8); 		// Arial bold 15
			$this->SetTextColor(216,60,118);     // Text color in gray
			$this->Cell(0,0,$business . " " .$bank,0,0,'R'); 		// Title			

			$this->Ln(4);

			$this->SetFont('Arial','I',8); 		// Arial bold 15
			$this->SetTextColor(0,0,0);
			$this->Cell(16,0,'',0,0,'L'); 		// Title
			$this->Cell(0,0,$phone,0,0,'L'); 		// Title			

			$this->SetFont('Arial','',8); 		// Arial bold 15
			$this->SetTextColor(0,0,0);
			$this->Cell(0,0,$shpadd,0,0,'R'); 		// Title			

			$this->Ln(4);

			$this->SetFont('Arial','I',8); 		// Arial bold 15
			$this->SetTextColor(0,0,0);
			$this->Cell(16,0,'',0,0,'L'); 		// Title			
			$this->Cell(0,0,$mail,0,0,'L'); 		// Title			

			$this->SetFont('Arial','I',8); 		// Arial bold 15
			$this->SetTextColor(107,107,107);
			$this->Cell(00,0,$addrss1,0,0,'R'); 		// Title			

			$this->Ln(4);

			$this->SetFont('Arial','I',8); 		// Arial bold 15
			$this->SetTextColor(0,0,0);
			$this->Cell(16,0,'',0,0,'L'); 		// Title			
			$this->Cell(0,0,$web,0,0,'L'); 		// Title			
//			$this->Cell(24,0,,0,0,'L'); 		// Title

			$this->SetFont('Arial','I',8); 		// Arial bold 15
			$this->SetTextColor(107,107,107);
			$this->Cell(0,0,$addrss2,0,0,'R'); 		// Title			

			$this->Ln(8);
		}

		function Footer() 	// Page footer
		{		
			$this->Image('../../img/logo.png',10,6,15); 		// Logo

			$this->SetY(-15); 		// Position at 1.5 cm from bottom
			$this->SetFont('Arial','I',8); 		// Arial italic 8
			$this->SetTextColor(137,165,146);     // Text color in gray
			$this->Cell(0,10,'oldal '.$this->PageNo().'/{nb}',0,0,'C'); 		// Page number
			//	$this->Cell(0,0,'oldal '.$this->PageNo().'/{nb}',0,0,'C'); 		// Page number
			
			$this->Cell(-41,10,'Nyomtatás:',0,0,'R');
			$this->Cell(-47,10,date("Y. F. d. H:i:s"),0,0,'L');
		}
	}

	$pdf = new PdfWithHeaderAndFooter('P','mm','A4');  //Fekvõ A4 mm mért PDF fájl
	$pdf->SetTitle('rendeles.pdf',0);
	$pdf->SetAuthor('Protea Csoport',0);
	$pdf->AliasNbPages();	//Lapokszámának beállítása
	$pdf->AddPage();		//Új oldal hozzáadása
	$pdf->Ln(3);
	// Title			
	
	$pdf->SetFont('Arial','',14); 		// Arial bold 15
	$pdf->SetTextColor(216,60,118);     // Text color in gray
	$pdf->Cell(0,0,'~ '.date("Y",strtotime($_GET["day"])) . ' ' . mymonth(date("n",strtotime($_GET["day"]))) . ' ' . date("d",strtotime($_GET["day"])) . ', ' . myday(date("N",strtotime($_GET["day"]))) . ' - Szalagok ~',0,1,'C'); 		// Title	

	$pdf->Ln(7);
		
			
	if (isset($_GET["day"]) && isset($_GET["shop"])){
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

		
		$query = "SELECT *
		FROM orders  
		WHERE DATE(orders.ritual_time)='".date("Y-m-d",strtotime($_GET["day"]))."' AND orders.maker_shop=".$_GET["shop"]." AND archive=0;";

//		echo $query;
		
		$result = $con->query($query);						

		while ($row = mysqli_fetch_array($result)) {
			$pdf->SetFont('Arial','',9);
			$pdf->SetTextColor(0,0,0);

			if (isset($row["deadname"]) && $row["deadname"]!= ""){
				$pdf->Cell(24,6,'Elhunyt:',0,0,'R');
				$pdf->SetFont('Arial','B',9);
				$pdf->Cell(40,6,'† '.$row["deadname"],0,0,'L');
			}else{
				$pdf->Cell(24,6,'',0,0,'R');
				$pdf->SetFont('Arial','B',9);
				$pdf->Cell(40,6,'',0,0,'L');			
			}
			$pdf->SetFont('Arial','',9);
			$pdf->Cell(80,6,'Megrendelõ:',0,0,'R');
			$pdf->Cell(40,6,$row["customer_name"],0,1,'L');

			
			$mydate = date("Y",strtotime($row["ritual_time"])) . " " . mymonth(date("n",strtotime($row["ritual_time"]))) . " " . date("d",strtotime($row["ritual_time"])) . ", " . myday(date("N",strtotime($row["ritual_time"]))) . " - ". date("H:i",strtotime($row["ritual_time"]));
			$pdf->SetFont('Arial','',9);
			$pdf->Cell(24,6,'Szertartás:',0,0,'R');
			$pdf->SetFont('Arial','B',9);
			$pdf->Cell(40,6,$mydate,0,1,'L');
			
			$pdf->Ln(1);
			$pdf->SetDrawColor(107,107,107);
			$pdf->Rect(11,$pdf->GetY(),185,0.01);
			$pdf->SetDrawColor(0,0,0);

			$query_wreaths = "SELECT COUNT(id) AS cid
						FROM order_items
						WHERE order_id='".$row["id"]."' AND is_offer=0";						

			$result_wreaths = $con->query($query_wreaths);
			$row_wreaths = $result_wreaths->fetch_assoc();
			$wreath_special_db =  $row_wreaths["cid"];

//			$pdf->Cell(0,0, $wreath_special_db,0,0,'L');

			$query_wreaths = "SELECT *
						FROM order_items
						WHERE order_id='".$row["id"]."' AND is_offer=0";						

			$result_wreaths = $con->query($query_wreaths);

			$ind = 1;
			while ($row_wreaths = mysqli_fetch_array($result_wreaths)) {
				$query_wreath = "SELECT special_wreath.picture, special_wreath.id,special_wreath.fancy, special_wreath.name, special_wreath.note, special_wreath.calculate_price, special_wreath.sale_price, base_wreath.price, base_wreath.size, base_wreath.note AS base_wreath_note
				FROM special_wreath,base_wreath
				WHERE special_wreath.base_wreath_id=base_wreath.id AND special_wreath.name='".$row_wreaths["wreath_name"]."'";
										
				$result_wreath = $con->query($query_wreath);

				while ($row_wreath = mysqli_fetch_array($result_wreath)) {
				
					$pdf->Image('../../img/wreath/'.trim($row_wreath["picture"],"|"),168,$pdf->GetY()+2,28); 		// Kep

					$pdf->SetFont('Arial','',9);
					$pdf->SetTextColor(0,0,0);
					$pdf->Cell(24,6,'#'.$ind.' Koszorú:',0,0,'R');
					$pdf->Cell(14,6,'#'.$row_wreaths["azonosito"],0,0,'L');

					$pdf->Cell(10,6,'- '.$row_wreath["name"],0,0,'L');
					$pdf->Cell(40,6,$row_wreath["fancy"],0,1,'L');
											
					$query_wreath = "SELECT special_wreath.picture, special_wreath.id,special_wreath.fancy, special_wreath.name, special_wreath.note, special_wreath.calculate_price, special_wreath.sale_price, base_wreath.price, base_wreath.size, base_wreath.note AS base_wreath_note
								FROM special_wreath,base_wreath
								WHERE special_wreath.base_wreath_id=base_wreath.id AND special_wreath.name='".$row_wreaths["wreath_name"]."'";
					
					$result_wreath = $con->query($query_wreath);
									
					if ($row_wreaths['ribbon'] != "") {
						$pdf->Cell(24,6,'Típus:',0,0,'R');
						$pdf->Cell(38,6,$row_wreaths["ribbon"],0,0,'L');
						$pdf->Cell(34,6,'Egyik oldal:',0,0,'R');
						$pdf->MultiCell(91,6,substr($row_wreaths["farewelltext"], strpos($row_wreaths["farewelltext"],"-")+2),0,'L');
						$pdf->Cell(24,6,'Szín:',0,0,'R');
						$pdf->Cell(38,6,$row_wreaths["ribboncolor"],0,0,'L');
						$pdf->Cell(34,6,'Másik oldal:',0,0,'R');
						$pdf->MultiCell(91,6,$row_wreaths["givers"],0,'L');
					}else{
						$pdf->Cell(34,6,'Szalag nélkül kérték!',0,1,'L');
					}										
					
					$pdf->ln();
				}
				$ind++;
			}

			$query_wreaths = "SELECT COUNT(id) AS cid
						FROM order_items
						WHERE order_id='".$row["id"]."' AND is_offer=1";						

			$result_wreaths = $con->query($query_wreaths);
			$row_wreaths = $result_wreaths->fetch_assoc();
			$wreath_offer_db =  $row_wreaths["cid"];

			$query_wreaths = "SELECT *
			FROM order_items
			WHERE order_id='".$row["id"]."' AND is_offer=1";
						
			$result_wreaths = $con->query($query_wreaths);

			while ($row_wreaths = mysqli_fetch_array($result_wreaths)) {

				$query_wreath = "SELECT offer_wreath.id, offer_wreath.name, offer_wreath.note, offer_wreath.calculate_price, offer_wreath.sale_price, base_wreath.price, base_wreath.size, base_wreath.note AS base_wreath_note
				FROM offer_wreath,base_wreath
				WHERE offer_wreath.base_wreath_id=base_wreath.id AND offer_wreath.name='".$row_wreaths["wreath_name"]."'";
	
				$result_wreath = $con->query($query_wreath);

				while ($row_wreath = mysqli_fetch_array($result_wreath)) {
				
					$pdf->SetFont('Arial','',9);
					$pdf->SetTextColor(98,127,107);
					$pdf->Cell(24,6,$ind.' Koszorú:',0,0,'R');
					$pdf->SetFont('Arial','',10);
					$pdf->SetTextColor(0,0,0);
					$pdf->Cell(14,6,'#'.$row_wreaths["azonosito"],0,0,'L');

					$pdf->Cell(10,6,'- '.$row_wreath["name"],0,1,'L');					

					
					if ($row_wreaths['ribbon_id'] != "") {
						$query_ribbid = "SELECT * FROM  `ribbons` WHERE id='".$row_wreaths['ribbon_id']."';";
						$result_ribbid = $con->query($query_ribbid);
						while ($row_ribbid = mysqli_fetch_assoc($result_ribbid)) {
							if ($row_ribbid["farewelltext"] != "SZ0 - Egyedi búcsúszöveg"){
								$pdf->SetTextColor(98,127,107);
								$pdf->SetFont('Arial','',9);
								$pdf->Cell(24,6,'Típus:',0,0,'R');
								$pdf->SetTextColor(0,0,0);
								$pdf->SetFont('Arial','',10);
								$pdf->Cell(38,6,$row_ribbid["ribbon"],0,0,'L');
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
								$pdf->Cell(24,6,'Típus:',0,0,'R');
								$pdf->SetTextColor(0,0,0);
								$pdf->SetFont('Arial','',10);
								$pdf->Cell(38,6,$row_ribbid["ribbon"],0,0,'L');
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
/*							$pdf->Cell(24,6,'Típus:',0,0,'R');
							$pdf->Cell(38,6,$row_ribbid["ribbon"],0,0,'L');
							$pdf->Cell(34,6,'Egyik oldal:',0,0,'R');
							$pdf->MultiCell(91,6,substr($row_ribbid["farewelltext"], strpos($row_ribbid["farewelltext"],"-")+2),0,'L');
							$pdf->Cell(24,6,'Szín:',0,0,'R');
							$pdf->Cell(38,6,$row_ribbid["ribboncolor"],0,0,'L');
							$pdf->Cell(34,6,'Másik oldal:',0,0,'R');
							$pdf->MultiCell(91,6,$row_ribbid["givers"],0,'L');*/
						}
					}else{
						$pdf->Cell(34,6,'Szalag nélkül kérték!',0,1,'L');
					}					

					$pdf->ln();
				}
				$ind++;

			}
		
		}		
		$con->close();
	}
			
	$pdf->Output();		//PDF fájl generálása			
?>