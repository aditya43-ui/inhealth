<?php
if (isset($caraPrint)){
    if($caraPrint=='EXCEL')
    {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$judul_print.'-'.date("Y/m/d").'.xls"');
        header('Cache-Control: max-age=0');
    }
}
?>
<?php
echo CHtml::css('.control-label{
        float:left;
        text-align: right;
        width:50%;
        color:black;
        padding-right:10px;
        font-size:9pt;
    }
    body{
        font-size:9pt;
    }
    td .uang{
        text-align:right;
    }
    .border th, .border td{
        border:1px solid #000;
        padding:2px;
    }
');
?>
<?php
$format = new MyFormatter;
if (!isset($_GET['frame'])){
   ?>
<table width="100%">
    <thead>
        <tr>
             <td>
                <div class="header"><?php
                    echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array());
                    ?></div>
            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <div class="content">
<?php
}
?>
    <table width="100%" style="margin:0px;" cellpadding="0" cellspacing="0">
        <tr>

            <td align="center" colspan="6">

                <div class="judulcontent"><b><?php echo $judul_print ?></b></div>
                <br/>
            </td>
        </tr>
        <tr>
            <td>Jenis Penjualan</td>
            <td>:</td>
            <td><?php echo $modPenjualan->jenispenjualan; ?></td>

            <td>Total Harga Jual</td>
            <td>:</td>
            <td><?php echo "Rp. ".MyFormatter::formatNumberForPrint($modPenjualan->totharganetto,2); ?></td>
        </tr>
        <tr>
          <td>Tanggal Penjualan</td>
          <td>:</td>
          <td><?php echo $format->formatDateTimeForUser($modPenjualan->tglpenjualan); ?></td>

          <td>Total PPN Jual</td>
          <td>:</td>
          <td><?php echo "Rp. ".MyFormatter::formatNumberForPrint($modPenjualan->totalppn,2); ?></td>
        </tr>
        <tr>
            <td>No. Resep</td>
            <td>:</td>
            <td><?php echo $modPenjualan->noresep; ?></td>

            <td>Keringanan Penjualan Karyawan</td>
            <td>:</td>
            <td><?php echo "Rp. ".MyFormatter::formatNumberForPrint($modPenjualan->discount,2); ?></td>
        </tr>
        <tr>
            <td>Tanggal Resep</td>
            <td>:</td>
            <td><?php echo $format->formatDateTimeForUser($modPenjualan->tglresep); ?></td>

            <td>Total Keseluruhan</td>
            <td>:</td>
            <td><?php echo "Rp. ".MyFormatter::formatNumberForPrint($modPenjualan->totalhargajual,2); ?></td>
        </tr>
        <tr>
          <td>Nama Dokter Resep</td>
          <td>:</td>
          <td><?php echo isset($modPenjualan->pegawai->NamaLengkap) ? $modPenjualan->pegawai->NamaLengkap : ""; ?></td>
        </tr>

        <tr>
            <td>Nama Pegawai</td>
            <td>:</td>
            <td><?php echo isset($modPenjualan->pasienpegawai->NamaLengkap) ? $modPenjualan->pasienpegawai->NamaLengkap : ""; ?></td>
        </tr>
    </table><br/>
    <table width="100%" style='margin-left:auto; margin-right:auto;' class ="border">
        <thead>
            <tr class="border">
                <th style="text-align: center;">Nama Obat</th>
                <th style="text-align: center;">Jumlah</th>
                <th style="text-align: center;">Harga Satuan (Rp)</th>
                <th style="text-align: center;">Total Embalase (Rp)</th>
                <th style="text-align: center;">Biaya Administrasi (Rp)</th>
                <th style="text-align: center;">Total Biaya Administrasi (Rp)</th>
                <th style="text-align: center;">Keringanan (%)</th>
                <th style="text-align: center;">Keringanan (Rp)</th>
                <th style="text-align: center;">PPN (%)</th>
                <th style="text-align: center;">PPN (Rp.)</th>
                <th style="text-align: center;">Sub Total</th>
            </tr>
        </thead>
        <?php
        $total = 0;
        $subtotal = 0;
        $jasapelayanan_farmasi = 0;
        foreach ($modPenjualanDetail as $i=>$modObat){
          $totaladmin = round(($modObat->biayaadministrasi * $modObat->qty_oa),2);
        ?>
            <tr>
                <td><?php echo $modObat->obatalkes->obatalkes_nama; ?></td>
                <td align="right"><?php echo $modObat->qty_oa." ".$modObat->satuankecil->satuankecil_nama; ?></td>
                <td align="right"><?php echo $format->formatNumberForPrint($modObat->hargasatuan_oa,2); ?></td>
                <td align="right"><?php echo $format->formatNumberForPrint($modObat->total_embalase,2); ?></td>
                <td align="right"><?php echo $format->formatNumberForPrint($modObat->biayaadministrasi,2); ?></td>
                <td align="right"><?php echo $format->formatNumberForPrint($totaladmin,2); ?></td>
                <td align="right"><?php echo $modObat->persen_discount; ?></td>
                <td align="right"><?php echo $format->formatNumberForPrint($modObat->discount,2); ?></td>
                <td align="right"><?php echo $modObat->persenppnjual; ?></td>
                <td align="right"><?php echo $format->formatNumberForPrint($modObat->jumlahppn,2); ?></td>
                <td align="right"><?php
                    $subtotal = $modObat->hargajual_oa;
                    $jasapelayanan_farmasi = $modPenjualan->jasapelayanan_farmasi;
                    $total = $total + $jasapelayanan_farmasi + $subtotal;
                    echo $format->formatNumberForPrint($subtotal,2); ?>
                </td>
            </tr>
        <?php } ?>
        <tfoot class="border">
            <tr>
                <td colspan="10" align="center"><strong>Jasa Pelayanan Farmasi</strong></td>
                <td align="right"><?php echo $format->formatNumberForPrint($jasapelayanan_farmasi,2); ?></td>
            </tr>
            <tr>
                <td colspan="10" align="center"><strong>Total</strong></td>
                <td align="right"><?php echo $format->formatNumberForPrint($total,2); ?></td>
            </tr>
            <?php if(!empty($modPenjualan->jasapelayanan_farmasi)){ ?>
            <tr>
                <td colspan="9" align="center"><strong>Jasa Pelayanan Farmasi</strong></td>
                <td align="right"><?php echo $format->formatNumberForPrint($modPenjualan->jasapelayanan_farmasi, 2); ?></td>
            </tr>
            <?php } ?>
            <tr>
                <td colspan="10" align="center"><strong>Total Keseluruhan</strong></td>
                <td align="right"><?php echo $format->formatNumberForPrint(($modPenjualan->jasapelayanan_farmasi + $total), 2); ?></td>
            </tr>
        </tfoot>
    </table>
<?php
if (isset($_GET['frame'])){
    echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="entypo-print"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('PRINT')"));
    echo CHtml::link(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('EXCEL')"));
?>
    <script type='text/javascript'>
    /**
     * print
     */
    function print(caraPrint){
        penjualanresep_id = '<?php echo isset($modPenjualan->penjualanresep_id) ? $modPenjualan->penjualanresep_id : ''; ?>';
        window.open('<?php echo $this->createUrl('print'); ?>&penjualanresep_id='+penjualanresep_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
    }
    </script>
<?php
}else{ ?>
    <table width="100%" style="margin-top:20px;">
    <tr>
        <td></td>
        <td></td>
        <td width="30%" align="center" align="top">
            <div><?php echo Yii::app()->user->getState("kabupaten_nama").", ".MyFormatter::formatDateTimeId(date('Y-m-d')); ?></div>
            <div>Operator</div>
            <div style="margin-top:60px;"><?php echo Yii::app()->user->getState('nama_pegawai'); ?></div>
        </td>
    </tr>
    </table>
<?php } ?>
<?php
if (!isset($_GET['frame'])){
?>
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
    <?php echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>
</div>
<?php
}
?>
