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
            <td><?= !empty($model->dpjp->nama_pegawai)?$model->dpjp->nama_pegawai:'' ?></td>
        </tr>
        <tr>
            <td>Perawat 1</td>
            <td>:</td>
            <td><?= !empty($model->perawat1->nama_pegawai)?$model->perawat1->nama_pegawai:null ?></td>
        </tr>
        <tr>
            <td>Perawat 2</td>
            <td>:</td>
            <td><?= (!empty($model->perawat2_id)) ? $model->perawat2->nama_pegawai : "" ?></td>
        </tr>
        <tr>
            <td align="center" valig="middle" colspan="3">
                 <h4>Daftar Informed To Consent</h4>
            </td>
        </tr>
        <tr>
            <td align="center" valig="middle" colspan="3">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Jenis Observasi</th>
                            <th>Jam Observasi</th>
                            <th>Blood Flow</th>
                            <th>UF Rate</th>
                            <th>Tekanan Darah</th>
                            <th>Nadi</th>
                            <th>Suhu</th>
                            <th>Respirasi</th>
                            <th>Intake Nacl</th>
                            <th>Intake Lainnya</th>
                            <th>Output UF Goal</th>
                            <th>Output Lainnya</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($modDetail as $row) : ?>
                        <tr>
                            <td><?= $row->jenis_observasi; ?></td>
                            <td><?= $row->jam_observasi ?></td>
                            <td><?= $row->blood_flow; ?></td>
                            <td><?= $row->uf_rate; ?></td>
                            <td><?= $row->tensi_sistolik .'/'. $row->tensi_diastolik ?></td>
                            <td><?= $row->nadi ?></td>
                            <td><?= $row->suhu; ?></td>
                            <td><?= $row->respirasi ?></td>
                            <td><?= $row->intake_nacl_keterangan ?></td>
                            <td><?= $row->intake_lainnya_keterangan ?></td>
                            <td><?= $row->output_uf_goal_keterangan ?></td>
                            <td><?= $row->output_lainnya_keterangan ?></td>
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