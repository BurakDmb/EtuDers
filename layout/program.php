<div class="jumbotron col-md-8 offset-md-2 bg-light ">
    <h4 class="display-4 text-center">EtuDers - Ders Programı Oluşturucu</h4>
    <p class="lead text-center">
        Ders programı oluşturma aracımızla, normalde oldukça uğraştırıcı olan kendi ders programınızı oluşturma sürecinizi saniyelere indiriyoruz. Mantık olarak seçtiğiniz dersleri kendi aralarındaki tüm kombinasyonlarını hesaplayıp size en az çakışmalı olan programları sunuyoruz.

    </p>
    <hr class="my-4">
    <p class="lead text-center">
        Ders programı oluşturma aracını herhangi bir öğrenci bilgisi gerektirmeden kullanabilirsiniz, öneri/tavsiye için <a href="mailto:burakhan@demirbilek.eu?subject=EtuDers Hk." target="_top">burakhan@demirbilek.eu</a> adresinden bana ulaşabilirsiniz.
        <br>
        <div class="row">

            <div class="lead col-md-12 text-center">
                <b><?php include __DIR__."/../counter/sorgu_counter.php"; echo "Toplam sorgu sayısı: ".sorguCounter(0)?></b>
            </div>
        </div>

    </p>

    <hr class="my-4">
    <div class="container">
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
                    <div  class="card-body" style="height:160px;overflow-y: auto;">
                        <div class="row align-self-center">
                            <span class="mx-auto " >
                                <div class="form-group text-center">
                                    <label for="cakisma" >Maks. çakışma limiti</label>
                                    <input type="text" class="form-control" id="cakisma"  placeholder="Varsayılan: 2">

                                </div>
                            </span>
                            <span class="mx-auto " >
                                <button type="button" class="btn btn-success" id="submit"  >
                                    Hesapla
                                </button>
                            </span>
                            <span class="mx-auto " >
                                <button type="button" onclick="uncheckall()" class="btn btn-danger align-self-center">Sıfırla</button>
                            </span>
                        </div>


                    </div>
                </div>
                <div class="card" style="height:390px;overflow-y: scroll">
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
                <div class="modal-header mx-auto">
                    <h5 class="modal-title text-center" id="sonucTitle">Sonuçlar</h5>

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
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>

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
    <div class="modal fade" id="hata" tabindex="-1" role="dialog" aria-labelledby="hataTitle" aria-hidden="true">
        <div class="modal-dialog " role="document">
            <div class="modal-content text-center">
                <h5 class="modal-header text-center mx-auto">
                    Hata

                </h5>

                <div class="modal-body ">
                    <h4>Girmiş olduğunuz maksimum çakışma limitine eşit veya daha az çakışmalı program bulunamamıştır.</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>

                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="hata2" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog " role="document">
            <div class="modal-content text-center">
                <h5 class="modal-header text-center mx-auto">
                    Hata

                </h5>

                <div class="modal-body ">
                    <h4>Lütfen ders seçiniz.</h4>
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
                <div class="modal-header mx-auto">
                    <h5 class="modal-title text-center" id="gosterTitle">Program</h5>

                </div>
                <div class="modal-body ">
                    <div class="table-responsive table-bordered">
                        <table class="table">
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
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>

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
        $(document).on('hidden.bs.modal', '.modal', function () {
            $('.modal:visible').length && $(document.body).addClass('modal-open');
        });
        var obj;
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

        function resetsonuclar() {
            var sonuclar=document.getElementById("programList");
            while (sonuclar.firstChild) {
                sonuclar.removeChild(sonuclar.firstChild);
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
        function resetgrid() {
            var panel=document.getElementById("programPanel")
            while (panel.firstChild) {
                panel.removeChild(panel.firstChild);
            }
        }

    </script>

</div>
