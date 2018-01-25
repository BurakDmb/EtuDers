<?php


class Sube
{

    public $SubeNo;
    public $OgretimUyesi;
    public $Saatler;
    public $DersKodu;
    public function __construct($subeno,$hoca, $saatler, $derskodu){

        $this->Saatler=array();
        $this->DersNo=$derskodu;
        $this->SubeNo=$subeno;
        $this->DersKodu=$derskodu;
        $this->OgretimUyesi=$hoca;
        foreach ($saatler as $sube){
            foreach ($sube['OgrenciDersProgram'] as $saat){
                if(isset($saat['DersKoduList'][0]))
                    array_push($this->Saatler,new Saat($saat['Baslangic'], $saat['Bitis'], $saat['Gun'], $saat['DersKoduList'],$this->SubeNo,$this->DersKodu));
                else if(isset($saat['DersKodu'])&&$saat['DersKodu']!="-")
                    array_push($this->Saatler,new Saat($saat['Baslangic'], $saat['Bitis'], $saat['Gun'], $saat['DersKoduList'],$this->SubeNo,$saat['DersKodu']));
            }
        }


    }
}