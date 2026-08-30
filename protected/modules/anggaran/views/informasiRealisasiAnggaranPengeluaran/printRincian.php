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
 
$format = new MyFormatter();
echo "Unit Kerja. : <b>".$models[0]->unitkerja->namaunitkerja."</b>";
?>
<table class="table">
	<thead>
		<tr style="border:1px solid;">
			<th>No.</th>
			<th>No. Realisasi Pengeluaran</th>
			<th>Program Kerja</th>
			<th>Tanggal Realisasi</th>
			<th>Nilai Alokasi</th>
			<th>Sumber Anggaran</th>
			<th>Nilai Realisasi</th>
			<th><p style="margin: 0; text-align: center;">%</p></th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$total_alokasi = 0;
		$total_realisasi = 0;
		foreach($models as $i => $modDetail){
		?>
		<tr>
			<td><?php echo $i+1; echo ". "; ?></td>
			<td><?php echo $modDetail->no_realisasi_peng; ?></td>
			<td><?php echo $modDetail->subkegiatanprogram->subkegiatanprogram_nama; ?></td>
			<td><?php echo $format->formatDateTimeId($modDetail->tglrealisasianggaran); ?></td>
			<td><?php echo isset($modDetail->nilaialokasi_pengeluaran)?$format->formatUang($modDetail->nilaialokasi_pengeluaran):0; ?></td>
			<td><?php echo $modDetail->sumberanggaran->sumberanggarannama; ?></td>
			<td><?php echo isset($modDetail->nilairealisasi_pengeluaran)?$format->formatUang($modDetail->nilairealisasi_pengeluaran):0; ?></td>
			<td><?php echo $modDetail->persentase_realisasi; ?></td>
			<?php
			$total_alokasi += $modDetail->nilaialokasi_pengeluaran;
			$total_realisasi += $modDetail->nilairealisasi_pengeluaran;
			?>
		</tr>
		<?php } ?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="4" style="text-align:right;"><b>Total</b></td>
			<td>
				<b><?php echo $format->formatUang($total_alokasi) ?></b>
			</td>
			<td></td>
			<td>
				<b><?php echo $format->formatUang($total_realisasi) ?></b>
			</td>
		</tr>
	</tfoot>
</table>

<?php if (!empty($models[0]->realisasimengetahui_id) && !empty($models[0]->realisasimenyetujui_id)){ ?>
	<div class="row">
		<div class="col-sm-6" style="text-align:center;">
			<div class='control-group' style='margin-bottom: 57.5px;margin-top: 10px;'>
				 Mengetahui,
			</div>	
			<div class="control-group">
				( <?php echo $models[0]->mengetahui->nama_pegawai;?> )
			</div>	
		</div>
		<div class="col-sm-6" style="text-align:center;">
			<div class="control-group" style="margin-bottom: 57.5px;margin-top: 10px;">
				Menyetujui,
			</div>
			<div class="control-group">
				( <?php echo $models[0]->menyetujui->nama_pegawai;?> )
			</div>
		</div>
	</div>
<?php } ?>