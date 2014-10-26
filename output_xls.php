<?php
/**
 * Created by PhpStorm.
 * User: urf
 * Date: 8/31/14
 * Time: 4:54 PM
 */
//error_reporting(E_ALL);
//ini_set('display_errors', TRUE);
//ini_set('display_startup_errors', TRUE);



if (file_exists('vendor/autoload.php')) {
    require 'vendor/autoload.php';
}

Kint::enabled(false);

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

include "Merchant.php";
$merchants =  unserialize($_POST['merchants']);
$total_calls = (int) $_POST['total_calls'];

d($merchants);

//$inc = '/home/urf/Dropbox/myprograms/php/libs/';
//require_once $inc . 'phpxls/Classes/PHPExcel.php';
//
//include $inc . 'krumo/class.krumo.php';
//
//krumo::disable();

$inputFileName = 'files/stat.xls';

date_default_timezone_set('Europe/Moscow');

$Reader = PHPExcel_IOFactory::createReaderForFile($inputFileName);
$objXLS = $Reader->load($inputFileName);

function cook_declines($declines) {
    foreach($declines as $k => $v) {
        if (!$v || $v == ' ') {
            unset($declines[$k]);
        } else {
            $declines[$k] = (int) $v;
        }
    }
    asort($declines);

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

    $merchant_percent_sum = 0;
    foreach($merchants as $key => $merchant) {
        $merchant_percent_sum += $merchant->percent;
        $merchant -> declines = cook_declines($merchant -> declines);
        $n_merchants[$merchant_percent_sum] = $merchant;
        unset($merchants[$key]);
    }
    $merchants = $n_merchants;
//    krumo($merchants);
    return $merchants;
}

function pick_random_element($arr) {
    end($arr);
    $total_percent = key($arr);
    $random_int = rand(0, $total_percent - 1);
    foreach($arr as $k => $v) {
        if ($random_int < $k)
            return $v;
    }
}

$merchants = cook_merchants($merchants);

d($merchants);

function write_declines_to_table() {
    global $total_calls, $merchants, $objXLS, $mapping;
    for ($i = 3; $i < $total_calls + 3; $i++) {
        $merch = pick_random_element($merchants);

        d($merch);

        $dec = pick_random_element($merch -> declines);
        d($dec[1]);
        d($mapping[$dec[1]] . $i);
        $objXLS->setActiveSheetIndex(0)->setCellValue($mapping[$dec[1]] . $i, 1);
        $objXLS->setActiveSheetIndex(0)->setCellValue("L" . $i, $merch -> name);
    }
}
write_declines_to_table();

 //Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="01simple.xls"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objXLS, 'Excel5');
$objWriter->save('php://output');
exit;
?>

