<?php

$date = date('Y-m-d');

$model = new KPPresensiT;
$model->unsetAttributes();
$model->tglpresensi = $model->tglpresensi_akhir = $date;

$model->statuskehadiran_id = Params::STATUSKEHADIRAN_ALPHA;
$res_alpha = $model->searchInformasiPresensiBaru();

$link_alpha = array(
    'KPPresensiT' => array(
        'tglpresensi' => $date,
        'tglpresensi_akhir' => $date,
        'statuskehadiran_id' => $model->statuskehadiran_id,
    )
);

$model->statuskehadiran_id = Params::STATUSKEHADIRAN_HADIR;
$res_hadir = $model->searchInformasiPresensiBaru();

$link_hadir = array(
    'KPPresensiT' => array(
        'tglpresensi' => $date,
        'tglpresensi_akhir' => $date,
        'statuskehadiran_id' => $model->statuskehadiran_id,
    )
);

$model->statusscan = "Terlambat";
$model->statuskehadiran_id = null;
$res_terlambat = $model->searchInformasiPresensiBaru();

$link_terlambat = array(
    'KPPresensiT' => array(
        'tglpresensi' => $date,
        'tglpresensi_akhir' => $date,
        'statusscan' => $model->statusscan
    )
);
?>

<div class="col-md-3 col-sm-6 col-sm-12">
    <div class="tile-stats tile-red">
        <div class="icon">
            <i class="fas fa-user-times"></i>
        </div>
        <div data-delay="0" data-duration="1500" data-postfix="" data-end="<?php echo count((array)$res_alpha); ?>" data-start="0" class="num">0</div>
        <a href="<?php echo $this->createUrl('presensiT/informasiPresensi', $link_alpha); ?>" target="_parent">
            <h3>Absensi Pegawai</h3>
            <p>Pegawai yang tidak hadir hari ini.</p>
        </a>
    </div>
</div>

<div class="col-md-3 col-sm-6 col-sm-12">
    <div class="tile-stats tile-green">
        <div class="icon">
            <i class="fas fa-user-check"></i>
        </div>
        <div data-delay="600" data-duration="1500" data-postfix="" data-end="<?php echo count((array)$res_hadir); ?>" data-start="0" class="num">0</div>
        <a href="<?php echo $this->createUrl('presensiT/informasiPresensi', $link_hadir); ?>" target="_parent">
            <h3>Presensi Pegawai</h3>
            <p>Pegawai yang hadir hari ini.</p>
        </a>
    </div>
</div>

<div class="col-md-3 col-sm-6 col-sm-12">
    <div class="tile-stats tile-aqua">
        <div class="icon">
            <i class="fas fa-user-clock"></i>
        </div>
        <div data-delay="1200" data-duration="1500" data-postfix="" data-end="<?php echo count((array)$res_terlambat); ?>" data-start="0" class="num">0</div>
        <a href="<?php echo $this->createUrl('presensiT/informasiPresensi', $link_terlambat); ?>" target="_parent">
            <h3>Pegawai Terlambat</h3>
            <p>Pegawai yang terlambat hari ini.</p>
        </a>
    </div>
</div>

<div class="col-md-3 col-sm-6 col-sm-12">
    <div class="tile-stats tile-blue">
        <div class="icon">
            <i class="fas fa-user-plus"></i>
        </div>
        <div data-delay="1800" data-duration="1500" data-postfix="" data-end="<?php echo $dataKolom[4]; ?>" data-start="0" class="num">0</div>
        <h3>Pegawai Baru</h3>
        <p>Pegawai baru bulan ini.</p>
    </div>
</div>