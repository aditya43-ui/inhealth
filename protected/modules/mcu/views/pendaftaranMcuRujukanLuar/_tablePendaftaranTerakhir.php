<?php 
if(isset($modPasien->pasien_id)){
	$riwayat = MCPendaftaranT::model()->searchRiwayatPasien($modPasien->pasien_id);
}else{
	$riwayat = array();
}
?>
<div class="">
    <table class="table table-condensed table-bordered table-striped">
		<thead>
			<tr>
				<th>Tanggal Pendaftaran</th>
				<th>No. Pendaftaran</th>
				<th>Instalasi</th>
				<th>Poliklinik/Ruangan</th>
				<th>Dokter</th>
				<th>Jenis Penjamin</th>
				<th>Penjamin</th>
			</tr>
		</thead>
		<tbody>
			<?php 
			foreach($riwayat as $i => $data){
				?>
			<tr>
				<td>
					<?php echo MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran); ?>
				</td>
				<td>
					<?php echo $data->no_pendaftaran; ?>
				</td>
				<td>
					<?php echo $data->instalasi_nama; ?>
				</td>
				<td>
					<?php echo $data->ruangan_nama; ?>
				</td>
				<td>
					<?php echo $data->gelardepan . " " . $data->nama_pegawai . ", " . $data->gelarbelakang_nama; ?>
				</td>
				<td>
					<?php echo $data->carabayar_nama; ?>
				</td>
				<td>
					<?php echo $data->penjamin_nama; ?>
				</td>
			</tr>
			<?php
			}
			?>
		</tbody>
	</table>
</div>
