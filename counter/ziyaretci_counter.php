<?php
session_start();
$counter_name = "counter.txt";

// Check if a text file exists. If not create one and initialize it to zero.
if (!file_exists($counter_name)) {
    $fa = fopen($counter_name, "w");
    fwrite($fa,"0");
    fclose($fa);
}

// Read the current value of our counter file
$f1 = fopen($counter_name,"r");
$counterVal = fread($f1, filesize($counter_name));
fclose($f1);

// Has visitor been counted in this session?
// If not, increase counter value by one
if(!isset($_COOKIE['ziyaret'])){

    setcookie('ziyaret', 'evet',time()+(10*365*24*60*60));
    $_COOKIE['ziyaret'] = 'evet';

    $_SESSION['ziyaret']="evet";
    $counterVal++;
    $f = fopen($counter_name, "w");
    fwrite($f, $counterVal);
    fclose($f);
}
echo "Tekil ziyaretçi sayısı: $counterVal ";
