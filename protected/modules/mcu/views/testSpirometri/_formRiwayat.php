<table id="table-riwayat" class="table table-bordered table-condensed">
    <thead>
        <tr>
            <th>Tanggal Pemeriksaan</th>
            <th>Dokter Pemeriksa</th>
            <th>Pakai Bronkhodilator</th>
            <th>Hasil Spiromatri</th>
            <th>Tes Reversibilitas</th>
            <th>Detail</th>
            <th>Ubah</th>
            <th>Hapus</th>

        </tr>
    </thead>
    <tbody>
        <?php if(count((array)$modelRiwayat) > 0 ) { 
          foreach ($modelRiwayat as $data ) {
            
            $modPegawai = PegawaiM::model()->findByPk($data->pengetahui_id);
        ?>
        <tr>
            <td><?php echo $format->formatDateTimeForUser($data->spirometri_tgl); ?></td>
            <td><?php echo !empty($modPegawai->nama_pegawai) ? $modPegawai->nama_pegawai : '-'; ?></td>
            <td><?php echo $data->pakai_bronkhodilator; ?></td>
            <td><?php echo $data->test_spirometri; ?></td>
            <td><?php echo $data->test_reversibilitas_nilai; ?></td>
            <td>
                <?php 
                    echo CHtml::link("<i class='".MyIcon::getIcons('lihat2')."'>",Yii::app()->controller->createUrl('/'.Yii::app()->controller->module->id."/".Yii::app()->controller->id."/detail",array("id"=>$data->spirometri_id)),array('rel'=>'tooltip','title'=>'Klik untuk melihat detail')); 
                ?> 
            </td>
            <td>
                <?php 
                    echo CHtml::link("<i class='".MyIcon::getIcons('ubah')."'>",Yii::app()->controller->createUrl('/'.Yii::app()->controller->module->id."/".Yii::app()->controller->id."/update",array("id"=>$data->spirometri_id)),array('rel'=>'tooltip','title'=>'Klik untuk update data')); 
                ?>
            </td>
            <td>
                <?php 
                    echo CHtml::Link("<span style='font-size:12px'><i class='glyphicon glyphicon-trash'></i></span>", '', array("class" => "",
                        "style"=>"Z-index: 9999999",
                        "onclick" => "setdelete($data->spirometri_id);",
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
