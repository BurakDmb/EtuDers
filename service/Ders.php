<?php


class Ders
{
    public $dersAdi;
    public $derskodu;
    public $Subeler;
    public function __construct($dersid)
    {
        $opts = array(
            'http'=>array(
                'method'=>"GET",
                'header'=>"Accept-language: tr\r\n" .
                    "Cookie: foo=bar\r\n" .
                    "Accept: application/json\r\n"
            )
        );
        $context = stream_context_create($opts);

        $ders = json_decode(file_get_contents('http://obs.etu.edu.tr:35/DersProgrami/api/dersprogramplan/dersProgram/'.$dersid.'/0?dil=tr', false, $context),true);
        $dersadi=json_decode(file_get_contents('http://obs.etu.edu.tr:35/DersProgrami/api/ders/get/'.$dersid.'/?dil=tr', false, $context),true);
        $this->derskodu=$dersadi['DersKodu'];
        $this->dersAdi=$dersadi['DersAdi'];
        $this->Subeler=array();
        foreach($ders as $subeler) { //foreach element in $arr
            array_push($this->Subeler, new Sube($subeler['SubeNo'], $subeler['OgretimUyesi'], $subeler['DersProgramPlan'], $this->derskodu));
        }
    }

}