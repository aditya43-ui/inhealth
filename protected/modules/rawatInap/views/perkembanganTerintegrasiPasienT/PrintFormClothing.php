<style>
    .barcode-label{
        margin-top:-20px;
        z-index: 1;
        text-align: center;
        letter-spacing: 10px;
    }
</style>

    <table class="status" width="100%">
         <tr>
            <td colspan="3" >
                <?php echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksiNew', array('judulLaporan'=>$judul_print)); ?>
            </td>
        </tr>
        
        <tr>
            <td align="center" valig="middle" colspan="3">
                 <h4>INSTALASI HEMODIALISIS RSUD. Dr. SOETOMO</h4>
            </td>
        </tr>
        <tr>
            <td>Nama Pasien</td>
            <td>:</td>
            <td><?php echo $modPasien->nama_pasien; ?></td>
        </tr>
        <tr>
            <td>No. Rekam Medik</td>
            <td>:</td>
            <td><?php echo $modPasien->no_rekam_medik; ?></td>
        </tr>
        <tr>
            <td>Tanggal Lahir / Umur</td>
            <td>:</td>
            <td><?php echo MyFormatter::formatDateTimeId($modPasien->tanggal_lahir); ?> / <?php echo $modPendaftaran->umur; ?></td>
        </tr>
        <tr>
            <td>Tanggal Kejadian</td>
            <td>:</td>
            <td><?php echo MyFormatter::formatDateTimeId($modMonitoringIntraHd->tanggal); ?></td>
        </tr>
        <tr>
            <td>Alasan Clothing</td>
            <td>:</td>
            <td><?php echo $model->alasan_clokting; ?></td>
        </tr>

    </table>
<div style="text-align: right">
    <span>Surabaya, <?= MyFormatter::formatDateTimeId(date('d-m-Y')); ?></span>
</div>
<table border="0" width="100%">
    <tr>
        <td style="text-align: center; width: 30%;">Mengetahui</td>
        <td style="text-align: center; width: 30%;"></td>
        <td></td>
    </tr>
    <tr>
        <td style="text-align: center">Ka. Instalasi Hemodialisis</td>
        <td></td>
        <td style="text-align: center">Dokter yang merawat</td>
    </tr>
    <tr style="height: 100px;">
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td style="text-align: center">Dr. Nunuk Mardiana, SpPD-KGH</td>
        <td></td>
        <td style="text-align: center"><?= $modPendaftaran->pegawai->nama_pegawai; ?></td>
    </tr>
</table>
<table border="0" width="100%">
    <tr style="height: 20px;">
        <td style="text-align: center; width: 30;"></td>
        <td style="text-align: center; width: 30%;"></td>
        <td></td>
    </tr>
    <tr>
        <td style="text-align: center"></td>
        <td style="text-align: center">PJ Shift pagi/sore/malam</td>
        <td style="text-align: center"></td>
    </tr>
    <tr style="height: 100px;">
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td style="text-align: center"></td>
        <td style="text-align: center">..................................................</td>
        <td style="text-align: center"></td>
    </tr>
</table>