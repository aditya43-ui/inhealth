<div class="col-md-3 col-sm-6 col-sm-12">
    <div class="tile-stats tile-red">
        <div class="icon">
            <i class="fas fa-user-plus"></i>
        </div>
        <div data-delay="0" data-duration="1500" data-postfix="" data-end="<?php echo $dataKolom[1]; ?>" data-start="0" class="num">0</div>
        <h3>Pendaftaran Pasien Rumah Sakit</h3>
        <p>Hari Ini <?php echo MyFormatter::formatDateTimeId(date("Y-m-d")); ?></p>
    </div>
</div>

<div class="col-md-3 col-sm-6 col-sm-12">
    <div class="tile-stats tile-green">
        <div class="icon">
            <span class="fa-stack">
                <i class="far fa-circle fa-stack-2x"></i>
                <i class="fas fa-user fa-stack-1x"></i>
            </span>
        </div>
        <div data-delay="600" data-duration="1500" data-postfix="" data-end="<?php echo $dataKolom[2]; ?>" data-start="0" class="num">0</div>
        <h3>Pendaftaran Pasien Luar</h3>
        <p>Hari ini <?php echo MyFormatter::formatDateTimeId(date("Y-m-d")); ?></p>
    </div>
</div>

<div class="col-sm-3 col-xs-6">
    <div class="tile-stats tile-aqua">
        <div class="icon">
            <i class="fas fa-user-md"></i>
        </div>
        <div data-delay="1200" data-duration="1500" data-postfix="" data-end="<?php echo $dataKolom[3]; ?>" data-start="0" class="num">0</div>
        <h3>Pemeriksaan Pasien</h3>
        <p>Hari Ini <?php echo MyFormatter::formatDateTimeId(date("Y-m-d")); ?></p>
    </div>
</div>

<div class="col-sm-3 col-xs-6">
    <div class="tile-stats tile-blue">
        <div class="icon">
            <i class="fas fa-users"></i>
        </div>
        <div data-delay="1800" data-duration="1500" data-postfix="" data-end="<?php echo $dataKolom[4]; ?>" data-start="0" class="num">0</div>
        <h3>Antrian Pasien</h3>
        <p>Hari ini <?php echo MyFormatter::formatDateTimeId(date("Y-m-d")); ?></p>
    </div>
</div>