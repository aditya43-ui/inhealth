<style>
    body {
        color: black;
        font-size: 10px;
    }
    
    .tab_header, .tab_detail {
        width:100%;
    }
    
    .tab_detail th {
        text-align: center;
    }
    
    .tab_detail td, .tab_detail th {
        border: 1px solid black;
        padding: 2px;
    }
</style>

<?php
//if (isset($caraPrint)){
//    echo $this->renderPartial('application.views.headerReport.headerDefault', array('judulLaporan'=>$judulKuitansi));      
//}
echo $this->renderPartial('application.views.headerReport.headerAnggaran',array('judulLaporan'=>'Bukti Pembayaran Supplier', 'deskripsi'=>"", 'colspan'=>10));
?>


<?php
echo CHtml::css('.control-label{
        float:left; 
        text-align: right; 
        width:120px;
        color:black;
        padding-right:10px;
    }
    table{
        font-size:11px;
    }

    td .tengah{
       text-align: center;  
    }
');
?>
<br>
<table width="100%" style="margin: 0;" cellpadding="0" cellspacing="0">
    <tr>
        <td width="50%">
            <table width="100%" class="tab_header">
                <tr>
                    <td width="13%" style="text-align:right;">No Faktur</td><td width="2%">:</td>
                    <td width="35%">
                        <?php echo CHtml::encode($modTerimaPersediaan->nofaktur); ?>
                    </td>
                </tr> 
                <tr>
                    <td width="13%" style="text-align:right;">Tanggal Faktur</td><td width="2%">:</td>
                    <td width="35%">
                        <?php echo MyFormatter::formatDateTimeForUser($modTerimaPersediaan->tglfaktur); ?>
                    </td>
                </tr> 
                <tr>
                    <td width="13%" style="text-align:right;">Tanggal Jatuh Tempo</td><td width="2%">:</td>
                    <td width="35%">
                        <?php echo MyFormatter::formatDateTimeForUser($modTerimaPersediaan->tgljatuhtempo); ?>
                    </td>
                </tr> 
                <tr>
                    <td width="13%" style="text-align:right;">Umur Utang</td><td width="2%">:</td>
                    <td width="35%">
                        <?php echo CHtml::encode($modTerimaPersediaan->umurhutang); ?>
                    </td>
                </tr> 
                <tr>
                    <td width="13%" style="text-align:right;">Syarat Bayar</td><td width="2%">:</td>
                    <td width="35%">
                        <?php echo CHtml::encode($modTerimaPersediaan->syaratbayar_nama); ?>
                    </td>
                </tr> 
                <tr>
                    <td width="13%" style="text-align:right;">Keterangan Faktur</td><td width="2%">:</td>
                    <td width="35%">
                        <?php echo CHtml::encode($modTerimaPersediaan->keteranganfaktur); ?>
                    </td>
                </tr> 
                <tr>
                    <td width="13%" style="text-align:right;">Supplier</td><td width="2%">:</td>
                    <td width="35%">
                        <?php echo CHtml::encode($modTerimaPersediaan->supplier_nama); ?>
                    </td>
                </tr> 
                
            </table>  
        </td>
        <td valign="top">
            <table width="100%" class="tab_header">
                <tr>
                    <td width="13%" style="text-align:right;">Total Harga</td><td width="2%">:</td>
                    <td width="35%">
                        <?php echo number_format($modTerimaPersediaan->totalharga,2,",","."); ?>
                    </td>
                </tr> 
                <tr>
                    <td width="13%" style="text-align:right;">Total Keringanan</td><td width="2%">:</td>
                    <td width="35%">
                        <?php echo number_format($modTerimaPersediaan->discount,2,",","."); ?>
                    </td>
                </tr> 
                <tr>
                    <td width="13%" style="text-align:right;">Total PPN</td><td width="2%">:</td>
                    <td width="35%">
                        <?php echo number_format($modTerimaPersediaan->pajakppn,2,",","."); ?>
                    </td>
                </tr> 
                <tr>
                    <td width="13%" style="text-align:right;">Total PPh</td><td width="2%">:</td>
                    <td width="35%">
                        <?php echo number_format($modTerimaPersediaan->pajakpph,2,",","."); ?>
                    </td>
                </tr> 
                <tr>
                    <td width="13%" style="text-align:right;">Total Keseluruhan</td><td width="2%">:</td>
                    <td width="35%">
                        <?php echo number_format($modTerimaPersediaan->totalkeseluruhan,2,",","."); ?>
                    </td>
                </tr> 
            </table>
        </td>
    </tr>
