<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
    <a class="navbar-brand" href="#">EtuDers</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse " id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="#">Anasayfa <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" target="_blank" href="http://obs.etu.edu.tr:35/DersProgrami#/">ETU-OBS</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" target="_blank" href="http://ubs.etu.edu.tr/">ETU-UBS</a>
            </li>




        </ul>
        <?php
        if(!isset($_COOKIE['okul_numarasi'])) {
            ?>
            <form id="okulno" class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" placeholder="Okul numaran" name="okul_numarasi" aria-label="okulno">
                <input class="btn btn-success my-2 my-sm-0" value="Okul Numaranı Gir" type="submit">
            </form>
            <?php
        } else {

            ?>
            <div class="my-2 my-lg-0">

                <span class="d-inline-block" tabindex="0" data-toggle="tooltip" data-placement="bottom" title="Okul numaranız sadece tarayıcınızın çerezler bölümünde saklanmaktadır, başka bir sunucuya aktarılmamaktadır.">
                    <button class="btn btn-primary" style="pointer-events: none;" type="button" disabled>Okul numaranız: <?php echo $_COOKIE['okul_numarasi'];?></button>
                </span>
                <button class="btn btn-success my-2 my-sm-0" type="button" id="onerilen">Alabileceğin Önerilen Dersler</button>
                <button type="button" class="btn btn-danger" onclick="document.cookie = 'okul_numarasi=;expires=Thu, 01 Jan 1970 00:00:01 GMT;';location.reload();">Okul Numaranı Sil</button>
            </div>
            <?php
        }
        ?>


    </div>
</nav>