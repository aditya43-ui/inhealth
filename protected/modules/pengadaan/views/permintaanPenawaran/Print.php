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

<style>
	.det td, .det th {
		border: 1px solid black;
		padding: 2px;
	}
</style>

<?php
if(!$modPenawaranDetail){
    echo "Data tidak ditemukan"; exit;
}
$format = new MyFormatter;
if (!isset($_GET['frame'])){
    echo $this->renderPartial($this->path_view.'_headerPrint'); 
}
?>
<table width="100%" style="margin:0px;" cellpadding="0" cellspacing="0">
    <tr>
        <td align="center" valig="middle" colspan="3">
            <b><?php echo $judul_print ?></b>
        </td>
    </tr>
    <tr>
        <td>No. Permintaan</td>
        <td>: </td>
        <td width="100%"><?php echo $modPermintaanPenawaran->nosuratpenawaran; ?></td>
    </tr>
    <tr>
        <td nowrap>Tanggal Permintaan</td>
        <td>: </td>
        <td><?php echo $format->formatDateTimeForUser($modPermintaanPenawaran->tglpenawaran); ?></td>
    </tr>
<!--    <tr>
        <td>Pegawai Mengetahui</td>
        <td>:</td>
        <td><?php // echo (isset($modPermintaanPenawaran->pegawaimengetahui->NamaLengkap) ? $modPermintaanPenawaran->pegawaimengetahui->NamaLengkap : ""); ?></td>
    </tr>
    <tr>
        <td>Pegawai Menyetujui</td>
        <td>:</td>
        <td><?php // echo (isset($modPermintaanPenawaran->pegawaimenyetujui->NamaLengkap) ? $modPermintaanPenawaran->pegawaimenyetujui->NamaLengkap : ""); ?></td>
    </tr>-->
    <tr>
        <td>Status Penawaran</td>
        <td>: </td>
        <td><?php echo $modPermintaanPenawaran->statuspenawaran; ?></td>
    </tr>
    <tr>
        <td colspan="3"><i>Merupakan penawaran <?= ($modPermintaanPenawaran->ispenawaranmasuk)?"masuk":"keluar"; ?> dari supplier <?= $modPermintaanPenawaran->supplier->supplier_nama; ?></i></td>
    </tr>
</table><br/>
<table width="100%" style='margin-left:auto; margin-right:auto;' class="det">
    <thead class="border">
        <th style="text-align: center;">No.</th>
        <th style="text-align: center;">Asal Barang</th>
        <th style="text-align: center;">Kategori / Nama Obat</th>
        <th style="text-align: center;">Jumlah Kemasan (Satuan) </th>
        <th style="text-align: center;">Jumlah Permintaan</th>
        <th style="text-align: center;">Harga Netto (Rp)</th>
        <th style="text-align: center;">Stok</th>
        <th style="text-align: center;">Minimal Stok</th>
        <th style="text-align: center;">Sub Total (Rp)</th>
    </thead>
    <?php 
    $total = 0;
    $subtotal = 0;
    foreach ($modPenawaranDetail as $i=>$modObat){ 
		$oa = ObatalkesM::model()->findByPk($modObat->obatalkes_id);
		//var_dump($modObat->attributes); die;
    ?>
        <tr>
            <td><?php echo ($i+1)."."; ?></td>
            <td><?php echo $modObat->sumberdana->sumberdana_nama; ?></td>
            <td><?php echo (!empty($modObat->obatalkes->obatalkes_kategori) ? $modObat->obatalkes->obatalkes_kategori."/ " : "") ."". $modObat->obatalkes->obatalkes_nama; ?></td>
            <td style="text-align: center;"><?php echo $modObat->kemasanbesar." ".$oa->satuankecil->satuankecil_nama; ?></td>
            <td style="text-align: center;"><?php echo $modObat->qty." ".$oa->satuanbesar->satuanbesar_nama; ?></td>
            <td style="text-align: right;"><?php echo $format->formatNumberForPrint($modObat->harganetto); ?></td>
            <td style="text-align: center;"><?php
            $modObat->stokakhir = StokobatalkesT::getJumlahStok($modObat->obatalkes_id, Yii::app()->user->getState('ruangan_id'));
            echo $modObat->stokakhir." ".$oa->satuankecil->satuankecil_nama; ?></td>
            <td style="text-align: center;"><?php echo $modObat->minimalstok; ?></td>
            <td style="text-align: right;"><?php 
                $subtotal = ($modObat->harganetto * $modObat->qty);
                $total += $subtotal;
                echo $format->formatNumberForPrint($subtotal); ?>
            </td>
        </tr>
    <?php } ?>
    <tr>
        <td colspan="8" align="center"><strong>Total</strong></td>
        <td style="text-align: right;"><?php echo $format->formatNumberForPrint($total); ?></td>
    </tr>
</table>
<?php
if (isset($_GET['frame'])){
    echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="entypo-print"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('PRINT')"));
    echo CHtml::link(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('EXCEL')")); 
?>
    <script type='text/javascript'>
    /**
     * print
     */    
    function print(caraPrint){
        permintaanpenawaran_id = '<?php echo isset($modPermintaanPenawaran->permintaanpenawaran_id) ? $modPermintaanPenawaran->permintaanpenawaran_id : ''; ?>';
        window.open('<?php echo $this->createUrl('print'); ?>&permintaanpenawaran_id='+permintaanpenawaran_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=640,height=480');
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
                        <div style="margin-top:60px;"><?php echo isset($modPermintaanPenawaran->pegawaimengetahui->NamaLengkap) ? $modPermintaanPenawaran->pegawaimengetahui->NamaLengkap : "" ?></div>
                    </td>
                    <td width="35%" align="center">
                        <div><?php echo Yii::app()->user->getState("kabupaten_nama").", ".MyFormatter::formatDateTimeId(date('Y-m-d')); ?></div>
                        <div>Pegawai Menyetujui</div>
                        <div style="margin-top:60px;"><?php echo isset($modPermintaanPenawaran->pegawaimenyetujui->NamaLengkap) ? $modPermintaanPenawaran->pegawaimenyetujui->NamaLengkap : "" ?></div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    </table>
<?php } ?>
