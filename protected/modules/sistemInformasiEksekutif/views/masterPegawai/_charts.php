<?php
$displayTbl_1 = "";
$displayTbl_2 = "display:none;";
$displayTbl_3 = "display:none;";
$displayTbl_4 = "display:none;";
//echo $pilihanTab;
if (isset($pilihanTab)) {
    if ($pilihanTab == "jk") {
        $displayTbl_1 = "";
        $displayTbl_2 = "display:none;";
        $displayTbl_3 = "display:none;";
        $displayTbl_4 = "display:none;";
    } else if ($pilihanTab == "klp") {
        $displayTbl_1 = "display:none;";
        $displayTbl_2 = "";
        $displayTbl_3 = "display:none;";
        $displayTbl_4 = "display:none;";
    } else if ($pilihanTab == "pdk") {
        $displayTbl_1 = "display:none;";
        $displayTbl_2 = "display:none;";
        $displayTbl_3 = "";
        $displayTbl_4 = "display:none;";
    } else {
        $displayTbl_1 = "display:none;";
        $displayTbl_2 = "display:none;";
        $displayTbl_3 = "display:none;";
        $displayTbl_4 = "";
    }
}
if (isset($caraPrint)) {
    $scrollTbl = "";
} else {
    $scrollTbl = "max-width:100%;";
}
?>
<div id="div_jk" style="<?php echo $scrollTbl . $displayTbl_1; ?>">
    <?php if (!isset($caraPrint)) { ?>

    <?php } ?>
    <fieldset> 
        <?php
        $this->renderPartial('_jeniskelamin', array(
            'model' => $model,
            'dataPieChartJk' => $dataPieChartJk,
            'dataBarLineChartJk' => $dataBarLineChartJk,
            'dataTableJk' => $dataTableJk
                )
        );
        ?>
    </fieldset>
</div>
<div id="div_klp" style="<?php echo $scrollTbl . $displayTbl_2; ?>">
    <?php if (!isset($caraPrint)) { ?>
        <!--<legend class="rim">Laporan Jumlah Harian</legend>-->
    <?php } ?>
    <fieldset> 
        <?php
        $this->renderPartial('_kelompok', array(
            'model' => $model,
            'modelKlp' => $modelKlp,
            'dataPieChartKlp' => $dataPieChartKlp,
            'dataStackChartKlp' => $dataStackChartKlp,
            'graphsStackKlp' => $graphsStackKlp,
            'dataLineChartKlp' => $dataLineChartKlp,
            'graphsLineKlp' => $graphsLineKlp,
            'dataTableKlp' => $dataTableKlp
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
            'dataStackChartPdk' => $dataStackChartPdk,
            'graphsStackPdk' => $graphsStackPdk,
            'dataLineChartPdk' => $dataLineChartPdk,
            'graphsLinePdk' => $graphsLinePdk,
            'dataTablePdk' => $dataTablePdk
                )
        );
        ?>
    </fieldset>
</div>
<div id="div_umur" style="<?php echo $scrollTbl . $displayTbl_4; ?>">
    <?php if (!isset($caraPrint)) { ?>
        <!--<legend class="rim">Rekap Jumlah</legend>-->
    <?php } ?>
    <fieldset> 
        <?php
        $this->renderPartial('_umur', array(
            'model' => $model,
            'modelUmur' => $modelUmur,
            'dataPieChartUmur' => $dataPieChartUmur,
			'dataPieChartUmurDet' => $dataPieChartUmurDet,
            'dataTableUmur' => $dataTableUmur,
            'dataBarChartUmur' => $dataBarChartUmur
                )
        );
        ?>
    </fieldset>
</div>