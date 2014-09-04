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


$document = simplexml_load_file('merchants.xml');

$merchants = [];

foreach ($document->merchant as $m) {
    $declines = [];
    $attr = '';
    foreach ($m->declines->children() as $decline) {
        if ($decline->getName() == 'others') {
                $attr = ' ' . $decline -> attributes()['text'];
        }
        $declines[$decline->getName()] = $decline . $attr;
    }
    $merchants[(string)$m->name] = new Merchant($m->name, $m->percent, $declines);
}

//var_dump($merchants);