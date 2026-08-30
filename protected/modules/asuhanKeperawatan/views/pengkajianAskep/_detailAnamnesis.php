<?php 
	echo '<p style="text-align:center;"><b>RIWAYAT ANAMNESIS</b></p>';
?>
<table style="width: 100%; border: none;">
	<tr>
		<td width="20%">
			<b>Nama Pasien</b>
		</td>
		<td width="30%">
			: <?php echo $modAnamnesa->nama_pasien; ?>
		</td>
		<td width="20%">
			<b>Tanggal Anamnesis</b>
		</td>
		<td width="30%">
			: <?php echo MyFormatter::formatDateTimeForUser($modAnamnesa->tglanamnesis);?>
		</td>
	</tr>
	<tr>
		<td width="20%">
			<b>Jenis Kelamin</b>
		</td>
		<td width="30%">
			: <?php echo $modAnamnesa->jeniskelamin; ?>
		</td>
		<td width="20%">
			<b>Dokter Pemeriksa</b>
		</td>
		<td width="30%">
			: <?php echo (!empty($modAnamnesa->gelardepan) ? $modAnamnesa->gelardepan : "") . " " . (!empty($modAnamnesa->nama_pegawai) ? $modAnamnesa->nama_pegawai : "") . " " . (!empty($modAnamnesa->gelarbelakang_nama) ? $modAnamnesa->gelarbelakang_nama : ""); ?>
		</td>
	</tr>
	<tr>
		<td width="20%">
			<b>Umur</b>
		</td>
		<td width="30%">
			: <?php echo $modAnamnesa->umur; ?>
		</td>
		<td width="20%">
			<b>Nama Paramedis</b>
		</td>
		<td width="30%">
			: <?php echo $modAnamnesa->paramedis_nama;?>
		</td>
	</tr>
	<tr>
		<td width="20%">
			<b>Tanggal Pendaftaran</b>
		</td>
		<td width="30%">
			: <?php echo MyFormatter::formatDateTimeForUser($modAnamnesa->tgl_pendaftaran); ?>
		</td>
		<td width="20%">
			<b>Kelas Pelayanan</b>
		</td>
		<td width="30%">
			: <?php echo $modAnamnesa->kelaspelayanan_nama;?>
		</td>
	</tr>
	<tr>
		<td width="20%">
			<b>No. Pendaftaran</b>
		</td>
		<td width="30%">
			: <?php echo $modAnamnesa->no_pendaftaran; ?>
		</td>
		<td width="20%">
		</td>
		<td width="30%">
		</td>
	</tr>
