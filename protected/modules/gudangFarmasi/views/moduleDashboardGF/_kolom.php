<div class="col-md-3 col-sm-6 col-sm-12">
    <div class="tile-stats tile-red">
        <div class="icon">
            <i class="fas fa-file-signature"></i>
        </div>
        <div data-delay="0" data-duration="1500" data-postfix="" data-end="<?php echo $dataKolom[1]; ?>" data-start="0" class="num">0</div>
        <h3>Permintaan Penawaran</h3>
        <p>Hari Ini <?php echo MyFormatter::formatDateTimeId(date("Y-m-d")); ?></p>
    </div>
</div>

<div class="col-md-3 col-sm-6 col-sm-12">
    <div class="tile-stats tile-green">
        <div class="icon">
            <i class="fas fa-file-invoice"></i>
        </div>
        <div data-delay="600" data-duration="1500" data-postfix="" data-end="<?php echo $dataKolom[2]; ?>" data-start="0" class="num">0</div>
        <h3>Permintaan Pembelian</h3>
        <p>Hari Ini <?php echo MyFormatter::formatDateTimeId(date("Y-m-d")); ?></p>
    </div>
</div>

<div class="col-md-3 col-sm-6 col-sm-12">
    <div class="tile-stats tile-aqua">
        <div class="icon">
            <i class="fas fa-dumpster-fire"></i>
        </div>
        <div data-delay="1200" data-duration="1500" data-postfix="" data-end="<?php echo $dataKolom[3]; ?>" data-start="0" class="num">0</div>
        <h3>Pemusnahan Obat Alkes</h3>
        <p>Hari Ini <?php echo MyFormatter::formatDateTimeId(date("Y-m-d")); ?></p>
    </div>
</div>

<div class="col-md-3 col-sm-6 col-sm-12">
    <div class="tile-stats tile-blue">
        <div class="icon">
            <i class="fas fa-undo-alt"></i>
        </div>
        <div data-delay="1800" data-duration="1500" data-postfix="" data-end="<?php echo $dataKolom[4]; ?>" data-start="0" class="num">0</div>
        <h3>Retur Pembelian</h3>
        <p>Hari Ini <?php echo MyFormatter::formatDateTimeId(date("Y-m-d")); ?></p>
    </div>
</div>