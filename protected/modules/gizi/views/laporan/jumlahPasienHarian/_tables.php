<?php
$displayTbl_1 = "";
$displayTbl_2 = "display:none;";
//echo $pilihanTab;
if (isset($pilihanTab)) {
    if ($pilihanTab == "report") {
        $displayTbl_1 = "";
        $displayTbl_2 = "display:none;";
    } else {
        $displayTbl_1 = "display:none;";
        $displayTbl_2 = "";
    }
}
if (isset($caraPrint)) {
    $scrollTbl = "";
} else {
    $scrollTbl = "";
}
?>
<div id="div_reportJmlPasienHarian" style="<?php echo $scrollTbl . $displayTbl_1; ?>">
    <?php if (!isset($caraPrint)) { ?>
        <!--<legend class="rim">Laporan Jumlah Harian</legend>-->
    <?php } ?>
    <?php
    $this->renderPartial(
        'gizi.views.laporan.jumlahPasienHarian/_tableJmlPasienHarian',
        array(
            'model' => $model,
            'models' => $models,
        )
    );
    ?>
</div>

<div id="div_rekapJmlPasienHarian" style="<?php echo $scrollTbl . $displayTbl_2; ?>">
    <?php if (!isset($caraPrint)) { ?>
        <!--<legend class="rim">Rekap Jumlah</legend>-->
    <?php } ?>
    <?php
    $this->renderPartial(
        'gizi.views.laporan.jumlahPasienHarian/_tableRekapJmlPasienHarian',
        array(
            'model' => $model,
            'models' => $modRekaps,
        )
    );
    ?>
</div>