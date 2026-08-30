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
echo "No. Rencana : <b>".$model->norenpengembalian."</b>";
?>
<table class="table">
	<thead>
		<tr style="border:1px solid;">
			<<th>No.</th>
			<th>Nama Obat</th>
			<th>Supplier</th>
			<th>Satuan Kecil</th>
			<th>Jumlah</th>
			<th>Tanggal Kedaluwarsa</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		foreach($modDetails as $i => $modDetail){
		?>
		<tr>
			<td><?php echo $i+1; echo ". "; ?></td>
			<td><?php echo $modDetail->obatalkes_nama; ?></td>
			<td><?php echo $modDetail->supplier_nama; ?></td>
			<td><?php echo $modDetail->satuankecil_nama; ?></td>
			<td><?php echo $modDetail->qty_renpenged; ?></td>
			<td><?php echo $format->formatDateTimeForUser($modDetail->tglkadaluarsa_renpeng); ?></td>
		</tr>
		<?php } ?>
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
