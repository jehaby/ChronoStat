<?php
/**
 * Created by PhpStorm.
 * User: urf
 * Date: 9/8/14
 * Time: 4:06 PM
 */

class Decline {

    private $mapping = [
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

    function __construct($m_name, $reason) {
        $this->m_name = (string) $m_name;
        $this->reason = (string) $reason;
    }

    function getCell($row_number) {
        return $this->mapping[$this->reason] . $row_number;
    }

} 