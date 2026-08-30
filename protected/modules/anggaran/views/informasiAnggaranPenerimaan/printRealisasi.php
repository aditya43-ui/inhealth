<?php 
echo $this->renderPartial('application.views.headerReport.headerAnggaran',array('judulLaporan'=>$judulLaporan, 'deskripsi'=>$deskripsi, 'colspan'=>10));
?>
<table class="table">
	<tr>
		<td>No. Penerimaan </td><td>:</td><td width="75%"><?php echo $model->norealisasianggpen; ?></td>
	</tr>
	<tr>
            <td>Tanggal Bukti Bayar </td><td>:</td><td><?php echo MyFormatter::formatDateTimeForUser(date('Y-m-d', strtotime($modTandaBukti->tglbuktibayar))); ?></td>
	</tr>
	<tr>
		<td>Sumber Anggaran </td><td>:</td><td><?php echo $modPenerimaan->sumberanggaran->sumberanggarannama; ?></td>
	</tr>
	<tr>
		<td>Termin Ke </td><td>:</td><td><?php echo $model->renanggaranpenerimaandet->renanggaran_ke; ?></td>
	</tr>
	<tr>
		<td>Nilai Rencana Penerimaan </td><td>:</td><td>Rp <?php echo $model->nilaipenerimaan; ?></td>
	</tr>
	<tr>
		<td>Nilai Realisasi Penerimaan </td><td>:</td><td>Rp <?php echo $model->realisasipenerimaan; ?></td>
	</tr>
	<tr>
		<td>Pembayar </td><td>:</td><td><?php echo $modTandaBukti->darinama_bkm; ?></td>
	</tr>
</table>

<?php if (!empty($model->peg_mengetahui_id) && !empty($model->peg_menyetujui_id)){ ?>
	<table class="table">
		<tr>
			<th style="width:50%; text-align:center; padding-bottom: 50px;"></th>
			<th style="width:50%; text-align:center; padding-top: 50px;" colspan="2"><?php echo Yii::app()->user->getState("kabupaten_nama").", ".$format->formatDateTimeForUser(date("Y-m-d")); ?></th>
		</tr>
		<tr>
			<th style="width:50%; text-align:center; padding-bottom: 50px;">
				Mengetahui,
				<br><br><br><br><br><br>
				( <?php echo $model->mengetahui->nama_pegawai;?> )		
			</th>
			<th style="width:50%; text-align:center; padding-bottom: 50px;">
				Menyetujui,
				<br><br><br><br><br><br>
				( <?php echo $model->menyetujui->nama_pegawai;?> )
			</th>
		</tr>
	</table>
<?php } ?>