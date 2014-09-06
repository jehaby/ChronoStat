<?php
/**
 * Created by PhpStorm.
 * User: urf
 * Date: 9/5/14
 * Time: 6:28 PM
 */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

include 'Merchant.php';

$merchants =  unserialize($_POST['merchants']);
//$mapping =  unserialize($_POST['mapping']);

//var_dump($merchants);
header('Content-Type: text/xml');

echo '<merchants>';

foreach ($merchants as $merchant) {
    echo "<merchant>\n";
    echo "<name>" . $merchant->name . "</name>\n";
    echo "<percent>" . $merchant->percent . "</percent>\n";
    echo "<declines>\n";
    foreach ($merchant->declines as $decline => $percent) {
        if ($decline == 'others') { //bug!
            $m = explode(' ', $percent, 2); // $m[0] -- percent, $m[] -- text
            if (count($m) == 2)
                echo "<others text='{$m[1]}'>" . $m[0] . "</others>\n";
        } else {
            if (!$percent) $percent = ' ';
            echo "<{$decline}>" . $percent . "</{$decline}>\n";
        }
    }
    echo "</declines>\n";
    echo "</merchant>\n\n";
}

echo "</merchants>\n";



