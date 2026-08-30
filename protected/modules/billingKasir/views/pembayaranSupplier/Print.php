<?php
if (isset($caraPrint)){
    echo $this->renderPartial('application.views.headerReport.headerDefault', array('judulLaporan'=>$judulKuitansi));      
}
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
<table width="100%" style="margin: 0;" cellpadding="0" cellspacing="0">
    <tr>
        <td>
		<legend class="rim2">Data Faktur</legend>
            <table style="width: 100%; border: none;">
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
        </td>
    </tr>
</table><br>
<table width="100%" style='margin-left:auto; margin-right:auto;' class='table table-striped table-bordered table-condensed'>
	<thead>
            <tr>
                <th>Nama Obat Alkes</th>
                <th>Jml Terima</th>
                <th>Harga Netto</th>
                <th>Harga PPN</th>
                <th>Harga PPh</th>
                <th>% Keringanan</th>
                <th>Jml Keringanan</th>
                <th>Harga Satuan</th>
                <th>Total Harga</th>
            </tr>
        </thead>
        <tbody>
            <?php echo $this->renderPartial($this->path_view.'_rowFaktur', array('modDetailBeli'=>$modDetailBeli)); ?>
        </tbody>
</table><br>
<table style="width: 100%; border: none;">
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
		<td width="13%" style="text-align:right;">Jumlah Kas Keluar</td><td width="2%">:</td>
		<td width="35%">
			<?php echo CHtml::encode(MyFormatter::formatNumberForPrint($modBuktiKeluar->jmlkaskeluar)); ?>
		</td>
	</tr>      
</table>
