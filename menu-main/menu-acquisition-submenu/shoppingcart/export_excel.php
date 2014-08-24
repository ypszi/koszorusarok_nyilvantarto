<?php
include '../../../config.php';

//mysql_set_charset('utf8_hungarian_ci');
//mysql_query('SET CHARACTER SET latin2;');

mysql_set_charset('utf8_general_ci');
mysql_query('SET CHARACTER SET utf8_general_ci;');
	

/** Error reporting */
//error_reporting(E_ALL);
//ini_set('display_errors', TRUE);
//ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/London');

require_once '../../../excel/Classes/PHPExcel.php';


$objPHPExcel = new PHPExcel();

$objPHPExcel->getProperties()->setCreator("Protea Family Kft.")
							 ->setLastModifiedBy("Maarten Balliauw")
							 ->setTitle("Bevásárló lista")
							 ->setSubject("Virágok, koszorú alapok, kiegészítők")
							 ->setDescription("Bevásárló lista az árukészlet feltöltése érdekében.")
							 ->setKeywords("Virágok, koszorú alapok, kiegészítők")
							 ->setCategory("Bevásárlás");

$objPHPExcel->getActiveSheet()->setTitle('Bevásárló lista');
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

echo date('H:i:s') , " Add some data" , EOL;
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('B1', 'Bevásárló lista neve:')
            ->setCellValue('B2', 'Megjegyzés:')
            ->setCellValue('G1', 'Dátum:')
            ->setCellValue('G2', 'Azonosító:');

	$query = "SELECT id,name,note,date
			  FROM shopping_cart
			  WHERE id = ".$_GET['id'].";";

	$result = mysql_query($query) or die(mysql_error());

	while ($row = mysql_fetch_assoc($result)) {
		$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('C1', $row['name'])
				->setCellValue('C2', $row['note'])
				->setCellValue('H1', date("Y-m-d",strtotime($row["date"])))
				->setCellValue('H2', $row["id"]);
		$objPHPExcel->getActiveSheet()->getStyle('H1')->getNumberFormat()->setFormatCode("yyyy mmmm dd");
	}
			
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(6);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(14);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('B4', 'Termék neve')
            ->setCellValue('C4', 'Igényelt db')
            ->setCellValue('D4', 'Megvett db')
            ->setCellValue('E4', 'Beszerzési ár')
            ->setCellValue('F4', 'Részösszeg')
            ->setCellValue('G4', 'Eladási ár')
            ->setCellValue('H4', 'Megjegyzés');

			$objPHPExcel->getActiveSheet()->getStyle('A4:H4')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);	
			
	$query = "SELECT id, shopping_cart_id, product, required_number, buying_number, price, sale_price, note
			  FROM shopping_cart_item WHERE shopping_cart_id = ".$_GET['id']." AND archive = 0;";

	$result = mysql_query($query) or die(mysql_error());

	$i = 5;
	while ($row = mysql_fetch_assoc($result)) {
		$objPHPExcel->setActiveSheetIndex(0)
		    	->getRowDimension($i)
		    	->setRowHeight(25);

		$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A'.$i, "#".($i-4))		
				->setCellValue('B'.$i, $row['product'])
				->setCellValue('C'.$i, $row['required_number'])
				->setCellValue('D'.$i, $row['buying_number'])
				->setCellValue('E'.$i, $row['price'])
				->setCellValue('F'.$i, '=D'.$i.'*E'.$i)
				->setCellValue('G'.$i, $row['sale_price'])
				->setCellValue('H'.$i, $row['note']);
			
		$objPHPExcel->getActiveSheet()->getStyle('E'.$i)->getNumberFormat()->setFormatCode("# ##0 Ft");
		$objPHPExcel->getActiveSheet()->getStyle('F'.$i)->getNumberFormat()->setFormatCode("# ##0 Ft");
		$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getNumberFormat()->setFormatCode("# ##0 Ft");

		$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);

		$i++;
	}
	
	$objPHPExcel->getActiveSheet()->getStyle('A'.$i.':H'.$i)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);	
	
	for ($j=0; $j<10; $j++){

		$objPHPExcel->setActiveSheetIndex(0)
		    	->getRowDimension($i)
		    	->setRowHeight(25);

		$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A'.$i, "#".($i-4))		
				->setCellValue('F'.$i, '=D'.$i.'*E'.$i);
	
		$objPHPExcel->getActiveSheet()->getStyle('E'.$i)->getNumberFormat()->setFormatCode("# ##0 Ft");
		$objPHPExcel->getActiveSheet()->getStyle('F'.$i)->getNumberFormat()->setFormatCode("# ##0 Ft");
		$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getNumberFormat()->setFormatCode("# ##0 Ft");
		$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);

		$i++;
	}
	
	$objPHPExcel->getActiveSheet()->getStyle('A'.$i.':H'.$i)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);	

	$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('E'.($i+1), 'Összesen:')
			->setCellValue('F'.($i+1), '=SUM(F5:F'.($i-1).')');

	$objPHPExcel->getActiveSheet()->getStyle('F'.($i+1))->getNumberFormat()->setFormatCode("# ##0 Ft");
	$objPHPExcel->getActiveSheet()->getStyle('F'.($i+1))->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
	


// Save Excel 2007 file
//echo date('H:i:s') , " Write to Excel2007 format" , EOL;
//$callStartTime = microtime(true);

//$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
//$objWriter->save(str_replace('.php', '.xlsx', __FILE__));
//$callEndTime = microtime(true);
//$callTime = $callEndTime - $callStartTime;

//echo date('H:i:s') , " File written to " , str_replace('.php', '.xlsx', pathinfo(__FILE__, PATHINFO_BASENAME)) , EOL;
//echo 'Call time to write Workbook was ' , sprintf('%.4f',$callTime) , " seconds" , EOL;
// Echo memory usage
//echo date('H:i:s') , ' Current memory usage: ' , (memory_get_usage(true) / 1024 / 1024) , " MB" , EOL;


$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

$filename = 'documents/'.$_GET['id'].'_excel_'.$_GET['date'].'.xlsx';

$objWriter->save($filename);

// Save Excel 95 file
echo date('H:i:s') , " Write to Excel5 format" , EOL;
$callStartTime = microtime(true);

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

$filename = 'documents/'.$_GET['id'].'_excel_'.$_GET['date'].'.xls';

$objWriter->save($filename);

?>