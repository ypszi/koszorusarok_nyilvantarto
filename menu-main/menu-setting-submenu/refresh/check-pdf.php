<?php
	include '../../../pdf-generator/fpdf.php';
	
	$con = new mysqli('localhost', 'koszor01_user', 'Petrik2012', 'koszor01_protea');
	$con->set_charset('utf8_hungarian_ci');
	$con->query('SET CHARACTER SET latin2;');

	class PdfWithHeaderAndFooter extends FPDF
	{
		function Header() 	// Page header
		{
			$this->Image('../../../img/logo.png',10,6,11); 		// Logo
			$this->Cell(5); 		// Move to the right
			$this->SetFont('Arial','',14); 		// Arial bold 15
			$this->SetTextColor(216,60,118);     // Text color in gray
			$this->Ln(13);			
		}

		function Footer() 	// Page footer
		{
			$this->SetY(-15); 		// Position at 1.5 cm from bottom
			$this->SetFont('Arial','I',8); 		// Arial italic 8
			$this->SetTextColor(137,165,146);     // Text color in gray
			$this->Cell(0,10,'oldal '.$this->PageNo().'/{nb}',0,0,'C'); 		// Page number
		}
	}

	$pdf = new PdfWithHeaderAndFooter('P','mm','A4');  //Fekvõ A4 mm mért PDF fájl
	$pdf->SetTitle('fizetesi_adatok.pdf',0);
	$pdf->SetAuthor('Protea Csoport',0);
	$pdf->AliasNbPages();	//Lapokszámának beállítása
	$pdf->AddPage();		//Új oldal hozzáadása
	
	$pdf->SetFont('Arial','',14); 		// Arial bold 15
	$pdf->SetTextColor(216,60,118);     // Text color in gray
	$pdf->Cell(0,0,'~ Kosszoruk ellenorzese ~',0,1,'C'); 		// Title	

	$pdf->Ln(10);	
			
	if (isset($_GET["id"])){

		$query = "SELECT special_wreath.picture, special_wreath.id,special_wreath.fancy, special_wreath.name, special_wreath.note, special_wreath.calculate_price, special_wreath.sale_price, base_wreath.price AS base_wreath_price, base_wreath.size, base_wreath.note AS base_wreath_note
				FROM `special_wreath`,`base_wreath` 
				WHERE special_wreath.base_wreath_id=base_wreath.id AND base_wreath.type='".$_GET[id]."'
				ORDER BY special_wreath.name ASC;";

		$result = $con->query($query);

		$ind=1;
		while ($row = mysqli_fetch_array($result)) {

			$pdf->SetFont('Arial','',9);
			$pdf->SetTextColor(98,127,107);
			$pdf->Cell(6,6,$ind++,0,0,'R');
			$pdf->SetFont('Arial','B',9);
			$pdf->SetTextColor(0,0,0);
			$pdf->Cell(10,6,$row["name"],0,0,'L');

			$pdf->SetFont('Arial','',9);
			$pdf->SetTextColor(50,50,50);
			$pdf->Cell(60,6,substr($row["fancy"], 0, 40),0,0,'L');

			$pdf->SetFont('Arial','',10);
			$pdf->SetTextColor(98,127,107);
			$pdf->Cell(24,6,number_format($row['sale_price'], 0, ',', ' ') .' Ft',0,0,'R');		

			$query_price = "SELECT conect_flower_special_wreath.id_flower, conect_flower_special_wreath.priece, flower.price
			FROM conect_flower_special_wreath,flower
			WHERE conect_flower_special_wreath.special_wreath_id=".$row[id]." AND conect_flower_special_wreath.id_flower = flower.id;";

//			echo $query_price;

			$result_price = $con->query($query_price);

			$sum = $row['base_wreath_price'];
			
			while ($row_price = mysqli_fetch_array($result_price)) {
				$sum = $sum + $row_price["priece"]*$row_price["price"];
			}

			$sum =  round((($sum + 1000) * 1.1111)/100) * 100;
			
			$pdf->SetFont('Arial','',10);
			$pdf->SetTextColor(98,127,107);
			$pdf->Cell(24,6,number_format($sum, 0, ',', ' ') .' Ft',0,0,'R');


			$pdf->SetFont('Arial','',10);
			if (($row['sale_price'] - $sum) > 0){
				$pdf->SetTextColor(0,0,0);
				$pdf->Cell(24,6,number_format(($row['sale_price'] - $sum), 0, ',', ' ') .' Ft',0,1,'R');
			}else if (($row['sale_price'] - $sum) < 0){
				$pdf->SetTextColor(255,0,0);
				$pdf->Cell(24,6,number_format(($row['sale_price'] - $sum), 0, ',', ' ') .' Ft',0,1,'R');
			}else{
				$pdf->Cell(24,6,'',0,1,'R');
			}


		}
	}
	
	$pdf->Output();		//PDF fájl generálása
?>