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
			$this->Cell(0,0,'Beszerzés - Virág lista',0,0,'C'); 		// Title
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

	$con = new mysqli('localhost', 'koszor01_user', 'Petrik2012', 'koszor01_protea');
	$con->query('SET CHARACTER SET latin2;');
			
	$result = $con->query($query);
	$username = mysqli_data_seek($result,1);

	$bd = date("Y-m-d");

	
	$query_shops = "SELECT *
				FROM shops";
	$result_shops = $con->query($query_shops);
	
	$tmp = 1;
	while ($row_shops = mysqli_fetch_array($result_shops)) {
			$names[$tmp] = $row_shops["name"];
			$tmp++;
	}
	
	$shop1 = 0;
	$shop2 = 0;
	$shop3 = 0;

	if(isset($_GET['shop1'])) {
		$shop1 = "checked";
	}
	else $shop1 = "";
	
	if(isset($_GET['shop2'])) {
		$shop2 = "checked";
	}
	else $shop2 = "";
	
	if(isset($_GET['shop3'])) {
		$shop3 = "checked";
	}
	else $shop3 = "";


	if($shop1 == "checked" || $shop2 == "checked" || $shop3 == "checked") {
		 $shopsql = " AND (";
	}
	else {
		$shopsql = "";
	}
	$pdf->SetFont('Arial','',10);	//Betütípus beállítása
	$pdf->SetTextColor(137,165,146); 	
	$pdf->Cell(33,0,"Szûrt boltok listája: ",0,0,'R');
	$pdf->SetTextColor(0,0,0);

	if($shop1 == "checked") {
		$shopsql .= " maker_shop = 1";
		$pdf->Cell(23,0,$names[1],0,0,'L');
	}
	if($shop2 == "checked") {
		if($shop1 == "checked")
			$shopsql .= " OR ";
		$shopsql .= " maker_shop = 2";

		$pdf->Cell(30,0,$names[2],0,0,'L');
	}
	if($shop3 == "checked") {
		if($shop1 == "checked" || $shop2 == "checked")
			$shopsql .= " OR ";
		$shopsql .= " maker_shop = 3";
		$pdf->Cell(26,0,$names[3],0,0,'L');
	}
	if($shopsql != "") $shopsql .= ")";	
 	
	$beginDate = isset($_GET['min_date']) ? $_GET['min_date'] : date("Y-m-d",strtotime($bd)+((8-date("N"))*24*3600));
	$endDate = isset($_GET['max_date']) ? $_GET['max_date'] : date("Y-m-d",strtotime($bd)+((11-date("N"))*24*3600));
		
	if(!isset($_GET['allchecked'])) {
		$shop1 = "checked";
		$shop2 = "checked";
		$shop3 = "checked";
		$pdf->Cell(23,0,$names[1],0,0,'L');
		$pdf->Cell(30,0,$names[2],0,0,'L');
		$pdf->Cell(26,0,$names[3],0,1,'L');
	}
	
	$pdf->ln(4);
	$pdf->SetTextColor(137,165,146); 
	$pdf->Cell(33,0,"Idõintervallum: ",0,0,'R');
	$pdf->SetTextColor(0,0,0); 	
	$pdf->Cell(23,0,$beginDate . " - " . $endDate,0,0,'L');
	


 
		$query = "SELECT *
		FROM orders
		WHERE ritual_time>='" . $beginDate . " 00-00-00' AND ritual_time <= '" . $endDate . " 23-59-59'" . $shopsql . " AND archive=0;";

		$result = $con->query($query);

		while ($row = mysqli_fetch_assoc($result)) {
			$query_wreaths = "SELECT *
						FROM order_items
						WHERE order_id='".$row["id"]."' AND is_offer=0";
						
			$result_wreaths = $con->query($query_wreaths);

			while ($row_wreaths = mysqli_fetch_array($result_wreaths)) {
				$query_wreath = "SELECT special_wreath.picture, special_wreath.id,special_wreath.fancy, special_wreath.name, special_wreath.note, special_wreath.calculate_price, special_wreath.sale_price, base_wreath.price, base_wreath.size, base_wreath.note AS base_wreath_note, base_wreath.id AS base_wreath_id
							FROM special_wreath,base_wreath
							WHERE special_wreath.base_wreath_id=base_wreath.id AND special_wreath.name='".$row_wreaths["wreath_name"]."'";
				
				$result_wreath = $con->query($query_wreath);

				while ($row_wreath = mysqli_fetch_array($result_wreath)) {
				
					$wreaths[$row_wreath["base_wreath_id"]]++; 
				
					$query_flowers = "	SELECT conect_flower_special_wreath.id_flower, conect_flower_special_wreath.priece 
										FROM `conect_flower_special_wreath`
										WHERE conect_flower_special_wreath.special_wreath_id = '".$row_wreath['id']."';";

					$result_flowers = $con->query($query_flowers);

					while ($row_flower = mysqli_fetch_array($result_flowers)) {
						$flowers[$row_flower["id_flower"]] += $row_flower["priece"];
					}
				}
			}
	
			$query_wreaths = "SELECT *
						FROM order_items
						WHERE order_id='".$row["id"]."' AND is_offer=1";
						
			$result_wreaths = $con->query($query_wreaths);

			while ($row_wreaths = mysqli_fetch_array($result_wreaths)) {
				$query_wreath = "SELECT offer_wreath.id, offer_wreath.name, offer_wreath.note, offer_wreath.calculate_price, offer_wreath.sale_price, base_wreath.price, base_wreath.size, base_wreath.note AS base_wreath_note, base_wreath.id AS base_wreath_id
		FROM offer_wreath,base_wreath
		WHERE offer_wreath.base_wreath_id=base_wreath.id AND offer_wreath.name='".$row_wreaths["wreath_name"]."'";
				
				$result_wreath = $con->query($query_wreath);

				while ($row_wreath = mysqli_fetch_array($result_wreath)) {
					$wreaths[$row_wreath["base_wreath_id"]]++; 

					$query_flowers = "	SELECT conect_flower_offer_wreath.id_flower, conect_flower_offer_wreath.priece
						FROM `conect_flower_offer_wreath`
						WHERE conect_flower_offer_wreath.offer_wreath_id = '".$row_wreath['id']."';";

					$result_flowers = $con->query($query_flowers);

					while ($row_flower = mysqli_fetch_array($result_flowers)) {
								$flowers[$row_flower["id_flower"]] += $row_flower["priece"];
					}
				}
			}
		}

		$query = "SELECT *
				FROM flower;";

		$result = $con->query($query);

		$pdf->ln(8);
		$pdf->SetTextColor(137,165,146); 
		$pdf->Cell(50,0,"Virág fajta",0,0,'L');
		$pdf->Cell(40,0,"Virág szín",0,0,'L');
		$pdf->Cell(30,0,'Darabszám',0,0,'L');
		$pdf->ln(6);
		
		$pdf->SetFont('Arial','',10);	//Betütípus beállítása
		$pdf->SetTextColor(0,0,0);
		while ($row = mysqli_fetch_assoc($result)) {
			if (isset($flowers[$row["id"]])){
				$pdf->Cell(50,0,$row["type"],0,0,'L');
				$pdf->Cell(40,0,$row["color"],0,0,'L');
				$pdf->Cell(30,0,$flowers[$row["id"]] . ' db',0,0,'L');
				$pdf->Ln(5);
			}
		}


	$pdf->Output();		//PDF fájl generálása
?>