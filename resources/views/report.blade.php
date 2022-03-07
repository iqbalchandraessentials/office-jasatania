<?php
$sdate    = date('Y-m-01');
$edate = date('Y-m-d');
// $edate     =  date('Y-m-t');

$start = new DateTime($sdate);
$end = new DateTime($edate);
// otherwise the  end date is excluded (bug?)
$end->modify('+1 day');

$interval = $end->diff($start);

// total days
$days = $interval->days;

// create an iterateable period of date (P1D equates to 1 day)
$period = new DatePeriod($start, new DateInterval('P1D'), $end);

// best stored as array, so you can add more than one
$holidays = array('');

foreach ($period as $dt) {
    $curr = $dt->format('D');

    // substract if Saturday or Sunday
    if ($curr == 'Sat' || $curr == 'Sun') {
        $days--;
    }

    // (optional) for the updated question
    elseif (in_array($dt->format('Y-m-d'), $holidays)) {
        $days--;
    }
}

$totalMasuk = $jml_masuk;

$percent = $totalMasuk / $days * 100;

echo $totalMasuk . '/' . $days . '=' . round($percent) . '%';
