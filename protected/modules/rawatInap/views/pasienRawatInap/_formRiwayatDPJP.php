<?php 

$this->widget('bootstrap.widgets.BootAlert'); 
?>
<div class="table-responsive">
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Riwayat Pengalihan DPJP
        </div>
    </div>
    <div class="pasnel-body" style="height: 250px; overflow: scroll; padding:10x">
        <table class="table table-condensed table-bordered">
            <thead>
                <th>Waktu Disposisi</th>
                <th>Petugas Disposisi</th>
                <th>DPJP ASAL</th>
                <th>DPJP Pengganti</th>
                <th>Perubahan</th>
                <th>Keterangan</th>
                <th>Status</th>
            </thead>
            <tbody>
                <?php if(count($modRiwayatUbahDokter) > 0) { ?>
                    <?php foreach ($modRiwayatUbahDokter as $ii => $row) : ?>
                        <tr>
                            <td><?php 
                                echo  MyFormatter::formatDateTimeForUser($row->tglubahdokter ?? "");
                            ?></td>
                            <td>
                                <?php  
                                    $pegawaiPemakai = LoginpemakaiK::model()->findByPk($row->create_loginpemakai_id);
                                    $pegawai = PegawaiM::model()->findByPk($pegawaiPemakai->pegawai_id);
                                    echo $pegawai->nama_pegawai ?? '';
                                ?>
                            </td>
                            <td><?= $row->dokterlama->nama_pegawai ?? '' ?></td>
                            <td><?= $row->dokterbaru->nama_pegawai ?? '' ?></td>
                            <td><?= $row->alasanperubahandokter ?></td>
                            <td><?= $row->keterangan ?? '' ?></td>
                            <td>
                                <?php 
                                    if($row->is_approve === false && $row->is_approve !== null) {
                                        echo 'Di Tolak';
                                    } else if($row->is_approve === true) {
                                        echo 'Di Terima';
                                    } else if($row->is_approve === null) {
                                        if($row->alasanperubahandokter == 'Disposisi' || $row->alasanperubahandokter == 'ALIH LEADER') {
                                            echo 'Belum Persetujuan';
                                        }
                                    }
                                ?>
                            </td>
                        </tr>
                    <?php endforeach ; ?>
                <?php } else { ?>
                    <tr>
                        <td colspan="5" style="text-align: center;">Tidak ditemukan riwayat</td>
                    </tr>
                    <?php } ?>
            </tbody>
        </table>
    </div>
</div>
             