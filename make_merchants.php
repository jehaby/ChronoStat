<?php
/**
 * Created by PhpStorm.
 * User: urf
 * Date: 9/1/14
 * Time: 9:02 AM
 */
include_once 'Merchant.php';

//error_reporting(E_ALL);
//ini_set('display_errors', TRUE);
//ini_set('display_startup_errors', TRUE);

if (($_SERVER['REQUEST_METHOD'] == 'POST') && $_POST['use_merchantsxml']) {
    $document = simplexml_load_file('files/merchants.xml');
} else {
    $document = simplexml_load_file('files/output.xml');
}

$merchants = [];

foreach ($document->merchant as $m) {
    $declines = [];
    $attr = '';
    foreach ($m->declines->children() as $decline) {
        $declines[$decline->getName()] = $decline . '';
        if ($decline->getName() == 'others') {
            $attr = ' ' . $decline -> attributes()['text'];
            $declines[$decline->getName()] .= $attr;
        }
    }
    $merchants[(string)$m->name] = new Merchant($m->name, $m->percent, $declines);
}

