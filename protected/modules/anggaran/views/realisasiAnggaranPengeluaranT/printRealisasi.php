<?php 
echo $this->renderPartial('application.views.headerReport.headerAnggaran',array('judulLaporan'=>$judulLaporan, 'deskripsi'=>$deskripsi, 'colspan'=>10));
?>
<table class="table">
	<tr>
		<td>No. Pengeluaran </td><td>:</td><td width="75%"><?php echo $model->no_realisasi_peng; ?></td>
	</tr>
	<tr>
		<td>Tanggal Bukti Keluar </td><td>:</td><td><?php echo MyFormatter::formatDateTimeForUser($modTandaBukti->tglkaskeluar); ?></td>
	</tr>
	<tr>
		<td>Sumber Anggaran </td><td>:</td><td><?php echo $model->sumberanggaran->sumberanggarannama; ?></td>
	</tr>
	<tr>
		<td>Nilai Alokasi </td><td>:</td><td>Rp <?php echo $format->formatNumberForPrint($model->nilaialokasi_pengeluaran); ?></td>
	</tr>
	<tr>
		<td>Nilai Realisasi </td><td>:</td><td>Rp <?php echo $format->formatNumberForPrint($model->nilairealisasi_pengeluaran); ?></td>
	</tr>
	<tr>
		<td>Penerima </td><td>:</td><td><?php echo $modTandaBukti->namapenerima; ?></td>
	</tr>
</table>

<?php if (!empty($model->realisasimengetahui_id)){ ?>
	<table class="table">
		<tr>
			<th style="width:50%; text-align:center; padding-bottom: 50px;"></th>
			<th style="width:50%; text-align:center; padding-top: 50px;" colspan="2">Bontang, <?php echo $format->formatDateTimeForUser(date("Y-m-d")); ?></th>
		</tr>
		<tr>
			<th style="width:50%; text-align:center; padding-bottom: 50px;">
			</th>
			<th style="width:50%; text-align:center; padding-bottom: 50px;">
				Mengetahui,
				<br><br><br><br><br><br>
				( <?php echo $model->mengetahui->nama_pegawai;?> )		
			</th>
		</tr>
	</table>
<?php }else if (!empty($model->realisasimenyetujui_id)) { ?>
	<table class="table">
		<tr>
			<th style="width:50%; text-align:center; padding-bottom: 50px;"></th>
			<th style="width:50%; text-align:center; padding-top: 50px;" colspan="2">Bontang, <?php echo $format->formatDateTimeForUser(date("Y-m-d")); ?></th>
		</tr>
		<tr>
			<th style="width:50%; text-align:center; padding-bottom: 50px;">	
			</th>
			<th style="width:50%; text-align:center; padding-bottom: 50px;">
				Menyetujui,
				<br><br><br><br><br><br>
				( <?php echo $model->menyetujui->nama_pegawai;?> )
			</th>
		</tr>
	</table>
<?php }else{ ?>
	<table class="table">
		<tr>
			<th style="width:50%; text-align:center; padding-bottom: 50px;"></th>
			<th style="width:50%; text-align:center; padding-top: 50px;" colspan="2">Bontang, <?php echo $format->formatDateTimeForUser(date("Y-m-d")); ?></th>
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

