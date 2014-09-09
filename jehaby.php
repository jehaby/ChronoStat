<?php

error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);


$arr = range(1, 10);

end($arr);
foreach($arr as $k => $v) {
    if ($v % 3 == 0){
        unset($arr[$k]);
    }
    $arr[$k*$k] = 0;
}

print_r($arr);