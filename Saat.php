<?php
/**
 * Created by PhpStorm.
 * User: burak
 * Date: 29.12.2017
 * Time: 01:11
 */

class Saat {

    public $dersno;
    public $subeno;
    public $baslangic ;
    public $bitis;
    public $gun;
    public $yer ;

    function __construct($bas,$bit,$gun,$yer,$subeno,$dersno) {
        $this->baslangic=$bas;
        $this->bitis=$bit;
        $this->gun=$gun;
        $this->yer=$yer;
        $this->subeno=$subeno;
        $this->dersno=$dersno;
    }


}