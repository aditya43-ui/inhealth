<style>
    .barcode-label{
        margin-top:-20px;
        z-index: 1;
        text-align: center;
        letter-spacing: 10px;
    }
</style>

    <table>
        <tr>
            <td>
                <?php echo $this->renderPartial('application.views.headerReport.headerDefault'); ?>
            </td>
        </tr>
    </table>
    <table class="status">
        <tr>
            <td align="center" valig="middle" colspan="3">
                <b><?php echo $judul_print ?></b>
            </td>
        </tr>
        <tr>
            <td align="center" valig="middle" colspan="3">
                 <h4>Data Kunjungan</h4>
            </td>
        </tr>
        <tr>
            <td>No. Pendaftaran</td>
            <td>:</td>
            <td><?php echo $modPendaftaran->no_pendaftaran; ?></td>
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
            <td>Tanggal Lahir / Umur</td>
            <td>:</td>
            <td><?php echo $modPasien->tanggal_lahir; ?> / <?php echo $modPendaftaran->umur; ?></td>
        </tr>
        <tr>
            <td>Jenis Penjamin / Penjamin</td>
            <td>:</td>
            <td><?php echo isset($modPendaftaran->carabayar->carabayar_nama)?$modPendaftaran->carabayar->carabayar_nama:''; ?> / <?php echo isset($modPendaftaran->penjamin->penjamin_nama)?$modPendaftaran->penjamin->penjamin_nama:''; ?></td>
        </tr>
        <tr>
            <td>Kelas Pelayanan</td>
            <td>:</td>
            <td><?php echo isset($modPendaftaran->kelaspelayanan->kelaspelayanan_nama)?$modPendaftaran->kelaspelayanan->kelaspelayanan_nama:''; ?></td>
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
                                    <tr>
                                        <th>Tanggal Pemakaian</th>
                                        <th>Nama Obat Alkes</th>
                                        <th>Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($modViewBmhp as $i => $bmhp) { ?>
                                    <tr>
                                        <td >
                                            <?php echo $bmhp->tglpelayanan; ?>
                                        </td>
                                        <td>
                                            <?php echo $bmhp->obatalkes->obatalkes_nama; ?>
                                        </td>
                                        <td>
                                            <?php echo $bmhp->qty_oa; ?>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
            </td>
        </tr>

    </table>
    <div style="border: 0 solid;margin-top: 10px;text-align:center;width:200px;">
        <img style="height: 64px;" src="index.php?r=barcode/myBarcode&code=<?php echo $modPendaftaran->pendaftaran_id; ?>&is_text=">  
        <div class="barcode-label"><?php echo $modPendaftaran->pendaftaran_id; ?></div>
    </div>