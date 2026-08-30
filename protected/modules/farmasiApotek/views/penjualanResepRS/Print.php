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
                    echo $this->renderPartial('application.views.headerReport.headerDefaultNewest', array());
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
<style type="text/css">
    table.identitas-pasien tr td{
        vertical-align: top;
        padding: 3px;
    }
</style>
<table width="100%" style="margin:0px;" cellpadding="0" cellspacing="0" class="identitas-pasien">
        <tr>
            <td align="center" valig="middle" colspan="6">
                <div class="judulcontent"><?php echo $judul_print ?></div>
                <br/>
            </td>
        </tr>

        <tr>
            <td>No. RM</td>
            <td>:</td>
            <td><?php echo $modPenjualan->pasien->no_rekam_medik; ?></td>

            <td>No. Resep</td>
            <td>:</td>
            <td><?php echo $modPenjualan->noresep; ?></td>
        </tr>
        <tr>
            <td>Nama Pasien</td>
            <td>:</td>
            <td><?php echo $modPenjualan->pasien->namadepan.' '.$modPenjualan->pasien->nama_pasien; ?></td>

            <td>Tanggal Resep</td>
            <td>:</td>
            <td><?php echo $format->formatDateTimeForUser($modPenjualan->tglresep); ?></td>
        </tr>
        <tr>
            <td>Tgl Lahir</td>
            <td>:</td>
            <td><?php echo $format->formatDateTimeForUser($modPenjualan->pasien->tanggal_lahir); ?></td>

            <td>Jenis Penjualan</td>
            <td>:</td>
            <td><?php echo $modPenjualan->jenispenjualan; ?></td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>:</td>
            <td><?php echo $modPenjualan->pasien->alamat_pasien; ?></td>

            <td>Tanggal Penjualan</td>
            <td>:</td>
            <td><?php echo $format->formatDateTimeForUser($modPenjualan->tglpenjualan); ?></td>
        </tr>
        <tr>
            <td>Nama Dokter</td>
            <td>:</td>
            <td><?php echo isset($modPenjualan->pegawai->NamaLengkap) ? $modPenjualan->pegawai->NamaLengkap : ""; ?></td>
        </tr>
    </table><br/>
    <table width="100%" style='margin-left:auto; margin-right:auto;' class ="border">
        <thead>
            <tr class="border">
                <th style="text-align: center;">Nama Obat</th>
                <th style="text-align: center;">Jumlah</th>
                <th style="text-align: center;">Signa</th>
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
          // $ppnpersen = round($modObat->jumlahppn/$jumlhqty * 100,2);
        ?>
            <tr>
                <!--<td align="center"><?php // echo ($i+1); ?></td>-->
                <!--<td align="center"><?php // echo isset($modObat->penjualanresep->antrianfarmasi_id) ? $modObat->penjualanresep->antrianfarmasi->noantrian: "-"; ?></td>-->
                <!--<td align="center"><?php // echo $modObat->r; ?></td>-->
                <!--<td align="center"><?php // echo $modObat->rke; ?></td>-->
                <!--<td><?php // echo (!empty($modObat->obatalkes->obatalkes_kode) ? $modObat->obatalkes->obatalkes_kode."/ " : "") ."". $modObat->obatalkes->obatalkes_nama; ?></td>-->
                <td><?php echo $modObat->obatalkes->obatalkes_nama; ?></td>
                <!--<td><?php // echo (!empty($modObat->etiket) ? $modObat->etiket : ""); ?></td>-->
                <!--<td>-->
					<?php // echo (!empty($modObat->signa_oa) ? $modObat->signa_oa : ""); ?>
					<?php
//							echo "<hr/>";
//							echo $modObat->ket_penggunaan;
					?>
				<!--</td>-->
                <!--td><?php // echo $modObat->satuankecil->satuankecil_nama; ?></td-->
                <td align="right"><?php echo $modObat->qty_oa." ".$modObat->satuankecil->satuankecil_nama; ?></td>
                <td><?php echo $modObat->signa_oa; ?></td>
                <td align="right"><?php echo $format->formatNumberForPrint($modObat->hargasatuan_oa,2); ?></td>
                <td align="right"><?php echo $format->formatNumberForPrint($modObat->total_embalase,2); ?></td>
                <td align="right"><?php echo $format->formatNumberForPrint($modObat->biayaadministrasi,2); ?></td>
                <td align="right"><?php echo $format->formatNumberForPrint($totaladmin,2); ?></td>
                <td align="right"><?php echo $modObat->persen_discount; ?></td>
                <td align="right"><?php echo $format->formatNumberForPrint($modObat->discount,2); ?></td>
                <td align="right"><?php echo $modObat->persenppnjual; ?></td>
                <td align="right"><?php echo $format->formatNumberForPrint($modObat->jumlahppn,2); ?></td>
                <!--<td align="right"><?php // echo $modObat->discount; ?></td>-->
                <td align="right"><?php
                    // $discount = (($modObat->hargasatuan_oa * $modObat->qty_oa) * ($modObat->discount/100));
                    // $subtotal = (($modObat->hargasatuan_oa * $modObat->qty_oa) - $discount);
                    // if($subtotal <=0 ){
                    //     $subtotal = 0;
                    // }
                    $subtotal = $modObat->hargajual_oa;
                    $jasapelayanan_farmasi = $modPenjualan->jasapelayanan_farmasi;
                    $total = $total + $jasapelayanan_farmasi + $subtotal;
                    echo $format->formatNumberForPrint($subtotal,2); ?>
                </td>
            </tr>
        <?php } ?>
        <tfoot class="border">
            <tr>
                <td colspan="11" align="center"><strong>Jasa Pelayanan Farmasi</strong></td>
                <td align="right"><?php echo $format->formatNumberForPrint($jasapelayanan_farmasi,2); ?></td>
            </tr>
            <tr>
                <td colspan="11" align="center"><strong>Total</strong></td>
                <td align="right"><?php echo $format->formatNumberForPrint($total,2); ?></td>
            </tr>
            <?php if(!empty($modPenjualan->jasapelayanan_farmasi)){ ?>
            <tr>
                <td colspan="11" align="center"><strong>Jasa Pelayanan Farmasi</strong></td>
                <td align="right"><?php echo $format->formatNumberForPrint($modPenjualan->jasapelayanan_farmasi, 2); ?></td>
            </tr>
            <?php } ?>
            <tr>
                <td colspan="11" align="center"><strong>Total Keseluruhan</strong></td>
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
        <td><i><?php echo Yii::app()->user->getState('pesandistruk'); ?></i></td>
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
