<?
//$date = new DateTime();
$today = getdate();
//print_r($today);
//echo $today[seconds];

$time1=$today[hours].':'.$today[minutes].':'.$today[seconds];
$day=$today[mon].'/'.$today[mday].'/'.$today[year];
echo $time1;
echo "<br>";
echo $day;
?>