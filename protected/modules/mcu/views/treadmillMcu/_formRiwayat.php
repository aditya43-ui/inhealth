<table id="table-riwayat" class="table table-bordered table-condensed">
    <thead>
        <tr>
            <th>Tanggal Pemeriksaan</th>
            <th>Pemeriksa</th>
            <th>Hasil Treadmil</th>
            <th>Detail</th>
            <th>Ubah</th>
            <th>Hapus</th>

        </tr>
    </thead>
    <tbody>
        <?php if(count((array)$modTreadmilRiwayat) > 0 ) { 
          foreach ($modTreadmilRiwayat as $data ) {
            
            $modPegawai = PegawaiM::model()->findByPk($data->pegawai_id);
        ?>
        <tr>
            <td><?php echo $format->formatDateTimeForUser($data->tgltreadmill); ?></td>
            <td><?php echo $data->namapemeriksa_treadmill; ?></td>
            <td><?php echo $data->hasiltreadmill; ?></td>
            <td>
                <?php 
                    echo CHtml::link("<i class='".MyIcon::getIcons('lihat2')."'></i>",Yii::app()->controller->createUrl('/'.Yii::app()->controller->module->id."/".Yii::app()->controller->id."/detail",array("id"=>$data->treadmill_id)),array('rel'=>'tooltip','title'=>'Klik untuk melihat detail')); 
                ?> 
            </td>
            <td><?php echo CHtml::link("<i class='".MyIcon::getIcons('ubah')."'>",Yii::app()->controller->createUrl('/'.Yii::app()->controller->module->id."/".Yii::app()->controller->id."/update",array("id"=>$data->treadmill_id)),array('rel'=>'tooltip','title'=>'Klik untuk update data'));            
                                ?></td>
            <td>
                <?php 
                    echo CHtml::Link("<span style='font-size:12px'><i class='glyphicon glyphicon-trash'></i></span>", '', array("class" => "",
                        "style"=>"Z-index: 9999999",
                        "onclick" => "setdelete($data->treadmill_id);",
                        "rel" => "tooltip",
                        "title" => "Klik untuk hapus",
                    )); 
                ?>
            </td>
        </tr>
        <?php
        }
        }
        ?>
    </tbody>
    
    
</table>
