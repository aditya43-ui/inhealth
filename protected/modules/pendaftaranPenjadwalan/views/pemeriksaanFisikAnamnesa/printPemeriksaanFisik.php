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
        height: 32px;
    }
</style>
<?php echo $this->renderPartial('rawatJalan.views.pemeriksaanFisik._headerPrint'); ?>

<table width="100%" border="1">
    <tr>
        <td style="width:20%">SMF</td>
        <td style="width:30%"><?php echo $modPendaftaran->jeniskasuspenyakit->jeniskasuspenyakit_nama; ?></td>
        <td style="width:20%">NO. RM</td>
        <td style="width:30%"><?php echo $modPasien->no_rekam_medik; ?></td>
    </tr>
    <tr>
        <td style="width:20%">Nama</td>
        <td style="width:30%"><?php echo $modPasien->nama_pasien; ?></td>
        <td style="width:20%">UMUR</td>
        <td style="width:30%"><?php echo CustomFunction::hitungUmur($modPasien->tanggal_lahir); ?></td>
    </tr>
    <tr>
        <td style="width:20%">Tgl. Periksa</td>
        <td style="width:20%"><?php echo MyFormatter::formatDateTimeId($modPemeriksaanFisik->tglperiksafisik); ?></td>
        <td style="width:20%">Ruangan</td>
        <td style="width:20%"><?php echo $modPendaftaran->ruangan->ruangan_nama; ?></td>
    </tr>
</table>
<table width="100%" class="content" style="border: none;">
    <tr>
        <td align="center" valign="middle" colspan="4" style="font-weight:bold">PERIKSA FISIK</td>
    </tr>
    <tr>
        <td colspan="2" width="30%">Tekanan Darah</td>
        <td colspan="2" width="70%"><?php echo (isset($modPemeriksaanFisik->tekanandarah)?$modPemeriksaanFisik->tekanandarah:" - ").' /MmHg'; ?></td>
    </tr>
    <tr>
        <td colspan="2" width="30%">Mean Arterial Pressure</td>
        <td colspan="2" width="70%"><?php echo isset($modPemeriksaanFisik->meanarteripressure)?$modPemeriksaanFisik->meanarteripressure:" - "; ?></td>
    </tr>
    <tr>
        <td colspan="2" width="30%">Detak Nadi</td>
        <td colspan="2" width="70%"><?php echo (isset($modPemeriksaanFisik->detaknadi)?$modPemeriksaanFisik->detaknadi:" - ").' /Menit'; ?></td>
    </tr>
    <tr>
        <td colspan="2" width="30%">Denyut Jantung</td>
        <td colspan="2" width="70%"><?php echo (isset($modPemeriksaanFisik->denyutjantung)?$modPemeriksaanFisik->denyutjantung:" - "); ?></td>
    </tr>
    <tr>
        <td colspan="2" width="30%">Pernapasan</td>
        <td colspan="2" width="70%"><?php echo (isset($modPemeriksaanFisik->pernapasan)?$modPemeriksaanFisik->pernapasan:" - ").' /Menit'; ?></td>
    </tr>
    <tr>
        <td colspan="2" width="30%">Suhu Tubuh</td>
        <td colspan="2" width="70%"><?php echo (isset($modPemeriksaanFisik->suhutubuh)?$modPemeriksaanFisik->suhutubuh:" - ").' &deg; Celcius'; ?></td>
    </tr>
    <tr>
        <td colspan="2" width="30%">Tinggi badan / Berat badan</td>
        <td colspan="2" width="70%"><?php echo (isset($modPemeriksaanFisik->tinggibadan_cm)?$modPemeriksaanFisik->tinggibadan_cm:" - ").' Cm / '.(isset($modPemeriksaanFisik->beratbadan_kg)?$modPemeriksaanFisik->beratbadan_kg:" - ").' Kg'; ?></td>
    </tr>
    <tr>
        <td colspan="2" width="30%">Index Masa Tubuh</td>
        <td colspan="2" width="70%"><?php echo (isset($modPemeriksaanFisik->indexmassatubuh)?$modPemeriksaanFisik->indexmassatubuh:" - "); ?></td>
    </tr>
    <tr>
        <td colspan="2" width="30%">Kelainan Pada Bagian Tubuh</td>
        <td colspan="2" width="70%"><?php echo isset($modPemeriksaanFisik->kelainanpadabagtubuh)?$modPemeriksaanFisik->kelainanpadabagtubuh:" - "; ?></td>
    </tr>
    <tr>
        <td colspan="2" width="30%">Inspeksi</td>
        <td colspan="2" width="70%"><?php echo isset($modPemeriksaanFisik->inspeksi)?$modPemeriksaanFisik->inspeksi:" - "; ?></td>
    </tr>
    <tr>
        <td colspan="2" width="30%">Palpasi</td>
        <td colspan="2" width="70%"><?php echo isset($modPemeriksaanFisik->palpasi)?$modPemeriksaanFisik->palpasi:" - "; ?></td>
    </tr>
    <tr>
        <td colspan="2" width="30%">Perkusi</td>
        <td colspan="2" width="70%"><?php echo isset($modPemeriksaanFisik->perkusi)?$modPemeriksaanFisik->perkusi:" - "; ?></td>
    </tr>
    <tr>
        <td colspan="2" width="30%">Auskultasi</td>
        <td colspan="2" width="70%"><?php echo isset($modPemeriksaanFisik->auskultasi)?$modPemeriksaanFisik->auskultasi:" - "; ?></td>
    </tr>
