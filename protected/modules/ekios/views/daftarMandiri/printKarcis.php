<style>
/*    .barcode-label{
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
    }*/
   BODY, DIV, TABLE, TBODY, TFOOT, TR, TH, TD, P {
    font-family: "Arial" !important;
    font-size: 14pt !important;
    }
</style>
<?php echo $this->renderPartial('application.views.headerReport.headerDefaultNew'); ?>
<table style="width: 100%; border: none;">
    <tr>
        <td align="center" valig="middle" colspan="3">
            <b><?php echo strtoupper($judul_print) ?></b>
        </td>
    </tr>
     <tr>
        <td align="center" valig="middle" colspan="3">
             DATA PASIEN
        </td>
    </tr>
    <?php // if($modPendaftaran->carabayar_id == Params::CARABAYAR_ID_MEMBAYAR){ ?>
    <tr>
        <td>No. Antrian Poli</td>
        <td>:</td>
        <td><b><?php echo $modPendaftaran->ruangan->ruangan_singkatan; ?>-<?php echo $modPendaftaran->no_urutantri; ?></b></td>
    </tr>
    <tr>
        <td>No. Pendaftaran</td>
        <td>:</td>
        <td><b><?php echo $modPendaftaran->no_pendaftaran; ?></b></td>
    </tr>
    <tr>
        <td>Tgl. Pendaftaran</td>
        <td>:</td>
        <td><b><?php echo MyFormatter::formatDateTimeId($modPendaftaran->tgl_pendaftaran); ?></b></td>
    </tr>   
    <tr>
        <td>Nama Peserta</td>
        <td>:</td>
        <td><?php echo $modPasien->namadepan.$modPasien->nama_pasien; ?></td>
    </tr>
    <tr>
        <td>No. Rekam Medis</td>
        <td>:</td>
        <td><?php echo $modPasien->no_rekam_medik; ?></td>
    </tr>
    <tr>
        <td>Poliklinik Tujuan</td>
        <td>:</td>
        <td><?php echo $modPendaftaran->ruangan->ruangan_nama; ?></td>
    </tr>
    <tr>
        <td>Dokter</td>
        <td>:</td>
        <td><?php echo !empty($modPegawai)?$modPegawai->nama_pegawai:"-"; ?></td>
    </tr>
    <tr>
        <td colspan="3" class="borderers"></td>
    </tr>

    
</table><br>
