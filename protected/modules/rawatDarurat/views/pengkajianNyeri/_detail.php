<?php

$ceklis = '<span class="fa fa-check-square-o"></span>';
$unceklis = '<span class="fa fa-square-o"></span>';

$skoring = array(
    "wbs" => "Wong Baker Faces Pain Scale",
    "flaccs" => "Skala FLACCS",
    "nrs" => "Numerical Rating Scale (NRS)",
    "vas" => "Visual Analog Scale (VAS)",
    "bps_tanpaventilator" => "Behavioural Pain Scale Tanpa Ventilator",
    "bps_ventilator" => "Behavioural Pain Scale Ventilator",
    "nips" => "Neonatal Infant Pain Score",
);
$tipe_nyeri = array('Akut'=>'Akut', 'Kronis'=>'Kronis');
$list_kualitas = LookupM::getItemsUrutan('kualitasnyeri');

if (!is_array($model->deskripsinyeri_kualitasnyeri)) {
    $model->deskripsinyeri_kualitasnyeri = CJSON::decode($model->deskripsinyeri_kualitasnyeri);
}

$list_jalar = array('Tidak'=>'Tidak', 'Ya'=>'Ya');
$list_tingkat = array('Tidak Nyeri'=>'Tidak Nyeri', 'Ringan'=>'Ringan', 'Sedang'=>'Sedang', 'Berat'=>'Berat');
$list_waktu = LookupM::getItemsUrutan('frekuensinyeri');
?>

<div class="base_det">
    <div class="det_label">Sistem Skoring : </div>
    <div class="det_val">
        <?php foreach ($skoring as $val => $label) {
        ?>
        <div><?php echo $val == $model->sistemskoring ? $ceklis : $unceklis; ?> <?php echo $label ?></div>
        <?php } ?>
    </div>
</div>
<br/>
<div class="base_det">
    <div class="det_label">Tipe Nyeri : </div>
    <div class="det_val">
        <?php foreach ($tipe_nyeri as $val => $label) {
        ?>
        <div style="display: inline-block;"><?php echo $val == $model->tipenyeri ? $ceklis : $unceklis; ?> <?php echo $label ?></div>
        <?php } ?>
    </div>
</div>
<br/>
<div class="base_det">
    <div class="det_label">Skala Nyeri Skor : </div>
    <div class="det_val">
        <?php echo $model->skalanyeri; ?>
    </div>
</div>
<br/>
<div class="base_det">
    <div class="det_label">Deskripsi Nyeri : </div>
    <div class="det_val">
        <div>
            <div class="det_label2">Lokasi : </div>
            <div class="det_val2">
                <?php echo $model->deskripsinyeri_lokasinyeri; ?>
            </div>
        </div>
        <div>
            <div class="det_label2">Onset : </div>
            <div class="det_val2">
                <?php echo $model->deskripsinyeri_onset." ".$model->deskripsinyeri_onsetsatuan; ?>
            </div>
        </div>
        <div>
            <div class="det_label2">Pencetus : </div>
            <div class="det_val2">
                <?php echo $model->deskripsinyeri_pencetus; ?>
            </div>
        </div>
        <div>
            <div class="det_label2">Kualitas : </div>
            <div class="det_val2"><?php
            foreach ($list_kualitas as $val => $label) { ?>
                <div style="display: inline; width: 70px; margin-right: 5px;"><?php echo (!empty($model->deskripsinyeri_kualitasnyeri) && is_array($model->deskripsinyeri_kualitasnyeri) && in_array($val, $model->deskripsinyeri_kualitasnyeri)) ? $ceklis : $unceklis; ?>
                <?php echo $label.((
                    !empty($model->deskripsinyeri_kualitasnyeri) 
                    && is_array($model->deskripsinyeri_kualitasnyeri) 
                    && in_array($val, $model->deskripsinyeri_kualitasnyeri)
                    && $val == "Lainnya") ? ", ".$model->deskripsinyeri_kualitasnyerilainnya : ""); ?></div>
            <?php };
            
            ?>
            
            </div>
        </div>
        <div>
            <div class="det_label2">Menjalar : </div>
            <div class="det_val2">
                <?php foreach ($list_jalar as $item): ?>
                <div style="display: inline; margin-right: 5px;"><?php echo ($item == $model->deskripsinyeri_menjalar ? $ceklis : $unceklis).$item.($item == $model->deskripsinyeri_menjalar && $item == "Ya" ? ", Lokasi : ".$model->deskripsinyeri_lokasipenjalaran : ""); ?></div>
                <?php endforeach ?>
            </div>
        </div>
        <div>
            <div class="det_label2">Tingkatan : </div>
            <div class="det_val2">
                <?php foreach ($list_tingkat as $item): ?>
                <div style="display: inline; margin-right: 5px;"><?php echo ($item == $model->deskripsinyeri_tingkatan ? $ceklis : $unceklis).$item; ?></div>
                <?php endforeach ?>
            </div>
        </div>
        <div>
            <div class="det_label2">Waktu : </div>
            <div class="det_val2">
                <?php foreach ($list_waktu as $item): ?>
                <div style="display: inline; margin-right: 5px;"><?php echo ($item == $model->deskripsinyeri_frekuensinyeri ? $ceklis : $unceklis).$item.($item == $model->deskripsinyeri_frekuensinyeri && $item == "Lainnya" ? ", ".$model->deskripsinyeri_frekuensinyerilainnya : ""); ?></div>
                <?php endforeach ?>
            </div>
        </div>
    </div>
</div>
<br/>
<div class="base_det">
    <div class="det_label">Tatalaksana Nyeri : </div>
    <div class="det_val">
        <?php echo $model->tatalaksananyeri; ?>
    </div>
</div>
<br/>