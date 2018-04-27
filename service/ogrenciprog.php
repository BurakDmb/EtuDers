<?php
if(isset($_POST['okul_numarasi'])){
    ini_set('display_startup_errors', 1);
    ini_set('display_errors', 1);
    error_reporting(-1);
    include 'programhesapla.php';
    $ogrencino=$_POST['okul_numarasi'];
    $okulkod=substr($ogrencino,2,3);
    $opts = array(
        'http'=>array(
            'method'=>"GET",
            'header'=>"Accept-language: tr\r\n" .
                "Cookie: foo=bar\r\n" .
                "Accept: application/json\r\n"
        )
    );
    $context = stream_context_create($opts);
    $dersprog=json_decode(file_get_contents('http://obs.etu.edu.tr:35/DersProgrami/api/dersprogramplan/getlist/'.$ogrencino, false, $context),true);

    if($dersprog!=null){
        $dersprogsube=new Sube(0,'',$dersprog,0);
        $oncekikod="";
        $bolumderslist=array();
        $bolumkod="";

        $oneriprog = new Plan();
        $oneriprog->subeEkle($dersprogsube);
        echo(json_encode($oneriprog));
    }
}