</table><br>
<table width="100%" style='margin-left:auto; margin-right:auto;' class='tab_detail'>
	<thead>
            <tr>
                <th>Jenis Barang</th>
                <th>Nama Barang</th>
                <th>Jumlah Terima</th>
                <th>Harga Satuan</th>
                <th>Keringanan (Rp)</th>
                <th>PPN (Rp)</th>
                <th>PPh (Rp)</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $total = 0;
            foreach ($modDetailPersediaan as $i => $detail) {    
                $jmlQty = ($detail->hargasatuan * $detail->jmlterima);
                $jmlDiskon = round((($jmlQty * $detail->persendiscount)/100),2);
                $jmlPpn = round(((($jmlQty - $jmlDiskon) * $detail->persenppn)/100),2);
                $jmlPph = round(((($jmlQty - $jmlDiskon) * $detail->persenpph)/100),2);
                $totalAll = round(($jmlQty - $jmlDiskon + $jmlPpn - $jmlPph),2);

                $total += $totalAll;
            ?>
            <tr>
                <td>
                        <?php echo (isset($detail->barang->jenisbarangs)?$detail->barang->jenisbarangs->jenisbarang_nama:""); ?>
                </td>
                <td>
                        <?php echo $detail->barang->barang_nama; ?>
                </td>
                <td style = "text-align:right;">
                        <?php echo number_format($detail->jmlterima,2,",",".").' '.$detail->satuanbeli; ?>
                </td>
                <td style = "text-align:right;">
                        <?php echo number_format($detail->hargasatuan,2,",","."); ?>
                </td>
                <td style = "text-align:right;">
                        <?php echo number_format($jmlDiskon,2,",","."); ?>
                </td>
                <td style = "text-align:right;">
                        <?php echo number_format($jmlPpn,2,",","."); ?>
                </td>
                <td style = "text-align:right;">
                        <?php echo number_format($jmlPph,2,",","."); ?>
                </td>
                <td style = "text-align:right;">
                        <?php echo number_format($detail->hargabeli,2,",","."); ?>
                </td>
            </tr>
            <?php } ?>
            <?php foreach ($modDetailBahanMakan as $i => $detail) { 
                $jmlQty = ($detail->harganettobhn * $detail->qty_terima);
                $jmlDiskon = round((($jmlQty * $detail->persendiscount)/100),2);
                $jmlPpn = round(((($jmlQty - $jmlDiskon) * $detail->persenppn)/100),2);
                $jmlPph = round(((($jmlQty - $jmlDiskon) * $detail->persenpph)/100),2);
                $totalAll = round(($jmlQty - $jmlDiskon + $jmlPpn - $jmlPph),2);

                $total += $totalAll;
                ?>
                <td>
                            <?php echo $detail->bahanmakanan->kelbahanmakanan; ?>
                    </td>
                    <td>
                            <?php echo $detail->bahanmakanan->namabahanmakanan; ?>
                    </td>
                    <td style = "text-align:right;">
                            <?php echo number_format($detail->qty_terima,2,",",".").' '.$detail->satuanbahan; ?>
                    </td>
                    <td style = "text-align:right;">
                            <?php echo number_format($detail->harganettobhn,2,",","."); ?>
                    </td>
                    <td style = "text-align:right;">
                            <?php echo number_format($jmlDiskon,2,",","."); ?>
                    </td>
                    <td style = "text-align:right;">
                            <?php echo number_format($jmlPpn,2,",","."); ?>
                    </td>
                    <td style = "text-align:right;">
                            <?php echo number_format($jmlPph,2,",","."); ?>
                    </td>
                    <td style = "text-align:right;">
                            <?php echo number_format($detail->hargajualbhn,2,",","."); ?>
                    </td>
            </tr>
            <?php    
                } ?>
        </tbody>
