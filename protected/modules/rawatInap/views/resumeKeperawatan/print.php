<style>
    .barcode-label{
        margin-top:-20px;
        z-index: 1;
        text-align: center;
        letter-spacing: 10px;
    }
    td, th{
        font-size: 8pt !important;
        height: 24px;
        padding-left:10px;
    }
    body{
        width: 21.7cm;
    }
    .content td{
        height: 20px;
    }
    .diagnosa td{
        height: 50px;
    }
</style>
<?php
echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksi',array('judulLaporan'=>$judul_print, 'colspan'=>10)); 
?>

<table width="100%" border="0">
    <tr>
        <td style="width:20%">No. Pendaftaran</td>
        <td style="width:20%"><?php echo isset($modKunjungan->no_pendaftaran)?$modKunjungan->no_pendaftaran:'' ?></td>
        <td style="width:20%">Jenis Penjamin</td>
        <td style="width:30%"><?php echo $modKunjungan->carabayar_nama ?></td>
    </tr>
    <tr>
		<td style="width:20%">No. Rekam Medis</td>
		<td style="width:20%"><?php echo $modKunjungan->no_rekam_medik; ?></td>
        <td style="width:20%">Penjamin</td>
        <td style="width:30%"><?php echo !empty($modKunjungan->penjamin_nama)?$modKunjungan->penjamin_nama:" - "; ?></td>
    </tr>
	<tr>
		<td style="width:20%">NIP</td>
        <td style="width:30%"><?php echo isset($model->pasien->pegawai_id)?$model->pasien->pegawai->nomorindukpegawai:' - ' ?></td>
		<td style="width:20%">Tanggal Masuk</td>
        <td style="width:30%"><?php echo !empty($modPasienMasukKamar->tglmasukkamar)?$modPasienMasukKamar->tglmasukkamar:" - "; ?></td>
	</tr>
    <tr>
        <td style="width:20%">Nama</td>
        <td style="width:20%"><?php echo isset($modKunjungan->namadepan)?$modKunjungan->namadepan.$modKunjungan->nama_pasien:$modKunjungan->nama_pasien; ?></td>
		<td style="width:20%">Tanggal Keluar</td>
        <td style="width:30%"><?php echo !empty($modPasienMasukKamar->tglpulang)?$modPasienMasukKamar->tglpulang: ' - '; ?></td>
    </tr>
    <tr>
        <td style="width:20%">Umur</td>
        <td style="width:20%"><?php echo isset($modKunjungan->umur)?$modKunjungan->umur:'' ?></td>
        <td style="width:20%">Kelas Pelayanan</td>
        <td style="width:30%"><?php echo !empty($modPasienMasukKamar->kelaspelayanan_nama)?$modPasienMasukKamar->kelaspelayanan_nama:" - "; ?></td>
    </tr>
    <tr>
        <td style="width:20%">Jenis Kelamin</td>
        <td style="width:20%"><?php echo isset($modKunjungan->jeniskelamin)?$modKunjungan->jeniskelamin:'' ?></td>
		<td style="width:20%">No. Kamar</td>
        <td style="width:30%"><?php echo !empty($modPasienMasukKamar->kamarruangan_nokamar)?$modPasienMasukKamar->kamarruangan_nokamar: ' - '; ?></td>
    </tr>
    <tr>
        <td style="width:20%">Dokter Pemeriksa</td>
        <td style="width:20%"><?php echo $modKunjungan->pegawai->nama_pegawai; ?></td>
    </tr>
