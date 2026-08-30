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
	echo $this->renderPartial('application.views.headerReport.headerDefault', array('judulLaporan' => $judulLaporan, 'colspan' => 7));
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
			<td width="40%">: <?php echo (isset($modPasien->umur) ? $modPasien->umur : " - "); ?></td>
			<td width="10%">Kamar / Kelas</td>
			<td width="40%">: <?php echo (isset($model->kamarruangan_nokamar) ? $model->kamarruangan_nokamar : $model->getNoKamar($modPasien->pendaftaran_id) ) . ' / ' . (isset($model->kelaspelayanan_nama) ? $model->kelaspelayanan_nama : $model->getKelasPelayanan($modPasien->pendaftaran_id) ) ; ?></td>
		</tr>
		<tr>
			<td width="10%">Diagnosa Medis</td>
			<td width="40%">: <?php echo (isset($modPasien->diagnosa_nama) ? $modPasien->diagnosa_nama : $model->getDiagnosaMedis($modPasien->pasien_id,$modPasien->pendaftaran_id) ); ?></td>
			<td width="10%">Tgl. Masuk RS</td>
			<td width="40%">: <?php echo isset($modPasien->tgl_pendaftaran) ? MyFormatter::formatDateTimeForUser($modPasien->tgl_pendaftaran) : " - "; ?></td>
		</tr>
		<tr>
			<td width="10%">Dokter</td>
			<td width="40%">: <?php echo (isset($modPasien->nama_pegawai) ? $modPasien->nama_pegawai : $model->getNamaDokter($modPasien->pendaftaran_id) ); ?></td>
		</tr>
	</table>
	<br>
	<table width="100%" class="table table-striped table-bordered table-condensed">
		<tr>
			<th>Tanggal / Jam</th>
			<th>Implementasi</th>
			<th>Paraf / Nama Perawat</th>
		</tr>
		<?php
		$modDetail = ASImplementasiaskepdetT::model()->findAllByAttributes(array('implementasiaskep_id'=>$model->implementasiaskep_id));

		if (count($modDetail)) {
			foreach ($modDetail as $i => $detail) {
				?>
				<tr>
					<td>
						<?php echo MyFormatter::formatDateTimeForUser($model->implementasiaskep_tgl); ?>
					</td>
					<td>
						<?php
						$impl = ASPilihimplementasiaskepT::model()->findAllBySql('
									SELECT pilihimplementasiaskep_t.*,indikatorimplkepdet.*
									FROM pilihimplementasiaskep_t
									JOIN indikatorimplkepdet_m AS indikatorimplkepdet ON indikatorimplkepdet.indikatorimplkepdet_id = pilihimplementasiaskep_t.indikatorimplkepdet_id
									WHERE implementasiaskepdet_id =' . $detail->implementasiaskepdet_id . ' AND pilihimplementasiaskep_t.indikatorimplkepdet_id IS NOT NULL');
						if (count($impl)) {
							foreach ($impl as $i => $indikator) {
								echo "<ul class='spasi1'>";
								echo '<li style="padding: 0 0px 0px 10px;">' . $indikator->indikatorimplkepdet_indikator . '</li>';
								echo "</ul>";
							}
						} else {
							echo "<ul class='spasi1'>";
							echo '<li> Data tidak ditemukan. </li>';
							echo "</ul>";
						}
						?>
						
					</td>
					<td>
						
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