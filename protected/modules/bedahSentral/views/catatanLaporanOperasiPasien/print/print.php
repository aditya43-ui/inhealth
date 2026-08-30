<style>
    
    .panel_print {
        width: 100%;
        border: 1px solid black;
        margin-bottom: 15px;
    }
    
    .panel_print_judul {
        padding: 5px;
        font-weight: bold;
        border-bottom: 1px solid black;
    }
    
    .panel_print_content {
        padding: 5px;
    }
    
    .row {
        margin-left: -5px;
        margin-right: -5px;
        clear: both;
    }
    
    .col-sm-6 {
        float: left;
        width: 50%;
        position: relative;
        min-height: 1px;
        padding-left: 5px;
        padding-right: 5px;
        box-sizing: border-box;
    }
    
    .tab_detail, .tab_list {
        width: 100%;
    }
    
    .tab_detail th, .tab_detail td {
        border: 1px solid black;
        padding: 3px;
        vertical-align: top;
    }
    
    .tab_list td {
        padding: 3px;
        vertical-align: top;
    }
    
</style>

<?php

echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array());

?>

<h3 style="text-align: center;">LAPORAN OPERASI</h3>

<div class="panel_print">
    <div class="panel_print_judul">Data Pasien</div>
    <div class="panel_print_content">
        <table class="tab_list">
            <tr>
                <td width="200">Nama Pasien</td>
                <td width="10">:</td>
                <td width="35%"><?php echo $penunjang->nama_pasien; ?></td>
                <td width="200">Jenis Kelamin</td>
                <td width="10">:</td>
                <td><?php echo $penunjang->jeniskelamin; ?></td>
            </tr>
            <tr>
                <td>No. Rekam Medik</td>
                <td>:</td>
                <td><?php echo $penunjang->no_rekam_medik; ?></td>
                <td>Tgl. Lahir</td>
                <td>:</td>
                <td><?php echo MyFormatter::formatDateTimeForUser($penunjang->tanggal_lahir); ?></td>
            </tr>
            <tr>
                <td>Tgl. Pendaftaran</td>
                <td>:</td>
                <td><?php echo MyFormatter::formatDateTimeForUser($penunjang->tgl_pendaftaran); ?></td>
                <td>Umur</td>
                <td>:</td>
                <td><?php echo $penunjang->umur; ?></td>
            </tr>
            <tr>
                <td>No. Pendaftaran</td>
                <td>:</td>
                <td><?php echo $penunjang->no_pendaftaran; ?></td>
                <td>Ruangan/Poliklinik Asal</td>
                <td>:</td>
                <td><?php echo $penunjang->ruanganasal_nama; ?></td>
            </tr>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <div class="panel_print">
            <div class="panel_print_judul">Data Tim Operasi</div>
            <div class="panel_print_content">
                <table class="tab_list">
                    <tr>
                        <td width="200">Nama Ahli Bedah</td>
                        <td width="10">:</td>
                        <td><?php echo (empty($rencana) || empty($rencana->dokter1)) ? "-" : ($rencana->dokter1->namaLengkap); ?></td>
                    </tr>
                    <tr>
                        <td>Nama Asisten Bedah</td>
                        <td>:</td>
                        <td><?php echo (empty($rencana) || empty($rencana->dokter2)) ? "-" : ($rencana->dokter2->namaLengkap); ?></td>
                    </tr>
                    <tr>
                        <td>Nama Perawat</td>
                        <td>:</td>
                        <td><?php echo (empty($rencana) || empty($rencana->perawatsirkuler)) ? "-" : ($rencana->perawatsirkuler->namaLengkap); ?></td>
                    </tr>
                    <tr>
                        <td>Nama Ahli Anestesi</td>
                        <td>:</td>
                        <td><?php echo (empty($anestesi) || empty($anestesi->dokteranastesi)) ? "-" : ($anestesi->dokteranastesi->namaLengkap); ?></td>
                    </tr>
                </table>
            </div>
        </div>
        
    </div>
    <div class="col-sm-6">
        <div class="panel_print">
            <div class="panel_print_judul">Waktu Operasi</div>
            <div class="panel_print_content">
                <table class="tab_list">
                    <tr>
                        <td width="200">Tanggal Operasi</td>
                        <td width="10">:</td>
                        <td><?php echo MyFormatter::formatDateTimeForUser($model->tanggal_operasi); ?></td>
                    </tr>
                    <tr>
                        <td>Jam Operasi Dimulai</td>
                        <td>:</td>
                        <td><?php echo $model->jam_mulaioperasi; ?></td>
                    </tr>
                    <tr>
                        <td>Jam Operasi Selesai</td>
                        <td>:</td>
                        <td><?php echo $model->jam_selesaioperasi; ?></td>
                    </tr>
                    <tr>
                        <td>Lamanya Operasi Berlangsung</td>
                        <td>:</td>
                        <td><?php echo $model->lamaoperasi; ?></td>
                    </tr>
                </table>
            </div>
        </div>
        
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <div class="panel_print">
            <div class="panel_print_judul">Diagnosa</div>
            <div class="panel_print_content">
                <table class="tab_list">
                    <tr>
                        <td width="200">Diagnosa Pre-Operatif</td>
                        <td width="10">:</td>
                        <td><?php echo (empty($diagnosa) ? "" : ($diagnosa->diagnosa->diagnosa_kode . " - " . $diagnosa->diagnosa->diagnosa_nama)); ?></td>
                    </tr>
                    <tr>
                        <td>Diagnosa Post-Operatif</td>
                        <td>:</td>
                        <td><?php 
                        $signout = OperasisignoutT::model()->findByAttributes(array(
                            'pasienmasukpenunjang_id' => $penunjang->pasienmasukpenunjang_id,
                        ));
                        echo empty($signout->signout_diagnosapostop) ? "" : ($signout->signout_diagnosapostop);
                        
                        ?></td>
                    </tr>
                </table>

            </div>
        </div>
        
    </div>
    <div class="col-sm-6">
        <div class="panel_print">
            <div class="panel_print_judul">Jenis Anestesi & Operasi</div>
            <div class="panel_print_content">
                <table class="tab_list">
                    <tr>
                        <td width="200">Jenis Anestesi</td>
                        <td width="10">:</td>
                        <td><?php echo (empty($anestesi) || empty($anestesi->jenisanastesi)) ? "" : ($anestesi->jenisanastesi->jenisanastesi_nama); ?></td>
                    </tr>
                    <tr>
                        <td>Jenis Operasi</td>
                        <td>:</td>
                        <td><?php echo (empty($rencana) || empty($rencana->operasi) || empty($rencana->operasi->kegiatanoperasi)) ? "" : ($rencana->operasi->kegiatanoperasi->kegiatanoperasi_nama); ?></td>
                    </tr>
                </table>
            </div>
        </div>
        
    </div>
