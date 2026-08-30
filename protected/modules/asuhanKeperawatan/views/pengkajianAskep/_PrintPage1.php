	<br>
	<?php echo '<p style="text-align:center;"><b>PENGKAJIAN AWAL KEPERAWATAN</b></p>'; ?>
	<?php echo '<p style="text-align:center;">(Dilengkapi dalam waktu 24 jam pertama pasien masuk rawat inap)</p>'; ?>
	<table width="100%" class="table-alergi table-condensed">
		<tr>
			<th colspan="2" style="text-align: center; ">ALERGI / REAKSI</th>
		</tr>
		<tr>
			<td width="50%">
				Tidak ada reaksi
			</td>
			<td width="50%"></td>
		</tr>
		<tr>
			<td width="50%">
				Alergi obat, sebutkan <?php echo (!empty($modAnamnesa->riwayatalergiobat) ? $modAnamnesa->riwayatalergiobat : "-"); ?>
			</td>
			<td width="50%">
				Reaksi: <?php echo (isset($modAnamnesa->reaksialergiobat) ? $modAnamnesa->reaksialergiobat : "-"); ?>
			</td>
		</tr>
		<tr>
			<td width="50%">
				Alergi makanan, sebutkan <?php echo (!empty($modAnamnesa->riwayatmakanan) ? $modAnamnesa->riwayatmakanan : "-"); ?>
			</td>
			<td width="50%">
				Reaksi: <?php echo isset($modAnamnesa->reaksialergimakanan) ? $modAnamnesa->reaksialergimakanan : "-"; ?>
			</td>
		</tr>
		<tr>
			<td width="50%">
				Alergi lainnya, sebutkan <?php echo !empty($modAnamnesa->riwayatalergilainnya) ? $modAnamnesa->riwayatalergilainnya : "-"; ?>
			</td>
			<td width="50%">
				Reaksi: <?php echo isset($modAnamnesa->reaksialergilainnya) ? $modAnamnesa->reaksialergilainnya : "-"; ?>
			</td>
		</tr>
		<tr>
			<td width="50%">
				Gelang tanda alergi di pasang ( warna merah )
			</td>
			<td width="50%">
				<?php echo isset($modAnamnesa->gelangtandaalergi) ? $modAnamnesa->gelangtandaalergi : "-"; ?>
			</td>
		</tr>
		<tr>
			<td width="50%">
				Tidak diketahui
			</td>
			<td width="50%"></td>
		</tr>
	</table>
	<br>
	<table style="width: 100%; border: none;">
		<tr>
			<td>
				<b>ALASAN MASUK RUMAH SAKIT (Keluhan utama) : </b>
			</td>
			<td>
				<?php echo isset($modAnamnesa->keluhanutama) ? $modAnamnesa->keluhanutama : "-"; ?>
			</td>
		</tr>
		<tr>
			<td>
			</td>
			<td>
				<?php echo isset($modAnamnesa->keluhantambahan) ? $modAnamnesa->keluhantambahan : "-"; ?>
			</td>
		</tr>
	</table>
	<br>
	<b>RIWAYAT KESEHATAN / PENGOBATAN / PERAWATAN SEBELUMNYA :</b>
	<p>
		<?php echo "Pernah dirawat: ". (($modAnamnesa->pernahdirawat == 1 ) ? "Ya, Lama Sakit " . $modAnamnesa->lamasakit :"Tidak, " )  
		. " Dimana: " . (isset($modAnamnesa->dirawatdimana) ? $modAnamnesa->dirawatdimana : "-")
		." Diagnosis: " . (isset($modAnamnesa->riwayatpenyakitterdahulu) ? $modAnamnesa->riwayatpenyakitterdahulu : "-")
		; ?>
	</p>
	<p>
		<?php echo "Apakah ada riwayat keluarga ". (isset($modAnamnesa->riwpenyakitkeldari) ? $modAnamnesa->riwpenyakitkeldari : "-")  
		. " yang memiliki penyakit mayor: " . (isset($modAnamnesa->penyakitmayor) ? $modAnamnesa->penyakitmayor : "-")
		; ?>
	</p>
	<p>
		<?php echo "Riwayat Perjalanan Penyakit Pasien: ". (isset($modAnamnesa->riwayatperjalananpasien) ? $modAnamnesa->riwayatperjalananpasien : "-")  ; ?>
	</p>
	<p>
		<?php echo "Pengobatan Yang Sudah Dilakukan: ". (isset($modAnamnesa->pengobatanygsudahdilakukan) ? $modAnamnesa->pengobatanygsudahdilakukan : "-")  ; ?>
	</p>
	<p>
		<?php echo "Riwayat Kelahiran: ". (isset($modAnamnesa->riwayatkelahiran) ? $modAnamnesa->riwayatkelahiran : "-") . ". Riwayat Imunisasi: " . (isset($modAnamnesa->riwayatimunisasi) ? $modAnamnesa->riwayatimunisasi : "-"); ?>
	</p>
	<br>
	<b>RIWAYAT PSIKOSOSIAL :</b>
	<p>
		<?php echo "Status Psikologis: " . (isset($modAnamnesa->statuspsikologis) ? $modAnamnesa->statuspsikologis : "-"); ?>
	</p>
	<p>
		<?php echo "Status Mental: " . (isset($modAnamnesa->statusmental) ? $modAnamnesa->statusmental : "-"); ?>
	</p>
	<p>
		<?php echo "Ada masalah yang dialami pasien sebelumnya, sebutkan " . (isset($modAnamnesa->masalahsebelumnya) ? $modAnamnesa->masalahsebelumnya : "-"); ?>
	</p>
	<p>
		<?php echo "Perilaku kekerasan yang dialami pasien sebelumnya, sebutkan " . (isset($modAnamnesa->prilakukekerasansebelumnya) ? $modAnamnesa->prilakukekerasansebelumnya : "-"); ?>
	</p>
	<br>
	<p>
		<?php echo "Gcs Eye " . (isset($modPeriksaFisik->gcs_eye) ? $modPeriksaFisik->gcs_eye : "-") ;?>
	</p>
	<p>
		<?php echo "Gcs Verbal " . (isset($modPeriksaFisik->gcs_verbal) ? $modPeriksaFisik->gcs_verbal : "-") ;?>
	</p>
	<p>
		<?php echo "Gcs Motorik " . (isset($modPeriksaFisik->gcs_motorik) ? $modPeriksaFisik->gcs_motorik : "-") ;?>
	</p>
	<p>
		<?php echo "Nilai Gcs ";?>
	</p>
	<p>
		<?php echo "Keterangan Anamnesis: ". (isset($modAnamnesa->keterangananamesa) ? $modAnamnesa->keterangananamesa : "-");?>
	</p>