</table><br>
<table style="width: 100%; border: none;">
    <tr>
        <td width="50%">
            <table style="width: 100%; border: none;">
                <tr>
                    <td width="13%" style="text-align:right;">No Kas Keluar</td><td width="2%">:</td>
                    <td width="35%">
                            <?php echo $modBuktiKeluar->nokaskeluar; ?>
                    </td>
                </tr> 
                <tr>
                    <td width="13%" style="text-align:right;">Tgl. Pembayaran</td><td width="2%">:</td>
                    <td width="35%">
                            <?php echo MyFormatter::formatDateTimeForUser($modelBayar->tglbayarkesupplier); ?>
                    </td>
                </tr> 
                <tr>
                    <td width="13%" style="text-align:right;">Tgl. Kas Keluar</td><td width="2%">:</td>
                    <td width="35%">
                            <?php echo MyFormatter::formatDateTimeForUser($modBuktiKeluar->tglkaskeluar); ?>
                    </td>
                </tr> 
                <tr>
                    <td width="13%" style="text-align:right;">Tanggal Jatuh Tempo</td><td width="2%">:</td>
                    <td width="35%">
                        <?php echo MyFormatter::formatDateTimeForUser($modelBayar->tgljatuhtempo); ?>
                    </td>
                </tr> 
                <tr>
                    <td width="13%" style="text-align:right;">Total Tagihan</td><td width="2%">:</td>
                    <td width="35%">
                            <?php echo number_format($modelBayar->totaltagihan,2,",","."); ?>
                    </td>
                </tr> 
                <tr>
                    <td width="13%" style="text-align:right;">Jumlah Pembayaran</td><td width="2%">:</td>
                    <td width="35%">
                            <?php echo number_format($modelBayar->jmldibayarkan,2,",","."); ?>
                    </td>
                </tr> 
                <tr>
                    <td width="13%" style="text-align:right;">Biaya Administrasi</td><td width="2%">:</td>
                    <td width="35%">
                            <?php echo number_format($modBuktiKeluar->biayaadministrasi,2,",","."); ?>
                    </td>
                </tr> 
                <tr>
                    <td width="13%" style="text-align:right;">Biaya Ongkos Kirim</td><td width="2%">:</td>
                    <td width="35%">
                            <?php echo number_format($modBuktiKeluar->biayaongkos_kirim,2,",","."); ?>
                    </td>
                </tr> 
                <tr>
                    <td width="13%" style="text-align:right;">Jumlah Kas Keluar</td><td width="2%">:</td>
                    <td width="35%">
                            <?php echo number_format($modBuktiKeluar->jmlkaskeluar,2,",","."); ?>
                    </td>
                </tr> 
            </table>
        </td>
        <td valign="top">
             <table style="width: 100%; border: none;">
                <tr>
                    <td width="13%" style="text-align:right;">Cara Pembayaran</td><td width="2%">:</td>
                    <td width="35%">
                            <?php echo isset($modBuktiKeluar->carabayarkeluar) ? $modBuktiKeluar->carabayarkeluar : ""; ?>
                    </td>
                </tr> 
                <?php if($modBuktiKeluar->carabayarkeluar == Params::CARAPEMBAYARAN_TRANSFER){ 
                    $bankNama = "";
                    $norek = "";
                    $atasNama = "";
                    
                    $bankmod = BankM::model()->findByPk($modBuktiKeluar->bank_id);
                        if(isset($bankmod)){
                            $bankNama = $bankmod->namabank;
                            $norek = $bankmod->norekening;
                            $atasNama = $bankmod->bank_atasnama;
                        }
                    ?>
                <tr>
                    <td width="13%" style="text-align:right;">Nama Bank Pengirim</td><td width="2%">:</td>
                    <td width="35%">
                            <?php echo $bankNama; ?>
                    </td>
                </tr> 
                <tr>
                    <td width="13%" style="text-align:right;">Dengan Rekening</td><td width="2%">:</td>
                    <td width="35%">
                            <?php echo $norek; ?>
                    </td>
                </tr> 
                <tr>
                    <td width="13%" style="text-align:right;">Atas Nama Rekening</td><td width="2%">:</td>
                    <td width="35%">
                        <?php echo $atasNama; ?>
                    </td>
                </tr> 
                <?php } ?> 
                <tr>
                    <td width="13%" style="text-align:right;">Nama Penerima</td><td width="2%">:</td>
                    <td width="35%">
                            <?php echo $modBuktiKeluar->namapenerima; ?>
                    </td>
                </tr> 
                <tr>
                    <td width="13%" style="text-align:right;">Alamat Penerima</td><td width="2%">:</td>
                    <td width="35%">
                            <?php echo $modBuktiKeluar->alamatpenerima; ?>
                    </td>
                </tr> 
                <tr>
                    <td width="13%" style="text-align:right;">Syarat Pembayaran</td><td width="2%">:</td>
                    <td width="35%">
                            <?php echo $modBuktiKeluar->untukpembayaran; ?>
                    </td>
                </tr> 
            </table>
        </td>
    </tr>
</table>
<br>
<?php
if (isset($_GET['frame'])){
    echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="entypo-print"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('PRINT')"));
   // echo CHtml::link(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('EXCEL')")); 
?>
    <script type='text/javascript'>
    /**
     * print
     */    
    function print(caraPrint){
        var terimapersediaan_id = '<?php echo $modelBayar->terimapersediaan_id; ?>';
        var terimabahanmakan_id = '<?php echo $modelBayar->terimabahanmakan_id; ?>';
        bayarkesupplier_id = '<?php echo isset($modBuktiKeluar->bayarkesupplier_id) ? $modBuktiKeluar->bayarkesupplier_id : ''; ?>';
        window.open('<?php echo $this->createUrl('print'); ?>&terimapersediaan_id='+terimapersediaan_id+'&terimabahanmakan_id='+terimabahanmakan_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
    }
    </script>
<?php
}