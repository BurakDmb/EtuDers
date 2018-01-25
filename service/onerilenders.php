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
        $dersListesi = json_decode(file_get_contents('http://obs.etu.edu.tr:35/DersProgrami/api/ders/getlist/?dil=tr', false, $context), true);
        $oncekikod="";
        $bolumderslist=array();
        $bolumkod="";
        switch ($okulkod){
            default:
                echo(null);
                break;
            case '110':
                $bolumkod="BİL";
                break;
            case '120':
                $bolumkod="ELE";
                break;
            case '130':
                $bolumkod="END";
                break;
            case '150':
                $bolumkod="MAK";
                break;
            case '170':
                $bolumkod="BMM";
                break;
            case '180':
                $bolumkod="MBN";
                break;
            case '220':
                $bolumkod="TDE";
                break;
            case '230':
                $bolumkod="TAR";
                break;
            case '240':
                $bolumkod="İDE";
                break;
            case '250':
                $bolumkod="PSİ";
                break;
            case '310':
                $bolumkod="İŞL";
                break;
            case '320':
                $bolumkod="İKT";
                break;
            case '340':
                $bolumkod="UGİ";
                break;
            case '420':
                $bolumkod="İÇT";
                break;
            case '430':
                $bolumkod="EÜT";
                break;
            case '440':
                $bolumkod="GİT";
                break;
            case '460':
                $bolumkod="MİM";
                break;
            case '480':
                $bolumkod="SAT";
                break;
            case '510':
                $bolumkod="HUK";
                break;
            case '520':
                $bolumkod="TIP";
                break;
            case '650':
                $bolumkod="ULU";
                break;
        }
        foreach($dersListesi as $ders) { //bolum ders listesi elde edildi
            $derskodu = explode(" ", $ders['DersKodu'])[0];
            if ($bolumkod == $derskodu) {
                array_push($bolumderslist,$ders['DersID']);
            }
        }
        $dersprog=json_decode(file_get_contents('http://obs.etu.edu.tr:35/DersProgrami/api/dersprogramplan/getlist/'.$ogrencino, false, $context),true);
        $oneriprog = array();
        foreach ($bolumderslist as $oneridersid) {
            $tmpders = new Ders($oneridersid, 0);
            $olasilik = count($tmpders->Subeler);
            for ($i = 0; $i < $olasilik; $i++) {
                $tmpplan = new Plan();
                $tmpplan->subeEkle($dersprogsube);
                $tmpplan->subeEkle($tmpders->Subeler[$i]);
                if ($tmpplan->cakismasayisi == 0) {
                    $tmpobj = array();
                    $tmpobj['derskodu'] = $tmpders->derskodu;
                    $tmpobj['derssube'] = $tmpders->Subeler[$i]->SubeNo;
                    $tmpobj['dersprog'] = $tmpplan;
                    array_push($oneriprog, $tmpobj);
                }
            }
        }
        echo(json_encode($oneriprog));
    }
}