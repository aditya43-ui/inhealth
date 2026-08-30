<table class="table table-striped">
    <tr>
        <th>Tgl.Pendaftaran/No.Pendaftaran</th>
        <th>Tanggal</th>
        <th>Instalasi/Ruangan</th>
        <th>DPJP</th>
        <th>Diagnosa Gizi</th>
        <th>Detail Asesmen Gizi</th>
    </tr>
    <?php if(count($modGizi) > 0) : ?>
    <?php foreach($modGizi as $no=>$row) : ?>
    <tr>
        <td>
            <?= MyFormatter::formatDateTimeId($modPendaftaran->tgl_pendaftaran)."/".$modPendaftaran->no_pendaftaran ;?>
        </td>
        <td>
            <?= MyFormatter::formatDateTimeId($row->tgl_pemeriksaan); ?>
        </td>
        <td></td>
        <td>
            <?= !empty($row->perawat_id) ? PegawaiM::model()->findByPk($row->perawat_id)->nama_pegawai : ""; ?>
        </td>
        <td>
            <?= $row->diagnosa_medis; ?>
        </td>
        <td><center>
            <?php
                echo CHtml::Link("<i class='fa fa-file-text-o'></i>
",Yii::app()->createUrl("rawatInap/asesmenAwalGizi/index",array("id"=>$row->pendaftaran_id, 'detail'=>1, )),array("class"=>"", "target"=>"frameRincian","onclick"=>"$(\"#dialogDetail\").dialog(\"open\");","rel"=>"tooltip",));
             ?>
        </center></td>
    </tr>
    <?php endforeach; ?>
    <?php endif; ?>
</table>