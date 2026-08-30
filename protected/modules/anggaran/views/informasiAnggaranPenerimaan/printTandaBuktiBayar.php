<?php 
echo $this->renderPartial('application.views.headerReport.headerAnggaran',array('judulLaporan'=>$judulLaporan, 'deskripsi'=>$deskripsi, 'colspan'=>10));
?>
<table class="table">
	<tr>
		<td>No. Kuitansi </td><td>:</td><td width="75%"><?php echo $modTandaBukti->nobuktibayar; ?></td>
	</tr>
	<tr>
		<td>No. Penerimaan </td><td>:</td><td><?php echo $model->norealisasianggpen; ?></td>
	</tr>
	<tr>
		<td>Sudah Terima Dari </td><td>:</td><td><?php echo $modTandaBukti->darinama_bkm." / ".$modPenerimaan->sumberanggaran->sumberanggarannama; ?></td>
	</tr>
	<tr>
		<td>Untuk Pembayaran </td><td>:</td><td><?php echo "Anggaran Periode (".$format->formatDateTimeForUser($modKonfig->tglanggaran)." - ".$format->formatDateTimeForUser($modKonfig->tglanggaran).")"; ?></td>
	</tr>
	<tr>
		<td>Termin Ke </td><td>:</td><td><?php echo $model->renanggaranpenerimaandet->renanggaran_ke; ?></td>
	</tr>
	<tr>
		<td></td><td></td><td><span style="border: 1px solid #000; padding: 5px; display: inline-block;">Rp <?php echo $model->realisasipenerimaan; ?></span></td>
	</tr>
</table>

<?php if (!empty($model->peg_mengetahui_id) && !empty($model->peg_menyetujui_id)){ ?>
	<table class="table">
		<tr>
			<th style="width:50%; text-align:center; padding-bottom: 50px;"></th>
			<th style="width:50%; text-align:center; padding-top: 50px;" colspan="2"><?php echo Yii::app()->user->getState("kabupaten_nama").", ".$format->formatDateTimeForUser(date('Y-m-d', strtotime($modTandaBukti->tglbuktibayar))); ?></th>
		</tr>
		<tr>
			<th style="width:50%; text-align:center; padding-bottom: 50px;"></th>
			<th style="width:50%; text-align:center; padding-bottom: 50px;">
				Mengetahui,
				<br><br><br><br><br><br>
				( <?php echo $model->mengetahui->nama_pegawai;?> )		
			</th>
		</tr>
	</table>
<?php } ?>