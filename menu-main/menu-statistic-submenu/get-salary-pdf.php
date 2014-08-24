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
						
			$selectedweek = date("W")+$week;

			$this->Image('../../img/logo.png',10,6,11); 		// Logo
			$this->Cell(5); 		// Move to the right
			$this->SetFont('Arial','',14); 		// Arial bold 15
			$this->SetTextColor(216,60,118);     // Text color in gray
			$this->Cell(0,0,'Fizetési Adatok ' . $selectedweek .'. hét',0,0,'C'); 		// Title
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

	$pdf = new PdfWithHeaderAndFooter('L','mm','A4');  //Fekvõ A4 mm mért PDF fájl
	$pdf->SetTitle('fizetesi_adatok.pdf',0);
	$pdf->SetAuthor('Protea Csoport',0);
	$pdf->AliasNbPages();	//Lapokszámának beállítása
	$pdf->AddPage();		//Új oldal hozzáadása
	
	$column_header = array('Név', 'Szombat', 'Vasárnap','Hétfõ', 'Kedd', 'Szerda', 'Csütörtök', 'Péntek'); // Column headings
	$column_width = array(40, 33, 33, 33, 33, 33, 33, 33);    // Column widths

	
	$con = new mysqli('localhost', 'koszor01_user', 'Petrik2012', 'koszor01_protea');
	$con->query('SET CHARACTER SET latin2;');

	if (isset($_GET['week'])){
		$week += $_GET['week'];
	}else{
		$week = 0;
	}
	$selectedweek = date("W")+$week;

	
	for ($shop = 1; $shop<4; $shop++){
		if ($selectedweek != 1 && $selectedweek != 53){
			$query="SELECT user,(SUM(end-begin)/2) AS munkaora 
					FROM workweek".$shop." 
					WHERE ((week=". ($selectedweek-1)." AND (day between 5 AND 6)) OR (week=". $selectedweek ." AND (day between 0 AND 4))) AND year= ". date('Y') ."
					GROUP BY user";
		}else if($selectedweek == 53){
			$query="SELECT user,(SUM(end-begin)/2) AS munkaora 
					FROM workweek".$shop." 
					WHERE ((year= ". date('Y') ." AND week=53 AND (day between 5 AND 6)) OR (year= ". (date('Y')+1) ." AND week=1 AND (day between 0 AND 4)))
					GROUP BY user";
		}else if($selectedweek == 1){
			$query="SELECT user,(SUM(end-begin)/2) AS munkaora 
					FROM workweek".$shop." 
					WHERE ((year= ". (date('Y')-1) ." AND week=52 AND (day between 5 AND 6)) OR 
						(year= ". (date('Y')-1) ." AND week=53 AND (day between 0 AND 4)) OR
						(year= ". date('Y') ." AND week=1 AND (day between 0 AND 4)))
					GROUP BY user";
		}	
		
		$result = $con->query($query);
		while ($row = mysqli_fetch_array($result)) {
			$salary[$row["user"]] += $row['munkaora'];
		}
	}
	
	$days = array(0 => 5, 1 => 6, 2 => 0, 3 => 1, 4 => 2, 5 => 3, 6 => 4, 7 =>5);
		
	$users="SELECT id,name,color,salary FROM users WHERE id!=1 AND id!=2 AND id !=3 AND enable=1 ORDER BY name ASC;";
	$result = $con->query($users);						

	$uc=-1;
	while ($row = mysqli_fetch_array($result)) {
		if ($uc!=6){
			$uc++;
		}else{	
			$uc=0;
		}
		$pdf->SetDrawColor(0,0,0);
		$pdf->Rect(20,45+23*$uc,260,0.01);
		
		for ($shop = 1; $shop<4; $shop++){
			/*$query_workdays = "SELECT week,day,user,begin,end 
			   FROM workweek".$shop." 
			   WHERE user=".$row["id"]." AND ((week=".($selectedweek-1)." AND (day between 5 AND 6)) OR (week=". ($selectedweek) ." AND (day between 0 AND 4))) 
			   ORDER BY week,day ASC;";*/

			if ($selectedweek != 1 && $selectedweek != 53){
				$query_workdays = "SELECT week,day,user,begin,end 
							   FROM workweek".$shop." 
							   WHERE user=".$row["id"]." AND ((week=".($selectedweek-1)." AND (day between 5 AND 6)) OR (week=".($selectedweek)." AND (day between 0 AND 4))) AND year= ". date('Y') ." 
							   ORDER BY week,day ASC;";
			}else if($selectedweek == 53){
				$query_workdays="SELECT week,day,user,begin,end 
							FROM workweek".$shop." 
							WHERE user=".$row["id"]." AND
								((year= ". (date('Y')) ." AND (week=52 AND (day between 5 AND 6))) OR
								 (year= ". (date('Y')) ." AND (week=53 AND (day between 0 AND 4))) OR
								 (year= ". (date('Y')+1) ." AND week=1 AND (day between 0 AND 4)))
							ORDER BY year,week,day ASC;";
			}else if($selectedweek == 1){
				$query_workdays="SELECT week,day,user,begin,end 
							FROM workweek".$shop." 
							WHERE user=".$row["id"]." AND
								((year= ". (date('Y')-1) ." AND (week=52 AND (day between 5 AND 6))) OR
								 (year= ". (date('Y')-1) ." AND (week=53 AND (day between 0 AND 4))) OR
								 (year= ". date('Y') ." AND week=1 AND (day between 0 AND 4)))
							ORDER BY year,week,day ASC;";
			}

			   
			$result_workdays = $con->query($query_workdays);

			$i = 0;
			$start = 1;

			while ($row_wd = mysqli_fetch_array($result_workdays,MYSQLI_ASSOC)) {
				$j = 0;
				while ($days[$i] != ($row_wd["day"])){
					$i++;
					$j++;
				}
				for ($k=1; $k<$j; $k++){
					if ($start == 1){
						$start = 0;
					}
				}
				$start = 0;
												
				if ($days[$i] == $row_wd["day"]){
					$workers[$row["id"]][$row_wd["day"]] = create_time($row_wd["begin"]).  ' - ' . create_time($row_wd["end"]);
					$workhours[$row["id"]][$row_wd["day"]] = (($row_wd["end"] - $row_wd["begin"])/2) . ' óra';
				}						
			}						
		}
		
		$pdf->SetFont('Arial','',10);	//Betütípus beállítása
		$pdf->SetTextColor(0,0,0);
		for($i=0; $i<9; $i++){     // Header
			$pdf->Cell($column_width[$i],7,$column_header[$i],0,0,'C');
		}
		$pdf->Ln(4);

		$pdf->SetFont('Arial','',12);	//Betütípus beállítása
		$pdf->SetTextColor(137,165,131);
		$pdf->Cell(40,10,$row["name"],0,0,'C');
				
		for ($i=0; $i<7; $i++){
			$pdf->SetFont('Arial','',10);	//Betütípus beállítása
			$pdf->Cell(33,10,$workers[$row["id"]][$days[$i]],0,0,'C');
		}

		$pdf->Ln(4);
		$pdf->SetFont('Arial','',12);	//Betütípus beállítása
		$pdf->SetTextColor(0,0,0);
		$pdf->Cell(40,10,'',0,0,'C');
		for ($i=0; $i<7; $i++){
			$pdf->SetFont('Arial','',10);	//Betütípus beállítása
			$pdf->Cell(33,10,$workhours[$row["id"]][$days[$i]],0,0,'C');
		}

		$time = strtotime("1 January ".date("Y"), time());
		$time += ((7*(date("W")-1+$week))+1-date('w', $time))*24*3600;

		$first_day_in_week = date('Y-m-d', $time - 2*24*3600);
		$last_day_in_week = date('Y-m-d',($time + 4*24*3600));

		
		$pdf->Ln(5);
		$pdf->SetFont('Arial','',10);	//Betütípus beállítása
		$pdf->SetTextColor(216,60,118);
		$pdf->Cell(95,10,$first_day_in_week.' Szombat 6:00 - '. $last_day_in_week .' Péntek 20:00',0,0,'R'); 		// Title
		if (isset($salary[$row["id"]])){
			$pdf->Cell(176,10,'Heti munkaóra, fizetés: '. $salary[$row["id"]] . ' óra - ' . number_format($salary[$row["id"]]*$row["salary"], 0, ',', ' ') .' ft',0,0,'R');
		}else{
			$pdf->Cell(176,10,'A héten nem dolgozott!',0,0,'R');		
		}
		$pdf->Ln(10);

		$vegosszeg += $salary[$row["id"]]*$row["salary"];
	}		

		$pdf->SetFont('Arial','',10);	//Betütípus beállítása
		$pdf->SetTextColor(137,165,131);
		$pdf->Cell(271,10,'Összesen kifizetendõ: '. number_format($vegosszeg, 0, ',', ' ') .' ft',0,0,'R');

	
	$pdf->Output();		//PDF fájl generálása
?>