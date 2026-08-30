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
                 <h4>Daftar Observasi Transfusi Darah</h4>
            </td>
        </tr>
        <tr>
            <td align="center" valig="middle" colspan="3">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Kantong Darah</th>
                            <th>Waktu Observasi</th>
                            <th>Reaksi Transfusi</th>
                            <th>Keluhan</th>
                            <th>Kesadaran</th>
                            <th>Tekanan Darah</th>
                            <th>Nadi</th>
                            <th>Suhu</th>
                            <th>Pernapasan</th>
                            <th>Lainnya</th>
                            <th>Petugas Observasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($model as $row) : ?>
                        <tr>
                            <td>
                                <?php
                                    $kantongdarah = KantongTransfusiDarahDetT::model()->find("kantong_transfusi_darah_det_id = ".$row->kantong_transfusi_darah_det_id);
                                    echo $kantongdarah->no_kantongdarah; 
                                ?>
                            </td>
                            <td><?= MyFormatter::formatDateTimeId($row->tanggal_observasi).' '.$row->jam_observasi ?></td>
                            <td>
                                <?php
                                    $reaksi = ReaksiTransfusiT::model()->findAll("observasi_transfusi_darah_id = ".$row->observasi_transfusi_darah_id);
                                    if(count($reaksi) > 0){
                                        $rks = "";
                                        foreach ($reaksi as $value){
                                            $rks .= $value->nama_reaksi_transfusi . "-";
                                        }

                                        echo $rks;
                                    }else{
                                        echo "";
                                    }
                                ?>
                            </td>
                            <td><?= $row->keluhan; ?></td>
                            <td><?= $row->kesadaran; ?></td>
                            <td><?= $row->tensi_sistolik .'/'. $row->tensi_diatolik ?></td>
                            <td><?= $row->nadi ?></td>
                            <td><?= $row->suhu; ?></td>
                            <td><?= $row->pernapasan ?></td>
                            <td><?= $row->lainnya ?></td>
                            <td><?= isset($row->petugas_observasi_id) ? $row->petugasObservasi->nama_pegawai : "" ?></td>
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