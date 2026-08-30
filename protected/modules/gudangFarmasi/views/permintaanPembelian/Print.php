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
if(!$modPermintaanPembelianDetail){
    echo "Data tidak ditemukan"; exit;
}
$format = new MyFormatter;
$modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
if (!isset($_GET['frame'])){
    echo $this->renderPartial($this->path_view.'_headerObat'); 
}
?>
    <table width="74%" style="margin:0px;" cellpadding="0" cellspacing="0">
        <tr>
            <td  width="20%">No. PO</td>
            <td>:</td>
            <td><?php echo $modPermintaanPembelian->nopermintaan; ?></td>
        </tr>
        <tr>
            <td>Lampiran</td>
            <td>:</td>
            <td></td>
        </tr>
        <tr>
            <td>Perihal</td>
            <td>:</td>
            <td>Pesanan Obat / Alat Kesehatan habis pakai rutin</td>
        </tr>
        <tr>
            <td>No. Rek</td>
            <td>:</td>
            <td></td>
        </tr>
		<tr>
            <td>No. Perencanaan</td>
            <td>:</td>
            <td><?php echo !empty($modPermintaanPembelian->rencanakebfarmasi_id)?$modPermintaanPembelian->rencanakebfarmasi->noperencnaan:' - '; ?></td>
        </tr>
    </table><br/><br>
    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Kepada Yth. <?php echo $modPermintaanPembelian->supplier->supplier_nama; ?><br>
    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Di  <?php echo $modPermintaanPembelian->supplier->supplier_alamat; ?><br>
    Dengan hormat,<br>
    Dengan ini kami mohon pada saudara untuk dapat menyediakan obat dan alat kesehatan <?php echo $modProfilRs->nama_rumahsakit; ?>
    <br><br>
    <table width="100%" style='margin-left:auto; margin-right:auto;' >
        <thead class="border">
            <th style="text-align: center;">No.</th>
            <th style="text-align: center;">Asal Barang</th>
            <th style="text-align: center;">Kategori / Nama Obat</th>
            <th style="text-align: center;">Jumlah Kemasan (Satuan) </th>
            <th style="text-align: center;">Jumlah Pembelian</th>
            <th style="text-align: center;">Harga Netto</th>
<!--            <th style="text-align: center;">Stok Akhir</th>
            <th style="text-align: center;">PPN</th>
            <th style="text-align: center;">PPH</th>
            <th style="text-align: center;">Diskon (%)</th>
            <th style="text-align: center;">Diskon Total (Rp.)</th>
            <th style="text-align: center;">Minimal Stok</th>-->
            <th style="text-align: center;">Sub Total</th>
        </thead>
        <?php 
        $total = 0;
        $subtotal = 0;
        foreach ($modPermintaanPembelianDetail as $i=>$modObat){ 
        ?>
            <tr class="border">
                <td><?php echo ($i+1)."."; ?></td>
                <td><?php echo $modObat->sumberdana->sumberdana_nama; ?></td>
                <td><?php echo (!empty($modObat->obatalkes->obatalkes_kategori) ? $modObat->obatalkes->obatalkes_kategori."/ " : "") ."". $modObat->obatalkes->obatalkes_nama; ?></td>
                <td><?php echo number_format($modObat->kemasanbesar); ?></td>
                <td><?php echo number_format($modObat->jmlpermintaan); ?></td>
                <td><?php echo (Params::cekHiddenHargaGudangFarmasi()==true)? $format->formatUang($modObat->harganettoper):"Hidden"; ?></td>
<!--                <td><?php // echo number_format($modObat->stokakhir); ?></td>
                <td><?php // echo $modObat->persenppn; ?></td>
                <td><?php // echo $modObat->persenpph; ?></td>
                <td><?php // echo $modObat->persendiscount; ?></td>
                <td><?php // echo $format->formatUang($modObat->jmldiscount); ?></td>
                <td><?php // echo number_format($modObat->minimalstok); ?></td>-->
                <td><?php 
                    $subtotal = ($modObat->harganettoper * $modObat->jmlpermintaan);
                    $total += $subtotal;
                    echo (Params::cekHiddenHargaGudangFarmasi()==true)?$format->formatUang($subtotal):"Hidden"; ?>
                </td>
            </tr>
        <?php } ?>
        <tr>
            <td colspan="4" style="text-align: center;"><i>( <?php echo (Params::cekHiddenHargaGudangFarmasi()==true)?  $format->kataterbilang($total).'rupiah': "Hidden"?> )</i></td>
            <td colspan="2" align="center"><strong>Total</strong></td>
            <td   class="border"><?php echo (Params::cekHiddenHargaGudangFarmasi()==true)?$format->formatUang($total):"Hidden"; ?></td>
        </tr>
    </table><br>
    Demikian Surat Pesanan ini kami buat untuk dapat dipergunakan seperlunya,<br>
    Atas perhatian dan kerja sama yang baik kami ucapkan terima kasih.<br><br>
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
        permintaanpembelian_id = '<?php echo isset($modPermintaanPembelian->permintaanpembelian_id) ? $modPermintaanPembelian->permintaanpembelian_id : ''; ?>';
        window.open('<?php echo $this->createUrl('print'); ?>&permintaanpembelian_id='+permintaanpembelian_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
    }
    </script>
<?php
}else{ ?>
    <table width="100%" style="margin-top:20px;" >
    <tr>
        <td width="100%" align="left" align="top">
            <table width="100%">
                <tr>
                    <td width="35%" align="center">
                        <div>Pejabat Pengadaan</div>
                        <div style="margin-top:60px;"><?php echo isset($modPermintaanPembelian->pegawaimenyetujui_id) ? $modPermintaanPembelian->pegawai->NamaLengkap : "" ?></div>
                    </td>
<!--                    <td width="35%" align="center">
                        <div style="margin-top:60px;"><b>Mengetahui<br>Direktur</b></div>
                        <div style="margin-top:60px;"><?php // echo $modProfilRs->namadirektur_rumahsakit; ?></div>
                    </td>-->
                    <td width="35%" align="center">
                        <div><?php echo Yii::app()->user->getState("kabupaten_nama").", ".MyFormatter::formatDateTimeId(date('Y-m-d')); ?></div>
                        <div>Ka. Instalasi Farmasi</div>
                        <div style="margin-top:60px;"><?php  echo isset($modPermintaanPembelian->pegawai_id) ? $modPermintaanPembelian->pegawai->NamaLengkap : "" ?></div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    </table>
<?php } ?>
