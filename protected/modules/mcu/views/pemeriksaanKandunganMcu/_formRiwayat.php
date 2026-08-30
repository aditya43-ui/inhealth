<table id="table-riwayat" class="table table-bordered table-condensed">
    <thead>
        <tr>
            <th>Tanggal Pemeriksaan</th>
            <th>Dokter Pemeriksa</th>
            <th>Anamnesis</th>
            <th>Diagnosa</th>
            <th>Detail</th>
            <th>Ubah</th>
            <th>Hapus</th>

        </tr>
    </thead>
    <tbody>
        <?php if(count((array)$ModPemeriksaankandunganRiwayat) > 0 ) { 
          foreach ($ModPemeriksaankandunganRiwayat as $data ) {
            $modPegawai = DokterV::model()->findByAttributes(array('pegawai_id'=>$data->dokterpemeriksa_id));
            ?>
        <tr>
            <td><?php echo $format->formatDateTimeForUser($data->tgl_pemeriksaan); ?></td>
            <td><?php echo $modPegawai->namaLengkap; ?></td>
            <td><?php echo $data->anamnesis; ?></td>
            <td><?php echo $data->diagnosis; ?></td>
            <td><?php echo CHtml::link("<i class='".MyIcon::getIcons('lihat2')."'>",Yii::app()->controller->createUrl('/'.Yii::app()->controller->module->id."/".Yii::app()->controller->id."/detail",array("id"=>$data->checkup_kandungan_id)),array('rel'=>'tooltip','title'=>'Klik untuk melihat detail'));            
                                ?> </td>
            <td><?php echo CHtml::link("<i class='".MyIcon::getIcons('ubah')."'>",Yii::app()->controller->createUrl('/'.Yii::app()->controller->module->id."/".Yii::app()->controller->id."/update",array("id"=>$data->checkup_kandungan_id)),array('rel'=>'tooltip','title'=>'Klik untuk update data'));            
                                ?></td>
            <td><?php echo CHtml::Link("<span style='font-size:12px'><i class='glyphicon glyphicon-trash'></i></span>", '', array("class" => "",
                                                    "style"=>"Z-index: 9999999",
                                                    "onclick" => "setdelete($data->checkup_kandungan_id);",
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