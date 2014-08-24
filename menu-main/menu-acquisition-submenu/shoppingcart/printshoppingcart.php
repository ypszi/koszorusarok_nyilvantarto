<?php
	include '../../../pdf-generator/fpdf.php';
	include '../../../config.php';

	mysql_set_charset('utf8_hungarian_ci');
	mysql_query('SET CHARACTER SET latin2;');

	function create_time($t){
		if ($t % 2 == 0){
			return (6+$t/2) . ':00';
		}else{
			return (5.5+$t/2) . ':30';
		}
	}
	
	class PdfWithHeaderAndFooter extends FPDF
	{
		function Header() 	// Page header
		{						
			$this->Image('../../../img/logo.png',10,6,11); 		// Logo
			$this->Cell(5); 		// Move to the right
			$this->SetFont('Arial','',14); 		// Arial bold 15
			$this->SetTextColor(216,60,118);     // Text color in gray
			$this->Cell(0,0,'Bevásárló lista',0,0,'C'); 		// Title
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
	$pdf->SetTitle('bevasarlo_lista.pdf',0);
	$pdf->SetAuthor('Protea Csoport',0);
	$pdf->AliasNbPages();	//Lapokszámának beállítása
	$pdf->AddPage();		//Új oldal hozzáadása

	if (isset($_GET['id'])){
		$shopcart += $_GET['id'];
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

					
	$query = "SELECT id, name, note, date FROM shopping_cart WHERE id=".$shopcart;
	$result = mysql_query($query) or die(mysql_error());

	$pdf->SetFont('Arial','',10);	//Betütípus beállítása

	while ($row = mysql_fetch_assoc($result)) {
		$pdf->SetTextColor(98,127,107);
		$pdf->Cell(38,0,"Lista neve: ",0,0,'R');
		$pdf->SetTextColor(216,60,118);
		$pdf->Cell(34,0,$row['name'],0,0,'L');
		$pdf->Ln(5);
		$pdf->SetTextColor(98,127,107);
		$pdf->Cell(38,0,"Lista megjegyzése: ",0,0,'R');
		$pdf->SetTextColor(216,60,118);
		$pdf->Cell(34,0,$row['note'],0,0,'L');
		$pdf->Ln(5);
		$pdf->SetTextColor(98,127,107);
		$pdf->Cell(38,0,"Beszerzés idõpontja: ",0,0,'R');
		$pdf->SetTextColor(216,60,118);
		$pdf->Cell(34,0,date("Y",strtotime($row["date"])) . ". " . ($show_month[date("m",strtotime($row["date"]))]) . " " . (date("d",strtotime($row["date"]))) . ".",0,0,'L');

		$pdf->Ln(15);
	}

	$pdf->SetTextColor(98,127,107);
	$pdf->Cell(38,0,"Termék neve",0,0,'L');
	$pdf->Cell(24,0,"Igényelt db",0,0,'L');
	$pdf->Cell(24,0,"Megvett db",0,0,'L');
	$pdf->Cell(32,0,"Beszerzési ár",0,0,'L');
	$pdf->Cell(32,0,"Részösszeg",0,0,'L');	
	$pdf->Cell(34,0,"Eladási ár",0,0,'R');

	$pdf->Ln(7);				
	
	$pdf->SetFont('Arial','',10);	//Betütípus beállítása
	$pdf->SetTextColor(0,0,0);
		

	$query = "SELECT id, shopping_cart_id, product, required_number, buying_number, price, sale_price, note
			FROM shopping_cart_item WHERE shopping_cart_id = ".$shopcart." AND archive = 0 ORDER BY product ASC";
	$result = mysql_query($query) or die(mysql_error());

	$sum = 0;
	while ($row = mysql_fetch_assoc($result)) {
		$pdf->Cell(38,0,$row["product"],0,0,'L');
		$pdf->Cell(17,0,$row["required_number"] . " db",0,0,'R');
		$pdf->Cell(24,0,$row["buying_number"] . " db",0,0,'R');
		$pdf->Cell(24,0,number_format($row["price"], 0, ".", " ") . " ft",0,0,'R');

		$price = $row["buying_number"] * $row["price"];		
		
		$pdf->Cell(32,0,number_format($price, 0, ".", " ") . " ft",0,0,'R');
		$pdf->Cell(48,0,$row["sale_price"] . " ft",0,0,'R');
						
		$pdf->Ln(5);
		$sum += $price;
	}

	$pdf->Ln(7);				
	$pdf->SetTextColor(98,127,107);
	$pdf->Cell(134,0,"Kifizetett pénzösszeg: " . number_format($sum, 0, ".", " ") . " ft",0,0,'R');	

	
	$pdf->Output();		//PDF fájl generálása
?>