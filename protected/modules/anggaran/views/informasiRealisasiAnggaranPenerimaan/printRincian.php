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
 
 
echo "No. : <b>".$models[0]->norealisasianggpen."</b>";
echo "<br>Sumber Anggaran : <b>".$models[0]->sumberanggaran->sumberanggarannama."</b>";
?>
<table class="table">
	<thead>
		<tr style="border:1px solid;">
			<th>No.</th>
			<th>Termin ke-</th>
			<th>Tanggal Realisasi Penerimaan</th>
			<th>Nilai Anggaran</th>
			<th>Nilai Realisasi</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$total_nilai = 0;
		$total_realisasi = 0;
		foreach($models as $i => $modDetail){
		?>
		<tr>
				<td style="font-weight: normal;"><?php echo $i+1; echo ". "; ?></td>
				<td style="font-weight: normal; text-align: right;"><?php echo $modDetail->penerimaanke; ?></td>
				<td style="font-weight: normal;"><?php echo $format->formatDateTimeId($modDetail->tglrealisasianggpen); ?></td>
				<td style="font-weight: normal; text-align: right;"><?php echo $format->formatUang($modDetail->nilaipenerimaan); ?></td>
				<td style="font-weight: normal; text-align: right;"><?php echo $format->formatUang($modDetail->realisasipenerimaan); ?></td>
				<?php
				$total_nilai += $modDetail->nilaipenerimaan;
				$total_realisasi += $modDetail->realisasipenerimaan;
				?>
		</tr>
		<?php } ?>
			<tr style="border:1px solid;">
				<td colspan="3" style="text-align:right;font-weight: normal; font-style: italic;">Total Anggaran</td>
				<td style="font-weight: normal; font-style: italic; text-align: right;">
					<b><?php echo $format->formatUang($total_nilai) ?></b>
				</td>
				<td style="font-weight: normal;  text-align: right; font-style: italic;">
					<b><?php echo $format->formatUang($total_realisasi) ?></b>
				</td>
			</tr>
	</tbody>
</table>

<?php // if (!empty($models[0]->renpen_tglmengetahui) && !empty($models[0]->renpen_tglmenyetujui)){ ?>
<!--	<div class="row">
		<div class="col-sm-6" style="text-align:center;">
			<div class='control-group' style='margin-bottom: 57.5px;margin-top: 10px;'>
				 Mengetahui,
			</div>	
			<div class="control-group">-->
				<!--( <?php // echo $models[0]->mengetahui->nama_pegawai;?> )-->
<!--			</div>	
		</div>
		<div class="col-sm-6" style="text-align:center;">
			<div class="control-group" style="margin-bottom: 57.5px;margin-top: 10px;">
				Menyetujui,
			</div>
			<div class="control-group">-->
				<!--( <?php // echo $models[0]->menyetujui->nama_pegawai;?> )-->
<!--			</div>
		</div>
	</div>-->
<?php // } ?>