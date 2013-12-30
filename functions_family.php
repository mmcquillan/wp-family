<?php

function family_year_array() {
    $years = 1000;
    $now = date("Y");
    $ret = array('');
    for ($i = $now; $i> ($now-$years); $i--) {
        array_push($ret, $i);
    }
    return $ret;
}

function family_month_array() {
    return array('', 'JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC');
}

function family_day_array() {
    return array('','1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31');
}

function family_date_encode( $year, $month, $day ) {
    if($year == '') {
        $year = '0000';
    }
    switch ($month) {
        case "JAN":
            $month = '01';
            break;
        case "FEB":
            $month = '02';
            break;
        case "MAR":
            $month = '03';
            break;
        case "APR":
            $month = '04';
            break;
        case "MAY":
            $month = '05';
            break;
        case "JUN":
            $month = '06';
            break;
        case "JUL":
            $month = '07';
            break;
        case "AUG":
            $month = '08';
            break;
        case "SEP":
            $month = '09';
            break;
        case "OCT":
            $month = '10';
            break;
        case "NOV":
            $month = '11';
            break;
        case "DEC":
            $month = '12';
            break;
        default:
            $month = '00';
    }
    if(is_numeric($day)) {
        if($day < 10) {
            $day = '0' . $day;
        }
    }
    else {
        $day = '00';
    }
    return $year . $month . $day;
}

function family_date_get_year($date) {
    $y = substr($date, 0, 4);
    if($y == '0000') {
        return '';
    }
    else {
        return $y;
    }
}


function family_date_get_month($date) {
    $m = substr($date, 4, 2);
    $mons = family_month_array();
    if($m == '00') {
        return '';
    }
    elseif(strpos($m, '0') === 0) {
        return $mons[substr($m, 1, 1)];
    }
    else {
        return $mons[$m];
    }
}

function family_date_get_day($date) {
    $d = substr($date, 6, 2);
    if($d == '00') {
        return '';
    }
    elseif(strpos($d, '0') === 0) {
        return substr($d, 1, 1);
    }
    else {
        return $d;
    }
}

function family_date_display($date) {
    return family_date_get_day($date) . ' ' . family_date_get_month($date) . ' ' . family_date_get_year($date);
}

?>