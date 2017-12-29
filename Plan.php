<?php

class Plan
{

    public $grid;
    public $saatsayisi;
    public $cakismasayisi;

    public function __construct(){
        $this->grid=array();
        $this->saatsayisi=0;
        $this->cakismasayisi=0;

    }
function subeEkle($sube){
    foreach ($sube->Saatler as $saat) {
        $d = strtotime($saat->baslangic);
        $saatindeks = date("G:i:s", $d) - date("G:i:s", strtotime("08:30:00"));
        $gunindeks = $saat->gun - 1;
        if ($saat->yer[0]!="-"){
            $this->grid[$saatindeks][$gunindeks][]=$saat;
            $this->saatsayisi++;

        }
    }
    $this->cakismahesapla();
}
function cakismahesapla(){
    $this->cakismasayisi=0;
    for($i=0;$i<13;$i++){
        for($j=0;$j<6;$j++){
            if(isset($this->grid[$i][$j])){
                if(count($this->grid[$i][$j])>1)
                    $this->cakismasayisi++;
            }
        }
    }
}


}