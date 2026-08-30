<style>
    .tile-selesai-operasi {
        width: 100px;
        height: 100px;
        background: url(<?php echo Yii::app()->request->baseUrl; ?>/images/icon_dashboard_tile/selesai-operasi.ico) center center no-repeat;
        background-size: cover;
    }
</style>

<div class="col-md-3 col-sm-6 col-sm-12">
    <div class="tile-stats tile-red">
        <div class="icon">
            <i class="tile-selesai-operasi"></i>
        </div>
        <div data-delay="0" data-duration="1500" data-postfix="" data-end="<?php echo $dataKolom[1]; ?>" data-start="0" class="num">0</div>
        <h3>Pasien Selesai Operasi</h3>
        <p>Jumlah pasien yang selesai melakukan tindakan operasi hari ini <?php echo MyFormatter::formatDateTimeForUser(date("Y-m-d")); ?></p>
    </div>
</div>
<div class="col-md-3 col-sm-6 col-sm-12">
    <div class="tile-stats tile-green">
        <div class="icon">
            <i class="fas fa-notes-medical"></i>
        </div>
        <div data-delay="0" data-duration="1500" data-postfix="" data-end="<?php echo $dataKolom[2]; ?>" data-start="0" class="num">0</div>
        <h3>Pasien Rencana Operasi</h3>
        <p>Jumlah pasien yang rencana melakukan tindakan operasi hari ini <?php echo MyFormatter::formatDateTimeForUser(date("Y-m-d")); ?></p>
    </div>
</div>
<div class="col-md-3 col-sm-6 col-sm-12">
    <div class="tile-stats tile-aqua">
        <div class="icon">
            <span class="fa-stack">
                <i class="fas fa-ban fa-stack-2x"></i>
                <i class="fas fa-user fa-stack-1x"></i>
            </span>
        </div>
        <div data-delay="0" data-duration="1500" data-postfix="" data-end="<?php echo $dataKolom[3]; ?>" data-start="0" class="num">0</div>
        <h3>Pasien Batal Operasi</h3>
        <p>Jumlah pasien yang membatalkan operasi hari ini <?php echo MyFormatter::formatDateTimeForUser(date("Y-m-d")); ?></p>
    </div>
</div>
<div class="col-md-3 col-sm-6 col-sm-12">
    <div class="tile-stats tile-blue">
        <div class="icon">
            <i class="fas fa-hospital-user"></i>
        </div>
        <div data-delay="0" data-duration="1500" data-postfix="" data-end="<?php echo $dataKolom[4]; ?>" data-start="0" class="num">0</div>
        <h3>Pasien Bedah Sentral</h3>
        <p>Jumlah keseluruhan pasien yang ada pada Instalasi Bedah Sentral hari ini <?php echo MyFormatter::formatDateTimeForUser(date("Y-m-d")); ?></p>
    </div>
</div>