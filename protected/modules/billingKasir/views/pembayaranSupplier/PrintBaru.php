<?php
//Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/prinout.css');
?>

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
//if (!isset($_GET['frame'])){
    //echo $this->renderPartial($this->path_view.'_headerPrint'); 
//	echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksi',array('judulLaporan'=>$judul_print, 'periode'=>'', 'colspan'=>10)); 
//}
echo $this->renderPartial('application.views.headerReport.headerAnggaran',array('judulLaporan'=>'Bukti Pembayaran Supplier', 'deskripsi'=>"", 'colspan'=>10));
?>  

<br>
<table width="100%" class="tab_header">
		<tr>
			<td width="13%" style="text-align:right;">Tanggal Faktur</td><td width="2%">:</td>
			<td width="35%">
				<?php echo CHtml::encode(MyFormatter::formatDateTimeForUser($modFakturBeli->tglfaktur)); ?>
			</td>
			<td width="13%" style="text-align:right;">Tanggal Jatuh Tempo</td><td width="2%">:</td>
			<td width="35%">
				<?php echo CHtml::encode(MyFormatter::formatDateTimeForUser($modFakturBeli->tgljatuhtempo)); ?>
			</td>
		</tr>     
		<tr>
			<td width="13%" style="text-align:right;">Total Bruto</td><td width="2%">:</td>
			<td width="35%">
				<?php echo CHtml::encode(MyFormatter::formatNumberForPrint($modFakturBeli->totalhargabruto)); ?>
			</td>
			<td width="13%" style="text-align:right;">No. Faktur</td><td width="2%">:</td>
			<td width="35%">
				<?php echo CHtml::encode($modFakturBeli->nofaktur); ?>
			</td>
		</tr>   
		<tr>
			<td width="13%" style="text-align:right;">Supplier</td><td width="2%">:</td>
			<td width="35%">
				<?php echo CHtml::encode($modFakturBeli->supplier->supplier_nama); ?>
			</td>
			<td width="13%" style="text-align:right;">Keterangan</td><td width="2%">:</td>
			<td width="35%">
				<?php echo CHtml::encode($modFakturBeli->keteranganfaktur); ?>
			</td>
		</tr>   
		<tr>
			<td width="13%" style="text-align:right;">No. Penerima</td><td width="2%">:</td>
			<td width="35%">
				<?php echo CHtml::encode($modFakturBeli->penerimaanbarang->noterima); ?>
			</td>
			<td width="13%" style="text-align:right;">No. PO</td><td width="2%">:</td>
			<td width="35%">
				<?php echo CHtml::encode(isset($modFakturBeli->penerimaanbarang->permintaanpembelian->nopermintaan)?$modFakturBeli->penerimaanbarang->permintaanpembelian->nopermintaan:'-'); ?>
			</td>
		</tr>   
</table>            
      <br>
<table width="100%" style='margin-left:auto; margin-right:auto;' class='tab_detail'>
	<thead>
			<tr>
				<th>No.</th>
                <th>Nama Obat dan Alkes</th>
                <th>Jml Terima</th>
                <th>Harga Netto</th>
                <th hidden>Harga PPN</th>
                <th hidden>Harga PPh</th>
                <th hidden>Keringanan %</th>
				<th>Keringanan Rp</th>
				<th>PPN</th>
                                <th>PPh</th>
				<th>HPP</th>                
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php echo $this->renderPartial($this->path_view.'_rowFaktur', array('modDetailBeli'=>$modDetailBeli)); ?>
        </tbody>
</table><br>

<table width="100%" class="">
	<tr>
		<td width="13%" style="text-align:right;">Tanggal Pembayaran</td><td width="2%">:</td>
		<td width="35%">
			<?php echo CHtml::encode(MyFormatter::formatDateTimeForUser($modelBayar->tglbayarkesupplier)); ?>
		</td>
		<td width="13%" style="text-align:right;">Jenis Penjamin</td><td width="2%">:</td>
		<td width="35%">
			<?php echo CHtml::encode($modBuktiKeluar->carabayarkeluar); ?>
		</td>
	</tr>     
	<tr>
		<td width="13%" style="text-align:right;">Total Tagihan</td><td width="2%">:</td>
		<td width="35%">
			<?php echo CHtml::encode(MyFormatter::formatNumberForPrint($modelBayar->totaltagihan)); ?>
		</td>
		<td width="13%" style="text-align:right;">Penerima</td><td width="2%">:</td>
		<td width="35%">
			<?php echo CHtml::encode($modBuktiKeluar->namapenerima); ?>
		</td>
	</tr>     
	<tr>
		<td width="13%" style="text-align:right;">Uang Muka</td><td width="2%">:</td>
		<td width="35%">
			<?php echo CHtml::encode(isset($modUangMuka->jumlahuang)?MyFormatter::formatNumberForPrint($modUangMuka->jumlahuang) : "0"); ?>
		</td>
		<td width="13%" style="text-align:right; vertical-align: top;" rowspan="2">Alamat Penerima</td><td width="2%"  style="vertical-align: top;" rowspan="2">:</td>
		<td width="35%"rowspan="2" style="vertical-align: top;">
			<?php echo CHtml::encode($modBuktiKeluar->alamatpenerima); ?>
		</td>
	</tr>     
	<tr>
		<td width="13%" style="text-align:right;">Jumlah Dibayarkan</td><td width="2%">:</td>
		<td width="35%">
			<?php echo CHtml::encode(MyFormatter::formatNumberForPrint($modelBayar->jmldibayarkan)); ?>
		</td>
	</tr> 
	<tr>
		<td width="13%" style="text-align:right;">Tanggal Kas Keluar</td><td width="2%">:</td>
		<td width="35%">
			<?php echo CHtml::encode(MyFormatter::formatDateTimeForUser($modBuktiKeluar->tglkaskeluar)); ?>
		</td>
		<td width="13%" style="text-align:right;">Untuk Pembayaran</td><td width="2%">:</td>
		<td width="35%">
			<?php echo CHtml::encode($modBuktiKeluar->untukpembayaran); ?>
		</td>
	</tr>      
	<tr>
		<td width="13%" style="text-align:right;">No. Kas Keluar</td><td width="2%">:</td>
		<td width="35%">
			<?php echo CHtml::encode($modBuktiKeluar->nokaskeluar); ?>
		</td>
	</tr>      
	<tr>
		<td width="13%" style="text-align:right;">Biaya Administrasi</td><td width="2%">:</td>
		<td width="35%">
			<?php echo CHtml::encode(MyFormatter::formatNumberForPrint($modBuktiKeluar->biayaadministrasi)); ?>
		</td>
	</tr> 
        <tr>
		<td width="13%" style="text-align:right;">Biaya Ongkos Kirim</td><td width="2%">:</td>
		<td width="35%">
			<?php echo CHtml::encode(MyFormatter::formatNumberForPrint($modBuktiKeluar->biayaongkos_kirim)); ?>
		</td>
	</tr> 
	<tr>
		<td width="13%" style="text-align:right;">Jumlah Kas Keluar</td><td width="2%">:</td>
		<td width="35%">
			<?php echo CHtml::encode(MyFormatter::formatNumberForPrint($modBuktiKeluar->jmlkaskeluar)); ?>
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
        bayarkesupplier_id = '<?php echo isset($modBuktiKeluar->bayarkesupplier_id) ? $modBuktiKeluar->bayarkesupplier_id : ''; ?>';
        window.open('<?php echo $this->createUrl('print'); ?>&id='+bayarkesupplier_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
    }
    </script>
<?php
}