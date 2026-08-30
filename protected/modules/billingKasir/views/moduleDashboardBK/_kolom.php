<div class="col-md-3 col-sm-6 col-sm-12">
    <div class="tile-stats tile-red">
        <div class="icon">
            <i class="fas fa-notes-medical"></i>
        </div>
        <div class="num"><?php echo isset($dataKolom[1]) ? $dataKolom[1] : 0; ?></div>
        <!--<div data-delay="0" data-duration="1500" data-postfix="" data-end="<?php // echo $dataKolom[1]; 
                                                                                ?>" data-start="0" class="num">0</div>-->
        <h3>Pasien Rencana Pulang</h3>
        <p>Jumlah Pasien rencana pulang hari ini.</p>
    </div>
</div>

<div class="col-md-3 col-sm-6 col-sm-12">
    <div class="tile-stats tile-green">
        <div class="icon">
            <i class="fas fa-user-md"></i>
        </div>
        <div class="num"><?php echo isset($dataKolom[2]) ? $dataKolom[2] : 0; ?></div>
        <!--<div data-delay="600" data-duration="1500" data-postfix="" data-end="<?php // echo $dataKolom[2]; 
                                                                                    ?>" data-start="0" class="num">0</div>-->
        <h3>Pasien Periksa</h3>
        <p>Jumlah Pasien yang sudah diperiksa hari ini.</p>
    </div>
</div>

<div class="col-md-3 col-sm-6 col-sm-12">
    <div class="tile-stats tile-aqua">
        <div class="icon">
            <i class="fas fa-house-user"></i>
        </div>
        <div class="num"><?php echo isset($dataKolom[3]) ? $dataKolom[3] : 0; ?></div>
        <!--<div data-delay="1200" data-duration="1500" data-postfix="" data-end="<?php // echo $dataKolom[3]; 
                                                                                    ?>" data-start="0" class="num">0</div>-->
        <h3>Pasien Pulang</h3>
        <p>Jumlah pasien pulang hari ini.</p>
    </div>
</div>

<div class="col-md-3 col-sm-6 col-sm-12">
    <div class="tile-stats tile-blue">
        <div class="icon">
            <i class="fas fa-user-check"></i>
        </div>
        <div class="num"><?php echo isset($dataKolom[4]) ? $dataKolom[4] : 0; ?></div>
        <!--<div data-delay="1800" data-duration="1500" data-postfix="" data-end="<?php // echo $dataKolom[4]; 
                                                                                    ?>" data-start="0" class="num">0</div>-->
        <h3>Pasien Sudah Bayar</h3>
        <p>Pasien udah bayar hari ini.</p>
    </div>
</div>