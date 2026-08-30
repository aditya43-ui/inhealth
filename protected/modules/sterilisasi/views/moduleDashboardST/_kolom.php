<div class="col-md-3 col-sm-6 col-sm-12">
    <div class="tile-stats tile-red">
        <div class="icon">
            <i class="fas fa-file-alt"></i>
        </div>
        <div data-delay="0" data-duration="1500" data-postfix="" data-end="<?php echo $dataKolom[1]; ?>" data-start="0" class="num">0</div>
        <h3> Jumlah Pengajuan </h3>
        <p>Jumlah Pengajuan hari ini <?php echo MyFormatter::formatDateTimeForUser(date("Y-m-d")); ?></p>
    </div>
</div>
<div class="col-md-3 col-sm-6 col-sm-12">
    <div class="tile-stats tile-green">
        <div class="icon">
            <i class="fas fa-pump-medical"></i>
        </div>
        <div data-delay="0" data-duration="1500" data-postfix="" data-end="<?php echo $dataKolom[2]; ?>" data-start="0" class="num">0</div>
        <h3>Jumlah Pemesanan </h3>
        <p>Jumlah Pemesanan hari ini <?php echo MyFormatter::formatDateTimeForUser(date("Y-m-d")); ?></p>
    </div>
</div>
<div class="col-md-3 col-sm-6 col-sm-12">
    <div class="tile-stats tile-aqua">
        <div class="icon">
            <i class="fas fa-archive"></i>
        </div>
        <div data-delay="0" data-duration="1500" data-postfix="" data-end="<?php echo $dataKolom[3]; ?>" data-start="0" class="num">0</div>
        <h3> Jumlah Penyimpanan </h3>
        <p>Jumlah Penyimpanan hari ini <?php echo MyFormatter::formatDateTimeForUser(date("Y-m-d")); ?></p>
    </div>
</div>
<div class="col-md-3 col-sm-6 col-sm-12">
    <div class="tile-stats tile-blue">
        <div class="icon">
            <i class="fas fa-people-carry"></i>
        </div>
        <div data-delay="0" data-duration="1500" data-postfix="" data-end="<?php echo $dataKolom[4]; ?>" data-start="0" class="num">0</div>
        <h3> Jumlah Penerimaan </h3>
        <p>Jumlah Penerimaan hari ini <?php echo MyFormatter::formatDateTimeForUser(date("Y-m-d")); ?></p>
    </div>
</div>