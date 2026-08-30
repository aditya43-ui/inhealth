<table class="table table-striped table-bordered table-condensed">
	<thead>
		<tr>
			<th>Ruangan Asal</th>
			<th>Tanggal Konsultasi</th>
			<th>Kategori Konsultasi</th>
			<th>Konsultasi Gizi</th>
			<th>Jumlah</th>
		</tr>
	</thead>
	<tbody>
	<?php 
		$format = new MyFormatter();
		if(count((array)$modTindakanSearch->detailRiwayatKonsul($modPendaftaran->pendaftaran_id)) > 0){
		foreach ($modTindakanSearch->detailRiwayatKonsul($modPendaftaran->pendaftaran_id) as $i => $value){ ?>
		
			<tr>
				<td><?php echo $value->ruangan_nama ?></td>
				<td><?php echo $format->formatDateTimeForUser($value->tgl_tindakan); ?></td>
				<td><?php echo $value->kategoritindakan_nama; ?></td>
				<td><?php echo $value->daftartindakan_nama; ?></td>
				<td><?php echo $value->qty_tindakan; ?></td>
			</tr>
	<?php } 
		}else{
	?>
			<tr>
				<td colspan="5"><i>Data tidak ditemukan</i></td>
			</tr>
	<?php } ?>
	</tbody>
</table>