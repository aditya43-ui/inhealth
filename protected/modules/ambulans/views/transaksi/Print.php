<style>
    .barcode-label{
        margin-top:-20px;
        z-index: 1;
        text-align: center;
        letter-spacing: 10px;
    }
    td, th{
        font-size: 11pt !important;
    }
    body{
        width: 21.7cm;
    }
</style>
<?php echo $this->renderPartial($this->path_view.'_headerPrintStatus'); ?>

<table style="width: 100%; border: none;">
    <tr>
        <td align="center" valig="middle" colspan="9">DATA UMUM PASIEN</td>
    </tr>
    <tr>
        <td colspan="5">No. Rekam Medis</td>
        <td colspan="4"><?php echo isset($modPemesanan->norekammedis) ? $modPemesanan->norekammedis : $modPemesanan->norekammedis; ?></td>
    </tr>
    <tr>
        <td colspan="5">Nama Pemesan/Pemohon</td>
        <td colspan="4"><?php echo isset($modPemesanan->namapasien) ? $modPemesanan->namapasien : $modPemesanan->namapasien; ?></td>
    </tr>
	<tr>
        <td align="center" valig="middle" colspan="9">DATA PEMESANAN</td>
    </tr>
    <tr>
        <td colspan="5">Tanggal Pemesanan Ambulans</td>
        <td colspan="4"><?php echo isset($modPemesanan->tglpemesananambulans) ? MyFormatter::formatDateTimeId($modPemesanan->tglpemesananambulans) : "-"; ?></td>
    </tr>
    <tr>
        <td colspan="5">Tanggal Pemakaian</td>
        <td colspan="4"><?php echo isset($modPemesanan->tglpemakaianambulans) ? MyFormatter::formatDateTimeId($modPemesanan->tglpemakaianambulans) : "-"; ?></td>
    </tr>
    <tr>
        <td colspan="5">No. Pesan Ambulans</td>
        <td colspan="4"><?php echo isset($modPemesanan->pesanambulans_no) ? $modPemesanan->pesanambulans_no:"-"; ?></td>
    </tr>
    <tr>
        <td colspan="5">Tempat Tujuan</td>
        <td colspan="4"><?php echo isset($modPemesanan->tempattujuan) ? $modPemesanan->tempattujuan:"-"; ?></td>
    </tr>
    <tr>
        <td colspan="5">Nama Tujuan</td>
        <td colspan="4"><?php echo isset($modPemesanan->alamattujuan) ? $modPemesanan->alamattujuan:"-"; ?></td>
    </tr>
    <tr>
        <td colspan="5">RT / RW</td>
        <td colspan="4"><?php echo isset($modPemesanan->rt_rw) ? $modPemesanan->rt_rw:"-"; ?></td>
    </tr>
	<tr>
        <td colspan="5">Kelurahan</td>
        <td colspan="4"><?php echo isset($modPemesanan->kelurahan_nama) ? $modPemesanan->kelurahan_nama:"-"; ?></td>
    </tr>
    <tr>
        <td colspan="5">Nomor Telepon (Rumah / Mobile)</td>
        <td><?php echo isset($modPemesanan->notelepon)?$modPemesanan->notelepon:' - '; ?> / <?php echo isset($modPemesanan->nomobile)?$modPemesanan->nomobile:' - '; ?></td>
    </tr>
	<tr>
        <td colspan="5">Untuk Keperluan</td>
        <td colspan="4"><?php echo isset($modPemesanan->untukkeperluan) ? $modPemesanan->untukkeperluan:"-"; ?></td>
    </tr>
	<tr>
        <td colspan="5">Keterangan Pesan</td>
        <td colspan="4"><?php echo isset($modPemesanan->keteranganpesan) ? $modPemesanan->keteranganpesan:"-"; ?></td>
    </tr>
	<tr>
        <td colspan="5">Ruangan Pemesanan</td>
        <td colspan="4"><?php echo isset($modPemesanan->ruanganpemesan->ruangan_nama) ? $modPemesanan->ruanganpemesan->ruangan_nama:"-"; ?></td>
    </tr>
</table>
<table width="100%" style="margin-top:20px;">
    <tr>
        <td width="30%" align="center" align="top">
			<div></div>
            <div>Pasien</div>
            <div style="margin-top:60px;"><?php echo $modPemesanan->namapasien; ?></div></td>
        <td></td>
        <td width="30%" align="center" align="top">
            <div><?php echo Yii::app()->user->getState("kabupaten_nama").", ".MyFormatter::formatDateTimeId(date('Y-m-d')); ?></div>
            <div>Petugas</div>
            <div style="margin-top:60px;"><?php $pegawai_id = Yii::app()->user->getState('pegawai_id'); $modPegawai=  AMPegawaiM::model()->findByPk($pegawai_id); echo isset($modPegawai) ? $modPegawai->NamaLengkap : ""; ?></div>
        </td>
    </tr>    
</table>