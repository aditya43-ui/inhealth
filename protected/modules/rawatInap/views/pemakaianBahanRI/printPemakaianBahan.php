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
                    <table class="status">
                        <!--<tr>
                            <td align="center" valig="middle" colspan="3">
                                <b><?php //echo $judul_print 
                                    ?></b>
                            </td>
                        </tr>-->
                        <tr>
                            <td align="center" valig="middle" colspan="3">
                                <h4>Data Kunjungan</h4>
                            </td>
                        </tr>
                        <tr>
                            <td>No. Pendaftaran</td>
                            <td>:</td>
                            <td><?php echo $modPasienAdmisi->no_pendaftaran; ?></td>
                        </tr>
                        <tr>
                            <td>Nama Pasien</td>
                            <td>:</td>
                            <td><?php echo $modPasienAdmisi->nama_pasien; ?></td>
                        </tr>
                        <tr>
                            <td>No. Rekam Medik</td>
                            <td>:</td>
                            <td><?php echo $modPasienAdmisi->no_rekam_medik; ?></td>
                        </tr>
                        <tr>
                            <td>Jenis Kelamin</td>
                            <td>:</td>
                            <td><?php echo $modPasienAdmisi->jeniskelamin; ?></td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td>:</td>
                            <td><?php echo $modPasienAdmisi->alamat_pasien; ?></td>
                        </tr>
                        <tr>
                            <td>Tanggal Lahir / Umur</td>
                            <td>:</td>
                            <td><?php echo $modPasienAdmisi->tanggal_lahir; ?> / <?php echo $modPasienAdmisi->umur; ?></td>
                        </tr>
                        <tr>
                            <td>Jenis Penjamin / Penjamin</td>
                            <td>:</td>
                            <td><?php echo $modPasienAdmisi->carabayar_nama; ?> / <?php echo $modPasienAdmisi->penjamin_nama; ?></td>
                        </tr>
                        <tr>
                            <td>Kelas Pelayanan</td>
                            <td>:</td>
                            <td><?php echo $modPasienAdmisi->kelaspelayanan_nama; ?></td>
                        </tr>
                        <tr>
                            <td align="center" valig="middle" colspan="3">
                                <h4>Daftar Obat dan Alat Kesehatan</h4>
                            </td>
                        </tr>
                        <tr>
                            <td align="center" valig="middle" colspan="3">
                                <table border="1" style="text-align:center;">
                                    <thead>
                                        <td><b>No.</b></td>
                                        <td><b>Obat dan Alkes</b></td>
                                        <td><b>Jumlah</b></td>
                                    </thead>
                                    <?php
                                    $total = 0;
                                    $subtotal = 0;
                                    foreach ($modObatAlkesPasien as $i => $modOAPasien) {
                                    ?>
                                        <tr>
                                            <td><?php echo ($i + 1) . "."; ?></td>
                                            <td><?php echo $modOAPasien->obatalkes->obatalkes_nama; ?></td>
                                            <td><?php echo $modOAPasien->qty_oa; ?></td>
                                        </tr>
                                    <?php } ?>
                                </table>
                            </td>
                        </tr>

                    </table>
                    <div style="border: 0 solid;margin-top: 10px;text-align:center;width:200px;">
                        <img style="height: 64px;" src="index.php?r=barcode/myBarcode&code=<?php echo $modPasienAdmisi->pendaftaran_id; ?>&is_text=">
                        <div class="barcode-label"><?php echo $modPasienAdmisi->pendaftaran_id; ?></div>
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