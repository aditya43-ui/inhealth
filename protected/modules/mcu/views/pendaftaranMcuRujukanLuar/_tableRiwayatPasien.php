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
					<?php echo isset($data->tgl_pendaftaran) ? MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran) : ""; ?>
				</td>
				<td>
					<?php echo isset($data->no_pendaftaran) ? $data->no_pendaftaran : ""; ?>
				</td>
				<td>
					<?php echo isset($data->instalasi_nama) ? $data->instalasi_nama : ""; ?>
				</td>
				<td>
					<?php echo isset($data->ruangan_nama) ? $data->ruangan_nama : ""; ?>
				</td>
				<td>
					<?php echo isset($data->pegawai_id) ? $data->gelardepan . " " . $data->nama_pegawai . ", " . $data->gelarbelakang_nama : ""; ?>
				</td>
				<td>
					<?php echo isset($data->carabayar_nama) ? $data->carabayar_nama : ""; ?>
				</td>
				<td>
					<?php echo isset($data->penjamin_nama) ? $data->penjamin_nama : ""; ?>
				</td>
			</tr>
			<?php
			}
			?>
		</tbody>
	</table>
</div>
