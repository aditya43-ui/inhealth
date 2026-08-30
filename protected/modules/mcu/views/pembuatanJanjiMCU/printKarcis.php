<style>
    .barcode-label{
        margin-top:-20px;
        z-index: 1;
        text-align: center;
        letter-spacing: 10px;
    }
    td, th{
        font-size: 8pt !important;
    }
    body{
        width:7.9cm;
    }
</style>
<?php echo $this->renderPartial('pendaftaranPenjadwalan.views.pendaftaranRawatJalan._headerPrint'); ?>
<table style="width: 100%; border: none;">
    <tr>
        <td align="center" valig="middle" colspan="3">
            <b><?php echo $judul_print ?></b>
        </td>
    </tr>
     <tr>
        <td align="center" valig="middle" colspan="3">
			&nbsp;
        </td>
    </tr>

    <tr>
        <td>No. Antrian</td>
        <td>:</td>
        <td><b><?php echo $model->ruangan->ruangan_singkatan; ?>-<?php echo $model->no_antrianjanji; ?></b></td>
    </tr>
    <tr>
        <td>No. Janji MCU</td>
        <td>:</td>
        <td><b><?php echo $model->no_buatjanji; ?></b></td>
    </tr>
    <tr>
        <td>Tanggal Janji MCU</td>
        <td>:</td>
        <td><b><?php echo MyFormatter::formatDateTimeForUser($model->tglbuatjanji); ?></b></td>
    </tr>
    <tr>
        <td>No. Rekam Medis</td>
        <td>:</td>
        <td><b><?php echo $modPasien->no_rekam_medik; ?></b></td>
    </tr>
    <tr>
        <td>Nama Pasien</td>
        <td>:</td>
        <td><?php echo $modPasien->namadepan.$modPasien->nama_pasien.(!empty($modPasien->nama_bin) ? " (".$modPasien->nama_bin.")" : ""); ?></td>
    </tr>
    <tr>
        <td>Poliklinik Tujuan</td>
        <td>:</td>
        <td><?php echo $model->ruangan->ruangan_nama; ?></td>
    </tr>
    <tr>
        <td>Dokter Pemeriksa</td>
        <td>:</td>
        <td><?php echo !empty($model->pegawai->gelardepan)?$model->pegawai->gelardepan.' ':''; echo $model->pegawai->nama_pegawai; ?></td>
    </tr>
    <tr>
        <td colspan="3"><i>&nbsp;</i></td>
    </tr>
    <tr>
        <td colspan="3"><i>(Sebelum ke ruangan pemeriksaan mohon ke pendaftaran terlebih dahulu)</i></td>
    </tr>
    </table>