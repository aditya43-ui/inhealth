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
 
 
echo "NO : <b>".$modPenerimaan->noren_penerimaan."</b>";
echo "<br>Sumber Anggaran : <b>".$modPenerimaan->sumberanggaran->sumberanggarannama."</b>";
?>
<table class="table">
	<thead>
		<tr style="border:1px solid;">
			<th>No.</th>
			<th>Termin ke-</th>
			<th>Tanggal Penerimaan</th>
			<th>Nilai Anggaran</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		foreach($modDetails as $i => $modDetail){
		?>
		<tr>
				<td style="font-weight: normal;"><?php echo $i+1; echo ". "; ?></td>
				<td style="font-weight: normal; text-align: right;"><?php echo $modDetail->renanggaran_ke; ?></td>
                                <td style="font-weight: normal;"><?php echo MyFormatter::formatDateTimeForUser($modDetail->tglrenanggaranpen); ?></td>
				<td style="font-weight: normal; text-align: right;"><?php echo $format->formatNumberForPrint($modDetail->nilaipenerimaan); ?></td>
		</tr>
		<?php } ?>
			<tr style="border:1px solid;">
				<td colspan="3" style="text-align:right;font-weight: normal; font-style: italic;">Total Anggaran</td>
				<td style="font-weight: normal; font-style: italic; text-align: right;">
					<?php echo $format->formatNumberForPrint($modPenerimaan->total_renanggaranpen) ?>
				</td>
			</tr>
	</tbody>
</table>

<?php if (!empty($modPenerimaan->renpen_tglmengetahui) && !empty($modPenerimaan->renpen_tglmenyetujui)){ ?>
	<table class="table">
		<tr>
			<th style="width:50%; text-align:center; padding-bottom: 50px;" colspan="2">
				Mengetahui,
				<br><br><br><br><br><br>
				( <?php echo $modPenerimaan->mengetahui->nama_pegawai;?> )		
			</th>
			<th style="width:50%; text-align:center; padding-bottom: 50px;" colspan="2">
				Menyetujui,
				<br><br><br><br><br><br>
				( <?php echo $modPenerimaan->menyetujui->nama_pegawai;?> )
			</th>
		</tr>
	</table>
<?php } ?>