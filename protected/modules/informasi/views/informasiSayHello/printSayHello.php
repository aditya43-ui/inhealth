<?php
echo $this->renderPartial('application.views.headerReport.headerRincianBaru');
?>
<table style="width: 100%; border: none;">
	<tr>
		<td>Tgl. Pendaftaran</td>
		<td>: <?php echo MyFormatter::formatDateTimeForUser($modPendaftaran->tgl_pendaftaran); ?></td>
		
		<td>No Rekam Medik</td>
		<td>: <?php echo $modPasien->no_rekam_medik; ?></td>
	</tr>
	<tr>
		<td>No. Pendaftaran</td>
		<td>: <?php echo $modPendaftaran->no_pendaftaran; ?></td>
		
		<td>Nama Pasien</td>
		<td>: <?php echo $modPasien->nama_pasien; ?></td>
	</tr>
	<tr>
		<td>Umur</td>
		<td>: <?php echo $modPendaftaran->umur; ?></td>
		
		<td>Nama Panggilan</td>
		<td>: <?php echo $modPasien->nama_bin; ?></td>
	</tr>
	<tr>
		<td>Jenis Kasus Penyakit</td>
		<td>: <?php echo $modPendaftaran->jeniskasuspenyakit->jeniskasuspenyakit_nama; ?></td>
		
		<td>Jenis Kelamin</td>
		<td>: <?php echo $modPasien->jeniskelamin; ?></td>
	</tr>
	<tr>
		<td>Dokter Pemeriksa</td>
		<td>: <?php echo $modAdmisi->pegawai->nama_pegawai; ?></td>
		
		<td>No Kamar / No. Bed</td>
		<td>: <?php echo isset($modAdmisi->kamarruangan_id) ? $modAdmisi->kamarruangan->kamarruangan_nokamar : '';
				echo ' / ';
				echo isset($modAdmisi->kamarruangan_id) ? $modAdmisi->kamarruangan->kamarruangan_nobed : '';
			?></td>
	</tr>
	<tr>
		<td>Kelas Pelayanan</td>
		<td>: <?php echo $modAdmisi->kelaspelayanan->kelaspelayanan_nama; ?></td>
		
		<td></td>
		<td></td>
	</tr>
</table>
<br>
<table style="width: 100%; border: none;">
	<tr>
		<td style="width: 100px;">Tanggal</td>
		<td>: <?php echo MyFormatter::formatDateTimeForUser($modSayHello->pasiensayhello_tgl); ?></td>
	</tr>
	<tr>
		<td>Media</td>
		<td>: <?php echo $modSayHello->pasiensayhello_media; ?></td>
	</tr>
	<tr>
		<td style="vertical-align: top;">Deskripsi</td>
		<td>: <?php echo $modSayHello->pasiensayhello_deskripsi; ?></td>
	</tr>
	<tr>
		<td>Kritik</td>
		<td>: <?php echo $modSayHello->pasiensayhello_kritik; ?></td>
	</tr>
	<tr>
		<td>Saran</td>
		<td>: <?php echo $modSayHello->pasiensayhello_saran; ?></td>
	</tr>
	<tr>
		<td>Kesimpulan</td>
		<td>: <?php echo $modSayHello->kesimpulan; ?></td>
	</tr>
	<tr>
		<td style="vertical-align: top;">Diagnosa</td>
		<td> 
			<?php 
			if(count((array)$modViewSayHello) > 0){
				echo '<ol>';
				foreach ($modViewSayHello as $key => $value) {
					echo '<li>Kode : '.$value->diagnosa_kode.' ( '.$value->diagnosa_nama.' )</li>';
				}
				echo '</ol>';
			}
			?>
		</td>
	</tr>
</table>
<br><br>
<table>
	<tr>
		<td width="75%"></td>
		<td style="text-align: center;"> 
			<?php echo Yii::app()->user->getState('kabupaten_nama') ?>, 
            <?php 
	            echo MyFormatter::formatDateTimeId($modSayHello->pasiensayhello_tgl);
			?>
			<br><br><br><br><br>
			<?php $pegawai = LoginpemakaiK::pegawaiLoginPemakai(); ?>
            <b><?php echo $pegawai->nama_pegawai; ?></b>
		</td>
	</tr>
</table>

