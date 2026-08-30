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
            <td align="center" valig="middle" colspan="3">
                 <h4>Daftar Informed To Consent</h4>
            </td>
        </tr>
        <tr>
            <td align="center" valig="middle" colspan="3">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Tgl. Informed To Consent</th>
                            <th>Keluhan</th>
                            <th>BB/TB</th>
                            <th>Nadi</th>
                            <th>Respirasi</th>
                            <th>Suhu</th>
                            <th>Lainnya</th>
                            <th>DPJP</th>
                            <th>Perawat 1</th>
                            <th>Perawat 2</th>
                            <th>Catatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(count($model) > 0) : ?>
                        <?php foreach($model as $row) : ?>
                        <tr>
                            <td><?= MyFormatter::formatDateTimeId($row->waktu); ?></td>
                            <td><?= $row->keluhan ?></td>
                            <td><?= $row->berat_badan.'/'.$row->tinggi_badan ?></td>
                            <td><?= $row->nadi ?> ( <?= ($row->nadi_reguler == true) ? 'Reguler' : ($row->nadi_irreguler == true) ? 'Irreguler' : '-' ?>) </td>
                            <td><?= $row->respirasi ?></td>
                            <td><?= $row->suhu ?></td>
                            <td><?= $row->lainnya ?></td>
                            <td><?= $row->dpjp->nama_pegawai ?></td>
                            <td><?= $row->perawat1->nama_pegawai ?></td>
                            <td><?= (!empty($row->perawat2_id2)) ? $row->perawat1->nama_pegawai : "" ?></td>
                            <td>
                                <?php
                                    if($row->catatan_dipulangkan == true){
                                        echo "dipulangkan";
                                    }elseif($row->catatan_igd == true){
                                        echo "IGD";
                                    }elseif($row->catatan_lainnya == true){
                                        echo $row->catatan_lainnya_keterangan;
                                    }else{
                                        echo "";
                                    }
                                ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    
                    </tbody>
                </table>


            </td>
        </tr>

    </table>
    <div style="border: 0px solid;margin-top: 10px;text-align:center;width:200px;">
        <img style="height: 64px;" src="index.php?r=barcode/myBarcode&code=<?php echo $modPendaftaran->pendaftaran_id; ?>&is_text=" >  
        <div class="barcode-label"><?php echo $modPendaftaran->pendaftaran_id; ?></div>
    </div>