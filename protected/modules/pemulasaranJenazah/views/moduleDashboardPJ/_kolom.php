<style>
    .tile-meninggal {
        width: 100px;
        height: 100px;
        background: url(<?php echo Yii::app()->request->baseUrl; ?>/images/icon_dashboard_tile/meninggal.ico) center center no-repeat;
        background-size: cover;
    }
</style>

<div class="col-md-3 col-sm-6 col-sm-12">
    <div class="tile-stats tile-red">
        <div class="icon">
            <i class="tile-meninggal"></i>
        </div>
        <div data-delay="0" data-duration="1500" data-postfix="" data-end="<?php echo $dataKolom[1]; ?>" data-start="0" class="num">0</div>
        <h3>Pengambilan Jenazah</h3>
        <p>Pengambilan jenazah hari ini.</p>
    </div>
</div>

<div class="col-md-3 col-sm-6 col-sm-12">
    <div class="tile-stats tile-green">
        <div class="icon">
            <i class="fas fa-bed"></i>
        </div>
        <div data-delay="600" data-duration="1500" data-postfix="" data-end="<?php echo $dataKolom[2]; ?>" data-start="0" class="num">0</div>
        <h3>Pemulasaraan Jenazah</h3>
        <p>Jumlah tindakan kepada jenazah hari ini.</p>
    </div>
</div>

<div class="col-md-3 col-sm-6 col-sm-12">
    <div class="tile-stats tile-aqua">
        <div class="icon">
            <i class="tile-meninggal"></i>
        </div>
        <div data-delay="1200" data-duration="1500" data-postfix="" data-end="<?php echo $dataKolom[3]; ?>" data-start="0" class="num">0</div>
        <h3>Pasien Meninggal</h3>
        <p>Pasien meninggal hari ini.</p>
    </div>
</div>

<div class="col-md-3 col-sm-6 col-sm-12">
    <div class="tile-stats tile-blue">
        <div class="icon">
            <i class="fas fa-ambulance"></i>
        </div>
        <div data-delay="1800" data-duration="1500" data-postfix="" data-end="<?php echo $dataKolom[4]; ?>" data-start="0" class="num">0</div>
        <h3>Pemakaian Mobil Jenazah</h3>
        <p>Pemakaian mobil jenazah hari ini.</p>
    </div>
</div>