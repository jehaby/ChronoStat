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

$mapping = [
    "emitent" => "A",
    "tech" => "C",
    "chrono" => "D",
    "filling" => "E",
    "didntget" => "F",
    "refund" => "G",
    "monthly" => "H",
    "wrong" => "I",
    "others" => "K"
];

include_once 'helper_functions.php';


include "Merchant.php";
include "Decline.php";
$merchants =  unserialize($_POST['merchants']);

$inc = '/home/urf/Dropbox/myprograms/php/libs/';
require_once $inc . 'phpxls/Classes/PHPExcel.php';
// put your code here
include $inc . 'krumo/class.krumo.php';

krumo::enable();

$inputFileName = 'files/stat.xlsx';

$Reader = PHPExcel_IOFactory::createReaderForFile($inputFileName);
$objXLS = $Reader->load($inputFileName);

$merchant_percent_sum = 0;
$total_declines = 50;

function cook_declines($declines) {
    foreach($declines as $k => $v) {
        if (!$v || $v == ' ') {
            unset($declines[$k]);
        } else {
            $declines[$k] = (int) $v;
        }
    }
    asort($declines);
//    krumo($declines);

    $declines_percent_sum = 0;
    foreach($declines as $k => $v) {
        $declines_percent_sum += $v;
        $n_declines[$declines_percent_sum] = [$v, $k];
        unset($declines[$k]);
    }
    unset($declines);
    return $n_declines;
}

function cook_merchants($merchants) {
    usort($merchants,
        function (Merchant $m1, Merchant $m2) {
            return ($m1->percent == $m2->percent) ? 0 : (($m1->percent < $m2->percent) ? -1 : 1);
        });

    global $merchant_percent_sum;
    foreach($merchants as $key => $merchant) {
        $merchant_percent_sum += $merchant->percent;
        $merchant -> declines = cook_declines($merchant -> declines);
        $n_merchants[$merchant_percent_sum] = $merchant;
        unset($merchants[$key]);
    }
    $merchants = $n_merchants;
    krumo($merchants);
    return $merchants;
}

function pick_random_element($arr) {
    end($arr);
    $total_percent = key($arr);
    $random_int = rand(0, $total_percent);
    foreach($arr as $k => $v) {
        if ($random_int < $k)
            return $v;
    }
}

$merchants = cook_merchants($merchants);

function write_declines_to_table() {
    global $total_declines, $merchants, $objXLS, $mapping;
    for ($i = 3; $i < $total_declines + 3; $i++) {
        $merch = pick_random_element($merchants);
        krumo($merch);
        $dec = pick_random_element($merch -> declines);
        $objXLS->setActiveSheetIndex(0)->setCellValue($mapping[$dec[1]] . $i, 1);

//        $objXLS->setActiveSheetIndex(0)->setCellValue("L" . $i, $merch -> name);
    }
}
write_declines_to_table();

// Redirect output to a client’s web browser (Excel5)
//header('Content-Type: application/vnd.ms-excel');
//header('Content-Disposition: attachment;filename="01simple.xls"');
//header('Cache-Control: max-age=0');
//
//$objWriter = PHPExcel_IOFactory::createWriter($objXLS, 'Excel5');
//$objWriter->save('php://output');
//exit;
?>

