<?php
	include '../../pdf-generator/fpdf.php';

	$con = new mysqli('localhost', 'koszor01_user', 'Petrik2012', 'koszor01_protea');
	$con->set_charset('utf8_hungarian_ci');
	$con->query('SET CHARACTER SET latin2;');
	
	class PdfWithHeaderAndFooter extends FPDF
	{

		function Header() 	// Page header
		{
		$con = new mysqli('localhost', 'koszor01_user', 'Petrik2012', 'koszor01_protea');
			$con->set_charset('utf8_hungarian_ci');
			$con->query('SET CHARACTER SET latin2;');

			$this->Image('../../img/logo.png',10,6,15); 		// Logo


			$query = "SELECT id,name
					FROM users;";

			$result = $con->query($query);

			while ($row = mysqli_fetch_array($result)) {
				$user[$row["id"]]= $row["name"];
			}

			$query = "SELECT shop,uploader
					FROM offer_wreath
					WHERE offer_wreath.id=".$_POST['offers_to_print'][0].";";

			$result = $con->query($query);

			while ($row = mysqli_fetch_array($result)) {
				$usr = $user[$row["uploader"]];
				$shop = $row["shop"];
			}

			switch ($shop){
				case 1:
					$shp = "Koszorúsarok";
					$shpadd ="1237 Budapest, Temetõ sor 13-al szemben";
					$addrss1= "Pesterzsébeti Temetõnél a kapuval szemben állva, balra az elsõ üzlet";
					$addrss2= "";
					$phone = "mobil +36 20 332 9993";
					$business ="Protea family Kft.";
					$bank= "Bankszámla szám: OTP 11720025-20001072";
					$mail= "email: bolt@koszorusarok.hu";
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
					$mail= "email: bolt@proteaviragbolt.hu";
					$web = "honlap: www.proteaviragbolt.hu";
					break;
				case 3:
					$shp ="Mindszenti õrület";
					break;
			}

			$this->SetFont('Arial','',14); 		// Arial bold 15
			$this->SetTextColor(216,60,118);     // Text color in gray
			$this->Cell(18,0,'',0,0,'L'); 		// Title			
			$this->Cell(0,0,$shp,0,0,'L'); 		// Title			

			$this->SetFont('Arial','',10); 		// Arial bold 15
			$this->SetTextColor(216,60,118);     // Text color in gray
			$this->Cell(0,0,$business . " " .$bank,0,0,'R'); 		// Title			

			$this->Ln(4);
			$this->Ln(0.5);

			$this->SetFont('Arial','I',10); 		// Arial bold 15
			$this->SetTextColor(0,0,0);
			$this->Cell(18,0,'',0,0,'L'); 		// Title
			$this->Cell(0,0,$phone,0,0,'L'); 		// Title			

			$this->SetFont('Arial','',10); 		// Arial bold 15
			$this->SetTextColor(0,0,0);
			$this->Cell(0,0,$shpadd,0,0,'R'); 		// Title			

			$this->Ln(4);

			$this->SetFont('Arial','I',10); 		// Arial bold 15
			$this->SetTextColor(0,0,0);
			$this->Cell(18,0,'',0,0,'L'); 		// Title			
			$this->Cell(0,0,$mail,0,0,'L'); 		// Title			

			$this->SetFont('Arial','I',10); 		// Arial bold 15
			$this->SetTextColor(107,107,107);
			$this->Cell(0,0,$addrss1,0,0,'R'); 		// Title			

			$this->Ln(4);

			$this->SetFont('Arial','I',10); 		// Arial bold 15
			$this->SetTextColor(0,0,0);
			$this->Cell(18,0,'',0,0,'L'); 		// Title			
			$this->Cell(0,0,$web,0,0,'L'); 		// Title			
//			$this->Cell(24,0,,0,0,'L'); 		// Title

			$this->SetFont('Arial','I',10); 		// Arial bold 15
			$this->SetTextColor(107,107,107);
			$this->Cell(0,0,$addrss2,0,0,'R'); 		// Title			
			
			$this->Ln(5);
			$this->SetDrawColor(0,0,0);
			$this->Rect(11,$this->GetY(),188,0.1);
			$this->Rect(11,$this->GetY(),188,0.1);
			$this->Rect(11,$this->GetY(),188,0.1);
			$this->SetDrawColor(0,0,0);

			$this->Ln(2);
		}

		function Footer() 	// Page footer
		{
			$con = new mysqli('localhost', 'koszor01_user', 'Petrik2012', 'koszor01_protea');
			$con->set_charset('utf8_hungarian_ci');
			$con->query('SET CHARACTER SET latin2;');

			$this->Image('../../img/logo.png',10,6,15); 		// Logo


			$query = "SELECT id,name
					FROM users;";

			$result = $con->query($query);

			while ($row = mysqli_fetch_array($result)) {
				$user[$row["id"]]= $row["name"];
			}

			$query = "SELECT shop,uploader,up_time
					FROM offer_wreath
					WHERE offer_wreath.id=".$_POST['offers_to_print'][0].";";

			$result = $con->query($query);

			while ($row = mysqli_fetch_array($result)) {
				$usr = $user[$row["uploader"]];
				$time = date("Y. F. d. H:i:s",strtotime($row["up_time"]));
			}
	
			$this->SetY(-15); 		// Position at 1.5 cm from bottom

			$this->SetFont('Arial','I',8); 		// Arial italic 8

			$this->SetTextColor(216,60,118);     // Text color in gray
			$this->Cell(-10,10,$usr . " - " . $time,0,0,'L');
			$this->SetTextColor(137,165,146);     // Text color in gray

			$this->Cell(0,10,'oldal '.$this->PageNo().'/{nb}',0,0,'C'); 		// Page number
			
			$this->Cell(-41,10,'Nyomtatás:',0,0,'R');
			$this->Cell(-47,10,date("Y. F. d. H:i:s"),0,0,'L');
		}
	}


	$pdf = new PdfWithHeaderAndFooter('P','mm','A4');  //Fekvõ A4 mm mért PDF fájl
	$pdf->SetTitle('ajanlat.pdf',0);
	$pdf->SetAuthor('Protea Csoport',0);
	$pdf->AliasNbPages();	//Lapokszámának beállítása
	$pdf->AddPage();		//Új oldal hozzáadása
	$pdf->Ln(3);
	// Title			
	
	$pdf->SetFont('Arial','',14); 		// Arial bold 15
	$pdf->SetTextColor(216,60,118);     // Text color in gray
	$pdf->Cell(0,0,'~ Ajánlat ~',0,1,'C'); 		// Title	

	$pdf->Ln(7);


	$ind = 1;
	if (isset($_POST['offers_to_print'])){


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
		
		foreach ($_POST['offers_to_print'] as $key) { // offers_to_print tömbbe azok kerülnek, amelyek checked
		//	$pdf->Cell(34,6,$key,0,0,'L');								// $key -edik elem megkapja az ID-t
		
			if (isset($key)){

				$con = new mysqli('localhost', 'koszor01_user', 'Petrik2012', 'koszor01_protea');
				$con->set_charset('utf8_unicode_ci');
				$con->query('SET CHARACTER SET latin2;');


				$query = "SELECT *
				FROM offer_wreath 
				WHERE id='".$key."';";

				$result = $con->query($query);
				
				while ($row = mysqli_fetch_array($result)) {
								
					$query_wreath = "SELECT offer_wreath.id, offer_wreath.name, offer_wreath.note,offer_wreath.ribbon_id, offer_wreath.calculate_price, offer_wreath.sale_price, base_wreath.price, base_wreath.size, base_wreath.note AS base_wreath_note
					FROM offer_wreath,base_wreath
					WHERE offer_wreath.base_wreath_id=base_wreath.id AND offer_wreath.id='".$row["id"]."'";

					$result_wreath = $con->query($query_wreath);

					while ($row_wreath = mysqli_fetch_array($result_wreath)) {
					
						$pdf->SetFont('Arial','',9);
						$pdf->SetTextColor(98,127,107);
						$pdf->Cell(24,4,''.$ind.'. Koszorú:',0,0,'R');
						$pdf->SetFont('Arial','',10);
						$pdf->SetTextColor(0,0,0);
						$pdf->Cell(84,4,$row_wreath["name"],0,0,'L');

						$pdf->SetFont('Arial','',9); 		
						$pdf->SetTextColor(98,127,107);
						$pdf->Cell(24,4,'Alap:',0,0,'R');
						$pdf->SetFont('Arial','',10); 		
						$pdf->SetTextColor(0,0,0);
						$pdf->MultiCell(54,4,$row_wreath["size"].','.$row_wreath["base_wreath_note"],0,'L');
						$pdf->ln(1);

	//					$pdf->Cell(34,6,$row_wreath["size"].','.$row_wreath["base_wreath_note"],0,1,'L');	

						if (isset($row_wreath["note"]) && $row_wreath["note"]!=""){
							$pdf->ln(1.5);
							$pdf->Cell(24,0,'',0,0,'L');
							$pdf->SetTextColor(50,50,50);
							$pdf->SetFont('Arial','I',10);
							$pdf->MultiCell(163,4,$row_wreath["note"],0,'L');
							$pdf->ln(1.5);
						}	


						$pdf->SetTextColor(98,127,107);
						$pdf->SetFont('Arial','',9); 		
						$pdf->Cell(24,6,'Összetevõk:',0,1,'R');
						$pdf->SetTextColor(0,0,0);

						$query_flowers = "	SELECT flower.type, flower.color, flower.price ,conect_flower_offer_wreath.priece 
											FROM `conect_flower_offer_wreath`,`flower` 
											WHERE conect_flower_offer_wreath.offer_wreath_id = '".$row_wreath['id']."' AND conect_flower_offer_wreath.id_flower = flower.id
											ORDER BY flower.leaf ASC, flower.type ASC;";

						$result_flowers = $con->query($query_flowers);

						$pdf->ln(-6.0);
						$pdf->SetFont('Arial','',10);		
						while ($row_flower = mysqli_fetch_array($result_flowers)) {
							$pdf->Cell(24,6,'',0,0,'R');
							$pdf->Cell(25,6,substr($row_flower["type"],0,12),0,0,'L');
							$pdf->Cell(32,6,$row_flower["color"],0,0,'L');

							if (($row_flower["priece"] * 100) % 100  == 0 ){
								$pdf->Cell(15,6, round($row_flower["priece"],0) . ' db',0,0,'R');
							}else{
								$pdf->Cell(15,6, $row_flower["priece"] . ' db',0,0,'R');
							}

//							$pdf->Cell(15,6,$row_flower["priece"]. ' db',0,0,'L');
							$pdf->ln(4.0);
						}
						$pdf->ln(3.5);
					
			
						$pdf->SetFont('Arial','',10);
						$pdf->SetTextColor(0,0,0);
						
						if ($row_wreath['ribbon_id'] != "") {
							$query_ribbid = "SELECT * FROM  `ribbons` WHERE id='".$row_wreath['ribbon_id']."';";
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
									$pdf->MultiCell(91,4,substr($row_ribbid["farewelltext"], strpos($row_ribbid["farewelltext"],"-")+2),0,'L');
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
									$pdf->MultiCell(91,4,$row_ribbid["givers"],0,'L');
								}else{
									$pdf->SetTextColor(98,127,107);
									$pdf->SetFont('Arial','',9);
									$pdf->Cell(34,4,'Egyik oldal:',0,0,'R');
									$pdf->SetTextColor(0,0,0);
									$pdf->SetFont('Arial','',10);
									$pdf->MultiCell(91,4,substr($row_ribbid["givers"], 0, strpos($row_ribbid["givers"],"/")),0,'L');
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
									$pdf->MultiCell(91,4,substr($row_ribbid["givers"], strpos($row_ribbid["givers"],"/")+1),0,'L');							
								}
							}
						}else{
							$pdf->Cell(34,6,'Szalag nélkül kérték!',0,1,'L');
						}					
					
						$ribbonprice = 0;
						if ($offer_ribbon_tpye != "") {						
							$pdf->SetFont('Arial','I',9);
							$pdf->SetTextColor(98,127,107);
							$pdf->Cell(24,6,'Koszorú ár:',0,0,'R');
							$pdf->SetTextColor(107,107,107);
							$pdf->SetFont('Arial','BI',10);
							$ribbonprice = $ribbon_type[$offer_ribbon_tpye]+$ribbon_color[$offer_ribbon_color];
							$pdf->Cell(18,6,number_format($row_wreath["sale_price"] - $ribbonprice, 0, ',', ' ') .' Ft',0,0,'L');
							$pdf->SetFont('Arial','I',9);
							$pdf->SetTextColor(98,127,107);
							$pdf->Cell(21,6,'+ Szalag ára:',0,0,'L');
							$pdf->SetFont('Arial','BI',10);
							$pdf->SetTextColor(107,107,107);
							$pdf->Cell(16,6,number_format($ribbonprice, 0, ',', ' ') .' Ft',0,0,'L');
							$pdf->SetFont('Arial','I',9);
							$pdf->SetTextColor(98,127,107);
							$pdf->Cell(90,6,'Ár:',0,0,'R');
						}else{
							$pdf->SetFont('Arial','I',9);
							$pdf->SetTextColor(98,127,107);
							$pdf->Cell(168,6,'Ár:',0,0,'R');
						}
					
						$pdf->SetFont('Arial','BI',12);
						$pdf->SetTextColor(0,0,0);
						$pdf->Cell(19,6,number_format($row_wreath["sale_price"], 0, ',', ' ') .' Ft',0,1,'R');
										
						$pdf->SetDrawColor(107,107,107);
						$pdf->Rect(11,$pdf->GetY(),188,0.1);
						$pdf->SetDrawColor(0,0,0);
						$pdf->ln(2);
					}
					
					$pdf->Ln(2);			
					
				}		
				$con->close();
			}
			$ind++;
		}
	}
	
	$pdf->SetFont('Arial','I',8); 		// Arial bold 15
	$pdf->SetTextColor(0,0,0);     // Text color in gray
	$pdf->Cell(0,0,"* A megadott ajánlat nem tartalmazza a kiszállítás kötségét, amennyiben nem az Erzsébeti temetõbe kéri.",0,1,'L'); 		
	
	$pdf->Output();		//PDF fájl generálása			
?>