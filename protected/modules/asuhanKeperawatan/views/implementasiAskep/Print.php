<link rel="stylesheet" href="css/printoutrsiaks-normal.css">

	<?php
	if ($caraPrint == 'EXCEL') {
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
		header('Cache-Control: max-age=0');
	}
	echo $this->renderPartial('application.views.headerReport._kopHeader'); 
	$no_urut = 1;
	
        echo "<div class='judul-rincian'>".$judulLaporan."</div>";
	
	?>
    <table width="100%" class="status">
		<tr class="identitas">
			<td width="10%">Nama</td>
			<td>: <?php echo (isset($modPasien->nama_pasien) ? $modPasien->nama_pasien : " - "); ?></td>
                        <td width="20%"></td>
                        <td width="10%">No. RM</td>
			<td >: <?php echo isset($modPasien->no_rekam_medik) ? $modPasien->no_rekam_medik : " - "; ?></td>
		</tr>
		<tr class="identitas">
			<td >Umur</td>
			<td >: <?php echo (isset($modPasien->umur) ? $modPasien->umur : " - "); ?></td>
                        <td>&nbsp;</td>
                        <td >Kamar / Kelas</td>
			<td >: <?php echo (isset($modPasien->kamarruangan_nokamar) ? $modPasien->kamarruangan_nokamar : $model->getNoKamar($modPasien->pendaftaran_id) ) . ' / ' . (isset($modPasien->kelaspelayanan_nama) ? $modPasien->kelaspelayanan_nama : $model->getKelasPelayanan($modPasien->pendaftaran_id) ) ; ?></td>
		</tr>
		<tr class="identitas">
			<?php /*
			<td width="10%">Diagnosa Medis</td>
			<td width="40%">: <?php echo (isset($modPasien->diagnosa_nama) ? $modPasien->diagnosa_nama : $model->getDiagnosaMedis($modPasien->pasien_id,$modPasien->pendaftaran_id) ); ?></td>
			 * 
			 */ ?>
			<td >Tgl. Masuk RS</td>
			<td >: <?php echo isset($modPasien->tgl_pendaftaran) ? MyFormatter::formatDateTimeForUser($modPasien->tgl_pendaftaran) : " - "; ?></td>
		</tr>
		<tr class="identitas">
			<td >Dokter</td>
			<td >: <?php echo (isset($modPasien->nama_pegawai) ? $modPasien->nama_pegawai : $model->getNamaDokter($modPasien->pendaftaran_id) ); ?></td>
		</tr>
	</table>
	<br>
	<table width="100%" class="grid grubrincian rincian-detail">
            <thead>
		<tr>
			<th>Tanggal / Jam</th>
			<th>Diagnosa</th>
			<th>Implementasi</th>
			<th>Paraf / Nama Perawat</th>
		</tr>
            </thead>
		<?php
		$modDetail = ASImplementasiaskepdetT::model()->findAllBySql('
					SELECT implementasiaskepdet_t.*,diagnosakep.*
					FROM implementasiaskepdet_t
					JOIN diagnosakep_m AS diagnosakep ON diagnosakep.diagnosakep_id = implementasiaskepdet_t.diagnosakep_id
					WHERE implementasiaskep_id =' . $model->implementasiaskep_id);

		if (count($modDetail)) {
			foreach ($modDetail as $i => $detail) {
				?>
				<tr>
					<td class="identitas" style="vertical-align: top;">
						<?php echo MyFormatter::formatDateTimeForUser($model->implementasiaskep_tgl); ?>
					</td>
					<td class="identitas" style="vertical-align: top;">
						<?php echo $detail->diagnosakep_nama; ?>
						<br>
						<br>
						<?php
						echo '<b>Tanda dan Gejala</b>';
						echo "<br>";
						$tandaGejala = ASPilihrencanaaskepT::model()->findAllBySql('
									SELECT pilihrencanaaskep_t.*,tandagejala.*
									FROM pilihrencanaaskep_t
									JOIN tandagejala_m AS tandagejala ON tandagejala.tandagejala_id = pilihrencanaaskep_t.tandagejala_id
									WHERE rencanaaskepdet_id =' . $detail->rencanaaskepdet_id . ' AND pilihrencanaaskep_t.tandagejala_id IS NOT NULL');
						if (count($tandaGejala)) {
							foreach ($tandaGejala as $i => $tg) {
								echo "<ul class='spasi1'>";
								echo '<li style="padding: 0 0px 0px 10px;">' . $tg->tandagejala_indikator . '</li>';
								echo "</ul>";
							}
						} else {
							echo "<ul class='spasi1'>";
							echo '<li> Data tidak ditemukan. </li>';
							echo "</ul>";
						}

						echo "<br>";

						echo '<b>Batasan Karakteristik</b>';
						echo "<br>";
						$bk_head = BataskarakteristikM::model()->findAllByAttributes(array('diagnosakep_id' => $detail->diagnosakep_id));
						if (count($bk_head)) {
							foreach ($bk_head as $i => $bk) {
								echo "<ul class='spasi1'>";
								echo '<li >' . $bk->bataskarakteristik_nama . '</li>';
								$bk_tail = BataskarakteristikdetM::model()->findAllByAttributes(array('bataskarakteristikdet_aktif'=>true,'bataskarakteristik_id' => $bk->bataskarakteristik_id));
								if (count($bk_tail)) {
									foreach ($bk_tail as $i => $bkd) {
										echo "<ul class='spasi1'>";
										echo '<li >' . $bkd->bataskarakteristikdet_indikator . '</li>';
										echo "</ul>";
									}
								} else {
									echo "<ul class='spasi1'>";
									echo '<li> Data tidak ditemukan. </li>';
									echo "</ul>";
								}
								echo "</ul>";
							}
						} else {
							echo "<ul class='spasi1'>";
							echo '<li> Data tidak ditemukan. </li>';
							echo "</ul>";
						}
						
						echo "<br>";

						echo '<b>Faktor Risiko</b>';
						echo "<br>";
						$bk_head = FaktorrisikoM::model()->findAllByAttributes(array('diagnosakep_id' => $detail->diagnosakep_id));
						if (count($bk_head)) {
							foreach ($bk_head as $i => $bk) {
								echo "<ul class='spasi1'>";
								echo '<li >' . $bk->faktorrisiko_nama . '</li>';
								$bk_tail = FaktorrisikodetM::model()->findAllByAttributes(array('faktorrisikodet_aktif'=>true,'faktorrisiko_id' => $bk->faktorrisiko_id));
								if (count($bk_tail)) {
									foreach ($bk_tail as $i => $bkd) {
										echo "<ul class='spasi1'>";
										echo '<li >' . $bkd->faktorrisikodet_indikator . '</li>';
										echo "</ul>";
									}
								} else {
									echo "<ul class='spasi1'>";
									echo '<li> Data tidak ditemukan. </li>';
									echo "</ul>";
								}
								echo "</ul>";
							}
						} else {
							echo "<ul class='spasi1'>";
							echo '<li> Data tidak ditemukan. </li>';
							echo "</ul>";
						}
						
						echo "<br>";

						echo '<b>Faktor Yang Berhubungan</b>';
						echo "<br>";
						$bk_head = FaktorhubM::model()->findAllByAttributes(array('diagnosakep_id' => $detail->diagnosakep_id));
						if (count($bk_head)) {
							foreach ($bk_head as $i => $bk) {
								echo "<ul class='spasi1'>";
								echo '<li >' . $bk->faktorhub_nama . '</li>';
								$bk_tail = FaktorhubdetM::model()->findAllByAttributes(array('faktorhubdet_aktif'=>true,'faktorhub_id' => $bk->faktorhub_id));
								if (count($bk_tail)) {
									foreach ($bk_tail as $i => $bkd) {
										echo "<ul class='spasi1'>";
										echo '<li >' . $bkd->faktorhubdet_indikator . '</li>';
										echo "</ul>";
									}
								} else {
									echo "<ul class='spasi1'>";
									echo '<li> Data tidak ditemukan. </li>';
									echo "</ul>";
								}
								echo "</ul>";
							}
						} else {
							echo "<ul class='spasi1'>";
							echo '<li> Data tidak ditemukan. </li>';
							echo "</ul>";
						}
						echo "<br>";
						echo '<b>Diagnosa Alternatif</b>';
						echo "<br>";
						$tandaGejala = ASPilihimplementasiaskepT::model()->findAllBySql('
									SELECT pilihimplementasiaskep_t.*,alternatifdx.*
									FROM pilihimplementasiaskep_t
									JOIN alternatifdx_m AS alternatifdx ON alternatifdx.alternatifdx_id = pilihimplementasiaskep_t.alternatifdx_id
									WHERE implementasiaskepdet_id =' . $detail->implementasiaskepdet_id . ' AND pilihimplementasiaskep_t.alternatifdx_id IS NOT NULL');
						if (count($tandaGejala)) {
							foreach ($tandaGejala as $i => $tg) {
								echo "<ul class='spasi1'>";
								echo '<li style="padding: 0 0px 0px 10px;">' . $tg->alternatifdx_nama . '</li>';
								echo "</ul>";
							}
						} else {
							echo "<ul class='spasi1'>";
							echo '<li> Data tidak ditemukan. </li>';
							echo "</ul>";
						}
						?>
						
					</td>
					<td class="identitas" style="vertical-align: top;">
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
					<td class="identitas">
						
					</td>						
				</tr>
				<?php
			}
		} else {
			?>
			<tr>
				<td colspan="5"  class="identitas">Data tidak ditemukan.</td>
			</tr>
		<?php } ?>
	</table>
