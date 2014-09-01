<?php
/**
 * Created by PhpStorm.
 * User: urf
 * Date: 8/31/14
 * Time: 4:54 PM
 */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

$inc = '/home/urf/Dropbox/myprograms/php/libs/';
require_once $inc . 'phpxls/Classes/PHPExcel.php';
        // put your code here

//$objPHPExcel = new PHPExcel();

$inputFileName = 'files/stat.xls';

$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
$objPHPExcel2 = new PHPExcel();

$Reader = PHPExcel_IOFactory::createReaderForFile($inputFileName);
$Reader->setReadDataOnly(true);

$objXLS = $Reader->load($inputFileName);

//To read a value from cell A1 in sheet 0 (first sheet) use this code:

$value = $objXLS->getSheet(0)->getCell('A1')->getValue();
// or to get calculated value, if there is a formula, etc
$value = $objXLS->getSheet(0)->getCell('A1')->getCalculatedValue();




//$objXLS->getSheet(0)->setCellValue('A3', 10);

//$objPHPExcel -> setActiveSheetIndex(0)
//        -> setCellValue('A2', '666')
//        -> setCellValue('A3', 'wtf');
//
//
//for ($i = 2; $i < 100; $i++) {
//    $objPHPExcel ->getActiveSheet()
//            ->setCellValue('A' . $i, ''. $i * $i);
//    }

        // Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="01simple.xls"');
header('Cache-Control: max-age=0');
//
//
//
$objWriter = PHPExcel_IOFactory::createWriter($objXLS, 'Excel5');
$objWriter->save('php://output');
exit;


