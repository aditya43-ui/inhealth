<table class="table table-striped">
    <tr>
        <th>Tgl.Pendaftaran/No.Pendaftaran</th>
        <th>Tanggal dan Jam Monitoring</th>
        <th>DPJP</th>
        <th>Pegawai Input</th>
        <th>Penyulit Selama HD</th>
        <th>Detail Monitoring</th>
        <th>Detail SOAP</th>
    </tr>
    <?php if(count($modPenyulitHD) > 0) : ?>
    <?php foreach($modPenyulitHD as $no=>$row) : ?>
    <tr>
        <td>
            <?= MyFormatter::formatDateTimeId($modPendaftaran->tgl_pendaftaran)."/".$modPendaftaran->no_pendaftaran ;?>
        </td>
        <td>
            <?= MyFormatter::formatDateTimeId($row->tanggal) ." ".$row->jam_observasi; ?>
        </td>
        <td>
            <?= !empty($row->dpjp_id) ? PegawaiM::model()->findByPk($row->dpjp_id)->nama_pegawai : ""; ?>
        </td>
        <td>
            <?= !empty($row->creale_login) ? LoginpemakaiK::model()->findByPk($row->creale_login)->pegawai->namaLengkap : ""; ?>
        </td>
        <td>
            <?= !empty($row->penyulit_hd_id) ? PenyulitHdM::model()->findByPk($row->penyulit_hd_id)->penyulit_hd_nama : ""; ?>
        </td>
        <td><center>
            <?php
                echo CHtml::Link("<i class='fa fa-file-text-o'></i>
",Yii::app()->controller->createUrl("monitoringIntraTHD/index",array("pendaftaran_id"=>$row->pendaftaran_id, 'monitoringintraid'=>$row->monitoring_intra_hd_id, 'detail'=>1, )),array("class"=>"", "target"=>"frameRincian","onclick"=>"$(\"#dialogDetail\").dialog(\"open\");","rel"=>"tooltip",));
             ?>
        </center></td>
        <td>
            <center>
            <?php
                echo CHtml::Link("<i class='fa fa-file-text-o'></i>
",Yii::app()->controller->createUrl("perkembanganTerintegrasiPasienTHD/createIntegrasi",array("pendaftaran_id"=>$row->pendaftaran_id, 'pasienadmisi_id'=>'', 'pasienmasukpenunjang_id'=>'', 'perkembangan_terintegrasi_pasien_id'=>$row->perkembangan_terintegrasi_pasien_id, 'detail'=>1, )),array("class"=>"", "target"=>"frameRincian","onclick"=>"$(\"#dialogDetail\").dialog(\"open\");","rel"=>"tooltip",));
             ?>
        </center>
        </td>
    </tr>
    <?php endforeach; ?>
    <?php endif; ?>
</table>