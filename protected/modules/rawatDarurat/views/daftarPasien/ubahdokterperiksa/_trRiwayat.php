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
            <td>
                <?php
                    echo CHtml::link('<i class="icon-form-silang"></i>', "javascript:;", array("id" => $row->ubahdokter_id, "rel" => "tooltip", "title" => "Klik untuk membatalkan pemeriksaan", 'data-placement' => 'left', 'onclick' => "cekBatal('" .$row->ubahdokter_id . "','" .$row->is_approve . "', '" . $row->dokterlama_id. "', '" . Yii::app()->user->getState('pegawai_id'). "', '" . $row->pendaftaran_id . "')"));
                    
                ?>
            </td>
        </tr>
    <?php endforeach ; ?>
<?php } else { ?>
    <tr>
        <td colspan="5" style="text-align: center;">Tidak ditemukan riwayat</td>
    </tr>
<?php } ?>