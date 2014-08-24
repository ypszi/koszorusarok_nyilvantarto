<?php
include '../../../config.php';

// mysql_set_charset('utf8_hungarian_ci');
// mysql_query('SET CHARACTER SET latin2;');

/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/London');

include '../../../excel/Classes/PHPExcel/IOFactory.php';
require_once '../../../excel/Classes/PHPExcel.php';

//  Include PHPExcel_IOFactory

// FÁJL FELTÖLTÉS

	$xls_file = "";
	$target = "upload/";
	if (isset($_FILES['xls_upload']) === true) {
		$files = $_FILES['xls_upload'];

		$filename = $files['name'];
		$ftmp_name = $files['tmp_name'];
		$filetype = $files['type'];
		$filesize = $files['size'];

		move_uploaded_file($ftmp_name, $target . $filename);
	}

// FÁJL FELTÖLTÉS VÉGE

$inputFileName = (isset($_FILES['xls_upload']) ? $filename : 'default.xls');

//  Read your Excel workbook
try {
    $inputFileType = PHPExcel_IOFactory::identify("upload/" . $inputFileName);
    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
    $objPHPExcel = $objReader->load("upload/" . $inputFileName);
} catch(Exception $e) {
    die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
}


	$highestColumm = $objPHPExcel->setActiveSheetIndex(0)->getHighestColumn(); //Legutolso oszlop
	$highestRow = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow(); //Legutolso sor

	$objPHPExcel->setActiveSheetIndex(0);

	$shp_id = $objPHPExcel->getActiveSheet()->getCell('H2');
	
	$i = 5;
	$is_set_data = true;
	
	$query="DELETE FROM shopping_cart_item WHERE shopping_cart_id=". $shp_id .";";
	mysql_query($query);
	
	$str = "INSERT INTO shopping_cart_item (shopping_cart_id, product, required_number, buying_number, price, sale_price, note) VALUES ";

	while (($i<=$highestRow-2) && $is_set_data ) { //fontos h sorfolytonosan töltse fel az excell-t
		$name = $objPHPExcel->getActiveSheet()->getCell('B'.$i);
		if (isset($name) && $name!=""){
			$str .= "(" . $shp_id . ", '" . $name . "'";

			if ($objPHPExcel->getActiveSheet()->getCell('C'.$i) != "") {
				$str .= ", " . $objPHPExcel->getActiveSheet()->getCell('C'.$i);
			} else {
				$str .= ", 0";
			}

			if ($objPHPExcel->getActiveSheet()->getCell('D'.$i) != "") {
				$str .= "," . $objPHPExcel->getActiveSheet()->getCell('D'.$i);
			} else {
				$str .= ", 0";
			}

			if ($objPHPExcel->getActiveSheet()->getCell('E'.$i) != "") {
				$str .= "," . $objPHPExcel->getActiveSheet()->getCell('E'.$i);
			} else {
				$str .= ", 0";
			}

			if ($objPHPExcel->getActiveSheet()->getCell('G'.$i) != "") {
				$str .= "," . $objPHPExcel->getActiveSheet()->getCell('G'.$i);
			} else {
				$str .= ", 0";
			}

			$str .= ",'" . $objPHPExcel->getActiveSheet()->getCell('H'.$i) . "'),";
		}else{
			$is_set_data = false;
		}

		$i++;
	}
	
	$str = substr($str,0, -1) . ";";
	
	mysql_query($str);

?>