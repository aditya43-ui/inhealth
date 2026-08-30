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
    .border{
        border:1px solid;
    }
');
?>  
<?php
if(!$modPenerimaanBarangDetail){
    echo "Data tidak ditemukan"; exit;
}
$format = new MyFormatter;
if (!isset($_GET['frame'])){
    echo $this->renderPartial('_headerPrint'); 
}
?>
    <table width="74%" style="margin:0px;" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center" valig="middle" colspan="3">
                <b><?php echo $judul_print ?></b>
            </td>
        </tr>
        <tr>
            <td>No. Penerimaan Barang</td>
            <td>:</td>
            <td><?php echo $modPenerimaanBarang->noterima; ?></td>
            
            <?php if(count($modFakturPembelian) > 0){ ?>
            <td>No. Faktur</td>
            <td>:</td>
            <td><?php echo $modFakturPembelian->nofaktur; ?></td>
            <?php } ?>
        </tr>
        <tr>
            <td>Tanggal Pembelian</td>
            <td>:</td>
            <td><?php echo $format->formatDateTimeForUser($modPenerimaanBarang->tglterima); ?></td>
            
            <?php if(count($modFakturPembelian) > 0){ ?>
            <td>Tanggal Kuitansi</td>
            <td>:</td>
            <td><?php echo $format->formatDateTimeForUser($modFakturPembelian->tglfaktur); ?></td>
            <?php } ?>
        </tr>
        <tr>
            <td>No. Kuitansi</td>
            <td>:</td>
            <td><?php echo $modPenerimaanBarang->nosuratjalan; ?></td>
        </tr>
        <tr>
            <td>Tanggal Surat Jalan</td>
            <td>:</td>
            <td><?php echo $format->formatDateTimeForUser($modPenerimaanBarang->tglsuratjalan); ?></td>
        </tr>
        <tr>
            <td>Status Penerimaan</td>
            <td>:</td>
            <td><?php echo $modPenerimaanBarang->statuspenerimaan; ?></td>
        </tr>
    </table><br/>
    <table width="100%" style='margin-left:auto; margin-right:auto;'>
        <thead class="border">
            <th style="text-align: center;">No.</th>
            <th style="text-align: center;">Asal Barang</th>
            <th style="text-align: center;">Kategori / Nama Obat</th>
            <th style="text-align: center;">No. Batch</th>
            <th style="text-align: center;">Tanggal Kadaluarsa</th>
            <th style="text-align: center;">Jumlah Kemasan</th>
            <th style="text-align: center;">Jumlah Pembelian</th>
            <th style="text-align: center;">Harga Satuan</th>
            <th style="text-align: center;">Keringanan (%)</th>
            <th style="text-align: center;">Keringanan Total (Rp.)</th>
            <th style="text-align: center;">Sub Total</th>
        </thead>
        <?php 
        $total = 0;
        $subtotal = 0;
        foreach ($modPenerimaanBarangDetail as $i=>$modObat){ 
			$modStokObatAlkes = StokobatalkesT::model()->findByAttributes(array('penerimaandetail_id'=>$modObat->penerimaandetail_id));
        ?>
            <tr>
                <td align="center"><?php echo ($i+1)."."; ?></td>
                <td><?php echo $modObat->sumberdana->sumberdana_nama; ?></td>
                <td><?php echo (!empty($modObat->obatalkes->obatalkes_kategori) ? $modObat->obatalkes->obatalkes_kategori."/ " : "") ."". $modObat->obatalkes->obatalkes_nama; ?></td>
                <td><?php echo (!empty($modStokObatAlkes->nobatch) ? $modStokObatAlkes->nobatch : ""); ?></td>
                <td><?php echo $format->formatDateTimeForUser($modObat->tglkadaluarsa); ?></td>
                <td align="center"><?php echo (isset($modObat->kemasanbesar) ? $modObat->kemasanbesar : 0 )." ".(isset($modObat->satuankecil_id) ? $modObat->satuankecil->satuankecil_nama : $modObat->satuanbesar->satuanbesar_nama); ?></td>
                <td align="right"><?php echo $modObat->jmlterima; ?></td>
                <td align="right"><?php echo $format->formatUang($modObat->harganettoper); ?></td>
                <td align="right"><?php echo $modObat->persendiscount; ?></td>
                <td align="right"><?php echo $modObat->jmldiscount; ?></td>
                <td align="right"><?php 
                    $discount = $modObat->jmldiscount;
                    $subtotal = (($modObat->harganettoper * $modObat->jmlpermintaan) - $discount);
                    if($subtotal <=0 ){
                        $subtotal = 0;
                    }
                    $total += $subtotal;
                    echo $format->formatUang($subtotal); ?>
                </td>
            </tr>
        <?php } ?>
        <tr>
            <td colspan="9" align="center"><strong>Total</strong></td>
            <td align="right"><?php echo $format->formatUang($total); ?></td>
        </tr>
    </table>
<?php
if (isset($_GET['frame'])){
    echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('PRINT')"));
    echo CHtml::link(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('EXCEL')")); 
?>
    <script type='text/javascript'>
    /**
     * print
     */    
    function print(caraPrint){
        penerimaanbarang_id = '<?php echo isset($modPenerimaanBarang->penerimaanbarang_id) ? $modPenerimaanBarang->penerimaanbarang_id : ''; ?>';
        window.open('<?php echo $this->createUrl('print'); ?>&penerimaanbarang_id='+penerimaanbarang_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
    }
    </script>
<?php
}else{ ?>
    <table width="100%" style="margin-top:20px;">
    <tr>
        <td width="100%" align="left" align="top">
            <table width="100%">
                <tr>
                    <td width="35%" align="center">
                        <div>Pegawai Mengetahui</div>
                        <div style="margin-top:60px;"><?php echo isset($modPenerimaanBarang->pegawaimengetahui->NamaLengkap) ? $modPenerimaanBarang->pegawaimengetahui->NamaLengkap : "" ?></div>
                    </td>
                    <td width="35%" align="center">
                        <div>Operator</div>
                        <div style="margin-top:60px;"><?php echo isset($modPenerimaanBarang->pegawai->NamaLengkap) ? $modPenerimaanBarang->pegawai->NamaLengkap : "" ?></div>
                    </td>
                    <td width="35%" align="center">
                        <div><?php echo Yii::app()->user->getState("kabupaten_nama").", ".MyFormatter::formatDateTimeId(date('Y-m-d')); ?></div>
                        <div>Pegawai Menyetujui</div>
                        <div style="margin-top:60px;"><?php echo isset($modPenerimaanBarang->pegawaimenyetujui->NamaLengkap) ? $modPenerimaanBarang->pegawaimenyetujui->NamaLengkap : "" ?></div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    </table>
<?php } ?>
