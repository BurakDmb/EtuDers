
    <div id="accordion"  role="tablist">
        <?php
        $opts = array(
            'http'=>array(
                'method'=>"GET",
                'header'=>"Accept-language: tr\r\n" .
                    "Cookie: foo=bar\r\n" .
                    "Accept: application/json\r\n"
            )
        );
        $context = stream_context_create($opts);
        $dersListesi = json_decode(file_get_contents('http://obs.etu.edu.tr:35/DersProgrami/api/ders/getlist/?dil=tr', false, $context), true);
        $oncekikod="";
        foreach($dersListesi as $ders) { //foreach element in $arr
            $derskodu=explode(" ",$ders['DersKodu'])[0];
            if($oncekikod==$derskodu){
                //eger esitse sadece yeni entry gir


                ?>

                            <li class="list-group-item">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" onclick="checkboxchange()" value="<?php echo $ders['DersID'];?> " name="derslistesi[]" >
                                    <label class="form-check-label" for="defaultCheck1">
                                        <?php echo $ders['DersKodu']." ".$ders['DersAdi'];?>
                                    </label>
                                </div>
                            </li>

                <?php
                $oncekikod=$derskodu;
            }
            else{


            if(!$oncekikod==""){
            echo '
                        </ul>
                    </div>
                </div>
            </div>';
                ?>
            <?php
            }
            ?>

            <div class="card">
                <div class="card-header" role="tab" id="heading<?php echo $derskodu;?>">
                    <h5 class="mb-0">
                        <a data-toggle="collapse" href="#goster<?php echo $derskodu;?>" role="button" aria-expanded="false" aria-controls="goster<?php echo $derskodu;?>">
                            <?php echo $derskodu;?> kodlu dersler
                        </a>
                    </h5>
                </div>

                <div id="goster<?php echo $derskodu;?>" class="collapse " role="tabpanel" aria-labelledby="heading<?php echo $derskodu;?>" data-parent="#accordion">
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" onclick="checkboxchange()" value="<?php echo $ders['DersID'];?>" name="derslistesi[]">
                                    <label class="form-check-label" for="defaultCheck1">
                                        <?php echo $ders['DersKodu']." ".$ders['DersAdi'];?>
                                    </label>
                                </div>
                            </li>


                            <?php
                            $oncekikod=$derskodu;
                            }
                }
                    echo '
                        </ul>
                    </div>
                </div>
            </div>';
                    ?>


      </div>