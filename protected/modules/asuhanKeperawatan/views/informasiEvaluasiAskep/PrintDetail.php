<style>
	.spasi1 {
		margin: 0 0px 0px 10px;
	}

	.spasi2 {
		padding: 0 0px 0px 20px;
	}

</style>
<div class="white-container">
	<?php
	if ($caraPrint == 'EXCEL') {
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
		header('Cache-Control: max-age=0');
	}
	    echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksiNew', array('judulLaporan' => $judulLaporan, 'colspan' => 7));
	$no_urut = 1;
	$class='';
	if (isset($_GET['frame'])) {
		$class="table table-striped";
	}
	?>
    <table width="100%" class="spasi1">
		<tr>
			<td width="10%">Nama</td>
			<td width="40%">: <?php echo (isset($modPasien->nama_pasien) ? $modPasien->nama_pasien : " - "); ?></td>
			<td width="10%">No. RM</td>
			<td width="40%">: <?php echo isset($modPasien->no_rekam_medik) ? $modPasien->no_rekam_medik : " - "; ?></td>
		</tr>
		<tr>
			<td width="10%">Umur</td>
			<td width="40%">: <?php echo (isset($modPendaftaran->umur) ? $modPendaftaran->umur : " - "); ?></td>
			<td width="10%">Kamar / Kelas</td>
			<td width="40%">: <?php echo (isset($model->kamarruangan_nokamar) ? $model->kamarruangan_nokamar : $model->getNoKamar($modPendaftaran->pendaftaran_id) ) . ' / ' . (isset($model->kelaspelayanan_nama) ? $model->kelaspelayanan_nama : $model->getKelasPelayanan($modPendaftaran->pendaftaran_id) ) ; ?></td>
		</tr>
		<tr>
			<td width="10%">Diagnosa Medis</td>
			<td width="40%">: <?php echo (isset($modPendaftaran->diagnosa_nama) ? $modPendaftaran->diagnosa_nama : $model->getDiagnosaMedis($modPasien->pasien_id,$modPendaftaran->pendaftaran_id) ); ?></td>
			<td width="10%">Tgl. Masuk RS</td>
			<td width="40%">: <?php echo isset($modPendaftaran->tgl_pendaftaran) ? MyFormatter::formatDateTimeForUser($modPendaftaran->tgl_pendaftaran) : " - "; ?></td>
		</tr>
		<tr>
			<td width="10%">Dokter</td>
			<td width="40%">: <?php echo (isset($modPendaftaran->nama_pegawai) ? $modPendaftaran->nama_pegawai : $model->getNamaDokter($modPendaftaran->pendaftaran_id) ); ?></td>
		</tr>
	</table>
	<br>
	<table width="100%" class="table table-striped table-bordered table-condensed">
		<tr>
			<th>Tanggal / Jam</th>
			<th>Evaluasi</th>
			<th>Paraf / Nama Perawat</th>
		</tr>
		<?php
		$modDetail = ASEvaluasiaskepdetT::model()->findAllByAttributes(array('evaluasiaskep_id'=>$model->evaluasiaskep_id));

		if (count($modDetail)) {
			foreach ($modDetail as $i => $detail) {
				?>
				<tr>
					<td>
						<?php echo MyFormatter::formatDateTimeForUser($model->evaluasiaskep_tgl); ?>
					</td>
					<td>
						<?php echo "<b>Subjektif:</b>"; ?>
						<?php echo "<br>"; ?>
						<?php echo $detail->evaluasiaskepdet_subjektif; ?>
						<br>
						<br>
						<?php echo "<b>Objektif:</b>"; ?>
						<?php echo "<br>"; ?>
						<?php echo $detail->evaluasiaskepdet_objektif; ?>
						<br>
						<br>
						<?php echo "<b>Assessment:</b>"; ?>
						<?php echo "<br>"; ?>
						<?php echo $detail->evaluasiaskepdet_assessment; ?>
						<br>
						<br>
						<?php echo "<b>Planning:</b>"; ?>
						<?php echo "<br>"; ?>
						<?php echo $detail->evaluasiaskepdet_planning; ?>
						<br>
						<br>
						<?php echo "<b>Implementasi:</b>"; ?>
						<?php echo "<br>"; ?>
						<?php echo $detail->evaluasiaskepdet_implementasi; ?>
						<br>
						<br>
						<?php echo "<b>Hasil:</b>"; ?>
						<?php echo "<br>"; ?>
						<?php echo $detail->evaluasiaskepdet_hasil; ?>
					</td>
					<td>
						<?php 
                                                $cekPegawai = PegawaiM::model()->findByPk($model->pegawai_id);
                                                echo !empty($cekPegawai) ? $cekPegawai->namaLengkap : ''; 
                                                
                                                ?>
					</td>						
				</tr>
				<?php
			}
		} else {
			?>
			<tr>
				<td colspan="5">Data tidak ditemukan.</td>
			</tr>
		<?php } ?>
	</table>
</div>