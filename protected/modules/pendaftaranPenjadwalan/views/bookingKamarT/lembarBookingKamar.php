<table>
    <tr>
        <td colspan="3">
            <table>
                <tr>
                    <td>
                        <?php echo $this->renderPartial('application.views.headerReport.headerDefault'); ?>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td align="center" valig="middle" colspan="3">
            <b><?php echo $judulLaporan ?></b>
        </td>
    </tr>
     <tr>
        <td align="center" valig="middle" colspan="3">
             Data Pasien
        </td>
    </tr>
    <tr>
        <td>Nama Pasien</td>
        <td>:</td>
        <td><?php echo $modPasien->namadepan.$modPasien->nama_pasien.$modPasien->nama_bin; ?></td>
    </tr>
    <tr>
        <td>No. Rekam Medis</td>
        <td>:</td>
        <td><?php echo $modPasien->no_rekam_medik; ?></td>
    </tr>   
    <tr>
        <td>Jenis Kelamin</td>
        <td>:</td>
        <td><?php echo $modPasien->jeniskelamin; ?></td>
    </tr>
    <tr>
        <td>Alamat</td>
        <td>:</td>
        <td><?php echo $modPasien->alamat_pasien; ?></td>
    </tr>
    <tr>
        <td>Tanggal Lahir</td>
        <td>:</td>
        <td><?php echo $modPasien->tanggal_lahir; ?></td>
    </tr>
    <tr>
        <td align="center" valig="middle" colspan="3">
             Data Pemesanan Kamar
        </td>
    </tr>
    <tr>
        <td>No. Pemesanan Kamar</td>
        <td>:</td>
        <td><?php echo $modBookingKamar->bookingkamar_no ?></td>
    </tr>
     <tr>
        <td>Status booking</td>
        <td>:</td>
        <td><?php echo $modBookingKamar->statusbooking ?></td>
    </tr>
    <tr>
        <td>Ruangan/No.Kamar-Bed</td>
        <td>:</td>
        <td><?php echo $modBookingKamar->ruangan->ruangan_nama; ?>/<?php echo $modBookingKamar->kamarruangan->kamarruangan_nokamar; ?>-<?php echo $modBookingKamar->kamarruangan->kamarruangan_nobed; ?></td>
    </tr>
     <tr>
        <td>Tanggal Transaksi Pemesanan</td>
        <td>:</td>
        <td><?php echo $modBookingKamar->tgltransaksibooking ?></td>
    </tr>
    <tr>
        <td>Tanggal Pemesanan Kamar</td>
        <td>:</td>
        <td><?php echo $modBookingKamar->tglbookingkamar ?></td>
    </tr>
     <tr>
        <td>Keterangan</td>
        <td>:</td>
        <td><?php echo $modBookingKamar->keteranganbooking ?></td>
    </tr>
    
    
    
</table>