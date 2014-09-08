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

include "Merchant.php";
include "Decline.php";
$merchants =  unserialize($_POST['merchants']);

$inc = '/home/urf/Dropbox/myprograms/php/libs/';
require_once $inc . 'phpxls/Classes/PHPExcel.php';
        // put your code here

$inputFileName = 'files/stat.xlsx';


$Reader = PHPExcel_IOFactory::createReaderForFile($inputFileName);
//$Reader->setReadDataOnly(true);
$objXLS = $Reader->load($inputFileName);

$objXLS->setActiveSheetIndex(0)->setCellValue('A3', 420);

function cookingMerchants() {
    global $merchants;

    var_dump($merchants);

    usort($merchants,
        function (Merchant $m1, Merchant $m2) {
            return ($m1->percent == $m2->percent) ? 0 : (($m1->percent < $m2->percent) ? -1 : 1);
        });

    $key_sum = 0;
    foreach($merchants as $key => $merchant) {
        $key_sum += $merchant->percent;
        $n_merchants[$key_sum] = $merchant;
        unset($merchants[$key]);
    }
    $merchants = $n_merchants;
    echo "<br>";echo "<br>";echo "<br>";
    var_dump($merchants);
}

cookingMerchants();

function generateDecline() {


    return new Decline('','');
}


//To read a value from cell A1 in sheet 0 (first sheet) use this code:
$value = $objXLS->getSheet(0)->getCell('A2')->getCalculatedValue();
// or to get calculated value, if there is a formula, etc
$value = $objXLS->getSheet(0)->getCell('A1')->getCalculatedValue();

        // Redirect output to a client’s web browser (Excel5)
//header('Content-Type: application/vnd.ms-excel');
//header('Content-Disposition: attachment;filename="01simple.xls"');
//header('Cache-Control: max-age=0');
//
//$objWriter = PHPExcel_IOFactory::createWriter($objXLS, 'Excel5');
//$objWriter->save('php://output');
exit;


?>

