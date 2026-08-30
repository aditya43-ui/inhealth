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
        width:100%;
    }
    .borderers {
        border-bottom: 1px dashed black;
    }
    
    .tab-det td {
        vertical-align: top;
    }
</style>
<?php echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksiNew', array('judulLaporan'=>$judul_print)); ?>
<table width="100%" class="tab-det">
        <td>No. Antrian</td>
        <td>:</td>
        <td><strong><?php echo $modKonsul->ruangan->ruangan_singkatan; ?>-<?php echo $modKonsul->no_antriankonsul; ?></strong></td>
    </tr>
    <tr>
        <td>No. Pendaftaran</td>
        <td>:</td>
        <td><strong><?php echo $modPendaftaran->no_pendaftaran; ?></strong></td>
    </tr>
    <tr>
        <td>Tgl. Pendaftaran</td>
        <td>:</td>
        <td><strong><?php echo MyFormatter::formatDateTimeId($modPendaftaran->tgl_pendaftaran); ?></strong></td>
    </tr>
    <tr>
        <td>Nama Pasien</td>
        <td>:</td>
        <td><?php echo $modPasien->namadepan.$modPasien->nama_pasien; ?></td>
    </tr>
    <tr>
        <td>No. Rekam Medis</td>
        <td>:</td>
        <td><?php echo $modPasien->no_rekam_medik; ?></td>
    </tr>
    <tr>
        <td>Lantai </td>
        <td>:</td>
        <td><?php echo $modKonsul->lantai_hd; ?></td>
    </tr>
    <tr>
        <td>Bed </td>
        <td>:</td>
        <td><?php 
        $modKamar = KamarruanganM::model()->findByPk($modKonsul->kamarruangan_id);
        echo $modKamar->kamarruangan_nobed; ?></td>
    </tr>
</table> <br>

<table width="100%">
    <tr>
        <td width="50%"></td>
        <td style="text-align: center;">
            Mengetahui / Petugas
        </td>
    </tr>
    <tr height="60px" valign="bottom">
        <td></td>
        <td style="text-align: center;"><?php echo !empty($modPegawai)?$modPegawai->nama_pegawai:"-"; ?></td>
    </tr>
</table>
    
    