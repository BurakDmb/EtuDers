<?php
if(isset($_POST['okul_numarasi'])){
    if(is_numeric($_POST['okul_numarasi'])&&strlen($_POST['okul_numarasi'])==9){
        setcookie("okul_numarasi", $_POST['okul_numarasi'], time()+3600*24*30,'/');  /* 30günlük geçerli */
        echo "Basarili";
    }
}