<?php
function sorguCounter($durum){
    $sorgu_name = __DIR__."/sorgu.txt";
    if (!file_exists($sorgu_name)) {
        $fb = fopen($sorgu_name, "w");
        fwrite($fb,"0");
        fclose($fb);
    }
    $f2 = fopen($sorgu_name,"r");
    $sorguVal = fread($f2, filesize($sorgu_name));
    fclose($f2);
    if($durum==0){
        return $sorguVal;
    }
    else{

        $sorguVal++;
        $f2 = fopen($sorgu_name, "w");
        fwrite($f2, $sorguVal);
        fclose($f2);
    }

}
?>