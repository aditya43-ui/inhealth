<?php 
echo $this->renderPartial('application.views.headerReport.headerAnggaran',array('judulLaporan'=>$judulLaporan, 'deskripsi'=>$deskripsi, 'colspan'=>10));
?>
<table class="table">
	<tr>
		<td>No. Kuitansi </td><td>:</td><td width="75%"><?php echo $modTandaBukti->nokaskeluar; ?></td>
	</tr>
	<tr>
		<td>No. Pengeluaran </td><td>:</td><td><?php echo $model->no_realisasi_peng; ?></td>
	</tr>
	<tr>
		<td>Sudah Terima Dari </td><td>:</td><td><?php echo $modTandaBukti->namapenerima." / ".$model->sumberanggaran->sumberanggarannama; ?></td>
	</tr>
	<tr>
		<td>Untuk Pembayaran </td><td>:</td><td><?php echo "Anggaran Periode (".$format->formatDateTimeForUser($modKonfig->tglanggaran)." - ".$format->formatDateTimeForUser($modKonfig->tglanggaran).")"; ?></td>
	</tr>
	<tr>
		<td></td><td></td><td><span style="border: 1px solid #000; padding: 5px; display: inline-block;"> Rp <?php echo $format->formatNumberForUser($model->nilaialokasi_pengeluaran); ?></span></td>
	</tr>
</table>

	<table class="table">
		<tr>
			<th style="width:50%; text-align:center; padding-bottom: 50px;"></th>
			<th style="width:50%; text-align:center; padding-top: 50px;" colspan="2">Bontang, <?php echo $format->formatDateTimeForUser(date("Y-m-d", strtotime($modTandaBukti->tglkaskeluar))); ?></th>
		</tr>
		
<?php if (!empty($model->realisasimengetahui_id) && !empty($model->realisasimenyetujui_id)){ ?>
		<tr>
			<th style="width:50%; text-align:center; padding-bottom: 50px;"></th>
			<th style="width:50%; text-align:center; padding-bottom: 50px;">
				Mengetahui,
				<br><br><br><br><br><br>
				( <?php echo $model->mengetahui->nama_pegawai;?> )		
			</th>
		</tr>
<?php } ?>
	</table>