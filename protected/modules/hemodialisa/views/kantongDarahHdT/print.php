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
            <td>DPJP</td>
            <td>:</td>
            <td><?= $model->pegawai->nama_pegawai ?></td>
        </tr>
        <tr>
            <td>Tanggal darah diterima</td>
            <td>:</td>
            <td><?= MyFormatter::formatDateTimeId($model->waktu_darah_diterima); ?></td>
        </tr>
        <tr>
            <td>Suhu Coolbox</td>
            <td>:</td>
            <td><?= (!empty($model->suhu_coolbox)) ? $model->suhu_coolbox : "" ?>&nbsp; &#8451;</td>
        </tr>
        <tr>
            <td align="center" valig="middle" colspan="3">
                 <h4>Detail Kantong Darah</h4>
            </td>
        </tr>
        <tr>
            <td align="center" valig="middle" colspan="3">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No. Kantong Darah</th>
                            <th>Jenis Darah</th>
                            <th>Volume Darah (ml)</th>
                            <th>Petugas Transfusi</th>
                            <th>Petugas Verifikasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($modDetail as $row) : ?>
                        <tr>
                            <td><?= $row->no_kantongdarah; ?></td>
                            <td><?= $row->jeniskomponendarah->jeniskomponenedarah_nama ?></td>
                            <td><?= $row->volume_darah; ?></td>
                            <td><?= $row->petugasTransfusi->nama_pegawai; ?></td>
                            <td><?= $row->petugasVerifikasi->nama_pegawai ?></td>
                        </tr>
                        <?php endforeach; ?>
                    
                    </tbody>
                </table>


            </td>
        </tr>

    </table>
    <div style="border: 0px solid;margin-top: 10px;text-align:center;width:200px;">
        <img style="height: 64px;" src="index.php?r=barcode/myBarcode&code=<?php echo $modPendaftaran->pendaftaran_id; ?>&is_text=" >  
        <div class="barcode-label"><?php echo $modPendaftaran->pendaftaran_id; ?></div>
    </div>