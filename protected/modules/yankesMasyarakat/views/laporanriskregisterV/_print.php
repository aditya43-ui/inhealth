<style>

    @page {

        width: <?php echo Params::height_F4 ?>mm;
        height:<?php echo Params::width_F4 ?>mm;
        font-family:"Times New Roman"; 
        font-size:12pt;

    }
    @media print {

        html, body {
            padding-top: 30px;
            width: <?php echo Params::height_F4 ?>mm;
            height:<?php echo Params::width_F4 ?>mm;
            font-family:"Times New Roman"; 
            font-size:12pt;

        }
        .ttd {
            page-break-inside: avoid;
        }

    }
</style><?php
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
        echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksiNew', array('judulLaporan' => $judulLaporan, 'periode' => '', 'colspan' => 16));
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
                        <div class="content"><?php $this->renderPartial('_tables', array('model' => $model, 'tabel' => $tabel, 'caraPrint' => $caraPrint)); ?></div>
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
                    <td HEIGHT=2 style="border-bottom: 2px solid #000000" width="97%" colspan="4"> </td>
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
        echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksiNew', array('judulLaporan' => $judulLaporan, 'periode' => ' ', 'colspan' => 16));
    }
} else {
    echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksiExcelNew', array('judulLaporan' => $judulLaporan, 'periode' => ' ', 'colspan' => 16));
}
?>

<?php
if ($caraPrint == 'PDF') {
    echo "<div class='header-space'>&nbsp;</div>";
    $this->renderPartial('_tables', array('model' => $model, 'tabel' => $tabel, 'caraPrint' => $caraPrint));
    echo "<div class='footer-space'>&nbsp;</div>";
}
if ($caraPrint == 'EXCEL') {
    echo "<div class='header-space'>&nbsp;</div>";
    $this->renderPartial('_tables', array('model' => $model, 'tabel' => $tabel, 'caraPrint' => $caraPrint));
    echo "<div class='footer-space'>&nbsp;</div>";
} 
?>