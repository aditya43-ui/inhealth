
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
                    echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array('judulLaporan' => $judul_print));
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
                                Data Pasien
                            </td>
                        </tr>
                        <tr>
                            <td>Nama Pasien</td>
                            <td>:</td>
                            <td><?php echo (!empty($modPasien->namadepan) ? $modPasien->namadepan : "" ) . (!empty($modPasien->nama_pasien) ? $modPasien->nama_pasien : "" ) . (!empty($modPasien->nama_bin) ? " (" . $modPasien->nama_bin . ")" : ""); ?></td>
                        </tr>
                        <tr>
                            <td>No. Rekam Medis</td>
                            <td>:</td>
                            <td><?php echo (!empty($modPasien->no_rekam_medik) ? $modPasien->no_rekam_medik : null ); ?></td>
                        </tr>
                        <tr>
                            <td>No. Pendaftaran</td>
                            <td>:</td>
                            <td><?php echo (!empty($modPendaftaran->no_pendaftaran) ? $modPendaftaran->no_pendaftaran : null ); ?></td>
                        </tr>
                        <?php /*
                    <!--RND-3123  <tr>
                            <td>Jenis Kelamin</td>
                            <td>:</td>
                            <td><?php echo (!empty($modPasien->jeniskelamin) ? $modPasien->jeniskelamin : "" ); ?></td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td>:</td>
                            <td><?php echo (!empty($modPasien->alamat_pasien) ? $modPasien->alamat_pasien: "" ); ?></td>
                        </tr>
                        <tr>
                            <td>Tanggal Lahir / Umur</td>
                            <td>:</td>
                            <td><?php echo (!empty($modPasien->tanggal_lahir) ? $modPasien->tanggal_lahir: "" ); ?>/<?php echo (!empty($modPendaftaran->umur) ? $modPendaftaran->umur: "" ); ?></td>
                        </tr>
                        <tr>
                            <td>Jenis Penjamin / Penjamin</td>
                            <td>:</td>
                            <td><?php echo empty($$modPasienAdmisi) ? $modPendaftaran->carabayar->carabayar_nama : $modPasienAdmisi->carabayar->carabayar_nama; ?>/<?php echo $modPasienAdmisi->penjamin->penjamin_nama; ?></td>
                        </tr>
                        <tr>
                            <td align="center" valig="middle" colspan="3">
                                Perawatan Rawat Inap
                            </td>
                        </tr>-->
                        */ ?>
                        <tr>
                            <td>Ruangan / Kamar Tujuan</td>
                            <td>:</td>
                            <td><?php echo empty($modPasienAdmisi) ? "-" : $modPasienAdmisi->ruangan->ruangan_nama; ?> / No.<?php echo isset($modPasienAdmisi->kamarruangan) ? $modPasienAdmisi->kamarruangan->kamarruangan_nokamar : "-"; ?></td>
                        </tr>
                        <?php /*
                    <!--<tr>
                            <td>Karcis</td>
                            <td>:</td>
                            <td><?php echo (isset($modTindakan->karcis->karcis_nama) ? $modTindakan->karcis->karcis_nama : "-"); ?></td>
                        </tr>
                        <tr>
                            <td>Harga Karcis</td>
                            <td>:</td>
                            <td><?php echo (isset($modTindakan->tarif_satuan) ? $format->formatUang($modTindakan->tarif_satuan * $modTindakan->qty_tindakan) : "-") ?></td>
                        </tr>
                        <tr>
                            <td>Status Pembayaran Karcis</td>
                            <td>:</td>
                            <td>Belum Dibayar  Default dulu</td>
                        </tr>
                        <tr>
                            <td>Dokter Ruangan</td>
                            <td>:</td>
                            <td><?php echo $modPasienAdmisi->pegawai->NamaLengkap; ?></td>
                        </tr>-->
                        */ ?>
                    </table>
                    <div style="border: 0 solid;margin-top: 10px;text-align:center;width:200px;">
                        <img style="height: 64px;" src="index.php?r=barcode/myBarcode&code=<?php echo (!empty($modPendaftaran->pendaftaran_id) ? $modPendaftaran->pendaftaran_id: null ); ?>&is_text=">  
                        <div class="barcode-label"><?php echo (!empty($modPendaftaran->pendaftaran_id) ? $modPendaftaran->pendaftaran_id: null ); ?></div>
                    </div>
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
