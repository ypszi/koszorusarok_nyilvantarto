<?php
	include '../../pdf-generator/fpdf.php';

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
			if (isset($_GET['week'])){
				$week += $_GET['week'];
			}else{
				$week = 0;
			}
						
			$this->Image('../../img/logo.png',10,6,11); 		// Logo
			$this->Cell(5); 		// Move to the right
			$this->SetFont('Arial','',14); 		// Arial bold 15
			$this->SetTextColor(216,60,118);     // Text color in gray
			$this->Cell(0,0,'Munkaid�, beoszt�si napt�r',0,0,'C'); 		// Title
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

	$pdf = new PdfWithHeaderAndFooter('L','mm','A4');  //Fekv� A4 mm m�rt PDF f�jl
	$pdf->SetTitle('fizetesi_adatok.pdf',0);
	$pdf->SetAuthor('Protea Csoport',0);
	$pdf->AliasNbPages();	//Lapoksz�m�nak be�ll�t�sa
	$pdf->AddPage();		//�j oldal hozz�ad�sa

	$show_month = array("01" => "Janu�r",
					"02"  => "Febru�r",
					"03"  => "M�rcius",
					"04"  => "�prilis",
					"05"  => "M�jus",
					"06"  => "J�nius",
					"07"  => "J�lius",
					"08"  => "Agusztus",
					"09"  => "Szeptember",
					"10"  => "Okt�ber",
					"11"  => "November",
					"12"  => "December");				

	$con = new mysqli('localhost', 'koszor01_user', 'Petrik2012', 'koszor01_protea');
	$con->query('SET CHARACTER SET latin2;');
			
	$result = $con->query($query);
	$username = mysqli_data_seek($result,1);

	
	for ($shop=1; $shop<4; $shop++){
		$query = "SELECT week,day,user,begin,end 
		   FROM workweek".$shop." 
		   WHERE user=".$_GET['user_id']." AND (week between ". date(W) ." AND ".(date(W)+4).")  AND year=" . date('Y'). "
		   ORDER BY week,day ASC;";
				
		$result = $con->query($query);

		while ($row = mysqli_fetch_array($result)) {
			$workhour[$row["week"]][$row["day"]] = create_time($row["begin"]) . ' - ' . create_time($row["end"]);
		}
	}
		
	$column_header = array($username, 'H�tf�', 'Kedd', 'Szerda', 'Cs�t�rt�k', 'P�ntek', 'Szombat', 'Vas�rnap'); // Column headings
	$column_width = array(40, 33, 33, 33, 33, 33, 33, 33);    // Column widths

	$pdf->SetFont('Arial','',10);	//Bet�t�pus be�ll�t�sa
	$pdf->SetTextColor(0,0,0);
	for($i=0; $i<9; $i++){     // Header
		$pdf->Cell($column_width[$i],7,$column_header[$i],0,0,'C');
	}
	$pdf->Ln(10);

	$pdf->SetDrawColor(0,0,0);
	$pdf->Rect(11,$pdf->GetY(),268,0.1);
	$pdf->SetDrawColor(0,0,0);

	$pdf->Ln(2);		

	for ($week=(date(W)+0); $week<(date(W)+4); $week++){
		$time = strtotime("1 January ".date("Y"), time());		
		$time += ((7*($week-1))+1-date('w', $time))*24*3600;

		$pdf->SetFont('Arial','',12);	//Bet�t�pus be�ll�t�sa
		$pdf->SetTextColor(137,165,131);
		$pdf->Cell(40,10,$show_month[date('m', $time)],0,0,'C');

		
		$pdf->SetTextColor(80,80,80);
		for ($day=0; $day<7; $day++){
			$today = date('d', $time + $day*24*3600);
			if ($day!=(date(N)-1) || $week!=date(W)){
//				$pdf->SetTextColor(137,165,131);
				$pdf->SetFont('Arial','',10);	//Bet�t�pus be�ll�t�sa
				$pdf->Cell(33,10,$today,0,0,'C');
			}else{
//				$pdf->SetTextColor(216,60,118);
				$pdf->SetFont('Arial','',12);	//Bet�t�pus be�ll�t�sa
				$pdf->Cell(33,10,$today,0,0,'C');
			}
		}
		$pdf->Ln(5);

		$pdf->SetFont('Arial','',12);	//Bet�t�pus be�ll�t�sa
		$pdf->SetTextColor(137,165,131);
		$pdf->Cell(40,10,$week . '. h�t',0,0,'C');

		$pdf->SetTextColor(0,0,0);		
		for ($day=0; $day<7; $day++){
			$today = date('d', $time + $day*24*3600);
			if ($day!=(date(N)-1) || $week!=date(W)){
				if (isset($workhour[$week][$day])){
					$pdf->SetFont('Arial','',10);	//Bet�t�pus be�ll�t�sa
					$pdf->Cell(33,10,$workhour[$week][$day],0,0,'C');
				}else{
					$pdf->SetFont('Arial','',10);	//Bet�t�pus be�ll�t�sa
					$pdf->Cell(33,10,'-',0,0,'C');				
				}
			}else{
				if (isset($workhour[$week][$day])){
					$pdf->SetFont('Arial','',11);	//Bet�t�pus be�ll�t�sa
					$pdf->Cell(33,10,$workhour[$week][$day],0,0,'C');
				}else{
					$pdf->SetFont('Arial','',11);	//Bet�t�pus be�ll�t�sa
					$pdf->Cell(33,10,'-',0,0,'C');
				}
			}
		}
		$pdf->Ln(10);

		$pdf->SetDrawColor(0,0,0);
		$pdf->Rect(11,$pdf->GetY(),268,0.1);
		$pdf->SetDrawColor(0,0,0);

		$pdf->Ln(2);		
	}

	$pdf->Output();		//PDF f�jl gener�l�sa
?>