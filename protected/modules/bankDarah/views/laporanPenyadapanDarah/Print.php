<?php if ($caraPrint == 'PDF') { ?>
    <style> 
        #headerlaporan {
            width: 119% !important; 
        }
    </style>
<?php } ?>
<?php
if ($caraPrint == 'EXCEL') {
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="' . 'Laporan Penyadapan Darah' . '-' . date("Y/m/d") . '.xls"');
    header('Cache-Control: max-age=0');
}
if ($caraPrint != 'EXCEL') {
    if ($caraPrint == 'PRINT') {
        ?>
        <span style="width: 100%">
            <?php
            echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksiNew', array('judulLaporan' => 'Laporan Penyadapan Darah', 'colspan' => 31));
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
                        <div class="content"><?php $this->renderPartial('table_print', array('model' => $model, 'caraPrint' => $caraPrint)); ?></div>
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
        <?php
    } else {
        echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksiNew', array('judulLaporan' => 'Laporan Penyadapan Darah', 'colspan' => 31));
        echo "<div class='header-space'>&nbsp;</div>";
        $this->renderPartial('table_print', array('model' => $model, 'caraPrint' => $caraPrint));
        echo "<div class='footer-space'>&nbsp;</div>";
    }
} else {
    echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksiExcelNew', array('judulLaporan' => 'Laporan Penyadapan Darah', 'colspan' => 31));
    echo "<div class='header-space'>&nbsp;</div>";
    $this->renderPartial('table_print', array('model' => $model, 'caraPrint' => $caraPrint));
    echo "<div class='footer-space'>&nbsp;</div>";
}
?>