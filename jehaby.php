<?php

error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

$arr = ['a', 'b', '43', 'e'];

var_dump($GLOBALS);

extract($arr, EXTR_PREFIX_ALL, 'arr');

echo "<br>";
var_dump($GLOBALS);