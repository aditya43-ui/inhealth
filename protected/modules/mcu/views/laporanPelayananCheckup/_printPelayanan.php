<?php
/**
 * digunakan untuk format laporan pada mcu kunjungan pasien 
 * RSST-3210
 * @author          Yusuf Putra Anugrah <yusufputra@.com>
 * @version         2.0.0
 * @link            http://172.9.1.15/simpp/docs/
 * 
 */
?>

<?php
if ($caraPrint == 'EXCEL') {
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
    header('Cache-Control: max-age=0');
}
if ($caraPrint != 'EXCEL') {
    if ($caraPrint == 'PRINT') {
        ?>
        <style>
             @media print {

                html, body {
/*                    padding: 1cm 1cm 1cm 1cm;*/
                    padding:0;
                    padding-top:1cm;
                    padding-bottom:1cm;
                    BODY,DIV,TABLE,TBODY,TFOOT,TR,TH,TD,P { font-family:"Arial"; font-size:12pt !important; }
                    THEAD { font-family:"Arial"; font-size:12pt !important; }
                    .footer {
                        width: 100%;
                        position: fixed;
                        bottom: 0;
                    }
                    
                }
                 .header-space{

                    height: 2cm;
                }
             }
              @page {
                padding:0;
                margin: 0cm 1cm 0cm 2cm;
                
            }
        </style>
        <?php

        echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksiNew', array('judulLaporan' => $judulLaporan, 'periode' => 'Periode : ' . $periode, 'colspan' => 12));
        ?>
        <table width="100%" style="margin-top:-2cm">
           <thead>
                <tr>
                    <td>
                        <div class="header-space">&nbsp;</div>  
                    </td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <div class="content"><?php $this->renderPartial($this->path_view.'_tablePelayanan', array('model' => $model, 'caraPrint' => $caraPrint)); ?></div>
                    </td></tr></tbody>
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
            <table style="width: 100%; border: none;">
                <tr>
                    <td ALIGN=CENTER VALIGN=MIDDLE HEIGHT=2 style="border-bottom: 2px solid #000000" width="" colspan="3"> </td>
                </tr>
                <tr>
                    <td width="" align="left"><span FACE="" SIZE=<?php echo isset($judulFont)?$judulFont:2; ?> color="black"><?php echo date("d/m/Y");?></span></td>
                    <td width="" align="center"><span FACE="" SIZE=<?php echo isset($judulFont)?$judulFont:2; ?> color="black">Bagian Unit Kerja <?php echo InstalasiM::model()->findByPk(Yii::app()->user->getState('instalasi_id'))->instalasi_nama;   ?></span></td>
                    <td width="" align="right"><span FACE="" SIZE=<?php echo isset($judulFont) ? $judulFont : 2; ?> color="black"><div id="pageFooter">Hal </div></span></td>
                </tr>
                <tr>
                    <td width="" align="left"></td>
                    <td width="" align="center"> </td>
                    <td width="" align="right"></td>
                </tr>

            </table>
        </div>
         

        <?php
        
    } else {
        echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksiNew', array('judulLaporan' => $judulLaporan, 'periode' => 'Periode : ' . $periode, 'colspan' => 12));
    }
} else {
    echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksiExcelNew', array('judulLaporan' => $judulLaporan, 'periode' => 'Periode : ' . $periode, 'colspan' => 12));
}
?>

<?php
if ($caraPrint == 'PDF') {
    echo "<div class='header-space'>&nbsp;</div>";
    $this->renderPartial($this->path_view.'_tablePelayanan', array('model' => $model, 'caraPrint' => $caraPrint));
    echo "<div class='footer-space'>&nbsp;</div>";
}
if ($caraPrint == 'EXCEL') {
    echo "<div class='header-space'>&nbsp;</div>";
    $this->renderPartial($this->path_view.'_tablePelayanan', array('model' => $model, 'caraPrint' => $caraPrint));
    echo "<div class='footer-space'>&nbsp;</div>";
    ?>
    <table width="100%" border="1">

        
        <tr>
            <td colspan="5" align="left"></td>
            <td colspan="3" align="center"><?php echo $this->renderPartial('application.views.headerReport.footerexcel_mcu', array()); ?></td>

        </tr>

    </table>
    <?php
}