</table>
<br>
<table width="100%" class="content" style="border: none;">
    <tr >
        <td style="width:20%">Keadaan saat masuk :</td>
    </tr>
    <tr>
        <td style="width:20%">&nbsp;&nbsp; a. Keluhan</td>
        <td style="width:80%"><?php echo $modResumeKeperawatan->keluhansaatmasuk; ?></td>
    </tr>
    <tr>
        <td style="width:20%">&nbsp;&nbsp; b. Diagnose Medis</td>
		<td style="width:80%"><?php echo $modResumeKeperawatan->diagnosaawal_nama; ?></td>
    </tr>
    <tr >
        <td style="width:20%">Keadaan selama dirawat :</td>
    </tr>
    <tr>
        <td style="width:20%">&nbsp;&nbsp; Diagnose keperawatan yang teratasi</td>
        <td style="width:80%"><?php echo $modResumeKeperawatan->diagkeprwtdiatasi; ?></td>
    </tr>
    <tr>
        <td style="width:20%">&nbsp;&nbsp; Tindakan</td>
        <td style="width:80%"><?php echo $modResumeKeperawatan->tindakankeprwatan; ?></td>
    </tr>
    <tr>
        <td style="width:20%">&nbsp;&nbsp; Diagnose keperawatan yang belum teratasi</td>
        <td style="width:80%"><?php echo $modResumeKeperawatan->diagkeprwtblmteratasi; ?></td>
    </tr>
    <tr >
        <td style="width:20%">Hasil pemeriksaan akhir :</td>
    </tr>
    <tr>
        <td style="width:20%">&nbsp;&nbsp; Laboratorium</td>
        <td style="width:80%"><?php echo $modResumeKeperawatan->hasikperiksalab; ?></td>
    </tr>
    <tr>
        <td style="width:20%">&nbsp;&nbsp; Rontgent</td>
		<td style="width:80%"><?php echo $modResumeKeperawatan->hasilperiksarad; ?></td>
    </tr>
    <tr>
        <td style="width:20%">&nbsp;&nbsp; Lain-lain</td>
		<td style="width:80%"><?php echo $modResumeKeperawatan->hasilperiksalainlain; ?></td>
    </tr>
    <tr >
        <td style="width:20%">Keadaan saat keluar :</td>
    </tr>
    <tr>
        <td style="width:20%">&nbsp;&nbsp; Keadaan Umum</td>
        <td style="width:80%"><?php echo $modResumeKeperawatan->keadaanumumkeluar; ?></td>
    </tr>
    <tr>
        <td style="width:20%">&nbsp;&nbsp; Tanda Vital</td>
		<td style="width:80%">
			Suhu : <?php echo $modResumeKeperawatan->suhu_saatkeluar; ?> &#186C, &nbsp;&nbsp;
			Nadi : <?php echo $modResumeKeperawatan->nadi_saatkeluar; ?> x/Mnt, &nbsp;&nbsp;
			Tensi : <?php echo $modResumeKeperawatan->tensi_saatkeluar; ?> mmHg, &nbsp;&nbsp;
			Nafas : <?php echo $modResumeKeperawatan->nafas_saatkeluar; ?> x/Mnt, &nbsp;&nbsp;
		</td>
    </tr>
    <tr>
        <td style="width:20%">&nbsp;&nbsp; Diagnase Medis</td>
		<td style="width:80%">
			<?php echo isset($modResumeKeperawatan->diagnosautama_nama)?$modResumeKeperawatan->diagnosautama_nama.'<br>':''; ?>
			<?php echo isset($modResumeKeperawatan->diagnosasekunder1_nama)?$modResumeKeperawatan->diagnosasekunder1_nama.'<br>':''; ?>
			<?php echo isset($modResumeKeperawatan->diagnosasekunder2_nama)?$modResumeKeperawatan->diagnosasekunder2_nama.'<br>':''; ?>
			<?php echo isset($modResumeKeperawatan->diagnosasekunder3_nama)?$modResumeKeperawatan->diagnosasekunder3_nama.'<br>':''; ?>
		</td>
    </tr>
    <tr>
        <td style="width:20%">&nbsp;&nbsp; Obat-obat yang dilanjutkan</td>
		<td style="width:80%"><?php echo $modResumeKeperawatan->terapilanjutan; ?></td>
    </tr>
    <tr>
        <td style="width:20%">&nbsp;&nbsp; Nasehat</td>
		<td style="width:80%">
			<table>
				<tr>
					<td>1. Diit </td>
					<td>: <?php echo $modResumeKeperawatan->nasehat_diit; ?></td>
				</tr>
				<tr>
					<td>2. Mobilisasi </td>
					<td>: <?php echo $modResumeKeperawatan->nasehat_mobilisasi; ?></td>
				</tr>
				<tr>
					<td>3. Eliminasi </td>
					<td>: <?php echo $modResumeKeperawatan->nasehat_eliminasi; ?></td>
				</tr>
				<tr>
					<td>4. Kontrol </td>
					<td>: <?php echo $modResumeKeperawatan->nasehat_kontrol; ?></td>
				</tr>
			</table>
		</td>
    </tr>
	<tr>
        <td style="width:20%">&nbsp;&nbsp; Cara Keluar</td>
		<td style="width:80%"><?php echo $modResumeKeperawatan->carakeluar; ?></td>
    </tr>
	<tr>
        <td style="width:20%">&nbsp;&nbsp; Tanggal Kontrol</td>
		<td style="width:80%"><?php echo MyFormatter::formatDateTimeForUser($modResumeKeperawatan->tglkontrol); ?></td>
    </tr>
</table>
<br><br><br><br><br>
<table width="100%" class="content">
	<tr>
		<td style="width:33%;" align="center"><?php echo MyFormatter::formatDateTimeForUser(date('Y-m-d')) ?></td>
		<td style="width:33%"  align="center">( Tanda Tangan )</td>
		<td style="width:33%"  align="center"><?php

        $login = LoginpemakaiK::model()->findByPk($modResumeKeperawatan->create_loginpemakai_id);
        $pegawai_id =   $login->pegawai_id;
        $modPeg = PegawaiM::model()->findByPk($pegawai_id);
        echo $modPeg->nama_pegawai;
        ?></td>
	</tr>
</table>