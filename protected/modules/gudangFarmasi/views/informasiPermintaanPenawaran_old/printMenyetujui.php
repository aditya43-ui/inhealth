<?php 
$table = 'ext.bootstrap.widgets.BootGridView';
$template = "{summary}\n{items}\n{pager}";
if (isset($caraPrint)){
	$template = "{items}";
	if($caraPrint=='EXCEL'){
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
		header('Cache-Control: max-age=0');   
		$table = 'ext.bootstrap.widgets.BootExcelGridView';
	}
}

echo $this->renderPartial('application.views.headerReport.headerAnggaran',array('judulLaporan'=>$judulLaporan, 'deskripsi'=>$deskripsi, 'colspan'=>10));
?>
<br>
<table style="width: 100%; border: none;">
	<tr>
		<td width="20%">No. Permintaan</td>
		<td width="70%">: <?php echo $model->nosuratpenawaran ?></td>
	</tr>
	<tr>
		<td>Tanggal Penawaran</td>
		<td>: <?php echo MyFormatter::formatDateTimeId($model->tglpenawaran) ?></td>
	</tr>
	<tr>
		<td>Status Penawaran</td>
		<td>: <?php echo $model->statuspenawaran ?></td>
	</tr>
	<tr>
		<td colspan="2"> <i>Merupakan penawaran <?php echo ($model->ispenawaranmasuk == TRUE)?"Masuk":"Keluar" ?> dari Supplier </i><b><?php echo $model->supplier_nama ?></b></td>
	</tr>
</table>
<table class="items table table-striped table-condensed" id="table-rencanaanggaranpenerimaan">
	<thead>
		<tr>
			<th>No.</th>
			<th>Asal Barang</th>
			<th>Kategori / Nama Obat</th>
			<th>Jumlah Kemasan (Satuan)</th>
			<th>Jumlah Permintaan</th>
			<th>Harga Netto</th>
			<th>Stok Akhir</th>
			<th>Minimal Stok</th>
			<th>Sub Total</th>
			
		</tr>
	</thead>
	<tbody>
		<?php 
		$total = 0;
        $subtotal = 0;
		foreach($modDetails as $i => $modDetail){
		?>
		<tr>
			<td><?php echo $i+1; echo ". "; ?></td>
			<td><?php echo $modDetail->sumberdana->sumberdana_nama; ?></td>
			<td><?php echo (!empty($modDetail->obatalkes->obatalkes_kategori) ? $modDetail->obatalkes->obatalkes_kategori."/ " : "") . $modDetail->obatalkes->obatalkes_nama; ?></td>
			<td style="text-align: center;"><?php echo $modDetail->kemasanbesar; ?></td>
			<td style="text-align: center;"><?php echo $modDetail->qty; ?></td>
			<td><?php echo $format->formatUang($modDetail->harganetto); ?></td>
			<td style="text-align: center;"><?php
			$modDetail->stokakhir = StokobatalkesT::getJumlahStok($modDetail->obatalkes_id, Yii::app()->user->getState('ruangan_id'));
			echo $modDetail->stokakhir; ?></td>
			<td style="text-align: center;"><?php echo $modDetail->minimalstok; ?></td>
			<td><?php 
				$subtotal = ($modDetail->harganetto * $modDetail->qty);
				$total += $subtotal;
				echo $format->formatUang($subtotal); ?>
			</td>
		</tr>
		<?php } ?>
		<tfoot>
			<tr>
				<td colspan="3" style="text-align:right;">Total</td>
				<td>
					<?php echo $format->formatNumberForUser($total) ?>
				</td>
			</tr>
		</tfoot>
	</tbody>
</table>
<table class="table">
	<tr>
		<th style="width:50%; text-align:center; padding-bottom: 50px;" colspan="2">&nbsp;</th>
		<th style="width:50%; text-align:center; padding-bottom: 50px;">
		<?php 
		if(isset($model->tglmenyetujui)){ ?>
			Menyetujui,
			<br><br><br><br><br><br>
			( <?php echo $model->PegawaimenyetujuiLengkap;?> )
		<?php } ?>
		</th>
	</tr>
</table>
