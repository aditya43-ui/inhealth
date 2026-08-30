<?php
if ($caraPrint == 'EXCEL') {
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
    header('Cache-Control: max-age=0');
    echo $this->renderPartial('application.views.headerReport.headerDefaultNewExcel', array('judulLaporan' => $judulLaporan, 'periode' => '', 'colspan' => 8));
}
echo CHtml::css('.control-label{
        float:left; 
        text-align: right; 
        width:50%;
        color:black;
        padding-right:10px;
        font-size:8pt;
    }
    body{
        font-size:8pt;
    }
    td .uang{
        text-align:right;
    }
    .border th, .border td{
        border:1px solid #000;
    }
    .table thead:first-child{
        border-top:1px solid #000;        
    }
    
    thead th{
        background:none;
        color:#333;
    }
    
    .table tbody tr:hover td, .table tbody tr:hover th {
        background-color: none;
    }
');
//if (!isset($_GET['frame'])){
//echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array('judulLaporan'=>$judulLaporan)); 
//}
?>
<table style="width: 100%; border: none;">
    <thead>
        <tr>
            <td>
                <div class="header"><?php
                                    if ($caraPrint != 'EXCEL') {
                                        echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array());
                                    }
                                    ?></div>
            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <div class="content">
                    <div class="judulcontent"> <?php echo $judulLaporan ?> </div>
                    <table width="74%" style="margin: 0;" cellpadding="0" cellspacing="0">

                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td><b>No. Formulir</b> </td>
                            <td>:</td>
                            <td><?php echo $model->forminvbarang_no; ?></td>

                            <td><b>Total Volume</b></td>
                            <td>:</td>
                            <td><?php echo $format->formatNumberForPrint($model->forminvbarang_totalvolume); ?></td>
                        </tr>
                        <tr>
                            <td><b>Tanggal Formulir</b> </td>
                            <td>:</td>
                            <td><?php echo $format->formatDateTimeForUser($model->forminvbarang_tgl); ?></td>

                            <td><b>Total Harga (Rp)</b></td>
                            <td>:</td>
                            <td><?php echo $format->formatNumberForPrint($model->forminvbarang_totalharga); ?></td>
                        </tr>
                    </table><br>
                    <table width="100%" border="0" class="border">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Kode Barang</th>
                                <th>Nama Barang</th>
                                <th>Merk</th>
                                <th>No. Seri</th>
                                <th>Satuan Kecil</th>
                                <th>HPP (Rp)</th>
                                <th>Inventarisasi Sistem</th>
                                <th>Sub Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $totVol = 0;
                            $totHarga = 0;
                            foreach ($modDetails as $i => $barang) {
                            ?>
                                <tr>
                                    <td style="text-align: center;"><?php echo ($i + 1); ?></td>
                                    <td style="text-align: center;"><?php echo (isset($barang->barang->barang_kode) ? $barang->barang->barang_kode : ""); ?></td>
                                    <td><?php echo $barang->barang->barang_nama; ?></td>
                                    <td><?php echo $barang->barang->barang_merk; ?></td>
                                    <td><?php echo $barang->barang->barang_noseri; ?></td>
                                    <td><?php echo $barang->barang->barang_satuan; ?></td>
                                    <td style="text-align:right;"><?php
                                                                    $data = BarangM::model()->findByPk($barang->barang_id);
                                                                    echo $format->formatNumberForPrint(
                                                                        (isset($data->barang_hpp) && !empty($data->barang_hpp) && $data->barang_hpp != 0) ? $data->barang_hpp : $data->barang_harganetto
                                                                    );

                                                                    $totVol += $barang->volume_inventaris;
                                                                    $totHarga += ($barang->volume_inventaris * ((isset($data->barang_hpp) && !empty($data->barang_hpp) && $data->barang_hpp != 0) ? $data->barang_hpp : $data->barang_harganetto));
                                                                    ?></td>
                                    <td style="text-align:right;"><?php echo $format->formatNumberForPrint($barang->volume_inventaris); ?></td>
                                    <td style="text-align:right;"><?php echo $format->formatNumberForPrint($barang->volume_inventaris * ((isset($data->barang_hpp) && !empty($data->barang_hpp) && $data->barang_hpp != 0) ? $data->barang_hpp : $data->barang_harganetto)); ?></td>

                                </tr>
                            <?php } ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="7" style="text-align:right;"><b>Total</b></td>
                                <td style="text-align:right;"><?php echo $format->formatNumberForPrint($totVol); ?></td>
                                <td style="text-align:right;"><?php echo $format->formatNumberForPrint($totHarga); ?></td>
                            </tr>
                        </tfoot>
                    </table>

                    <table width="100%" style="margin-top:20px;">
                        <tr>
                            <td width="100%" align="left" align="top">
                                <table style="width: 100%; border: none;">
                                    <tr>
                                        <td width="35%" style="text-align:center;">
                                        </td>
                                        <td width="35%" style="text-align:center;">
                                        </td>
                                        <td width="35%" style="text-align:center;">
                                            <div><?php echo Yii::app()->user->getState("kabupaten_nama") . ", " . MyFormatter::formatDateTimeId(date('Y-m-d')); ?></div>
                                            <div>Petugas</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td style="text-align:center;">
                                            <div><?php echo Yii::app()->user->getState('nama_pegawai'); ?></div>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
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
if (isset($_GET['frame'])) {
    echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "print('PRINT')"));
    echo CHtml::link(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "print('EXCEL')"));
?>
    <script type='text/javascript'>
        /**
         * print
         */
        function print(caraPrint) {
            formulirinvbarang_id = '<?php echo isset($model->formulirinvbarang_id) ? $model->formulirinvbarang_id : ''; ?>';
            window.open('<?php echo $this->createUrl('print'); ?>&formulirinvbarang_id=' + formulirinvbarang_id + '&caraPrint=' + caraPrint, 'printwin', 'left=100,top=100,width=640,height=480');
        }
    </script>

<?php } //else{ 
?>

<?php //} 
