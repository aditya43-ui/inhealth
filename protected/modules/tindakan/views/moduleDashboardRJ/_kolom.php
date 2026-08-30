<style>
    .tile-rawat-inap {
        width: 100px;
        height: 100px;
        background: url(<?php echo Yii::app()->request->baseUrl; ?>/images/icon_dashboard_tile/rawat-inap.ico) center center no-repeat;
        background-size: cover;
    }
</style>

<div class="col-md-2 col-sm-4 col-sm-12" style="min-width: 20%;">
    <div class="tile-stats tile-red">
        <div class="icon">
            <i class="fas fa-walking"></i>
        </div>
        <div data-delay="0" data-duration="1500" data-postfix="" data-end="<?php echo $dataKolom[1]; ?>" data-start="0" class="num">0</div>
        <h4 style="color:white;">Kunjungan Pasien Klinik</h4>
        <p>Hari Ini <?php echo MyFormatter::formatDateTimeId(date("Y-m-d")); ?></p>
    </div>
</div>

<div class="col-md-2 col-sm-4 col-sm-12" style="min-width: 20%;">
    <div class="tile-stats tile-green">
        <div class="icon">
            <i class="tile-rawat-inap"></i>
        </div>
        <div data-delay="600" style="color:white;" data-duration="1500" data-postfix="" data-end="<?php echo $dataKolom[2]; ?>" data-start="0" class="num"><font color='white'>0</font></div>
        <h4 style="color:white;">Rawat Inap</h4>
        <p><font color='white'><?php echo MyFormatter::formatDateTimeId(date("Y-m-d")); ?></font></p>
    </div>
</div>

<div class="col-md-2 col-sm-4 col-sm-12" style="min-width: 20%;">
    <div class="tile-stats tile-aqua">
        <div class="icon">
            <i class="fas fa-hospital"></i>
        </div>
        <div data-delay="1200" data-duration="1500" data-postfix="" data-end="<?php echo $dataKolom[3]; ?>" data-start="0" class="num">0</div>
        <h4 style="color:white;">Konsul Ke Poliklinik Lain</h4>
        <p>Hari Ini <?php echo MyFormatter::formatDateTimeId(date("Y-m-d")); ?></p>
    </div>
</div>

<div class="col-md-2 col-sm-4 col-sm-12" style="min-width: 20%;">
    <div class="tile-stats tile-brown">
        <div class="icon">
            <i class="fas fa-hospital"></i>
        </div>
        <div data-delay="1200" data-duration="1500" data-postfix="" data-end="<?php echo $dataKolom[51]; ?>" data-start="0" class="num">0</div>
        <h3>Konsul Dari Poliklinik Lain</h3>
        <p>Hari Ini <?php echo MyFormatter::formatDateTimeId(date("Y-m-d")); ?></p>
    </div>
</div>


<div class="col-md-2 col-sm-4 col-sm-12" style="min-width: 20%;">
    <div class="tile-stats tile-blue">
        <div class="icon">
            <i class="fas fa-users"></i>
        </div>
        <div data-delay="1800" data-duration="1500" data-postfix="" data-end="<?php echo $dataKolom[4]; ?>" data-start="0" class="num">0</div>
        <h3>Antrian Pasien</h3>
        <p><?php echo MyFormatter::formatDateTimeId(date("Y-m-d")); ?></p>
    </div>
</div>