</table>
<table width="100%" class="content" style="border: none;">
    <tr>
        <td width="20%">Kepala</td>
        <td width="30%"><?php echo isset($modPemeriksaanFisik->kepala)?$modPemeriksaanFisik->kepala:" - "; ?></td>
        <td width="20%">Mata</td>
        <td width="30%"><?php echo isset($modPemeriksaanFisik->mata)?$modPemeriksaanFisik->mata:" - "; ?></td>
    </tr>
    <tr>
        <td width="20%">Hidung</td>
        <td width="30%"><?php echo isset($modPemeriksaanFisik->hidung)?$modPemeriksaanFisik->hidung:" - "; ?></td>
	<td width="20%">Telinga</td>
        <td width="30%"><?php echo isset($modPemeriksaanFisik->telinga)?$modPemeriksaanFisik->telinga:" - "; ?></td>
    </tr>
    <tr>
	<td width="20%">Tenggorokan</td>
        <td width="30%"><?php echo isset($modPemeriksaanFisik->tenggorokan)?$modPemeriksaanFisik->tenggorokan:" - "; ?></td>
        <td width="20%">Leher</td>
        <td width="30%"><?php echo isset($modPemeriksaanFisik->leher)?$modPemeriksaanFisik->leher:" - "; ?></td>
    </tr>
    <tr>
	<td width="20%">Jantung</td>
        <td width="30%"><?php echo isset($modPemeriksaanFisik->jantung)?$modPemeriksaanFisik->jantung:" - "; ?></td>
	<td width="20%">Payudara</td>
        <td width="30%"><?php echo isset($modPemeriksaanFisik->payudara)?$modPemeriksaanFisik->payudara:" - "; ?></td>
    </tr>
    <tr>
	<td width="20%">Abdomen</td>
        <td width="30%"><?php echo isset($modPemeriksaanFisik->abdomen)?$modPemeriksaanFisik->abdomen:" - "; ?></td>
        <td width="20%">Kulit</td>
        <td width="30%"><?php echo isset($modPemeriksaanFisik->kulit)?$modPemeriksaanFisik->kulit:" - "; ?></td>
    </tr>
</table>
<table width="100%" class="content" style="border: none;">
    <tr>
        <td colspan="2" width="30%">Hasil</td>
        <td colspan="2" width="70%"><?php echo isset($hasil)?$hasil:" - "; ?></td>
    </tr>
</table>
<table style="width: 100%; border: none;">
    <tr>
        <td colspan="9">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="3" align="center" valign="middle">Pasien / Keluarga pasien</td>
        <td colspan="3"></td>
        <td colspan="3" align="center" valign="middle"><?php echo Yii::app()->user->getState('kabupaten_nama').", ".MyFormatter::formatDateTimeId(date('Y-m-d',strtotime($modPemeriksaanFisik->tglperiksafisik))); ?><br>Dokter Pemeriksa</td>
    </tr>
    <tr>
        <td colspan="9">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="9">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="9">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="3" align="center" valign="middle"></td>
        <td colspan="3"></td>
        <td colspan="3" align="center" valign="middle"><?php echo (isset($modPendaftaran->pegawai->gelardepan)?$modPendaftaran->pegawai->gelardepan:'').' '.$modPendaftaran->pegawai->nama_pegawai.' '.(isset($modPendaftaran->pegawai->gelarbelakang_nama)?$modPendaftaran->pegawai->gelarbelakang_nama:''); ?></td>
    </tr>
</table>
