<?php
function sorguCounter($durum){
    $sorgu_name = __DIR__."/sorgu.txt";
    $eski_sorgu_name = __DIR__."/eski_sorgu.txt";
    if (!file_exists($sorgu_name)) {
        $fb = fopen($sorgu_name, "w");
        fwrite($fb,"0");
        fclose($fb);
    }
    if (!file_exists($eski_sorgu_name)) {
        $fb_eski = fopen($eski_sorgu_name, "w");
        fwrite($fb_eski,"0");
        fclose($fb_eski);
    }
    $f2 = fopen($sorgu_name,"r");
    $f3 = fopen($eski_sorgu_name,"r");
    $sorguVal = fread($f2, filesize($sorgu_name));
    $eskiSorguVal = fread($f3, filesize($eski_sorgu_name));
    fclose($f2);
    if($durum==0){
        return $sorguVal;
    }
    else if($durum==2){
        return $eskiSorguVal;
    }
    else if($durum==1){

        $sorguVal++;
        $f2 = fopen($sorgu_name, "w");
        fwrite($f2, $sorguVal);
        fclose($f2);
    }

}
?>