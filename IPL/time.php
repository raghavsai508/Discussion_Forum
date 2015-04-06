<?php

$myvalue = '28-1-2011 14:32:55';

$datetime = new DateTime($myvalue);

$date = $datetime->format('Y-m-d');
$time = $datetime->format('H:i:s');

echo $date ;
echo '<br>';
echo $time;
echo '<br>';
echo date($date);
echo '<br>';

$today = date("F j, Y, g:i a");    
echo $today;
echo '<br>';

$datetime1 = "2014-03-23 18:58:27";
$date1 = date('Y-m-d', strtotime($datetime1));
$time1 = date('g:i a', strtotime($datetime1));

echo kjhsdakfjdfkj;
echo '<br>';echo '<br>';
echo $date1;
echo '<br>';
echo $time1;
echo '<br>';

echo date('M d, Y', strtotime($date1));
echo at;
echo $time1;
?>