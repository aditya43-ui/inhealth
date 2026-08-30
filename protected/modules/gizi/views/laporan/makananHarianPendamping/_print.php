
<?php
if ($caraPrint == 'EXCEL') {
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
    header('Cache-Control: max-age=0');
}
if ($caraPrint != 'EXCEL') {
    if ($caraPrint == 'PRINT') {
        echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksi', array('judulLaporan' => $judulLaporan, 'periode' => 'Periode : ' . $periode, 'colspan' => 13));
        ?>
        <?php $this->renderPartial('makananHarianPendamping/_table', array('model' => $model, 'caraPrint' => $caraPrint)); ?>

        <div class="footer">
            <table style="width: 100%; border: none;">
                <tr>
                    <td HEIGHT=2 style="border-bottom: 2px solid #000000" width="100%" colspan="4"> </td>
                </tr>
                <tr>
                    <td width="25%" align="left"><span FACE="" SIZE=<?php echo isset($judulFont) ? $judulFont : 2; ?> color="black"><?php echo date("d/m/Y"); ?></span></td>
                    <td width="50%" align="center"><span FACE="" SIZE=<?php echo isset($judulFont) ? $judulFont : 2; ?> color="black">Bagian Unit Kerja <?php echo InstalasiM::model()->findByPk(Yii::app()->user->getState('instalasi_id'))->instalasi_nama; ?></span></td>
                    <td width="25%" align="right"><span FACE="" SIZE=<?php echo isset($judulFont) ? $judulFont : 2; ?> color="black"><div id="pageFooter">Hal </div></span></td>
                </tr>
                <tr>
                    <td width="25%" align="left"></td>
                    <td width="50%" align="center"> </td>
                    <td width="25%" align="right"></td>
                </tr>

            </table>
        </div>

        <?php
    } else {
        echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksi', array('judulLaporan' => $judulLaporan, 'periode' => 'Periode : ' . $periode, 'colspan' => 14));
    }
} else {
    echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksiExcel', array('judulLaporan' => $judulLaporan, 'periode' => 'Periode : ' . $periode, 'colspan' => 13));
}
?>

<?php
if ($caraPrint == 'PDF') {
    echo "<div class='header-space'>&nbsp;</div>";
    $this->renderPartial('makananHarianPendamping/_table', array('model' => $model, 'caraPrint' => $caraPrint));
    echo "<div class='footer-space'>&nbsp;</div>";
}
if ($caraPrint == 'EXCEL') {
    echo "<div class='header-space'>&nbsp;</div>";
    $this->renderPartial('makananHarianPendamping/_table', array('model' => $model, 'caraPrint' => $caraPrint));
    echo "<div class='footer-space'>&nbsp;</div>";
    ?>
    <table width="100%" border="1">

        <tr>
            <td colspan="11" align="left"></td>
            <td colspan="3" align="center"><?php echo $this->renderPartial('application.views.headerReport.footerexcel_mcu', array()); ?></td>

        </tr>

    </table>
    <?php
}





if ($caraPrint == 'GRAFIK')
    echo $this->renderPartial('_grafik', array('model' => $model, 'data' => $data, 'caraPrint' => $caraPrint), true);
?>