</div>
<div class="panel_print">
    <div class="panel_print_judul">Jaringan Hasil Operasi</div>
    <div class="panel_print_content">
        <table class="tab_detail">
            <thead>
                <tr>
                    <th>Jenis Spesimen Jaringan</th>
                    <th>Diperoleh dengan Hasil</th>
                    <th>Lokasi Pengambilan</th>
                    <th>Volume</th>
                    <th>Dikirim untuk Pemeriksaan PA</th>
                    <th>Permintaan Pemeriksaan PA</th>
                </tr>
            </thead>
            <tbody id="tab_jaringan">
                <?php
                if (!$model->isNewRecord) {
                    $det = SpesimenhasiloperasiT::model()->findAllByAttributes(array(
                            'laporanoperasipasien_id'=>$model->laporanoperasipasien_id,
                    ));

                    foreach ($det as $idx => $item) {
                        $item->permintaanPeriksa = CHtml::listData(SpesimenhasiloperasidetT::model()->findAllByAttributes(array(
                            'spesimenhasiloperasi_id'=>$item->spesimenhasiloperasi_id,
                        )), 'pemeriksaanlab_id', 'pemeriksaanlab_id');

                        echo $this->renderPartial('_rowJaringan', array(
                            'mod'=>$item, 'idx'=>$idx, 'no_hapus'=>true,
                        ));

                    }
                }

                ?>
            </tbody>
        </table>
    </div>
</div>

<div class="panel_print">
    <div class="panel_print_judul">Laporan Operasi</div>
    <div class="panel_print_content">
        <?php echo $model->laporanoperasi; ?>
    </div>
</div>

<table style="width: 100%; border: none;">
    <tr>
        <td></td>
        <td width="200" style="text-align: center;">
            <?php echo empty($model->tanggalpengisian_laporanop) ? "-" : MyFormatter::formatDateTimeForUser(date('Y-m-d', strtotime($model->tanggalpengisian_laporanop))); ?>
            <br>
            Ahli Bedah
            <br>
            <br>
            <br>
            <br>
            <br>
            <?php echo empty($model->dokterbedahPengisilaporan) ? "-" : $model->dokterbedahPengisilaporan->namaLengkap; ?>
        </td>
    </tr>
</table>
        