<?php
function getThaiDate($dateString) {
    if (!$dateString) return "-";
    $timestamp = strtotime($dateString);
    
    $thai_months = [
        1 => 'มกราคม', 2 => 'กุมภาพันธ์', 3 => 'มีนาคม', 4 => 'เมษายน',
        5 => 'พฤษภาคม', 6 => 'มิถุนายน', 7 => 'กรกฎาคม', 8 => 'สิงหาคม',
        9 => 'กันยายน', 10 => 'ตุลาคม', 11 => 'พฤศจิกายน', 12 => 'ธันวาคม'
    ];

    $day = date('j', $timestamp);
    $month = $thai_months[(int)date('n', $timestamp)];
    $year = date('Y', $timestamp) + 543;

    return "$day $month $year";
}
