<div class="jumbotron col-md-8 offset-md-2 bg-light bootstrap-fs-modal">
    <h4 class="display-4 text-center">EtuDers - Ders Programı Oluşturucu</h4>
    <p class="lead text-center">
        Ders programı oluşturma aracımızla, normalde oldukça uğraştırıcı olan kendi ders programınızı oluşturma sürecinizi saniyelere indiriyoruz.
        Mantık olarak seçtiğiniz dersleri kendi aralarındaki tüm kombinasyonlarını hesaplayıp, sizin istediğiniz çakışma limitinden az olan programları size sunuyoruz, bu sayede size uygun ders programlarını kolayca görebilir ve ders kayıt dönemini kolayca atlatabilirsiniz.

    </p>
    <hr class="my-4">
    <p class="lead text-center">
        Ders listesi ve şube bilgileri sorgu yapılırken anlık olarak ETU-OBS 'den otomatik alınmaktadır, alınan bilgilerin tamamına normal bir öğrenci de erişebilir.
        EtuDers sadece bu ders bilgilerine hızlı sürede erişip, kendi sunucusunda hesaplama yaparak kullanıcıya istediği dersleri içeren ders programı çıktıları sunmaktadır.

    </p>
    <hr class="my-4">
    <p class="lead text-center">
        Bu site okulumuzdaki herkesin kolayca ders programı yapabilmesi için Burak Han Demirbilek tarafından yapılmıştır. Destek olmak için siteyi arkadaşlarınızla paylaşabilirsiniz <i class="far fa-smile"></i>
        <br>
        Her türlü öneri veya hata bildirimleriniz için <a href="mailto:burakhan.demirbilek@gmail.com?subject=EtuDers Hk." target="_top">burakhan.demirbilek@gmail.com</a> mail adresinden bana ulaşabilirsiniz.
        <br>
        <div class="row">

            <div class="lead col-md-6 text-center">
                <b><?php include __DIR__."/../counter/sorgu_counter.php";  echo "Geçen dönemki toplam sorgu sayısı: ".sorguCounter(2)?></b>
            </div>
        <div class="lead col-md-6 text-center">
            <b><?php  echo "Bu dönemki toplam sorgu sayısı: ".sorguCounter(0)?></b>
        </div>
        </div>
    </p>

    <hr class="my-4">
    <div class="container ">
        <form class="row" >
            <div id="dersList" class="col-md-6" >
                <div class="card">
                    <div class="card-header text-center">
                        <b>Ders Listesi</b>
                    </div>
                    <div class="card-body " style="height:550px;overflow-y: scroll;background-color: #f8f9fa">
                        <?php include __DIR__."/derslistesiform.php";?>
                    </div>
                </div>

            </div>
            <div class="col-md-6" >

                <div class="card">
                    <div class="card-header text-center">
                        <b>İşlemler</b>
                    </div>
                    <div  class="card-body text-center " >
                        <div class="row align-self-center">
                            <div class="card-group col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <span class="mx-auto " >
                                            <div class="form-group text-center">
                                                <label for="cakisma" >Maksimum çakışma limiti</label>
                                                <input type="text" class="form-control" id="cakisma" style="text-align:center" placeholder="Varsayılan: 2">

                                            </div>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="card-group col-md-12">

                                <div class="card col-md-12">
                                    <div class="card-body align-middle">
                                        <span class="mx-auto align-middle" >
                                            <button type="button" class="btn btn-success align-middle" id="submit"  >
                                                Hesapla
                                            </button>
                                        </span>
                                    </div>
                                </div>
                                <div class="card col-md-6">
                                    <div class="card-body">
                                        <span class="mx-auto " >
                                            <button type="button" onclick="uncheckall()" class="btn btn-danger align-self-center">Sıfırla</button>
                                        </span>
                                    </div>
                                </div>
                            </div>



                        </div>


                    </div>
                </div>
                <div class="card" style="height:300px;overflow-y: scroll">
                    <div class="card-header text-center">
                        <b>Seçilmiş olan dersler</b>
                    </div>

                    <div id="secilmisDersler" class="card-body text-center" >

                    </div>
                </div>
            </div>
        </form>
    </div>


    <div class="modal fade" id="sonuc" tabindex="-1" role="dialog" aria-labelledby="sonucTitle" aria-hidden="true" >
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header ">
                    <h5 class="modal-title text-center mx-auto" id="sonucTitle">Sonuçlar</h5>
                    <button type="button" class="close ml-0" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body ">
                    <table class="table" >
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Çakışma Sayısı</th>
                            <th scope="col">Görüntüle</th>
                        </tr>
                        </thead>
                        <tbody id="programList">


                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
    <div class="modal fade" id="oneri" tabindex="-1" role="dialog" aria-labelledby="oneriTitle" aria-hidden="true" >
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-center  mx-auto" id="oneriTitle">Programınıza uyan önerilen bölüm dersleri</h5>
                    <button type="button" class="close ml-0" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body ">
                    <table class="table" >
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Ders Adı</th>
                            <th scope="col">Görüntüle</th>
                        </tr>
                        </thead>
                        <tbody id="oneriList">


                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
    <div class="modal fade" id="yukleniyor" tabindex="-1"  aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body mx-auto">
                    <h3>Olası programlarınız hesaplanıyor, lütfen bekleyiniz.</h3>
                    <img class="img-fluid mx-auto d-block" src="../loading.gif">
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="yukleniyorOgrenci" tabindex="-1"  aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body mx-auto">
                    <h3>Ders programınız yükleniyor, lütfen bekleyiniz.</h3>
                    <img class="img-fluid mx-auto d-block" src="../loading.gif">
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="hata" tabindex="-1" role="dialog" aria-labelledby="hataTitle" aria-hidden="true">
        <div class="modal-dialog " role="document">
            <div class="modal-content text-center">
                <h5 class="modal-header text-center mx-auto">
                    Hata
                    <button type="button" class="close ml-0" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </h5>

                <div class="modal-body ">
                    <h4>Girmiş olduğunuz maksimum çakışma limitine eşit veya daha az çakışmalı program bulunamamıştır.</h4>
                </div>

            </div>
        </div>
    </div>
    <div class="modal fade" id="hata2" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog " role="document">
            <div class="modal-content text-center">
                <h5 class="modal-header text-center mx-auto">
                    Hata
                    <button type="button" class="close ml-0" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </h5>

                <div class="modal-body ">
                    <h4>Lütfen ders seçiniz.</h4>
                </div>

            </div>
        </div>
    </div>
    <div class="modal fade" id="hataOgrenci" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog " role="document">
            <div class="modal-content text-center">
                <h5 class="modal-header text-center mx-auto">
                    Hata

                </h5>

                <div class="modal-body ">
                    <h4>Girilmiş olan öğrenci numarasına ait program bulunamadı.</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>

                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="goster" tabindex="-1" role="dialog" aria-labelledby="gosterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mx-auto" id="gosterTitle">Program</h5>
                    <button type="button" class="close ml-0" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive table-bordered">
                        <table class="table table-hover">
                            <thead style="background-color: #3174ae">
                            <tr class="text-white">
                                <th scope="col">Saat</th>
                                <th scope="col">Pazartesi</th>
                                <th scope="col">Salı</th>
                                <th scope="col">Çarşamba</th>
                                <th scope="col">Perşembe</th>
                                <th scope="col">Cuma</th>
                                <th scope="col">Cumartesi</th>
                            </tr>
                            </thead>
                            <tbody class="text-center" id="programPanel">

                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        checkboxchange();
        function getCheckedBoxes(chkboxName) {
            var checkboxes = document.getElementsByName(chkboxName);

            var checkboxesChecked = [];
            for (var i=0; i<checkboxes.length; i++) {
                if (checkboxes[i].checked) {

                    checkboxesChecked.push(checkboxes[i]);
                }
            }
            return checkboxesChecked.length > 0 ? checkboxesChecked : null;
        }
        function uncheckall() {
            var checkboxes = document.getElementsByName("derslistesi[]");
            var checkboxesChecked = [];

            for (var i=0; i<checkboxes.length; i++) {
                if (checkboxes[i].checked) {
                    checkboxes[i].checked=false;
                }
            }
            checkboxchange();
        }

        function checkboxchange() {
            var secilmisdersler = document.getElementById("secilmisDersler");
            while(secilmisdersler.firstChild){
                secilmisdersler.removeChild(secilmisdersler.firstChild);
            }
            var checkedBoxes=getCheckedBoxes("derslistesi[]")
            if(checkedBoxes!=null){
                var arrayLength=checkedBoxes.length;
                for (var i = 0; i < arrayLength; i++) {
                    var p=document.createElement("p");
                    var text=document.createTextNode(checkedBoxes[i].parentNode.getElementsByTagName("label")[0].innerText);
                    p.appendChild(text);
                    secilmisdersler.appendChild(p);
                }
            }


        }
        function getCookie(name) {
            var dc = document.cookie;
            var prefix = name + "=";
            var begin = dc.indexOf("; " + prefix);
            if (begin == -1) {
                begin = dc.indexOf(prefix);
                if (begin != 0) return null;
            }
            else
            {
                begin += 2;
                var end = document.cookie.indexOf(";", begin);
                if (end == -1) {
                    end = dc.length;
                }
            }
            // because unescape has been deprecated, replaced with decodeURI
            //return unescape(dc.substring(begin + prefix.length, end));
            return decodeURI(dc.substring(begin + prefix.length, end));
        }
        $('form#okulno').on( "submit", function( event ) {
            event.preventDefault();
            if($.isNumeric($('form#okulno').serializeArray()[0].value)&&$('form#okulno').serializeArray()[0].value.length==9){
                $.post('../service/okulnologin.php',{ okul_numarasi: $('form#okulno').serializeArray()[0].value}, function (data) {

                    //console.log(data);
                    location.reload();
                });
            }
            else{
                alert("Lütfen okul numaranızı tekrar giriniz, girdiğiniz değer sadece 9 adet rakamdan oluşmalıdır.");
            }


        });
        $(document).on('hidden.bs.modal', '.modal', function () {
            $('.modal:visible').length && $(document.body).addClass('modal-open');
        });
        var obj;
        var oneriobj;
        var ogrenciobj;
        $('button#submit').on('click', function () {

                var cakisma= $('input#cakisma').val();
                var derslistesi = []
                $("input[name='derslistesi[]']:checked").each(function ()
                {
                    derslistesi.push(parseInt($(this).val()));
                });
                if(derslistesi.length==0){
                    $("#hata2").focus();
                    $("#hata2").modal('show');
                    return;
                }
                $("#yukleniyor").modal();
                $.post('../service/programhesapla.php',{ derslistesi: derslistesi, cakisma: cakisma}, function (data) {

                    resetsonuclar();
                    obj = JSON.parse(data);

                    console.log(obj);
                    var sonucvar=0;

                    for (var i in obj){

                        var tr = document.createElement('tr');

                        var td1 = document.createElement('td');
                        var th = document.createElement('th');
                        var td2 = document.createElement('td');

                        var text1 = document.createTextNode(Number(i)+1);
                        var text2 = document.createTextNode(obj[i].cakismasayisi);
                        var text3 = document.createTextNode('Görüntüle');

                        var button= document.createElement('button');
                        button.className+=' btn btn-primary'
                        button.type="button";
                        button.onclick=programgoster;
                        button.appendChild(text3);

                        td1.appendChild(text1);
                        th.appendChild(text2);
                        td2.appendChild(button);

                        tr.appendChild(td1);
                        tr.appendChild(th);
                        tr.appendChild(td2);
                        document.getElementById("programList").appendChild(tr);

                        sonucvar=1;

                    }
                    $("#yukleniyor").modal('toggle');
                    if(sonucvar==0){

                        $("#hata").focus();
                        $("#hata").modal('toggle');

                    }
                    else{
                        $("#sonuc").focus();
                        $("#sonuc").modal('toggle');
                    }

                });


            });
        $('button#ogrenci').on('click', function () {

                var okulno= getCookie("okul_numarasi");
                if(okulno !== null) {
                    $("#yukleniyorOgrenci").modal();
                    $.post('../service/ogrenciprog.php', {okul_numarasi: okulno}, function (data) {
                        resetsonuclar();
                        ogrenciobjarr=JSON.parse(data);
                        ogrenciobj = ogrenciobjarr;

                        console.log(ogrenciobj);
                        var sonucvar = 1;
                        ogrencigoster()



                        $("#yukleniyorOgrenci").modal('toggle');
                        if (sonucvar == 0) {

                            $("#hataOgrenci").focus();
                            $("#hataOgrenci").modal('toggle');

                        }
                        else {
                            $("#goster").focus();
                            $("#goster").modal('toggle');
                            var backButton = function (ev) {
                                $("#goster").modal('toggle');
                            };
                            document.addEventListener("backbutton", backButton, false);
                        }


                    });

                    $(window).on("navigate", function (event, data) {
                        var direction = data.state.direction;
                        if (direction == 'back') {
                            // do something
                        }
                        if (direction == 'forward') {
                            // do something else
                        }
                    });
                }
        });
        $('button#onerilen').on('click', function () {

            var okulno= getCookie("okul_numarasi");
            if(okulno !== null) {
                $("#yukleniyor").modal();
                $.post('../service/onerilenders.php', {okul_numarasi: okulno}, function (data) {
                    resetsonuclar();
                    oneriobjarr=JSON.parse(data);
                    oneriobj = oneriobjarr;

                    console.log(oneriobj);
                    var sonucvar = 0;

                    for (var i in oneriobj) {

                        var tr = document.createElement('tr');

                        var td1 = document.createElement('td');
                        var th = document.createElement('th');
                        var td2 = document.createElement('td');

                        var text1 = document.createTextNode(Number(i) + 1);
                        var text2 = document.createTextNode(oneriobj[i]['derskodu']+"-"+oneriobj[i]['derssube']);
                        var text3 = document.createTextNode('Görüntüle');

                        var button = document.createElement('button');
                        button.className += ' btn btn-primary'
                        button.type = "button";
                        button.onclick = onerigoster;
                        button.appendChild(text3);

                        td1.appendChild(text1);
                        th.appendChild(text2);
                        td2.appendChild(button);

                        tr.appendChild(td1);
                        tr.appendChild(th);
                        tr.appendChild(td2);
                        document.getElementById("oneriList").appendChild(tr);

                        sonucvar = 1;

                    }
                    $("#yukleniyor").modal('toggle');
                    if (sonucvar == 0) {

                        $("#hata").focus();
                        $("#hata").modal('toggle');

                    }
                    else {
                        $("#oneri").focus();
                        $("#oneri").modal('toggle');
                    }


                });

            }
        });


        function replaceAll(str, find, replace) {
            return str.replace(new RegExp(find, 'g'), replace);
        }
        function resetsonuclar() {
            var sonuclar=document.getElementById("programList");
            while (sonuclar.firstChild) {
                sonuclar.removeChild(sonuclar.firstChild);
            }
            var onerisonuclar=document.getElementById("oneriList");
            while (onerisonuclar.firstChild) {
                onerisonuclar.removeChild(onerisonuclar.firstChild);
            }
        }
        function programgoster() {
            var id=this.parentElement.parentElement.firstChild.firstChild.textContent;
            var grid=obj[Number(id)-1].grid;
            resetgrid();
            for(var i=0;i<13;i++){
                var saat1 = 8+i;
                var saat2= saat1+1;

                var tr = document.createElement('tr');

                var th = document.createElement('th');
                var td1 = document.createElement('td');
                var td2 = document.createElement('td');
                var td3 = document.createElement('td');
                var td4 = document.createElement('td');
                var td5 = document.createElement('td');
                var td6 = document.createElement('td');
                var text1 = document.createTextNode(saat1+".30-"+saat2+".20");
                th.appendChild(text1);
                var text2 = document.createTextNode('-');
                var text3 = document.createTextNode('-');
                var text4 = document.createTextNode('-');
                var text5 = document.createTextNode('-');
                var text6 = document.createTextNode('-');
                var text7 = document.createTextNode('-');

                //burası daha kısa yapılabilir, çok üşendim :)
                if(grid[i]!=null){
                    var tmpstr="";
                    if(grid[i][0]!=null){
                        tmpstr="";
                        for (var cakisma in grid[i][0]){
                            tmpstr=tmpstr+grid[i][0][cakisma].dersno+'-'+grid[i][0][cakisma].subeno+" ";
                        }
                        //console.log(tmpstr);
                        text2 = document.createTextNode(tmpstr);


                    }
                    if(grid[i][1]!=null){
                        tmpstr="";
                        for (var cakisma in grid[i][1]){
                            tmpstr=tmpstr+grid[i][1][cakisma].dersno+'-'+grid[i][1][cakisma].subeno+" ";
                        }

                        text3 = document.createTextNode(tmpstr);

                    }
                    if(grid[i][2]!=null){
                        tmpstr="";
                        for (var cakisma in grid[i][2]){
                            tmpstr=tmpstr+grid[i][2][cakisma].dersno+'-'+grid[i][2][cakisma].subeno+" ";
                        }
                        text4 = document.createTextNode(tmpstr);

                    }
                    if(grid[i][3]!=null){
                        tmpstr="";
                        for (var cakisma in grid[i][3]){
                            tmpstr=tmpstr+grid[i][3][cakisma].dersno+'-'+grid[i][3][cakisma].subeno+" ";
                        }
                        text5 = document.createTextNode(tmpstr);

                    }
                    if(grid[i][4]!=null){
                        tmpstr="";
                        for (var cakisma in grid[i][4]){
                            tmpstr=tmpstr+grid[i][4][cakisma].dersno+'-'+grid[i][4][cakisma].subeno+" ";
                        }
                        text6 = document.createTextNode(tmpstr);

                    }
                    if(grid[i][5]!=null){
                        tmpstr="";
                        for (var cakisma in grid[i][5]){
                            tmpstr=tmpstr+grid[i][5][cakisma].dersno+'-'+grid[i][5][cakisma].subeno+" ";
                        }
                        text7 = document.createTextNode(tmpstr);
                    }
                }

                th.scope="row";
                th.style="background-color: #3174ae";
                th.className="text-white ";

                td1.appendChild(text2);
                td2.appendChild(text3);
                td3.appendChild(text4);
                td4.appendChild(text5);
                td5.appendChild(text6);
                td6.appendChild(text7);

                tr.appendChild(th);
                tr.appendChild(td1);
                tr.appendChild(td2);
                tr.appendChild(td3);
                tr.appendChild(td4);
                tr.appendChild(td5);
                tr.appendChild(td6);
                document.getElementById("programPanel").appendChild(tr);
            }
            $("#goster").modal();
        }
        function onerigoster() {
            var id=this.parentElement.parentElement.firstChild.firstChild.textContent;
            var grid=oneriobj[Number(id)-1]['dersprog'].grid;
            resetgrid();
            for(var i=0;i<13;i++){
                var saat1 = 8+i;
                var saat2= saat1+1;

                var tr = document.createElement('tr');

                var th = document.createElement('th');
                var td1 = document.createElement('td');
                var td2 = document.createElement('td');
                var td3 = document.createElement('td');
                var td4 = document.createElement('td');
                var td5 = document.createElement('td');
                var td6 = document.createElement('td');
                var text1 = document.createTextNode(saat1+".30-"+saat2+".20");
                th.appendChild(text1);
                var text2 = document.createTextNode('-');
                var text3 = document.createTextNode('-');
                var text4 = document.createTextNode('-');
                var text5 = document.createTextNode('-');
                var text6 = document.createTextNode('-');
                var text7 = document.createTextNode('-');

                var bold = document.createElement("b");

                //burası daha kısa yapılabilir, çok üşendim :)
                if(grid[i]!=null){
                    var tmpstr="";
                    if(grid[i][0]!=null){
                        tmpstr="";
                        for (var cakisma in grid[i][0]){
                            if(grid[i][0][cakisma].subeno!="0"){
                                tmpstr=tmpstr+replaceAll(grid[i][0][cakisma].dersno,"<br />","\n")+"-"+grid[i][0][cakisma].subeno+" ";
                            }
                            else{
                                tmpstr=tmpstr+replaceAll(grid[i][0][cakisma].dersno,"<br />","\n")+" ";
                            }
                        }
                        //console.log(tmpstr);
                        text2 = document.createTextNode(tmpstr);


                    }
                    if(grid[i][1]!=null){
                        tmpstr="";
                        for (var cakisma in grid[i][1]){
                            if(grid[i][1][cakisma].subeno!="0"){
                                tmpstr=tmpstr+replaceAll(grid[i][1][cakisma].dersno,"<br />","\n")+"-"+grid[i][1][cakisma].subeno+" ";
                            }
                            else{
                                tmpstr=tmpstr+replaceAll(grid[i][1][cakisma].dersno,"<br />","\n")+" ";
                            }
                        }

                        text3 = document.createTextNode(tmpstr);

                    }
                    if(grid[i][2]!=null){
                        tmpstr="";
                        for (var cakisma in grid[i][2]){
                            if(grid[i][2][cakisma].subeno!="0"){
                                tmpstr=tmpstr+replaceAll(grid[i][2][cakisma].dersno,"<br />","\n")+"-"+grid[i][2][cakisma].subeno+" ";
                            }
                            else{
                                tmpstr=tmpstr+replaceAll(grid[i][2][cakisma].dersno,"<br />","\n")+" ";
                            }
                        }
                        text4 = document.createTextNode(tmpstr);

                    }
                    if(grid[i][3]!=null){
                        tmpstr="";
                        for (var cakisma in grid[i][3]){
                            if(grid[i][3][cakisma].subeno!= "0"){
                                tmpstr=tmpstr+replaceAll(grid[i][3][cakisma].dersno,"<br />","\n")+"-"+grid[i][3][cakisma].subeno+" ";
                            }
                            else{
                                tmpstr=tmpstr+replaceAll(grid[i][3][cakisma].dersno,"<br />","\n")+" ";
                            }
                        }
                        text5 = document.createTextNode(tmpstr);

                    }
                    if(grid[i][4]!=null){
                        tmpstr="";
                        for (var cakisma in grid[i][4]){
                            if(grid[i][4][cakisma].subeno!="0"){
                                tmpstr=tmpstr+replaceAll(grid[i][4][cakisma].dersno,"<br />","\n")+"-"+grid[i][4][cakisma].subeno+" ";
                            }
                            else{
                                tmpstr=tmpstr+replaceAll(grid[i][4][cakisma].dersno,"<br />","\n")+" ";
                            }
                        }
                        text6 = document.createTextNode(tmpstr);

                    }
                    if(grid[i][5]!=null){
                        tmpstr="";
                        for (var cakisma in grid[i][5]){
                            if(grid[i][5][cakisma].subeno!="0"){
                                tmpstr=tmpstr+replaceAll(grid[i][5][cakisma].dersno,"<br />","\n")+"-"+grid[i][5][cakisma].subeno+" ";
                            }
                            else{
                                tmpstr=tmpstr+replaceAll(grid[i][5][cakisma].dersno,"<br />","\n")+" ";
                            }
                        }
                        text7 = document.createTextNode(tmpstr);

                    }
                }

                th.scope="row";
                th.style="background-color: #3174ae";
                th.className="text-white ";

                td1.appendChild(text2);
                td2.appendChild(text3);
                td3.appendChild(text4);
                td4.appendChild(text5);
                td5.appendChild(text6);
                td6.appendChild(text7);

                tr.appendChild(th);
                tr.appendChild(td1);
                tr.appendChild(td2);
                tr.appendChild(td3);
                tr.appendChild(td4);
                tr.appendChild(td5);
                tr.appendChild(td6);
                document.getElementById("programPanel").appendChild(tr);
            }
            $("#goster").modal();
        }
        function ogrencigoster() {
            //var id=this.parentElement.parentElement.firstChild.firstChild.textContent;
            var grid=ogrenciobj.grid;
            resetgrid();
            for(var i=0;i<13;i++){
                var saat1 = 8+i;
                var saat2= saat1+1;

                var tr = document.createElement('tr');

                var th = document.createElement('th');
                var td1 = document.createElement('td');
                var td2 = document.createElement('td');
                var td3 = document.createElement('td');
                var td4 = document.createElement('td');
                var td5 = document.createElement('td');
                var td6 = document.createElement('td');
                var text1 = document.createTextNode(saat1+".30-"+saat2+".20");
                th.appendChild(text1);
                var text2 = document.createTextNode('-');
                var text3 = document.createTextNode('-');
                var text4 = document.createTextNode('-');
                var text5 = document.createTextNode('-');
                var text6 = document.createTextNode('-');
                var text7 = document.createTextNode('-');

                var bold = document.createElement("b");

                //burası daha kısa yapılabilir, çok üşendim :)
                if(grid[i]!=null){
                    var tmpstr="";
                    if(grid[i][0]!=null){
                        tmpstr="";
                        for (var cakisma in grid[i][0]){
                            if(grid[i][0][cakisma].subeno!="0"){
                                tmpstr=tmpstr+replaceAll(grid[i][0][cakisma].dersno,"<br />","\n")+"-"+grid[i][0][cakisma].subeno+" ";
                            }
                            else{
                                tmpstr=tmpstr+replaceAll(grid[i][0][cakisma].dersno,"<br />","\n")+" ";
                            }
                        }
                        //console.log(tmpstr);
                        text2 = document.createTextNode(tmpstr);


                    }
                    if(grid[i][1]!=null){
                        tmpstr="";
                        for (var cakisma in grid[i][1]){
                            if(grid[i][1][cakisma].subeno!="0"){
                                tmpstr=tmpstr+replaceAll(grid[i][1][cakisma].dersno,"<br />","\n")+"-"+grid[i][1][cakisma].subeno+" ";
                            }
                            else{
                                tmpstr=tmpstr+replaceAll(grid[i][1][cakisma].dersno,"<br />","\n")+" ";
                            }
                        }

                        text3 = document.createTextNode(tmpstr);

                    }
                    if(grid[i][2]!=null){
                        tmpstr="";
                        for (var cakisma in grid[i][2]){
                            if(grid[i][2][cakisma].subeno!="0"){
                                tmpstr=tmpstr+replaceAll(grid[i][2][cakisma].dersno,"<br />","\n")+"-"+grid[i][2][cakisma].subeno+" ";
                            }
                            else{
                                tmpstr=tmpstr+replaceAll(grid[i][2][cakisma].dersno,"<br />","\n")+" ";
                            }
                        }
                        text4 = document.createTextNode(tmpstr);

                    }
                    if(grid[i][3]!=null){
                        tmpstr="";
                        for (var cakisma in grid[i][3]){
                            if(grid[i][3][cakisma].subeno!= "0"){
                                tmpstr=tmpstr+replaceAll(grid[i][3][cakisma].dersno,"<br />","\n")+"-"+grid[i][3][cakisma].subeno+" ";
                            }
                            else{
                                tmpstr=tmpstr+replaceAll(grid[i][3][cakisma].dersno,"<br />","\n")+" ";
                            }
                        }
                        text5 = document.createTextNode(tmpstr);

                    }
                    if(grid[i][4]!=null){
                        tmpstr="";
                        for (var cakisma in grid[i][4]){
                            if(grid[i][4][cakisma].subeno!="0"){
                                tmpstr=tmpstr+replaceAll(grid[i][4][cakisma].dersno,"<br />","\n")+"-"+grid[i][4][cakisma].subeno+" ";
                            }
                            else{
                                tmpstr=tmpstr+replaceAll(grid[i][4][cakisma].dersno,"<br />","\n")+" ";
                            }
                        }
                        text6 = document.createTextNode(tmpstr);

                    }
                    if(grid[i][5]!=null){
                        tmpstr="";
                        for (var cakisma in grid[i][5]){
                            if(grid[i][5][cakisma].subeno!="0"){
                                tmpstr=tmpstr+replaceAll(grid[i][5][cakisma].dersno,"<br />","\n")+"-"+grid[i][5][cakisma].subeno+" ";
                            }
                            else{
                                tmpstr=tmpstr+replaceAll(grid[i][5][cakisma].dersno,"<br />","\n")+" ";
                            }
                        }
                        text7 = document.createTextNode(tmpstr);

                    }
                }

                th.scope="row";
                th.style="background-color: #3174ae";
                th.className="text-white ";

                td1.appendChild(text2);
                td2.appendChild(text3);
                td3.appendChild(text4);
                td4.appendChild(text5);
                td5.appendChild(text6);
                td6.appendChild(text7);

                tr.appendChild(th);
                tr.appendChild(td1);
                tr.appendChild(td2);
                tr.appendChild(td3);
                tr.appendChild(td4);
                tr.appendChild(td5);
                tr.appendChild(td6);
                document.getElementById("programPanel").appendChild(tr);
            }
            $("#goster").modal();
        }
        function resetgrid() {
            var panel=document.getElementById("programPanel")
            while (panel.firstChild) {
                panel.removeChild(panel.firstChild);
            }
        }

    </script>

</div>