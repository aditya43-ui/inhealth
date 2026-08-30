<style> 
    #headerlaporan {
        width: 100% !important; 
    }
    @page {
        size: landscape;
        font-family: Arial, sans-serif;
        font-size: 12pt !important;
        padding-top: 30px;
        margin-top: 0px;
        margin-bottom: 0px;
        margin-left: 2cm;
        margin-right: 2cm;
       
    }
    @media print {
        @page {
            size: landscape
        }
        html, body {
            padding-top: 30px;
            width: 330mm;
            height: 210mm;
            line-height: 1.6;
        }
        div.footer {
            position: fixed;
            bottom: 0;
        }
    }
    table.footer {
        position: fixed;
        bottom: 0;
    }
    @media all {
    .page-break { display: none; }
    }

    @media print {
    .page-break { display: block; page-break-before: always; }
    }
</style>
<?php

$cekInstalasi = InstalasiM::model()->findByPk(Yii::app()->user->getState('instalasi_id'));
$unitkerja = !empty($cekInstalasi->instalasi_nama) ? 'Bagian Unit Kerja '.$cekInstalasi->instalasi_nama : '';
if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
if ($caraPrint != 'EXCEL') {
    if ($caraPrint == 'PRINT') {
        ?>
        <span style="width: 100%">
        <?php
        echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksiNew', array('judulLaporan' => $judulLaporan, 'periode' => 'Periode : ' . $periode, 'colspan' => 23));
        ?>
        </span>
        <table style="width: 100%">
            <thead>
                <tr>
                    <td>
                        
                    </td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <div class="content"><?php $this->renderPartial('seleksidonor/_table_print', array('model'=>$model, 'caraPrint'=>$caraPrint, 'modShow'=>$variabel['modShow'],'b'=>$variabel['b']));  ?></div>
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
        <div class="ttd page-break" style="padding-top:30px">
            <table style="width:100%">
                <tr>
                    <td width="50%" style="text-align: center"> Mengetahui<br>Kepala Instalasi Transfusi Darah<br><br><br><br><br></td>
                    <td width="50%" style="text-align: center"> Surabaya, <?php echo date('d ').MyFormatter::getMonthId(date('m')).date(' Y');  ?><br>Koordinator Pelayanan Donor<br><br><br><br><br> </td>
                </tr>
                <tr>
                    <td width="50%" style="text-align: center;">Dr. Betty Agustina T,SpPK(K)</td>
                    <td width="50%" style="text-align: center">Rosa Rusdiana, Amd.Kep</td>
                </tr>
                <tr>
                    <td width="50%" style="text-align: center;">NIP. 19760822 201101 2 005</td>
                    <td width="50%" style="text-align: center">NIP. 19661219 198903 2 007</td>
                </tr>
            </table>
        </div>
        <div class="footer">
            <table width="100%">
                <tr>
                    <td HEIGHT=2 style="border-bottom: 2px solid #000000" width="100%" colspan="4"> </td>
                </tr>
                <tr>
                    <td width="25%" align="left"><FONT FACE="" SIZE=<?php echo isset($judulFont) ? $judulFont : 2; ?> color="black"><?php echo date("d/m/Y, h:m:s"); ?></FONT></td>
                    <td width="50%" align="center"><FONT FACE="" SIZE=<?php echo isset($judulFont) ? $judulFont : 2; ?> color="black"><?php echo $unitkerja; ?></FONT></td>
                    <td width="25%" align="right"><FONT FACE="" SIZE=<?php echo isset($judulFont) ? $judulFont : 2; ?> color="black"><div id="pageFooter">Hal </div></FONT></td>
                </tr>
            </table>
        </div>
        <?php
    } else {
        echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksiNew', array('judulLaporan' => $judulLaporan, 'periode' => 'Periode : ' . $periode, 'colspan' => 23));
    }
} else {
    echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksiExcelNew', array('judulLaporan' => $judulLaporan, 'periode' => 'Periode : ' . $periode, 'colspan' => 23));
}
?>

<?php
if ($caraPrint == 'PDF') {
    echo "<div class='header-space'>&nbsp;</div>";
    $this->renderPartial('seleksidonor/_table_print', array('model'=>$model, 'caraPrint'=>$caraPrint, 'modShow'=>$variabel['modShow'],'b'=>$variabel['b'])); 
    echo "<div class='footer-space'>&nbsp;</div>";
}
if ($caraPrint == 'EXCEL') {
    echo "<div class='header-space'>&nbsp;</div>";
    $this->renderPartial('seleksidonor/_table_print', array('model'=>$model, 'caraPrint'=>$caraPrint, 'modShow'=>$variabel['modShow'],'b'=>$variabel['b'])); 
    echo "<div class='footer-space'>&nbsp;</div>";
}

if ($caraPrint == 'GRAFIK')
    echo $this->renderPartial('_grafik', array('model' => $model, 'data' => $data, 'caraPrint' => $caraPrint), true);
?>
