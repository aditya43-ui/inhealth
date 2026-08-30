<table id="table-riwayat" class="table table-bordered table-condensed">
    <thead>
        <tr>
            <th>Tanggal Pemeriksaan</th>
            <th>Dokter Pemeriksa</th>
            <th>Hasil Pop smeer</th>
            <th>Mamma</th>
            <th>Detail</th>
            <th>Ubah</th>
            <th>Hapus</th>

        </tr>
    </thead>
    <tbody>
        <?php if(count((array)$modMcuPemeriksaanlainlainRiwayat) > 0 ) { 
          foreach ($modMcuPemeriksaanlainlainRiwayat as $data ) {
            $modPegawai = PegawaiM::model()->findByPk($data->dokterpemeriksa_id);
            ?>
        <tr>
            <td><?php echo $format->formatDateTimeForUser($data->tgl_pemeriksaan); ?></td>
            <td><?php echo $modPegawai->nama_pegawai; ?></td>
            <td><?php echo $data->hasil_pap_smeer; ?></td>
            <td><?php echo $data->pemeriksaan_mamma; ?></td>
            <td><?php echo CHtml::link("<i class='".MyIcon::getIcons('lihat2')."'>",Yii::app()->controller->createUrl('/'.Yii::app()->controller->module->id."/".Yii::app()->controller->id."/detail",array("id"=>$data->checkup_lainlain_id)),array('rel'=>'tooltip','title'=>'Klik untuk melihat detail'));            
                                ?> </td>
            <td><?php echo CHtml::link("<i class='".MyIcon::getIcons('ubah')."'>",Yii::app()->controller->createUrl('/'.Yii::app()->controller->module->id."/".Yii::app()->controller->id."/update",array("id"=>$data->checkup_lainlain_id)),array('rel'=>'tooltip','title'=>'Klik untuk update data'));            
                                ?></td>
            <td><?php echo CHtml::Link("<span style='font-size:12px'><i class='glyphicon glyphicon-trash'></i></span>", '', array("class" => "",
                                                    "style"=>"Z-index: 9999999",
                                                    "onclick" => "setdelete($data->checkup_lainlain_id);",
                                                    "rel" => "tooltip",
                                                    "title" => "Klik untuk hapus",
                                                )); ?></td>
        </tr>
        <?php
        }
        }
        ?>
    </tbody>
    
    
</table>