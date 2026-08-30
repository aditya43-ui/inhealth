<?php
/**
* issue RSST-2549
* prinout rencana keperawatan
* 
* @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @version     2.0.0
* @link    <http://172.9.1.15/simpp/docs/>
* @link    <http://piindonesia.co.id>
* 
*/
?>
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
			<td width="5%">Nama</td>
			<td width="25%">: <?php echo (isset($modPasien->nama_pasien) ? $modPasien->nama_pasien : " - "); ?></td>
			<td width="5%">No. RM</td>
			<td width="25%">: <?php echo isset($modPasien->no_rekam_medik) ? $modPasien->no_rekam_medik : " - "; ?></td>
			<td width="5%">Umur</td>
			<td width="35%">: <?php echo (isset($modPasien->umur) ? $modPasien->umur : " - ") . ' / ' . (isset($modPasien->jeniskelamin) ? $modPasien->jeniskelamin : " - " ); ?></td>
		</tr>
		<tr>
			<td width="10%">Ruang / Kelas</td>
			<td width="25%">: <?php echo (isset($modPasien->ruangan_nama) ? $modPasien->ruangan_nama : " - ") . ' / ' . (isset($modPasien->kelaspelayanan_nama) ? $modPasien->kelaspelayanan_nama : " - " ); ?></td>
			<td width="5%">Tanggal</td>
			<td width="25%">: <?php echo (isset($model->rencanaaskep_tgl) ? MyFormatter::formatDateTimeForUser($model->rencanaaskep_tgl) : " - "); ?></td>
			<td width="5%">Diagnosa</td>
			<td width="35%">: <?php echo (isset($modPasien->diagnosa_nama) ? $modPasien->diagnosa_nama : $model->getDiagnosaMedis($modPasien->pasien_id,$modPasien->pendaftaran_id)); ?></td>
		</tr>

	</table>
	<br>
	<table width="100%" class="table table-striped">
		<tr>
			<th>No.</th>
			<th>Diagnosa</th>
			<th>Tujuan</th>
			<th>Intervensi</th>
			<th>TTD/Nama Perawat</th>
		</tr>
		<?php
		$modDetail = ASRencanaaskepdetT::model()->findAllBySql('
					SELECT rencanaaskepdet_t.*,diagnosakep.*,tujuan.*,kriteriahasil.*,intervensi.*,renaskep.pegawai_id
					FROM rencanaaskepdet_t 
					JOIN diagnosakep_m AS diagnosakep ON diagnosakep.diagnosakep_id = rencanaaskepdet_t.diagnosakep_id
                                        JOIN rencanaaskep_t renaskep ON renaskep.rencanaaskep_id =  rencanaaskepdet_t.rencanaaskep_id
					LEFT JOIN tujuan_m AS tujuan ON tujuan.tujuan_id = rencanaaskepdet_t.tujuan_id
					LEFT JOIN kriteriahasil_m AS kriteriahasil ON kriteriahasil.kriteriahasil_id = rencanaaskepdet_t.kriteriahasil_id
					LEFT JOIN intervensi_m AS intervensi ON intervensi.intervensi_id = rencanaaskepdet_t.intervensi_id
					WHERE rencanaaskepdet_t.rencanaaskep_id =' . $model->rencanaaskep_id);

		if (count($modDetail)) {
			foreach ($modDetail as $i => $detail) {
				?>
				<tr>
					<td>
						<?php echo $i + 1; ?>
					</td>
					<td>
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
						$tandaGejala = ASPilihrencanaaskepT::model()->findAllBySql('
									SELECT pilihrencanaaskep_t.*,alternatifdx.*
									FROM pilihrencanaaskep_t
									JOIN alternatifdx_m AS alternatifdx ON alternatifdx.alternatifdx_id = pilihrencanaaskep_t.alternatifdx_id
									WHERE rencanaaskepdet_id =' . $detail->rencanaaskepdet_id . ' AND pilihrencanaaskep_t.alternatifdx_id IS NOT NULL');
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
					<td>
						<!--Setelah dilakukan tindakan keperawatan selama <?php //echo $detail->rencanaaskepdet_hari; ?> x 24 Jam,-->
                                                Setelah dilakukan tindakan keperawatan selama per <?php echo $detail->rencanaaskepdet_hari; ?> <?php echo $detail->rencanaaskepdet_estimasiwaktu; ?> , 
						<?php echo $detail->tujuan_nama; ?>
						<br>
						<br>
						<?php
						echo '<b>Kriteria Hasil:</b>';
						echo "<br>";
						echo $detail->kriteriahasil_nama. '<br>';
						$kriteriaHasil = ASPilihrencanaaskepT::model()->findAllBySql('
									SELECT pilihrencanaaskep_t.*,kriteriahasildet.*
									FROM pilihrencanaaskep_t
									JOIN kriteriahasildet_m AS kriteriahasildet ON kriteriahasildet.kriteriahasildet_id = pilihrencanaaskep_t.kriteriahasildet_id
									WHERE rencanaaskepdet_id =' . $detail->rencanaaskepdet_id . ' AND pilihrencanaaskep_t.kriteriahasildet_id IS NOT NULL');
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
								echo '<td>'.$kh->kriteriahasildet_indikator.'</td>';
								echo '<td>'.$kh->rencanaaskep_ir.'</td>';
								echo '<td>'.$kh->rencanaaskep_er.'</td>';
								echo '</tr>';
								
							}								
								echo '</table>';
						} else {
							
							echo 'Data tidak ditemukan';
						}
						?>
					</td>
					<td>
						<?php echo $detail->intervensi_nama; ?>
						<?php
						echo "<br>";
						$intervensi = ASPilihrencanaaskepT::model()->findAllBySql('
									SELECT pilihrencanaaskep_t.*,intervensidet.*
									FROM pilihrencanaaskep_t
									JOIN intervensidet_m AS intervensidet ON intervensidet.intervensidet_id = pilihrencanaaskep_t.intervensidet_id
									WHERE rencanaaskepdet_id =' . $detail->rencanaaskepdet_id . ' AND pilihrencanaaskep_t.intervensidet_id IS NOT NULL');
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
						?>
					</td>
					<td>
                                            <?php
                                                $peg = PegawaiM::model()->findByPk($detail->pegawai_id);
                                                
                                                if (!empty($peg)){
                                                    return $peg->namaLengkap;
                                                }
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