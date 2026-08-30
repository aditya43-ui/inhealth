<table style="width: 100%; border: none;">
	<tr>
		<td style="text-align:center;" align="center"><b>RENCANA KEPERAWATAN</b></td>
	</tr>
</table>
<div class="white-container">
	<div class="row">
		<table style="width: 100%; border: none;">
			<tr>
				<td ><p>No. Rencana</p></td>
				<td ><p> : <?php echo isset($model->no_rencana) ? $model->no_rencana : "-"; ?></p></td>
				<td ><p>Tanggal Rencana</p></td>
				<td ><p> : <?php echo isset($model->rencanaaskep_tgl) ? MyFormatter::FormatDateTimeForUser($model->rencanaaskep_tgl) : "-"; ?></p></td>
				<td ><p>Nama Perawat</p></td>
				<td ><p> : <?php echo isset($model->nama_pegawai) ? $model->nama_pegawai : "-"; ?></p></td>
			</tr>
		</table>
	</div>
	<div class="row">
		<fieldset class="box">
			<legend class="rim">Data Pengkajian</legend>
			<table style="width: 100%; border: none;">
				<tr>
					<td ><p>No. Pengkajian</p></td>
					<td ><p> : <?php echo isset($modPasien->no_pengkajian) ? $modPasien->no_pengkajian : "-"; ?></p></td>
					<td ><p>Tanggal Pengkajian</p></td>
					<td ><p> : <?php echo isset($modPasien->pengkajianaskep_tgl) ? MyFormatter::FormatDateTimeForUser($modPasien->pengkajianaskep_tgl) : "-"; ?></p></td>
					<td ><p>Nama Perawat</p></td>
					<td ><p> : <?php echo isset($modPasien->nama_pegawai) ? $modPasien->nama_pegawai : "-"; ?></p></td>
				</tr>
			</table>
		</fieldset>
	</div>
	<div class="row">
		<fieldset class="box">
			<legend class="rim">Identitas Pasien</legend>
			<table style="width: 100%; border: none;">
				<tr>
					<td ><p>No. Pendaftaran</p></td>
					<td ><p> : <?php echo isset($modPasien->no_pendaftaran) ? $modPasien->no_pendaftaran : "-"; ?></p></td>
					<td ><p>Nama Pasien</p></td>
					<td ><p> : <?php echo isset($modPasien->nama_pasien) ? $modPasien->nama_pasien : "-"; ?></p></td>
					<td ><p>Ruangan</p></td>
					<td ><p> : <?php echo isset($modPasien->ruangan_nama) ? $modPasien->ruangan_nama : "-" ?></p></td>
				</tr>
				<tr>
					<td ><p>Tanggal Pendaftaran</p></td>
					<td ><p> : <?php echo isset($modPasien->tgl_pendaftaran) ? MyFormatter::formatDateTimeForUser($modPasien->tgl_pendaftaran) : "-"; ?></p></td>
					<td ><p>Umur</p></td>
					<td ><p> : <?php echo isset($modPasien->umur) ? $modPasien->umur : "-"; ?></p></td>
					<td ><p>Kelas</p></td>
					<td ><p> : <?php echo isset($modPasien->kelaspelayanan_nama) ? $modPasien->kelaspelayanan_nama : "-" ?></p></td>
				</tr>
				<tr>
					<td ><p>No Rekam Medik</p></td>
					<td ><p> : <?php echo isset($modPasien->no_rekam_medik) ? $modPasien->no_rekam_medik : "-"; ?></p></td>
					<td ><p>Diagnosa Medik Masuk</p></td>
					<td ><p> : <?php echo isset($modPasien->diagnosa_nama) ? $modPasien->diagnosa_nama : "-"; ?></p></td>
					<td ><p>No Kamar / No. Bed</p></td>
					<td ><p> : <?php echo (isset($modPasien->kamarruangan_nokamar) ? $modPasien->kamarruangan_nokamar : "-") . ' / ' . (isset($modPasien->kamarruangan_nobed) ? $modPasien->kamarruangan_nobed : "-"); ?></p></td>
				</tr>
			</table>
		</fieldset>
	</div>

	<?php
	$rencanadet = ASRencanaaskepdetT::model()->findAllBySql(
			'SELECT rencanaaskepdet_t.*,diagnosakep.*,tujuan.*,kriteriahasil.*,intervensi.*
					FROM rencanaaskepdet_t
					JOIN diagnosakep_m AS diagnosakep ON diagnosakep.diagnosakep_id = rencanaaskepdet_t.diagnosakep_id
					JOIN tujuan_m AS tujuan ON tujuan.tujuan_id = rencanaaskepdet_t.tujuan_id
					JOIN kriteriahasil_m AS kriteriahasil ON kriteriahasil.kriteriahasil_id = rencanaaskepdet_t.kriteriahasil_id
					JOIN intervensi_m AS intervensi ON intervensi.intervensi_id = rencanaaskepdet_t.intervensi_id
					WHERE rencanaaskepdet_t.rencanaaskep_id=' . $model->rencanaaskep_id);
	?>
	<div class="row">
		<fieldset class="box">
			<legend class="rim">Rencana Keperawatan</legend>
			<table width="100%" class="table table-striped table-condensed table-bordered">
				<thead>
				<th>Diagnosa Keperawatan</th>
				<th>Tanda dan Gejala</th>
				<th>Tujuan</th>
				<th>Kriteria Hasil</th>
				<th>Intervensi</th>
				<th>Kolaborasi</th>
				</thead>
				<tbody>
					<?php
					if (count($rencanadet)) {
						foreach ($rencanadet as $i => $modDetail) {
							?>
							<tr>
								<td><?php echo $modDetail->diagnosakep_nama; ?></td>
								<td><?php
									$tandaGejala = ASPilihrencanaaskepT::model()->findAllBySql('
									SELECT pilihrencanaaskep_t.*,tandagejala.*
									FROM pilihrencanaaskep_t
									JOIN tandagejala_m AS tandagejala ON tandagejala.tandagejala_id = pilihrencanaaskep_t.tandagejala_id
									WHERE rencanaaskepdet_id =' . $modDetail->rencanaaskepdet_id . ' AND pilihrencanaaskep_t.tandagejala_id IS NOT NULL');
									if (count($tandaGejala)) {
										foreach ($tandaGejala as $i => $tg) {
											echo "<ul>";
											echo '<li style="padding: 0 0px 0px 10px;">' . $tg->tandagejala_indikator . '</li>';
											echo "</ul>";
										}
									} else {
										echo "<ul class='spasi1'>";
										echo '<li> Data tidak ditemukan. </li>';
										echo "</ul>";
									}
									?></td>
								<td>Setelah dilakukan tindakan keperawatan selama <?php echo $modDetail->rencanaaskepdet_hari; ?> x 24 Jam, 
									<?php echo $modDetail->tujuan_nama; ?></td>
								<td><?php
									echo $modDetail->kriteriahasil_nama . '<br>';
									$kriteriaHasil = ASPilihrencanaaskepT::model()->findAllBySql('
									SELECT pilihrencanaaskep_t.*,kriteriahasildet.*
									FROM pilihrencanaaskep_t
									JOIN kriteriahasildet_m AS kriteriahasildet ON kriteriahasildet.kriteriahasildet_id = pilihrencanaaskep_t.kriteriahasildet_id
									WHERE rencanaaskepdet_id =' . $modDetail->rencanaaskepdet_id . ' AND pilihrencanaaskep_t.kriteriahasildet_id IS NOT NULL');
									if (count($kriteriaHasil)) {
										echo '<table class="table table-striped table-bordered table-condensed">
									<tr>
										<th>Kriteria Hasil</th>
										<th>IR</th>
										<th>ER</th>
									</tr>
									';
										foreach ($kriteriaHasil as $i => $kh) {
											echo '<tr>';
											echo '<td>' . $kh->kriteriahasildet_indikator . '</td>';
											echo '<td>' . $kh->rencanaaskep_ir . '</td>';
											echo '<td>' . $kh->rencanaaskep_er . '</td>';
											echo '</tr>';
										}
										echo '</table>';
									} else {

										echo 'Data tidak ditemukan';
									}
									?></td>
								<td><?php echo $modDetail->intervensi_nama; ?>
									<?php
									echo "<br>";
									$intervensi = ASPilihrencanaaskepT::model()->findAllBySql('
									SELECT pilihrencanaaskep_t.*,intervensidet.*
									FROM pilihrencanaaskep_t
									JOIN intervensidet_m AS intervensidet ON intervensidet.intervensidet_id = pilihrencanaaskep_t.intervensidet_id
									WHERE rencanaaskepdet_id =' . $modDetail->rencanaaskepdet_id . ' AND pilihrencanaaskep_t.intervensidet_id IS NOT NULL');
									if (count($intervensi)) {
										foreach ($intervensi as $i => $itv) {
											echo "<ul class='spasi1'>";
											echo '<li style="padding: 0 0px 0px 10px;">' . $itv->intervensidet_indikator . '</li>';
											echo "</ul>";
										}
									} else {
										echo "<ul class='spasi1'>";
										echo '<li> Data tidak ditemukan. </li>';
										echo "</ul>";
									}
									?></td>
								<td><?php echo ($modDetail->iskolaborasi == 1) ? "Ya":"Tidak"; ?>
									<?php
									echo "<br>";
									echo 'Ket: ';
									echo isset($modDetail->rencanaaskepdet_ketkolaborasi) ? $modDetail->rencanaaskepdet_ketkolaborasi : "-" ?></td>
							</tr>
							<?php
						}
					} else {
						echo "<tr>";
						echo "<td colspan=6>Data tidak ditemukan.</td>";
						echo "</tr>";
					}
					?>
				</tbody>
			</table>
		</fieldset>
	</div>

</div>