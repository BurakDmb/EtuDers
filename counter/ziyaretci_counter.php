<?php
function ziyaretciCounter($durum)
{
    $counter_name = __DIR__."/counter.txt";

    if (!file_exists($counter_name)) {
        $fa = fopen($counter_name, "w");
        fwrite($fa, "0");
        fclose($fa);
    }

    $f1 = fopen($counter_name, "r");
    $counterVal = fread($f1, filesize($counter_name));
    fclose($f1);


    if (!isset($_COOKIE["ziyaret"])) {
        setcookie("ziyaret", "evet", time() + 3600 * 24 * 30, '/');  /* 30günlük geçerli */


        $counterVal++;
        $f = fopen($counter_name, "w");
        fwrite($f, $counterVal);
        fclose($f);
    }



//echo "Tekil ziyaretçi sayısı: $counterVal ";
}


