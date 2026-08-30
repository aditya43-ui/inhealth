<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/themes/neon/assets/js/daterangepicker/moment.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/Chart.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/chartjs-plugin/annotation/chartjs-plugin-annotation.js', CClientScript::POS_END);
?>
<style> 
    #headerlaporan {
        width:110% !important; 
    }
</style>
<?php
if ($caraPrint == 'EXCEL') {
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
    header('Cache-Control: max-age=0');
}
if ($caraPrint != 'EXCEL') {
    if ($caraPrint == 'PRINT') {
        ?>
        <span>
        <?php
        echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksiNew', array('judulLaporan' => $judulLaporan, 'periode' => '', 'colspan' => 5));
        ?>
        </span>
        <table>
            <thead>
                <tr>
                    <td>
                        <div class="">&nbsp;</div>  
                    </td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <div class="content"><?php $this->renderPartial('_tableprint', array('dataTable' => $model, 'caraPrint' => $caraPrint)); ?></div>
                    </td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td>
                        <div class="footer-space">&nbsp;</div>
                    </td>
                </tr>
            </tfoot>
        </table>
        <div class="">
        </div>
        <div class="footer">
            <table width="97%" style="margin-left:28px">
                <tr>
                    <td HEIGHT=2 style="border-bottom: 2px solid #000000" width="97%" colspan="8"> </td>
                </tr>
                <tr>
                    <td width="25%" align="left"><FONT FACE="" SIZE=<?php echo isset($judulFont) ? $judulFont : 2; ?> color="black"><?php echo date("d/m/Y, h:m:s"); ?></FONT></td>
                    <td width="50%" align="center"><FONT FACE="" SIZE=<?php echo isset($judulFont) ? $judulFont : 2; ?> color="black">Bagian Unit Kerja <?php echo InstalasiM::model()->findByPk(Yii::app()->user->getState('instalasi_id'))->instalasi_nama; ?></FONT></td>
                    <td width="25%" align="right"><FONT FACE="" SIZE=<?php echo isset($judulFont) ? $judulFont : 2; ?> color="black"><div id="pageFooter">Hal </div></FONT></td>
                </tr>
            </table>
        </div>
        <?php
    } else {
//        echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksiNew', array('judulLaporan' => $judulLaporan, 'periode' => ' ', 'colspan' => 7));
    }
} else {
    echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksiExcelNew', array('judulLaporan' => $judulLaporan, 'periode' => ' ', 'colspan' => 5));
}
?>

<?php
if ($caraPrint == 'PDF') {
    $this->renderPartial('_tableprint', array('dataTable' => $model, 'caraPrint' => $caraPrint));
    echo "<div class='footer-space'>&nbsp;</div>";
}
if ($caraPrint == 'EXCEL') {
    $this->renderPartial('_tableprint', array('dataTable' => $model, 'caraPrint' => $caraPrint));
    echo "<div class='footer-space'>&nbsp;</div>";
} 
if ($caraPrint == 'GRAFIK') {
    echo '<canvas id="chart_TAT"> </canvas>';
    echo $this->renderPartial('_jsFunctions', array('dataTable' => $model), true);
}
?>