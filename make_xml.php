<?php
/**
 * Created by PhpStorm.
 * User: urf
 * Date: 9/5/14
 * Time: 6:28 PM
 */
//error_reporting(E_ALL);
ini_set('display_errors', FAlSE);
ini_set('display_startup_errors', FALSE);

include 'Merchant.php';

$merchants =  unserialize($_POST['merchants']);

//var_dump($merchants);
header('Content-Type: text/xml');

ob_start();

echo '<merchants>';

foreach ($merchants as $merchant) {
    echo "<merchant>\n";
    echo "<name>" . $merchant->name . "</name>\n";
    echo "<percent>" . $merchant->percent . "</percent>\n";
    echo "<declines>\n";
    foreach ($merchant->declines as $decline => $percent) {
        if ($decline == 'others') {
            list($others_percent, $text) = explode(' ', $percent, 2);
            if ($others_percent && $percent)
                echo "<others text='{$text}'>" . $others_percent . "</others>\n";
        } else {
            if (!$percent) $percent = '';
            echo "<{$decline}>" . $percent . "</{$decline}>\n";
        }
    }
    echo "</declines>\n";
    echo "</merchant>\n\n";
}

echo "</merchants>\n";

file_put_contents('files/output.xml', ob_get_clean());



