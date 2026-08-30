<style>
    .barcode-label {
        margin-top: -20px;
        z-index: 1;
        text-align: center;
        letter-spacing: 10px;
    }
</style>

<table style="width: 100%; border: none;">
    <thead>
        <tr>
            <td>
                <div class="header"><?php
                                    echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array());
                                    ?></div>
            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <div class="content">

                    <table class="status">
                        <tr>
                            <td align="center" valig="middle" colspan="3">
                                <div class="judulcontent"> <b><?php echo $judul_print ?></b> </div>
                            </td>
                        </tr>
                        <tr>
                            <td align="center" valig="middle" colspan="3">
                                <h4>Data Kunjungan</h4>
                            </td>
                        </tr>
                        <tr>
                            <td>No. Masuk Penunjang</td>
                            <td>:</td>
                            <td><?php echo $modPasienMasukPenunjang->no_masukpenunjang; ?></td>
                        </tr>
                        <tr>
                            <td>No. Pendaftaran</td>
                            <td>:</td>
                            <td><?php echo $modPasienMasukPenunjang->no_pendaftaran; ?></td>
                        </tr>
                        <tr>
                            <td>Nama Pasien</td>
                            <td>:</td>
                            <td><?php echo $modPasienMasukPenunjang->nama_pasien; ?></td>
                        </tr>
                        <tr>
                            <td>No. Rekam Medik</td>
                            <td>:</td>
                            <td><?php echo $modPasienMasukPenunjang->no_rekam_medik; ?></td>
                        </tr>
                        <tr>
                            <td>Jenis Kelamin</td>
                            <td>:</td>
                            <td><?php echo $modPasienMasukPenunjang->jeniskelamin; ?></td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td>:</td>
                            <td><?php echo $modPasienMasukPenunjang->alamat_pasien; ?></td>
                        </tr>
                        <tr>
                            <td>Tanggal Lahir / Umur</td>
                            <td>:</td>
                            <td><?php echo $modPasienMasukPenunjang->tanggal_lahir; ?> / <?php echo $modPasienMasukPenunjang->umur; ?></td>
                        </tr>
                        <tr>
                            <td>Jenis Penjamin / Penjamin</td>
                            <td>:</td>
                            <td><?php echo $modPasienMasukPenunjang->carabayar_nama; ?> / <?php echo $modPasienMasukPenunjang->penjamin_nama; ?></td>
                        </tr>
                        <tr>
                            <td>Kelas Pelayanan</td>
                            <td>:</td>
                            <td><?php echo $modPasienMasukPenunjang->kelaspelayanan_nama; ?></td>
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
                                        <td><b>Harga</b></td>
                                        <td><b>Jumlah</b></td>
                                        <td><b>Sub Total</b></td>
                                    </thead>
                                    <?php
                                    $total = 0;
                                    $subtotal = 0;
                                    foreach ($modObatAlkesPasien as $i => $modOAPasien) {
                                    ?>
                                        <tr>
                                            <td><?php echo ($i + 1) . "."; ?></td>
                                            <td><?php echo $modOAPasien->obatalkes->obatalkes_nama; ?></td>
                                            <td><?php echo $format->formatUang($modOAPasien->hargasatuan_oa); ?></td>
                                            <td><?php echo $modOAPasien->qty_oa; ?></td>
                                            <td><?php
                                                $subtotal = ($modOAPasien->hargasatuan_oa * $modOAPasien->qty_oa);
                                                $total += $subtotal;
                                                echo $format->formatUang($subtotal); ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    <tr>
                                        <td colspan="4" align="center"><b>Total</b></td>
                                        <td><?php echo $format->formatUang($total); ?></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>

                    </table>
                    <div style="border: 0 solid;margin-top: 10px;text-align:center;width:200px;">
                        <img style="height: 64px;" src="index.php?r=barcode/myBarcode&code=<?php echo $modPasienMasukPenunjang->pendaftaran_id; ?>&is_text=">
                        <div class="barcode-label"><?php echo $modPasienMasukPenunjang->pendaftaran_id; ?></div>
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