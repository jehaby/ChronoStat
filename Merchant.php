<?php
/**
 * Created by PhpStorm.
 * User: urf
 * Date: 9/2/14
 * Time: 11:55 AM
 */

class Merchant {
    //private $name;


    function __construct($name, $percent, array $declines) {
        $this->name = $name;
        $this->percent = $percent;
        $this->declines = $declines;
    }

    function toString() {
        $res =  "Name: " . $this->name . '  P: ' . $this->percent . ' ||| ';
        foreach ($this->declines as $d => $v) {
            $res .= $d . ': ' . $v . ' | ';
        }
        return $res;
    }
}

