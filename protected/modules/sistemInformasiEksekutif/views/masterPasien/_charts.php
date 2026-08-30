<?php
$displayTbl_1 = "";
$displayTbl_2 = "display:none;";
$displayTbl_3 = "display:none;";
if (isset($pilihanTab)) {
    if ($pilihanTab == "ujk") {
        $displayTbl_1 = "";
        $displayTbl_2 = "display:none;";
        $displayTbl_3 = "display:none;";
    } else if ($pilihanTab == "kerja") {
        $displayTbl_1 = "display:none;";
        $displayTbl_2 = "";
        $displayTbl_3 = "display:none;";
    } else {
        $displayTbl_1 = "display:none;";
        $displayTbl_2 = "display:none;";
        $displayTbl_3 = "";
    }
}
if (isset($caraPrint)) {
    $scrollTbl = "";
} else {
    $scrollTbl = "max-width:100%;";
}
?>
<div id="div_ujk" style="<?php echo $scrollTbl . $displayTbl_1; ?>">
    <?php if (!isset($caraPrint)) { ?>
        <!--<legend class="rim">Laporan Jumlah Harian</legend>-->
    <?php } ?>
    <fieldset> 
        <?php
        $this->renderPartial('_ujk', array(
            'model' => $model,
//            'modelUmur' => $modelUmur,
            'dataPieChartUmur' => $dataPieChartUmur,
            'dataPieChartJk' => $dataPieChartJk,
            'dataTableUmur' => $dataTableUmur,
            'dataBarChartUmur' => $dataBarChartUmur,
            'graphsStackUmur' => $graphsStackUmur,
            'dataStackChartUmur' => $dataStackChartUmur,
            'dataStackChartJk' => $dataStackChartJk
                )
        );
        ?>
    </fieldset>
</div>
<div id="div_kerja" style="<?php echo $scrollTbl . $displayTbl_2; ?>">
    <?php if (!isset($caraPrint)) { ?>
        <!--<legend class="rim">Laporan Jumlah Harian</legend>-->
    <?php } ?>
    <fieldset> 
        <?php
        $this->renderPartial('_pekerjaan', array(
            'model' => $model,
            'dataPieChartKerja' => $dataPieChartKerja,
            'dataTableKerja' => $dataTableKerja,
            'dataStackChartKerja' => $dataStackChartKerja,
            'graphsStackKerja'=>$graphsStackKerja
                )
        );
        ?>
    </fieldset>
</div>
<div id="div_pdk" style="<?php echo $scrollTbl . $displayTbl_3; ?>">
    <?php if (!isset($caraPrint)) { ?>
        <!--<legend class="rim">Laporan Jumlah Harian</legend>-->
    <?php } ?>
    <fieldset> 
        <?php
        $this->renderPartial('_pendidikan', array(
            'model' => $model,
            'dataPieChartPdk' => $dataPieChartPdk,
            'dataTablePdk' => $dataTablePdk,
            'dataStackChartPdk' => $dataStackChartPdk,
            'graphsStackPdk'=>$graphsStackPdk
                )
        );
        ?>
    </fieldset>
</div>