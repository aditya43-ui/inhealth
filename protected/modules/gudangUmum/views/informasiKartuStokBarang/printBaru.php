<?php
if ($caraPrint == 'EXCEL') {
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
    header('Cache-Control: max-age=0');
    echo $this->renderPartial('application.views.headerReport.headerDefaultNewExcel', array('judulLaporan' => $judulLaporan, 'periode' => "", 'colspan' => 4));
}
//echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksi',array('judulLaporan'=>$judulLaporan, 'periode'=>'Periode : '.$periode , 'colspan'=>8));  

if ($caraPrint != 'GRAFIK' && $caraPrint != 'PDF') {
    ?>

    <table style="width: 100%; border: none;">
        <thead>
            <tr>
                <td>
                    <div class="header"><?php
                        if ($caraPrint != 'EXCEL') {
                            echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array('judulLaporan' => $judulLaporan, 'periode' => ""));
                        }
                        ?></div>  
                </td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <div class="content">
                        <table width="100%" style="margin: 0;" cellpadding="0" cellspacing="0">
                            <tr>
                                <td width="10%">Kode</td>
                                <td width="15%">: <?php echo $model->barang_kode; ?></td>
                                <td width="10%">Jenis Barang</td>
                                <td width="15%">: <?php echo $model->jenisbarang_nama; ?></td>
                            </tr>
                            <tr>
                                <td>Tipe</td>
                                <td>: <?php echo $model->barang_type; ?></td>
                                <td>Nama</td>
                                <td>: <?php echo $model->barang_nama; ?></td>
                            </tr>
                            <tr>
                                <td>Satuan</td>
                                <td>: <?php echo $model->barang_satuan; ?></td>
                            </tr>
                        </table>
                        <?php $this->renderPartial($this->path_view . '_tableBaruPrint', array('model2' => $model2, 'caraPrint' => $caraPrint, 'pilihTgl' => $pilihTgl)); ?>

                    </div>		
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
        <?php if (isset($caraPrint) && $caraPrint != "PDF") { ?>
            <?php echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>
        <?php } ?>
    </div>   

    <?php
}
if ($caraPrint == 'PDF') {
    ?>
    <div class="header">
        <?php echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array('judulLaporan' => $judulLaporan, 'periode' => "")); ?>
    </div>
    <div class="content">
        <table width="100%" style="margin: 0;" cellpadding="0" cellspacing="0">
            <tr>
                <td width="10%">Kode</td>
                <td width="15%">: <?php echo $model->barang_kode; ?></td>
                <td width="10%">Jenis Barang</td>
                <td width="15%">: <?php echo $model->jenisbarang_nama; ?></td>
            </tr>
            <tr>
                <td>Tipe</td>
                <td>: <?php echo $model->barang_type; ?></td>
                <td>Nama</td>
                <td>: <?php echo $model->barang_nama; ?></td>
            </tr>
            <tr>
                <td>Satuan</td>
                <td>: <?php echo $model->barang_satuan; ?></td>
            </tr>
        </table>
        <?php $this->renderPartial($this->path_view . '_tableBaruPrint', array('model2' => $model2, 'caraPrint' => $caraPrint, 'pilihTgl' => $pilihTgl)); ?>
    </div>

    <?php
}
?>