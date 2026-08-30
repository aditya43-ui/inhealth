
<style>

    .border th, .border td{
        border:1px solid #000;
    }
    .table thead:first-child{
        border-top:1px solid #000;        
    }

    thead th{
        background:none;
        color:#333;
    }

    .border {
        box-shadow:none;
        border-spacing: 0;
        padding: 0;
    }

    .table tbody tr:hover td, .table tbody tr:hover th {
        background-color: none;
    }
</style>

<table style="width: 100%; border: none;">
    <thead>
        <tr>
            <td>
                <div class="header"><?php
            
                        echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array('judulLaporan' => $judulLaporan));
                    
                    ?></div>  
            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <div class="content">

                    <table style="width: 100%; border: none;">

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
                            <td><?php echo $modPasien->namadepan . $modPasien->nama_pasien . $modPasien->nama_bin; ?></td>
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
                </div>		
            </td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <td>
                <div class="footer-space">&nbsp;</div>
            </td>
        </tr>
    </tfoot>
</table>
<div class="">
</div>
<div class="footer">

    <?php echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>

</div>   
