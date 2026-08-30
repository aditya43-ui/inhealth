<style>
    .tile-abortus {
        width: 100px;
        height: 100px;
        background: url(<?php echo Yii::app()->request->baseUrl; ?>/images/icon_dashboard_tile/abortus.ico) center center no-repeat;
        background-size: cover;
    }

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
            <i class="fas fa-baby"></i>
        </div>
        <div data-delay="0" data-duration="1500" data-postfix="" data-end="<?php echo $dataKolom[1]; ?>" data-start="0" class="num">0</div>
        <h3>Jumlah Kelahiran Bayi</h3>
        <p>Jumlah kelahiran bayi hari ini.</p>
    </div>
</div>

<div class="col-md-3 col-sm-6 col-sm-12">
    <div class="tile-stats tile-green">
        <div class="icon">
            <span class="fa-stack">
                <i class="fas fa-ban fa-stack-2x"></i>
                <i class="fas fa-baby fa-stack-1x"></i>
            </span>
        </div>
        <div data-delay="600" data-duration="1500" data-postfix="" data-end="<?php echo $dataKolom[2]; ?>" data-start="0" class="num">0</div>
        <h3>Jumlah Kematian Bayi</h3>
        <p>Jumlah kematian bayi hari ini.</p>
    </div>
</div>

<div class="col-md-3 col-sm-6 col-sm-12">
    <div class="tile-stats tile-aqua">
        <div class="icon">
            <i class="tile-abortus"></i>
        </div>
        <div data-delay="1200" data-duration="1500" data-postfix="" data-end="<?php echo $dataKolom[3]; ?>" data-start="0" class="num">0</div>
        <h3>Jumlah Abortus</h3>
        <p>Jumlah abortus hari ini.</p>
    </div>
</div>

<div class="col-md-3 col-sm-6 col-sm-12">
    <div class="tile-stats tile-blue">
        <div class="icon">
            <i class="tile-meninggal"></i>
        </div>
        <div data-delay="1800" data-duration="1500" data-postfix="" data-end="<?php echo $dataKolom[4]; ?>" data-start="0" class="num">0</div>
        <h3>Jumlah Kematian Ibu</h3>
        <p>Jumlah kematian ibu hari ini.</p>
    </div>
</div>