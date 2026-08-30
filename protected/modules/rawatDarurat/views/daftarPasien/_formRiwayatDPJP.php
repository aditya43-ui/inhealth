<?php 

$this->widget('bootstrap.widgets.BootAlert'); 
?>
<div class="table-responsive">
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Riwayat DPJP / Alih Leader / Disposisi 
        </div>
    </div>
    <div class="pasnel-body table-riwayat" style="height: 250px; overflow: scroll; padding:10x">
        <table class="table table-condensed table-bordered">
            <thead>
                <th>Waktu Disposisi</th>
                <th>Petugas Disposisi</th>
                <th>DPJP ASAL</th>
                <th>DPJP Pengganti</th>
                <th>Spesialis</th>
                <th>Perubahan</th>
                <th>Keterangan</th>
                <th>Status</th>
                <th>Batal</th>
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
                                    echo $pegawai->namaLengkap ?? '';
                                ?>
                            </td>
                            <td><?= $row->dokterlama->namaLengkap ?? '' ?></td>
                            <td><?= $row->dokterbaru->namaLengkap ?? '' ?></td>
                            <td>
                                <?php 
                                    if(!empty($row->spesialis)) {
                                        echo $row->spesialis->jeniskasuspenyakit_nama ?? '';
                                    } else {
                                        echo isset($row->dokterbaru->spesialis_id) ? JeniskasuspenyakitM::model()->findByPk($row->dokterbaru->spesialis_id)->jeniskasuspenyakit_nama ?? ''  : '';
                                    }
                                ?>
                            </td>
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
                            <td>
                                <?php
                                    echo CHtml::link('<i class="icon-form-silang"></i>', "javascript:;", array("id" => $row->ubahdokter_id, "rel" => "tooltip", "title" => "Klik untuk membatalkan pemeriksaan", 'data-placement' => 'left', 'onclick' => "cekBatal('" .$row->ubahdokter_id . "','" .$row->is_approve . "', '" . $row->dokterlama_id. "', '" . Yii::app()->user->getState('pegawai_id'). "', '" . $row->pendaftaran_id . "')"));
                                    
                                ?>
                            </td>
                        </tr>
                    <?php endforeach ; ?>
                <?php } else { ?>
                    <tr>
                        <td colspan="9" style="text-align: center;">Tidak ditemukan riwayat</td>
                    </tr>
                    <?php } ?>
            </tbody>
        </table>
    </div>
</div>
             
<script>
    function cekBatal(ubahdokter_id, is_approve, dokterlama_id, pegawai_id_login, pendaftaran_id) {
        if(is_approve) {
            myAlert('Data tidak dapat dibatalkan karena sudah disetujui');
        } else if(dokterlama_id != pegawai_id_login){
            myAlert('Tidak dapat menghapus data [hak akses]');
        } else {
            $('.table-riwayat').addClass('animation-loading');
            myConfirm('Yakin Ingin Menghapus Data?', 'Perhatian !', function(r) {
                if(r) {
                    $.post('<?= $this->createUrl('batalDisposisi') ?>', {
                        ubahdokter_id:ubahdokter_id,
                        pendaftaran_id:pendaftaran_id
                    }, function(data) {
                        if(data.sukses == 1) {
                            myAlert('Data Berhasil Dihapus');
                            $('.table-riwayat table tbody').html(data.html);
                        } else {
                            myAlert('Data Gagal Dihapus');
                        }
                        $('.table-riwayat').removeClass('animation-loading');
                    }, 'json');
                } else {
                    $('.table-riwayat').removeClass('animation-loading');
                }
            });
           
        }
    }
</script>