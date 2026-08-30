<style>
	.spasi1 {
		margin: 0 0px 0px 10px;
	}

	.spasi2 {
		padding: 0 0px 0px 20px;
	}
	.table-alergi, th {
		border: 1px solid black;
	}
</style>
<div class="white-container">
	<?php
	// if ($caraPrint == 'EXCEL') {
	// 	header('Content-Type: application/vnd.ms-excel');
	// 	header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
	// 	header('Cache-Control: max-age=0');
	// }
	echo $this->renderPartial('application.views.headerReport.headerDefault', array('colspan' => 7));
	$no_urut = 1;
	$class='';
	if (isset($_GET['frame'])) {
		$class="table table-striped";
	}
	?>
	<table width="100%" class="spasi1">
		<tr>
			<td width="20%">Nama</td>
			<td width="30%">: <?php echo (isset($modPasien->nama_pasien) ? $modPasien->nama_pasien : " - "); ?></td>
			<td width="20%">No. Rekam Medis</td>
			<td width="30%">: <?php echo isset($modPasien->no_rekam_medik) ? $modPasien->no_rekam_medik : " - "; ?></td>
		</tr>
		<tr>
			<td width="20%">Umur</td>
			<td width="30%">: <?php echo (isset($modPendaftaran->umur) ? $modPendaftaran->umur : " - "); ?></td>
			<td width="20%">Ruangan</td>
			<td width="30%">: <?php echo isset($modPendaftaran->ruangan->ruangan_nama) ? $modPendaftaran->ruangan->ruangan_nama : " - "; ?></td>
		</tr>
		<tr>
			<td width="20%">Tgl. Masuk RS</td>
			<td width="30%">: <?php echo isset($modPendaftaran->tgl_pendaftaran) ? date('d-m-Y', strtotime($modPendaftaran->tgl_pendaftaran)) : " - "; ?></td>
			<td width="20%">Jam</td>
			<td width="30%">: <?php echo isset($modPendaftaran->tgl_pendaftaran) ? date('H:i:s', strtotime($modPendaftaran->tgl_pendaftaran)) : " - "; ?></td>
		</tr>
	</table>