</table>
<br>
<table width="100%" class="table table-striped table-bordered table-condensed">
	<tr>
		<td width="20%">
			<b>Keluhan Utama</b>
		</td>
		<td width="30%">
			<?php echo $modAnamnesa->keluhanutama; ?>
		</td>
		<td width="20%">
			<b>Jml Rokok / Hari</b>
		</td>
		<td width="30%">
			<?php echo $modAnamnesa->jmlrokok_btg_hr; ?>
		</td>
	</tr>
	<tr>
		<td width="20%">
			<b>Keluhan Tambahan</b>
		</td>
		<td width="30%">
			<?php echo $modAnamnesa->keluhantambahan; ?>
		</td>
		<td width="20%">
			<b>Status Psikologis</b>
		</td>
		<td width="30%">
			<?php echo $modAnamnesa->statuspsikologis; ?>
		</td>
	</tr>
	<tr>
		<td width="20%">
			<b>Riwayat Perjalanan Penyakit Pasien</b>
		</td>
		<td width="30%">
			<?php echo $modAnamnesa->riwayatpenyakitterdahulu; ?>
		</td>
		<td width="20%">
			<b>Status Mental</b>
		</td>
		<td width="30%">
			<?php echo $modAnamnesa->statusmental; ?>
		</td>
	</tr>
	<tr>
		<td width="20%">
			<b>Pernah Dirawat</b>
		</td>
		<td width="30%">
			<?php echo $modAnamnesa->pernahdirawat; ?>
		</td>
		<td width="20%">
			<b>Masalah Yang Dialami Pasien Sebelumnya</b>
		</td>
		<td width="30%">
			<?php echo $modAnamnesa->masalahsebelumnya; ?>
		</td>
	</tr>
	<tr>
		<td width="20%">
			<b>Dimana</b>
		</td>
		<td width="30%">
			<?php echo $modAnamnesa->dirawatdimana; ?>
		</td>
		<td width="20%">
			<b>Perilaku Kekerasan Yang Dialami Pasien Sebelumnya</b>
		</td>
		<td width="30%">
			<?php echo $modAnamnesa->prilakukekerasansebelumnya; ?>
		</td>
	</tr>
	<tr>
		<td width="20%">
			<b>Lama Sakit</b>
		</td>
		<td width="30%">
			<?php echo $modAnamnesa->lamasakit; ?>
		</td>
		<td width="20%">
			<b>Penurunan BB Yang Tidak Diinginkan</b>
		</td>
		<td width="30%">
			<?php echo $modAnamnesa->penurunanbb_3bln; ?>
		</td>
	</tr>
	<tr>
		<td width="20%">
			<b>Riwayat Penyakit Terdahulu</b>
		</td>
		<td width="30%">
			<?php echo $modAnamnesa->riwayatpenyakitterdahulu; ?>
		</td>
		<td width="20%">
			<b>Asupan Berkurang</b>
		</td>
		<td width="30%">
			<?php echo $modAnamnesa->asupanberkurang; ?>
		</td>
	</tr>
	<tr>
		<td width="20%">
			<b>Riwayat Penyakit Keluarga Dari</b>
		</td>
		<td width="30%">
			<?php echo $modAnamnesa->riwpenyakitkeldari; ?>
		</td>
		<td width="20%">
			<b>Aktifitas dan Mobilisasi</b>
		</td>
		<td width="30%">
			<?php echo $modAnamnesa->aktifitas_mobilisasi; ?>
		</td>
	</tr>
	<tr>
		<td width="20%">
			<b>Penyakit Mayor</b>
		</td>
		<td width="30%">
			<?php echo $modAnamnesa->penyakitmayor; ?>
		</td>
		<td width="20%">
			<b>Sebutkan Bantuan</b>
		</td>
		<td width="30%">
			<?php echo $modAnamnesa->sebutkan_bantuan; ?>
		</td>
	</tr>
	<tr>
		<td width="20%">
			<b>Riwayat Penyakit Keluarga</b>
		</td>
		<td width="30%">
			<?php echo $modAnamnesa->riwayatpenyakitkeluarga; ?>
		</td>
		<td width="20%">
			<b>Resiko Cedera / Jatuh</b>
		</td>
		<td width="30%">
			<?php echo $modAnamnesa->resikocedera; ?>
		</td>
	</tr>
	<tr>
		<td width="20%">
			<b>Riwayat Alergi Obat</b>
		</td>
		<td width="30%">
			<?php echo $modAnamnesa->riwayatalergiobat; ?>
		</td>
		<td width="20%">
			<b>Gelang Resiko Jatuh Terpasang</b>
		</td>
		<td width="30%">
			<?php echo ($modAnamnesa->isgelangresiko == 1) ? "Ya" : "Tidak" ; ?>
		</td>
	</tr>
	<tr>
		<td width="20%">
			<b>Reaksi Alergi Obat</b>
		</td>
		<td width="30%">
			<?php echo $modAnamnesa->reaksialergiobat; ?>
		</td>
		<td width="20%">
			<b>Tanda Segitiga Warna Kuning Terpasang</b>
		</td>
		<td width="30%">
			<?php echo $modAnamnesa->tandasegitigaterpasang ; ?>
		</td>
	</tr>
	<tr>
		<td width="20%">
			<b>Riwayat Alergi Makanan</b>
		</td>
		<td width="30%">
			<?php echo $modAnamnesa->riwayatmakanan; ?>
		</td>
		<td width="20%">
			<b>Penafsiran / Skrining Nyeri</b>
		</td>
		<td width="30%">
			<?php echo $modAnamnesa->skriningnyeri ; ?>
		</td>
	</tr>
	<tr>
		<td width="20%">
			<b>Reaksi Alergi Makanan</b>
		</td>
		<td width="30%">
			<?php echo $modAnamnesa->reaksialergimakanan; ?>
		</td>
		<td width="20%">
			<b>Skala Nyeri</b>
		</td>
		<td width="30%">
			<?php echo $modAnamnesa->skalanyeri ; ?>
		</td>
	</tr>
	<tr>
		<td width="20%">
			<b>Riwayat Alergi Lainnya</b>
		</td>
		<td width="30%">
			<?php echo $modAnamnesa->riwayatalergilainnya; ?>
		</td>
		<td width="20%">
			<b>Karakteristik Nyeri</b>
		</td>
		<td width="30%">
			<?php echo $modAnamnesa->karakteristiknyeri ; ?>
		</td>
	</tr>
	<tr>
		<td width="20%">
			<b>Reaksi Alergi Lainnya</b>
		</td>
		<td width="30%">
			<?php echo $modAnamnesa->reaksialergilainnya; ?>
		</td>
		<td width="20%">
			<b>Lokasi Nyeri</b>
		</td>
		<td width="30%">
			<?php echo $modAnamnesa->lokasinyeri ; ?>
		</td>
	</tr>
	<tr>
		<td width="20%">
			<b>Pengobatan Yang Sudah Dilakukan</b>
		</td>
		<td width="30%">
			<?php echo $modAnamnesa->pengobatanygsudahdilakukan; ?>
		</td>
		<td width="20%">
			<b>Nyeri Terasa</b>
		</td>
		<td width="30%">
			<?php echo $modAnamnesa->nyeriterasa ; ?>
		</td>
	</tr>
	<tr>
		<td width="20%">
			<b>Riwayat Kelahiran</b>
		</td>
		<td width="30%">
			<?php echo $modAnamnesa->riwayatkelahiran; ?>
		</td>
		<td width="20%">
			<b>Nyeri Hilang Bila</b>
		</td>
		<td width="30%">
			<?php echo $modAnamnesa->nyerihilangbila ; ?>
		</td>
	</tr>
	<tr>
		<td width="20%">
			<b>Riwayat Imunisasi</b>
		</td>
		<td width="30%">
			<?php echo $modAnamnesa->riwayatimunisasi; ?>
		</td>
		<td width="20%">
			<b>Hubungan Pasien Dengan Anggota Keluarga</b>
		</td>
		<td width="30%">
			<?php echo ($modAnamnesa->hubungankeluarga == 1) ? "Ya" : "Tidak" ; ?>
		</td>
	</tr>
	<tr>
		<td width="20%">
			<b>Gelang Tanda Alergi Dipasang</b>
		</td>
		<td width="30%">
			<?php echo $modAnamnesa->gelangtandaalergi; ?>
		</td>
		<td width="20%">
			<b>Tempat Tinggal</b>
		</td>
		<td width="30%">
			<?php echo $modAnamnesa->tempattinggal; ?>
		</td>
	</tr>
	<tr>
		<td width="20%">
			<b>Status Merokok</b>
		</td>
		<td width="30%">
			<?php echo ($modAnamnesa->statusmerokok == 1) ? "Ya" : "Tidak" ; ?>
		</td>
		<td width="20%">
			<b>Keterangan Anamnesis</b>
		</td>
		<td width="30%">
			<?php echo $modAnamnesa->keterangananamesa; ?>
		</td>
	</tr>
</table>