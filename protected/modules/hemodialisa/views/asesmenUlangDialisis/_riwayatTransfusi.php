<table class="table table-striped">
    <tr>
        <th>Tgl.Pendaftaran/No.Pendaftaran</th>
        <th>Tanggal Transfusi</th>
        <th>DPJP</th>
        <th>Pegawai Input</th>
        <th>Detail Observasi Transfusi</th>
    </tr>
    <?php if (count($modTransfusi) > 0) : ?>
        <?php foreach ($modTransfusi as $no => $row) : ?>
            <tr>
                <td>
                    <?= MyFormatter::formatDateTimeId($modPendaftaran->tgl_pendaftaran) . "/" . $modPendaftaran->no_pendaftaran; ?>
                </td>
                <td>
                    <?= MyFormatter::formatDateTimeId($row->create_time); ?>
                </td>
                <td>
                    <?= !empty($row->pegawai_id) ? PegawaiM::model()->findByPk($row->pegawai_id)->nama_pegawai : ""; ?>
                </td>
                <td>
                    <?= !empty($row->create_loginpemakai_id) ? LoginpemakaiK::model()->findByPk($row->create_loginpemakai_id)->pegawai->namaLengkap : ""; ?>
                </td>
                <td><center>
                <?php
                $disabled = true;
                $observasi = ObservasiTransfusiDarahT::model()->findAll('kantong_transfusi_darah_det_id = ' . $row->kantong_transfusi_darah_det_id);
                if (count($observasi) > 0) {
                    $disabled = false;
                }
                    echo CHtml::Link("<i class='fa fa-file-text-o'></i>", 
                        Yii::app()->controller->createUrl("observasiTransfusiDarahTHD/detail", array("pendaftaran_id" => $row->pendaftaran_id, 'tranfusi_id' => $row->kantong_transfusi_darah_id, 'kantongdarahdetid' => $row->kantong_transfusi_darah_det_id)), array("class" => "", "target" => "frameRincian", "onclick" => "$(\"#dialogDetail\").dialog(\"open\");", "rel" => "tooltip", "disabled" => $disabled));
                ?>
            </center></td>
        </tr>
    <?php endforeach; ?>
<?php endif; ?>
</table>