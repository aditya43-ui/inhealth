<?php if ($caraPrint == 'PDF') { ?>
<style> 
    #headerlaporan {
        width: 119% !important; 
    }
</style>
<?php }?>
<?php
if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.'Laporan Pengujian Konfirmasi Golongan Darah'.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
if ($caraPrint != 'EXCEL') {
    if ($caraPrint == 'PRINT') {
        ?>
        <span style="width: 100%">
        <?php
        echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksiNew', array('judulLaporan' => 'Laporan Pengujian Konfirmasi Golongan Darah', 'colspan' => 12));
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
        <br>
        <div class="ttd">
            <table style="width:100%">
                <tr>
                    <td width="50%" style="text-align: left"> Penanggung Jawab<br>Koordinator Pelayanan Donor<br><br><br><br><br><br><br></td>
                    <td width="50%" style="text-align: right"> Surabaya, <?php echo date('d ').MyFormatter::getMonthId(date('m')).date(' Y');  ?><br>Petugas Pelaksana<br><br><br><br><br><br><br> </td>
                </tr>
                <tr>
                    <td width="50%" style="text-align: left;">Rosa Rusdiana, Amd.Kep</td>
                    <td width="50%" style="text-align: right"></td>
                </tr>
                <tr>
                    <td width="50%" style="text-align: left;">NIP. 19661219 198903 2 007</td>
                    <td width="50%" style="text-align: right"></td>
                </tr>
            </table>
        </div>
        <?php
    } else {
        echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksiNew', array('judulLaporan' => 'Laporan Pengujian Konfirmasi Golongan Darah', 'colspan' => 12));
    }
} else {
    echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksiExcelNew', array('judulLaporan' => 'Laporan Pengujian Konfirmasi Golongan Darah', 'colspan' => 12));
}
?>

<?php
if ($caraPrint == 'PDF') {
    echo "<div class='header-space'>&nbsp;</div>";
    $this->renderPartial('table_print', array('model' => $model, 'caraPrint' => $caraPrint));
    echo "<div class='footer-space'>&nbsp;</div>";
}
if ($caraPrint == 'EXCEL') {
    echo "<div class='header-space'>&nbsp;</div>";
    $this->renderPartial('table_print', array('model' => $model, 'caraPrint' => $caraPrint));
    echo "<div class='footer-space'>&nbsp;</div>";
}

if ($caraPrint == 'GRAFIK')
    echo $this->renderPartial('_grafik', array('model' => $model, 'data' => $data, 'caraPrint' => $caraPrint), true);
?>
