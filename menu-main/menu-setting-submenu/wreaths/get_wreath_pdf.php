<?php
	include '../../../pdf-generator/fpdf.php';

	class PdfWithHeaderAndFooter extends FPDF
	{
		function Header() 	// Page header
		{
			$this->Image('../../../img/logo.png',10,6,11); 		// Logo
			$this->Cell(5); 		// Move to the right
			$this->SetFont('Arial','',14); 		// Arial bold 15
			$this->SetTextColor(216,60,118);     // Text color in gray
			$this->Cell(0,0,'Koszorú',0,0,'C'); 		// Title
			$this->Ln(10);
		}

		function Footer() 	// Page footer
		{
			$this->SetY(-15); 		// Position at 1.5 cm from bottom
			$this->SetFont('Arial','I',8); 		// Arial italic 8
			$this->SetTextColor(137,165,146);     // Text color in gray
			$this->Cell(0,10,'oldal '.$this->PageNo().'/{nb}',0,0,'C'); 		// Page number
			
			$this->Cell(-34,10,'Nyomtatás:',0,0,'R');
			$this->Cell(-40,10,date("Y. F. d. H:i:s"),0,0,'L');
		}
	}

	$pdf = new PdfWithHeaderAndFooter('P','mm','A4');  //Fekvõ A4 mm mért PDF fájl
	$pdf->SetTitle('koszoru.pdf',0);
	$pdf->SetAuthor('Protea Csoport',0);
	$pdf->AliasNbPages();	//Lapokszámának beállítása
	$pdf->AddPage();		//Új oldal hozzáadása
	$pdf->Ln(7);
		
		
	if (isset($_GET["id"])){
		$con = new mysqli('localhost', 'koszor01_user', 'Petrik2012', 'koszor01_protea');
		$con->set_charset('utf8_hungarian_ci');
		$con->query('SET CHARACTER SET latin2;');
		
		$query_wreath = "SELECT special_wreath.picture, special_wreath.id,special_wreath.fancy, special_wreath.name, special_wreath.note, special_wreath.calculate_price, special_wreath.sale_price, base_wreath.price, base_wreath.size, base_wreath.note AS base_wreath_note
		FROM special_wreath,base_wreath
		WHERE special_wreath.base_wreath_id=base_wreath.id AND special_wreath.id='".$_GET["id"]."'";
								
		$result_wreath = $con->query($query_wreath);

		while ($row_wreath = mysqli_fetch_array($result_wreath)) {
	
			$pdf->SetFont('Arial','',9);
			$pdf->SetTextColor(0,0,0);
			$pdf->Cell(24,6,'Koszorú:',0,0,'R');
			$pdf->Cell(10,6,'- '.$row_wreath["name"],0,0,'L');
			$pdf->Cell(40,6,'- '.$row_wreath["fancy"],0,1,'L');

			$pdf->Cell(24,0,'',0,0,'L');
			$pdf->SetTextColor(107,107,107);
			$pdf->SetFont('Arial','I',9);
			$pdf->MultiCell(164,4,$row_wreath["note"],0,'L');
									
			$query_wreath = "SELECT special_wreath.picture, special_wreath.id,special_wreath.fancy, special_wreath.name, special_wreath.note, special_wreath.calculate_price, special_wreath.sale_price, base_wreath.price, base_wreath.size, base_wreath.note AS base_wreath_note
						FROM special_wreath,base_wreath
						WHERE special_wreath.base_wreath_id=base_wreath.id AND special_wreath.id='".$_GET["id"]."'";
			
			$result_wreath = $con->query($query_wreath);

			while ($row_wreath = mysqli_fetch_array($result_wreath)) {
				$pdf->SetFont('Arial','',9); 		
				$pdf->SetTextColor(0,0,0);
				$pdf->Cell(24,6,'Alap:',0,0,'R');
				$pdf->Cell(34,6,$row_wreath["size"].','.$row_wreath["base_wreath_note"],0,1,'L');
			
				$pdf->Cell(24,6,'Összetevõk:',0,1,'R');

				$query_flowers = "	SELECT flower.type, flower.color, flower.price ,conect_flower_special_wreath.priece 
									FROM `conect_flower_special_wreath`,`flower` 
									WHERE conect_flower_special_wreath.special_wreath_id = '".$row_wreath['id']."' AND conect_flower_special_wreath.id_flower = flower.id
									ORDER BY flower.leaf ASC, conect_flower_special_wreath.priece DESC;";
			
				$result_flowers = $con->query($query_flowers);
				
				while ($row_flower = mysqli_fetch_array($result_flowers)) {
					$pdf->Cell(24,6,'',0,0,'R');
					$pdf->Cell(40,6,$row_flower["type"],0,0,'L');
					$pdf->Cell(40,6,$row_flower["color"],0,0,'L');
					$pdf->Cell(10,6,$row_flower["priece"]. ' db',0,1,'L');
				}				

				$pdf->Cell(24,6,'Koszorú ára:',0,0,'R');
				$pdf->SetFont('Arial','BI',10);
				$pdf->SetTextColor(98,127,107);
				$pdf->Cell(14,6,number_format($row_wreath["sale_price"], 0, ',', ' ') .' Ft',0,0,'L');
				
				$pdf->SetDrawColor(107,107,107);
				$pdf->Rect(14,$pdf->GetY(),182,0.01);
				$pdf->SetDrawColor(0,0,0);

				$pdf->Image('../../../img/wreath/'.trim($row_wreath["picture"],"|"),52,$pdf->GetY()+10,110); 		// Kep
			}					
								
		}

		$con->close();
	}		
		
	$pdf->Output();		//PDF fájl generálása			
?>